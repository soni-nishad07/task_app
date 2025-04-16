<?php
require 'auth.php';
require 'db.php';

if (isLoggedIn() && isAdmin() && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $task_id = $_POST['task_id'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE tasks SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $task_id);
    $stmt->execute();
}

header("Location: admin_list.php");
exit;
