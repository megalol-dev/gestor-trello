<?php

use App\Http\Controllers\BoardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::resource('boards', BoardController::class);
    Route::resource('tasks', TaskController::class);
    

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::patch('/tasks/{task}/progreso', [TaskController::class, 'moverAProgreso'])
    ->name('tasks.progreso');
    Route::patch('/tasks/{task}/hecho', [TaskController::class, 'moverAHecho'])
    ->name('tasks.hecho');

    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])
    ->name('tasks.destroy');

    Route::put('/tasks/{task}', [TaskController::class, 'update'])
    ->name('tasks.update');

    Route::patch(
        '/tasks/{task}/estado',
        [TaskController::class, 'cambiarEstado']
    )->name('tasks.estado');
});

require __DIR__.'/auth.php';
