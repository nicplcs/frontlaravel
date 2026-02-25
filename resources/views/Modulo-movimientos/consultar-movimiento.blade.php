<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Movimientos - Invex</title>
  <link rel="stylesheet" href="{{ asset('css/styleconsultarmovimiento.css') }}">
</head>
<body>


  <div class="header-nav">
    <a href="{{ route('modulo.movimiento') }}" class="back-button">
      ← Volver
    </a>
  </div>

  <div class="main-container">

    <div class="page-title">
      <h1>Movimientos</h1>
      <p>Gestiona el inventario de tu almacén</p>
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

    <div class="search-container">
  <div class="search-bar">
    <span class="search-icon">
      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
      </svg>
    </span>
    <input 
      type="text" 
      id="searchInput" 
      class="search-input" 
      placeholder="Buscar por ID, descripción, usuario o tipo..."
      onkeyup="filtrarMovimientos()">
    <button 
      id="clearSearch" 
      class="clear-btn" 
      style="display: none;" 
      onclick="limpiarBusqueda()">✕</button>
  </div>
</div>

    <div class="providers-container">
      <div class="table-header">
        Lista de Movimientos ({{ count($movimientos) }})
      </div>

      <div class="providers-list">
        @forelse($movimientos as $movimiento)
          <div class="provider-item" data-movimiento='@json($movimiento)'>

            <div class="provider-header">
              <span class="provider-id">ID: {{ $movimiento['id_movimiento'] }}</span>
              <span class="provider-status status-{{ strtolower($movimiento['tipo']) }}">
                {{ strtoupper($movimiento['tipo']) }}
              </span>
            </div>

            <div class="provider-name">{{ $movimiento['descripcion'] }}</div>

            <div class="provider-info">
              <div class="info-row">
                <span class="info-label">Usuario:</span>
                <span>{{ $movimiento['usuario_responsable'] }}</span>
              </div>
              <div class="info-row">
                <span class="info-label">Fecha:</span>
                <span>{{ \Carbon\Carbon::parse($movimiento['fecha'])->format('d/m/Y H:i') }}</span>
              </div>
              <div class="info-row">
                <span class="info-label">Acción:</span>
                <span>{{ $movimiento['accion'] }}</span>
              </div>
              <div class="info-row">
                <span class="info-label">Cantidad:</span>
                <span>{{ $movimiento['cantidad'] }}</span>
              </div>
              <div class="info-row">
                <span class="info-label">ID Producto:</span>
                <span>{{ $movimiento['id_producto'] ?? '—' }}</span>
              </div>
            </div>

            <div class="provider-actions">
  <button 
    onclick="descargarPDF({{ $movimiento['id_movimiento'] }})" 
    class="btn-pdf"
    title="Descargar PDF">
    PDF
  </button>
  <button 
    onclick="mostrarModalEliminar({{ $movimiento['id_movimiento'] }})" 
    class="btn-delete">
    Eliminar
  </button>
</div>
          </div>
        @empty
          <div class="no-data">
            No hay movimientos registrados
          </div>
        @endforelse
      </div>
    </div>

  </div>

  <script>

    function filtrarMovimientos() {
      const input = document.getElementById('searchInput');
      const filter = input.value.toLowerCase().trim();
      const clearBtn = document.getElementById('clearSearch');
      const items = document.querySelectorAll('.provider-item');

      clearBtn.style.display = filter ? 'block' : 'none';
      
      let visibleCount = 0;
      
      items.forEach(item => {
        const movimiento = JSON.parse(item.getAttribute('data-movimiento'));
        const searchText = `
          ${movimiento.id_movimiento}
          ${movimiento.descripcion}
          ${movimiento.usuario_responsable}
          ${movimiento.tipo}
          ${movimiento.accion}
          ${movimiento.id_producto || ''}
        `.toLowerCase();
        
        if (searchText.includes(filter)) {
          item.style.display = '';
          visibleCount++;
        } else {
          item.style.display = 'none';
        }
      });

      const header = document.querySelector('.table-header');
      const totalItems = items.length;
      if (filter) {
        header.textContent = `Mostrando ${visibleCount} de ${totalItems} movimientos`;
      } else {
        header.textContent = `Lista de Movimientos (${totalItems})`;
      }
    }

    function limpiarBusqueda() {
      document.getElementById('searchInput').value = '';
      filtrarMovimientos();
    }

    document.getElementById('searchInput').addEventListener('input', function() {
      document.getElementById('clearSearch').style.display = this.value ? 'block' : 'none';
    });

    function descargarPDF(idMovimiento) {
      const url = `http://localhost:8080/movimientos/${idMovimiento}/pdf`;
      window.open(url, '_blank');
    }
    let movimientoAEliminar = null;

