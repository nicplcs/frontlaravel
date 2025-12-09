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
    // --- CAMBIOS AQUÍ ---
    // Quitar 'estado' y 'rol' de la validación SI viene del registro
    // Pero mantenerlos SI viene de la gestión de usuarios
    if ($request->has('from_registration')) {
        $request->validate([
            'nombre' => 'required|string',
            'correo' => 'required|email',
            'contrasena' => 'required|string',
            'telefono' => 'nullable|string',
            'fecha_Nacimiento' => 'nullable|date',
            // 'estado' => 'required',  // <-- COMENTADO
            // 'rol' => 'required|string' // <-- COMENTADO
        ]);
    } else {
        $request->validate([
            'nombre' => 'required|string',
            'correo' => 'required|email',
            'contrasena' => 'required|string',
            'estado' => 'required',
            'telefono' => 'nullable|string',
            'fecha_Nacimiento' => 'nullable|date',
            'rol' => 'required|string'
        ]);
    }

    try {
        $token = session('token');
        
        // --- CAMBIOS AQUÍ ---
        // Preparar los datos para enviar a Spring Boot
        $datosParaApi = [
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'contrasena' => $request->contrasena,
            'telefono' => $request->telefono,
            'fecha_Nacimiento' => $request->fecha_Nacimiento,
        ];

        // Si viene del registro, asignar rol y estado fijos
        if ($request->has('from_registration')) {
            $datosParaApi['rol'] = 'Empleado';
            $datosParaApi['estado'] = '0';
        } else {
            // Si viene de la gestión de usuarios, usar los valores del formulario
            $datosParaApi['rol'] = $request->rol;
            $datosParaApi['estado'] = $request->estado;
        }

        $response = Http::withHeaders($token ? ['Authorization' => 'Bearer ' . $token] : [])
            ->asJson()
            ->post('http://localhost:8080/usuarios', $datosParaApi);

        if ($response->successful() || $response->status() == 200 || $response->status() == 201) {
            // --- CAMBIOS AQUÍ ---
            // Redirigir según el origen de la petición
            if ($request->has('from_registration')) {
                return redirect()->route('login')
                    ->with('success', 'Usuario registrado exitosamente. Espere la activación por un administrador.');
            } else {
                return redirect()->route('usuarios.gestion')
                    ->with('success', 'Usuario creado correctamente');
            }
        }

        // --- CAMBIOS AQUÍ ---
        // Redirigir según el origen de la petición en caso de error
        if ($request->has('from_registration')) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al crear usuario: ' . $response->body());
        } else {
            return redirect()->route('usuarios.gestion')
                ->with('error', 'Error al crear usuario: ' . $response->body());
        }

    } catch (\Exception $e) {
        // --- CAMBIOS AQUÍ ---
        // Redirigir según el origen de la petición en caso de excepción
        if ($request->has('from_registration')) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error: ' . $e->getMessage());
        } else {
            return redirect()->route('usuarios.gestion')
                ->with('error', 'Error: ' . $e->getMessage());
        }
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
            'fecha_Nacimiento' => 'nullable|date',
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
    'fecha_Nacimiento' => $request->fecha_Nacimiento,
    'rol' => $request->rol,
    'contrasena' => $request->filled('contrasena') ? $request->contrasena : null  // ← ESTE ES EL CAMBIO
];

$response = Http::withHeaders($token ? ['Authorization' => 'Bearer ' . $token] : [])
    ->asJson()
    ->put("http://localhost:8080/usuarios/{$id}", $datos);
    
            // INCLUIR CONTRASEÑA SOLO SI SE PROPORCIONA
          $datos['contrasena'] = $request->filled('contrasena') ? $request->contrasena : null;

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