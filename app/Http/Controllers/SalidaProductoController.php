<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProductoService;

class SalidaProductoController extends Controller
{
    private $productoService;

    public function __construct()
    {
        $this->productoService = new ProductoService();
    }

    public function mostrarFormulario()
    {
        $productos = $this->obtenerProductosActivos();

        return view('productos.salida-producto', [
            'productos' => $productos
        ]);
    }

   
    public function mostrarFormularioEmpleado()
    {
        $productos = $this->obtenerProductosActivos();

        return view('Empleado.registrar-salida-empleado', [
            'productos' => $productos
        ]);
    }

   
    public function registrarSalida(Request $request)
    {
        $request->validate([
            'idProducto' => 'required|integer|min:1',
            'cantidadRetirar' => 'required|integer|min:1'
        ], [
            'idProducto.required' => 'Debe seleccionar un producto.',
            'cantidadRetirar.required' => 'Debe ingresar una cantidad.',
            'cantidadRetirar.min' => 'La cantidad debe ser al menos 1.'
        ]);

        $idProducto = $request->idProducto;
        $cantidad = $request->cantidadRetirar;

        $productos = $this->productoService->obtenerProductos();
        $productoActual = null;

        foreach ($productos as $p) {
            if ($p['idProducto'] == $idProducto) {
                $productoActual = $p;
                break;
            }
        }

        if (!$productoActual) {
            return back()->with('error', 'Producto no encontrado.');
        }

        if ($productoActual['stockActual'] < $cantidad) {
            return back()->withInput()->with(
                'error',
                " Stock insuficiente. Disponible: {$productoActual['stockActual']}"
            );
        }

        $nuevoStock = $productoActual['stockActual'] - $cantidad;
        $productoActual['stockActual'] = $nuevoStock;

        $advertencia = '';
        if ($nuevoStock < $productoActual['stockMinimo']) {
            $advertencia = " Stock por debajo del mínimo ({$productoActual['stockMinimo']}).";
        }

        $resultado = $this->productoService->actualizarProducto($idProducto, $productoActual);

        if ($resultado['success']) {
            return back()->with(
                'success',
                "✓ Salida registrada correctamente. Nuevo stock: {$nuevoStock}{$advertencia}"
            );
        }

        return back()->with('error', 'Error al registrar la salida.');
    }

  
    private function obtenerProductosActivos()
    {
        return array_filter(
            $this->productoService->obtenerProductos(),
            fn($p) => isset($p['estado']) && $p['estado'] == '1'
        );
    }
}
