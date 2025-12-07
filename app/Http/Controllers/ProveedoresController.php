<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class ProveedoresController extends Controller
{
    // LISTAR TODOS LOS PROVEEDORES
    public function index()
    {
        try {
            $response = Http::timeout(10)->get('http://localhost:8080/proveedores');
            
            if ($response->successful()) {
                $proveedores = $response->json();
            } else {
                $proveedores = [];
            }
            
        } catch (\Exception $e) {
            $proveedores = [];
            $error = "Error al conectar con la API: " . $e->getMessage();
        }
        
        return view('Modulo-usuarios.gestion-proveedores', [
            'proveedores' => $proveedores,
            'error' => $error ?? null
        ]);
    }

    // CREAR PROVEEDOR
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'direccion' => 'required|string',
            'telefono' => 'required|string',
            'correo' => 'required|email',
            'estado' => 'required'
        ]);

        try {
            $response = Http::asJson()->post('http://localhost:8080/proveedores', [
                'nombre' => $request->nombre,
                'direccion' => $request->direccion,
                'telefono' => $request->telefono,
                'correo' => $request->correo,
                'estado' => $request->estado
            ]);

            if ($response->successful() || $response->status() == 200) {
                return redirect()->route('proveedores.gestion')
                    ->with('success', 'Proveedor creado correctamente');
            }

            return redirect()->route('proveedores.gestion')
                ->with('error', 'Error al crear proveedor');

        } catch (\Exception $e) {
            return redirect()->route('proveedores.gestion')
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }

    // ACTUALIZAR PROVEEDOR
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'nombre' => 'required|string',
            'direccion' => 'required|string',
            'telefono' => 'required|string',
            'correo' => 'required|email',
            'estado' => 'required'
        ]);

        try {
            $id = $request->input('id');
            
            $response = Http::asJson()->put("http://localhost:8080/proveedores/{$id}", [
                'nombre' => $request->nombre,
                'direccion' => $request->direccion,
                'telefono' => $request->telefono,
                'correo' => $request->correo,
                'estado' => $request->estado
            ]);

            if ($response->successful() || $response->status() == 200) {
                return redirect()->route('proveedores.gestion')
                    ->with('success', 'Proveedor actualizado correctamente');
            }

            return redirect()->route('proveedores.gestion')
                ->with('error', 'Error al actualizar');

        } catch (\Exception $e) {
            return redirect()->route('proveedores.gestion')
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }

    // ELIMINAR PROVEEDOR
    public function destroy(Request $request)
    {
        try {
            $id = $request->input('id');
            
            $response = Http::delete("http://localhost:8080/proveedores/{$id}");

            if ($response->successful() || $response->status() == 200) {
                return redirect()->route('proveedores.gestion')
                    ->with('success', 'Proveedor eliminado correctamente');
            }

            return redirect()->route('proveedores.gestion')
                ->with('error', 'Error al eliminar');

        } catch (\Exception $e) {
            return redirect()->route('proveedores.gestion')
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }
}