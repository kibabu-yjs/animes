<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/fpb/{slug}', [App\Http\Controllers\HomeController::class, 'filamentPageBuilder']);
