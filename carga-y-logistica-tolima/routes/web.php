<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/envios/consultar', function () {
    return view('envios.consultar');
});