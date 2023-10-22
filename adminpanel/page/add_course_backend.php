<?php
// Assuming $conn is your mysqli connection
include("database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['course_name'])) {
    // Retrieve all the necessary course details from the POST request
    $courseName = $_POST['course_name'];
    $courseDescription = $_POST['course_description'];
    $courseCode = $_POST['course_code'];
    $courseCategory = $_POST['course_category'];
    $courseInstructor = $_POST['course_instructor'];
    $courseMaterials = $_POST['course_materials'];
    $coursePrerequisites = $_POST['course_prerequisites'];
    $courseFees = $_POST['course_fees'];

    // Check if the course already exists in the database
    $checkQuery = $conn->query("SELECT * FROM course_tbl WHERE course_name = '$courseName'");
    if ($checkQuery->num_rows > 0) {
        // If the course already exists, display an appropriate message
        echo "Course already added.";
    } else {
        // If the course doesn't exist, insert it into the database
        $insertQuery = $conn->query("INSERT INTO course_tbl (course_name, course_description, course_code, course_category, course_instructor, course_materials, course_prerequisites, course_fees) VALUES ('$courseName', '$courseDescription', '$courseCode', '$courseCategory', '$courseInstructor', '$courseMaterials', '$coursePrerequisites', '$courseFees')");
        if ($insertQuery === TRUE) {
            // If the course is successfully added, display a success message
            echo "Course added successfully.";
        } else {
            // If an error occurs while adding the course, display an error message
            echo "Error adding course: " . $conn->error;
        }
    }
}
?>
