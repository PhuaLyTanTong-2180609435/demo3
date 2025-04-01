<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\GoogleAuthController;

Route::middleware(['web'])->group(function () {
    Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirect'])->name('google.login');
    Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback']);
});
Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');
Route::middleware('auth')->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});


require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
