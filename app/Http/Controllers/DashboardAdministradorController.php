<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DashboardAdministradorController extends Controller
{
    private $apiUrl = 'http://localhost:8080';

    public function index()
    {
        try {
            // Obtener estadísticas
            $estadisticas = Http::get($this->apiUrl . '/dashboard/estadisticas')->json();
            
            // Obtener usuarios recientes
            $usuariosRecientes = Http::get($this->apiUrl . '/dashboard/usuarios-recientes')->json();
            
            // Obtener movimientos recientes
            $movimientosRecientes = Http::get($this->apiUrl . '/dashboard/movimientos-recientes')->json();
            
            return view('Administrador.inicio-administrador', [
                'usuariosActivos' => $estadisticas['usuariosActivos'] ?? 0,
                'productosActivos' => $estadisticas['productosActivos'] ?? 0,
                'bajoStock' => $estadisticas['bajoStock'] ?? 0,
                'movimientosHoy' => $estadisticas['movimientosHoy'] ?? 0,
                'usuariosRecientes' => $usuariosRecientes ?? [],
                'movimientosRecientes' => $movimientosRecientes ?? []
            ]);
            
        } catch (\Exception $e) {
            return view('Administrador.inicio-administrador', [
                'usuariosActivos' => 0,
                'productosActivos' => 0,
                'bajoStock' => 0,
                'movimientosHoy' => 0,
                'usuariosRecientes' => [],
                'movimientosRecientes' => []
            ]);
        }
    }
}