<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

use Illuminate\Support\Facades\Schedule;

/*
 * The day-before arrival reminder. Runs once a day; the command stamps each
 * booking it emails, so an extra run never sends a guest the same reminder
 * twice. withoutOverlapping stops a slow run from being started again on top
 * of itself.
 */
Schedule::command('bookings:send-reminders')
    ->dailyAt('09:00')
    ->withoutOverlapping();
