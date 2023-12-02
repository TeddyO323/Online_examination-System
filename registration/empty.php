<?php
session_start();

// Check if the user is authenticated (adjust as needed)
if (!isset($_SESSION["user_id"])) {
    header("Location: login.html");
    exit;
}
?>

<?php
session_start();

// Check if the user is authenticated (adjust as needed)
if (!isset($_SESSION["user_id"])) {
    header("Location: login.html");
    exit;
}
?>
<!-- This page intentionally left empty. You can add content here in the future. -->

<!-- Content can be added here -->
<html>
<head>
    <title>Empty Page with Content</title>
</head>
<body>
    <h1>Welcome to the Empty Page</h1>
    <p>You can add more information and content here.</p>
    <!-- Additional content goes here -->
</body>
</html>
