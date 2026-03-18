<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        
        $correo = $request->input('usuario'); 
        $contrasena = $request->input('contrasena');


        $datos = [
            'correo' => $correo,
            'contrasena' => $contrasena
        ];

       
        $url = 'http://localhost:8080/auth/login';
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($datos));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

        $respuesta = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $resultado = json_decode($respuesta, true);

        if ($httpCode == 200 && isset($resultado['token'])) {
            
            session([
                'token' => $resultado['token'],
                'nombre' => $resultado['nombre'],
                'correo' => $resultado['correo'],
                'rol' => $resultado['rol']
            ]);

            $rol = strtolower($resultado['rol']);
            
            if ($rol == 'administrador') {
                return redirect()->route('inicio.administrador');
            } else {
                return redirect()->route('inicio.empleado');
            }
        } else {
            
            return redirect()->route('login')->with('error', 'Correo o contraseña incorrectos. Por favor, inténtalo de nuevo.');
        }
    }
}