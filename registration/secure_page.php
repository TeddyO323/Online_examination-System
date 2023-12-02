<?php
session_start();

// Check if the user is authenticated
if (!isset($_SESSION["user_id"])) {
    header("Location: login.html");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Secure Page</title>
</head>
<body>
    <h1>Welcome, <?php echo $_SESSION["username"]; ?></h1>
    <p>This is a secure page.</p>
    <a href="logout.php">Logout</a>
</body>
</html>
