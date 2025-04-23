<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AttendanceRecord;
use App\Models\AttendanceSummary;
use App\Models\User;
use App\Services\AttendanceSummaryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceSummaryController extends Controller
{
    protected $attendanceSummaryService;

    public function __construct(AttendanceSummaryService $attendanceSummaryService)
    {
        $this->attendanceSummaryService = $attendanceSummaryService;
    }

    public function index()
    {
        $summaries = AttendanceSummary::with(['user', 'admin'])
            ->latest()
            ->paginate(10);

        $totalKaryawan = User::count();
        $totalHadir = AttendanceSummary::sum('total_hadir');
        $totalTerlambat = AttendanceSummary::sum('total_terlambat');
        $totalCuti = AttendanceSummary::sum('total_cuti');

        return view('admin.summaries', compact('summaries', 'totalKaryawan', 'totalHadir', 'totalTerlambat', 'totalCuti'));
    }

    public function show()
    {
        return $this->generateForm();
    }

    public function generateForm()
    {
        return view('admin.summariesgenerate');
    }

    public function generate(Request $request)
    {
        $request->validate([
            'bulan' => 'required|integer|between:1,12',
            'tahun' => 'required|integer|min:2000|max:' . (date('Y') + 1)
        ]);

        $bulan = $request->bulan;
        $tahun = $request->tahun;

        // Cek apakah sudah ada ringkasan untuk bulan dan tahun tersebut
        $existingSummary = AttendanceSummary::where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->exists();

        if ($existingSummary) {
            return response()->json([
                'success' => false,
                'message' => 'Ringkasan absensi untuk bulan dan tahun tersebut sudah ada.'
            ]);
        }

        try {
            DB::beginTransaction();

            $users = User::all();
            foreach ($users as $user) {
                $records = AttendanceRecord::where('user_id', $user->id)
                    ->whereMonth('tanggal', $bulan)
                    ->whereYear('tanggal', $tahun)
                    ->get();

                if ($records->isNotEmpty()) {
                    AttendanceSummary::create([
                        'user_id' => $user->id,
                        'attendance_record_id' => $records->first()->id,
                        'bulan' => $bulan,
                        'tahun' => $tahun,
                        'total_hadir' => $records->where('status', 'hadir')->count(),
                        'total_terlambat' => $records->where('ketepatan_waktu', 'terlambat')->count(),
                        'total_lembur' => $records->sum('durasi_lembur'),
                        'total_izin' => $records->where('status', 'izin')->count(),
                        'total_cuti' => $records->where('status', 'cuti')->count(),
                        'admin_id' => auth()->id(),
                        'managed_at' => now(),
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Ringkasan absensi berhasil dibuat.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat membuat ringkasan absensi: ' . $e->getMessage()
            ]);
        }
    }

    public function showGenerate()
    {
        $totalKaryawan = User::count();
        return view('admin.summariesgenerate', compact('totalKaryawan'));
    }

    public function countByDepartment($department)
    {
        $count = User::where('department', $department)->count();
        return response()->json(['count' => $count]);
    }
}
