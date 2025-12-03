<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Movimientos - Invex</title>
  <link rel="stylesheet" href="{{ asset('css/styleconsultarmovimiento.css') }}">
</head>
<body>

  <div class="container">

    <h1 class="titulo">
      <svg xmlns="http://www.w3.org/2000/svg" width="26" height="24" fill="currentColor" class="icon">
        <path fill-rule="evenodd" d="M5.5 9.5A.5.5 0 0 1 6 9h4a.5.5 0 0 1 0 1H6a..."/>
      </svg>
      Historial de Movimientos
    </h1>

    @if(isset($error))
      <div class="alert-error">
        {{ $error }}
      </div>
    @endif

    <div class="tabla-container">
      <table class="tabla">
        <thead>
          <tr>
            <th><span class="header-icon"></span> ID</th>
            <th><span class="header-icon"></span> Tipo</th>
            <th><span class="header-icon"></span> Descripción</th>
             <th><span class="header-icon"></span> Cantidad</th>
             <th><span class="header-icon"></span> Fecha</th>
            <th><span class="header-icon"></span> Usuario</th>
            <th><span class="header-icon"></span> Acción</th>
            <th><span class="header-icon"></span> ID Producto</th>
          </tr>
        </thead>

        <tbody>
          @forelse($movimientos as $movimiento)
        <tr>
          <td>{{ $movimiento['id_movimiento'] }}</td>
          <td>{{ $movimiento['tipo'] }}</td>
          <td>{{ $movimiento['descripcion'] }}</td>
          <td>{{ $movimiento['cantidad'] }}</td>
          <td>{{ \Carbon\Carbon::parse($movimiento['fecha'])->format('d/m/Y H:i') }}</td>
          <td>{{ $movimiento['usuario_responsable'] }}</td>
          <td>{{ $movimiento['accion'] }}</td>
          <td>{{ $movimiento['id_producto'] ?? '—' }}</td>
  
      </td>

        </tr>
      @empty
        <tr>
          <td colspan="8" class="no-data">No hay movimientos registrados</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>
    <div class="volver">
      <a href="{{ route('modulo.movimiento') }}" class="btn-volver">
        ⬅ Volver al panel
      </a>
    </div>

  </div>

</body>
</html>
