<?php

use App\Console\Commands\TimetableNotification;
use App\Mail\Timetable;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    abort(40);
});

