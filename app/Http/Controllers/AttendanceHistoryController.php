<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AttendanceRecord;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
class AttendanceHistoryController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->input('filter', 'week'); // Default filter minggu
        $selectedYear = $request->input('year', ''); // Ambil tahun dari request, default kosong
        // Ambil data absensi dengan relasi user
        $query = AttendanceRecord::with('user');
        if ($selectedYear) {
            $query->whereYear('waktu_check_in', $selectedYear);
        }
        switch ($filter) {
            case 'month':
                $query->whereMonth('waktu_check_in', Carbon::now()->month)
                      ->whereYear('waktu_check_in', Carbon::now()->year);
                break;
            case 'year':
                $query->whereYear('waktu_check_in', Carbon::now()->year);
                break;
            default:
                $query->whereBetween('waktu_check_in', [
                    Carbon::now()->startOfWeek(), 
                    Carbon::now()->endOfWeek()
                ]);
                break;
        }
        // Ambil data absensi dan tentukan status waktu
        $attendances = $query->get()->map(function ($attendance) {
            $attendance->waktu_check_in = Carbon::parse($attendance->waktu_check_in);
            $attendance->status_waktu = $attendance->waktu_check_in->format('H:i') <= '07:30' ? 'Tepat Waktu' : 'Terlambat';
            return $attendance;
        });
        // Ambil daftar tahun
        $years = AttendanceRecord::selectRaw('YEAR(waktu_check_in) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');
        return view('user.attendance_history', compact('attendances', 'years', 'selectedYear'));
    }
}
