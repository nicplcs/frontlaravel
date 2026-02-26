<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovimientosController;
use App\Http\Controllers\DevolucionesController;
use App\Http\Controllers\UsuariosController; 
use App\Http\Controllers\ProveedoresController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\EntradaProductoController;
use App\Http\Controllers\SalidaProductoController;
use App\Http\Controllers\RegistrarProductoController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardAdministradorController;
use App\Http\Controllers\DashboardEmpleadoController;
use App\Http\Controllers\ProveedoresEmpleadoController;
use App\Http\Controllers\MovimientosEmpleadoController;
use App\Http\Controllers\DevolucionesEmpleadoController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

    //Login
Route::get('/login', function () {
    return view('Login.login');
})->name('login');

Route::post('/login', [LoginController::class, 'login'])->name('login.post');

Route::get('/logout', function () {
    session()->flush();
    return redirect()->route('login')->with('success', 'Sesión cerrada correctamente');
})->name('logout');

//REGISTRO DE USUARIOS
Route::get('/registro', function () {
    return view('Login.registro'); 
})->name('registro');


Route::get('/inicio-administrador', [DashboardAdministradorController::class, 'index'])
    ->name('inicio.administrador');


Route::get('/inicio-empleado', [DashboardEmpleadoController::class, 'index'])
    ->name('inicio.empleado');

    // Movimientos
Route::get('/consultar-movimiento', [MovimientosController::class, 'consultarMovimientos'])
    ->name('consultar.movimiento');

Route::get('/modulo-movimiento', function () {
    return view('Modulo-movimientos.modulo-movimiento');
})->name('modulo.movimiento');

Route::post('/movimientos/eliminar', [MovimientosController::class, 'eliminar'])
    ->name('movimientos.eliminar');
    
Route::post('/validar-password-eliminar', [MovimientosController::class, 'validarPasswordEliminar'])
    ->name('validar.password.eliminar');

    // Devoluciones

Route::get('/registrar-devolucion', [DevolucionesController::class, 'index'])
    ->name('registrar.devolucion');

Route::post('/devoluciones/crear', [DevolucionesController::class, 'store'])
    ->name('devoluciones.store');

Route::post('/devoluciones/actualizar', [DevolucionesController::class, 'update'])
    ->name('devoluciones.update');

Route::post('/devoluciones/eliminar', [DevolucionesController::class, 'destroy'])
    ->name('devoluciones.destroy');
    
// MODULO USUARIOS
Route::get('/modulo-usuarios', function () {
    return view('Modulo-usuarios.modulo-usuarios');
})->name('modulo.usuarios');

Route::get('/gestion-usuarios', [UsuariosController::class, 'index'])
    ->name('usuarios.gestion');

Route::post('/usuarios/crear', [UsuariosController::class, 'store'])
    ->name('usuarios.store');

Route::match(['post', 'put'], '/usuarios/actualizar', [UsuariosController::class, 'update'])
    ->name('usuarios.update');
    
Route::post('/usuarios/eliminar', [UsuariosController::class, 'destroy'])
    ->name('usuarios.destroy');

    // PROVEEDORES
Route::get('/gestion-proveedores', [ProveedoresController::class, 'index'])
    ->name('proveedores.gestion');

Route::post('/proveedores/crear', [ProveedoresController::class, 'store'])
    ->name('proveedores.store');

Route::post('/proveedores/actualizar', [ProveedoresController::class, 'update'])
    ->name('proveedores.update');

Route::post('/proveedores/eliminar', [ProveedoresController::class, 'destroy'])
    ->name('proveedores.destroy');

// PRODUCTOS

Route::get('/productos/gestion', function () {
    return view('productos.gestion');
})->name('productos.gestion');

Route::get('/productos/consultar', [ProductoController::class, 'consultar'])
    ->name('productos.consultar');

Route::post('/productos/actualizar', [ProductoController::class, 'actualizar'])
    ->name('productos.actualizar');

Route::post('/productos/desactivar', [ProductoController::class, 'desactivar'])
    ->name('productos.desactivar');

Route::get('/productos/entrada', [EntradaProductoController::class, 'mostrarFormulario'])
    ->name('productos.entrada');

Route::post('/productos/entrada', [EntradaProductoController::class, 'registrarEntrada'])
    ->name('productos.entrada.registrar');


Route::get('/productos/salida', [SalidaProductoController::class, 'mostrarFormulario'])
    ->name('productos.salida');

Route::post('/productos/salida', [SalidaProductoController::class, 'registrarSalida'])
    ->name('productos.salida.registrar');


Route::get('/productos/registrar', [RegistrarProductoController::class, 'mostrarFormulario'])
    ->name('productos.registrar');

Route::post('/productos/registrar', [RegistrarProductoController::class, 'registrarProducto'])
    ->name('productos.registrar.guardar');


Route::get('/interfaz-caleb', function () {
    return view('Interfaz-caleb.interfaz');
})->name('interfaz.caleb');
    
    //inicio bloqueado
Route::get('/inicio-bloqueado', function () {
    return view('inicio.inicio-bloqueado');
})->name('inicio.bloqueado');

// EMPLEADOS PROVEEDORES
Route::get('/empleado/proveedores', [ProveedoresEmpleadoController::class, 'index'])
    ->name('empleado.proveedores.consultar');

    //reset password
Route::get('/forgot-password', function () {
    return view('Login.forgot-password');
})->name('password.request');

Route::get('/reset-password', function () {
    return view('Login.reset-password');
})->name('password.reset');

// EMPLEADOS MOVIMIENTOS
Route::get('/empleado/movimientos', [MovimientosEmpleadoController::class, 'consultarMovimientos'])
    ->name('empleado.movimientos.consultar');

// EMPLEADOS DEVOLUCIONES
Route::get('/empleado/devoluciones', [DevolucionesEmpleadoController::class, 'index'])
    ->name('empleado.devoluciones.consultar');
