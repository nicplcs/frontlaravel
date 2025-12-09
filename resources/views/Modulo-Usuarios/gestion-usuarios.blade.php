<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Usuarios - Invex</title>
  <link rel="stylesheet" href="{{ asset('css/styleusuario.css') }}">
</head>
<body>

  <div class="container">

    
    <a href="{{ route('modulo.usuarios') }}" class="btn-volver">
      ← Volver al Modulo</a>
    </div>

    <h1 class="titulo">
     <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" class="icon" fill="white">
  <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
</svg>
      Gestión de Usuarios
    </h1>

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

    {{-- Detectar si estamos editando --}}
    @php
      $editando = request()->has('editar');
      $usuarioEditar = null;
      
      if ($editando) {
        $usuarioEditar = collect($usuarios)->firstWhere('id_usuario', request()->get('editar'));
      }
    @endphp

    <div class="formulario-container">
      <h2 class="subtitulo">
        @if($editando && $usuarioEditar)
          Editar Usuario #{{ $usuarioEditar['id_usuario'] }}
        @else
          Agregar Usuario
        @endif
      </h2>
      
      <form action="{{ $editando && $usuarioEditar ? route('usuarios.update') : route('usuarios.store') }}" method="POST" class="formulario-usuario">
        @csrf
        
        {{-- Si estamos editando, agregar método PUT --}}
        @if($editando && $usuarioEditar)
          @method('PUT')
          <input type="hidden" name="id" value="{{ $usuarioEditar['id_usuario'] }}">
        @endif

        <div class="form-row">
          <div class="form-group">
            <label for="nombre">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
              </svg>
              Nombre:
            </label>
            <input type="text" id="nombre" name="nombre" placeholder="Ej: Juan Pérez" 
                   value="{{ $usuarioEditar['nombre'] ?? old('nombre') }}" required>
          </div>

          <div class="form-group">
            <label for="correo">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z"/>
              </svg>
              Correo:
            </label>
            <input type="email" id="correo" name="correo" placeholder="ejemplo@correo.com" 
                   value="{{ $usuarioEditar['correo'] ?? old('correo') }}" required>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="contrasena">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2m3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2"/>
              </svg>
              Contraseña:
            </label>
            <input type="password" id="contrasena" name="contrasena" 
                   placeholder="{{ $editando && $usuarioEditar ? 'Dejar vacío para no cambiar' : 'Mínimo 6 caracteres' }}" 
                   {{ $editando && $usuarioEditar ? '' : 'required' }}>
          </div>

          <div class="form-group">
            <label for="telefono">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.6 17.6 0 0 0 4.168 6.608 17.6 17.6 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.68.68 0 0 0-.58-.122l-2.19.547a1.75 1.75 0 0 1-1.657-.459L5.482 8.062a1.75 1.75 0 0 1-.46-1.657l.548-2.19a.68.68 0 0 0-.122-.58z"/>
              </svg>
              Teléfono:
            </label>
            <input type="tel" id="telefono" name="telefono" placeholder="Ej: 3001234567"
                   value="{{ $usuarioEditar['telefono'] ?? old('telefono') }}">
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="fecha_Nacimiento">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                <path d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5z"/>
                <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z"/>
              </svg>
              Fecha Nacimiento:
            </label>
           <input type="date" id="fecha_Nacimiento" name="fecha_Nacimiento"
       value="{{ isset($usuarioEditar['fecha_Nacimiento']) ? \Carbon\Carbon::parse($usuarioEditar['fecha_Nacimiento'])->format('Y-m-d') : old('fecha_Nacimiento') }}">
          </div>

          <div class="form-group">
            <label for="rol">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
              </svg>
              Rol:
            </label>
            <select id="rol" name="rol" required>
              <option value="">Seleccionar rol</option>
              <option value="administrador" {{ ($usuarioEditar['rol'] ?? old('rol')) == 'administrador' ? 'selected' : '' }}>Administrador</option>
              <option value="Empleado" {{ ($usuarioEditar['rol'] ?? old('rol')) == 'Empleado' ? 'selected' : '' }}>Empleado</option>
            </select>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="estado">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425z"/>
              </svg>
              Estado:
            </label>
            <select id="estado" name="estado" required>
              <option value="">Seleccionar estado</option>
              <option value="1" {{ ($usuarioEditar['estado'] ?? old('estado')) == '1' ? 'selected' : '' }}>Activo</option>
              <option value="0" {{ ($usuarioEditar['estado'] ?? old('estado')) == '0' ? 'selected' : '' }}>Inactivo</option>
            </select>
          </div>
        </div>

        <div class="form-actions">
          <button type="submit" class="btn-submit">
            @if($editando && $usuarioEditar)
              Actualizar Usuario
            @else
              Agregar Usuario
            @endif
          </button>
          
          @if($editando && $usuarioEditar)
            <a href="{{ route('usuarios.gestion') }}" class="btn-cancel">
              Cancelar
            </a>
          @endif
        </div>
      </form>
    </div>

    <div class="tabla-section">
      <h2 class="subtitulo">Listado de Usuarios</h2>
      
      <div class="tabla-container">
        <table class="tabla">
          <thead>
            <tr>
              <th>ID</th>
              <th>Nombre</th>
              <th>Correo</th>
              <th>Teléfono</th>
              <th>Fecha Nac.</th>
              <th>Rol</th>
              <th>Estado</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            @forelse($usuarios as $usuario)
              <tr>
                <td>{{ $usuario['id_usuario'] }}</td>
                <td>{{ $usuario['nombre'] }}</td>
                <td>{{ $usuario['correo'] }}</td>
                <td>{{ $usuario['telefono'] ?? '-' }}</td>
                <td>
                  @if(isset($usuario['fecha_Nacimiento']))
                    {{ \Carbon\Carbon::parse($usuario['fecha_Nacimiento'])->format('d/m/Y') }}
                  @else
                    -
                  @endif
                </td>
                <td>{{ $usuario['rol'] }}</td>
                <td>{{ $usuario['estado'] == '1' ? 'Activo' : 'Inactivo' }}</td>
                <td class="acciones">
                  <a href="{{ route('usuarios.gestion') }}?editar={{ $usuario['id_usuario'] }}" class="btn-edit">
                    Editar
                  </a>
                  
                  <form action="{{ route('usuarios.destroy') }}" method="POST" style="display: inline;" 
                        onsubmit="return confirm('¿Estás seguro de eliminar este usuario?')">
                    @csrf
                    <input type="hidden" name="id" value="{{ $usuario['id_usuario'] }}">
                    <button type="submit" class="btn-delete">
                    Eliminar
                    </button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="8" class="no-data">No hay usuarios registrados</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

  </div>

</body>
</html>