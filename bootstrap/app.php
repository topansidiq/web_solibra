<?php

use App\Jobs\MarkOverdueBorrows;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Schedule;

$app = new Application(
    $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__)
);

$app->afterBootstrapping(
    Illuminate\Foundation\Bootstrap\BootProviders::class,
    function ($app) {
        $app->make(Schedule::class)->call(function () {
            dispatch(new MarkOverdueBorrows());
        })->dailyAt('08:00')->name('mark-overdue-borrows');
    }
);

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
