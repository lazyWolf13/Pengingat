<?php

namespace App\Http\Controllers;

use App\Models\AdminUser;
use App\Models\AttendanceRecord;
use App\Models\AttendanceSummary;
use App\Models\Foto;
use App\Models\Job;
use App\Models\LeaveRequest;
use App\Models\Login;
use App\Models\Profile;
use App\Models\Reminder;
use App\Models\Session;
use App\Models\Task;
use App\Models\TaskAssignment;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalAdminUsers = AdminUser::count();
        $totalAttendanceRecords = AttendanceRecord::count();
        $totalAttendanceSummaries = AttendanceSummary::count();
        $totalFotos = Foto::count();
        $totalJobs = Job::count();
        $totalLeaveRequests = LeaveRequest::count();
        $totalLogins = Login::count();
        $totalProfiles = Profile::count();
        $totalReminders = Reminder::count();
        $totalSessions = Session::count();
        $totalTasks = Task::count();
        $totalTaskAssignments = TaskAssignment::count();
        $totalUsers = User::count();

        return view('admin.dashboard', compact(
            'totalAdminUsers', 'totalAttendanceRecords', 'totalAttendanceSummaries', 
            'totalFotos', 'totalJobs', 'totalLeaveRequests', 'totalLogins', 
            'totalProfiles', 'totalReminders', 'totalSessions', 'totalTasks', 
            'totalTaskAssignments', 'totalUsers'
        ));
    }
} 