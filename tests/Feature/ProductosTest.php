<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Http;

class ProductosTest extends TestCase
{
    // PRUEBA 1: VER FORMULARIO REGISTRAR PRODUCTO
    public function test_ver_formulario_registrar_producto()
    {
        Http::fake([
            'http://localhost:8080/productos'   => Http::response([], 200),
            'http://localhost:8080/categorias'  => Http::response([
                ['idCategoria' => 1, 'nombreCategoria' => 'Bebidas', 'descripcion' => '']
            ], 200),
            'http://localhost:8080/proveedores' => Http::response([
                ['id' => 1, 'nombre' => 'Proveedor Test', 'direccion' => '', 'telefono' => '', 'correo' => '', 'estado' => '1']
            ], 200),
        ]);

        $respuesta = $this->withSession(['token' => 'fake-token-123'])
            ->get(route('productos.registrar'));

        $respuesta->assertStatus(200);
    }

    // PRUEBA 2: REGISTRAR PRODUCTO EXITOSO
    public function test_registrar_producto_exitoso()
    {
        $respuesta = $this->withSession(['token' => 'fake-token-123'])
            ->post(route('productos.registrar.guardar'), [
                'nombre'      => 'Producto Test',
                'precio'      => 5000,
                'stockMinimo' => 5,
                'stockMaximo' => 100,
                'stockActual' => 50,
                'idCategoria' => 1,
                'idProveedor' => 1
            ]);

        $respuesta->assertSessionDoesntHaveErrors();
    }

    // PRUEBA 3: REGISTRAR PRODUCTO SIN NOMBRE
    public function test_registrar_producto_falla_sin_nombre()
    {
        $respuesta = $this->withSession(['token' => 'fake-token-123'])
            ->post(route('productos.registrar.guardar'), [
                'nombre'      => '',
                'precio'      => 5000,
                'stockMinimo' => 5,
                'stockMaximo' => 100,
                'stockActual' => 50,
                'idCategoria' => 1,
                'idProveedor' => 1
            ]);

        $respuesta->assertSessionHasErrors(['nombre']);
    }

    // PRUEBA 4: STOCK ACTUAL MENOR AL MÍNIMO
    public function test_registrar_producto_falla_stock_actual_menor_al_minimo()
    {
        $respuesta = $this->withSession(['token' => 'fake-token-123'])
            ->post(route('productos.registrar.guardar'), [
                'nombre'      => 'Producto Test',
                'precio'      => 5000,
                'stockMinimo' => 50,
                'stockMaximo' => 100,
                'stockActual' => 10,
                'idCategoria' => 1,
                'idProveedor' => 1
            ]);

        $respuesta->assertSessionHas('error');
    }

    // PRUEBA 5: STOCK MÍNIMO MAYOR AL MÁXIMO
    public function test_registrar_producto_falla_stock_minimo_mayor_al_maximo()
    {
        $respuesta = $this->withSession(['token' => 'fake-token-123'])
            ->post(route('productos.registrar.guardar'), [
                'nombre'      => 'Producto Test',
                'precio'      => 5000,
                'stockMinimo' => 100,
                'stockMaximo' => 10,
                'stockActual' => 50,
                'idCategoria' => 1,
                'idProveedor' => 1
            ]);

        $respuesta->assertSessionHas('error');
    }

    // PRUEBA 6: VER INVENTARIO
    public function test_ver_inventario_productos()
    {
        Http::fake([
            'http://localhost:8080/productos' => Http::response([
                [
                    'idProducto'  => 1,
                    'nombre'      => 'Coca Cola',
                    'precio'      => 3500,
                    'stockMinimo' => 10,
                    'stockMaximo' => 100,
                    'stockActual' => 50,
                    'idCategoria' => 1,
                    'idProveedor' => 1,
                    'estado'      => '1'
                ]
            ], 200),
            'http://localhost:8080/categorias'  => Http::response([
                ['idCategoria' => 1, 'nombreCategoria' => 'Bebidas', 'descripcion' => '']
            ], 200),
            'http://localhost:8080/proveedores' => Http::response([
                ['id' => 1, 'nombre' => 'Proveedor Test', 'direccion' => '', 'telefono' => '', 'correo' => '', 'estado' => '1']
            ], 200),
        ]);

        $respuesta = $this->withSession(['token' => 'fake-token-123'])
            ->get(route('productos.consultar'));

        $respuesta->assertStatus(200);
    }

