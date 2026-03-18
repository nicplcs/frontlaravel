<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DashboardEmpleadoController extends Controller
{
    private $apiUrl = 'http://localhost:8080';

    public function index()
    {
        try {
            // Obtener estadísticas para empleado
            $estadisticas = Http::get($this->apiUrl . '/dashboard/estadisticas-empleado')->json();
            
            // Obtener productos con bajo stock
            $productosBajoStock = Http::get($this->apiUrl . '/dashboard/productos-bajo-stock')->json();
            
            // Obtener movimientos recientes
            $movimientosRecientes = Http::get($this->apiUrl . '/dashboard/movimientos-recientes')->json();
            
            return view('Empleado.inicio-empleado', [
                'productosActivos' => $estadisticas['productosActivos'] ?? 0,
                'bajoStock' => $estadisticas['bajoStock'] ?? 0,
                'categorias' => $estadisticas['categorias'] ?? 0,
                'movimientosHoy' => $estadisticas['movimientosHoy'] ?? 0,
                'productosBajoStock' => $productosBajoStock ?? [],
                'movimientosRecientes' => $movimientosRecientes ?? []
            ]);
            
        } catch (\Exception $e) {
            return view('Empleado.inicio-empleado', [
                'productosActivos' => 0,
                'bajoStock' => 0,
                'categorias' => 0,
                'movimientosHoy' => 0,
                'productosBajoStock' => [],
                'movimientosRecientes' => []
            ]);
        }
    }
}