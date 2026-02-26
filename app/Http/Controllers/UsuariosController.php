<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class UsuariosController extends Controller
{
    // ─── LISTAR TODOS LOS USUARIOS ───────────────────────────────────────────
    public function index()
    {
        try {
            $token = session('token');

            $response = Http::timeout(10)
                ->withHeaders($token ? ['Authorization' => 'Bearer ' . $token] : [])
                ->get('http://localhost:8080/usuarios');

            $usuarios = $response->successful() ? $response->json() : [];

        } catch (\Exception $e) {
            $usuarios = [];
            $error    = "Error al conectar con la API: " . $e->getMessage();
        }

        return view('Modulo-usuarios.gestion-usuarios', [
            'usuarios' => $usuarios,
            'error'    => $error ?? null,
        ]);
    }

    // ─── CREAR USUARIO ───────────────────────────────────────────────────────
    public function store(Request $request)
    {
        if ($request->has('from_registration')) {
            $request->validate([
                'nombre'          => 'required|string',
                'correo'          => 'required|email',
                'contrasena'      => 'required|string',
                'telefono'        => 'nullable|string',
                'fecha_Nacimiento'=> 'nullable|date',
            ]);
        } else {
            $request->validate([
                'nombre'          => 'required|string',
                'correo'          => 'required|email',
                'contrasena'      => 'required|string',
                'estado'          => 'required',
                'telefono'        => 'nullable|string',
                'fecha_Nacimiento'=> 'nullable|date',
                'rol'             => 'required|string',
            ]);
        }

        try {
            $token = session('token');

            $datosParaApi = [
                'nombre'          => $request->nombre,
                'correo'          => $request->correo,
                'contrasena'      => $request->contrasena,
                'telefono'        => $request->telefono,
                'fecha_Nacimiento'=> $request->fecha_Nacimiento,
            ];

            if ($request->has('from_registration')) {
                $datosParaApi['rol']    = 'Empleado';
                $datosParaApi['estado'] = '0';
            } else {
                $datosParaApi['rol']    = $request->rol;
                $datosParaApi['estado'] = $request->estado;
            }

            $response = Http::withHeaders($token ? ['Authorization' => 'Bearer ' . $token] : [])
                ->asJson()
                ->post('http://localhost:8080/usuarios', $datosParaApi);

            if ($response->successful() || in_array($response->status(), [200, 201])) {
                if ($request->has('from_registration')) {
                    return redirect()->route('login')
                        ->with('success', 'Usuario registrado exitosamente. Espere la activación por un administrador.');
                }
                return redirect()->route('usuarios.gestion')
                    ->with('success', 'Usuario creado correctamente');
            }

            $errorMsg = 'Error al crear usuario: ' . $response->body();
            if ($request->has('from_registration')) {
                return redirect()->back()->withInput()->with('error', $errorMsg);
            }
            return redirect()->route('usuarios.gestion')->with('error', $errorMsg);

        } catch (\Exception $e) {
            $errorMsg = 'Error: ' . $e->getMessage();
            if ($request->has('from_registration')) {
                return redirect()->back()->withInput()->with('error', $errorMsg);
            }
            return redirect()->route('usuarios.gestion')->with('error', $errorMsg);
        }
    }

    // ─── ACTUALIZAR USUARIO ──────────────────────────────────────────────────
    public function update(Request $request)
    {
        $request->validate([
            'id'              => 'required|integer',
            'nombre'          => 'required|string',
            'correo'          => 'required|email',
            'contrasena'      => 'nullable|string',
            'estado'          => 'required',
            'telefono'        => 'nullable|string',
            'fecha_Nacimiento'=> 'nullable|date',
            'rol'             => 'required|string',
        ]);

        try {
            $token = session('token');
            $id    = $request->input('id');

            $datos = [
                'nombre'          => $request->nombre,
                'correo'          => $request->correo,
                'estado'          => $request->estado,
                'telefono'        => $request->telefono,
                'fecha_Nacimiento'=> $request->fecha_Nacimiento,
                'rol'             => $request->rol,
                'contrasena'      => $request->filled('contrasena') ? $request->contrasena : null,
            ];

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

    // ─── DESACTIVAR USUARIO (cambia estado a 0) ──────────────────────────────
    public function desactivar(Request $request)
    {
        try {
            $token = session('token');
            $id    = $request->input('id');

            // Obtener el usuario actual para conservar sus datos
            $getResponse = Http::timeout(10)
                ->withHeaders($token ? ['Authorization' => 'Bearer ' . $token] : [])
                ->get("http://localhost:8080/usuarios/{$id}");

            if (!$getResponse->successful()) {
                return redirect()->route('usuarios.gestion')
                    ->with('error', 'No se pudo obtener el usuario.');
            }

            $usuario = $getResponse->json();
            $usuario['estado'] = '0';   // ← desactivar

            $response = Http::withHeaders($token ? ['Authorization' => 'Bearer ' . $token] : [])
                ->asJson()
                ->put("http://localhost:8080/usuarios/{$id}", $usuario);

            if ($response->successful() || $response->status() == 200) {
                return redirect()->route('usuarios.gestion')
                    ->with('success', 'Usuario desactivado correctamente');
            }

            return redirect()->route('usuarios.gestion')
                ->with('error', 'Error al desactivar: ' . $response->body());

        } catch (\Exception $e) {
            return redirect()->route('usuarios.gestion')
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }

    // ─── VALIDAR CONTRASEÑA ANTES DE DESACTIVAR (doble autenticación) ────────
    public function validarPasswordDesactivar(Request $request)
    {
        try {
            $correoSesion = session('correo');

            if (!$correoSesion) {
                return response()->json([
                    'success' => false,
                    'mensaje' => 'Sesión expirada',
                ], 401);
            }

            $password   = $request->input('password');
            $id_usuario = $request->input('id_usuario');

            if (!$password || !$id_usuario) {
                return response()->json([
                    'success' => false,
                    'mensaje' => 'Datos incompletos',
                ], 400);
            }

            // ── PASO 1: Verificar contraseña usando /auth/login ──────────────
            // Este endpoint no requiere token (está excluido del filtro JWT)
            $loginResponse = Http::asJson()
                ->post('http://localhost:8080/auth/login', [
                    'correo'     => $correoSesion,
                    'contrasena' => $password,
                ]);

            // Si /auth/login no devuelve 200, la contraseña es incorrecta
            if (!$loginResponse->successful()) {
                return response()->json([
                    'success' => false,
                    'mensaje' => 'Contraseña incorrecta',
                ], 401);
            }

            // ── PASO 2: Contraseña válida → desactivar usuario ───────────────
            $token       = session('token');
            $tokenHeader = $token ? ['Authorization' => 'Bearer ' . $token] : [];

            // Obtener datos actuales del usuario a desactivar
            $getUser = Http::timeout(10)
                ->withHeaders($tokenHeader)
                ->get("http://localhost:8080/usuarios/{$id_usuario}");

            if (!$getUser->successful()) {
                return response()->json([
                    'success' => false,
                    'mensaje' => 'No se pudo obtener el usuario',
                ], 500);
            }

            $usuario           = $getUser->json();
            $usuario['estado'] = '0';   // ← desactivar

            $updateResponse = Http::withHeaders($tokenHeader)
                ->asJson()
                ->put("http://localhost:8080/usuarios/{$id_usuario}", $usuario);

            if ($updateResponse->successful() || $updateResponse->status() == 200) {
                return response()->json([
                    'success' => true,
                    'mensaje' => 'Usuario desactivado correctamente',
                ]);
            }

            return response()->json([
                'success' => false,
                'mensaje' => 'Contraseña válida, pero error al desactivar: ' . $updateResponse->body(),
            ], 500);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'mensaje' => 'Error del servidor: ' . $e->getMessage(),
            ], 500);
        }
    }
}