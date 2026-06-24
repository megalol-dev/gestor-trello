<x-app-layout>

    <main class="boards-page">

        <div class="boards-top-card">

            <div>
                <h1 class="boards-title">
                    Crear tablero
                </h1>

                <p class="boards-subtitle">
                    Crea un nuevo proyecto para organizar tus tareas.
                </p>
            </div>

            <div class="boards-actions">

                <a href="{{ route('boards.index') }}" class="btn btn-primary">
                    Volver
                </a>

                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf

                    <button type="submit" class="btn btn-danger">
                        Cerrar sesión
                    </button>
                </form>

            </div>

        </div>

        <div class="profile-card">

            <form action="{{ route('boards.store') }}" method="POST" class="board-form">

                @csrf

                <div class="form-group">

                    <label for="nombre">
                        Nombre del tablero
                    </label>

                    <input
                        type="text"
                        id="nombre"
                        name="nombre"
                        value="{{ old('nombre') }}"
                        class="form-control">

                    @error('nombre')
                    <p class="form-error">
                        {{ $message }}
                    </p>
                    @enderror

                </div>

                <div class="form-group">

                    <label for="descripcion">
                        Descripción
                    </label>

                    <textarea
                        id="descripcion"
                        name="descripcion"
                        rows="5"
                        class="form-control">{{ old('descripcion') }}</textarea>

                    @error('descripcion')
                    <p class="form-error">
                        {{ $message }}
                    </p>
                    @enderror

                </div>

                <button type="submit" class="btn btn-primary">
                    Crear tablero
                </button>

            </form>

        </div>

    </main>

</x-app-layout>