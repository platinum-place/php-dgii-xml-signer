<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return [config('app.name') => app()->version()];
});
