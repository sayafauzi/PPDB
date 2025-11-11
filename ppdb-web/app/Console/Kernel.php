<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define your application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Jalankan pengecekan deadline pendaftaran tiap 30 menit
        $schedule->command('registrasi:cek-deadline')->everyThirtyMinutes();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        // Laravel akan otomatis memuat semua file di folder app/Console/Commands
        $this->load(__DIR__.'/Commands');

        // Atau kalau kamu ingin daftar manual:
        // require base_path('routes/console.php');
    }
}
