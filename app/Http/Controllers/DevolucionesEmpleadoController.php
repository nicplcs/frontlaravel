<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class DevolucionesEmpleadoController extends Controller
{
    public function index()
    {
        try {
            $response = Http::timeout(10)->get('http://localhost:8080/devoluciones');
            $devoluciones = $response->successful() ? $response->json() : [];
        } catch (\Exception $e) {
            $devoluciones = [];
            $error = "Error al conectar con la API: " . $e->getMessage();
        }

        return view('Empleado.registrar-devoluciones', [
            'devoluciones' => $devoluciones,
            'error' => $error ?? null
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'cantidad' => 'required|integer',
            'motivo' => 'required|string',
            'fechaDevolucion' => 'required|date',
            'idOrdenSalida' => 'required|integer',
            'idProducto' => 'required|integer'
        ]);

        try {
            $response = Http::asJson()->post('http://localhost:8080/devoluciones', [
                'cantidad' => (int)$request->cantidad,
                'motivo' => $request->motivo,
                'fechaDevolucion' => $request->fechaDevolucion,
                'idOrdenSalida' => (int)$request->idOrdenSalida,
                'idProducto' => (int)$request->idProducto
            ]);

            return redirect()->route('Empleado.registrar-devoluciones')
                ->with($response->successful() ? 'success' : 'error', 
                    $response->successful() ? 'Devolución registrada correctamente' : 'Error al registrar');


        } catch (\Exception $e) {
            return redirect()->route('Empleado.registrar-devoluciones')
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }

}
