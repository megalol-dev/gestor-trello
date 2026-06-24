<x-app-layout>

    <div class="profile-page">

        <div class="profile-header-card">

            <div>
                <h1 class="profile-title">
                    Mi perfil
                </h1>

                <p class="profile-user-name">
                    Usuario: {{ Auth::user()->name }}
                </p>
            </div>

            <a
                href="{{ route('dashboard') }}"
                class="btn btn-primary">
                Volver al panel
            </a>

        </div>

        <div class="profile-grid">

            <div class="profile-card">
                @include('profile.partials.update-profile-information-form')
            </div>

            <div class="profile-card">
                @include('profile.partials.update-password-form')
            </div>

        </div>

    </div>

</x-app-layout>