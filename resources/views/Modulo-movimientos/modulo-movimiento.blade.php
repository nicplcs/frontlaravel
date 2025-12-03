<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Punto Éxito - Gestión de Movimientos</title><img src="../imagenes/camion.png" alt="Gestión Movimientos" width="20" height="20"> 
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/stylegestionmovimientos.css">
</head>
<body>

  <!-- VIDEO DE FONDO -->
  <video class="video-fondo" autoplay loop muted>
    <source src="{{ asset('videos/proovedores.mp4') }}" type="video/mp4">
    Tu navegador no soporta el video.
  </video>

  <!-- HEADER -->
  <header class="d-flex justify-content-between align-items-center px-4 py-3">
    <div class="rol-texto text-light">Rol: Administrador</div>

    <div class="text-center text-light">
      <h1 class="mb-0">Gestión de Movimientos</h1>
      <p class="mb-0">Sistema de información para automatización de productos</p>
    </div>

    <div class="dropdown">
      <button class="btn dropdown-toggle perfil-dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        <img src="../imagenes/perfil.png" alt="Perfil" width="20" height="20">
      </button>
      <ul class="dropdown-menu dropdown-menu-end">
        <li><a class="dropdown-item" href="../paginas/perfil.html">Mi perfil</a></li>
        <li><a class="dropdown-item" href="../backend/logout.php">Cerrar sesión</a></li>
      </ul>
    </div>
  </header>

  <!-- MAIN -->
  <main>
    <div class="bienvenida-wrapper">
      <span class="icono-lateral">
        <svg xmlns="http://www.w3.org/2000/svg" width="46" height="46" fill="currentColor" class="bi bi-arrow-left-right" viewBox="0 0 16 16">
          <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-2.147-2.146a.5.5 0 0 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
        </svg>
      </span>

      <div class="bienvenida-texto">
        <h2>¡Bienvenido!</h2>
        <p>Selecciona una opción del módulo:</p>
      </div>

      <span class="icono-lateral">
        <svg xmlns="http://www.w3.org/2000/svg" width="46" height="46" fill="currentColor" class="bi bi-truck" viewBox="0 0 16 16">
          <path d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5z"/>
        </svg>
      </span>
    </div>

    <ul class="opciones-modulo">
      <li>
        <a href="/registrar-devolucion">
          <div class="icono"><i class="bi bi-arrow-counterclockwise"></i></div>
          <div class="titulo">Devoluciones</div>
          <div class="descripcion">Gestiona productos devueltos por errores o daños</div>
        </a>
      </li>

      <li>
        <a href="/consultar-movimiento">
          <div class="icono"><i class="bi bi-list-columns-reverse"></i></div>
          <div class="titulo">Ver Movimientos</div>
          <div class="descripcion">Consulta entradas y salidas registradas</div>
        </a>
      </li>
    </ul>

    <div class="volver">
      <a href="../general/inicio-desbloqueado.html">
        <img src="../imagenes/flecha-izquierda.png"  width="16" height="16"> Volver a la pagina principal
      </a>
    </div>
  </main>

  <!-- FOOTER -->
  <footer>
    <p>&copy; 2025 Invex. Todos los derechos reservados.</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
