<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardSearatesAPI;
use App\Http\Controllers\DashboardDbController;
use App\Http\Controllers\SearatesApiController;

Route::get('/', function () {
    return view('searates');
});

// Original routes
Route::get('/searates', [SearatesApiController::class, 'index']);

// Dashboard routes
Route::get('/dashboard', [DashboardSearatesAPI::class, 'index'])->name('dashboard');
Route::post('/api/search-tracking', [DashboardSearatesAPI::class, 'search'])->name('dashboard.search');


//Dashboard Database Routes
Route::get('/dashboard-db', [DashboardDbController::class, 'index'])->name('dashboard-db');
Route::post('/api/search-tracking-db', [DashboardDbController::class, 'search'])->name('dashboard-db.search');