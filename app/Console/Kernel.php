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
        Commands\ReportAnnualYears::class,
        Commands\DailyLeave::class,
        Commands\LeavedUserAnnualHours::class,
        Commands\DailyWaitProve::class,
        Commands\EveryDayAnnualHours::class,
        Commands\CronJobTest::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('Report:AnnualHours')->dailyAt('10:15')->when(function () {
            return Carbon::now()->endOfMonth()->isToday();
        });
        
        $schedule->command('Report:LeavedUserAnnualHours')->dailyAt('20:00')->when(function () {
            return Carbon::now()->endOfMonth()->isToday();
        });

        $schedule->command('Report:AnnualYears')->dailyAt('11:00')->when(function () {
            return (Carbon::now()->format('m-d') == "12-31");
        });

        $schedule->command('Notice:DailyLeave')->dailyAt('10:00');//每天10點通知今日請假人

        $schedule->command('Report:AnnualHoursEveryDay')->dailyAt('09:28'); //每天早上00:05算當日特休

        $schedule->command('Notice:CronJobTest')->everyMinute();
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
