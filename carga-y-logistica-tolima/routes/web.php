<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Página de inicio
Route::get('/', function () {
    return view('welcome');
});

// Dashboard tras el login (Tarea SCRUM-46)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// GRUPO DE SEGURIDAD (Tarea SCRUM-62)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ESTA ES LA LÍNEA QUE AGREGAMOS PARA TU PROYECTO
    Route::get('/envios/consultar', function () {
        return view('envios.consultar');
    })->name('envios.consultar');
});

require __DIR__.'/auth.php';
