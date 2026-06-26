<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|max:255',
            'descripcion' => 'nullable|max:1000',
            'board_id' => 'required|exists:boards,id',
        ]);

        $board = \App\Models\Board::findOrFail($request->board_id);

        if ($board->user_id !== $request->user()->id) {
            abort(403);
        }

        Task::create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'estado' => 'pendiente',
            'board_id' => $request->board_id,
        ]);

        return redirect()
            ->back()
            ->with(
                'scroll_position',
                $request->scroll_position
            );
    }

    public function moverAProgreso(Request $request, Task $task)
    {
        if ($task->board->user_id !== $request->user()->id) {
            abort(403);
        }

        $task->update([
            'estado' => 'progreso'
        ]);

        return redirect()->back()->withFragment('kanban-board');
    }

    public function moverAHecho(Request $request, Task $task)
    {
        if ($task->board->user_id !== $request->user()->id) {
            abort(403);
        }

        $task->update([
            'estado' => 'hecho'
        ]);

        return redirect()->back()->withFragment('kanban-board');
    }

    public function cambiarEstado(Request $request, Task $task)
    {
        if ($task->board->user_id !== $request->user()->id) {
            abort(403);
        }

        $request->validate([
            'estado' => 'required|in:pendiente,progreso,hecho'
        ]);

        $task->update([
            'estado' => $request->estado
        ]);

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    public function update(Request $request, Task $task)
    {
        if ($task->board->user_id !== $request->user()->id) {
            abort(403);
        }

        $request->validate([
            'titulo' => 'required|max:255',
            'descripcion' => 'nullable'
        ]);

        $task->update([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion
        ]);

        $scroll = $request->scroll_position;

        return redirect()
            ->route('boards.show', $task->board_id)
            ->with([
                'scroll_position' => $scroll
            ]);
    }


    public function destroy(Request $request, Task $task)
    {
        if ($task->board->user_id !== $request->user()->id) {
            abort(403);
        }

        $task->delete();

        return redirect()->back()->withFragment('kanban-board');
    }
}
