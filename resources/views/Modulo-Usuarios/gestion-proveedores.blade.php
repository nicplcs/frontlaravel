<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Gestión de Proveedores - Invex</title>
  <link rel="stylesheet" href="{{ asset('css/styleproveedores.css') }}">
</head>
<body>

  <div class="header-nav">
    <a href="{{ route('modulo.usuarios') }}" class="back-button">← Volver al módulo</a>
  </div>

  <div class="main-container">
    <div class="page-title">
      <h1>
        <svg xmlns="http://www.w3.org/2000/svg" width="45" height="40" fill="currentColor" viewBox="0 0 15 15">
          <path d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5z"/>
        </svg>
        Gestión de Proveedores
      </h1>
      <p>Control y administración de proveedores del sistema</p>
    </div>

    @if(session('success'))
      <div class="alert-success">{{ session('success') }}</div>
    @endif

    @if(isset($error) || session('error'))
      <div class="alert-error">{{ $error ?? session('error') }}</div>
    @endif

    {{-- FORMULARIO AGREGAR / EDITAR --}}
    <div class="glass-card">
      <h2 class="card-header">
        @if(request()->has('edit'))
          Editar Proveedor #{{ request()->get('id') }}
        @else
          Agregar Proveedor
        @endif
      </h2>

      <form action="{{ request()->has('edit') ? route('proveedores.update') : route('proveedores.store') }}" method="POST">
        @csrf

        @if(request()->has('edit'))
          <input type="hidden" name="id" value="{{ request()->get('id') }}">
        @endif

        <div class="form-grid">
          <div class="form-group">
            <label for="nombre">Nombre del Proveedor</label>
            <input type="text" id="nombre" name="nombre"
                   placeholder="Ej: Coca-Cola"
                   value="{{ old('nombre', request()->get('nombre', '')) }}"
                   required>
          </div>

          <div class="form-group">
            <label for="telefono">Teléfono</label>
            <input type="text" id="telefono" name="telefono"
                   placeholder="Ej: 3001234567"
                   value="{{ old('telefono', request()->get('telefono', '')) }}"
                   required>
          </div>

          <div class="form-group">
            <label for="correo">Correo Electrónico</label>
            <input type="email" id="correo" name="correo"
                   placeholder="Ej: proveedor@ejemplo.com"
                   value="{{ old('correo', request()->get('correo', '')) }}"
                   required>
          </div>

          <div class="form-group">
            <label for="direccion">Dirección</label>
            <input type="text" id="direccion" name="direccion"
                   placeholder="Ej: Calle 123 #45-67"
                   value="{{ old('direccion', request()->get('direccion', '')) }}"
                   required>
          </div>

          <div class="form-group">
            <label for="estado">Estado</label>
            <select id="estado" name="estado" required>
              <option value="">Seleccionar estado</option>
              <option value="1" {{ old('estado', request()->get('estado', '')) == '1' ? 'selected' : '' }}>Activo</option>
              <option value="0" {{ old('estado', request()->get('estado', '')) == '0' ? 'selected' : '' }}>Inactivo</option>
            </select>
          </div>
        </div>

        <div class="form-actions">
          <button type="submit" class="btn btn-submit">
            @if(request()->has('edit')) Actualizar Proveedor @else Agregar Proveedor @endif
          </button>

          @if(request()->has('edit'))
            <a href="{{ route('proveedores.gestion') }}" class="btn btn-cancel">Cancelar</a>
          @endif
        </div>
      </form>
    </div>

    {{-- LISTADO DE PROVEEDORES --}}
    <div class="providers-container">
      <div class="table-header">
        Listado de Proveedores Registrados
      </div>

      <div class="providers-list">
        @forelse($proveedores as $proveedor)
          <div class="provider-item">
            <div class="provider-header">
              <span class="provider-id">#{{ $proveedor['id_proveedor'] ?? $proveedor['id'] }}</span>
              <span class="provider-status {{ ($proveedor['estado'] ?? '1') == '1' ? 'status-activo' : 'status-inactivo' }}">
                {{ ($proveedor['estado'] ?? '1') == '1' ? 'Activo' : 'Inactivo' }}
              </span>
            </div>

            <div class="provider-info">
              <div class="provider-name">{{ $proveedor['nombre'] ?? '-' }}</div>

              <div class="info-row">
                <span class="info-label">Teléfono:</span>
                <span>{{ $proveedor['telefono'] ?? '-' }}</span>
              </div>

              <div class="info-row">
                <span class="info-label">Correo:</span>
                <span>{{ $proveedor['correo'] ?? '-' }}</span>
              </div>

              <div class="info-row">
                <span class="info-label">Dirección:</span>
                <span>{{ $proveedor['direccion'] ?? '-' }}</span>
              </div>
            </div>

            <div class="provider-actions">
              <a href="{{ route('proveedores.gestion') }}?edit=1&id={{ $proveedor['id_proveedor'] ?? $proveedor['id'] }}&nombre={{ urlencode($proveedor['nombre'] ?? '') }}&telefono={{ urlencode($proveedor['telefono'] ?? '') }}&correo={{ urlencode($proveedor['correo'] ?? '') }}&direccion={{ urlencode($proveedor['direccion'] ?? '') }}&estado={{ $proveedor['estado'] ?? '' }}"
                 class="btn-edit">
                Editar
              </a>

              {{-- Solo mostrar Desactivar si está activo --}}
              @if(($proveedor['estado'] ?? '1') == '1')
                <button
                  onclick="mostrarModalDesactivar({{ $proveedor['id_proveedor'] ?? $proveedor['id'] }}, '{{ addslashes($proveedor['nombre'] ?? '') }}')"
                  class="btn-delete">
                  Desactivar
                </button>
              @else
                <span class="badge-inactivo">Inactivo</span>
              @endif
            </div>
          </div>
        @empty
          <div class="no-data">No hay proveedores registrados</div>
        @endforelse
      </div>
    </div>
  </div>

  {{-- ══════════ MODAL DOBLE AUTENTICACIÓN ══════════ --}}
  <div id="modalDesactivar" class="modal" style="display: none;">
    <div class="modal-content">
      <div class="modal-header">
        <h2>Confirmar Desactivación</h2>
        <span class="close-modal" onclick="cerrarModal()">&times;</span>
      </div>

      <div class="modal-body">
        <p>Para desactivar al proveedor <strong id="nombreProveedorModal"></strong>, confirma tu contraseña:</p>

        <div class="form-group">
          <label for="modalUsuario">Tu usuario:</label>
          <input type="text" id="modalUsuario" class="input-modal"
                 value="{{ session('nombre') ?? 'Usuario' }}" readonly>
        </div>

        <div class="form-group">
          <label for="modalPassword">Contraseña:</label>
          <input type="password" id="modalPassword" class="input-modal"
                 placeholder="Ingresa tu contraseña">
        </div>

        <div id="modalError" class="error-message" style="display: none;"></div>
      </div>

      <div class="modal-footer">
        <button onclick="cerrarModal()" class="btn-cancelar">Cancelar</button>
        <button onclick="confirmarDesactivacion()" class="btn-confirmar">Confirmar</button>
      </div>
    </div>
  </div>
  {{-- ════════════════════════════════════════════════ --}}

  <script>
    let proveedorADesactivar = null;

    function mostrarModalDesactivar(idProveedor, nombreProveedor) {
      proveedorADesactivar = idProveedor;
      document.getElementById('nombreProveedorModal').textContent = nombreProveedor;
      document.getElementById('modalDesactivar').style.display = 'flex';
      document.getElementById('modalPassword').value = '';
      document.getElementById('modalError').style.display = 'none';
      setTimeout(() => document.getElementById('modalPassword').focus(), 150);
    }

    function cerrarModal() {
      document.getElementById('modalDesactivar').style.display = 'none';
      proveedorADesactivar = null;
    }

    async function confirmarDesactivacion() {
      const password = document.getElementById('modalPassword').value;
      const errorDiv = document.getElementById('modalError');

      if (!password) {
        errorDiv.textContent = 'Por favor ingresa tu contraseña';
        errorDiv.style.display = 'block';
        return;
      }

      try {
        const formData = new FormData();
        formData.append('password',      password);
        formData.append('id_proveedor',  proveedorADesactivar);
        formData.append('_token',        '{{ csrf_token() }}');

        const response = await fetch('{{ route("proveedores.validar.desactivar") }}', {
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
          document.getElementById('modalPassword').value = '';
          document.getElementById('modalPassword').focus();
        }
      } catch (error) {
        console.error('Error:', error);
        errorDiv.textContent = 'Error de conexión con el servidor';
        errorDiv.style.display = 'block';
      }
    }

    // Cerrar al hacer clic fuera del modal
    window.onclick = function(event) {
      const modal = document.getElementById('modalDesactivar');
      if (event.target === modal) cerrarModal();
    };

    // Confirmar con Enter
    document.addEventListener('keypress', function(e) {
      if (e.key === 'Enter' && document.getElementById('modalDesactivar').style.display === 'flex') {
        confirmarDesactivacion();
      }
    });
  </script>

</body>
</html>