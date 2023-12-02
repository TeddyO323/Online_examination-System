<?php
// Database connection details
$db_host = "localhost";     // Database host (e.g., localhost)
$db_username = "root"; // Database username
$db_password = ""; // Database password
$db_name = "your_db_name";     // Database name

// Create a database connection
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

// Check for a successful database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
