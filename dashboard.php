<?php
require 'auth.php';
require 'db.php';

if (!isLoggedIn()) {
  header("Location: login.php");
  exit;
}

$user_id = $_SESSION['user_id'];
$role = htmlspecialchars($_SESSION['role']);
$name = htmlspecialchars($_SESSION['name']);

// Filter setup
$where = "user_id = ?";
$params = [$user_id];
$types = "i";

if (!empty($_GET['status'])) {
  $where .= " AND status = ?";
  $params[] = $_GET['status'];
  $types .= "s";
}

if (!empty($_GET['priority'])) {
  $where .= " AND priority = ?";
  $params[] = $_GET['priority'];
  $types .= "s";
}

if (!empty($_GET['deadline'])) {
  $where .= " AND deadline = ?";
  $params[] = $_GET['deadline'];
  $types .= "s";
}

$sql = "SELECT * FROM tasks WHERE $where ORDER BY id DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();
$tasks = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Task Dashboard</title>
  <link rel="stylesheet" href="./assets/style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<div class="container py-4">
  <h2>Welcome, <span class="text-danger"><?= $name ?></span> | <a href="logout.php">Logout</a></h2>

  <div class="admin_btn mt-5">
    <?php if (isAdmin()) echo '<a href="admin_list.php" class="btn btn-primary mb-4">All Task List</a>'; ?>
  </div>

  <div class="task_sec card p-3 mt-1">
    <h4 class="py-4">Add <span style="text-transform: capitalize;"><?= $role ?></span> Task</h4>
    <form action="add_task.php" method="POST">
      <div class="mb-3">
        <input name="title" class="form-control" placeholder="Title" required>
      </div>
      <div class="mb-3">
        <input name="deadline" type="date" class="form-control">
      </div>
      <div class="mb-3">
        <select name="priority" class="form-control">
          <option value="High">High</option>
          <option value="Medium" selected>Medium</option>
          <option value="Low">Low</option>
        </select>
      </div>
      <button class="btn btn-success my-4">Add Task</button>
    </form>
  </div>

  <!-- Filters -->
  <form method="GET" class="row g-2 mt-5 mb-4">
    <div class="col-md-3">
      <select name="status" class="form-select">
        <option value="">All Status</option>
        <option value="pending" <?= (isset($_GET['status']) && $_GET['status'] === 'pending') ? 'selected' : '' ?>>Pending</option>
        <option value="completed" <?= (isset($_GET['status']) && $_GET['status'] === 'completed') ? 'selected' : '' ?>>Completed</option>
      </select>
    </div>
    <div class="col-md-3">
      <select name="priority" class="form-select">
        <option value="">All Priority</option>
        <option value="High" <?= (isset($_GET['priority']) && $_GET['priority'] === 'High') ? 'selected' : '' ?>>High</option>
        <option value="Medium" <?= (isset($_GET['priority']) && $_GET['priority'] === 'Medium') ? 'selected' : '' ?>>Medium</option>
        <option value="Low" <?= (isset($_GET['priority']) && $_GET['priority'] === 'Low') ? 'selected' : '' ?>>Low</option>
      </select>
    </div>
    <div class="col-md-3">
      <input type="date" name="deadline" class="form-control" value="<?= $_GET['deadline'] ?? '' ?>">
    </div>
    <div class="col-md-3">
      <button class="btn btn-primary w-100">Apply Filters</button>
    </div>
  </form>

  <!-- Task List -->
  <div class="task_list">
    <h4 class="mt-2"><span style="text-transform: capitalize;"><?= $role ?></span> Tasks List</h4>
    <?php if (empty($tasks)): ?>
      <p>No tasks found.</p>
    <?php else: ?>
      <table class="table table-bordered">
        <thead class="table-dark">
          <tr>
            <th>Title</th>
            <th>Deadline</th>
            <th>Priority</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($tasks as $task): ?>
          <tr>
            <td><?= htmlspecialchars($task['title']) ?></td>
            <td><?= htmlspecialchars($task['deadline']) ?></td>
            <td><?= htmlspecialchars($task['priority']) ?></td>
            <td><?= htmlspecialchars($task['status']) ?></td>
            <td>
              <a href="edit_task.php?id=<?= $task['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
              <form action="delete_task.php" method="POST" style="display:inline;">
                <input type="hidden" name="task_id" value="<?= $task['id'] ?>">
                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>
</div>
</body>
</html>
