<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::post('/dashboard/chores/{chore}/complete', [DashboardController::class, 'complete'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard.chores.complete');


require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
