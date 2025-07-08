<?php

use App\Http\Controllers\DashboardSearatesAPI;
use App\Http\Controllers\SearatesApiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('searates');
});

// Original routes
Route::get('/searates', [SearatesApiController::class, 'index']);

// Dashboard routes
Route::get('/dashboard', [DashboardSearatesAPI::class, 'index'])->name('dashboard');
Route::post('/api/search-tracking', [DashboardSearatesAPI::class, 'search'])->name('dashboard.search');