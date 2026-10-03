<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\BebekController::class, 'index']);

Route::get('/kasir', function () {
    return view('kasir');
});