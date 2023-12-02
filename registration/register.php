<?php
// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection details (update with your own)
    $db_host = "localhost";
    $db_username = "root";
    $db_password = "";
    $db_name = "your_db_name";

    // Create a database connection
    $conn = new mysqli($db_host, $db_username, $db_password, $db_name);

    // Check for a successful database connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get user input from the registration form
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Perform basic input validation
    if ($password !== $confirm_password) {
        // Passwords do not match
        echo "Passwords do not match.";
    } else {
        // Hash the password (you should use password_hash() in a real application)
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // SQL query to insert user data into the database
        $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        
        // Prepare and execute the statement
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $username, $email, $hashed_password);

        if ($stmt->execute()) {
            // Registration successful
// Registration successful message
echo "Registration successful. You can now log in.";

// Redirect to login page
header("Location: login.html");
exit; // Add this line
        } else {
            // Registration failed
            echo "Error: " . $conn->error;
        }

        // Close the database connection
        $stmt->close();
    }

    // Close the database connection
    $conn->close();
}
?>
