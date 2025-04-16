<?php
require 'auth.php';
require 'db.php';
if (!isLoggedIn()) exit;
$user_id = $_SESSION['user_id'];
$action = $_POST['action'];
if ($action === 'create') {
    $stmt = $conn->prepare("INSERT INTO tasks (user_id, title, deadline, priority, status) VALUES (?, ?, ?, ?, 'pending')");
    $stmt->bind_param("isss", $user_id, $_POST['title'], $_POST['deadline'], $_POST['priority']);
    $stmt->execute();
} elseif ($action === 'read') {
    $res = isAdmin() ? $conn->query("SELECT * FROM tasks") : $conn->query("SELECT * FROM tasks WHERE user_id = $user_id");
    $data = $res->fetch_all(MYSQLI_ASSOC);
    echo json_encode($data);
} elseif ($action === 'delete') {
    $id = (int)$_POST['id'];
    if (isAdmin()) {
        $conn->query("DELETE FROM tasks WHERE id = $id");
    } else {
        $conn->query("DELETE FROM tasks WHERE id = $id AND user_id = $user_id");
    }
}



// =======================================================
?>