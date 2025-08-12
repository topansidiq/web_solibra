<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Udah jatuh tempo
Schedule::command('reminder:due-books')->dailyAt("07:30");

// Mau jatuh tempo
Schedule::command('reminder:due-date-book')->dailyAt("07:35");

// Merubah status peminjaman
Schedule::job('app:mark-overdue-borrow')->daily();
