<?php

namespace App\Http\Controllers;

use App\Models\AttendanceRecord;
use Illuminate\Http\Request;
class AttendanceRecordController extends Controller
{
    /**
     * Menampilkan daftar absensi.
     */
    public function index()
    {
        $attendance = AttendanceRecord::where('user_id', auth()->id())
                        ->whereDate('tanggal', now()->toDateString())
                        ->first();
        return view('user.attendance', compact('attendance'));
    }
    public function absenMasuk(Request $request)
    {
        $request->validate([
            'status' => 'required|in:Hadir,Sakit,Izin',
            'file_surat' => 'required_if:status,Sakit,Izin|file|mimes:jpg,jpeg,png,pdf',
            'keterangan' => 'required_if:status,Sakit,Izin',
            'local_time' => 'required|date_format:Y-m-d H:i:s', // Pastikan format waktu benar
        ]);
        $data = [
            'user_id' => auth()->id(),
            'name' => auth()->user()->full_name,
            'tanggal' => now()->toDateString(), // Tetap gunakan tanggal dari server untuk keseragaman
            'waktu_check_in' => $request->local_time, // Gunakan waktu dari user
            'status' => $request->status,
        ];
        if ($request->hasFile('file_surat')) {
            $data['file_surat'] = $request->file('file_surat')->store('surat_absensi');
        }
        AttendanceRecord::create($data);
        return redirect()->route('user.attendance')->with('success', 'Absen masuk berhasil!');
    }

    public function absenPulang()
    {
        $attendance = AttendanceRecord::where('user_id', auth()->id())
                        ->whereDate('tanggal', now()->toDateString())
                        ->first();
        if ($attendance && $attendance->status === 'Hadir' && now()->format('H') >= 16) {
            $attendance->update(['waktu_check_out' => now()->toTimeString()]);
            return redirect()->route('user.attendance')->with('success', 'Absen pulang berhasil!');
        }
        return back()->with('error', 'Tidak memenuhi syarat untuk absen pulang.');
    }
    public function history(Request $request)
    {
        $query = AttendanceRecord::query();
        if ($request->filter == 'weekly') {
            $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
        } elseif ($request->filter == 'monthly') {
            $query->whereMonth('created_at', now()->month);
        } elseif ($request->filter == 'yearly') {
            $query->whereYear('created_at', now()->year);
        }
        $records = $query->get();
        return view('attendance_history', compact('records'));
    }
}

