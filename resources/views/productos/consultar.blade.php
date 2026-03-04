<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Inventario - Punto Éxito</title>
    <link rel="stylesheet" href="{{ asset('css/styleproductos.css') }}">
</head>
<body>
    <div class="header-nav" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <a href="{{ session('rol') == 'administrador' ? route('productos.gestion') : route('inicio.empleado') }}" class="back-button" style="background: rgba(255, 255, 255, 0.15); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); color: white; padding: 10px 20px; border-radius: 25px; text-decoration: none; font-weight: 500; transition: all 0.3s ease;">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" style="vertical-align: middle; margin-right: 5px;">
                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 0 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 0 1 .708.708L2.707 7.5H14.5A.5.5 0 0 1 15 8"/>
            </svg>
            Volver al Módulo
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
                            <th style="text-align: center;">ACCIONES</th>
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
                                <td style="text-align: center;">
                                    <button onclick='editarProducto(@json($producto))' style="background: rgba(255, 255, 255, 0.15); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.3); color: rgba(255, 255, 255, 0.9); padding: 8px 18px; border-radius: 10px; font-weight: 600; cursor: pointer; margin-right: 8px; font-size: 13px; transition: all 0.3s ease;">Editar</button>
                                    @if($producto['estado'] == '1')
                                        <button onclick="desactivarProducto({{ $producto['idProducto'] }}, '{{ $producto['nombre'] }}')" style="background: rgba(255, 255, 255, 0.15); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.3); color: rgba(255, 255, 255, 0.9); padding: 8px 18px; border-radius: 10px; font-weight: 600; cursor: pointer; font-size: 13px; transition: all 0.3s ease;">Desactivar</button>
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

        <!-- MODAL EDITAR -->
        <div id="modalEditar" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.8); backdrop-filter: blur(10px); z-index: 1000; align-items: center; justify-content: center;">
            <div style="background: rgba(102, 126, 234, 0.15); backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.2); padding: 35px; border-radius: 20px; max-width: 550px; width: 90%; box-shadow: 0 8px 32px rgba(0, 0, 0, 0.5);">
                <h2 style="margin-bottom: 25px; font-size: 1.8rem; color: white; text-shadow: 2px 2px 10px rgba(0,0,0,0.5); text-align: center;">Editar Producto</h2>
                <form method="POST" action="{{ route('productos.actualizar') }}" style="background: transparent; border: none; padding: 0; box-shadow: none;">
                    @csrf
                    <input type="hidden" name="id" id="edit_id">

                    <label for="edit_nombre" style="color: white; font-weight: 600; margin-bottom: 8px; display: block;">Nombre:</label>
                    <input type="text" name="nombre" id="edit_nombre" required style="width: 100%; padding: 12px 15px; background: rgba(255, 255, 255, 0.15); border: 1px solid rgba(255, 255, 255, 0.3); border-radius: 10px; color: white; font-size: 14px; margin-bottom: 18px;">

                    <label for="edit_precio" style="color: white; font-weight: 600; margin-bottom: 8px; display: block;">Precio:</label>
                    <input type="number" name="precio" id="edit_precio" step="0.01" required style="width: 100%; padding: 12px 15px; background: rgba(255, 255, 255, 0.15); border: 1px solid rgba(255, 255, 255, 0.3); border-radius: 10px; color: white; font-size: 14px; margin-bottom: 18px;">

                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px;">
                        <div>
                            <label for="edit_stockMinimo" style="color: white; font-weight: 600; margin-bottom: 8px; display: block; font-size: 13px;">Stock Mín:</label>
                            <input type="number" name="stockMinimo" id="edit_stockMinimo" required style="width: 100%; padding: 12px 10px; background: rgba(255, 255, 255, 0.15); border: 1px solid rgba(255, 255, 255, 0.3); border-radius: 10px; color: white; font-size: 14px;">
                        </div>
                        <div>
                            <label for="edit_stockMaximo" style="color: white; font-weight: 600; margin-bottom: 8px; display: block; font-size: 13px;">Stock Máx:</label>
                            <input type="number" name="stockMaximo" id="edit_stockMaximo" required style="width: 100%; padding: 12px 10px; background: rgba(255, 255, 255, 0.15); border: 1px solid rgba(255, 255, 255, 0.3); border-radius: 10px; color: white; font-size: 14px;">
                        </div>
                        <div>
                            <label for="edit_stockActual" style="color: white; font-weight: 600; margin-bottom: 8px; display: block; font-size: 13px;">Stock Actual:</label>
                            <input type="number" name="stockActual" id="edit_stockActual" required style="width: 100%; padding: 12px 10px; background: rgba(255, 255, 255, 0.15); border: 1px solid rgba(255, 255, 255, 0.3); border-radius: 10px; color: white; font-size: 14px;">
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-top: 18px;">
                        <div>
                            <label for="edit_idCategoria" style="color: white; font-weight: 600; margin-bottom: 8px; display: block;">Categoría:</label>
                            <select name="idCategoria" id="edit_idCategoria" required style="width: 100%; padding: 12px 15px; background: rgba(50, 50, 80, 0.95); border: 1px solid rgba(255, 255, 255, 0.3); border-radius: 10px; color: white; font-size: 14px;">
                                <option value="">-- Selecciona --</option>
                                @foreach($categorias as $categoria)
                                    <option value="{{ $categoria['idCategoria'] }}">{{ $categoria['nombreCategoria'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="edit_idProveedor" style="color: white; font-weight: 600; margin-bottom: 8px; display: block;">Proveedor:</label>
                            <select name="idProveedor" id="edit_idProveedor" required style="width: 100%; padding: 12px 15px; background: rgba(50, 50, 80, 0.95); border: 1px solid rgba(255, 255, 255, 0.3); border-radius: 10px; color: white; font-size: 14px;">
                                <option value="">-- Selecciona --</option>
                                @foreach($proveedores as $proveedor)
                                    <option value="{{ $proveedor['id'] }}">{{ $proveedor['nombre'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <label for="edit_estado" style="color: white; font-weight: 600; margin-bottom: 8px; margin-top: 18px; display: block;">Estado:</label>
                    <select name="estado" id="edit_estado" style="width: 100%; padding: 12px 15px; background: rgba(50, 50, 80, 0.95); border: 1px solid rgba(255, 255, 255, 0.3); border-radius: 10px; color: white; font-size: 14px; margin-bottom: 25px;">
                        <option value="1">Activo</option>
                        <option value="0">Inactivo</option>
                    </select>

                    <div style="display: flex; gap: 12px;">
                        <button type="submit" style="flex: 1; background: linear-gradient(135deg, #667eea, #764ba2); color: white; padding: 14px; font-weight: 700; border: none; border-radius: 12px; cursor: pointer; font-size: 15px;">
                            ✓ Actualizar
                        </button>
                        <button type="button" onclick="cerrarModal()" style="flex: 1; background: rgba(108, 117, 125, 0.3); border: 1px solid rgba(255, 255, 255, 0.2); color: white; padding: 14px; font-weight: 600; border-radius: 12px; cursor: pointer; font-size: 15px;">
                            ✕ Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <form id="formDesactivar" method="POST" action="{{ route('productos.desactivar') }}" style="display: none;">
            @csrf
            <input type="hidden" name="id" id="desactivar_id">
        </form>
    </main>

    <footer>
        <p>© 2025 Punto Éxito. Todos los derechos reservados.</p>
    </footer>

    <script>
        function editarProducto(producto) {
            document.getElementById('edit_id').value = producto.idProducto;
            document.getElementById('edit_nombre').value = producto.nombre;
            document.getElementById('edit_precio').value = producto.precio;
            document.getElementById('edit_stockMinimo').value = producto.stockMinimo;
            document.getElementById('edit_stockMaximo').value = producto.stockMaximo;
            document.getElementById('edit_stockActual').value = producto.stockActual;

            // Seleccionar categoría correcta en el dropdown
            document.getElementById('edit_idCategoria').value = producto.idCategoria;
            // Seleccionar proveedor correcto en el dropdown
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

        document.getElementById('modalEditar').addEventListener('click', function(e) {
            if (e.target === this) cerrarModal();
        });

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('button[onclick*="editarProducto"]').forEach(btn => {
                btn.addEventListener('mouseenter', function() {
                    this.style.background = 'rgba(255, 255, 255, 0.25)';
                    this.style.transform = 'translateY(-2px)';
                });
                btn.addEventListener('mouseleave', function() {
                    this.style.background = 'rgba(255, 255, 255, 0.15)';
                    this.style.transform = 'translateY(0)';
                });
            });

            document.querySelectorAll('button[onclick*="desactivarProducto"]').forEach(btn => {
                btn.addEventListener('mouseenter', function() {
                    this.style.background = 'rgba(255, 255, 255, 0.25)';
                    this.style.transform = 'translateY(-2px)';
                });
                btn.addEventListener('mouseleave', function() {
                    this.style.background = 'rgba(255, 255, 255, 0.15)';
                    this.style.transform = 'translateY(0)';
                });
            });
        });
    </script>
</body>
</html>