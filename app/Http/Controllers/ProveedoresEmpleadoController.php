<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class ProveedoresEmpleadoController extends Controller
{
    public function index(Request $request)
    {
        try {
            $token = session('token');
            
            $response = Http::timeout(10)
                ->withHeaders($token ? ['Authorization' => 'Bearer ' . $token] : [])
                ->get('http://localhost:8080/proveedores');
            
            if ($response->successful()) {
                $proveedores = $response->json();
                
                // APLICAR FILTROS
                if ($request->filled('nombre')) {
                    $nombre = strtolower($request->nombre);
                    $proveedores = array_filter($proveedores, function($proveedor) use ($nombre) {
                        return stripos(strtolower($proveedor['nombre']), $nombre) !== false;
                    });
                }
                
                if ($request->filled('estado')) {
                    $estado = $request->estado;
                    $proveedores = array_filter($proveedores, function($proveedor) use ($estado) {
                        return ($proveedor['estado'] ?? '1') == $estado;
                    });
                }
                
                // Reindexar el array después de filtrar
                $proveedores = array_values($proveedores);
                
            } else {
                $proveedores = [];
            }
            
        } catch (\Exception $e) {
            $proveedores = [];
            $error = "Error al conectar con la API: " . $e->getMessage();
        }
        
        return view('Empleado.consultar-proveedores', [
            'proveedores' => $proveedores,
            'error' => $error ?? null
        ]);
    }
}