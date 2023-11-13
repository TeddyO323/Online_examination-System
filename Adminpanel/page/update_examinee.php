<?php
    // Include the database connection
    include 'database.php';

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        $exmne_id = $_POST['exmne_id'];
        $fullname = $_POST['fullname'];
        $reg_no = $_POST['reg_no'];
        $birthdate = $_POST['birthdate'];
        $gender = $_POST['gender'];
        $course = $_POST['course'];
        $year_level = $_POST['year_level'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $contact_no = $_POST['contact_no'];
        $address = $_POST['address'];

        // Prepare and bind the SQL statement to update the examinee
        $stmt = $conn->prepare("UPDATE examinee_tbl SET exmne_fullname = ?, reg_no = ?, exmne_birthdate = ?, exmne_gender = ?, exmne_course = ?, exmne_year_level = ?, exmne_email = ?, exmne_password = ?, contact_no = ?, address = ? WHERE exmne_id = ?");
        $stmt->bind_param("ssssisssssi", $fullname, $reg_no, $birthdate, $gender, $course, $year_level, $email, $password, $contact_no, $address, $exmne_id);

        // Execute the statement
        if ($stmt->execute()) {
            // Examinee updated successfully
            echo "<script>alert('Update successful');</script>";
        } else {
            // Error in updating examinee
            echo "Error: " . $stmt->error;
        }

        // Close the statement and the connection
        $stmt->close();
        $conn->close();
        
    }
?>

