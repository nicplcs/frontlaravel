<?php

namespace App\Services;

class ProductoService
{
    private $apiUrl = "http://localhost:8080/productos";

    
    private function obtenerToken()
    {
        return session('token', null);
    }

    // GET 
    public function obtenerProductos()
    {
        $token = $this->obtenerToken();
        if (!$token) return [];

        $proceso = curl_init($this->apiUrl);
        curl_setopt($proceso, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($proceso, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $token
        ]);

        $respuesta = curl_exec($proceso);
        $http_code = curl_getinfo($proceso, CURLINFO_HTTP_CODE);
        curl_close($proceso);

        if ($http_code !== 200) return [];
        return json_decode($respuesta, true) ?? [];
    }

    // POST 
    public function agregarProducto($producto)
    {
        $token = $this->obtenerToken();
        if (!$token) return ["success" => false, "error" => "No hay sesión activa"];

        $data_json = json_encode($producto);

        $proceso = curl_init($this->apiUrl);
        curl_setopt($proceso, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($proceso, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($proceso, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($proceso, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token,
            'Content-Length: ' . strlen($data_json)
        ]);

        $respuestapet = curl_exec($proceso);
        $http_code = curl_getinfo($proceso, CURLINFO_HTTP_CODE);

        if (curl_errno($proceso)) {
            $error = curl_error($proceso);
            curl_close($proceso);
            return ["success" => false, "error" => $error];
        }

        curl_close($proceso);

        return ($http_code === 200 || $http_code === 201)
            ? ["success" => true]
            : ["success" => false, "error" => "HTTP $http_code"];
    }

    // PUT 
    public function actualizarProducto($id, $producto)
    {
        $token = $this->obtenerToken();
        if (!$token) return ["success" => false, "error" => "No hay sesión activa"];

        $data_json = json_encode($producto);

        $proceso = curl_init($this->apiUrl . "/" . $id);
        curl_setopt($proceso, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($proceso, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($proceso, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($proceso, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token,
            'Content-Length: ' . strlen($data_json)
        ]);

        $respuestapet = curl_exec($proceso);
        $http_code = curl_getinfo($proceso, CURLINFO_HTTP_CODE);

        curl_close($proceso);

        return ($http_code === 200)
            ? ["success" => true]
            : ["success" => false, "error" => "HTTP $http_code"];
    }

    // DELETE 
    public function eliminarProducto($id)
    {
        $token = $this->obtenerToken();
        if (!$token) return ["success" => false, "error" => "No hay sesión activa"];

        $proceso = curl_init($this->apiUrl . "/" . $id);
        curl_setopt($proceso, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($proceso, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($proceso, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $token
        ]);

        $respuestapet = curl_exec($proceso);
        $http_code = curl_getinfo($proceso, CURLINFO_HTTP_CODE);

        curl_close($proceso);

        return ($http_code === 200)
            ? ["success" => true]
            : ["success" => false, "error" => "HTTP $http_code"];
    }
}