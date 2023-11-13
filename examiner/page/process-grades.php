<?php
include 'database.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reg_no = $_POST['reg_no'];

    $exam_title = $_POST['exam_title']; // Add this line for debugging

    // Debugging statement

    $examiner_number = $_SESSION['examiner_number'];

    // Fetch examiner_id based on examiner_number
    $examinerQuery = "SELECT examiner_id FROM examiner_tbl WHERE examiner_number = '$examiner_number'";
    $examinerResult = $conn->query($examinerQuery);

    if ($examinerResult && $examinerResult->num_rows > 0) {
        $examinerRow = $examinerResult->fetch_assoc();
        $examiner_id = $examinerRow['examiner_id'];
    } else {
        // Handle the case where examiner_id is not found
        echo "Error fetching examiner_id: " . $conn->error;
        exit; // You might want to handle this more gracefully
    }

    // Fetch examinee_id based on reg_no
    $examineeQuery = "SELECT exmne_id FROM examinee_tbl WHERE reg_no = '$reg_no'";
    $examineeResult = $conn->query($examineeQuery);

    if ($examineeResult && $examineeResult->num_rows > 0) {
        $examineeRow = $examineeResult->fetch_assoc();
        $examinee_id = $examineeRow['exmne_id'];
    } else {
        // Handle the case where examinee_id is not found
        echo "Error fetching examinee_id: " . $conn->error;
        exit; // You might want to handle this more gracefully
    }

  

    $totalMarks = 0;

    foreach ($_POST as $key => $value) {
        if (strpos($key, 'question_') === 0) {
            $eqt_id = substr($key, strlen('question_'));
    
            // Fetch the correct answer and marks from the database
            $questionQuery = "SELECT exam_answer, marks FROM exam_question_tbl WHERE eqt_id = '$eqt_id'";
            $questionResult = $conn->query($questionQuery);
    
            if ($questionResult && $questionResult->num_rows > 0) {
                $questionRow = $questionResult->fetch_assoc();
    
                // Fetch the given answer from the exam_answers table
                $givenAnswerQuery = "SELECT exans_answer FROM exam_answers WHERE quest_id = '$eqt_id' AND reg_no = '$reg_no'";
                $givenAnswerResult = $conn->query($givenAnswerQuery);
    
                if ($givenAnswerResult && $givenAnswerResult->num_rows > 0) {
                    $givenAnswerRow = $givenAnswerResult->fetch_assoc();
                    $givenAnswer = $givenAnswerRow['exans_answer'];
    
                    // Compare the given answer with the correct answer
                    $isCorrect = ($givenAnswer == $questionRow['exam_answer']);
    
                    if ($isCorrect) {
                        $totalMarks += $questionRow['marks'];
                    }
    
                    // Insert the grading information into the exam_grades table
                    $insertQuery = "INSERT INTO exam_grades (examiner_id, examinee_id, exam_id, question_id, given_answer, correct_answer, grade)
                                    VALUES ('$examiner_id', '$examinee_id', '$exam_title', '$eqt_id', '$givenAnswer', '{$questionRow['exam_answer']}', " . ($isCorrect ? $questionRow['marks'] : '0') . ")";
                    $conn->query($insertQuery);
                } else {
                    echo "Error fetching given answer details: " . $conn->error;
                }
            } else {
                echo "Error fetching question details: " . $conn->error;
            }
        }
    }
    
    // Update the total marks in the exam_grades table
    $totalMarksQuery = "UPDATE exam_grades SET total_marks = '$totalMarks' WHERE reg_no = '$reg_no'";
    $conn->query($totalMarksQuery);
    
    echo "Grading completed successfully!";
    
    
} else {
    echo "Invalid request. Form not submitted.";
}
?>
