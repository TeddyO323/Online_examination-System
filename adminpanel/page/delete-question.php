<?php
// Include the file for database connection
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['eqt_id'])) {
    $questionId = $_POST['eqt_id'];

    // SQL to delete the question based on the eqt_id
    $sql = "DELETE FROM exam_question_tbl WHERE eqt_id = $questionId";

    if ($conn->query($sql) === TRUE) {
        // Deletion was successful
        echo "Question deleted successfully!";
    } else {
        // Error occurred during deletion
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    // Invalid request method or missing parameters
    echo "Invalid request. Please try again.";
}

// Close the database connection
$conn->close();
?>
