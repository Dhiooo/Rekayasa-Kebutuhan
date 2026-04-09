<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\Auth\LoginController;

// Auth Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Global Redirect to Login (Forcing Logout to ensure Login Page is always shown)
Route::get('/', function () {
    auth()->logout();
    return redirect()->route('login');
});

// Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::prefix('alumni')->group(function () {
        Route::get('/dashboard', [AlumniController::class, 'index'])->name('alumni.dashboard');
        Route::get('/master', [AlumniController::class, 'master'])->name('alumni.master');
        Route::get('/tracking', [AlumniController::class, 'tracking'])->name('alumni.tracking');
        Route::get('/create', [AlumniController::class, 'create'])->name('alumni.create');
        Route::post('/store', [AlumniController::class, 'store'])->name('alumni.store');
        Route::get('/{id}', [AlumniController::class, 'show'])->name('alumni.show');
        Route::get('/{id}/edit', [AlumniController::class, 'edit'])->name('alumni.edit');
        Route::put('/{id}', [AlumniController::class, 'update'])->name('alumni.update');
        Route::delete('/{id}', [AlumniController::class, 'destroy'])->name('alumni.destroy');
        
        // Tracking Actions
        Route::post('/{id}/track', [AlumniController::class, 'trackSingle'])->name('alumni.track');
        Route::post('/track-all', [AlumniController::class, 'trackAll'])->name('alumni.trackAll');
        Route::post('/{id}/verify', [AlumniController::class, 'verify'])->name('alumni.verify');
    });
});
