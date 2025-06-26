<?php

use App\Http\Controllers\HabitoController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/habitos', [HabitoController::class, 'index'])->name('habitos.index');
    Route::post('/habitos', [HabitoController::class, 'store'])->name('habitos.store');
    Route::get('/habitos/{id}/edit', [HabitoController::class, 'edit'])->name('habitos.edit');
    Route::put('/habitos/{id}', [HabitoController::class, 'update'])->name('habitos.update');
    Route::delete('/habitos/{id}', [HabitoController::class, 'destroy'])->name('habitos.destroy');
    
    Route::get('/reportes', [HabitoController::class, 'reporte'])->name('habitos.reporte');
    Route::get('/recomendaciones', [HabitoController::class, 'recomendaciones'])->name('habitos.recomendaciones');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
