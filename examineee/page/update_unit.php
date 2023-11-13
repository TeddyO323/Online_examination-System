<?php
// Add your database connection file here
include("database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming you have the necessary validation and sanitation of the input data

    // Retrieve the values from the form
    $unitId = $_POST['unit_id'];
    $unitName = $_POST['unit_name'];
    $unitCode = $_POST['unit_code'];
    $courseName = $_POST['course_name'];

    // Implement the logic for updating the unit in the database
    $updateQuery = "UPDATE units_tbl SET unit_name='$unitName', unit_code='$unitCode', course_name='$courseName' WHERE unit_id='$unitId'";

    if ($conn->query($updateQuery) === TRUE) {
        // Handle the successful update case
        echo "<script>alert('Unit Updated successfully');</script>";
    } else {
        // Handle the case when the update operation fails
        echo "Error updating unit: " . $conn->error;
    }
}
?>
