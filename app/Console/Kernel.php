<?php

namespace App\Console;

use App\Console\Commands\PostAvailablePharmacies;
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
        $schedule->command(PostAvailablePharmacies::class, ['region' => 'nicosia'])->dailyAt('06:00');
        $schedule->command(PostAvailablePharmacies::class, ['region' => 'limassol'])->dailyAt('06:30');
        $schedule->command(PostAvailablePharmacies::class, ['region' => 'larnaca'])->dailyAt('07:00');
        $schedule->command(PostAvailablePharmacies::class, ['region' => 'paphos'])->dailyAt('07:30');
        $schedule->command(PostAvailablePharmacies::class, ['region' => 'paralimni'])->dailyAt('08:00');
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
