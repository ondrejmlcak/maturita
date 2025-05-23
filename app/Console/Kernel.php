<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Definuj naplánované příkazy aplikace.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('matches:store')->cron('*/20 * * * *');
    }

    /**
     * Zaregistruj příkazy aplikace.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
