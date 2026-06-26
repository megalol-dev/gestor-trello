<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar contraseña - GestorTrello</title>

    @vite(['resources/css/app.css'])
</head>

<body>

    <div class="auth-container">

        <div class="auth-card">

            <h1 class="auth-title">
                Recuperar contraseña
            </h1>

            <p class="auth-subtitle">
                Introduce tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña.
            </p>

            @if (session('status'))

            <div class="success-message">
                ✅ Se ha enviado un enlace de recuperación a tu correo electrónico.
            </div>

            @endif

            <form method="POST" action="{{ route('password.email') }}" novalidate>

                @csrf

                <div class="form-group">

                    <label for="email">
                        Correo electrónico
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus>

                    @error('email')

                    <div class="login-error">

                        @if($message === __('passwords.user'))
                        No existe ninguna cuenta registrada con ese correo electrónico.

                        @elseif(str_contains($message, 'valid email'))
                        Introduce un correo electrónico válido.

                        @else
                        {{ $message }}
                        @endif

                    </div>

                    @enderror

                </div>

                <button type="submit" class="btn-primary">
                    Enviar enlace de recuperación
                </button>

                <div class="login-footer">

                    <a href="{{ route('login') }}">
                        Volver al inicio de sesión
                    </a>

                </div>

            </form>

        </div>

    </div>

</body>

</html>