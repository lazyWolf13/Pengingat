<?php

namespace App\Http\Controllers;

use App\Models\AttendanceRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

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
            'status' => 'required|in:Hadir,Izin,Cuti', // Hapus Sakit dari validasi
            'local_time' => 'required|date_format:Y-m-d H:i:s',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        // Koordinat lokasi absensi (misalnya sekolah)
        $lokasiValid = ['lat' => -6.6027276535294, 'lng' => 106.79819226264955];
        $batasRadius = 300; // meter

        // Hitung jarak antara lokasi user dan titik absen
        $distance = $this->calculateDistance(
            $request->latitude,
            $request->longitude,
            $lokasiValid['lat'],
            $lokasiValid['lng']
        );

        if ($distance > $batasRadius) {
            return back()->with('error', 'Kamu berada di luar jangkauan lokasi absen.');
        }

        // Hitung apakah waktu check-in terlambat atau tepat waktu
        $waktuCheckIn = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $request->local_time);
        $batasTepatWaktu = now()->setTime(8, 0, 0); // Jam 08:00 server time

        // Semua status akan dicek ketepatan waktunya
        $ketepatan = $waktuCheckIn->gt($batasTepatWaktu) ? 'terlambat' : 'tepat waktu';

        $data = [
            'user_id' => auth()->id(),
            'name' => auth()->user()->full_name,
            'tanggal' => now()->toDateString(),
            'waktu_check_in' => $request->local_time,
            'status' => $request->status,
            'ketepatan_waktu' => $ketepatan,
            'lokasi_absen' => $request->latitude . ',' . $request->longitude, // Tambahkan ini
        ];

        AttendanceRecord::create($data);

        return redirect()->route('user.attendance')->with('success', 'Absen masuk berhasil!');
    }

    // Fungsi menghitung jarak antar titik (haversine formula)
    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $R = 6371000; // Radius bumi dalam meter
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return $R * $c;
    }

    public function absenPulang(Request $request)
{
    $user = Auth::user();

    $attendance = AttendanceRecord::where('user_id', $user->id)
                            ->whereDate('created_at', Carbon::now()->toDateString())
                            ->first();

    if ($attendance && $attendance->status == 'hadir' && !$attendance->waktu_check_out) {
        if ($request->filled('local_check_out')) {
            $waktuPulang = Carbon::parse($request->input('local_check_out'))->setTimezone('Asia/Jakarta');
            $attendance->waktu_check_out = $waktuPulang;

            // Batas mulai hitung lembur: 16:30:00
            $batasLembur = Carbon::today()->setTime(16, 0, 0);

            // Jika pulang setelah 16:30
            if ($waktuPulang->gt($batasLembur)) {
                $durasiLembur = $waktuPulang->diff($batasLembur);
                $attendance->durasi_lembur = $durasiLembur->format('%H:%I:%S');
            } else {
                $attendance->durasi_lembur = '00:00:00';
            }
        }

        $attendance->save();
    }

    return redirect()->back()->with('success', 'Absen pulang berhasil.');
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