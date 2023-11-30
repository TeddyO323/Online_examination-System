<?php
// Include the database connection file
include("database.php");

// Check if the 'id' parameter is set in the URL
if (isset($_GET['id'])) {
    // Retrieve the course ID from the URL
    $courseId = $_GET['id'];

    // Check if a confirmation has been received from the user
    if (isset($_GET['confirm']) && $_GET['confirm'] === 'true') {
        // SQL query to delete the course with the given ID
        $sql = "DELETE FROM course_tbl WHERE cou_id = $courseId";

        if ($conn->query($sql) === TRUE) {
            echo "Successfully deleted course";
        } else {
            echo "Error deleting course: " . $conn->error;
        }
    } else {
        // JavaScript confirmation prompt
        echo "<script>
            var confirmation = confirm('Are you sure you want to delete this course? The entire units under this course will be deleted as well.');
            if (confirmation) {
                // User confirmed, redirect to this page with confirmation parameter
                var courseId = $courseId;
                window.location.href = 'manage-course.php?id=' + courseId + '&confirm=true';
            } else {
                // User canceled, redirect back to the manage course page
                window.location.href = 'manage-course.php';
            }
        </script>";
    }
} else {
    echo "No course ID provided for deletion";
}

// Close the database connection
$conn->close();
?>
