<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Invex - Plataforma de Gestión</title>
  <link rel="stylesheet" href="{{ asset('css/styleiniciobloq.css') }}" />
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;800&display=swap" rel="stylesheet">
</head>

<body>

  <!-- Video de fondo -->
  <video autoplay muted loop playsinline class="video-fondo">
    <source src="{{ asset('videos/imageninicios.mp4') }}" type="video/mp4">
  </video> 

  <!-- Overlay -->
  <div class="overlay"></div>
 
  <!-- Header -->
  <header class="header">
    <div class="logo">
      <img src="{{ asset('imagenes/logo.png') }}" alt="Logo Invex">
      <h1>Invex</h1>
    </div>
    <nav class="navegacion">
      <a href="{{ url('/login') }}">Iniciar Sesión</a>
      <a href="{{ url('/registro') }}" class="btn-acceso">Registrarse</a>
    </nav>
  </header>

  <!-- Main Content -->
  <main>
    <!-- Hero Section -->
    <section class="hero">
      <div class="texto-hero">
        <h2>
          ¡Usa tu inventario de manera eficiente!
          <span>Desde una sola plataforma</span>
        </h2>
        <p>Gestiona productos, empleados y proveedores con facilidad, precisión y velocidad.</p>
      </div>
    </section>

    <!-- Beneficios Section -->
    <section class="beneficios">
      
      <!-- Control de inventario -->
      <div class="beneficio">
        <h3>
          <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" viewBox="0 0 16 16">
            <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2zm3.564 1.426L5.596 5 8 5.961 14.154 3.5zm3.25 1.7-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464z"/>
          </svg>
          Control de inventario
        </h3>
        <p>Revisa el stock en tiempo real y evita pérdidas.</p>
      </div>

      <!-- Gestión de usuarios -->
      <div class="beneficio">
        <h3>
          <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" viewBox="0 0 16 16">
            <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1zm-7.978-1L7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002-.014.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0M6.936 9.28a6 6 0 0 0-1.23-.247A7 7 0 0 0 5 9c-4 0-5 3-5 4q0 1 1 1h4.216A2.24 2.24 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816M4.92 10A5.5 5.5 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0m3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4"/>
          </svg>
          Gestión de usuarios
        </h3>
        <p>Administra roles y permisos de forma segura.</p>
      </div>

      <!--Proveedores -->
      <div class="beneficio">
        <h3>
          <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" viewBox="0 0 16 16">
            <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .49.598l-1 5a.5.5 0 0 1-.465.401l-9.397.472L4.415 11H13a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l.84 4.479 9.144-.459L13.89 4zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
          </svg>
          Proveedores
        </h3>
        <p>Registra y controla los insumos recibidos.</p>
      </div>

    </section>
  </main>

  <!-- Footer -->
  <footer>
    <p>&copy; 2025 Invex. Todos los derechos reservados.</p>
  </footer>

</body>
</html>