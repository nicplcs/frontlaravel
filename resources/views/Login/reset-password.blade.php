<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Restablecer Contraseña - INVEX</title>
    <link rel="stylesheet" href="{{ asset('css/styleresetcontra.css') }}">
</head>
<body>
    
    <div class="header-nav">
        <a href="{{ url('/login') }}" class="back-button">
            ← Volver
        </a>
    </div>

    <div class="container">
        
        <div id="loadingDiv" class="loading">
            <div class="spinner"></div>
            <p>Verificando enlace de recuperación...</p>
        </div>
        
        <div id="formContainer" class="hidden">
            <div class="logo">
                <svg class="logo-icon" xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M5.338 1.59a61 61 0 0 0-2.837.856.48.48 0 0 0-.328.39c-.554 4.157.726 7.19 2.253 9.188a10.7 10.7 0 0 0 2.287 2.233c.346.244.652.42.893.533q.18.085.293.118a1 1 0 0 0 .101.025 1 1 0 0 0 .1-.025q.114-.034.294-.118c.24-.113.547-.29.893-.533a10.7 10.7 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.552 1.29 8.531 1.067 8 1.067c-.53 0-1.552.223-2.662.524zM5.072.56C6.157.265 7.31 0 8 0s1.843.265 2.928.56c1.11.3 2.229.655 2.887.87a1.54 1.54 0 0 1 1.044 1.262c.596 4.477-.787 7.795-2.465 9.99a11.8 11.8 0 0 1-2.517 2.453 7 7 0 0 1-1.048.625c-.28.132-.581.24-.829.24s-.548-.108-.829-.24a7 7 0 0 1-1.048-.625 11.8 11.8 0 0 1-2.517-2.453C1.928 10.487.545 7.169 1.141 2.692A1.54 1.54 0 0 1 2.185 1.43 63 63 0 0 1 5.072.56"/>
                    <path d="M9.5 6.5a1.5 1.5 0 0 1-1 1.415l.385 1.99a.5.5 0 0 1-.491.595h-.788a.5.5 0 0 1-.49-.595l.384-1.99a1.5 1.5 0 1 1 2-1.415"/>
                </svg>
                <h1>INVEX</h1>
            </div>
            
            <h2>Restablecer Contraseña</h2>
            <p class="subtitle">Ingresa tu nueva contraseña</p>
            
            <div id="message" class="message"></div>
            
            <form id="resetPasswordForm">
                <div class="form-group">
                    <label for="newPassword">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2m3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2"/>
                        </svg>
                        Nueva Contraseña
                    </label>
                    <input 
                        type="password" 
                        id="newPassword" 
                        name="newPassword" 
                        required
                        minlength="6"
                        placeholder="••••••••"
                        autocomplete="new-password"
                    >
                    <div class="password-requirements">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                            <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                        </svg>
                        La contraseña debe tener al menos 6 caracteres
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="confirmPassword">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2m3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2"/>
                        </svg>
                        Confirmar Contraseña
                    </label>
                    <input 
                        type="password" 
                        id="confirmPassword" 
                        name="confirmPassword" 
                        required
                        minlength="6"
                        placeholder="••••••••"
                        autocomplete="new-password"
                    >
                </div>
                
                <button type="submit" class="btn" id="submitBtn">
                    Restablecer Contraseña
                </button>
            </form>
        </div>
        
        <div id="errorContainer" class="hidden">
            <div class="error-content">
                <div class="logo">
                    <svg class="logo-icon" xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M3.5 11.5a3.5 3.5 0 1 1 3.163-5H14L15.5 8 14 9.5l-1-1-1 1-1-1-1 1zm-.653.757A4.5 4.5 0 0 0 7.5 15h.5v-2.5h-1v-1h1v-1h-1v-1h1v-1h-1z"/>
                        <circle cx="4.5" cy="4.5" r=".5" fill="currentColor"/>
                    </svg>
                    <h1>INVEX</h1>
                </div>
                
                <svg class="error-icon" xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5m.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                </svg>
                
                <h2>Enlace Inválido</h2>
                <div class="message error" style="display: block;">
                    El enlace de recuperación es inválido o ha expirado. Por favor, solicita uno nuevo.
                </div>
                <a href="{{ url('/forgot-password') }}" class="btn">
                    Solicitar Nuevo Enlace
                </a>
            </div>
        </div>
    </div>

    <script>
        const API_URL = 'http://localhost:8080/api/password-reset';
        
        const urlParams = new URLSearchParams(window.location.search);
        const token = urlParams.get('token');
        
        const loadingDiv = document.getElementById('loadingDiv');
        const formContainer = document.getElementById('formContainer');
        const errorContainer = document.getElementById('errorContainer');
        const form = document.getElementById('resetPasswordForm');
        const messageDiv = document.getElementById('message');
        const submitBtn = document.getElementById('submitBtn');
        const newPasswordInput = document.getElementById('newPassword');
        const confirmPasswordInput = document.getElementById('confirmPassword');

        async function validateToken() {
            if (!token) {
                console.log('No hay token en la URL');
                showError();
                return;
            }
            
            console.log('Validando token:', token);
            
            try {
                const response = await fetch(`${API_URL}/validate/${token}`);
                const data = await response.json();
                
                console.log('Respuesta de validación:', data);
                
                if (data.success) {
                    loadingDiv.classList.add('hidden');
                    formContainer.classList.remove('hidden');
                } else {
                    showError();
                }
            } catch (error) {
                console.error('Error al validar token:', error);
                showError();
            }
        }
        
        function showError() {
            loadingDiv.classList.add('hidden');
            errorContainer.classList.remove('hidden');
        }
        
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const newPassword = newPasswordInput.value;
            const confirmPassword = confirmPasswordInput.value;
            
            if (newPassword !== confirmPassword) {
                showMessage('Las contraseñas no coinciden', 'error');
                return;
            }
        
            if (newPassword.length < 6) {
                showMessage('La contraseña debe tener al menos 6 caracteres', 'error');
                return;
            }
            
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="loading-spinner"></span> Restableciendo...';
            messageDiv.style.display = 'none';
            
            try {
                const response = await fetch(`${API_URL}/reset`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        token: token,
                        newPassword: newPassword
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showMessage('✓ ' + data.message + ' Redirigiendo al login...', 'success');
                    form.reset();
                    
                    setTimeout(() => {
                        window.location.href = '{{ url("/login") }}';
                    }, 3000);
                } else {
                    showMessage(data.message, 'error');
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Restablecer Contraseña';
                }
                
            } catch (error) {
                console.error('Error:', error);
                showMessage('Error al conectar con el servidor. Intenta nuevamente.', 'error');
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Restablecer Contraseña';
            }
        });
        
        function showMessage(message, type) {
            messageDiv.textContent = message;
            messageDiv.className = `message ${type}`;
            messageDiv.style.display = 'block';
        }
        
        validateToken();
    </script>
</body>
</html>