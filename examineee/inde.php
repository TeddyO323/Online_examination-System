<?php
// Start session
session_start();

// Check if the user is logged in, if not, redirect to the login page
if (!isset($_SESSION['reg_no'])) {
    header("Location: login.php");
    exit();
}

// Include the file containing the database connection details
require_once('database.php');

// Retrieve the examinee's name from the database based on the registration number
$reg_no = $_SESSION['reg_no'];
$sql = "SELECT exmne_fullname FROM examinee_tbl WHERE reg_no = '$reg_no'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $exmne_fullname = $row['exmne_fullname'];
} else {
    $exmne_fullname = "Examinee";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Welcome to the Index Page</title>
    <!-- Add your custom styles and scripts here -->
</head>
<body>
    <!-- Add your content for the index page here -->
    <h2>Welcome, <?php echo $exmne_fullname . " (" . $reg_no . ")"; ?></h2>
    <p>This is the main content of your index page.</p>
</body>
</html>
