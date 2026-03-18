<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Consulta de Proveedores - Invex</title>
  <link rel="stylesheet" href="{{ asset('css/styleproveedores.css') }}">
</head>
<body>

  <div class="header-nav">
    <a href="{{ route('inicio.empleado') }}" class="back-button">← Volver al Dashboard</a>
  </div>

  <div class="main-container">

    <div class="page-title">
      <h1>Gestión de Proveedores</h1>
      <p>Consulta de proveedores registrados</p>
    </div>

    {{-- Filtros --}}
    <div class="glass-card">
      <h2 class="card-header">Filtros de búsqueda</h2>

      <form method="GET" action="{{ route('empleado.proveedores.consultar') }}">
        <div class="form-grid">

          <div class="form-group">
            <label>Nombre</label>
            <input type="text" name="nombre" value="{{ request('nombre') }}">
          </div>

          <div class="form-group">
            <label>Estado</label>
            <select name="estado">
              <option value="">Todos</option>
              <option value="1" {{ request('estado') === '1' ? 'selected' : '' }}>Activo</option>
              <option value="0" {{ request('estado') === '0' ? 'selected' : '' }}>Inactivo</option>
            </select>
          </div>

        </div>

        <div class="form-actions">
          <button type="submit" class="btn btn-submit">Filtrar</button>
          <a href="{{ route('empleado.proveedores.consultar') }}" class="btn btn-cancel">Limpiar</a>
        </div>
      </form>
    </div>

    {{-- Listado --}}
    <div class="providers-container">
      <div class="table-header">
        Proveedores Registrados
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
              <div class="provider-name">{{ $proveedor['nombre'] }}</div>

              <div class="info-row">
                <span class="info-label">Teléfono:</span>
                <span>{{ $proveedor['telefono'] }}</span>
              </div>

              <div class="info-row">
                <span class="info-label">Correo:</span>
                <span>{{ $proveedor['correo'] }}</span>
              </div>

              <div class="info-row">
                <span class="info-label">Dirección:</span>
                <span>{{ $proveedor['direccion'] }}</span>
              </div>
            </div>

          </div>
        @empty
          <div class="no-data">
            No hay proveedores para mostrar
          </div>
        @endforelse
      </div>
    </div>

  </div>

</body>
</html>