<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /** 
     * cPanel Instructions
     * Go to MultiPHP INI Editor
     * Select Domain
     * allow_url_fopen = on
     * disable_functions = show_source, system, shell_exec, symlink, passthru, exec, popen,eval
     */

    /**
     * on cPanel setup cron job
     * @param php_path
     * @param project_directory/artisan schedule:run >> /dev/null 2>&1 or > "NUL" 2>&1
     * Example: * * * * * php /php_path/project_directory/artisan schedule:run >> /dev/null 2>&1 or > "NUL" 2>&1
     */
    
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
