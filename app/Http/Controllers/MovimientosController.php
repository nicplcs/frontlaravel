<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;


class MovimientosController extends Controller
{
    public function consultarMovimientos()
    {
        try {
            // Consume tu API de Spring Boot
            $response = Http::timeout(10)->get('http://localhost:8080/movimientos');
            
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
    $id = $request->id_movimiento;

    try {
        $response = Http::delete("http://localhost:8080/eliminarMovimiento", [
            "id_movimiento" => $id
        ]);

        if ($response->failed()) {
            return back()->with('error', 'Error al eliminar el movimiento');
        }

        return back()->with('success', 'Movimiento eliminado correctamente');

    } catch (\Exception $e) {
        return back()->with('error', 'No se pudo comunicar con la API');
    }
}
}