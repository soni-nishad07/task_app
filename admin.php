
<?php
require 'auth.php';
require 'db.php';
if (!isLoggedIn() || !isAdmin()) header("Location: login.php");

?>