<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class DevolucionesController extends Controller
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
        
        return view('Modulo-movimientos.registrar-devolucion', [
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
            'idMovimiento' => 'required|integer',
            'idProducto' => 'required|integer'
        ]);

        try {
            $response = Http::asJson()->post('http://localhost:8080/devoluciones', [
                'cantidad' => (int)$request->cantidad,
                'motivo' => $request->motivo,
                'fechaDevolucion' => $request->fechaDevolucion,
                'idMovimiento' => (int)$request->idMovimiento,
                'idProducto' => (int)$request->idProducto
            ]);

            return redirect()->route('registrar.devolucion')
                ->with($response->successful() ? 'success' : 'error', 
                    $response->successful() ? 'Devolución registrada correctamente' : 'Error al registrar');


        } catch (\Exception $e) {
            return redirect()->route('registrar.devolucion')
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'cantidad' => 'required|integer',
            'motivo' => 'required|string',
            'fechaDevolucion' => 'required|date',
            'idMovimiento' => 'required|integer',
            'idProducto' => 'required|integer'
        ]);

        try {
            $id = $request->input('id');

            $response = Http::asJson()->put("http://localhost:8080/devoluciones/{$id}", [
                'cantidad' => (int)$request->cantidad,
                'motivo' => $request->motivo,
                'fechaDevolucion' => $request->fechaDevolucion,
                'idMovimiento' => (int)$request->idMovimiento,
                'idProducto' => (int)$request->idProducto
            ]);

            return redirect()->route('registrar.devolucion')
                ->with($response->successful() ? 'success' : 'error',
                    $response->successful() ? 'Devolución actualizada correctamente' : 'Error al actualizar');


        } catch (\Exception $e) {
            return redirect()->route('registrar.devolucion')
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        try {
            $id = $request->input('id');
            $response = Http::delete("http://localhost:8080/devoluciones/{$id}");

            return redirect()->route('registrar.devolucion')
                ->with($response->successful() ? 'success' : 'error',
                    $response->successful() ? 'Devolución eliminada correctamente' : 'Error al eliminar');


        } catch (\Exception $e) {
            return redirect()->route('registrar.devolucion')
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
