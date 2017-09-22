<?php

namespace App\Console;

use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\MonthAnnualHours::class,
        Commands\LeavedUserAnnualHours::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('Report:AnnualHours')->dailyAt('10:00')->when(function () {
            return \Carbon\Carbon::now()->endOfMonth()->isToday();
        });
        $schedule->command('Report:LeavedUserAnnualHours')->dailyAt('10:00')->when(function () {
            return \Carbon\Carbon::now()->endOfMonth()->isToday();
        });
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
