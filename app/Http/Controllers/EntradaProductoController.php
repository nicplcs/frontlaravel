<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProductoService;

class EntradaProductoController extends Controller
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

        return view('productos.entrada-producto', [
            'productos' => $productosActivos
        ]);
    }

    public function registrarEntrada(Request $request)
    {
        $request->validate([
            'idProducto' => 'required|integer|min:1',
            'cantidadAgregar' => 'required|integer|min:1'
        ], [
            'idProducto.required' => 'Debe seleccionar un producto.',
            'cantidadAgregar.required' => 'Debe ingresar una cantidad.',
            'cantidadAgregar.min' => 'La cantidad debe ser al menos 1.'
        ]);

        $idProducto = $request->input('idProducto');
        $cantidadAgregar = $request->input('cantidadAgregar');

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

        
        $nuevoStockActual = $productoActual['stockActual'] + $cantidadAgregar;

        
        $advertencia = "";
        if ($nuevoStockActual > $productoActual['stockMaximo']) {
            $advertencia = "  ADVERTENCIA: La entrada excede el stock máximo permitido ({$productoActual['stockMaximo']}).";
        }

        $productoActual['stockActual'] = $nuevoStockActual;

        $resultado = $this->productoService->actualizarProducto($idProducto, $productoActual);

        if ($resultado["success"]) {
            return redirect()->back()->with('success', "✓ Entrada registrada correctamente. Nuevo stock: {$nuevoStockActual}{$advertencia}");
        } else {
            return redirect()->back()->with('error', "Error: {$resultado['error']}");
        }
    }
}