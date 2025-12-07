<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Invex - Gestión de Usuarios</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="{{ asset('css/stylegestionusuario.css') }}">
</head>
<body>

  <video id="video-fondo" autoplay loop muted playsinline>
    <source src="{{ asset('videos/videousuario.mp4') }}" type="video/mp4">
  </video>

  <div class="contenido">

    <header>
      <div class="barra-superior">
        <div class="lado-izquierdo">
          <a href="{{ route('inicio.administrador') }}" class="btn-volver">
            Volver al panel
          </a>
        </div>
        <a href="{{ route('login') }}" class="btn-cerrar">
          Cerrar sesión
        </a>
      </div>

      <div class="titulo-central">
        <h1>Gestión de Usuarios</h1>
        <p>Sistema de información para automatización de productos</p>
      </div>
    </header>

    <main>
      <div class="bienvenida-wrapper">
        <div class="bienvenida-texto">
          <h2>¡Bienvenido!</h2>
          <p>Selecciona una opción del módulo:</p>
        </div>
      </div>

      <ul>
        <li>
          <a href="{{ route('usuarios.gestion') }}">
            <div class="icono">
              <i class="bi bi-people-fill"></i>
            </div>
            <div class="titulo">Administrar Usuarios</div>
            <div class="descripcion">Gestiona usuarios registrados y sus roles</div>
          </a>
        </li>

        <li>
          <a href="{{ route('proveedores.gestion') }}">
            <div class="icono">
              <i class="bi bi-truck"></i>
            </div>
            <div class="titulo">Gestión de Proveedores</div>
            <div class="descripcion">Control de proveedores asociados al sistema</div>
          </a>
        </li>
      </ul>
    </main>

    <footer>
      <p>&copy; 2025 Invex. Todos los derechos reservados.</p>
    </footer>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>