<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

#[Signature('app:clear-enrollment-logs')]
#[Description('Command description')]
class ClearEnrollmentLogs extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $logFile = storage_path('logs/enrollment.log');

        if (!File::exists($logFile)) {
            $this->warn('Log file does not exist.');
            return self::SUCCESS;
        }

        File::put($logFile, '');
        Log::info('Start of the Log');
        $this->info('Enrollment logs cleared successfully.');
        return self::SUCCESS;
    }
}
