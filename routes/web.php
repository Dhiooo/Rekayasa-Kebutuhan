<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AlumniController;

Route::get('/', [AlumniController::class, 'index'])->name('alumni.index');
Route::get('/alumni-master', [AlumniController::class, 'master'])->name('alumni.master');
Route::get('/alumni/tracking', [AlumniController::class, 'tracking'])->name('alumni.tracking');
Route::get('/alumni/{id}/show', [AlumniController::class, 'show'])->name('alumni.show');
Route::delete('/alumni/{id}', [AlumniController::class, 'destroy'])->name('alumni.destroy');
Route::resource('alumni', AlumniController::class)->except(['index', 'show', 'destroy']);
Route::post('/alumni/{id}/track', [AlumniController::class, 'track'])->name('alumni.track');
Route::post('/alumni/track-all', [AlumniController::class, 'trackAll'])->name('alumni.trackAll');
Route::post('/alumni/{id}/verify', [AlumniController::class, 'verify'])->name('alumni.verify');
