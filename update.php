<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $sql = "UPDATE tasks SET completed = NOT completed WHERE id = $id";
    $conn->query($sql);
}
?>
