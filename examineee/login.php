<?php
// Include the file containing the database connection details
require_once('database.php');

// Check if form fields are set
if (isset($_POST['reg_no']) && isset($_POST['exmne_password'])) {
    // Retrieve data from the form
    $reg_no = $_POST['reg_no'];
    $exmne_password = $_POST['exmne_password'];

    // SQL query to fetch user data
    $sql = "SELECT * FROM examinee_tbl WHERE reg_no = '$reg_no' AND exmne_password = '$exmne_password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Start session
        session_start();

        // Store data in session variables if login is successful
        $_SESSION['reg_no'] = $reg_no;

        // Redirect to the user's dashboard or homepage
        header("Location: index.php"); // Redirect to index.php after successful login
        exit();
    } else {
        echo "Invalid login credentials. Please try again.";
    }
} else {
    echo "Please fill in both the registration number and password fields.";
}

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Examinee Login</title>
    <style>
        /* Add your custom CSS here */
        body {
            font-family: Arial, sans-serif;
        }
        .login-container {
            width: 300px;
            margin: 0 auto;
            margin-top: 100px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .login-container h2 {
            text-align: center;
        }
        .login-container label, .login-container input, .login-container button {
            display: block;
            width: 100%;
            margin-bottom: 10px;
        }
        .login-container button {
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .login-container button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Examinee Login</h2>
        <form method="post" action="login.php">
            <label for="reg_no">Registration Number:</label>
            <input type="text" id="reg_no" name="reg_no" required>
            <label for="exmne_password">Password:</label>
            <input type="password" id="exmne_password" name="exmne_password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
