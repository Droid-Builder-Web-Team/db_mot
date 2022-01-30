<?php

/**
 * Console Kernel
 * php version 7.4
 *
 * @category Kernel
 * @package  Console
 * @author   Darren Poulson <darren.poulson@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://portal.droidbuilders.uk/
 */
namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

/**
 * Console Kernel
 *
 * @category Class
 * @package  Console
 * @author   Darren Poulson <darren.poulson@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://portal.droidbuilders.uk/
 */
class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule Schedule
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('cron:checkmot')->dailyAt('10:00');
        $schedule->command('cron:checkpli')->dailyAt('10:30');
        $schedule->command('cron:eventupcoming')->dailyAt('11:00');
        $schedule->command('cron:eventmot')->dailyAt('11:15');
        $schedule->command('cron:newevent')->dailyAt('11:30');
        $schedule->command('backup:clean')->dailyAt('04:00');
        $schedule->command('backup:run')->dailyAt('05:00');
        $schedule->command('stats:gather')->dailyAt('03:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        include base_path('routes/console.php');
    }
}
