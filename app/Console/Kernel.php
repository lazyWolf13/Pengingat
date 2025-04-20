<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        Commands\GenerateAttendanceSummaries::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        // Generate attendance summaries at the end of each month
        $schedule->command('attendance:generate-summaries')
            ->monthly()
            ->onLastDayOfMonth()
            ->at('23:59');
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}