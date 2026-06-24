let draggedTask = null;

document.querySelectorAll(".task-card").forEach((card) => {
    card.addEventListener("dragstart", () => {
        draggedTask = card;

        card.classList.add("dragging");
    });

    card.addEventListener("dragend", () => {
        card.classList.remove("dragging");
    });
});

document.querySelectorAll(".task-column").forEach((column) => {
    column.addEventListener("dragover", (e) => {
        e.preventDefault();

        column.classList.add("drop-zone-active");
    });

    column.addEventListener("dragleave", () => {
        column.classList.remove("drop-zone-active");
    });

    column.addEventListener("drop", async () => {
        column.classList.remove("drop-zone-active");

        const estado = column.dataset.estado;

        const taskId = draggedTask.dataset.taskId;

        try {
            await fetch(`/tasks/${taskId}/estado`, {
                method: "PATCH",

                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]',
                    ).content,
                },

                body: JSON.stringify({
                    estado: estado,
                }),
            });

            location.reload();
        } catch (error) {
            alert("Error al mover la tarea");
        }
    });
});
