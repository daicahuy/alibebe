<?php

namespace App\Console;

use App\Console\Commands\PruneSoftDeletedCategories;
use App\Console\Commands\DeleteOldTrashedItems;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Database\Console\PruneCommand;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        DeleteOldTrashedItems::class,
    ];
    /**
     * Define the application's command schedule.
     */
    protected $commands = [
        PruneSoftDeletedCategories::class,
    ];
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('categories:prune')->dailyAt('06:00');
        // $schedule->command('inspire')->hourly();
        $schedule->command('app:delete-old-trashed-items')->everyFifteenSeconds();
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
