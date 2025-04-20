<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AttendanceRecord;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\ValidationException;

/**
 * Class AttendanceRecordsController
 * @package App\Http\Controllers\Admin
 */
class AttendanceRecordsController extends Controller
{
    /**
     * Display a listing of attendance records with optional filtering.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = AttendanceRecord::with('user')->latest('tanggal');

        // Apply filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function (Builder $q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('lokasi_absen', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->where('tanggal', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('tanggal', '<=', $request->date_to);
        }

        $records = $query->paginate(10)->withQueryString();

        // Get total counts for each status
        $totalHadir = AttendanceRecord::where('status', 'hadir')->count();
        $totalTerlambat = AttendanceRecord::where('status', 'hadir')
            ->whereTime('waktu_check_in', '>', '07:30:00')
            ->count();
        $totalIzin = AttendanceRecord::where('status', 'izin')->count();
        $totalCuti = AttendanceRecord::where('status', 'cuti')->count();

        return view('admin.attendance', [
            'records' => $records,
            'totalHadir' => $totalHadir,
            'totalTerlambat' => $totalTerlambat,
            'totalIzin' => $totalIzin,
            'totalCuti' => $totalCuti,
            'filters' => $request->only(['search', 'status', 'date_from', 'date_to'])
        ]);
    }

    /**
     * Show the form for creating a new attendance record.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $users = User::orderBy('full_name')->get();
        return view('admin.attendance.create', compact('users'));
    }

    /**
     * Store a newly created attendance record.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'tanggal' => 'required|date',
                'waktu_check_in' => 'required|date_format:H:i',
                'waktu_check_out' => 'nullable|date_format:H:i|after:waktu_check_in',
                'status' => 'required|in:hadir,izin,cuti,alpa',
                'lokasi_absen' => 'nullable|string|max:255',
            ], [
                'user_id.required' => 'Silakan pilih karyawan',
                'user_id.exists' => 'Karyawan tidak ditemukan',
                'tanggal.required' => 'Tanggal wajib diisi',
                'tanggal.date' => 'Format tanggal tidak valid',
                'waktu_check_in.required' => 'Waktu check-in wajib diisi',
                'waktu_check_in.date_format' => 'Format waktu check-in tidak valid',
                'waktu_check_out.date_format' => 'Format waktu check-out tidak valid',
                'waktu_check_out.after' => 'Waktu check-out harus setelah waktu check-in',
                'status.required' => 'Status kehadiran wajib diisi',
                'status.in' => 'Status kehadiran tidak valid',
                'lokasi_absen.max' => 'Lokasi absen maksimal 255 karakter',
            ]);

            DB::beginTransaction();

            $user = User::findOrFail($validated['user_id']);
            
            // Combine date and time for check-in
            $checkInDateTime = Carbon::parse($validated['tanggal'] . ' ' . $validated['waktu_check_in']);
            
            // Determine ketepatan_waktu based on check-in time
            $ketepatanWaktu = $checkInDateTime->format('H:i') > '07:30' ? 'terlambat' : 'tepat waktu';

            // Calculate durasi_lembur if check-out time is provided
            $durasiLembur = null;
            $checkOutDateTime = null;
            if (!empty($validated['waktu_check_out'])) {
                $checkOutDateTime = Carbon::parse($validated['tanggal'] . ' ' . $validated['waktu_check_out']);
                if ($checkOutDateTime->format('H:i') > '17:00') {
                    $durasiLembur = $checkOutDateTime->diff(Carbon::parse($validated['tanggal'] . ' 17:00'))->format('%H:%I:00');
                    $ketepatanWaktu = 'lembur';
                }
            }

            AttendanceRecord::create([
                'user_id' => $validated['user_id'],
                'name' => $user->full_name,
                'tanggal' => $validated['tanggal'],
                'waktu_check_in' => $checkInDateTime,
                'waktu_check_out' => $checkOutDateTime,
                'lokasi_absen' => $validated['lokasi_absen'],
                'ketepatan_waktu' => $ketepatanWaktu,
                'durasi_lembur' => $durasiLembur,
                'status' => $validated['status'],
            ]);

            DB::commit();

            return redirect()
                ->route('admin.attendance.index')
                ->with('success', 'Data absensi berhasil ditambahkan');

        } catch (ValidationException $e) {
            return back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->with('error', 'Terjadi kesalahan saat menyimpan data absensi')
                ->withInput();
        }
    }

    /**
     * Show the form for editing the specified attendance record.
     *
     * @param AttendanceRecord $record
     * @return \Illuminate\View\View
     */
    public function edit(AttendanceRecord $record)
    {
        $users = User::orderBy('full_name')->get();
        return view('admin.attendance.edit', compact('record', 'users'));
    }

