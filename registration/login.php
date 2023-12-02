<?php
session_start();
include("db.php"); // Include the database connection file

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Retrieve user data from the database
    $sql = "SELECT id, username, password FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($user_id, $db_username, $db_password);
        $stmt->fetch();

        // Verify the password (you should use password_verify() in a real application)
        if ($password === $db_password) {
            // Authentication successful, set session variables
            $_SESSION["user_id"] = $user_id;
            $_SESSION["username"] = $db_username;

            // Redirect to the empty.php page after successful login
            header("Location: empty.php");
            exit;
        } else {
            // Invalid password
            header("Location: login.html?error=1");
            exit;
        }
    } else {
        // User not found
        header("Location: login.html?error=1");
        exit;
    }

    // Close database connection
    $stmt->close();
}
?>
