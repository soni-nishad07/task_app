

<?php
require 'db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = 'user';
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $password, $role);
    $stmt->execute();
    header("Location: login.php");
    exit;
}
?>



<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home</title>

        <?php include('link.php'); ?>
    </head>
    <body>
        <?php include('nav.php'); ?>

        <section class="login_sec">
            <div class="login_box">
                <h2>Register In</h2>
                <form action="" method="POST">
                <div class="form-group">
                        <label for="name">Name*</label>
                        <input type="text" name="name" placeholder="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email*</label>
                        <input type="email" name="email" placeholder="Email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password*</label>
                        <input type="password" name="password" placeholder="Password" required>
                    </div>
                    <button type="submit">Register</button>
                </form>
            </div>
        </section>

    </body>
    </html>