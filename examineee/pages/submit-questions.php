<?php
session_start();

// Replace with your database connection details
require_once('database.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the form data has been submitted

    // Check if the user is logged in
    if (isset($_SESSION['reg_no'])) {
        $reg_no = $_SESSION['reg_no']; // Get the logged-in user's ID


        // Assuming you have retrieved the exam_id from the URL
        if (isset($_GET['exam_id']) && !empty($_GET['exam_id'])) {
            $exam_id = $_GET['exam_id'];

      // Insert data into the exam_attempt table
$exam_attempt_stmt = $conn->prepare("INSERT INTO exam_attempt (reg_no, exam_id) VALUES (?, ?)");

if ($exam_attempt_stmt) {
    $exam_attempt_stmt->bind_param("si", $reg_no, $exam_id);

    if ($exam_attempt_stmt->execute() === TRUE) {
        // Fetch the examat_id after insertion
        $examat_id = $exam_attempt_stmt->insert_id;
        echo "New record created successfully in exam_attempt table. Exam Attempt ID: $examat_id<br>";
    } else {
        echo "Error: " . $exam_attempt_stmt->error;
    }

    $exam_attempt_stmt->close();

    // Process the exam answers here
    foreach ($_POST['answer'] as $quest_id => $exans_answer) {
        // Prepare and execute the SQL query to insert the data into the exam_answers table
        $exam_answers_stmt = $conn->prepare("INSERT INTO exam_answers (reg_no, exam_id, quest_id, exans_answer, examat_id) VALUES (?, ?, ?, ?, ?)");

        if ($exam_answers_stmt) {
            if (is_array($exans_answer)) {
                $exans_answer = implode(", ", $exans_answer); // Convert array to a string
            }

            // Remove HTML tags from the answer
            $exans_answer = strip_tags($exans_answer);

            $exam_answers_stmt->bind_param("siisi", $reg_no, $exam_id, $quest_id, $exans_answer, $examat_id);

            if ($exam_answers_stmt->execute() === TRUE) {
                echo "New record created successfully for question with ID: " . $quest_id . "<br>";
            } else {
                echo "Error: " . $exam_answers_stmt->error;
            }

            $exam_answers_stmt->close();
        } else {
            echo "Prepare statement failed: " . $conn->error;
        }
    }
} else {
    echo "Prepare statement failed: " . $conn->error;
}

        } else {
            echo "Exam ID is null or empty";
        }
    } else {
        echo "User not logged in"; // Handle the case where the user is not logged in
    }

    $conn->close();
}
?>
