<?php
// Include the database connection file
include('database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve data from the form
    $feedbackId = $_POST['feedback_id'];
    $feedbackCategory = $_POST['feedback_category'];
    $feedbackText = $_POST['feedback_text'];

    // Update the feedback details in the database
    $updateQuery = "UPDATE feedback_tbl SET feedback_category = '$feedbackCategory', feedback_text = '$feedbackText' WHERE feedback_id = $feedbackId";

    if (mysqli_query($conn, $updateQuery)) {
        // Redirect to the feedback history page or show a success message
        header("Location: feedback_history.php");
        exit();
    } else {
        // Handle the case where the update fails
        echo "Error updating feedback: " . mysqli_error($conn);
    }
} else {
    // Redirect or handle the case where the form is not submitted via POST
    header("Location: feedback_history.php");
    exit();
}

// Close the database connection
$conn->close();
?>
