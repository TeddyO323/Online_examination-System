<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once('database.php');

if (isset($_POST['reg_no']) && isset($_POST['exmne_password'])) {
    $reg_no = $_POST['reg_no'];
    $exmne_password = $_POST['exmne_password'];

    $sql = "SELECT * FROM examinee_tbl WHERE reg_no = '$reg_no' AND exmne_password = '$exmne_password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if ($row['exmne_status'] == 'active') {
            $_SESSION['reg_no'] = $reg_no;
            header("Location: index.php");
            exit();
        } else {
            echo '<p style="color: red; font-weight: bold;">Your account is suspended. Please contact the administrator for assistance.</p>';
        }
    } else {
        echo '<p style="color: red;">Invalid login credentials. Please try again.</p>';
    }
} else {
    echo '<p style="color: red;">Please fill in both the registration number and password fields.</p>';
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examinee Login</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            width: 300px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .login-container h2 {
            text-align: center;
            color: #333;
        }

        .login-container label {
            display: block;
            margin-bottom: 8px;
            color: #555;
        }

        .login-container input {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .login-container button {
            width: 100%;
            padding: 10px;
            background-color: #3498db;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .login-container button:hover {
            background-color: #2980b9;
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
        <!-- Add this after the form tag in your HTML -->
<?php
if (isset($_GET['exmne_status']) && $_GET['exmne_status'] == 'suspended') {
    echo '<p style="color: red;">Your account is suspended. Please contact the administrator for assistance.</p>';
}
?>

    </div>
</body>
</html>
