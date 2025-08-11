<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardSearatesAPI;
use App\Http\Controllers\DashboardDbController;
use App\Http\Controllers\SearatesApiController;
use App\Http\Controllers\UserTestingController;

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

//Import Excel
Route::get('/import-excel' , [UserTestingController::class, 'index'])->name('excel-import');
Route::post('/import-excel', [UserTestingController::class, 'store'])->name('import.excel');
//Download Template
Route::get('/download-template', [UserTestingController::class, 'downloadTemplate'])->name('download.template');
Route::get('/importing', [UserTestingController::class, 'import']);