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
        $todosProductos = $this->productoService->obtenerProductos();
        
        
        $productosActivos = array_filter($todosProductos, function($p) {
            return $p['estado'] == '1';
        });

        return view('productos.salida-producto', [
            'productos' => $productosActivos
        ]);
    }

    public function registrarSalida(Request $request)
    {
        $request->validate([
            'idProducto' => 'required|integer|min:1',
            'cantidadRetirar' => 'required|integer|min:1'
        ]);

        $idProducto = $request->input('idProducto');
        $cantidadRetirar = $request->input('cantidadRetirar');

        $productos = $this->productoService->obtenerProductos();
        $productoActual = null;

        foreach ($productos as $p) {
            if ($p['idProducto'] == $idProducto) {
                $productoActual = $p;
                break;
            }
        }

        if (!$productoActual) {
            return redirect()->back()->with('error', 'Producto no encontrado.');
        }

        
        if ($productoActual['stockActual'] < $cantidadRetirar) {
            return redirect()->back()->with('error', "Stock insuficiente. Stock actual: {$productoActual['stockActual']}, solicitado: {$cantidadRetirar}");
        }

        
        $productoActual['stock'] -= $cantidadRetirar;
        $productoActual['stockActual'] -= $cantidadRetirar;

        $advertencia = "";
        if ($productoActual['stockActual'] < $productoActual['stockMinimo']) {
            $advertencia = " ADVERTENCIA: El stock está por debajo del mínimo requerido.";
        }

        $resultado = $this->productoService->actualizarProducto($idProducto, $productoActual);

        if ($resultado["success"]) {
            return redirect()->back()->with('success', "Salida registrada correctamente. Nuevo stock: {$productoActual['stockActual']}{$advertencia}");
        } else {
            return redirect()->back()->with('error', "Error: {$resultado['error']}");
        }
    }
}