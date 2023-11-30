<?php
// Start or resume the session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Check if the user is logged in
if (!isset($_SESSION['reg_no'])) {
    // Respond with an error or redirect the user to the login page
    http_response_code(403); // Forbidden
    exit();
}

// Retrieve the 'exam_id' from the URL
$examId = $_GET['exam_id'];

// Check if the attempt count is set in the session
if (isset($_SESSION['exam_attempts'][$examId]) && $_SESSION['exam_attempts'][$examId] > 0) {
    // Decrement the attempt count in the session
    $_SESSION['exam_attempts'][$examId]--;
} else {
    // Respond with an error or handle the case where attempts are depleted
    http_response_code(400); // Bad Request
    exit();
}

// Respond with a success message
echo "Attempts decremented successfully.";
?>
