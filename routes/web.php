<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovimientosController;

Route::get('/', function () {
    return view('welcome');
});
 Route::get('/login', function () {
    return view('Login.login');
})->name('login');

Route::get('/consultar-movimiento', [MovimientosController::class, 'consultarMovimientos'])
    ->name('consultar.movimiento');

Route::get('/modulo-movimiento', function () {
    return view('Modulo-movimientos.modulo-movimiento');
})->name('modulo.movimiento');

Route::get('/registrar-devolucion', function () {
    return view('Modulo-movimientos.registrar-devolucion');
})->name('registrar.devolucion');

Route::post('/movimientos/eliminar', [MovimientoController::class, 'eliminar'])
     ->name('movimientos.eliminar');
