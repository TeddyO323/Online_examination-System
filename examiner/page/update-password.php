<?php
// Include the file for database connection
include 'database.php';
session_start(); // Start the session to access session variables

// Check if the examiner number is stored in the session
if(isset($_SESSION['examiner_number'])){
    $examinerNumber = $_SESSION['examiner_number'];
} else {
    // Redirect to the login page or display an error message if the examiner number is not found in the session
    // Example:
    header("Location: ../login.php"); // Redirect to the login page
    exit();
}


// Ensure the old password, new password, and confirm password are set
if (isset($_POST['old_password'], $_POST['new_password'], $_POST['confirm_password'])) {
    // Retrieve the entered data
    $oldPassword = $_POST['old_password'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    // Validate if the old password matches the one in the database for the specific examiner
    $examinerNumber = "examiner_number"; // Replace with the actual examiner number
    $sql = "SELECT * FROM examiner_tbl WHERE examiner_number = '$examinerNumber' AND examiner_password = '$oldPassword'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        // Check if the new password matches the confirmed password
        if ($newPassword === $confirmPassword) {
            // Update the examiner's password
            $sql = "UPDATE examiner_tbl SET examiner_password = '$newPassword' WHERE examiner_number = '$examinerNumber'";
            if ($conn->query($sql)) {
                echo "Password updated successfully.";
            } else {
                echo "Error updating password: " . $conn->error;
            }
        } else {
            echo "New password and confirm password do not match.";
        }
    } else {
        echo "Invalid old password.";
    }
} else {
    echo "One or more form fields are missing.";
}

// Close the database connection
$conn->close();
?>
