<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveRequestController extends Controller
{
    public function index()
    {
        $leaveRequests = LeaveRequest::with(['user', 'admin'])->orderBy('created_at', 'desc')->get();
        return view('admin.leavereq', compact('leaveRequests'));
    }

    public function show(LeaveRequest $leaveRequest)
    {
        return view('admin.leavereqshow', compact('leaveRequest'));
    }

    public function approve(Request $request, LeaveRequest $leaveRequest)
    {
        $request->validate([
            'status' => 'required|in:disetujui,ditolak',
            'keterangan' => 'nullable|string',
        ]);

        $leaveRequest->update([
            'status' => $request->status,
            'admin_id' => Auth::id(),
            'approved_at' => now(),
            'approved_by' => Auth::user()->full_name,
        ]);

        $status = $request->status == 'disetujui' ? 'disetujui' : 'ditolak';
        return redirect()->route('admin.leavereq.index')
                        ->with('success', "Permohonan {$status} berhasil.");
    }

    public function destroy(LeaveRequest $leaveRequest)
    {
        $leaveRequest->delete();
        return redirect()->route('admin.leavereq.index')
                        ->with('success', 'Permohonan berhasil dihapus.');
    }
} 