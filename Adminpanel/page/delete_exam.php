<?php
// Include your database connection file
include("database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['exam_id'])) {
        $examId = $_POST['exam_id'];

        // Perform the deletion query here
        $deleteQuery = "DELETE FROM exam_tbl WHERE ex_id = $examId";

        if ($conn->query($deleteQuery) === TRUE) {
            echo "Exam deleted successfully";
        } else {
            echo "Error deleting exam: " . $conn->error;
        }
    } else {
        echo "Exam ID not provided";
    }
}
?>
