<?php

namespace App\Console;

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
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // 每天午夜解除当天 选定 但未跟进的目标客户 锁定状态
        $schedule->command('Empty:Target')->daily();
        // 每天8点发送前一天的报表
        $schedule->command('SendReport:day')->dailyAt('8:00');
        // 每周一早上8点发送前一周的报表
        $schedule->command('SendReport:week')->weeklyOn(1, '8:00');
        // 每月1号8点发送前一月的报表
        $schedule->command('SendReport:month')->monthlyOn(1, '8:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
