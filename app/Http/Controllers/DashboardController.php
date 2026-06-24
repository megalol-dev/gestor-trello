<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Task;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $boards = $user->boards;
        $boardsCount = $boards->count();

        $tasks = Task::whereHas('board', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        });

        $totalTasks = $tasks->count();

        $pendientes = (clone $tasks)
            ->where('estado', 'pendiente')
            ->count();

        $progreso = (clone $tasks)
            ->where('estado', 'progreso')
            ->count();

        $hechas = (clone $tasks)
            ->where('estado', 'hecho')
            ->count();

        $porcentaje = $totalTasks > 0
            ? round(($hechas / $totalTasks) * 100)
            : 0;

        return view('dashboard', compact(
            'boards',
            'boardsCount',
            'totalTasks',
            'pendientes',
            'progreso',
            'hechas',
            'porcentaje'
        ));
    }
}