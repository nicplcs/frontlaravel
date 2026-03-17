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
                ->delete("http://localhost:8080/eliminarMovimiento", [
                    'id_movimiento' => $id
                ]);

            if ($response->successful() || $response->status() == 200) {
                return back()->with('success', 'Movimiento eliminado correctamente');
            }

            return back()->with('error', 'Error al eliminar el movimiento: ' . $response->body());

        } catch (\Exception $e) {
            return back()->with('error', 'No se pudo comunicar con la API: ' . $e->getMessage());
        }
    }
     public function validarPasswordEliminar(Request $request)
    {
        try {
            $correoSesion = session('correo');
            
            if (!$correoSesion) {
                return response()->json([
                    'success' => false,
                    'mensaje' => 'Sesión expirada'
                ], 401);
            }
            
            $password = $request->input('password');
            $id_movimiento = $request->input('id_movimiento');
            
            if (!$password || !$id_movimiento) {
                return response()->json([
                    'success' => false,
                    'mensaje' => 'Datos incompletos'
                ], 400);
            }
            
            $token = session('token');
            
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => $token ? 'Bearer ' . $token : ''
            ])->post('http://localhost:8080/validar-eliminar-movimiento', [
                'correo' => $correoSesion,
                'contrasena' => $password,
                'id_movimiento' => (string)$id_movimiento
            ]);
            
            if ($response->successful()) {
                return response()->json($response->json());
            } else {
                $resultado = $response->json();
                return response()->json([
                    'success' => false,
                    'mensaje' => $resultado['mensaje'] ?? 'Error al validar'
                ], $response->status());
            }
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'mensaje' => 'Error del servidor: ' . $e->getMessage()
            ], 500);
        }
    }

}