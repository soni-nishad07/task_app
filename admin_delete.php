<?php
require 'auth.php';
require 'db.php';

if (!isLoggedIn() || !isAdmin()) {
  header("Location: login.php");
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['task_id'])) {
  $task_id = intval($_POST['task_id']);

  // Delete task
  $stmt = $conn->prepare("DELETE FROM tasks WHERE id = ?");
  $stmt->bind_param("i", $task_id);
  $stmt->execute();

  header("Location: admin_list.php");
  exit;
}
?>
