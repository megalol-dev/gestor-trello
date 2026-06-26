<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            Información del perfil
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Modifica tu nombre y correo electrónico.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6"
        novalidate>
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Nombre')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />

            <x-text-input
                id="email"
                name="email"
                type="email"
                class="mt-1 block w-full"
                :value="old('email', $user->email)"
                required
                autocomplete="username" />

            @if($errors->has('email'))

            @php
            $error = $errors->first('email');
            @endphp

            <div class="login-error mt-3">

                @if(str_contains($error, 'valid'))
                Introduce un correo electrónico válido.

                @elseif(str_contains($error, 'taken'))
                Ese correo electrónico ya está registrado.

                @elseif(str_contains($error, 'required'))
                El correo electrónico es obligatorio.

                @else
                {{ $error }}
                @endif

            </div>

            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>Guardar cambios</x-primary-button>

            @if (session('status') === 'profile-updated')

            <div class="success-message">
                ✅ Perfil actualizado correctamente.
            </div>

            @endif
        </div>
    </form>
</section>