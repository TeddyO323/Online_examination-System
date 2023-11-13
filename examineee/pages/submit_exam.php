<?php
    // Check if the form has been submitted
    if(isset($_POST['confirm_submit'])){
        // Assuming you have a database connection
        require_once('database.php');

        // Extract the submitted answers and other relevant information
        $examId = $_GET['exam_id']; // Get the exam ID from the URL
        $userId = 1; // Assuming the user ID is hardcoded for demonstration purposes
        $submittedAnswers = $_POST['submitted_answers']; // Assuming the answers are in a format you can store in the database

        // Process the submitted answers and store them in the database
        $sql = "INSERT INTO exam_attempt (exmne_id, exam_id, submitted_answers) VALUES ('$userId', '$examId', '$submittedAnswers')";
        if($conn->query($sql) === TRUE){
            echo "<h2>Exam Submitted Successfully</h2>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        // If the form has not been submitted, redirect back to the exam page
        header("Location: exam.php?exam_id=" . $_GET['exam_id']);
        exit();
    }
?>
