<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withSchedule(function ($schedule) {
        $schedule->command('app:timetable-notification')->everyMinute()->timezone('Europe/Tallinn');
        $schedule->command('app:timetable-notification')->weeklyOn(7, '10:00')->timezone('Europe/Tallinn');
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
