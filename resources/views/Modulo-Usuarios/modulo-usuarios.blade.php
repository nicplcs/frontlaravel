<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Invex - Gestión de Usuarios</title>
  <link rel="stylesheet" href="{{ asset('css/stylegestionusuario.css') }}">
</head>
<body>
  <div class="header-nav">
    <a href="{{ route('inicio.administrador') }}" class="back-button">
      ← Volver
    </a>
    <div class="role-badge">Administrador</div>
  </div>

  <div class="main-container">
    <div class="page-title">
      <h1>Gestión de Usuarios</h1>
      <p>Sistema de información para automatización de productos</p>
    </div>

    <div class="welcome-section">
      <h2>¡Bienvenido!</h2>
      <p>Selecciona una opción del módulo:</p>
    </div>

    <div class="options-grid">
      <a href="{{ route('usuarios.gestion') }}" class="option-card">
        <div class="card-icon">
          <div class="icon-circle">
            <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="currentColor" viewBox="0 0 16 16">
              <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1zm-7.978-1L7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002-.014.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0M6.936 9.28a6 6 0 0 0-1.23-.247A7 7 0 0 0 5 9c-4 0-5 3-5 4q0 1 1 1h4.216A2.24 2.24 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816M4.92 10A5.5 5.5 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0m3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4"/>
            </svg>
          </div>
        </div>
        <div class="card-content">
          <h3 class="card-title">Administrar Usuarios</h3>
          <p class="card-description">Gestiona usuarios registrados y sus roles</p>
        </div>
      </a>

      <a href="{{ route('proveedores.gestion') }}" class="option-card">
        <div class="card-icon">
          <div class="icon-circle">
            <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="currentColor" viewBox="0 0 16 16">
              <path d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5zm1.294 7.456A2 2 0 0 1 4.732 11h5.536a2 2 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456M12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2m9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2"/>
            </svg>
          </div>
        </div>
        <div class="card-content">
          <h3 class="card-title">Gestión de Proveedores</h3>
          <p class="card-description">Control de proveedores asociados al sistema</p>
        </div>
      </a>
    </div>
  </div>

  <footer>
    <p>&copy; 2025 Invex. Todos los derechos reservados.</p>
  </footer>
</body>
</html>