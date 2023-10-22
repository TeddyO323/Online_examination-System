<?php
// Include the database connection
include("database.php");

// Check if the 'id' parameter is set and not empty
if(isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    // Check if the form has been submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validate and sanitize the input, then update the database
        $courseName = $_POST['course_name']; // Assuming 'course_name' is the field name from the form
        $courseName = mysqli_real_escape_string($conn, $courseName); // Sanitize the input

        // Update Query
        $updateQuery = "UPDATE course_tbl SET course_name = '$courseName' WHERE cou_id = $id";

        // Execute the update query
        if (mysqli_query($conn, $updateQuery)) {
            // Redirect to the desired page after the operation is completed
            header("Location: manage-course.php");
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    }
} else {
    // Handle the case when the ID is not provided
    echo "Invalid request!";
}
?>
