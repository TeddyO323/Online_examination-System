<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include the database connection file
    include("database.php");

    // Get the values from the form
    $courseID = $_POST['course_id'];
    $courseName = $_POST['course_name'];
    $courseDescription = $_POST['course_description'];
    $courseCode = $_POST['course_code'];
    $courseCategory = $_POST['course_category'];
    $courseInstructor = $_POST['course_instructor'];
    $courseMaterials = $_POST['course_materials'];
    $coursePrerequisites = $_POST['course_prerequisites'];
    $courseFees = $_POST['course_fees'];

    // Update the course in the database
    $sql = "UPDATE course_tbl SET course_name='$courseName', course_description='$courseDescription', course_code='$courseCode', course_category='$courseCategory', course_instructor='$courseInstructor', course_materials='$courseMaterials', course_prerequisites='$coursePrerequisites', course_fees='$courseFees' WHERE cou_id=$courseID";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Course updated successfully');</script>";
    } else {
        echo "Error updating course: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
} else {
    echo "<script>alert('Form not submitted successfully!');</script>";
}
?>
