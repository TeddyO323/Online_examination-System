<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once('database.php');

// Retrieve exam_id from the URL
$examId = $_GET['exam_id'] ?? null;

if ($examId === null) {
    // Handle the case when the exam_id is missing or empty
    echo "Error: Missing or empty exam_id parameter.";
    // Optionally, you might want to redirect the user or display a different error message.
    exit();
}

// Check if the user is logged in
if (isset($_SESSION['reg_no'])) {
    $userRegistrationNumber = $_SESSION['reg_no']; // Get the logged-in user's registration number

    // Process form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Insert the attempt into the exam_attempt table
        $sqlInsertAttempt = "INSERT INTO exam_attempt (reg_no, exam_id) VALUES ('$userRegistrationNumber', '$examId')";
        $resultInsertAttempt = $conn->query($sqlInsertAttempt);

        if (!$resultInsertAttempt) {
            echo "Error: " . $sqlInsertAttempt . "<br>" . $conn->error;
            // Handle the error accordingly, redirect, display a message, etc.
        } else {
            // Get the exam attempt ID
            $examAttemptId = $conn->insert_id;

            // Assuming you have a table named exam_answers with columns exans_id, reg_no, exam_id, quest_id, exans_answer, examat_id
            foreach ($_POST as $key => $values) {
                // Check if the input field corresponds to an answer
                if (strpos($key, 'answer_') === 0) {
                    // Extract question_id from the input field name
                    $questionId = substr($key, strlen('answer_'));
            
                    if (is_array($values)) {
                        // Multiple-choice question
                        $answer = implode(',', $values);
                    } else {
                        // Single-choice question
                        $answer = $values;
                    }
            
                    // Process and store the answer in the database
                    $sqlInsertAnswer = "INSERT INTO exam_answers (reg_no, exam_id, quest_id, exans_answer, examat_id) VALUES ('$userRegistrationNumber', '$examId', '$questionId', '$answer', '$examAttemptId')";
                    $resultInsertAnswer = $conn->query($sqlInsertAnswer);
            
                    if (!$resultInsertAnswer) {
                        echo "Error: " . $sqlInsertAnswer . "<br>" . $conn->error;
                        // Handle the error accordingly, redirect, display a message, etc.
                    }
                }
            }
            
            // Success message
            echo "Attempt recorded successfully!";
            // Optionally, you can redirect the user to a success page
            // header('Location: exam_result.php?exam_id=' . $examId);
            // exit();
        }
    }
} else {
    // Error message for not being logged in
    echo "Error: User not logged in.";
}

// Close the database connection
$conn->close();
?>