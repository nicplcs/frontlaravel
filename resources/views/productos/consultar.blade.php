<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Inventario - Invex</title>
    <link rel="stylesheet" href="{{ asset('css/styleproductos.css') }}">
</head>
<body>
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
                <table style="width: 100%; border-collapse: collapse; background-color: #1b1b27; border-radius: 8px;">
                    <thead style="background-color: #121218;">
                        <tr>
                            <th style="padding: 12px; text-align: left; color: lightyellow;">ID</th>
                            <th style="padding: 12px; text-align: left; color: lightyellow;">Nombre</th>
                            <th style="padding: 12px; text-align: left; color: lightyellow;">Precio</th>
                            <th style="padding: 12px; text-align: left; color: lightyellow;">Stock</th>
                            <th style="padding: 12px; text-align: left; color: lightyellow;">Min</th>
                            <th style="padding: 12px; text-align: left; color: lightyellow;">Max</th>
                            <th style="padding: 12px; text-align: left; color: lightyellow;">Actual</th>
                            <th style="padding: 12px; text-align: left; color: lightyellow;">Cat</th>
                            <th style="padding: 12px; text-align: left; color: lightyellow;">Prov</th>
                            <th style="padding: 12px; text-align: left; color: lightyellow;">Estado</th>
                            <th style="padding: 12px; text-align: center; color: lightyellow;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($productos as $producto)
                            <tr style="border-bottom: 1px solid #444;">
                                <td style="padding: 12px;">{{ $producto['idProducto'] ?? '' }}</td>
                                <td style="padding: 12px;">{{ $producto['nombre'] ?? '' }}</td>
                                <td style="padding: 12px;">${{ number_format($producto['precio'] ?? 0, 2) }}</td>
                                <td style="padding: 12px;">{{ $producto['stock'] ?? '' }}</td>
                                <td style="padding: 12px;">{{ $producto['stockMinimo'] ?? '' }}</td>
                                <td style="padding: 12px;">{{ $producto['stockMaximo'] ?? '' }}</td>
                                <td style="padding: 12px;">{{ $producto['stockActual'] ?? '' }}</td>
                                <td style="padding: 12px;">{{ $producto['idCategoria'] ?? '' }}</td>
                                <td style="padding: 12px;">{{ $producto['idProveedor'] ?? '' }}</td>
                                <td style="padding: 12px;">
                                    <span style="padding: 4px 8px; border-radius: 4px; background-color: {{ $producto['estado'] == '1' ? '#1b4d1b' : '#4d1b1b' }}; color: white; font-size: 12px;">
                                        {{ $producto['estado'] == '1' ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </td>
                                <td style="padding: 12px; text-align: center;">
                                    <button onclick='editarProducto(@json($producto))' style="background-color: #f5a623; color: black; border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer; margin-right: 5px;">Editar</button>
                                    @if($producto['estado'] == '1')
                                        <button onclick="desactivarProducto({{ $producto['idProducto'] }}, '{{ $producto['nombre'] }}')" style="background-color: #d9534f; color: white; border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer;">Desactivar</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p style="color:#999;">No hay productos en el inventario.</p>
        @endif

  
        <div id="modalEditar" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.7); z-index: 1000; align-items: center; justify-content: center;">
            <div style="background-color: #1b1b27; padding: 30px; border-radius: 14px; max-width: 600px; width: 90%; border: 2px solid #444;">
                <h2 style="margin-bottom: 20px;">Editar Producto</h2>
                <form method="POST" action="{{ route('productos.actualizar') }}">
                    @csrf
                    <input type="hidden" name="id" id="edit_id">

                    <label for="edit_nombre">Nombre:</label>
                    <input type="text" name="nombre" id="edit_nombre" required>

                    <label for="edit_precio">Precio:</label>
                    <input type="number" name="precio" id="edit_precio" step="0.01" required>

                    <label for="edit_stock">Stock:</label>
                    <input type="number" name="stock" id="edit_stock" required>

                    <label for="edit_stockMinimo">Stock Mínimo:</label>
                    <input type="number" name="stockMinimo" id="edit_stockMinimo" required>

                    <label for="edit_stockMaximo">Stock Máximo:</label>
                    <input type="number" name="stockMaximo" id="edit_stockMaximo" required>

                    <label for="edit_stockActual">Stock Actual:</label>
                    <input type="number" name="stockActual" id="edit_stockActual" required>

                    <label for="edit_idCategoria">ID Categoría:</label>
                    <input type="number" name="idCategoria" id="edit_idCategoria" required>

                    <label for="edit_idProveedor">ID Proveedor:</label>
                    <input type="number" name="idProveedor" id="edit_idProveedor" required>

                    <label for="edit_estado">Estado:</label>
                    <select name="estado" id="edit_estado">
                        <option value="1">Activo</option>
                        <option value="0">Inactivo</option>
                    </select>

                    <div style="display: flex; gap: 10px; margin-top: 20px;">
                        <button type="submit" style="flex: 1;">Actualizar</button>
                        <button type="button" onclick="cerrarModal()" style="flex: 1; background-color: #666;">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>

   
        <form id="formDesactivar" method="POST" action="{{ route('productos.desactivar') }}" style="display: none;">
            @csrf
            <input type="hidden" name="id" id="desactivar_id">
        </form>

        <div class="volver">
            <a href="{{ route('productos.gestion') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" style="vertical-align: middle; margin-right: 5px;">
                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 0 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 0 1 .708.708L2.707 7.5H14.5A.5.5 0 0 1 15 8"/>
                </svg>
                Volver al módulo
            </a>
        </div>
    </main>

    <footer>
        <p>© 2025 Invex. Todos los derechos reservados.</p>
    </footer>

    <script>
        function editarProducto(producto) {
            document.getElementById('edit_id').value = producto.idProducto;
            document.getElementById('edit_nombre').value = producto.nombre;
            document.getElementById('edit_precio').value = producto.precio;
            document.getElementById('edit_stock').value = producto.stock;
            document.getElementById('edit_stockMinimo').value = producto.stockMinimo;
            document.getElementById('edit_stockMaximo').value = producto.stockMaximo;
            document.getElementById('edit_stockActual').value = producto.stockActual;
            document.getElementById('edit_idCategoria').value = producto.idCategoria;
            document.getElementById('edit_idProveedor').value = producto.idProveedor;
            document.getElementById('edit_estado').value = producto.estado;
            
            document.getElementById('modalEditar').style.display = 'flex';
        }

        function cerrarModal() {
            document.getElementById('modalEditar').style.display = 'none';
        }

        function desactivarProducto(id, nombre) {
            if (confirm('¿Está seguro que desea desactivar el producto "' + nombre + '"?')) {
                document.getElementById('desactivar_id').value = id;
                document.getElementById('formDesactivar').submit();
            }
        }
    </script>
</body>
</html>