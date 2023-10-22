<?php
// Database connection
include("database.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['unit_name'])) {
    // Check if the unit already exists in the database
    $unitName = $_POST['unit_name'];
    $courseName = $_POST['course_name'];

    $checkQuery = $conn->prepare("SELECT * FROM units_tbl WHERE unit_name = ? AND course_name = ?");
    $checkQuery->bind_param("ss", $unitName, $courseName);
    $checkQuery->execute();
    $checkResult = $checkQuery->get_result();

    if ($checkResult->num_rows > 0) {
        // If the unit already exists, display an appropriate message
        echo "<script>alert('Unit already exists');</script>";
    } else {
        // If the unit doesn't exist, insert it into the database
        $insertQuery = $conn->prepare("INSERT INTO units_tbl (unit_name, course_name) VALUES (?, ?)");
        $insertQuery->bind_param("ss", $unitName, $courseName);

        if ($insertQuery->execute()) {
            // If the unit is successfully added, display a success message
            echo "<script>alert('Successfully added unit');</script>";
        } else {
            // If an error occurs while adding the unit, display an error message
            echo "<script>alert('Error adding unit: " . $conn->error . "');</script>";
        }

        // Close statement
        $insertQuery->close();
    }

    // Close statement
    $checkQuery->close();
}
?>
