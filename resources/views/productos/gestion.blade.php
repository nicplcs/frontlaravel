<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Invex - Gestión de Productos</title>
  <link rel="stylesheet" href="{{ asset('css/stylegestionproductos.css') }}" />
</head>
<body>


  <div class="volver">
    <a href="{{ route('inicio.administrador') }}">
      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
      </svg>
      Volver al inicio
    </a>
  </div>

  
  <video autoplay muted loop class="video-fondo">
    <source src="{{ asset('videos/cocacola.mp4') }}" type="video/mp4"> 
    Tu navegador no admite la etiqueta de video.
  </video>
  <div class="overlay"></div>


  <div class="header-logo">
    <img src="{{ asset('imagenes/logo.png') }}" alt="Logo Punto Éxito" />
  </div>


  <a href="{{ route('login') }}" class="cerrar-sesion">
    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
      <path fill-rule="evenodd" d="M10 15a1 1 0 0 1-1 1H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h7a1 1 0 0 1 0 2H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h7a1 1 0 0 1 1 1z"/>
      <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
    </svg>
    Cerrar sesión
  </a>


  <header>
    <h1>
      <svg xmlns="http://www.w3.org/2000/svg" width="36" height="30" fill="currentColor" class="bi bi-box-seam-fill" viewBox="0 0 16 16">
        <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2zM11.75 2.54 5.596 5 8 5.961l6.154-2.461zM15 4.24l-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923z"/>
      </svg>
      Gestión de Productos
    </h1>
    <p>Sistema de información para automatización de productos</p>
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
        <a href="{{ route('productos.consultar') }}">
          <div class="icono">
            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-box2" viewBox="0 0 16 16">
              <path d="M2.95.4a1 1 0 0 1 .8-.4h8.5a1 1 0 0 1 .8.4l2.85 3.8a.5.5 0 0 1 .1.3V15a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V4.5a.5.5 0 0 1 .1-.3zM7.5 1H3.75L1.5 4h6zm1 0v3h6l-2.25-3zM15 5H1v10h14z"/>
            </svg>
          </div>
          <div class="titulo">Consultar inventario</div>
          <div class="descripcion">Ver, editar y gestionar productos.</div>
        </a>
      </li>
      <li>
        <a href="{{ route('productos.entrada') }}">
          <div class="icono">
            <svg xmlns="http://www.w3.org/2000/svg" width="66" height="66" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
              <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
            </svg>
          </div>
          <div class="titulo">Entrada Productos</div>
          <div class="descripcion">Agregar stock al inventario.</div>
        </a>
      </li>
      <li>
        <a href="{{ route('productos.salida') }}">
          <div class="icono">
            <svg xmlns="http://www.w3.org/2000/svg" width="66" height="66" fill="currentColor" class="bi bi-dash" viewBox="0 0 16 16">
              <path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8"/>
            </svg>
          </div>
          <div class="titulo">Salida Productos</div>
          <div class="descripcion">Registrar ventas y reducir stock.</div>
        </a>
      </li>
      <li>
        <a href="{{ route('productos.registrar') }}">
          <div class="icono">
            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-clipboard-plus" viewBox="0 0 16 16">
              <path fill-rule="evenodd" d="M8 7a.5.5 0 0 1 .5.5V9H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V10H6a.5.5 0 0 1 0-1h1.5V7.5A.5.5 0 0 1 8 7"/>
              <path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1z"/>
              <path d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0z"/>
            </svg>
          </div>
          <div class="titulo">Registrar Productos</div>
          <div class="descripcion">Crear productos nuevos.</div>
        </a>
      </li>
    </ul>
  </main>

  <footer>
    <p>&copy; 2025 Invex. Todos los derechos reservados.</p>
  </footer>

</body>
</html>