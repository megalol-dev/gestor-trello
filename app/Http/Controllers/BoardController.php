<?php

namespace App\Http\Controllers;

use App\Models\Board;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    public function show(Request $request, Board $board)
    {
        if ($board->user_id !== $request->user()->id) {
            abort(403);
        }

        $tasksPendientes = $board->tasks()
            ->where('estado', 'pendiente')
            ->get();

        $tasksProgreso = $board->tasks()
            ->where('estado', 'progreso')
            ->get();

        $tasksHechas = $board->tasks()
            ->where('estado', 'hecho')
            ->get();

        return view('boards.show', compact(
            'board',
            'tasksPendientes',
            'tasksProgreso',
            'tasksHechas'
        ));
    }

   
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:255',
            'descripcion' => 'nullable',
        ]);

        $request->user()->boards()->create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
        ]);

        return redirect()
            ->back()
            ->with(
                'scroll_position',
                $request->scroll_position
            );
    }

    public function edit(Request $request, Board $board)
    {
        if ($board->user_id !== $request->user()->id) {
            abort(403);
        }

        return view('boards.edit', compact('board'));
    }

    public function update(Request $request, Board $board)
    {
        if ($board->user_id !== $request->user()->id) {
            abort(403);
        }

        $request->validate([
            'nombre' => 'required|max:255',
            'descripcion' => 'nullable',
        ]);

        $board->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
        ]);

        return redirect()->route('boards.show', $board);
    }

    public function destroy(Request $request, Board $board)
    {
        if ($board->user_id !== $request->user()->id) {
            abort(403);
        }

        $board->delete();

        return redirect()->route('dashboard');
    }
}