function mostrarModalEliminar(idMovimiento) {
  movimientoAEliminar = idMovimiento;
  document.getElementById('modalEliminar').style.display = 'block';
  document.getElementById('passwordConfirm').value = '';
  document.getElementById('errorMessage').style.display = 'none';
  document.getElementById('passwordConfirm').focus();
}

function cerrarModal() {
  document.getElementById('modalEliminar').style.display = 'none';
  movimientoAEliminar = null;
}

async function confirmarEliminacion() {
  const password = document.getElementById('passwordConfirm').value;
  const errorDiv = document.getElementById('errorMessage');
  
  if (!password) {
    errorDiv.textContent = 'Por favor ingresa tu contraseña';
    errorDiv.style.display = 'block';
    return;
  }
  
  try {
    const formData = new FormData();
    formData.append('password', password);
    formData.append('id_movimiento', movimientoAEliminar);
    formData.append('_token', '{{ csrf_token() }}');
    
    const response = await fetch('{{ url("/validar-password-eliminar") }}', {
      method: 'POST',
      body: formData
    });
    
    const resultado = await response.json();
    
    if (resultado.success) {
      cerrarModal();
      alert(resultado.mensaje);
      location.reload();
    } else {
      errorDiv.textContent = resultado.mensaje;
      errorDiv.style.display = 'block';
      document.getElementById('passwordConfirm').value = '';
      document.getElementById('passwordConfirm').focus();
    }
  } catch (error) {
    console.error('Error:', error);
    errorDiv.textContent = 'Error de conexión con el servidor';
    errorDiv.style.display = 'block';
  }
}
window.onclick = function(event) {
  const modal = document.getElementById('modalEliminar');
  if (event.target == modal) {
    cerrarModal();
  }
}

document.addEventListener('keypress', function(e) {
  if (e.key === 'Enter' && document.getElementById('modalEliminar').style.display === 'block') {
    confirmarEliminacion();
  }
});
  </script>
<div id="modalEliminar" class="modal" style="display: none;">
  <div class="modal-content">
    <div class="modal-header">
      <h2>Confirmar Eliminación</h2>
      <span class="close-modal" onclick="cerrarModal()">&times;</span>
    </div>
    
<div class="modal-body">
  <p>Para eliminar este movimiento, confirma tu contraseña:</p>
  
  <div class="form-group">
    <label for="correoUsuario">Usuario:</label>
    <input 
      type="text" 
      id="correoUsuario" 
      class="input-modal" 
      value="{{ session('nombre') ?? 'Usuario' }}"
      readonly>
  </div>
  
  <div class="form-group">
    <label for="passwordConfirm">Contraseña:</label>
    <input 
      type="password" 
      id="passwordConfirm" 
      class="input-modal" 
      placeholder="Ingresa tu contraseña"
      autofocus>
  </div>
  
  <div id="errorMessage" class="error-message" style="display: none;"></div>
</div>
    
    <div class="modal-footer">
      <button onclick="cerrarModal()" class="btn-cancelar">Cancelar</button>
      <button onclick="confirmarEliminacion()" class="btn-confirmar">Confirmar</button>
    </div>
  </div>
</div>

</body>
</html>