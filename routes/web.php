<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TascaController;
// Caldrà crear aquest controlador per gestionar els responsables
use App\Http\Controllers\ResponsableController; 

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// ===================================
// RUTES DE GESTIÓ DE TASQUES (Kanban)
// ===================================

// Ruta principal: Kanban (Llista de tasques)
Route::get('/', [TascaController::class, 'index'])->name('tasca.index');

// Crear tasca
Route::get('/tasca/create', [TascaController::class, 'create'])->name('tasca.create');
Route::post('/tasca', [TascaController::class, 'store'])->name('tasca.store');

// Editar i actualitzar tasca
Route::get('/tasca/{id}/edit', [TascaController::class, 'edit'])->name('tasca.edit');
Route::put('/tasca/{id}', [TascaController::class, 'update'])->name('tasca.update');

// Eliminar tasca
Route::delete('/tasca/{id}', [TascaController::class, 'destroy'])->name('tasca.destroy');

// Drag & Drop Kanban: actualitzar estat i posició
Route::post('/tasca/kanban/update', [TascaController::class, 'updateKanban'])->name('tasca.kanban.update');


// ===================================
// NOVES RUTES DE GESTIÓ DE RESPONSABLES
// ===================================

// Rutes per al CRUD de Responsables
// Nota: Necessitaràs crear el ResponsableController si no el tens.

// Crear responsable
Route::get('/responsable/create', [ResponsableController::class, 'create'])->name('responsable.create');
Route::post('/responsable', [ResponsableController::class, 'store'])->name('responsable.store');

// Llista de responsables (opcional, però útil per gestionar-los)
Route::get('/responsables', [ResponsableController::class, 'index'])->name('responsable.index');

// Editar responsable
Route::get('/responsable/{id}/edit', [ResponsableController::class, 'edit'])->name('responsable.edit');
Route::put('/responsable/{id}', [ResponsableController::class, 'update'])->name('responsable.update');

// Eliminar responsable
Route::delete('/responsable/{id}', [ResponsableController::class, 'destroy'])->name('responsable.destroy');