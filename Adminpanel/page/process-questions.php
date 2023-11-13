<?php
// Include the file for database connection
include 'database.php';
$exId = null;

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Function to sanitize input data
    function sanitize($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
        
    }
    $exId = intval($exId); // Convert to integer to prevent SQL injection

    $exId = $conn->real_escape_string($_POST['ex_id']); // Make sure to get ex_id

    $exId = $_POST['ex_id'];

    // Get the marks from the POST data
    $marks = $_POST['marks'];

    if (isset($_POST['mc_single_question'])) {
        $question = sanitize($_POST['mc_single_question']);

        // Sanitize the data
        $question = sanitize($_POST['mc_single_question']);
        $option1 = sanitize($_POST['s_option1_value']);
        $option2 = sanitize($_POST['s_option2_value']);
        $option3 = sanitize($_POST['s_option3_value']);
        $option4 = sanitize($_POST['s_option4_value']);
        $correctAnswer = $_POST['mc_single_correct_answer'];

        // File upload handling
        $image = $_FILES['mc_single_image']['name'];
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["mc_single_image"]["name"]);
        move_uploaded_file($_FILES["mc_single_image"]["tmp_name"], $target_file);

        // Insert into the database with the marks included
        $sql = "INSERT INTO exam_question_tbl (ex_id, exam_question, exam_ch1, exam_ch2, exam_ch3, exam_ch4, photo, exam_answer, question_type, marks) VALUES ('$exId','$question', '$option1', '$option2', '$option3', '$option4', '$image', '$correctAnswer', 'single_choice', '$marks')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Question added successfully');</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } elseif (isset($_POST['mc_multiple_question'])) {
        $question = $conn->real_escape_string($_POST['mc_multiple_question']);
        $option1 = $conn->real_escape_string($_POST['mc_multiple_option1_value']);
        $option2 = $conn->real_escape_string($_POST['mc_multiple_option2_value']);
        $option3 = $conn->real_escape_string($_POST['mc_multiple_option3_value']);
        $option4 = $conn->real_escape_string($_POST['mc_multiple_option4_value']);
    
        // Handle multiple correct answers as an array
        $selectedAnswers = isset($_POST['correct_answer']) ? $_POST['correct_answer'] : [];
        
        // Ensure each selected answer is a simple value
        $selectedAnswers = array_map([$conn, 'real_escape_string'], $selectedAnswers);
    
        // Convert the array of correct answers to a string
        $correctAnswer = implode(",", $selectedAnswers);
        
        $marks = $conn->real_escape_string($_POST['marks']);
    
    

        
        // File upload handling
        $image = $_FILES['mc_multiple_image']['name'];
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["mc_multiple_image"]["name"]);
        move_uploaded_file($_FILES["mc_multiple_image"]["tmp_name"], $target_file);
    
        // Insert into the database with the marks included
        $sql = "INSERT INTO exam_question_tbl (ex_id, exam_question, exam_ch1, exam_ch2, exam_ch3, exam_ch4, photo, exam_answer, question_type, marks) VALUES ('$exId','$question', '$option1', '$option2', '$option3', '$option4', '$image', '$correctAnswer', 'multiple_choice', '$marks')";


        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Question added successfully');</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } elseif (isset($_POST['essay_question'])) {
        // Sanitize the data
        $question = sanitize($_POST['essay_question']);

        // File upload handling
        $image = $_FILES['essay_image']['name'];
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["essay_image"]["name"]);
        move_uploaded_file($_FILES["essay_image"]["tmp_name"], $target_file);

        // Insert into the database with the marks included
        $sql = "INSERT INTO exam_question_tbl (ex_id, exam_question, photo, question_type, marks) VALUES ('$exId','$question', '$image', 'essay', '$marks')";
        
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Question added successfully');</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Form not submitted";
    }
}
?>
