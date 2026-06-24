<x-app-layout>

    <main class="boards-page">

        <header class="boards-header">

            <div class="boards-top-card">

                <div>

                    <h1 class="boards-title">
                        Mis tableros
                    </h1>

                </div>

                <div class="boards-actions">

                    <a href="{{ route('boards.create') }}" class="btn btn-primary">
                        Crear tablero
                    </a>

                    <a href="{{ route('dashboard') }}" class="btn btn-primary">
                        Volver
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <button type="submit" class="btn btn-danger">
                            Cerrar sesión
                        </button>
                    </form>



                </div>

            </div>

        </header>

        <section class="boards-list">

            @if($boards->isEmpty())

            <p class="empty-message">
                Todavía no tienes tableros creados.
            </p>

            @else

            @foreach($boards as $board)

            <article class="board-card">

                <h2 class="board-name">

                    <a href="{{ route('boards.show', $board) }}">
                        {{ $board->nombre }}
                    </a>

                </h2>

                @if($board->descripcion)

                <p class="board-description">
                    {{ $board->descripcion }}
                </p>

                @endif

                <div class="board-stats">

                    <div class="board-stat">
                        ⏳ {{ $board->tareasPendientes()->count() }}
                    </div>

                    <div class="board-stat">
                        🔄 {{ $board->tareasProgreso()->count() }}
                    </div>

                    <div class="board-stat">
                        ✅ {{ $board->tareasHechas()->count() }}
                    </div>

                </div>

                @php
                $total = $board->tasks()->count();

                $hechas = $board->tareasHechas()->count();

                $porcentaje = $total > 0
                ? round(($hechas / $total) * 100)
                : 0;
                @endphp

                <div class="board-progress">
                    📈 {{ $porcentaje }}% completado
                </div>

            </article>

            @endforeach

            @endif

        </section>

    </main>

</x-app-layout>