<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Inventario - Empleado</title>
    <link rel="stylesheet" href="{{ asset('css/styleproductos.css') }}">
</head>
<body>
    <div class="header-nav" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <a href="{{ route('inicio.empleado') }}" class="back-button" style="background: rgba(255, 255, 255, 0.15); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); color: white; padding: 10px 20px; border-radius: 25px; text-decoration: none; font-weight: 500; transition: all 0.3s ease;">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" style="vertical-align: middle; margin-right: 5px;">
                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 0 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 0 1 .708.708L2.707 7.5H14.5A.5.5 0 0 1 15 8"/>
            </svg>
            Volver al Dashboard
        </a>
    </div>

    <header>
        <h1>
            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" viewBox="0 0 16 16" style="vertical-align: middle; margin-right: 10px;">
                <path d="M1 2.5A1.5 1.5 0 0 1 2.5 1h3A1.5 1.5 0 0 1 7 2.5v3A1.5 1.5 0 0 1 5.5 7h-3A1.5 1.5 0 0 1 1 5.5zM2.5 2a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5zm6.5.5A1.5 1.5 0 0 1 10.5 1h3A1.5 1.5 0 0 1 15 2.5v3A1.5 1.5 0 0 1 13.5 7h-3A1.5 1.5 0 0 1 9 5.5zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5zM1 10.5A1.5 1.5 0 0 1 2.5 9h3A1.5 1.5 0 0 1 7 10.5v3A1.5 1.5 0 0 1 5.5 15h-3A1.5 1.5 0 0 1 1 13.5zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5zm6.5.5A1.5 1.5 0 0 1 10.5 9h3a1.5 1.5 0 0 1 1.5 1.5v3a1.5 1.5 0 0 1-1.5 1.5h-3A1.5 1.5 0 0 1 9 13.5zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5z"/>
            </svg>
            Consultar Inventario
        </h1>
    </header>

    <main>
        @if(isset($mensaje) && $mensaje)
            <p style="color: {{ isset($tipo_mensaje) && $tipo_mensaje === 'success' ? 'green' : 'red' }};">
                {{ $mensaje }}
            </p>
        @endif

        <h2>Inventario de Productos</h2>
        
        @if(is_array($productos) && count($productos) > 0)
            <div style="overflow-x: auto;">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>NOMBRE</th>
                            <th>PRECIO</th>
                            <th>STOCK ACTUAL</th>
                            <th>STOCK MÍN</th>
                            <th>STOCK MÁX</th>
                            <th>CATEGORÍA</th>
                            <th>PROVEEDOR</th>
                            <th>ESTADO</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($productos as $producto)
                            <tr>
                                <td>{{ $producto['idProducto'] ?? '' }}</td>
                                <td><b>{{ $producto['nombre'] ?? '' }}</b></td>
                                <td>${{ number_format($producto['precio'] ?? 0, 2) }}</td>
                                <td>{{ $producto['stockActual'] ?? '' }}</td>
                                <td>{{ $producto['stockMinimo'] ?? '' }}</td>
                                <td>{{ $producto['stockMaximo'] ?? '' }}</td>

                                {{-- CATEGORÍA: muestra nombre --}}
                                <td>
                                    @php
                                        $cat = collect($categorias)->firstWhere('idCategoria', $producto['idCategoria'] ?? null);
                                    @endphp
                                    {{ $cat ? $cat['nombreCategoria'] : ($producto['idCategoria'] ?? '') }}
                                </td>

                                {{-- PROVEEDOR: muestra nombre --}}
                                <td>
                                    @php
                                        $prov = collect($proveedores)->firstWhere('id', $producto['idProveedor'] ?? null);
                                    @endphp
                                    {{ $prov ? $prov['nombre'] : ($producto['idProveedor'] ?? '') }}
                                </td>

                                <td>
                                    @if($producto['estado'] == '1')
                                        <span style="background-color: rgba(40, 167, 69, 0.3); color: #90ee90; padding: 5px 12px; border-radius: 20px; font-weight: 600; font-size: 12px; border: 1px solid rgba(40, 167, 69, 0.5);">
                                            Activo
                                        </span>
                                    @else
                                        <span style="background-color: rgba(220, 53, 69, 0.3); color: #ffb3ba; padding: 5px 12px; border-radius: 20px; font-weight: 600; font-size: 12px; border: 1px solid rgba(220, 53, 69, 0.5);">
                                            Inactivo
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p style="color:rgba(255, 255, 255, 0.7); text-align: center; padding: 20px;">No hay productos en el inventario.</p>
        @endif
    </main>

    <footer>
        <p>© 2025 Punto Éxito. Todos los derechos reservados.</p>
    </footer>
</body>
</html>