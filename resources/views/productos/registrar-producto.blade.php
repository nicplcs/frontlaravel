<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Producto - Punto Éxito</title>
    <link rel="stylesheet" href="{{ asset('css/styleproductos.css') }}">
</head>
<body>
    <header>
        <h1>
            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" viewBox="0 0 16 16" style="vertical-align: middle; margin-right: 10px;">
                <path d="M8 7a.5.5 0 0 1 .5-.5H10V5a.5.5 0 0 1 1 0v1.5h1.5a.5.5 0 0 1 0 1H11V9a.5.5 0 0 1-1 0V7.5H8.5A.5.5 0 0 1 8 7"/>
                <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4"/>
            </svg>
            Registrar Producto
        </h1>
    </header>

    <main>
        {{-- Mensajes de éxito o error --}}
        @if(session('success'))
            <p style='color:green; background-color: #1b4d1b; padding: 15px; border-radius: 8px; margin-bottom: 20px; font-weight: bold; border: 1px solid #2d7a2d;'>
                {{ session('success') }}
            </p>
        @endif

        @if(session('error'))
            <p style='color:red; background-color: #4d1b1b; padding: 15px; border-radius: 8px; margin-bottom: 20px; font-weight: bold; border: 1px solid #7a2d2d;'>
                {{ session('error') }}
            </p>
        @endif

        @if($errors->any())
            <div style='color:red; background-color: #4d1b1b; padding: 15px; border-radius: 8px; margin-bottom: 20px; font-weight: bold; border: 1px solid #7a2d2d;'>
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <h2>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16" style="vertical-align: middle; margin-right: 8px;">
                <path d="M2 2a.5.5 0 0 0-.5.5V5a.5.5 0 0 0 .5.5h2.5a.5.5 0 0 0 .5-.5V2.5a.5.5 0 0 0-.5-.5zm0 7a.5.5 0 0 0-.5.5V12a.5.5 0 0 0 .5.5h2.5a.5.5 0 0 0 .5-.5V9.5a.5.5 0 0 0-.5-.5zm7-7a.5.5 0 0 0-.5.5V5a.5.5 0 0 0 .5.5H12a.5.5 0 0 0 .5-.5V2.5A.5.5 0 0 0 12 2zm0 7a.5.5 0 0 0-.5.5V12a.5.5 0 0 0 .5.5H12a.5.5 0 0 0 .5-.5V9.5A.5.5 0 0 0 12 9z"/>
            </svg>
            Formulario de Registro
        </h2>

        <form method="POST" action="{{ route('productos.registrar.guardar') }}">
            @csrf
            <label for="nombre">Nombre del Producto:</label>
            <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" required>

            <label for="idCategoria">Categoría:</label>
            <input type="number" name="idCategoria" id="idCategoria" value="{{ old('idCategoria') }}" required>

            <label for="precio">Precio:</label>
            <input type="number" name="precio" id="precio" step="0.01" min="0" value="{{ old('precio') }}" required>

            <label for="stock">Stock:</label>
            <input type="number" name="stock" id="stock" min="0" value="{{ old('stock') }}" required>

            <label for="stockMinimo">Stock Mínimo:</label>
            <input type="number" name="stockMinimo" id="stockMinimo" min="0" value="{{ old('stockMinimo') }}" required>

            <label for="stockMaximo">Stock Máximo:</label>
            <input type="number" name="stockMaximo" id="stockMaximo" min="0" value="{{ old('stockMaximo') }}" required>

            <label for="stockActual">Stock Actual:</label>
            <input type="number" name="stockActual" id="stockActual" min="0" value="{{ old('stockActual') }}" required>

            <label for="idProveedor">Proveedor:</label>
            <input type="number" name="idProveedor" id="idProveedor" value="{{ old('idProveedor') }}" required>

            <button type="submit">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16" style="vertical-align: middle; margin-right: 5px;">
                    <path d="M8.186.09a.5.5 0 0 0-.372 0l-7 3a.5.5 0 0 0 0 .92L8 7.846l7.186-3.836a.5.5 0 0 0 0-.92zM15 4.54 8.5 8v7.5l6.5-3.5V4.54zM7.5 8 1 4.54v7.96l6.5 3.5zM8 8.707l-7.146-3.81L8 1.293l7.146 3.604z"/>
                </svg>
                Registrar Producto
            </button>
        </form>


        <h2>Productos Registrados</h2>
        @if(count($productos) > 0)
            <ul>
                @foreach($productos as $producto)
                    <li>
                        <b>ID:</b> {{ htmlspecialchars($producto["idProducto"] ?? '') }} | 
                        <b>Nombre:</b> {{ htmlspecialchars($producto["nombre"] ?? '') }} | 
                        <b>Precio:</b> ${{ number_format($producto["precio"] ?? 0, 2) }} | 
                        <b>Stock:</b> {{ htmlspecialchars($producto["stock"] ?? '') }} | 
                        <b>Stock Min:</b> {{ htmlspecialchars($producto["stockMinimo"] ?? '') }} | 
                        <b>Stock Max:</b> {{ htmlspecialchars($producto["stockMaximo"] ?? '') }} | 
                        <b>Stock Actual:</b> {{ htmlspecialchars($producto["stockActual"] ?? '') }} | 
                        <b>Categoría:</b> {{ htmlspecialchars($producto["idCategoria"] ?? '') }} | 
                        <b>Proveedor:</b> {{ htmlspecialchars($producto["idProveedor"] ?? '') }} | 
                        <b>Estado:</b> {{ $producto["estado"] == "1" ? "Activo" : "Inactivo" }}
                    </li>
                @endforeach
            </ul>
        @else
            <p style="color:#999;">No hay productos registrados.</p>
        @endif

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
        <p>© 2025 Punto Éxito. Todos los derechos reservados.</p>
    </footer>
</body>
</html>