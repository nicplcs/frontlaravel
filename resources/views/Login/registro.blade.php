<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Registrarse - Invex</title>
  <link rel="stylesheet" href="{{ asset('css/styleregistro.css') }}">
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;800&display=swap" rel="stylesheet">
</head>

<body>

 <!-- Video de fondo -->
  <video autoplay muted loop playsinline class="video-fondo">
    <source src="{{ asset('videos/imageninicios.mp4') }}" type="video/mp4">
  </video>

  <div class="overlay"></div>

  <!-- CONTENEDOR DEL FORMULARIO -->
  <div class="registro-container">
    <h2><svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-person-plus" viewBox="0 0 16 16">
  <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
  <path d="M8 4a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0M9.5 4a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0"/>
</svg> Registrarse</h2>

    {{-- Mostrar mensaje de error --}}
    @if(session('error'))
      <div style="background-color: rgba(248, 215, 218, 0.9); color: #721c24; padding: 12px; border-radius: 8px; margin-bottom: 15px; border: 1px solid #f5c6cb; text-align: center;">
        {{ session('error') }}
      </div>
    @endif

    {{-- Mostrar mensaje de éxito --}}
    @if(session('success'))
      <div style="background-color: rgba(212, 237, 218, 0.9); color: #155724; padding: 12px; border-radius: 8px; margin-bottom: 15px; border: 1px solid #c3e6cb; text-align: center;">
        {{ session('success') }}
      </div>
    @endif

    <form action="{{ route('usuarios.store') }}" method="POST">
      @csrf

      <label for="nombre">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-add" viewBox="0 0 16 13">
          <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0m-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4"/>
          <path d="M8.256 14a4.5 4.5 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10q.39 0 .74.025c.226-.341.496-.65.804-.918Q8.844 9.002 8 9c-5 0-6 3-6 4s1 1 1 1z"/>
        </svg> Nombre completo
      </label>
      <input type="text" id="nombre" name="nombre" placeholder="Ej: Nicolás Palacios" value="{{ old('nombre') }}" required />

      <label for="correo">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 12">
          <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z"/>
        </svg> Correo electrónico
      </label>
      <input type="email" id="correo" name="correo" placeholder="ejemplo@correo.com" value="{{ old('correo') }}" required />

      <label for="telefono">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone" viewBox="0 0 16 14">
          <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.6 17.6 0 0 0 4.168 6.608 17.6 17.6 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.68.68 0 0 0-.58-.122l-2.19.547a1.75 1.75 0 0 1-1.657-.459L5.482 8.062a1.75 1.75 0 0 1-.46-1.657l.548-2.19a.68.68 0 0 0-.122-.58z"/>
        </svg> Número de teléfono
      </label>
      <input type="tel" id="telefono" name="telefono" placeholder="3001234567" value="{{ old('telefono') }}" required />

      <label for="fecha_Nacimiento">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cake2" viewBox="0 0 18 13">
          <path d="M10.5 2c-.276 0-.5.448-.5 1s.224 1 .5 1 .5-.448.5-1-.224-1-.5-1m-3 0c-.276 0-.5.448-.5 1s.224 1 .5 1 .5-.448.5-1-.224-1-.5-1m-3 0c-.276 0-.5.448-.5 1s.224 1 .5 1 .5-.448.5-1-.224-1-.5-1m10.5 6.5c.828 0 1.5.672 1.5 1.5v.5c0 .276-.224.5-.5.5h-12c-.276 0-.5-.224-.5-.5v-.5c0-.828.672-1.5 1.5-1.5z"/>
          <path d="M14.5 11.5c.828 0 1.5.672 1.5 1.5v.5c0 .276-.224.5-.5.5h-12c-.276 0-.5-.224-.5-.5v-.5c0-.828.672-1.5 1.5-1.5z"/>
          <path d="M16 15.5c0 .276-.224.5-.5.5h-15c-.276 0-.5-.224-.5-.5v-.5c0-.828.672-1.5 1.5-1.5h13c.828 0 1.5.672 1.5 1.5z"/>
          <path d="M8 1.5c-.276 0-.5.448-.5 1s.224 1 .5 1 .5-.448.5-1-.224-1-.5-1m0 6.5c-.276 0-.5.448-.5 1s.224 1 .5 1 .5-.448.5-1-.224-1-.5-1m0 6.5c-.276 0-.5.448-.5 1s.224 1 .5 1 .5-.448.5-1-.224-1-.5-1"/>
        </svg> Fecha de Nacimiento
      </label>
      <input type="date" id="fecha_Nacimiento" name="fecha_Nacimiento" value="{{ old('fecha_Nacimiento') }}" required />

      <label for="contrasena">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lock" viewBox="0 0 17 14">
          <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2m3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2M5 8h6a1 1 0 0 1 1 0v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-5a1 1 0 0 1 1-1"/>
        </svg> Contraseña
      </label>
      <input type="password" id="contrasena" name="contrasena" placeholder="••••••••••" required />

      <!-- Campos ocultos para rol y estado predeterminados -->
      <input type="hidden" name="rol" value="Empleado" />
      <input type="hidden" name="estado" value="0" />
      <input type="hidden" name="from_registration" value="1">

      <button type="submit"> Registrarse</button>
    </form>

    <div class="enlaces">
      <a href="{{ url('inicio-bloqueado') }}" class="volver">
        Volver al inicio
      </a>

      
  

</body>

</html>