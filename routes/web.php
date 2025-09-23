<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\DashboardSearatesAPI;
use App\Http\Controllers\DashboardDbController;
use App\Http\Controllers\ImportManualOceanShipments;
use App\Http\Controllers\OceanShipmentsController;
use App\Http\Controllers\OceanShipmentsManualController;
use App\Http\Controllers\SearatesApiController;
use App\Http\Controllers\UserTestingController;

// Public routes (accessible without authentication)
Route::get('/', [LoginController::class, 'index'])->name('login_form');
Route::post('/', [LoginController::class, 'login'])->name('login.process');

// Protected routes (require authentication) - gunakan 'auth' middleware bawaan
// Route::middleware(['auth.user'])->group(function () {
    
    // Logout route
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    // Dashboard routes
    Route::get('/dashboard', [DashboardSearatesAPI::class, 'index'])->name('dashboard');
    Route::post('/api/search-tracking', [DashboardSearatesAPI::class, 'search'])->name('dashboard.search');

    // Dashboard Database Routes
    Route::get('/dashboard-db', [DashboardDbController::class, 'index'])->name('dashboard-db');
    Route::post('/api/search-tracking-db', [DashboardDbController::class, 'search'])->name('dashboard-db.search');

    // Calendar Routes
    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar');
    Route::get('/api/calendar-events', [CalendarController::class, 'getEvents'])->name('calendar.events');
    Route::get('/api/calendar-event-details', [CalendarController::class, 'getEventDetails'])->name('calendar.event.details');

    // Import Excel Routes
    Route::get('/import-excel', [UserTestingController::class, 'index'])->name('excel-import');
    Route::post('/import-excel', [UserTestingController::class, 'store'])->name('import.excel');
    Route::get('/download-template', [UserTestingController::class, 'downloadTemplate'])->name('download.template');
    Route::get('/importing', [UserTestingController::class, 'import']);

    // Searates API routes (for development/testing)
    Route::get('/searates', [SearatesApiController::class, 'index']);
    Route::get('/insert-searates', function () {
        return view('searates');
    });

    Route::get('/import-manual', [ImportManualOceanShipments::class, 'index'])->name('import-manual');
    Route::post('import-manual-store', [ImportManualOceanShipments::class, 'store'])->name('import-manual.store');

        // Ocean Shipments Routes
    Route::get('/ocean-shipments', [OceanShipmentsController::class, 'index'])->name('ocean-shipments');
    Route::post('/ocean-shipments/search', [OceanShipmentsController::class, 'search'])->name('ocean-shipments.search');

// Redirect any other routes to login
Route::fallback(function () {
    return redirect()->route('login_form')->with('error', 'Page not found. Please login to access the system.');
});