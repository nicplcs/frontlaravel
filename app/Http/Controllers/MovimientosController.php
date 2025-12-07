<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class MovimientosController extends Controller
{
    public function consultarMovimientos()
    {
        try {
            $token = session('token');
            
            // Consume tu API de Spring Boot
            $response = Http::timeout(10)
                ->withHeaders($token ? ['Authorization' => 'Bearer ' . $token] : [])
                ->get('http://localhost:8080/movimientos');
            
            // Verifica si la respuesta fue exitosa
            if ($response->successful()) {
                $movimientos = $response->json();
            } else {
                $movimientos = [];
            }
            
        } catch (\Exception $e) {
            // Si hay error de conexión
            $movimientos = [];
            $error = "Error al conectar con la API: " . $e->getMessage();
        }
        
        return view('Modulo-movimientos.consultar-movimiento', [
            'movimientos' => $movimientos,
            'error' => $error ?? null
        ]);
    }

    public function eliminar(Request $request)
    {
        $id = $request->input('id');

        try {
            $token = session('token');
            
            $response = Http::withHeaders($token ? ['Authorization' => 'Bearer ' . $token] : [])
                ->delete("http://localhost:8080/movimientos/{$id}");

            if ($response->successful() || $response->status() == 200) {
                return back()->with('success', 'Movimiento eliminado correctamente');
            }

            return back()->with('error', 'Error al eliminar el movimiento: ' . $response->body());

        } catch (\Exception $e) {
            return back()->with('error', 'No se pudo comunicar con la API: ' . $e->getMessage());
        }
    }
}