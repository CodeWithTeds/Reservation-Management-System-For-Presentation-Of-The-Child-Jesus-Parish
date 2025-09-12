<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('admin/dashboard', function () {
    return Inertia::render('admin/Dashboard');
})->middleware(['auth', 'verified', 'admin'])->name('admin.dashboard');

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified', 'admin'])->group(function () {
    // Event Management Routes
    Route::resource('events', EventController::class);
    Route::get('events-calendar', [EventController::class, 'calendar'])->name('events.calendar');
    
    // Room Management Routes
    Route::resource('rooms', RoomController::class);
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
