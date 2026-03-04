<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Productos - Punto Éxito</title>
    <link rel="stylesheet" href="{{ asset('css/styleproductos.css') }}">
</head>
<body>
    <!-- BOTÓN VOLVER ARRIBA -->
    <div class="header-nav">
        <a href="{{ route('productos.gestion') }}" class="back-button">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" style="vertical-align: middle; margin-right: 5px;">
                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 0 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 0 1 .708.708L2.707 7.5H14.5A.5.5 0 0 1 15 8"/>
            </svg>
            Volver al Módulo
        </a>
    </div>

    <!-- HEADER -->
    <header>
        <h1>
            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" viewBox="0 0 16 16" style="vertical-align: middle; margin-right: 10px;">
                <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4"/>
            </svg>
            Gestión de Productos
        </h1>
    </header>

    <main>
        <!-- FORMULARIO DE REGISTRO -->
        <h2>Agregar Producto</h2>

        {{-- Mensajes de éxito o error --}}
        @if(session('success'))
            <p style='color:green; background-color: rgba(40, 167, 69, 0.3); padding: 15px; border-radius: 12px; margin-bottom: 20px; font-weight: 500; border: 1px solid rgba(40, 167, 69, 0.5);'>
                {{ session('success') }}
            </p>
        @endif

        @if(session('error'))
            <p style='color:red; background-color: rgba(220, 53, 69, 0.3); padding: 15px; border-radius: 12px; margin-bottom: 20px; font-weight: 500; border: 1px solid rgba(220, 53, 69, 0.5);'>
                {{ session('error') }}
            </p>
        @endif

        @if($errors->any())
            <div style='color:red; background-color: rgba(220, 53, 69, 0.3); padding: 15px; border-radius: 12px; margin-bottom: 20px; font-weight: 500; border: 1px solid rgba(220, 53, 69, 0.5);'>
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('productos.registrar.guardar') }}">
            @csrf
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0 30px;">
                <!-- COLUMNA IZQUIERDA -->
                <div>
                    <label for="nombre">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16" style="vertical-align: middle; margin-right: 5px;">
                            <path d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2M5 4h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1m-.5 2.5A.5.5 0 0 1 5 6h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5M5 8h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1m0 2h3a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1"/>
                        </svg>
                        Nombre del Producto:
                    </label>
                    <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" placeholder="Ej: Coca Cola 600ml" required>

                    <label for="precio">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16" style="vertical-align: middle; margin-right: 5px;">
                            <path d="M4 10.781c.148 1.667 1.513 2.85 3.591 3.003V15h1.043v-1.216c2.27-.179 3.678-1.438 3.678-3.3 0-1.59-.947-2.51-2.956-3.028l-.722-.187V3.467c1.122.11 1.879.714 2.07 1.616h1.47c-.166-1.6-1.54-2.748-3.54-2.875V1H7.591v1.233c-1.939.23-3.27 1.472-3.27 3.156 0 1.454.966 2.483 2.661 2.917l.61.162v4.031c-1.149-.17-1.94-.8-2.131-1.718zm3.391-3.836c-1.043-.263-1.6-.825-1.6-1.616 0-.944.704-1.641 1.8-1.828v3.495l-.2-.05zm1.591 1.872c1.287.323 1.852.859 1.852 1.769 0 1.097-.826 1.828-2.2 1.939V8.73z"/>
                        </svg>
                        Precio:
                    </label>
                    <input type="number" name="precio" id="precio" step="0.01" min="0" value="{{ old('precio') }}" placeholder="0.00" required>

                    <label for="stockMinimo">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16" style="vertical-align: middle; margin-right: 5px;">
                            <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2zm3.564 1.426L5.596 5 8 5.961 14.154 3.5zm3.25 1.7-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464z"/>
                        </svg>
                        Stock Mínimo:
                    </label>
                    <input type="number" name="stockMinimo" id="stockMinimo" min="0" value="{{ old('stockMinimo') }}" placeholder="Cantidad mínima" required>

                    <label for="stockActual">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16" style="vertical-align: middle; margin-right: 5px;">
                            <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7z"/>
                        </svg>
                        Stock Actual:
                    </label>
                    <input type="number" name="stockActual" id="stockActual" min="0" value="{{ old('stockActual') }}" placeholder="Cantidad actual en inventario" required>
                </div>

                <!-- COLUMNA DERECHA -->
                <div>
                    <label for="idCategoria">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16" style="vertical-align: middle; margin-right: 5px;">
                            <path d="M1 2.5A1.5 1.5 0 0 1 2.5 1h3A1.5 1.5 0 0 1 7 2.5v3A1.5 1.5 0 0 1 5.5 7h-3A1.5 1.5 0 0 1 1 5.5zm8 0A1.5 1.5 0 0 1 10.5 1h3A1.5 1.5 0 0 1 15 2.5v3A1.5 1.5 0 0 1 13.5 7h-3A1.5 1.5 0 0 1 9 5.5zm-8 8A1.5 1.5 0 0 1 2.5 9h3A1.5 1.5 0 0 1 7 10.5v3A1.5 1.5 0 0 1 5.5 15h-3A1.5 1.5 0 0 1 1 13.5zm8 0A1.5 1.5 0 0 1 10.5 9h3a1.5 1.5 0 0 1 1.5 1.5v3a1.5 1.5 0 0 1-1.5 1.5h-3A1.5 1.5 0 0 1 9 13.5z"/>
                        </svg>
                        Categoría:
                    </label>
                    <select name="idCategoria" id="idCategoria" required>
                        <option value="">-- Selecciona una categoría --</option>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria['idCategoria'] }}"
                                {{ old('idCategoria') == $categoria['idCategoria'] ? 'selected' : '' }}>
                                {{ $categoria['nombreCategoria'] }}
                            </option>
                        @endforeach
                    </select>

                    <label for="idProveedor">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16" style="vertical-align: middle; margin-right: 5px;">
                            <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5.784 6A2.24 2.24 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.3 6.3 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5"/>
                        </svg>
                        Proveedor:
                    </label>
                    <select name="idProveedor" id="idProveedor" required>
                        <option value="">-- Selecciona un proveedor --</option>
                        @foreach($proveedores as $proveedor)
                            <option value="{{ $proveedor['id'] }}"
                                {{ old('idProveedor') == $proveedor['id'] ? 'selected' : '' }}>
                                {{ $proveedor['nombre'] }}
                            </option>
                        @endforeach
                    </select>

                    <label for="stockMaximo">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16" style="vertical-align: middle; margin-right: 5px;">
                            <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5 8 5.961 14.154 3.5zM15 4.239l-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464z"/>
                        </svg>
                        Stock Máximo:
                    </label>
                    <input type="number" name="stockMaximo" id="stockMaximo" min="0" value="{{ old('stockMaximo') }}" placeholder="Cantidad máxima" required>
                </div>
            </div>

            <button type="submit" style="margin-top: 10px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16" style="vertical-align: middle; margin-right: 8px;">
                    <path d="M8 7a.5.5 0 0 1 .5-.5H10V5a.5.5 0 0 1 1 0v1.5h1.5a.5.5 0 0 1 0 1H11V9a.5.5 0 0 1-1 0V7.5H8.5A.5.5 0 0 1 8 7"/>
                    <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4"/>
                </svg>
                AGREGAR PRODUCTO
            </button>
        </form>

        <!-- LISTADO DE PRODUCTOS -->
        <h2>Listado de Productos</h2>
        @if(count($productos) > 0)
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
                                <td>{{ $producto["idProducto"] ?? '' }}</td>
                                <td><b>{{ $producto["nombre"] ?? '' }}</b></td>
                                <td>${{ number_format($producto["precio"] ?? 0, 2) }}</td>
                                <td>{{ $producto["stockActual"] ?? '' }}</td>
                                <td>{{ $producto["stockMinimo"] ?? '' }}</td>
                                <td>{{ $producto["stockMaximo"] ?? '' }}</td>

                                {{-- CATEGORÍA: muestra nombre en vez del ID --}}
                                <td>
                                    @php
                                        $cat = collect($categorias)->firstWhere('idCategoria', $producto["idCategoria"] ?? null);
                                    @endphp
                                    {{ $cat ? $cat['nombreCategoria'] : ($producto["idCategoria"] ?? '') }}
                                </td>

                                {{-- PROVEEDOR: muestra nombre en vez del ID --}}
                                <td>
                                    @php
                                        $prov = collect($proveedores)->firstWhere('id', $producto["idProveedor"] ?? null);
                                    @endphp
                                    {{ $prov ? $prov['nombre'] : ($producto["idProveedor"] ?? '') }}
                                </td>

                                <td>
                                    @if($producto["estado"] == "1")
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
            <p style="color:rgba(255, 255, 255, 0.7); text-align: center; padding: 20px;">
                No hay productos registrados.
            </p>
        @endif
    </main>

    <footer>
        <p>© 2025 Punto Éxito. Todos los derechos reservados.</p>
    </footer>
</body>
</html>