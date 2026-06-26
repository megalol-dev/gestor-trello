<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer contraseña - GestorTrello</title>

    @vite(['resources/css/app.css'])
</head>

<body>

    <div class="auth-container">

        <div class="auth-card">

            <h1 class="auth-title">
                Restablecer contraseña
            </h1>

            <p class="auth-subtitle">
                Introduce tu nueva contraseña para recuperar el acceso a tu cuenta.
            </p>

            <form method="POST" action="{{ route('password.store') }}" novalidate>

                @csrf

                <input
                    type="hidden"
                    name="token"
                    value="{{ $request->route('token') }}">

                <div class="form-group">

                    <label for="email">
                        Correo electrónico
                    </label>

                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email', $request->email) }}"
                        required
                        autofocus
                        autocomplete="username">

                    @error('email')
                    <div class="login-error">
                        Introduce un correo electrónico válido.
                    </div>
                    @enderror

                </div>

                <div class="form-group">

                    <label for="password">
                        Nueva contraseña
                    </label>

                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        autocomplete="new-password">

                    @error('password')

                    <div class="login-error">

                        @if(str_contains($message, 'at least'))
                        La contraseña debe tener al menos 8 caracteres.

                        @elseif(str_contains($message, 'confirmation'))
                        Las contraseñas no coinciden.

                        @else
                        {{ $message }}
                        @endif

                    </div>

                    @enderror

                </div>

                <div class="form-group">

                    <label for="password_confirmation">
                        Confirmar contraseña
                    </label>

                    <input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        required
                        autocomplete="new-password">

                    @error('password_confirmation')
                    <div class="login-error">
                        Las contraseñas no coinciden.
                    </div>
                    @enderror

                </div>

                <button
                    type="submit"
                    class="btn-primary">
                    Restablecer contraseña
                </button>

            </form>

        </div>

    </div>

</body>

</html>