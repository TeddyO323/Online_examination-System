

<?php
    include 'database.php';
    session_start();

    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Using prepared statements to prevent SQL injection
        $stmt = $conn->prepare("SELECT * FROM examiner_tbl WHERE examiner_email=? AND examiner_password=?");
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION['examiner_number'] = $row['examiner_number']; // Set the session variable to the examiner's unique identifier
            header("Location: index.php");
            exit();
        } else {
            echo "<p style='color: red;'>Invalid email or password. Please try again.</p>";
        }

        $stmt->close();
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            padding-top: 100px;
        }

        form {
            max-width: 300px;
            margin: 0 auto;
            background: #ffffff;
            padding: 25px;
            border-radius: 5px;
            box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.1);
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 100%;
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        h2 {
            color: #333;
        }
    </style>
    </head>
<body>
    <h2>Examiner Login</h2>
    <form action="" method="post">
        Email: <input type="text" name="email"><br><br>
        Password: <input type="password" name="password"><br><br>
        <input type="submit" value="Log In">
    </form>
</body>
</html>
