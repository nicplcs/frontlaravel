<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class UsuarioTest extends TestCase
{
    // --- USUARIOS ---     

    // prueba que la lista de usuarios cargue bien cuando el back responde normal
    public function test_gestion_usuarios_carga_correctamente_con_respuesta_exitosa()
    {
        Http::fake([
            'http://localhost:8080/usuarios' => Http::response([
               ['id_usuario' => 1, 'nombre' => 'Nicolas', 'correo' => 'nicolas@mail.com', 'rol' => 'Administrador', 'estado' => '1', 'telefono' => '3001234567'],
['id_usuario' => 2, 'nombre' => 'Caleb',   'correo' => 'caleb@mail.com',   'rol' => 'Empleado',       'estado' => '1', 'telefono' => '3009876543'],
            ], 200),
        ]);

        $response = $this->get('/gestion-usuarios');

        $response->assertStatus(200);
        $response->assertViewIs('Modulo-usuarios.gestion-usuarios');
        $response->assertViewHas('usuarios');
    }

    // si el back se cae o da error, la página no debería romperse
    // solo muestra la lista vacía y ya
    public function test_gestion_usuarios_maneja_error_de_api_sin_romper_la_app()
    {
        Http::fake([
            'http://localhost:8080/usuarios' => Http::response([], 500),
        ]);

        $response = $this->get('/gestion-usuarios');

        $response->assertStatus(200);
        $response->assertViewHas('usuarios', []);
    }

    // cuando el admin crea un usuario con todo bien, debería redirigir de vuelta a gestión
    public function test_crear_usuario_desde_gestion_redirige_con_exito()
    {
        Http::fake([
            'http://localhost:8080/usuarios' => Http::response(['id' => 3], 201),
        ]);

        $response = $this->post('/usuarios/crear', [
            'nombre'           => 'Pedro Prueba',
            'correo'           => 'pedro@mail.com',
            'contrasena'       => 'secret123',
            'estado'           => '1',
            'telefono'         => '3001234567',
            'fecha_Nacimiento' => '1995-06-15',
            'rol'              => 'Administrador',
        ]);

        $response->assertRedirect(route('usuarios.gestion'));
        $response->assertSessionHas('success');
    }

    // si mandan el formulario sin nombre, correo, estado y rol
    // Laravel debería rechazarlo antes de siquiera llamar al back
    public function test_crear_usuario_falla_validacion_sin_campos_obligatorios()
    {
        $response = $this->post('/usuarios/crear', [
            'contrasena' => 'secret123',
            // falta nombre, correo, estado, rol
        ]);

        $response->assertSessionHasErrors(['nombre', 'correo', 'estado', 'rol']);
    }

    // cuando alguien se registra desde el formulario público,
    // el sistema le asigna rol Empleado y estado 0 automáticamente
    // y lo manda al login a esperar que un admin lo active
    public function test_crear_usuario_desde_registro_asigna_rol_empleado_y_redirige_al_login()
    {
        Http::fake([
            'http://localhost:8080/usuarios' => Http::response(['id' => 4], 201),
        ]);

        $response = $this->post('/usuarios/crear', [
            'nombre'            => 'Ana Empleada',
            'correo'            => 'ana@mail.com',
            'contrasena'        => 'pass1234',
            'telefono'          => '3109876543',
            'fecha_Nacimiento'  => '2000-01-01',
            'from_registration' => '1',
        ]);

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('success');
    }

    // editar usuario con datos válidos, debería funcionar sin problema
    public function test_actualizar_usuario_redirige_con_exito()
    {
        Http::fake([
            'http://localhost:8080/usuarios/1' => Http::response(['id' => 1], 200),
        ]);

        $response = $this->post('/usuarios/actualizar', [
            'id'               => 1,
            'nombre'           => 'Nicolas Actualizado',
            'correo'           => 'nicolas_new@mail.com',
            'estado'           => '1',
            'telefono'         => '3001111111',
            'fecha_Nacimiento' => '1998-03-20',
            'rol'              => 'Administrador',
        ]);

        $response->assertRedirect(route('usuarios.gestion'));
        $response->assertSessionHas('success');
    }

    // eliminar usuario, el back responde 200 y debería redirigir con mensaje
    public function test_eliminar_usuario_redirige_con_exito()
    {
        Http::fake([
            'http://localhost:8080/usuarios/5' => Http::response([], 200),
        ]);

        $response = $this->post('/usuarios/eliminar', ['id' => 5]);

        $response->assertRedirect(route('usuarios.gestion'));
        $response->assertSessionHas('success');
    }

    // --- PROVEEDORES ---

    // igual que usuarios, que la lista de proveedores cargue bien
    public function test_gestion_proveedores_carga_correctamente_con_respuesta_exitosa()
    {
        Http::fake([
            'http://localhost:8080/proveedores' => Http::response([
                ['id' => 1, 'nombre' => 'Proveedor A', 'correo' => 'a@proveedor.com'],
                ['id' => 2, 'nombre' => 'Proveedor B', 'correo' => 'b@proveedor.com'],
            ], 200),
        ]);

        $response = $this->get('/gestion-proveedores');

        $response->assertStatus(200);
        $response->assertViewIs('Modulo-usuarios.gestion-proveedores');
        $response->assertViewHas('proveedores');
    }

    // crear proveedor con todo completo debería ir bien
    public function test_crear_proveedor_con_datos_validos_redirige_con_exito()
    {
        Http::fake([
            'http://localhost:8080/proveedores' => Http::response(['id' => 10], 201),
        ]);

        $response = $this->post('/proveedores/crear', [
            'nombre'    => 'Proveedor Nuevo',
            'direccion' => 'Calle 123 #45-67',
            'telefono'  => '6012345678',
            'correo'    => 'nuevo@proveedor.com',
            'estado'    => '1',
        ]);

        $response->assertRedirect(route('proveedores.gestion'));
        $response->assertSessionHas('success');
    }

    // si mandan un correo mal escrito y faltan campos, Laravel lo rechaza
    public function test_crear_proveedor_falla_validacion_con_datos_invalidos()
    {
        $response = $this->post('/proveedores/crear', [
            'nombre' => 'Proveedor Malo',
            'correo' => 'esto-no-es-un-correo',
            // falta direccion, telefono, estado
        ]);

        $response->assertSessionHasErrors(['correo', 'direccion', 'telefono', 'estado']);
    }
}