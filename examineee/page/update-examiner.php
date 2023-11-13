<?php
// Include the file for database connection
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the necessary form fields are set
    if (isset($_POST['examiner_number'], $_POST['examiner_name'], $_POST['examiner_email'], $_POST['contact_number'], $_POST['address'], $_POST['date_of_birth'], $_POST['certification'], $_POST['gender'])) {
        $examinerNumber = $_POST['examiner_number'];
        $examinerName = $conn->real_escape_string($_POST['examiner_name']);
        $examinerEmail = $conn->real_escape_string($_POST['examiner_email']);
        $contactNumber = $conn->real_escape_string($_POST['contact_number']);
        $address = $conn->real_escape_string($_POST['address']);
        $dateOfBirth = $conn->real_escape_string($_POST['date_of_birth']);
        $certification = $conn->real_escape_string($_POST['certification']);
        $gender = $conn->real_escape_string($_POST['gender']);

        // Update the examiner information
        $sql = "UPDATE examiner_tbl SET examiner_name = '$examinerName', examiner_email = '$examinerEmail', contact_number = '$contactNumber', address = '$address', date_of_birth = '$dateOfBirth', certification = '$certification', gender = '$gender' WHERE examiner_number = $examinerNumber";
        if (!$conn->query($sql)) {
            echo "Error updating examiner: " . $conn->error;
        } else {
            echo "<script>alert('Details updated successfully');</script>";
        }
    } else {
        echo "One or more form fields are missing.";
    }
} else {
    echo "Invalid request method. Please use a valid POST request.";
}

// Close the database connection
$conn->close();
?>
