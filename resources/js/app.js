import Sortable from "sortablejs";

document.addEventListener("DOMContentLoaded", () => {
    const taskList = document.getElementById("task-list");

    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");
    const reorderUrl = document
        .querySelector('meta[name="reorder-url"]')
        .getAttribute("content");

    if (taskList) {
        Sortable.create(taskList, {
            animation: 150,
            ghostClass: "sortable-ghost",
            chosenClass: "sortable-chosen",
            dragClass: "sortable-drag",
            onEnd: async () => {
                const order = Array.from(
                    taskList.querySelectorAll(".task-item")
                ).map((item) => item.dataset.id);
                try {
                    const response = await fetch(reorderUrl, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": csrfToken,
                        },
                        body: JSON.stringify({ order }),
                    });
                    if (response.ok) {
                        console.log("Order updated successfully!");
                        // Optionally update UI without reload.
                    } else {
                        console.error(
                            "Error updating order:",
                            response.statusText
                        );
                    }
                } catch (error) {
                    console.error("Fetch error:", error);
                }
            },
        });
    }
});
