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

    /*
    |--------------------------------------------------------------------------
    | Tableros
    |--------------------------------------------------------------------------
    */

    Route::post('/boards', [BoardController::class, 'store'])
        ->name('boards.store');

    Route::get('/boards/{board}', [BoardController::class, 'show'])
        ->name('boards.show');

    Route::get('/boards/{board}/edit', [BoardController::class, 'edit'])
        ->name('boards.edit');

    Route::put('/boards/{board}', [BoardController::class, 'update'])
        ->name('boards.update');

    Route::delete('/boards/{board}', [BoardController::class, 'destroy'])
        ->name('boards.destroy');

    /*
    |--------------------------------------------------------------------------
    | Tareas
    |--------------------------------------------------------------------------
    */

    Route::resource('tasks', TaskController::class);

    Route::patch('/tasks/{task}/progreso', [TaskController::class, 'moverAProgreso'])
        ->name('tasks.progreso');

    Route::patch('/tasks/{task}/hecho', [TaskController::class, 'moverAHecho'])
        ->name('tasks.hecho');

    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])
        ->name('tasks.destroy');

    Route::put('/tasks/{task}', [TaskController::class, 'update'])
        ->name('tasks.update');

    Route::patch('/tasks/{task}/estado', [TaskController::class, 'cambiarEstado'])
        ->name('tasks.estado');

    /*
    |--------------------------------------------------------------------------
    | Perfil
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__ . '/auth.php';
