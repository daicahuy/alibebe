<?php

namespace App\Console;

use App\Console\Commands\CheckExpiredCoupons;
use App\Console\Commands\DeleteOldTrashedItems;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Database\Console\PruneCommand;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected $commands = [
        DeleteOldTrashedItems::class,
        CheckExpiredCoupons::class,
    ];

    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('categories:prune')->dailyAt('06:00');
        // $schedule->command('inspire')->hourly();
        $schedule->command('app:delete-old-trashed-items')->everyFifteenSeconds();
        $schedule->command('coupons:check-expired-coupons')->everyFifteenSeconds();
        $schedule->command('product:update-expired-sale')->everyFifteenSeconds();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
        
        require base_path('routes/console.php');
    }
}
