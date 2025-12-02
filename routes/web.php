<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TascaController;

// Ruta principal: Kanban (Llista de tasques)
Route::get('/', [TascaController::class, 'index'])->name('tasca.index');

// Crear tasca
Route::get('/tasca/create', [TascaController::class, 'create'])->name('tasca.create');
Route::post('/tasca', [TascaController::class, 'store'])->name('tasca.store');

// Editar tasca
Route::get('/tasca/{id}/edit', [TascaController::class, 'edit'])->name('tasca.edit');
Route::put('/tasca/{id}', [TascaController::class, 'update'])->name('tasca.update');

// Eliminar tasca
Route::delete('/tasca/{id}', [TascaController::class, 'destroy'])->name('tasca.destroy');

// Drag & Drop Kanban: actualitzar estat i posició (la ruta que faltava i causava el 404)
Route::post('/tasca/kanban/update', [TascaController::class, 'updateKanban'])->name('tasca.kanban.update');