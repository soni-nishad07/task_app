<?php
require 'auth.php';
require 'db.php';

if (!isLoggedIn()) {
  header("Location: login.php");
  exit;
}

$user_id = $_SESSION['user_id'];
$task_id = $_POST['task_id'];

// Ensure the task belongs to the logged-in user
$stmt = $conn->prepare("DELETE FROM tasks WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $task_id, $user_id);
$stmt->execute();

// header("Location: dashboard.php");
header("Location: admin_list.php");

exit;
