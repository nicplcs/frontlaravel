<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProductoService;
use App\Services\CategoriaService;
use App\Services\ProveedorService;

class RegistrarProductoController extends Controller
{
    private $productoService;
    private $categoriaService;
    private $proveedorService;

    public function __construct()
    {
        $this->productoService  = new ProductoService();
        $this->categoriaService = new CategoriaService();
        $this->proveedorService = new ProveedorService();
    }

    public function mostrarFormulario()
    {
        $productos   = $this->productoService->obtenerProductos();
        $categorias  = $this->categoriaService->obtenerCategorias();
        $proveedores = $this->proveedorService->obtenerProveedores();

        return view('productos.registrar-producto', [
            'productos'   => $productos,
            'categorias'  => $categorias,
            'proveedores' => $proveedores
        ]);
    }

    public function registrarProducto(Request $request)
    {
        $request->validate([
            'nombre'      => 'required|string|max:255',
            'precio'      => 'required|numeric|min:0.01',
            'stockMinimo' => 'required|integer|min:0',
            'stockMaximo' => 'required|integer|min:0',
            'stockActual' => 'required|integer|min:0',
            'idCategoria' => 'required|integer|min:1',
            'idProveedor' => 'required|integer|min:1'
        ], [
            'nombre.required'      => 'El nombre del producto es obligatorio.',
            'nombre.max'           => 'El nombre no puede exceder 255 caracteres.',
            'precio.required'      => 'El precio es obligatorio.',
            'precio.min'           => 'El precio debe ser mayor a 0.',
            'stockMinimo.required' => 'El stock mínimo es obligatorio.',
            'stockMinimo.min'      => 'El stock mínimo no puede ser negativo.',
            'stockMaximo.required' => 'El stock máximo es obligatorio.',
            'stockMaximo.min'      => 'El stock máximo no puede ser negativo.',
            'stockActual.required' => 'El stock actual es obligatorio.',
            'stockActual.min'      => 'El stock actual no puede ser negativo.',
            'idCategoria.required' => 'La categoría es obligatoria.',
            'idCategoria.min'      => 'El ID de categoría debe ser válido.',
            'idProveedor.required' => 'El proveedor es obligatorio.',
            'idProveedor.min'      => 'El ID de proveedor debe ser válido.'
        ]);

        if ($request->input('stockActual') < $request->input('stockMinimo')) {
            return redirect()->back()->withInput()
                ->with('error', 'El stock actual no puede ser menor al stock mínimo.');
        }

        if ($request->input('stockActual') > $request->input('stockMaximo')) {
            return redirect()->back()->withInput()
                ->with('error', 'El stock actual no puede ser mayor al stock máximo.');
        }

        if ($request->input('stockMinimo') > $request->input('stockMaximo')) {
            return redirect()->back()->withInput()
                ->with('error', 'El stock mínimo no puede ser mayor al stock máximo.');
        }

        $producto = [
            "nombre"      => $request->input('nombre'),
            "precio"      => $request->input('precio'),
            "stockMinimo" => $request->input('stockMinimo'),
            "stockMaximo" => $request->input('stockMaximo'),
            "stockActual" => $request->input('stockActual'),
            "idCategoria" => $request->input('idCategoria'),
            "idProveedor" => $request->input('idProveedor'),
            "estado"      => "1"
        ];

        $resultado = $this->productoService->agregarProducto($producto);

        if ($resultado["success"]) {
            return redirect()->back()->with('success', 'Producto agregado correctamente.');
        } else {
            return redirect()->back()->withInput()
                ->with('error', "Error: {$resultado['error']}");
        }
    }
}