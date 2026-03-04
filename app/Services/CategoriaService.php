<?php

namespace App\Services;

class CategoriaService
{
    private string $apiUrl = "http://localhost:8080/categorias";

    private function obtenerToken(): ?string
    {
        return session('token');
    }

    public function obtenerCategorias(): array
    {
        $token = $this->obtenerToken();
        if (!$token) return [];

        $curl = curl_init($this->apiUrl);
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_CONNECTTIMEOUT => 3,
            CURLOPT_HTTPHEADER => ['Authorization: Bearer ' . $token]
        ]);

        $respuesta = curl_exec($curl);
        if (curl_errno($curl)) { curl_close($curl); return []; }
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($httpCode !== 200) return [];
        return json_decode($respuesta, true) ?? [];
    }
}