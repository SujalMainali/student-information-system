<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

#[Signature('app:clear-laravel-logs')]
#[Description('Command description')]
class ClearLaravelLogs extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $logFile = storage_path('logs/laravel.log');

        if (!File::exists($logFile)) {
            $this->warn('Log file does not exist.');
            return self::SUCCESS;
        }

        File::put($logFile, '');
        Log::info('Start of the Log');
        $this->info('Laravel logs cleared successfully.');
        return self::SUCCESS;
    }
}
