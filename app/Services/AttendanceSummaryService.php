<?php

namespace App\Services;

use App\Models\AttendanceRecord;
use App\Models\AttendanceSummary;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AttendanceSummaryService
{
    public function syncAttendanceSummaries($bulan = null, $tahun = null)
    {
        // Jika bulan dan tahun tidak ditentukan, gunakan bulan dan tahun saat ini
        $bulan = $bulan ?? date('n');
        $tahun = $tahun ?? date('Y');

        // Ambil semua user
        $users = User::all();

        foreach ($users as $user) {
            // Ambil semua attendance records untuk user ini pada bulan dan tahun tertentu
            $records = AttendanceRecord::where('user_id', $user->id)
                ->whereMonth('tanggal', $bulan)
                ->whereYear('tanggal', $tahun)
                ->get();

            // Hitung total untuk setiap status
            $totalHadir = $records->where('status', 'hadir')->count();
            $totalTerlambat = $records->where('ketepatan_waktu', 'terlambat')->count();
            $totalIzin = $records->where('status', 'izin')->count();
            $totalCuti = $records->where('status', 'cuti')->count();

            // Hitung total lembur
            $totalLembur = $records->sum(function ($record) {
                return $record->durasi_lembur ? Carbon::parse($record->durasi_lembur)->diffInMinutes(Carbon::parse('00:00:00')) : 0;
            });

            // Format total lembur ke format time
            $totalLemburFormatted = Carbon::parse('00:00:00')->addMinutes($totalLembur)->format('H:i:s');

            // Ambil record terakhir untuk attendance_record_id
            $latestRecord = $records->sortByDesc('tanggal')->first();

            // Update atau create summary
            AttendanceSummary::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'bulan' => $bulan,
                    'tahun' => $tahun,
                ],
                [
                    'attendance_record_id' => $latestRecord ? $latestRecord->id : null,
                    'total_hadir' => $totalHadir,
                    'total_terlambat' => $totalTerlambat,
                    'total_lembur' => $totalLemburFormatted,
                    'total_izin' => $totalIzin,
                    'total_cuti' => $totalCuti,
                    'admin_id' => auth()->id(),
                    'managed_at' => now(),
                ]
            );
        }
    }

    public function syncSingleUserSummary($userId, $bulan = null, $tahun = null)
    {
        $bulan = $bulan ?? date('n');
        $tahun = $tahun ?? date('Y');

        $records = AttendanceRecord::where('user_id', $userId)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->get();

        $totalHadir = $records->where('status', 'hadir')->count();
        $totalTerlambat = $records->where('ketepatan_waktu', 'terlambat')->count();
        $totalIzin = $records->where('status', 'izin')->count();
        $totalCuti = $records->where('status', 'cuti')->count();

        $totalLembur = $records->sum(function ($record) {
            return $record->durasi_lembur ? Carbon::parse($record->durasi_lembur)->diffInMinutes(Carbon::parse('00:00:00')) : 0;
        });

        $totalLemburFormatted = Carbon::parse('00:00:00')->addMinutes($totalLembur)->format('H:i:s');
        $latestRecord = $records->sortByDesc('tanggal')->first();

        return AttendanceSummary::updateOrCreate(
            [
                'user_id' => $userId,
                'bulan' => $bulan,
                'tahun' => $tahun,
            ],
            [
                'attendance_record_id' => $latestRecord ? $latestRecord->id : null,
                'total_hadir' => $totalHadir,
                'total_terlambat' => $totalTerlambat,
                'total_lembur' => $totalLemburFormatted,
                'total_izin' => $totalIzin,
                'total_cuti' => $totalCuti,
                'admin_id' => auth()->id(),
                'managed_at' => now(),
            ]
        );
    }
}