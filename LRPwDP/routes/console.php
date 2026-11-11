<?php

use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// 1. Hourly AI Price Updates
Schedule::command('ml:update-prices')->everyFiveMinutes();

// 2. Auto-Cancel Expired Reservations
Schedule::command('reservations:cancel-expired')->everyFiveMinutes();

// 3. Mark expired perishables as inactive
Schedule::command('perishables:prune')->everyFiveMinutes();
// Schedule::call(function () {
//     Log::info('this is from scheduler');
// })->everyFiveSeconds();