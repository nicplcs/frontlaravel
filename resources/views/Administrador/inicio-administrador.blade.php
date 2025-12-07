<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Invex - Dashboard</title>


  <link rel="stylesheet" href="{{ asset('css/styleiniciodesbloq.css') }}">


  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">


  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;800&display=swap" rel="stylesheet">
</head>

<body>


  <video autoplay muted loop class="video-fondo">
    <source src="{{ asset('videos/city_2.mp4') }}" type="video/mp4">
    Tu navegador no soporta el video.
  </video>


  <div class="overlay"></div>


  <header>
    <div class="header-logo">
      <img src="{{ asset('videosdefondo/logo.png') }}" alt="Logo Invex">
    </div>
    <h1>Bienvenido a Invex</h1>
    <p>Sistema de información para automatización de productos</p>


    <input type="checkbox" id="toggle-user-menu" class="toggle-user-menu">
    <label for="toggle-user-menu" class="user-icon">
      <img src="{{ asset('imagenes/engranaje.webp') }}" alt="Engranaje" width="20" height="20">
    </label>


    <div class="user-menu">
      <img src="{{ asset('img_productos/usuario.png') }}" alt="Usuario" class="user-avatar">
      <p class="user-name">{{ session('nombre', 'Usuario') }}</p>
      <p class="user-role">Rol: {{ session('rol', 'Administrador') }}</p>
      <a href="{{ route('logout') }}" class="logout-btn">Cerrar sesión</a>
    </div>
  </header>

  <main>
    <div class="bienvenida-wrapper">
      <div class="bienvenida-texto">
        <h2>¡Bienvenido!</h2>
        <p>Selecciona uno de los módulos:</p>
      </div>
    </div>

    <ul>
      <li>
        <a href="{{ route('modulo.movimiento') }}">
          <div class="icono">
            <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" fill="currentColor"
              class="bi bi-folder2-open" viewBox="0 0 16 16">
              <path
                d="M1 3.5A1.5 1.5 0 0 1 2.5 2h2.764c.958 0 1.76.56 2.311 1.184C7.985 3.648 8.48 4 9 4h4.5A1.5 1.5 0 0 1 15 5.5v.64c.57.265.94.876.856 1.546l-.64 5.124A2.5 2.5 0 0 1 12.733 15H3.266a2.5 2.5 0 0 1-2.481-2.19l-.64-5.124A1.5 1.5 0 0 1 1 6.14zM2 6h12v-.5a.5.5 0 0 0-.5-.5H9c-.964 0-1.71-.629-2.174-1.154C6.374 3.334 5.82 3 5.264 3H2.5a.5.5 0 0 0-.5.5zm-.367 1a.5.5 0 0 0-.496.562l.64 5.124A1.5 1.5 0 0 0 3.266 14h9.468a1.5 1.5 0 0 0 1.489-1.314l.64-5.124A.5.5 0 0 0 14.367 7z" />
            </svg>
          </div>
          <div class="titulo">Gestión de Movimientos</div>
          <div class="descripcion">Entrada y salida de productos.</div>
        </a>
      </li>

      <li>
        <a href="{{ route('productos.gestion') }}">
          <div class="icono">
            <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" fill="currentColor" class="bi bi-cart"
              viewBox="0 0 16 16">
              <path
                d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2" />
            </svg>
          </div>
          <div class="titulo">Gestión de Productos</div>
          <div class="descripcion">Registra y organiza el inventario.</div>
        </a>
      </li>

      <li>
        <a href="{{ route('modulo.usuarios') }}">
          <div class="icono">
            <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" fill="currentColor"
              class="bi bi-person-lines-fill" viewBox="0 0 16 16">
              <path
                d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5m.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1z" />
            </svg>
          </div>
          <div class="titulo">Gestión de Usuarios</div>
          <div class="descripcion">Control de roles y usuarios.</div>
        </a>
      </li>
    </ul>
  </main>

  <footer>
    <p>&copy; 2025 Invex. Todos los derechos reservados.</p>
  </footer>

</body>

</html>