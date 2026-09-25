<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;

class TodoController extends Controller
{
    public function index()
    {
        $todos = Todo::latest()->get();
        return view('todo', compact('todos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
        ]);

        Todo::create([
            'judul' => $request->judul,
            'keterangan' => $request->keterangan,
            'is_selesai' => false,
        ]);

        return redirect()->route('todo.index');
    }

    public function update(Request $request, $id)
    {
        $todo = Todo::findOrFail($id);
        $isSelesai = !$todo->is_selesai;

        $todo->update([
            'is_selesai' => $isSelesai,
            'selesai_pada' => $isSelesai ? now() : null,
        ]);

        return redirect()->route('todo.index');
    }

    public function destroy($id)
    {
        $todo = Todo::findOrFail($id);
        $todo->delete(); // Hapus dari database MySQL

        return redirect()->route('todo.index');
    }
}