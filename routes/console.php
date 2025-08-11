<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('reminder:due-books')->weekdays()->dailyAt("07:30");
Schedule::command('reminder:due-date-book')->weekdays()->dailyAt("07:35");
Schedule::job('app:mark-overdue-borrow')->daily();