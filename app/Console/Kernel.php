<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('limpar:arquivos')->dailyAt('00:00')->runInBackground();
        $schedule->command('post:aniversario')->dailyAt('00:30')->runInBackground();
        $schedule->command('backup:clean')->dailyAt('01:00')->runInBackground();
        $schedule->command('backup:run')->dailyAt('01:30')->runInBackground();
        $schedule->command('parse:birthday')->dailyAt('02:00')->runInBackground();

        //$schedule->command('cron:teste')->everyMinute()->runInBackground();parse:birthday
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
