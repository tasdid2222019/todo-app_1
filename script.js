// Add Task
document.getElementById("taskForm").addEventListener("submit", function(e) {
  e.preventDefault();
  const taskInput = document.getElementById("taskInput");
  const taskText = taskInput.value.trim();

  if (taskText === "") return;

  fetch("insert.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: "task=" + encodeURIComponent(taskText)
  })
  .then(res => res.text())
  .then(data => {
    showAlert("Task added!", "success");
    setTimeout(() => window.location.reload(), 500);
  });

  taskInput.value = "";
});

// Delete Task
document.querySelectorAll(".delete-btn").forEach(btn => {
  btn.addEventListener("click", function() {
    const li = this.closest("li");
    const id = li.getAttribute("data-id");

    fetch("delete.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: "id=" + id
    }).then(() => {
      showAlert("Task deleted!", "danger");
      li.remove();
    });
  });
});

// Toggle Completion
document.querySelectorAll(".toggle-btn, .task-text").forEach(el => {
  el.addEventListener("click", function() {
    const li = this.closest("li");
    const id = li.getAttribute("data-id");

    fetch("update.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: "id=" + id
    }).then(() => window.location.reload());
  });
});

// Bootstrap Alert
function showAlert(message, type) {
  const alertBox = `
    <div class="alert alert-${type} alert-dismissible fade show" role="alert">
      ${message}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>`;
  document.getElementById("alertPlaceholder").innerHTML = alertBox;
}
