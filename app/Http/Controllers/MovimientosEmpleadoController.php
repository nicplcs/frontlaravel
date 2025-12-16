<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class MovimientosEmpleadoController extends Controller
{
    public function consultarMovimientos()
    {
        try {
            $token = session('token');
            
            $response = Http::timeout(10)
                ->withHeaders($token ? ['Authorization' => 'Bearer ' . $token] : [])
                ->get('http://localhost:8080/movimientos');
         
            if ($response->successful()) {
                $movimientos = $response->json();
            } else {
                $movimientos = [];
            }
            
        } catch (\Exception $e) {
         
            $movimientos = [];
            $error = "Error al conectar con la API: " . $e->getMessage();
        }

        return view('Empleado.consultar-movimientos', [
            'movimientos' => $movimientos,
            'error' => $error ?? null
        ]);
    }

    
}