    // PRUEBA 7: ACTUALIZAR PRODUCTO EXITOSO
    public function test_actualizar_producto_exitoso()
    {
        Http::fake([
            'http://localhost:8080/productos/1' => Http::response([], 200),
            'http://localhost:8080/productos'   => Http::response([], 200),
            'http://localhost:8080/categorias'  => Http::response([], 200),
            'http://localhost:8080/proveedores' => Http::response([], 200),
        ]);

        $respuesta = $this->withSession(['token' => 'fake-token-123'])
            ->post(route('productos.actualizar'), [
                'id'          => 1,
                'nombre'      => 'Producto Actualizado',
                'precio'      => 9000,
                'stockMinimo' => 5,
                'stockMaximo' => 100,
                'stockActual' => 50,
                'idCategoria' => 1,
                'idProveedor' => 1,
                'estado'      => '1'
            ]);

        $respuesta->assertStatus(200);
    }

    // PRUEBA 8: DESACTIVAR PRODUCTO
    public function test_desactivar_producto_exitoso()
    {
        Http::fake([
            'http://localhost:8080/productos' => Http::response([
                [
                    'idProducto'  => 1,
                    'nombre'      => 'Producto Test',
                    'precio'      => 5000,
                    'stockMinimo' => 5,
                    'stockMaximo' => 100,
                    'stockActual' => 50,
                    'idCategoria' => 1,
                    'idProveedor' => 1,
                    'estado'      => '1'
                ]
            ], 200),
            'http://localhost:8080/productos/1' => Http::response([], 200),
            'http://localhost:8080/categorias'  => Http::response([], 200),
            'http://localhost:8080/proveedores' => Http::response([], 200),
        ]);

        $respuesta = $this->withSession(['token' => 'fake-token-123'])
            ->post(route('productos.desactivar'), [
                'id' => 1
            ]);

        $respuesta->assertStatus(200);
    }

    // PRUEBA 9: VER FORMULARIO ENTRADA DE PRODUCTO
    public function test_ver_formulario_entrada_producto()
    {
        Http::fake([
            'http://localhost:8080/productos' => Http::response([
                ['idProducto' => 1, 'nombre' => 'Coca Cola', 'precio' => 3500,
                 'stockMinimo' => 5, 'stockMaximo' => 100, 'stockActual' => 50, 'estado' => '1']
            ], 200),
        ]);

        $respuesta = $this->withSession(['token' => 'fake-token-123'])
            ->get(route('productos.entrada'));

        $respuesta->assertStatus(200);
    }

    // PRUEBA 10: REGISTRAR ENTRADA EXITOSA
    public function test_registrar_entrada_exitosa()
    {
        Http::fake([
            'http://localhost:8080/productos' => Http::response([
                ['idProducto' => 1, 'nombre' => 'Coca Cola', 'precio' => 3500,
                 'stockMinimo' => 5, 'stockMaximo' => 100, 'stockActual' => 50, 'estado' => '1']
            ], 200),
            'http://localhost:8080/productos/1' => Http::response(['success' => true], 200),
        ]);

        $respuesta = $this->withSession(['token' => 'fake-token-123'])
            ->post(route('productos.entrada.registrar'), [
                'idProducto'      => 1,
                'cantidadAgregar' => 10
            ]);

        $respuesta->assertSessionDoesntHaveErrors();
    }

    // PRUEBA 11: ENTRADA FALLA SIN PRODUCTO
    public function test_registrar_entrada_falla_sin_producto()
    {
        $respuesta = $this->withSession(['token' => 'fake-token-123'])
            ->post(route('productos.entrada.registrar'), [
                'idProducto'      => '',
                'cantidadAgregar' => 10
            ]);

        $respuesta->assertSessionHasErrors(['idProducto']);
    }

    // PRUEBA 12: ENTRADA FALLA CON CANTIDAD CERO
    public function test_registrar_entrada_falla_cantidad_cero()
    {
        $respuesta = $this->withSession(['token' => 'fake-token-123'])
            ->post(route('productos.entrada.registrar'), [
                'idProducto'      => 1,
                'cantidadAgregar' => 0
            ]);

        $respuesta->assertSessionHasErrors(['cantidadAgregar']);
    }

    // PRUEBA 13: ENTRADA FALLA CON CANTIDAD NEGATIVA
    public function test_registrar_entrada_falla_cantidad_negativa()
    {
        $respuesta = $this->withSession(['token' => 'fake-token-123'])
            ->post(route('productos.entrada.registrar'), [
                'idProducto'      => 1,
                'cantidadAgregar' => -5
            ]);

        $respuesta->assertSessionHasErrors(['cantidadAgregar']);
    }

