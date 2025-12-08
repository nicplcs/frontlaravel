<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Registro de Devoluciones - Invex</title>
  <link rel="stylesheet" href="{{ asset('css/styledevolucion.css') }}">
</head>
<body>

  <div class="header-nav">
    <a href="{{ route('modulo.movimiento') }}" class="back-button">
      ← Volver
    </a>
  </div>

  <div class="main-container">

    <div class="page-title">
      <h1>Devoluciones</h1>
      <p>Gestiona las devoluciones de productos</p>
    </div>

    @if(session('success'))
      <div class="alert-success">
      {{ session('success') }}
      </div>
    @endif

    @if(isset($error) || session('error'))
      <div class="alert-error">
      {{ $error ?? session('error') }}
      </div>
    @endif

    <div class="glass-card">
      <h2 class="card-header" id="form-title">Registrar Nueva Devolución</h2>
      
      <form id="form-devolucion" action="{{ route('devoluciones.store') }}" method="POST" class="formulario-devolucion">
        @csrf
        <input type="hidden" id="devolucion-id" name="id">

        <div class="form-grid">
          <div class="form-group">
            <label for="fechaDevolucion">Fecha:</label>
            <input type="date" id="fechaDevolucion" name="fechaDevolucion" required>
          </div>

          <div class="form-group">
            <label for="cantidad">Cantidad:</label>
            <input type="number" id="cantidad" name="cantidad" min="1" placeholder="Ej: 5" required>
          </div>
        </div>

        <div class="form-grid">
          <div class="form-group">
            <label for="idProducto">ID Producto:</label>
            <input type="number" id="idProducto" name="idProducto" min="1" placeholder="Ej: 1" required>
          </div>

          <div class="form-group">
            <label for="idOrdenSalida">ID Orden Salida:</label>
            <input type="number" id="idOrdenSalida" name="idOrdenSalida" min="1" placeholder="Ej: 1" required>
          </div>
        </div>

        <div class="form-group">
          <label for="motivo">Motivo:</label>
          <textarea id="motivo" name="motivo" placeholder="Describe el motivo de la devolución" rows="3" required></textarea>
        </div>

        <div class="form-actions">
          <button type="submit" class="btn-submit" id="btn-submit">
            <span id="btn-text">Registrar Devolución</span>
          </button>
          <button type="button" class="btn-cancel" id="btn-cancel" onclick="cancelarEdicion()" style="display: none;">
            Cancelar
          </button>
        </div>
      </form>
    </div>

    <div class="providers-container">
      <div class="table-header">
      Historial de Devoluciones ({{ count($devoluciones) }})
      </div>

      <div class="providers-list">
        @forelse($devoluciones as $devolucion)
          <div class="provider-item">

            <div class="provider-header">
              <span class="provider-id">ID: {{ $devolucion['idDevolucion'] }}</span>
              <span class="provider-status status-devolucion">DEVOLUCIÓN</span>
            </div>

            <div class="provider-name">{{ $devolucion['motivo'] }}</div>

            <div class="provider-info">
              <div class="info-row">
                <span class="info-label">Fecha:</span>
                <span>{{ \Carbon\Carbon::parse($devolucion['fechaDevolucion'])->format('d/m/Y') }}</span>
              </div>
              <div class="info-row">
                <span class="info-label">Cantidad:</span>
                <span>{{ $devolucion['cantidad'] }}</span>
              </div>
              <div class="info-row">
                <span class="info-label">ID Producto:</span>
                <span>{{ $devolucion['idProducto'] }}</span>
              </div>
              <div class="info-row">
                <span class="info-label">ID Orden:</span>
                <span>{{ $devolucion['idOrdenSalida'] }}</span>
              </div>
            </div>

            <div class="provider-actions">
              <button onclick="editarDevolucion({{ json_encode($devolucion) }})" class="btn-edit">
              Editar
              </button>
              
              <form action="{{ route('devoluciones.destroy') }}" method="POST" style="display: inline;" 
                    onsubmit="return confirm('¿Estás seguro de eliminar esta devolución?')">
                @csrf
                <input type="hidden" name="id" value="{{ $devolucion['idDevolucion'] }}">
                <button type="submit" class="btn-delete">
                Eliminar
                </button>
              </form>
            </div>
          </div>
        @empty
          <div class="no-data">
          No hay devoluciones registradas
          </div>
        @endforelse
      </div>
    </div>

  </div>

  <script>
    function editarDevolucion(devolucion) {

      document.getElementById('form-title').textContent = 'Editar Devolución #' + devolucion.idDevolucion;

      document.getElementById('form-devolucion').action = "{{ route('devoluciones.update') }}";

      document.getElementById('devolucion-id').value = devolucion.idDevolucion;
      document.getElementById('fechaDevolucion').value = devolucion.fechaDevolucion;
      document.getElementById('cantidad').value = devolucion.cantidad;
      document.getElementById('idProducto').value = devolucion.idProducto;
      document.getElementById('idOrdenSalida').value = devolucion.idOrdenSalida;
      document.getElementById('motivo').value = devolucion.motivo;

      document.getElementById('btn-text').textContent = 'Actualizar Devolución';
      document.getElementById('btn-cancel').style.display = 'inline-block';

      document.querySelector('.glass-card').scrollIntoView({ behavior: 'smooth' });
    }

    function cancelarEdicion() {
    
      document.getElementById('form-devolucion').reset();
      document.getElementById('form-devolucion').action = "{{ route('devoluciones.store') }}";
      document.getElementById('devolucion-id').value = '';
      document.getElementById('form-title').textContent = 'Registrar Nueva Devolución';
      document.getElementById('btn-text').textContent = 'Registrar Devolución';
      document.getElementById('btn-cancel').style.display = 'none';
    }
  </script>

</body>
</html>