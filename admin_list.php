<?php
require 'auth.php';
require 'db.php';
if (!isLoggedIn() || !isAdmin()) header("Location: login.php");

// Filtering logic
$where = "1=1";
$params = [];
if (!empty($_GET['status'])) {
    $where .= " AND t.status = ?";
    $params[] = $_GET['status'];
}
if (!empty($_GET['priority'])) {
    $where .= " AND t.priority = ?";
    $params[] = $_GET['priority'];
}
if (!empty($_GET['deadline'])) {
    $where .= " AND t.deadline = ?";
    $params[] = $_GET['deadline'];
}

$sql = "SELECT t.*, u.name FROM tasks t JOIN users u ON t.user_id = u.id WHERE $where ORDER BY t.id DESC";
$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $types = str_repeat('s', count($params));
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin - Task Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>
  <div class="container py-4">
    <h2>Admin Panel | All Task List</h2>
    <a href="dashboard.php" class="btn btn-secondary mb-3">Back</a>

    <!-- Filters -->
    <form method="GET" class="row g-2 mb-4">
      <div class="col-md-3">
        <select name="status" class="form-select">
          <option value="">All Status</option>
          <option value="pending" <?= isset($_GET['status']) && $_GET['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
          <option value="completed" <?= isset($_GET['status']) && $_GET['status'] == 'completed' ? 'selected' : '' ?>>Completed</option>
        </select>
      </div>
      <div class="col-md-3">
        <select name="priority" class="form-select">
          <option value="">All Priority</option>
          <option value="High" <?= isset($_GET['priority']) && $_GET['priority'] == 'High' ? 'selected' : '' ?>>High</option>
          <option value="Medium" <?= isset($_GET['priority']) && $_GET['priority'] == 'Medium' ? 'selected' : '' ?>>Medium</option>
          <option value="Low" <?= isset($_GET['priority']) && $_GET['priority'] == 'Low' ? 'selected' : '' ?>>Low</option>
        </select>
      </div>
      <div class="col-md-3">
        <input type="date" name="deadline" class="form-control" value="<?= $_GET['deadline'] ?? '' ?>">
      </div>
      <div class="col-md-3">
        <button class="btn btn-primary w-100">Filter</button>
      </div>
    </form>

    <!-- Task Table -->
    <table class="table table-bordered table-hover">
      <thead class="table-light">
        <tr>
          <th>User</th>
          <th>Title</th>
          <th>Deadline</th>
          <th>Priority</th>
          <th>Status</th>
          <th>Update Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()) { ?>
          <tr>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['title']) ?></td>
            <td><?= htmlspecialchars($row['deadline']) ?></td>
            <td><?= htmlspecialchars($row['priority']) ?></td>
            <td><?= htmlspecialchars($row['status']) ?></td>
            <td>
              <form action="update_status.php" method="POST" class="d-flex align-items-center">
                <input type="hidden" name="task_id" value="<?= $row['id'] ?>">
                <select name="status" class="form-select form-select-sm me-2">
                  <option value="pending" <?= $row['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                  <option value="completed" <?= $row['status'] == 'completed' ? 'selected' : '' ?>>Completed</option>
                </select>
                <button type="submit" class="btn btn-sm btn-outline-primary">Update</button>
              </form>
            </td>
            <td>
              <form action="admin_delete.php" method="POST" onsubmit="return confirm('Delete this task?')">
                <input type="hidden" name="task_id" value="<?= $row['id'] ?>">
                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
              </form>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
