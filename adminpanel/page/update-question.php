<?php
// Include the file for database connection
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the necessary form fields are set
    if (isset($_POST['eqt_id'], $_POST['question'], $_POST['choice1'], $_POST['choice2'], $_POST['choice3'], $_POST['choice4'], $_POST['correct_answer'])) {
        $questionId = $_POST['eqt_id'];
        $updatedQuestion = $_POST['question'];
        $updatedChoice1 = $_POST['choice1'];
        $updatedChoice2 = $_POST['choice2'];
        $updatedChoice3 = $_POST['choice3'];
        $updatedChoice4 = $_POST['choice4'];
        $updatedCorrectAnswer = $_POST['correct_answer'];

        // Update the question, choices, and correct answer in the database
        $sql = "UPDATE exam_question_tbl SET exam_question = '$updatedQuestion', 
                exam_ch1 = '$updatedChoice1', exam_ch2 = '$updatedChoice2', 
                exam_ch3 = '$updatedChoice3', exam_ch4 = '$updatedChoice4', 
                exam_answer = '$updatedCorrectAnswer' 
                WHERE eqt_id = $questionId";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Successfully updated the question, choices, and correct answer.');</script>";
        } else {
            echo "Error updating question, choices, and correct answer: " . $conn->error;
        }
    } else {
        echo "One or more form fields are missing.";
    }
} else {
    echo "Invalid request method. Please use a valid POST request.";
}

// Close the database connection
$conn->close();
?>
