<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrada de Productos - Punto Éxito</title>
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
        .alert-icon {
            font-size: 20px;
            flex-shrink: 0;
        }
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
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
        <h1>Entrada de Productos</h1>
    </header>

    <main>
        {{-- Mensajes de éxito o error --}}
        @if(session('success'))
            <div class="alert alert-success">
                <span class="alert-icon">✓</span>
                <span>{!! session('success') !!}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                <span class="alert-icon">✕</span>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-error">
                <span class="alert-icon">⚠</span>
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <h2>Registrar Entrada de Stock</h2>

        <form method="POST" action="{{ route('productos.entrada.registrar') }}">
            @csrf
            <label for="idProducto">Selecciona un producto:</label>
            <select name="idProducto" id="idProducto" required onchange="mostrarInfoProducto()">
                <option value="">-- Selecciona un producto --</option>
                @if(count($productos) > 0)
                    @foreach($productos as $producto)
                        <option value="{{ $producto['idProducto'] }}" 
                                data-nombre="{{ htmlspecialchars($producto['nombre']) }}"
                                data-stockactual="{{ $producto['stockActual'] }}"
                                data-stockmaximo="{{ $producto['stockMaximo'] }}">
                            {{ htmlspecialchars($producto['nombre']) }} (Stock: {{ $producto['stockActual'] }})
                        </option>
                    @endforeach
                @endif
            </select>

            <div id="infoProducto" style="display: none; background: rgba(255,255,255,0.1); backdrop-filter: blur(15px); padding: 20px; border-radius: 12px; margin-bottom: 20px; border: 1px solid rgba(255,255,255,0.2);">
                <p><b>Producto:</b> <span id="infoNombre"></span></p>
                <p><b>Stock Actual:</b> <span id="infoStockActual"></span></p>
                <p><b>Stock Máximo:</b> <span id="infoStockMaximo"></span></p>
            </div>

            <label for="cantidadAgregar">Cantidad a ingresar:</label>
            <input type="number" name="cantidadAgregar" id="cantidadAgregar" min="1" required>

            <button type="submit">Confirmar Entrada</button>
        </form>

        <h2>Productos Disponibles</h2>
        @if(count($productos) > 0)
            <ul>
                @foreach($productos as $producto)
                    <li>
                        <b>ID:</b> {{ htmlspecialchars($producto["idProducto"]) }} | 
                        <b>Nombre:</b> {{ htmlspecialchars($producto["nombre"]) }} | 
                        <b>Stock Actual:</b> {{ htmlspecialchars($producto["stockActual"]) }} | 
                        <b>Stock Min:</b> {{ htmlspecialchars($producto["stockMinimo"]) }} | 
                        <b>Stock Max:</b> {{ htmlspecialchars($producto["stockMaximo"]) }}
                    </li>
                @endforeach
            </ul>
        @else
            <p style="color:rgba(255,255,255,0.7);">No hay productos activos disponibles.</p>
        @endif
    </main>

    <footer>
        <p>© 2025 Punto Éxito. Todos los derechos reservados.</p>
    </footer>

    <script>
        function mostrarInfoProducto() {
            const select = document.getElementById('idProducto');
            const option = select.options[select.selectedIndex];
            if (option.value) {
                document.getElementById('infoNombre').textContent = option.dataset.nombre;
                document.getElementById('infoStockActual').textContent = option.dataset.stockactual;
                document.getElementById('infoStockMaximo').textContent = option.dataset.stockmaximo;
                document.getElementById('infoProducto').style.display = 'block';
            } else {
                document.getElementById('infoProducto').style.display = 'none';
            }
        }
    </script>
</body>
</html>