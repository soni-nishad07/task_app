<?php
require 'auth.php';
require 'db.php';

if (!isLoggedIn()) {
  header("Location: login.php");
  exit;
}

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role']; // Get role (admin/user)
$task_id = $_GET['id'] ?? null;

// Fetch task (admins can fetch any task)
if ($role === 'admin') {
  $stmt = $conn->prepare("SELECT * FROM tasks WHERE id = ?");
  $stmt->bind_param("i", $task_id);
} else {
  $stmt = $conn->prepare("SELECT * FROM tasks WHERE id = ? AND user_id = ?");
  $stmt->bind_param("ii", $task_id, $user_id);
}

$stmt->execute();
$result = $stmt->get_result();
$task = $result->fetch_assoc();

if (!$task) {
  die("Task not found or access denied.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = $_POST['title'];
  $deadline = $_POST['deadline'];
  $priority = $_POST['priority'];

  if ($role === 'admin') {
    $status = $_POST['status'];
    $stmt = $conn->prepare("UPDATE tasks SET title = ?, deadline = ?, priority = ?, status = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $title, $deadline, $priority, $status, $task_id);
  } else {
    // Don't allow status to be updated by users
    $stmt = $conn->prepare("UPDATE tasks SET title = ?, deadline = ?, priority = ? WHERE id = ? AND user_id = ?");
    $stmt->bind_param("sssii", $title, $deadline, $priority, $task_id, $user_id);
  }

  $stmt->execute();
  header("Location: dashboard.php");
  exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Task</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="./assets/style.css">
</head>

<body>
<div class="container py-4">
  <div class="task_sec1 p-3 mt-5">
    <h2>Edit Task</h2>
    <form method="POST">
      <div class="mb-3">
        <label>Title</label>
        <input name="title" value="<?= htmlspecialchars($task['title']) ?>" class="form-control" required>
      </div>

      <div class="mb-3">
        <label>Deadline</label>
        <input name="deadline" type="date" value="<?= $task['deadline'] ?>" class="form-control">
      </div>

      <div class="mb-3">
        <label>Priority</label>
        <select name="priority" class="form-control">
          <option value="High" <?= $task['priority'] === 'High' ? 'selected' : '' ?>>High</option>
          <option value="Medium" <?= $task['priority'] === 'Medium' ? 'selected' : '' ?>>Medium</option>
          <option value="Low" <?= $task['priority'] === 'Low' ? 'selected' : '' ?>>Low</option>
        </select>
      </div>

      <div class="mb-3">
        <label>Status</label>
        <?php if ($role === 'admin'): ?>
          <select name="status" class="form-control">
            <option value="pending" <?= $task['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
            <option value="completed" <?= $task['status'] === 'completed' ? 'selected' : '' ?>>Completed</option>
          </select>
        <?php else: ?>
          <input class="form-control" value="<?= htmlspecialchars($task['status']) ?>" disabled>
        <?php endif; ?>
      </div>

      <button class="btn btn-primary">Update Task</button>
      <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
    </form>
  </div>
</div>
</body>
</html>
