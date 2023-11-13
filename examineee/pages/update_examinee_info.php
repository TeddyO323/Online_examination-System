<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['reg_no'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include the file containing the database connection details
    require_once('database.php');

    // Escape user inputs for security
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $birthdate = mysqli_real_escape_string($conn, $_POST['birthdate']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $contact_no = mysqli_real_escape_string($conn, $_POST['contact_no']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Attempt to update the record
    $reg_no = $_SESSION['reg_no'];
    $sql = "UPDATE examinee_tbl SET exmne_fullname='$fullname', exmne_gender='$gender', exmne_birthdate='$birthdate', address='$address', contact_no='$contact_no', exmne_email='$email' WHERE reg_no='$reg_no'";

    if ($conn->query($sql) === true) {
        // Set a session variable to indicate successful update
        $_SESSION['update_success'] = true;

        // Redirect to the examinee's info page after a successful update
        header("Location: examinee_info.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>
