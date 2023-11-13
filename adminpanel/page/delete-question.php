<?php
// Include the file for database connection
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the question ID is set
    if (isset($_POST['eqt_id'])) {
        $eqtId = $_POST['eqt_id'];
        // SQL query to delete the question with the specified ID
        $sql = "DELETE FROM exam_question_tbl WHERE eqt_id = $eqtId";

        if ($conn->query($sql) === TRUE) {
            echo "Question deleted successfully!";
        } else {
            echo "Error deleting question: " . $conn->error;
        }
    } else {
        echo "Question ID not set.";
    }
} else {
    echo "Invalid request method.";
}

// Close the database connection
$conn->close();
?>
