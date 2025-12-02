<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
 Route::get('/login', function () {
    return view('Login.login');
})->name('login');

 Route::get('/consultar-movimiento', function () {
    return view('Modulo-movimientos.consultar-movimiento');
 })->name('consultar.movimiento');

Route::get('/modulo-movimiento', function () {
    return view('Modulo-movimientos.modulo-movimiento');
})->name('modulo.movimiento');
