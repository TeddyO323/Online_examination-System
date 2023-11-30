<?php
include("database.php");

// Assuming you are passing exam_id through GET parameter
$examId = $_GET['exam_id'];

// Check if the exam_id is provided
if (!isset($examId)) {
    $response = ['success' => false, 'message' => 'Exam ID not provided'];
    echo json_encode($response);
    exit;
}

// Perform the deletion in your database
$sql = "DELETE FROM exam_tbl WHERE ex_id = '$examId'";

if ($conn->query($sql) === TRUE) {
    $response = ['success' => true, 'message' => 'Exam deleted successfully'];
    echo json_encode($response);
} else {
    $response = ['success' => false, 'message' => 'Error deleting exam: ' . $conn->error];
    echo json_encode($response);
}

// Close the database connection
$conn->close();
?>
