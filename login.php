

<?php
require 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = $_POST['password'];

    // Run query
    $query = "SELECT id, name, password, role FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);

        if (password_verify($password, $row['password'])) {
            // Store session data
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['role'] = $row['role'];

            header("Location: dashboard.php");
            exit;
        } else {
            echo "Invalid credentials.";
        }
    } else {
        echo "Invalid credentials.";
    }
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
                <h2>Log In</h2>
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="email">Email*</label>
                        <input type="email" name="email" placeholder="Email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password*</label>
                        <input type="password" name="password" placeholder="Password" required>
                    </div>
                    <button type="submit">Log In</button>
                </form>
            </div>
        </section>

    </body>
    </html>