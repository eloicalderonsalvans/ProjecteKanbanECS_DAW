<?php


use App\Http\Controllers\TascaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('tasca.index');
});


Route::resource('tasca',TascaController::class);
