<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\BebekController;

Route::get('/produk', [BebekController::class, 'index']);
