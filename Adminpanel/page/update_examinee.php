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
        $course_id = $_POST['course']; // Change the variable name to $course_id
        $email = $_POST['email'];
        $password = $_POST['password'];
        $contact_no = $_POST['contact_no'];
        $address = $_POST['address'];

        // Get the course_name based on the selected course_id
        $course_result = $conn->query("SELECT course_name FROM course_tbl WHERE cou_id = $course_id");
        $course_row = $course_result->fetch_assoc();
        $course_name = $course_row['course_name'];

        // Prepare and bind the SQL statement to update the examinee
        $stmt = $conn->prepare("UPDATE examinee_tbl SET exmne_fullname = ?, reg_no = ?, exmne_birthdate = ?, exmne_gender = ?, exmne_course = ?, exmne_email = ?, exmne_password = ?, contact_no = ?, address = ? WHERE exmne_id = ?");
        $stmt->bind_param("sssssssssi", $fullname, $reg_no, $birthdate, $gender, $course_name,  $email, $password, $contact_no, $address, $exmne_id);

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
