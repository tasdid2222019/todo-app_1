<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['task'])) {
    $task = $conn->real_escape_string($_POST['task']);
    $sql = "INSERT INTO tasks (task) VALUES ('$task')";
    if ($conn->query($sql)) {
        echo "Task added!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
