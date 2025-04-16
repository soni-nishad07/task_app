<?php
require 'auth.php';
require 'db.php';

if (!isLoggedIn()) {
  header("Location: login.php");
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $user_id = $_SESSION['user_id'];
  $title = $_POST['title'];
  $deadline = $_POST['deadline'] ?: '0000-00-00';
  $priority = $_POST['priority'];
  $status = 'pending';

  $stmt = $conn->prepare("INSERT INTO tasks (user_id, title, deadline, priority, status) VALUES (?, ?, ?, ?, ?)");
  $stmt->bind_param("issss", $user_id, $title, $deadline, $priority, $status);
  $stmt->execute();
}

header("Location: dashboard.php");
exit;
