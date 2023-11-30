<?php
session_start();
require_once('database.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the examiner is logged in
    if (isset($_SESSION['examiner_number']) && isset($_POST['reg_no']) && isset($_POST['exam_attempt_id'])) {
        $examiner_id = $_SESSION['examiner_number']; // Get the logged-in examiner's ID
        $exam_attempt_id = $_POST['exam_attempt_id'];


        // Retrieve exam_id based on exam_attempt_id
        $exam_id_query = "SELECT exam_id FROM exam_attempt WHERE examat_id = $exam_attempt_id";
        $exam_id_result = $conn->query($exam_id_query);

        if ($exam_id_result && $exam_id_result->num_rows > 0) {
            $exam_row = $exam_id_result->fetch_assoc();
            $exam_id = $exam_row['exam_id'];

            // Retrieve examinee_id based on reg_no
            $examinee_id_query = "SELECT exmne_id FROM examinee_tbl WHERE reg_no = '" . $_POST['reg_no'] . "'";
            $examinee_id_result = $conn->query($examinee_id_query);

            if ($examinee_id_result && $examinee_id_result->num_rows > 0) {
                $examinee_row = $examinee_id_result->fetch_assoc();
                $examinee_id = $examinee_row['exmne_id'];

                // Process essay questions
                if (isset($_POST['essay_marks'])) {
                    foreach ($_POST['essay_marks'] as $question_id => $marks) {
                        // Ensure marks are within the valid range (0 to max_marks from exam_question_tbl)
                        $max_marks_query = "SELECT marks FROM exam_question_tbl WHERE eqt_id = '$question_id'";
                        $max_marks_result = $conn->query($max_marks_query);

                        if ($max_marks_result && $max_marks_result->num_rows > 0) {
                            $max_marks = $max_marks_result->fetch_assoc()['marks'];

                            // Ensure marks are within the valid range
                            $marks = max(0, min($marks, $max_marks));

                            // Insert or update the grade for the essay question
                            $grade_query = "INSERT INTO exam_grades (examiner_id, examinee_id, exam_id, question_id, grade, examat_id)
                                            VALUES ('$examiner_id', '$examinee_id', '$exam_id', '$question_id', '$marks', '$exam_attempt_id')
                                            ON DUPLICATE KEY UPDATE grade = '$marks'";

                            $conn->query($grade_query);
                            if ($conn->error) {
                                echo "Error executing query: " . $conn->error;
                            }
                        } else {
                            // Handle the case where max_marks retrieval fails
                            echo "Error fetching max marks for question $question_id";
                            continue;
                        }
                    }
                }

                // Inside the loop where you process multiple-choice questions
// Fetch examinee's selected answer from exam_answers
$examineeAnswerQuery = "SELECT exans_answer FROM exam_answers WHERE reg_no = '$examinee_id' AND quest_id = '$question_id' AND examat_id = $exam_attempt_id ORDER BY exans_id DESC LIMIT 1";
$examineeAnswerResult = $conn->query($examineeAnswerQuery);
$examineeAnswer = ($examineeAnswerResult && $examineeAnswerResult->num_rows > 0) ? $examineeAnswerResult->fetch_assoc()['exans_answer'] : '';
var_dump($examineeAnswer);



// Process other question types (multiple-choice) here
if (isset($_POST['other_marks'])) {
    foreach ($_POST['other_marks'] as $question_id => $marks) {
        // Fetch examinee's selected answer from exam_answers
        $examineeAnswerQuery = "SELECT exans_answer FROM exam_answers WHERE reg_no = '$examinee_id' AND quest_id = '$question_id' AND examat_id = $exam_attempt_id ORDER BY exans_id DESC LIMIT 1";
        $examineeAnswerResult = $conn->query($examineeAnswerQuery);
        $examineeAnswer = ($examineeAnswerResult && $examineeAnswerResult->num_rows > 0) ? $examineeAnswerResult->fetch_assoc()['exans_answer'] : '';

        // Fetch correct answer from exam_question_tbl
        $correctAnswerQuery = "SELECT exam_answer FROM exam_question_tbl WHERE eqt_id = '$question_id'";
        $correctAnswerResult = $conn->query($correctAnswerQuery);
        $correctAnswer = ($correctAnswerResult && $correctAnswerResult->num_rows > 0) ? $correctAnswerResult->fetch_assoc()['exam_answer'] : '';

        // Insert or update the grade for the multiple-choice question
        $grade_query = "INSERT INTO exam_grades (examiner_id, examinee_id, exam_id, question_id, given_answer, correct_answer, grade, examat_id)
                        VALUES ('$examiner_id', '$examinee_id', '$exam_id', '$question_id', '$examineeAnswer', '$correctAnswer', '$marks' ,'$exam_attempt_id')
                        ON DUPLICATE KEY UPDATE given_answer = '$examineeAnswer', correct_answer = '$correctAnswer', grade = '$marks'";

        $conn->query($grade_query);
        if ($conn->error) {
            echo "Error executing query: " . $conn->error;
        }
    }
}


                echo "Grading completed successfully!";
            } else {
                // Handle the case where examinee_id is not found
                echo "Error: No matching examinee found for reg_no '" . $_POST['reg_no'] . "'";
            }
        } else {
            // Handle the case where exam_id is not found
            echo "Error: No matching exam found for exam_attempt_id '$exam_attempt_id'";
        }
    } else {
        echo "User not logged in";
    }

    $conn->close();
} else {
    echo "Invalid request. Please provide the exam ID.";
}
?>
