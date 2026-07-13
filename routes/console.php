<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('app:clear-laravel-logs')->dailyAt('19:00')->withoutOverlapping();

Schedule::command('app:clear-enrollment-logs')->weeklyOn(1, '18:00')->withoutOverlapping();