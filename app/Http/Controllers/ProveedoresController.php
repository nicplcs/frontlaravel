<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class ProveedoresController extends Controller
{
    // ─── LISTAR TODOS LOS PROVEEDORES ────────────────────────────────────────
    public function index()
    {
        try {
            $token = session('token');

            $response = Http::timeout(10)
                ->withHeaders($token ? ['Authorization' => 'Bearer ' . $token] : [])
                ->get('http://localhost:8080/proveedores');

            $proveedores = $response->successful() ? $response->json() : [];

        } catch (\Exception $e) {
            $proveedores = [];
            $error = "Error al conectar con la API: " . $e->getMessage();
        }

        return view('Modulo-usuarios.gestion-proveedores', [
            'proveedores' => $proveedores,
            'error'       => $error ?? null,
        ]);
    }

    // ─── CREAR PROVEEDOR ─────────────────────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'nombre'    => 'required|string',
            'direccion' => 'required|string',
            'telefono'  => 'required|string',
            'correo'    => 'required|email',
            'estado'    => 'required',
        ]);

        try {
            $token = session('token');

            $response = Http::withHeaders($token ? ['Authorization' => 'Bearer ' . $token] : [])
                ->asJson()
                ->post('http://localhost:8080/proveedores', [
                    'nombre'    => $request->nombre,
                    'direccion' => $request->direccion,
                    'telefono'  => $request->telefono,
                    'correo'    => $request->correo,
                    'estado'    => $request->estado,
                ]);

            if ($response->successful() || in_array($response->status(), [200, 201])) {
                return redirect()->route('proveedores.gestion')
                    ->with('success', 'Proveedor creado correctamente');
            }

            return redirect()->route('proveedores.gestion')
                ->with('error', 'Error al crear proveedor: ' . $response->body());

        } catch (\Exception $e) {
            return redirect()->route('proveedores.gestion')
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }

    // ─── ACTUALIZAR PROVEEDOR ────────────────────────────────────────────────
    public function update(Request $request)
    {
        $request->validate([
            'id'        => 'required|integer',
            'nombre'    => 'required|string',
            'direccion' => 'required|string',
            'telefono'  => 'required|string',
            'correo'    => 'required|email',
            'estado'    => 'required',
        ]);

        try {
            $token = session('token');
            $id    = $request->input('id');

            $response = Http::withHeaders($token ? ['Authorization' => 'Bearer ' . $token] : [])
                ->asJson()
                ->put("http://localhost:8080/proveedores/{$id}", [
                    'nombre'    => $request->nombre,
                    'direccion' => $request->direccion,
                    'telefono'  => $request->telefono,
                    'correo'    => $request->correo,
                    'estado'    => $request->estado,
                ]);

            if ($response->successful() || $response->status() == 200) {
                return redirect()->route('proveedores.gestion')
                    ->with('success', 'Proveedor actualizado correctamente');
            }

            return redirect()->route('proveedores.gestion')
                ->with('error', 'Error al actualizar: ' . $response->body());

        } catch (\Exception $e) {
            return redirect()->route('proveedores.gestion')
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }

    // ─── DESACTIVAR PROVEEDOR (cambia estado a 0) ────────────────────────────
    public function desactivar(Request $request)
    {
        try {
            $token = session('token');
            $id    = $request->input('id');

            // Obtener datos actuales del proveedor
            $getResponse = Http::timeout(10)
                ->withHeaders($token ? ['Authorization' => 'Bearer ' . $token] : [])
                ->get("http://localhost:8080/proveedores/{$id}");

            if (!$getResponse->successful()) {
                return redirect()->route('proveedores.gestion')
                    ->with('error', 'No se pudo obtener el proveedor.');
            }

            $proveedor           = $getResponse->json();
            $proveedor['estado'] = '0';   // ← desactivar

            $response = Http::withHeaders($token ? ['Authorization' => 'Bearer ' . $token] : [])
                ->asJson()
                ->put("http://localhost:8080/proveedores/{$id}", $proveedor);

            if ($response->successful() || $response->status() == 200) {
                return redirect()->route('proveedores.gestion')
                    ->with('success', 'Proveedor desactivado correctamente');
            }

            return redirect()->route('proveedores.gestion')
                ->with('error', 'Error al desactivar: ' . $response->body());

        } catch (\Exception $e) {
            return redirect()->route('proveedores.gestion')
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

            $password      = $request->input('password');
            $id_proveedor  = $request->input('id_proveedor');

            if (!$password || !$id_proveedor) {
                return response()->json([
                    'success' => false,
                    'mensaje' => 'Datos incompletos',
                ], 400);
            }

            // ── PASO 1: Verificar contraseña con /auth/login ─────────────────
            $loginResponse = Http::asJson()
                ->post('http://localhost:8080/auth/login', [
                    'correo'     => $correoSesion,
                    'contrasena' => $password,
                ]);

            if (!$loginResponse->successful()) {
                return response()->json([
                    'success' => false,
                    'mensaje' => 'Contraseña incorrecta',
                ], 401);
            }

            // ── PASO 2: Contraseña válida → desactivar proveedor ─────────────
            $token       = session('token');
            $tokenHeader = $token ? ['Authorization' => 'Bearer ' . $token] : [];

            // Obtener datos actuales del proveedor
            $getProveedor = Http::timeout(10)
                ->withHeaders($tokenHeader)
                ->get("http://localhost:8080/proveedores/{$id_proveedor}");

            if (!$getProveedor->successful()) {
                return response()->json([
                    'success' => false,
                    'mensaje' => 'No se pudo obtener el proveedor',
                ], 500);
            }

            $proveedor           = $getProveedor->json();
            $proveedor['estado'] = '0';

            $updateResponse = Http::withHeaders($tokenHeader)
                ->asJson()
                ->put("http://localhost:8080/proveedores/{$id_proveedor}", $proveedor);

            if ($updateResponse->successful() || $updateResponse->status() == 200) {
                return response()->json([
                    'success' => true,
                    'mensaje' => 'Proveedor desactivado correctamente',
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