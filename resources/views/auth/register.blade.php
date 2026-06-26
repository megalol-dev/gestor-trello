<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear cuenta - GestorTrello</title>

    @vite([
    'resources/css/app.css',
    'resources/js/app.js'
    ])
</head>

<body>

    <div class="auth-container">

        <div class="auth-card">

            <h1 class="auth-title">
                GestorTrello
            </h1>

            <p class="auth-subtitle">
                Crea una cuenta para comenzar
            </p>

            <form action="{{ route('register') }}" method="POST">

                @csrf

                <div class="form-group">

                    <label for="name">
                        Nombre de usuario
                    </label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Ej: Pepe"
                        required
                        autofocus>

                    <p id="name-message" class="validation-message"></p>

                </div>

                <div class="form-group">

                    <label for="email">
                        Correo electrónico
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Ej: pepe@gmail.com"
                        required>

                    <p id="email-message" class="validation-message"></p>

                </div>

                <div class="form-group">

                    <label for="password">
                        Contraseña
                    </label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Mínimo 8 caracteres"
                        required>

                    <p id="password-message" class="validation-message"></p>

                </div>

                <div class="form-group">

                    <label for="password_confirmation">
                        Confirmar contraseña
                    </label>

                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        placeholder="Repite la contraseña"
                        required>

                    <p id="confirm-message" class="validation-message"></p>

                </div>

                <button
                    type="submit"
                    class="btn-primary"
                    id="register-btn"
                    disabled>
                    Crear cuenta
                </button>

                <div class="login-footer">

                    <a href="{{ route('login') }}">
                        ¿Ya tienes cuenta? Inicia sesión
                    </a>

                </div>

            </form>

        </div>

    </div>



</body>

</html>