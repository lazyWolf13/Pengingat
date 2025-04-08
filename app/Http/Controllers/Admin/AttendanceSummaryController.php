<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AttendanceSummary;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceSummaryController extends Controller
{
    public function index()
    {
        $totalKaryawan = User::count();
        $currentMonth = date('n');
        $currentYear = date('Y');
        
        $totalHadir = DB::table('attendance_records')
            ->whereMonth('tanggal', $currentMonth)
            ->whereYear('tanggal', $currentYear)
            ->where('status', 'hadir')
            ->count();
        
        $totalTerlambat = DB::table('attendance_records')
            ->whereMonth('tanggal', $currentMonth)
            ->whereYear('tanggal', $currentYear)
            ->where('status', 'terlambat')
            ->count();
        
        $totalCuti = DB::table('attendance_records')
            ->whereMonth('tanggal', $currentMonth)
            ->whereYear('tanggal', $currentYear)
            ->where('status', 'cuti')
            ->count();

        $summaries = AttendanceSummary::with(['user', 'admin'])
            ->latest()
            ->paginate(10);

        return view('admin.summaries', compact(
            'summaries',
            'totalKaryawan',
            'totalHadir',
            'totalTerlambat',
            'totalCuti'
        ));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'bulan' => 'required|integer|between:1,12',
            'tahun' => 'required|integer|min:2000'
        ]);

        try {
            DB::transaction(function () use ($request) {
                $users = User::all();
                foreach ($users as $user) {
                    AttendanceSummary::updateOrCreate(
                        [
                            'user_id' => $user->id,
                            'bulan' => $request->bulan,
                            'tahun' => $request->tahun,
                        ],
                        [
                            'total_hadir' => $this->countAttendance($user->id, $request->bulan, $request->tahun, 'hadir'),
                            'total_terlambat' => $this->countAttendance($user->id, $request->bulan, $request->tahun, 'terlambat'),
                            'total_izin' => $this->countAttendance($user->id, $request->bulan, $request->tahun, 'izin'),
                            'total_cuti' => $this->countAttendance($user->id, $request->bulan, $request->tahun, 'cuti'),
                            'total_lembur' => $this->calculateOvertime($user->id, $request->bulan, $request->tahun),
                            'admin_id' => auth()->id(),
                            'managed_at' => now(),
                        ]
                    );
                }
            });

            // Ambil data terbaru untuk ditampilkan
            $summaries = AttendanceSummary::with(['user', 'admin'])
                ->where('bulan', $request->bulan)
                ->where('tahun', $request->tahun)
                ->latest()
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Ringkasan absensi berhasil digenerate',
                'summaries' => $summaries
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    private function countAttendance($userId, $bulan, $tahun, $status)
    {
        return DB::table('attendance_records')
            ->where('user_id', $userId)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->where('status', $status)
            ->count();
    }

    private function calculateOvertime($userId, $bulan, $tahun)
    {
        return DB::table('attendance_records')
            ->where('user_id', $userId)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->where('status', 'lembur')
            ->count();
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