    // PRUEBA 14: VER FORMULARIO SALIDA DE PRODUCTO
    public function test_ver_formulario_salida_producto()
    {
        Http::fake([
            'http://localhost:8080/productos' => Http::response([
                ['idProducto' => 1, 'nombre' => 'Coca Cola', 'precio' => 3500,
                 'stockMinimo' => 5, 'stockMaximo' => 100, 'stockActual' => 50, 'estado' => '1']
            ], 200),
        ]);

        $respuesta = $this->withSession(['token' => 'fake-token-123'])
            ->get(route('productos.salida'));

        $respuesta->assertStatus(200);
    }

    // PRUEBA 15: REGISTRAR SALIDA EXITOSA
    public function test_registrar_salida_exitosa()
    {
        Http::fake([
            'http://localhost:8080/productos' => Http::response([
                ['idProducto' => 1, 'nombre' => 'Coca Cola', 'precio' => 3500,
                 'stockMinimo' => 5, 'stockMaximo' => 100, 'stockActual' => 50, 'estado' => '1']
            ], 200),
            'http://localhost:8080/productos/1' => Http::response(['success' => true], 200),
        ]);

        $respuesta = $this->withSession(['token' => 'fake-token-123'])
            ->post(route('productos.salida.registrar'), [
                'idProducto'      => 1,
                'cantidadRetirar' => 5
            ]);

        $respuesta->assertSessionDoesntHaveErrors();
    }

    // PRUEBA 16: SALIDA FALLA SIN PRODUCTO
    public function test_registrar_salida_falla_sin_producto()
    {
        $respuesta = $this->withSession(['token' => 'fake-token-123'])
            ->post(route('productos.salida.registrar'), [
                'idProducto'      => '',
                'cantidadRetirar' => 5
            ]);

        $respuesta->assertSessionHasErrors(['idProducto']);
    }

    // PRUEBA 17: SALIDA FALLA CON CANTIDAD CERO
    public function test_registrar_salida_falla_cantidad_cero()
    {
        $respuesta = $this->withSession(['token' => 'fake-token-123'])
            ->post(route('productos.salida.registrar'), [
                'idProducto'      => 1,
                'cantidadRetirar' => 0
            ]);

        $respuesta->assertSessionHasErrors(['cantidadRetirar']);
    }

    // PRUEBA 18: SALIDA FALLA POR STOCK INSUFICIENTE
    public function test_registrar_salida_falla_stock_insuficiente()
    {
        Http::fake([
            'http://localhost:8080/productos' => Http::response([
                ['idProducto' => 1, 'nombre' => 'Coca Cola', 'precio' => 3500,
                 'stockMinimo' => 5, 'stockMaximo' => 100, 'stockActual' => 3, 'estado' => '1']
            ], 200),
        ]);

        $respuesta = $this->withSession(['token' => 'fake-token-123'])
            ->post(route('productos.salida.registrar'), [
                'idProducto'      => 1,
                'cantidadRetirar' => 10
            ]);

        $respuesta->assertSessionHas('error');
    }

    // PRUEBA 19: ACTUALIZAR PRODUCTO FALLA SIN NOMBRE
    public function test_actualizar_producto_falla_sin_nombre()
    {
        $respuesta = $this->withSession(['token' => 'fake-token-123'])
            ->post(route('productos.actualizar'), [
                'id'          => 1,
                'nombre'      => '',
                'precio'      => 9000,
                'stockMinimo' => 5,
                'stockMaximo' => 100,
                'stockActual' => 50,
                'idCategoria' => 1,
                'idProveedor' => 1,
                'estado'      => '1'
            ]);

        $respuesta->assertSessionHasErrors(['nombre']);
    }

    // PRUEBA 20: ACTUALIZAR PRODUCTO FALLA STOCK MÍNIMO MAYOR AL MÁXIMO
    public function test_actualizar_producto_falla_stock_minimo_mayor_al_maximo()
    {
        $respuesta = $this->withSession(['token' => 'fake-token-123'])
            ->post(route('productos.actualizar'), [
                'id'          => 1,
                'nombre'      => 'Producto Test',
                'precio'      => 9000,
                'stockMinimo' => 100,
                'stockMaximo' => 10,
                'stockActual' => 50,
                'idCategoria' => 1,
                'idProveedor' => 1,
                'estado'      => '1'
            ]);

        $respuesta->assertSessionHas('error');
    }
}