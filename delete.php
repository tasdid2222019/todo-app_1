<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['id'])) {
    $id = intval($_POST['id']);
    $sql = "DELETE FROM tasks WHERE id = $id";
    $conn->query($sql);
}
?>
