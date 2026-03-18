<?php

use App\Http\Controllers\EnvioController;
use Illuminate\Support\Facades\Route;

Route::get('/envios/buscar', [EnvioController::class, 'buscarPorGuia']);
use App\Http\Controllers\GuiaController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/guias',              [GuiaController::class, 'index']);
    Route::post('/guias',             [GuiaController::class, 'store']);
    Route::get('/guias/{numeroGuia}', [GuiaController::class, 'show']);
    Route::get('/planillas',          [GuiaController::class, 'getPlanillas']);
});