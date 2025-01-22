<?php

namespace App\Console;

use App\Console\Commands\PruneSoftDeletedCategories;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Database\Console\PruneCommand;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected $commands = [
        PruneSoftDeletedCategories::class,
    ];
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('app:prune-soft-deleted-categories')->daily();
        // $schedule->command('inspire')->hourly();
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
