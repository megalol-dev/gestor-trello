<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión - GestorTrello</title>

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
                Inicia sesión para continuar
            </p>

            @if(session('status'))
            <div class="login-success">
                {{ session('status') }}
            </div>
            @endif

            @if($errors->has('email'))
            <div class="login-error">
                Correo o contraseña incorrectos.
            </div>
            @endif

            <form action="{{ route('login') }}" method="POST">

                @csrf

                <div class="form-group">

                    <label for="email">
                        Correo electrónico
                    </label>

                    <input
                        type="text"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Ej: pepe@gmail.com"
                        required>
                </div>

                <div class="form-group">

                    <label for="password">
                        Contraseña
                    </label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Introduce tu contraseña"
                        required>
                </div>

                <div class="login-actions">

                    <button
                        type="submit"
                        class="btn btn-primary"
                        id="login-btn">
                        Iniciar sesión
                    </button>

                    <div id="login-status"></div>

                    <div class="remember-wrapper">

                        <input
                            type="checkbox"
                            id="remember_me"
                            name="remember">

                        <label for="remember_me">
                            Recordarme
                        </label>

                    </div>

                </div>

                <div class="login-footer">

                    <a href="{{ route('register') }}">
                        Crear cuenta
                    </a>

                    @if(Route::has('password.request'))
                    <a href="{{ route('password.request') }}">
                        ¿Olvidaste tu contraseña?
                    </a>
                    @endif

                </div>

            </form>

        </div>

    </div>

</body>

</html>