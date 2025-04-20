<?php

namespace App\Observers;

use App\Models\AttendanceRecord;
use App\Services\AttendanceSummaryService;

class AttendanceRecordObserver
{
    protected $attendanceSummaryService;

    public function __construct(AttendanceSummaryService $attendanceSummaryService)
    {
        $this->attendanceSummaryService = $attendanceSummaryService;
    }

    public function created(AttendanceRecord $attendanceRecord)
    {
        $this->syncSummary($attendanceRecord);
    }

    public function updated(AttendanceRecord $attendanceRecord)
    {
        $this->syncSummary($attendanceRecord);
    }

    public function deleted(AttendanceRecord $attendanceRecord)
    {
        $this->syncSummary($attendanceRecord);
    }

    protected function syncSummary(AttendanceRecord $attendanceRecord)
    {
        $bulan = $attendanceRecord->tanggal->month;
        $tahun = $attendanceRecord->tanggal->year;

        $this->attendanceSummaryService->syncSingleUserSummary(
            $attendanceRecord->user_id,
            $bulan,
            $tahun
        );
    }
}