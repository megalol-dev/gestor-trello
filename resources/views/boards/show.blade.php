<x-app-layout>

    <main class="board-page">

        <!-- Aviso para móviles en orientación vertical -->
        <div class="rotate-device-message">
            <h2>📱↻</h2>
            <p>
                Gira tu dispositivo para utilizar el tablero.
            </p>
        </div>

        <div class="board-page-content">

            <h1 class="dashboard-title">Edición de tablero</h1>

            <div class="dashboard-user-bar">

                <div class="dashboard-user-info">
                    <span>Usuario: {{ Auth::user()->name }}</span>
                </div>

                <div class="dashboard-user-actions">

                    <a href="{{ route('dashboard') }}" class="btn btn-primary">
                        Volver
                    </a>
                </div>

            </div>




            <div class="boards-top-card">

                <div class="board-header-info">

                    <h2 class="boards-title">
                        Título del tablero: {{ $board->nombre }}
                    </h2>

                    <p class="boards-subtitle">
                        Información: {{ $board->descripcion }}
                    </p>

                    <div class="boards-actions">

                        <button
                            type="button"
                            class="btn btn-primary"
                            onclick="openBoardModal()">
                            Editar tablero
                        </button>



                        <form
                            id="delete-board-form"
                            method="POST"
                            action="{{ route('boards.destroy', $board) }}">

                            @csrf
                            @method('DELETE')

                            <button
                                type="button"
                                class="btn btn-danger"
                                onclick="openDeleteModal(
                    'delete-board-form',
                    '¿Seguro que quieres eliminar este tablero?<br><br><strong>También se eliminarán todas sus tareas.</strong>'
                )">
                                Eliminar tablero
                            </button>

                        </form>

                    </div>

                </div>

            </div>

            <!-- MODAL EDITAR TABLERO -->

            <div id="boardModal" class="board-modal">

                <div class="board-modal-content">

                    <h2>Editar tablero</h2>

                    <form
                        action="{{ route('boards.update', $board) }}"
                        method="POST">

                        @csrf
                        @method('PUT')

                        <div class="form-group">

                            <label>Nombre</label>

                            <input
                                type="text"
                                name="nombre"
                                value="{{ $board->nombre }}"
                                required>

                        </div>

                        <div class="form-group">

                            <label>Descripción</label>

                            <textarea
                                name="descripcion"
                                rows="4">{{ $board->descripcion }}</textarea>

                        </div>

                        <div class="board-modal-actions">

                            <button
                                type="button"
                                class="btn btn-danger"
                                onclick="closeBoardModal()">
                                Cancelar
                            </button>

                            <button
                                type="submit"
                                class="btn btn-primary">
                                Guardar cambios
                            </button>

                        </div>

                    </form>

                </div>

            </div>

            <!-- MODAL EDITAR TAREA -->

            <div id="taskModal" class="board-modal">

                <div class="board-modal-content">

                    <h2>Editar tarea</h2>

                    <form
                        id="taskEditForm"
                        method="POST">

                        @csrf
                        @method('PUT')

                        <input
                            type="hidden"
                            id="scroll_position"
                            name="scroll_position">

                        <div class="form-group">

                            <label>Título</label>

                            <input
                                type="text"
                                id="editTitulo"
                                name="titulo"
                                required>

                        </div>

                        <div class="form-group">

                            <label>Descripción</label>

                            <textarea
                                id="editDescripcion"
                                name="descripcion"
                                rows="4"></textarea>

                        </div>

                        <div class="board-modal-actions">

                            <button
                                type="button"
                                class="btn btn-danger"
                                onclick="closeTaskModal()">
                                Cancelar
                            </button>

                            <button
                                type="submit"
                                class="btn btn-primary">
                                Guardar cambios
                            </button>

                        </div>

                    </form>

                </div>

            </div>

            <!-- MODAL CONFIRMAR ELIMINACIÓN -->

            <div id="deleteModal" class="board-modal">

                <div class="board-modal-content">

                    <h2 id="deleteTitle">
                        Confirmar eliminación
                    </h2>

                    <p id="deleteMessage">
                    </p>

                    <div class="board-modal-actions">

                        <button
                            type="button"
                            class="btn btn-primary"
                            onclick="closeDeleteModal()">

                            Cancelar

                        </button>

                        <button
                            type="button"
                            class="btn btn-danger"
                            onclick="submitDeleteForm()">

                            Eliminar

                        </button>

                    </div>

                </div>

            </div>

            <!-- NUEVA TAREA -->

            <section class="profile-card task-form-card">

                <h2>Nueva tarea</h2>

                <form id="createTaskForm"
                    action="{{ route('tasks.store') }}"
                    method="POST">

                    @csrf

                    <input
                        type="hidden"
                        name="board_id"
                        value="{{ $board->id }}">

                    <input
                        type="hidden"
                        id="scroll_position_task"
                        name="scroll_position">

                    <input
                        type="text"
                        id="titulo"
                        name="titulo"
                        placeholder="Título de la tarea">

                    <div
                        id="task-error"
                        class="login-error"
                        style="display:none;">
                        El título de la tarea es obligatorio.
                    </div>

                    <textarea
                        id="descripcion"
                        name="descripcion"
                        placeholder="Descripción"></textarea>

                    <button
                        type="submit"
                        class="btn btn-primary">
                        Crear tarea
                    </button>

                </form>

            </section>

            <!-- COLUMNAS KANBAN -->

            <section
                id="kanban-board"
                class="tasks-columns">

                <!-- PENDIENTES -->

                <div
                    class="task-column"
                    data-estado="pendiente">

                    <h2 class="column-title">
                        ⏳ Pendientes
                    </h2>

                    @forelse($tasksPendientes as $task)

                    <article
                        class="task-card"
                        draggable="true"
                        data-task-id="{{ $task->id }}">

                        <h3 class="task-title">
                            {{ $task->titulo }}
                        </h3>

                        <p class="task-description">
                            {{ $task->descripcion }}
                        </p>

                        <div class="task-actions">

                            <button
                                type="button"
                                class="btn"
                                onclick='openTaskModal(
                                {{ $task->id }},
                                @json($task->titulo),
                                @json($task->descripcion)
                            )'>
                                Editar
                            </button>

                            <form
                                id="delete-task-{{ $task->id }}"
                                action="{{ route('tasks.destroy', $task) }}"
                                method="POST">

                                @csrf
                                @method('DELETE')

                                <button
                                    type="button"
                                    class="btn btn-danger"
                                    onclick="openDeleteModal(
                                    'delete-task-{{ $task->id }}',
                                    '¿Seguro que quieres eliminar esta tarea?'
                                )">
                                    Eliminar

                                </button>

                            </form>

                            <form
                                action="{{ route('tasks.progreso', $task) }}"
                                method="POST">
                                @csrf
                                @method('PATCH')


                            </form>

                        </div>

                    </article>

                    @empty

                    <p class="empty-column">
                        No hay tareas pendientes.
                    </p>

                    @endforelse

                </div>

                <!-- EN PROGRESO -->

                <div
                    class="task-column"
                    data-estado="progreso">

                    <h2 class="column-title">
                        🔄 Desarrollo
                    </h2>

                    @forelse($tasksProgreso as $task)

                    <article
                        class="task-card"
                        draggable="true"
                        data-task-id="{{ $task->id }}">

                        <h3 class="task-title">
                            {{ $task->titulo }}
                        </h3>

                        <p class="task-description">
                            {{ $task->descripcion }}
                        </p>

                        <div class="task-actions">

                            <button
                                type="button"
                                class="btn"
                                onclick='openTaskModal(
                                {{ $task->id }},
                                @json($task->titulo),
                                @json($task->descripcion)
                            )'>
                                Editar
                            </button>

                            <form
                                id="delete-task-{{ $task->id }}"
                                action="{{ route('tasks.destroy', $task) }}"
                                method="POST">

                                @csrf
                                @method('DELETE')

                                <button
                                    type="button"
                                    class="btn btn-danger"
                                    onclick="openDeleteModal(
                                    'delete-task-{{ $task->id }}',
                                    '¿Seguro que quieres eliminar esta tarea?'
                                )">
                                    Eliminar

                                </button>

                            </form>

                            <form
                                action="{{ route('tasks.hecho', $task) }}"
                                method="POST">
                                @csrf
                                @method('PATCH')

                            </form>

                        </div>

                    </article>

                    @empty

                    <p class="empty-column">
                        No hay tareas en progreso.
                    </p>

                    @endforelse

                </div>

                <!-- HECHAS -->

                <div
                    class="task-column"
                    data-estado="hecho">

                    <h2 class="column-title">
                        ✅ Completas
                    </h2>

                    @forelse($tasksHechas as $task)

                    <article
                        class="task-card"
                        draggable="true"
                        data-task-id="{{ $task->id }}">

                        <h3 class="task-title">
                            {{ $task->titulo }}
                        </h3>

                        <p class="task-description">
                            {{ $task->descripcion }}
                        </p>

                        <div class="task-actions">

                            <button
                                type="button"
                                class="btn"
                                onclick='openTaskModal(
                                {{ $task->id }},
                                @json($task->titulo),
                                @json($task->descripcion)
                            )'>
                                Editar
                            </button>

                            <form
                                id="delete-task-{{ $task->id }}"
                                action="{{ route('tasks.destroy', $task) }}"
                                method="POST">

                                @csrf
                                @method('DELETE')

                                <button
                                    type="button"
                                    class="btn btn-danger"
                                    onclick="openDeleteModal(
                                    'delete-task-{{ $task->id }}',
                                    '¿Seguro que quieres eliminar esta tarea?'
                                )">
                                    Eliminar

                                </button>

                            </form>

                        </div>

                    </article>

                    @empty

                    <p class="empty-column">
                        No hay tareas completadas.
                    </p>

                    @endforelse

                </div>

            </section>

        </div>

    </main>

    <input
        type="hidden"
        id="savedScrollPosition"
        value="{{ session('scroll_position') }}">

    <script>
        function openBoardModal() {
            document.getElementById('boardModal').style.display = 'flex';
            document.body.classList.add('modal-open');
        }

        function closeBoardModal() {
            document.getElementById('boardModal').style.display = 'none';
            document.body.classList.remove('modal-open');
        }


        function openTaskModal(id, titulo, descripcion) {
            document.getElementById('editTitulo').value = titulo;
            document.getElementById('editDescripcion').value = descripcion;
            document.getElementById('taskEditForm').action = '/tasks/' + id;
            document.getElementById('taskModal').style.display = 'flex';
            document.body.classList.add('modal-open');
        }

        function closeTaskModal() {
            document.getElementById('taskModal').style.display = 'none';
            document.body.classList.remove('modal-open');
        }

        document
            .getElementById('taskEditForm')
            .addEventListener('submit', function() {

                document.getElementById('scroll_position').value =
                    window.scrollY;

            });

        document
            .getElementById('createTaskForm')
            .addEventListener('submit', function(event) {

                const titulo =
                    document.getElementById('titulo');

                const error =
                    document.getElementById('task-error');

                if (titulo.value.trim() === '') {
                    event.preventDefault();
                    error.style.display = 'block';
                    titulo.focus();
                    return;
                }

                error.style.display = 'none';

                document.getElementById(
                    'scroll_position_task'
                ).value = window.scrollY;

            });

        document
            .getElementById('titulo')
            .addEventListener('input', function() {

                document.getElementById(
                    'task-error'
                ).style.display = 'none';

            });

        const savedScrollPosition =
            document.getElementById('savedScrollPosition');

        if (savedScrollPosition && savedScrollPosition.value) {
            window.addEventListener('load', function() {
                setTimeout(() => {
                    window.scrollTo(
                        0,
                        Number(savedScrollPosition.value)
                    );
                }, 50);
            });
        }
    </script>

    <script>
        let deleteForm = null;

        function openDeleteModal(formId, mensaje) {
            deleteForm = document.getElementById(formId);
            document.getElementById("deleteMessage").innerHTML = mensaje;
            document.getElementById("deleteModal").style.display = "flex";
            document.body.classList.add('modal-open');
        }

        function closeDeleteModal() {
            document.getElementById("deleteModal").style.display = "none";
            document.body.classList.remove('modal-open');
            deleteForm = null;
        }


        function submitDeleteForm() {

            if (deleteForm) {
                deleteForm.submit();
            }

        }
    </script>

</x-app-layout>