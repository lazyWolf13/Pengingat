<?php

namespace App\Http\Controllers;

use App\Models\AttendanceRecord;
use Illuminate\Http\Request;

class AttendanceRecordController extends Controller
{
    public function index()
    {
        $attendanceRecords = AttendanceRecord::with('user')->get();
        return view('attendance.index', compact('attendanceRecords'));
    }

    public function create()
    {
        return view('attendance.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'waktu_check_in' => 'nullable|date_format:H:i:s',
            'waktu_check_out' => 'nullable|date_format:H:i:s',
            'lokasi_absen' => 'nullable|string|max:255',
            'ketepatan_waktu' => 'nullable|in:tepat waktu,terlambat,lembur',
            'durasi_lembur' => 'nullable|date_format:H:i',
            'status' => 'required|in:hadir,izin,cuti,alpa',
        ]);

        AttendanceRecord::create($request->all());
        return redirect()->route('attendance.index')->with('success', 'Attendance record created successfully.');
    }
}
