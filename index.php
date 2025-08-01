<?php
include 'db.php';

$sql = "SELECT * FROM tasks ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);

$tasks = [];
$totalTasks = 0;
$completedTasks = 0;

while ($row = mysqli_fetch_assoc($result)) {
    $tasks[] = $row;
    $totalTasks++;
    if ($row['completed']) {
        $completedTasks++;
    }
}

$progress = ($totalTasks > 0) ? round(($completedTasks / $totalTasks) * 100) : 0;
?>

<?php 
include 'db.php'; 
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html>
<head>
  <title>To-Do List</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="style.css" rel="stylesheet"> 
</head>
<body class="bg-light">
  <div class="container mt-5">
    <h2 class="text-center mb-4">To-Do List</h2>

    <?php
      // Ensure completed column is present and safe
      $countResult = $conn->query("SELECT COUNT(*) AS total FROM tasks");
      $completedResult = $conn->query("SELECT COUNT(*) AS completed FROM tasks WHERE completed = 1");

      $totalTasks = 0;
      $completedTasks = 0;

      if ($countResult && $row = $countResult->fetch_assoc()) {
        $totalTasks = (int)$row['total'];
      }

      if ($completedResult && $row = $completedResult->fetch_assoc()) {
        $completedTasks = (int)$row['completed'];
      }

      $percentage = ($totalTasks > 0) ? round(($completedTasks / $totalTasks) * 100) : 0;
    ?>

    <div class="mb-4">
      <div class="d-flex justify-content-between align-items-center mb-1">
        <strong>Completed: <?= $completedTasks ?> of <?= $totalTasks ?> tasks</strong>
        <span><?= $percentage ?>%</span>
      </div>
      <div class="progress">
        <div 
          class="progress-bar bg-success" 
          role="progressbar" 
          style="width: <?= $percentage ?>%;" 
          aria-valuenow="<?= $percentage ?>" 
          aria-valuemin="0" 
          aria-valuemax="100">
        </div>
      </div>
    </div>

    <form id="taskForm" class="d-flex mb-3">
      <input type="text" id="taskInput" name="task" class="form-control me-2" placeholder="Enter a task" required>
      <button type="submit" class="btn btn-primary">Add</button>
    </form>

    <div id="alertPlaceholder"></div>
    <div class="container my-4">
    <h4>Progress</h4>
    <div class="progress mb-2" style="height: 25px;">
        <div class="progress-bar progress-bar-striped bg-success" 
             role="progressbar" 
             style="width: <?= $progress ?>%;" 
             aria-valuenow="<?= $progress ?>" 
             aria-valuemin="0" 
             aria-valuemax="100">
            <?= $progress ?>%
        </div>
    </div>
    <p><strong><?= $completedTasks ?></strong> of <strong><?= $totalTasks ?></strong> tasks completed</p>
</div>


    <ul id="taskList" class="list-group">
      <?php
        $sql = "SELECT * FROM tasks ORDER BY created_at DESC";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
          $done = $row['completed'] ? "text-decoration-line-through text-muted" : "";
          echo "<li class='list-group-item d-flex justify-content-between align-items-center $done' data-id='{$row['id']}'>";
          echo "<span class='task-text' style='cursor:pointer'>{$row['task']}</span>";
          echo "<small class='text-muted'>[{$row['created_at']}]</small>";
          echo "<div>
                  <button class='btn btn-sm btn-success me-2 toggle-btn'>✔</button>
                  <button class='btn btn-sm btn-danger delete-btn'>✖</button>
                </div>";
          echo "</li>";
        }
      ?>
    </ul>
  </div>

  <script src="script.js"></script>
</body>
</html>
