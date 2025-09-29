<?php

namespace App\Console;

use App\Jobs\SendExamReminderJob;
use App\Models\Ujian;
use App\Jobs\SendUjianReminderJob;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Tes sederhana
        $schedule->call(function () {
            $ujians = Ujian::where('status', 'published')
                ->where('waktu_mulai', '>', now())
                ->where('waktu_mulai', '<=', now()->addMinutes(30)) // reminder 30 menit sebelum
                ->get();

            foreach ($ujians as $ujian) {
                dispatch(new SendExamReminderJob($ujian));
            }
        })->everyMinute();
    }


    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
