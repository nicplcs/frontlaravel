<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Recuperar Contraseña - INVEX</title>
    <link rel="stylesheet" href="{{ asset('css/stylerecuperarcontra.css') }}">
</head>
<body>

    <div class="header-nav">
        <a href="{{ url('/login') }}" class="back-button">
            ← Volver
        </a>
    </div>

    <div class="container">
        <div class="logo">
            <svg class="logo-icon" xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2m3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2M5 8h6a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1"/>
            </svg>
            <h1>INVEX</h1>
        </div>
        
        <h2>¿Olvidaste tu contraseña?</h2>
        <p class="subtitle">Te enviaremos un enlace de recuperación a tu correo electrónico</p>
        
        <div id="message" class="message"></div>
        
        <form id="forgotPasswordForm">
            <div class="form-group">
                <label for="email">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z"/>
                    </svg>
                    Correo Electrónico
                </label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    required 
                    placeholder="ejemplo@correo.com"
                    autocomplete="email"
                >
            </div>
            
            <button type="submit" class="btn" id="submitBtn">
                Enviar Enlace de Recuperación
            </button>
        </form>
    </div>

    <script>
        const form = document.getElementById('forgotPasswordForm');
        const messageDiv = document.getElementById('message');
        const submitBtn = document.getElementById('submitBtn');
        const emailInput = document.getElementById('email');
        
        const API_URL = 'http://localhost:8080/api/password-reset';

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const email = emailInput.value.trim();
            
            if (!email) {
                showMessage('Por favor ingresa tu correo electrónico', 'error');
                return;
            }
            
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                showMessage('Por favor ingresa un correo electrónico válido', 'error');
                return;
            }
            
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="loading-spinner"></span> Enviando...';
            messageDiv.style.display = 'none';
            
            try {
                const response = await fetch(`${API_URL}/request`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ email: email })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showMessage(data.message, 'success');
                    form.reset();
                    emailInput.blur();
                } else {
                    showMessage(data.message, 'error');
                }
                
            } catch (error) {
                console.error('Error:', error);
                showMessage('Error al conectar con el servidor. Por favor intenta nuevamente.', 'error');
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Enviar Enlace de Recuperación';
            }
        });
        
        function showMessage(message, type) {
            messageDiv.textContent = message;
            messageDiv.className = `message ${type}`;
            messageDiv.style.display = 'block';
            
            if (type === 'success') {
                setTimeout(() => {
                    messageDiv.style.display = 'none';
                }, 10000);
            }
        }
    </script>
</body>
</html>