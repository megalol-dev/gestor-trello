<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            Cambiar contraseña
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Actualiza tu contraseña para mantener tu cuenta segura.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        @php
        $passwordErrors = $errors->updatePassword->get('password');
        @endphp

        <div>

            <x-input-label
                for="update_password_current_password"
                :value="__('Contraseña actual')" />

            <x-text-input
                id="update_password_current_password"
                name="current_password"
                type="password"
                class="mt-1 block w-full"
                autocomplete="current-password" />

            @if($errors->updatePassword->has('current_password'))
            <div class="login-error mt-3">
                La contraseña actual es incorrecta.
            </div>
            @endif

        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('Nueva contraseña')" />
            <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            @if($errors->updatePassword->has('password'))

            @php
            $passwordErrors = $errors->updatePassword->get('password');
            @endphp

            @if(collect($passwordErrors)->contains(fn($e) => str_contains($e, 'at least')))
            <div class="login-error mt-3">
                La contraseña debe tener al menos 8 caracteres.
            </div>
            @endif

            @endif
        </div>

        <div>

            <x-input-label
                for="update_password_password_confirmation"
                :value="__('Confirmar nueva contraseña')" />

            <x-text-input
                id="update_password_password_confirmation"
                name="password_confirmation"
                type="password"
                class="mt-1 block w-full"
                autocomplete="new-password" />
            @if($errors->updatePassword->has('password'))

            @php
            $passwordErrors = $errors->updatePassword->get('password');
            @endphp

            @if(collect($passwordErrors)->contains(fn($e) => str_contains($e, 'confirmation')))
            <div class="login-error mt-3">
                Las contraseñas no coinciden.
            </div>
            @endif

            @endif

        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Guardar contraseña') }}</x-primary-button>
            @if (session('status') === 'password-updated')

            <div class="success-message">
                ✅ Contraseña actualizada correctamente.
            </div>

            @endif
        </div>
    </form>
</section>