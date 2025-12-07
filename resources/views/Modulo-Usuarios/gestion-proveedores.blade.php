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
    <div class="role-badge">Rol: Administrador</div>
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
            @if(request()->has('edit'))
              Actualizar Proveedor
            @else
              Agregar Proveedor
            @endif
          </button>
          
          @if(request()->has('edit'))
            <a href="{{ route('proveedores.gestion') }}" class="btn btn-cancel">
              Cancelar
            </a>
          @endif
        </div>
      </form>
    </div>

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
              
              <form action="{{ route('proveedores.destroy') }}" method="POST" style="display: inline;" 
                    onsubmit="return confirm('¿Estás seguro de eliminar este proveedor?')">
                @csrf
                <input type="hidden" name="id" value="{{ $proveedor['id_proveedor'] ?? $proveedor['id'] }}">
                <button type="submit" class="btn-delete">
                  Eliminar
                </button>
              </form>
            </div>
          </div>
        @empty
          <div class="no-data">
            No hay proveedores registrados
          </div>
        @endforelse
      </div>
    </div>
  </div>

</body>
</html>