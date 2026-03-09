<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Inventario - Punto Éxito</title>
    <link rel="stylesheet" href="{{ asset('css/styleproductos.css') }}">
    <style>
        .alert {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 16px 20px;
            border-radius: 14px;
            margin-bottom: 24px;
            font-weight: 500;
            font-size: 15px;
            backdrop-filter: blur(15px);
            animation: slideIn 0.3s ease;
        }
        .alert-success {
            background: rgba(40, 167, 69, 0.2);
            border: 1px solid rgba(40, 167, 69, 0.5);
            color: #90ee90;
        }
        .alert-error {
            background: rgba(220, 53, 69, 0.2);
            border: 1px solid rgba(220, 53, 69, 0.5);
            color: #ffb3ba;
        }
        .alert-icon { font-size: 20px; flex-shrink: 0; }
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* MODAL REDISEÑADO */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.75);
            backdrop-filter: blur(12px);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            animation: fadeOverlay 0.3s ease;
        }
        @keyframes fadeOverlay {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .modal-box {
            background: linear-gradient(145deg, rgba(30, 30, 60, 0.95), rgba(50, 30, 80, 0.95));
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 24px;
            padding: 0;
            max-width: 620px;
            width: 92%;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.6), 0 0 0 1px rgba(255,255,255,0.05);
            animation: slideUp 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
            overflow: hidden;
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(40px) scale(0.95); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }
        .modal-header {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.4), rgba(118, 75, 162, 0.4));
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 24px 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .modal-header h2 {
            font-size: 1.4rem;
            color: white;
            font-weight: 700;
            margin: 0;
            padding: 0;
            border: none;
            text-shadow: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .modal-close-btn {
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.2);
            color: white;
            width: 34px;
            height: 34px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }
        .modal-close-btn:hover {
            background: rgba(220, 53, 69, 0.4);
            border-color: rgba(220, 53, 69, 0.6);
            transform: rotate(90deg);
        }
        .modal-body {
            padding: 28px 30px;
        }
        .modal-grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0 20px;
        }
        .modal-grid-3 {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 0 15px;
        }
        .modal-field label {
            display: block;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: rgba(255,255,255,0.6);
            margin-bottom: 6px;
        }
        .modal-field input,
        .modal-field select {
            width: 100%;
            padding: 11px 14px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 10px;
            color: white;
            font-size: 14px;
            margin-bottom: 16px;
            transition: all 0.25s ease;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .modal-field input:focus,
        .modal-field select:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.14);
            border-color: rgba(102, 126, 234, 0.7);
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.15);
        }
        .modal-field select option {
            background: #1e1e3a;
            color: white;
        }
        .modal-field input::placeholder {
            color: rgba(255,255,255,0.35);
        }
        .modal-divider {
            height: 1px;
            background: rgba(255,255,255,0.08);
            margin: 6px 0 18px 0;
        }
        .modal-footer {
            padding: 0 30px 28px 30px;
            display: flex;
            gap: 12px;
        }
        .btn-actualizar {
            flex: 1;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 14px;
            font-weight: 700;
            font-size: 14px;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.35);
        }
        .btn-actualizar:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.55);
        }
        .btn-cancelar {
            flex: 1;
            background: rgba(255, 255, 255, 0.07);
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: rgba(255,255,255,0.8);
            padding: 14px;
            font-weight: 600;
            font-size: 14px;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .btn-cancelar:hover {
            background: rgba(220, 53, 69, 0.2);
            border-color: rgba(220, 53, 69, 0.4);
            color: #ffb3ba;
        }
    </style>
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
        {{-- Alertas --}}
        @if(session('success'))
            <div class="alert alert-success">
                <span class="alert-icon">✓</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                <span class="alert-icon">✕</span>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if(isset($mensaje) && $mensaje)
            <div class="alert {{ isset($tipo_mensaje) && $tipo_mensaje === 'success' ? 'alert-success' : 'alert-error' }}">
                <span class="alert-icon">{{ isset($tipo_mensaje) && $tipo_mensaje === 'success' ? '✓' : '✕' }}</span>
                <span>{{ $mensaje }}</span>
            </div>
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
                                <td>
                                    @php
                                        $cat = collect($categorias)->firstWhere('idCategoria', $producto['idCategoria'] ?? null);
                                    @endphp
                                    {{ $cat ? $cat['nombreCategoria'] : ($producto['idCategoria'] ?? '') }}
                                </td>
                                <td>
                                    @php
                                        $prov = collect($proveedores)->firstWhere('id', $producto['idProveedor'] ?? null);
                                    @endphp
                                    {{ $prov ? $prov['nombre'] : ($producto['idProveedor'] ?? '') }}
                                </td>
                                <td>
                                    @if($producto['estado'] == '1')
                                        <span style="background-color: rgba(40, 167, 69, 0.3); color: #90ee90; padding: 5px 12px; border-radius: 20px; font-weight: 600; font-size: 12px; border: 1px solid rgba(40, 167, 69, 0.5);">Activo</span>
                                    @else
                                        <span style="background-color: rgba(220, 53, 69, 0.3); color: #ffb3ba; padding: 5px 12px; border-radius: 20px; font-weight: 600; font-size: 12px; border: 1px solid rgba(220, 53, 69, 0.5);">Inactivo</span>
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

        <!-- MODAL EDITAR REDISEÑADO -->
        <div id="modalEditar" class="modal-overlay">
            <div class="modal-box">
                <div class="modal-header">
                    <h2>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z"/>
                        </svg>
                        Editar Producto
                    </h2>
                    <button class="modal-close-btn" onclick="cerrarModal()">✕</button>
                </div>

                <form method="POST" action="{{ route('productos.actualizar') }}" style="background: transparent; border: none; padding: 0; box-shadow: none; margin: 0; animation: none;">
                    @csrf
                    <input type="hidden" name="id" id="edit_id">

                    <div class="modal-body">
                        <!-- Nombre y Precio -->
                        <div class="modal-grid-2">
                            <div class="modal-field">
                                <label for="edit_nombre">Nombre del Producto</label>
                                <input type="text" name="nombre" id="edit_nombre" required placeholder="Nombre del producto">
                            </div>
                            <div class="modal-field">
                                <label for="edit_precio">Precio ($)</label>
                                <input type="number" name="precio" id="edit_precio" step="0.01" required placeholder="0.00">
                            </div>
                        </div>

                        <div class="modal-divider"></div>

                        <!-- Stocks -->
                        <div class="modal-grid-3">
                            <div class="modal-field">
                                <label for="edit_stockMinimo">Stock Mínimo</label>
                                <input type="number" name="stockMinimo" id="edit_stockMinimo" required placeholder="0">
                            </div>
                            <div class="modal-field">
                                <label for="edit_stockMaximo">Stock Máximo</label>
                                <input type="number" name="stockMaximo" id="edit_stockMaximo" required placeholder="0">
                            </div>
                            <div class="modal-field">
                                <label for="edit_stockActual">Stock Actual</label>
                                <input type="number" name="stockActual" id="edit_stockActual" required placeholder="0">
                            </div>
                        </div>

                        <div class="modal-divider"></div>

                        <!-- Categoría, Proveedor y Estado -->
                        <div class="modal-grid-2">
                            <div class="modal-field">
                                <label for="edit_idCategoria">Categoría</label>
                                <select name="idCategoria" id="edit_idCategoria" required>
                                    <option value="">-- Selecciona --</option>
                                    @foreach($categorias as $categoria)
                                        <option value="{{ $categoria['idCategoria'] }}">{{ $categoria['nombreCategoria'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="modal-field">
                                <label for="edit_idProveedor">Proveedor</label>
                                <select name="idProveedor" id="edit_idProveedor" required>
                                    <option value="">-- Selecciona --</option>
                                    @foreach($proveedores as $proveedor)
                                        <option value="{{ $proveedor['id'] }}">{{ $proveedor['nombre'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="modal-field">
                            <label for="edit_estado">Estado</label>
                            <select name="estado" id="edit_estado">
                                <option value="1">✓ Activo</option>
                                <option value="0">✕ Inactivo</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn-actualizar">✓ Actualizar Producto</button>
                        <button type="button" class="btn-cancelar" onclick="cerrarModal()">✕ Cancelar</button>
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

        document.getElementById('modalEditar').addEventListener('click', function(e) {
            if (e.target === this) cerrarModal();
        });
    </script>
</body>
</html>