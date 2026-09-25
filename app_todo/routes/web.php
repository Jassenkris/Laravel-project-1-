<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;

Route::get('/', [TodoController::class, 'index'])->name('todo.index');
Route::post('/tambah', [TodoController::class, 'store'])->name('todo.store');
Route::patch('/update/{id}', [TodoController::class, 'update'])->name('todo.update');
Route::delete('/hapus/{id}', [TodoController::class, 'destroy'])->name('todo.destroy');