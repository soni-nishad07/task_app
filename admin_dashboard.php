<?php
require 'auth.php';
require 'db.php';
if (!isLoggedIn()) header("Location: login.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Task Dashboard</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/style.css">
</head>

<body>

  <div class="container">

  <h2 class="my-4">Welcome, 
      <span style="color: red;">
      <?= htmlspecialchars($_SESSION['name']) ?>
    </span> | <a href="logout.php">Logout</a></h2>
    <?php if (isAdmin()) echo '<a href="admin.php" class="btn btn-primary mb-4">Admin Panel</a>'; ?>

    <div id="task-container" class="my-4"></div>


    <div class="task_sec">
    <h3 class="m-3">Add Task</h3>
    <div class="mb-3">
      <input id="title" class="form-control" placeholder="Title">
    </div>
    <div class="mb-3">
      <input id="deadline" type="date" class="form-control">
    </div>
    <div class="mb-3">
      <select id="priority" class="form-control">
        <option>High</option>
        <option>Medium</option>
        <option>Low</option>
      </select>
    </div>
    <button onclick="addTask()" class="btn btn-success">Add Task</button>
    </div>

    
  </div>

  <!-- Bootstrap JS and dependencies -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
  <script src="assets/script.js"></script>
</body>
</html>