    /**
     * Update the specified attendance record.
     *
     * @param Request $request
     * @param AttendanceRecord $record
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, AttendanceRecord $record)
    {
        try {
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'tanggal' => 'required|date',
                'waktu_check_in' => 'required|date_format:H:i',
                'waktu_check_out' => 'nullable|date_format:H:i|after:waktu_check_in',
                'status' => 'required|in:hadir,izin,cuti,alpa',
                'lokasi_absen' => 'nullable|string|max:255',
            ], [
                'user_id.required' => 'Silakan pilih karyawan',
                'user_id.exists' => 'Karyawan tidak ditemukan',
                'tanggal.required' => 'Tanggal wajib diisi',
                'tanggal.date' => 'Format tanggal tidak valid',
                'waktu_check_in.required' => 'Waktu check-in wajib diisi',
                'waktu_check_in.date_format' => 'Format waktu check-in tidak valid',
                'waktu_check_out.date_format' => 'Format waktu check-out tidak valid',
                'waktu_check_out.after' => 'Waktu check-out harus setelah waktu check-in',
                'status.required' => 'Status kehadiran wajib diisi',
                'status.in' => 'Status kehadiran tidak valid',
                'lokasi_absen.max' => 'Lokasi absen maksimal 255 karakter',
            ]);

            DB::beginTransaction();

            $user = User::findOrFail($validated['user_id']);
            
            // Combine date and time for check-in
            $checkInDateTime = Carbon::parse($validated['tanggal'] . ' ' . $validated['waktu_check_in']);
            
            // Determine ketepatan_waktu based on check-in time
            $ketepatanWaktu = $checkInDateTime->format('H:i') > '07:30' ? 'terlambat' : 'tepat waktu';

            // Calculate durasi_lembur if check-out time is provided
            $durasiLembur = null;
            $checkOutDateTime = null;
            if (!empty($validated['waktu_check_out'])) {
                $checkOutDateTime = Carbon::parse($validated['tanggal'] . ' ' . $validated['waktu_check_out']);
                if ($checkOutDateTime->format('H:i') > '17:00') {
                    $durasiLembur = $checkOutDateTime->diff(Carbon::parse($validated['tanggal'] . ' 17:00'))->format('%H:%I:00');
                    $ketepatanWaktu = 'lembur';
                }
            }

            $record->update([
                'user_id' => $validated['user_id'],
                'name' => $user->full_name,
                'tanggal' => $validated['tanggal'],
                'waktu_check_in' => $checkInDateTime,
                'waktu_check_out' => $checkOutDateTime,
                'lokasi_absen' => $validated['lokasi_absen'],
                'ketepatan_waktu' => $ketepatanWaktu,
                'durasi_lembur' => $durasiLembur,
                'status' => $validated['status'],
            ]);

            DB::commit();

            return redirect()
                ->route('admin.attendance.index')
                ->with('success', 'Data absensi berhasil diperbarui');

        } catch (ValidationException $e) {
            return back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->with('error', 'Terjadi kesalahan saat memperbarui data absensi')
                ->withInput();
        }
    }

    /**
     * Display the specified attendance record.
     *
     * @param AttendanceRecord $record
     * @return \Illuminate\View\View
     */
    public function show(AttendanceRecord $record)
    {
        $record->load('user');
        return view('admin.attendanceshow', compact('record'));
    }

    /**
     * Soft delete the specified attendance record.
     *
     * @param AttendanceRecord $record
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(AttendanceRecord $record)
    {
        try {
            $record->delete();
            return redirect()
                ->route('admin.attendance.index')
                ->with('success', 'Data absensi berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat menghapus data absensi');
        }
    }

    /**
     * Display a listing of soft deleted attendance records.
     *
     * @return \Illuminate\View\View
     */
    public function trash()
    {
        $records = AttendanceRecord::onlyTrashed()
            ->with('user')
            ->latest('tanggal')
            ->paginate(10);

        return view('admin.attendance.trash', compact('records'));
    }

    /**
     * Restore a soft deleted attendance record.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($id)
    {
        try {
            $record = AttendanceRecord::onlyTrashed()->findOrFail($id);
            $record->restore();

            return redirect()
                ->route('admin.attendance.trash')
                ->with('success', 'Data absensi berhasil dipulihkan');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat memulihkan data absensi');
        }
    }

    /**
     * Permanently delete a soft deleted attendance record.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forceDelete($id)
    {
        try {
            $record = AttendanceRecord::onlyTrashed()->findOrFail($id);
            $record->forceDelete();

            return redirect()
                ->route('admin.attendance.trash')
                ->with('success', 'Data absensi berhasil dihapus permanen');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat menghapus permanen data absensi');
        }
    }
} 