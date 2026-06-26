<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="dashboard-container">

                        <h2 class="dashboard-title">
                            Bienvenido a GestorTrello
                        </h2>

                        <div class="dashboard-user-bar">

                            <div class="dashboard-user-info">
                                <span>Usuario: {{ Auth::user()->name }}</span>
                            </div>

                            <div class="dashboard-user-actions">

                                <a
                                    href="{{ route('profile.edit') }}"
                                    class="btn btn-primary">
                                    Perfil
                                </a>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <button
                                        type="submit"
                                        class="btn btn-danger">
                                        Cerrar sesión
                                    </button>
                                </form>

                            </div>

                        </div>

                        <div class="dashboard-actions">

                            <button
                                type="button"
                                class="btn btn-primary"
                                onclick="openCreateBoardModal()">
                                Crear tablero
                            </button>

                        </div>

                        <h2 class="dashboard-section-title">
                            Resumen general de tu actividad
                        </h2>


                            <div class="dashboard-summary">

                                <div class="stats-grid">

                                    <div class="stat-card">
                                        <h3>📋 Tableros</h3>
                                        <p>{{ $boardsCount }}</p>
                                    </div>

                                    <div class="stat-card">
                                        <h3>📝 Tareas</h3>
                                        <p>{{ $totalTasks }}</p>
                                    </div>

                                    <div class="stat-card">
                                        <h3>⏳ Pendientes</h3>
                                        <p>{{ $pendientes }}</p>
                                    </div>

                                    <div class="stat-card">
                                        <h3>🔄 En progreso</h3>
                                        <p>{{ $progreso }}</p>
                                    </div>

                                    <div class="stat-card">
                                        <h3>✅ Hechas</h3>
                                        <p>{{ $hechas }}</p>
                                    </div>

                                    <div class="stat-card">
                                        <h3>📈 Completado</h3>
                                        <p>{{ $porcentaje }}%</p>
                                    </div>

                                </div>

                            </div>

                            <div class="dashboard-actions">

                                <div class="dashboard-boards">

                                    <h2 class="dashboard-section-title">
                                        Tus tableros
                                    </h2>

                                    @if($boards->isEmpty())

                                    <p class="empty-message">
                                        Todavía no tienes tableros creados.
                                    </p>

                                    @else

                                    <div class="dashboard-boards-grid">

                                        @foreach($boards as $board)

                                        @php
                                        $pendientesBoard = $board->tareasPendientes()->count();
                                        $progresoBoard = $board->tareasProgreso()->count();
                                        $hechasBoard = $board->tareasHechas()->count();

                                        $totalBoard =
                                        $pendientesBoard +
                                        $progresoBoard +
                                        $hechasBoard;

                                        $porcentajeBoard = $totalBoard > 0
                                        ? round(($hechasBoard / $totalBoard) * 100)
                                        : 0;
                                        @endphp

                                        <div class="dashboard-board-card">

                                            <div class="dashboard-board-title">

                                                <a
                                                    href="{{ route('boards.show', $board) }}"
                                                    class="board-open-button">
                                                    📋 {{ $board->nombre }}
                                                </a>

                                            </div>

                                            <p class="dashboard-board-description">
                                                Información: {{ $board->descripcion }}
                                            </p>

                                            <div class="dashboard-board-stats">

                                                <span>⏳ {{ $pendientesBoard }}</span>

                                                <span>🔄 {{ $progresoBoard }}</span>

                                                <span>✅ {{ $hechasBoard }}</span>

                                            </div>

                                            <div class="dashboard-board-progress">
                                                📈 {{ $porcentajeBoard }}% completado
                                            </div>

                                        </div>

                                        @endforeach

                                        @endif

                                    </div>



                                </div>


                            </div>
                    </div>
                </div>
            </div>

            <div id="createBoardModal" class="board-modal">

                <div class="board-modal-content">

                    <h2>Crear tablero</h2>

                    <form method="POST" action="{{ route('boards.store') }}">

                        @csrf

                        <div class="form-group">

                            <label for="nombre">Nombre del tablero</label>

                            <input
                                type="text"
                                id="nombre"
                                name="nombre"
                                required
                                placeholder="Ej: Proyecto DAW">

                        </div>

                        <div class="form-group">

                            <label for="descripcion">Descripción</label>

                            <textarea
                                id="descripcion"
                                name="descripcion"
                                rows="4"
                                placeholder="Describe brevemente el tablero"></textarea>

                        </div>

                        <div class="board-modal-actions">

                            <button
                                type="button"
                                class="btn btn-danger"
                                onclick="closeCreateBoardModal()">
                                Cancelar
                            </button>

                            <button
                                type="submit"
                                class="btn btn-primary">
                                Crear tablero
                            </button>

                        </div>

                    </form>

                </div>

            </div>

            <script>
                function openCreateBoardModal() {
                    document.getElementById('createBoardModal').style.display = 'flex';
                }

                function closeCreateBoardModal() {
                    document.getElementById('createBoardModal').style.display = 'none';
                }

                window.addEventListener('click', function(event) {
                    const modal = document.getElementById('createBoardModal');

                    if (event.target === modal) {
                        closeCreateBoardModal();
                    }
                });
            </script>
</x-app-layout>