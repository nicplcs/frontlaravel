<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class UsuariosController extends Controller
{
    // LISTAR TODOS LOS USUARIOS
    public function index()
    {
        try {
            // Agregar token si es necesario
            $token = session('token');
            
            $response = Http::timeout(10)
                ->withHeaders($token ? ['Authorization' => 'Bearer ' . $token] : [])
                ->get('http://localhost:8080/usuarios');
            
            if ($response->successful()) {
                $usuarios = $response->json();
            } else {
                $usuarios = [];
            }
            
        } catch (\Exception $e) {
            $usuarios = [];
            $error = "Error al conectar con la API: " . $e->getMessage();
        }
        
        return view('Modulo-usuarios.gestion-usuarios', [
            'usuarios' => $usuarios,
            'error' => $error ?? null
        ]);
    }

    // CREAR USUARIO
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'correo' => 'required|email',
            'contrasena' => 'required|string',
            'estado' => 'required',
            'telefono' => 'nullable|string',
            'fecha_nacimiento' => 'nullable|date',
            'rol' => 'required|string'
        ]);

        try {
            $token = session('token');
            
            $response = Http::withHeaders($token ? ['Authorization' => 'Bearer ' . $token] : [])
                ->asJson()
                ->post('http://localhost:8080/usuarios', [
                    'nombre' => $request->nombre,
                    'correo' => $request->correo,
                    'contrasena' => $request->contrasena,
                    'estado' => $request->estado,
                    'telefono' => $request->telefono,
                    'fecha_nacimiento' => $request->fecha_nacimiento,
                    'rol' => $request->rol
                ]);

            if ($response->successful() || $response->status() == 200 || $response->status() == 201) {
                return redirect()->route('usuarios.gestion')
                    ->with('success', 'Usuario creado correctamente');
            }

            return redirect()->route('usuarios.gestion')
                ->with('error', 'Error al crear usuario: ' . $response->body());

        } catch (\Exception $e) {
            return redirect()->route('usuarios.gestion')
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }

    // ACTUALIZAR USUARIO
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'nombre' => 'required|string',
            'correo' => 'required|email',
            'contrasena' => 'nullable|string',
            'estado' => 'required',
            'telefono' => 'nullable|string',
            'fecha_nacimiento' => 'nullable|date',
            'rol' => 'required|string'
        ]);

        try {
            $token = session('token');
            $id = $request->input('id');
            
            $datos = [
                'nombre' => $request->nombre,
                'correo' => $request->correo,
                'estado' => $request->estado,
                'telefono' => $request->telefono,
                'fecha_nacimiento' => $request->fecha_nacimiento,
                'rol' => $request->rol
            ];

            // INCLUIR CONTRASEÑA SOLO SI SE PROPORCIONA
            if ($request->filled('contrasena')) {
                $datos['contrasena'] = $request->contrasena;
            }

            $response = Http::withHeaders($token ? ['Authorization' => 'Bearer ' . $token] : [])
                ->asJson()
                ->put("http://localhost:8080/usuarios/{$id}", $datos);

            if ($response->successful() || $response->status() == 200) {
                return redirect()->route('usuarios.gestion')
                    ->with('success', 'Usuario actualizado correctamente');
            }

            return redirect()->route('usuarios.gestion')
                ->with('error', 'Error al actualizar: ' . $response->body());

        } catch (\Exception $e) {
            return redirect()->route('usuarios.gestion')
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }

    // ELIMINAR USUARIO
    public function destroy(Request $request)
    {
        try {
            $token = session('token');
            $id = $request->input('id');
            
            $response = Http::withHeaders($token ? ['Authorization' => 'Bearer ' . $token] : [])
                ->delete("http://localhost:8080/usuarios/{$id}");

            if ($response->successful() || $response->status() == 200) {
                return redirect()->route('usuarios.gestion')
                    ->with('success', 'Usuario eliminado correctamente');
            }

            return redirect()->route('usuarios.gestion')
                ->with('error', 'Error al eliminar: ' . $response->body());

        } catch (\Exception $e) {
            return redirect()->route('usuarios.gestion')
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }
}