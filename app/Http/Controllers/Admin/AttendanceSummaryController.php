<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AttendanceSummary;
use Illuminate\Http\Request;

class AttendanceSummaryController extends Controller
{
    public function index()
    {
        $attendanceSummaries = AttendanceSummary::with('user')->get();
        return view('admin.summaries', compact('attendanceSummaries'));
    }

    public function create()
    {
        \Log::info('Create method called');
        return view('admin.summariescreate');
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'bulan' => 'required|integer',
            'tahun' => 'required|integer',
            'total_hadir' => 'required|integer',
            'total_terlambat' => 'required|integer',
            'total_lembur' => 'nullable|date_format:H:i',
            'total_izin' => 'required|integer',
            'total_cuti' => 'required|integer',
            'admin_id' => 'nullable|exists:admin_users,id',
        ]);

        AttendanceSummary::create($request->all());
        return redirect()->route('attendance.summaries.index')->with('success', 'Attendance summary created successfully.');
    }

    public function edit(AttendanceSummary $attendanceSummary)
    {
        return view('admin.summariesedit', compact('attendanceSummary'));
    }

    public function update(Request $request, AttendanceSummary $attendanceSummary)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'bulan' => 'required|integer',
            'tahun' => 'required|integer',
            'total_hadir' => 'required|integer',
            'total_terlambat' => 'required|integer',
            'total_lembur' => 'nullable|date_format:H:i',
            'total_izin' => 'required|integer',
            'total_cuti' => 'required|integer',
            'admin_id' => 'nullable|exists:admin_users,id',
        ]);

        $attendanceSummary->update($request->all());
        return redirect()->route('attendance.summaries.index')->with('success', 'Attendance summary updated successfully.');
    }

    public function destroy(AttendanceSummary $attendanceSummary)
    {
        $attendanceSummary->delete();
        return redirect()->route('attendance.summaries.index')->with('success', 'Attendance summary deleted successfully.');
    }
}
