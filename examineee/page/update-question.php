<?php
// Include the file for database connection
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the necessary form fields are set
    if (isset($_POST['eqt_id'], $_POST['ex_id'])) {
        $questionId = $_POST['eqt_id'];
        $exId = $_POST['ex_id'];

        // Update the question based on the question type
        if (isset($_POST['question'])) {
            $updatedQuestion = $conn->real_escape_string($_POST['question']);
            $sql = "UPDATE exam_question_tbl SET exam_question = '$updatedQuestion' WHERE eqt_id = $questionId";
            if (!$conn->query($sql)) {
                echo "Error updating question: " . $conn->error;
            }
        }

        // Update the choices for multiple-choice questions
        if (isset($_POST['choices'])) {
            $choices = $_POST['choices'];
            $choiceLetters = ['1', '2', '3', '4']; // If the choices go beyond D, add more letters
            for ($i = 0; $i < count($choices); $i++) {
                $choice = $conn->real_escape_string($choices[$i]);
                $choiceLetter = $choiceLetters[$i];
                $sql = "UPDATE exam_question_tbl SET exam_ch$choiceLetter = '$choice' WHERE eqt_id = $questionId";
                if (!$conn->query($sql)) {
                    echo "Error updating choice $choiceLetter: " . $conn->error;
                }
            }
        }

        // Update the correct answer if available
        if (isset($_POST['correct_answer'])) {
            $updatedCorrectAnswer = $conn->real_escape_string($_POST['correct_answer']);
            $sql = "UPDATE exam_question_tbl SET exam_answer = '$updatedCorrectAnswer' WHERE eqt_id = $questionId";
            if (!$conn->query($sql)) {
                echo "Error updating correct answer: " . $conn->error;
            }
        }

        // Prompt for a successful update
        echo "<script>alert('Successfully updated the question!');</script>";
    } else {
        echo "One or more form fields are missing.";
    }
} else {
    echo "Invalid request method. Please use a valid POST request.";
}

// Close the database connection
$conn->close();
?>
