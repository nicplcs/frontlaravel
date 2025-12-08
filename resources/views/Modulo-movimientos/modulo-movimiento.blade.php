<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Invex - Gestión de Movimientos</title>
  <link rel="stylesheet" href="{{ asset('css/stylegestionmovimientos.css') }}">
</head>
<body>

  <div class="header-nav">
    <a href="{{ url('/inicio') }}" class="back-button">
      ← Volver
    </a>
    <div class="role-badge">Administrador</div>
  </div>

  <div class="main-container">

    <div class="page-title">
      <h1>Gestión de Inventario</h1>
      <p>Sistema de información para automatización de productos</p>
    </div>

    <div class="welcome-section">
      <h2>¡Bienvenido!</h2>
      <p>Selecciona una opción del módulo:</p>
    </div>

    <div class="options-grid">

      <a href="{{ url('/registrar-devolucion') }}" class="option-card">
    <div class="card-icon">
      <div class="icon-circle">
    
        <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="currentColor" viewBox="0 0 16 16">
          <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2z"/>
          <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466"/>
        </svg>
      </div>
    </div>
    <div class="card-content">
      <h3 class="card-title">Devoluciones</h3>
      <p class="card-description">Gestiona productos devueltos por errores o daños</p>
    </div>
  </a>

      <a href="{{ url('/consultar-movimiento') }}" class="option-card">
  <div class="card-icon">
    <div class="icon-circle">
    
      <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="currentColor" viewBox="0 0 16 16">
        <path d="M4 11H2v3h2zm5-4H7v7h2zm5-5v12h-2V2zm-2-1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM6 7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1zm-5 4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1z"/>
      </svg>
    </div>
  </div>
  <div class="card-content">
    <h3 class="card-title">Ver Movimientos</h3>
    <p class="card-description">Consulta entradas y salidas registradas</p>
  </div>
</a>

    </div>

  </div>

  <footer>
    <p>&copy; 2025 Invex. Todos los derechos reservados.</p>
  </footer>

</body>
</html>