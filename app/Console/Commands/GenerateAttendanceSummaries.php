<?php

namespace App\Console\Commands;

use App\Services\AttendanceSummaryService;
use Illuminate\Console\Command;

class GenerateAttendanceSummaries extends Command
{
    protected $signature = 'attendance:generate-summaries {--month=} {--year=}';
    protected $description = 'Generate attendance summaries for all users';

    protected $attendanceSummaryService;

    public function __construct(AttendanceSummaryService $attendanceSummaryService)
    {
        parent::__construct();
        $this->attendanceSummaryService = $attendanceSummaryService;
    }

    public function handle()
    {
        $month = $this->option('month') ?: date('n');
        $year = $this->option('year') ?: date('Y');

        $this->info("Generating attendance summaries for {$month}/{$year}...");

        try {
            $this->attendanceSummaryService->generateMonthlySummary($month, $year);
            $this->info('Attendance summaries generated successfully!');
        } catch (\Exception $e) {
            $this->error('Failed to generate attendance summaries: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }
}