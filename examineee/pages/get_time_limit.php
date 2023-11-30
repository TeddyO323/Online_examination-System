<?php
// get_exam_time_limit.php

// Assuming you have a database connection established already
require_once('database.php');

// Get the exam ID from the AJAX request
$examId = $_GET['exam_id'];

// Fetch the time limit for the specified exam from the database
$sql = "SELECT exam_time_limit FROM exam_tbl WHERE ex_id='$examId'";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $timeLimit = $row['exam_time_limit'];

    // Return the time limit in minutes
    echo $timeLimit;
} else {
    // Return a default time limit if the query fails
    echo 0;
}

// Close the database connection
$conn->close();
?>
