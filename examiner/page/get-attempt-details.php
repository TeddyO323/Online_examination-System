
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Attempt Details</title>
    <!-- Add your styles or external stylesheets here -->
</head>
<body>

<?php
// Include the database connection file
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['reg_no']) && isset($_GET['examat_id'])) {
    $reg_no = $_GET['reg_no'];
    $exam_attempt_id = $_GET['examat_id'];
    

    // Fetch details from exam_question_tbl
    $questionsQuery = "SELECT eqt_id, exam_question, exam_ch1, exam_ch2, exam_ch3, exam_ch4, exam_answer, marks, question_type
                      FROM exam_question_tbl
                      WHERE ex_id = (SELECT exam_id FROM exam_attempt WHERE reg_no = '$reg_no' AND examat_id = $exam_attempt_id)";
    $questionsResult = $conn->query($questionsQuery);

    if ($questionsResult) {
        // Display questions and details
        echo '<style>';
        echo '.question-container { margin: 10px; padding: 10px; }';
        echo '.correct-answer { color: green; }';
        echo '.incorrect-answer { color: red; }';
        echo '</style>';
        echo '<script>';
        echo 'function validateForm() {';
        echo '    var elements = document.getElementsByName("essay_marks[]");';
        echo '    for (var i = 0; i < elements.length; i++) {';
        echo '        var maxMarks = elements[i].max;';
        echo '        var enteredMarks = elements[i].value;';
        echo '        if (enteredMarks > maxMarks) {';
        echo '            alert("Value must be less than or equal to " + maxMarks);';
        echo '            return false;';
        echo '        }';
        echo '    }';
        echo '    return true;';
        echo '}';
        echo '</script>';
        echo '<h2>Exam Questions</h2>';
        $questionNumber = 1; // Initialize question number
    
        echo '<form method="post" action="process-grades.php" onsubmit="return validateForm();">';
        echo '<input type="hidden" name="reg_no" value="' . $reg_no . '">';
        echo '<input type="hidden" name="exam_attempt_id" value="' . $exam_attempt_id . '">';
        
        while ($questionRow = $questionsResult->fetch_assoc()) {
            // Fetch examinee answer from exam_answers
            $examineeAnswerQuery = "SELECT exans_answer FROM exam_answers WHERE reg_no = '$reg_no' AND quest_id = '{$questionRow['eqt_id']}' AND examat_id = $exam_attempt_id ORDER BY exans_id DESC LIMIT 1";
            $examineeAnswerResult = $conn->query($examineeAnswerQuery);
    
            $examineeAnswer = ($examineeAnswerResult && $examineeAnswerResult->num_rows > 0) ? $examineeAnswerResult->fetch_assoc()['exans_answer'] : 'N/A';
    
            // Determine if the answer is correct
            $isCorrect = ($examineeAnswer == $questionRow['exam_answer']);
    
            // Calculate marks
            $marks = ($isCorrect && $questionRow['question_type'] != 'essay') ? $questionRow['marks'] : 0;
    
            // Display question details with styles
            echo '<div class="question-container" style="';
            // Change background color only for non-essay questions
            if ($questionRow['question_type'] != 'essay') {
                echo 'background-color: ' . ($isCorrect ? '#c8e6c9' : '#f8d7da') . ';';
            }
            echo '">';
            echo '<p>' . $questionNumber . '. ' . $questionRow['exam_question'] . '</p>';
            echo 'Marks: ' . $marks . '/' . $questionRow['marks'] . '<br>';

            
            if ($questionRow['question_type'] != 'essay') {
                // Display choices as letters for non-essay questions
                $choices = range('A', 'D');
                foreach ($choices as $index => $choice) {
                    $choiceClass = ($isCorrect && $examineeAnswer == $questionRow['exam_ch' . ($index + 1)]) ? 'correct-answer' : 'incorrect-answer';
                    echo '<span class="' . $choiceClass . '">' . $choice . '. ' . $questionRow['exam_ch' . ($index + 1)] . '</span><br>';
                }
            }
    
            if ($questionRow['question_type'] == 'essay') {
                // For essay questions, display editable input for marks
                if ($examineeAnswer == 'N/A') {
                    echo 'Marks: <span class="not-answered">Not Answered</span><br>';
                } else {
                    echo 'Marks: <input type="number" name="essay_marks[' . $questionRow['eqt_id'] . ']" min="0" max="' . $questionRow['marks'] . '" value="' . $marks . '"/><br>';
                }
            } else// For other question types, display marks
            echo 'Correct Answer: <span class="correct-answer">' . $questionRow['exam_answer'] . '</span><br>';
            if ($questionRow['question_type'] != 'essay') {
                // If it's not an essay question, calculate and display marks
                
                $marks = ($isCorrect) ? $questionRow['marks'] : 0;
                echo '<input type="hidden" name="other_marks[' . $questionRow['eqt_id'] . ']" value="' . $marks . '">';                
            }
            
    
            echo 'Examinee Answer: <span class="' . ($isCorrect ? 'correct-answer' : 'incorrect-answer') . '">' . ($examineeAnswer == 'N/A' ? 'Not Answered' : $examineeAnswer) . '</span><br>';
            echo '</div>';
    
            $questionNumber++; // Increment question number for the next iteration
        }
    
        
        // Add submit button
        echo '<input type="submit" value="Grade Exam">';
        echo '</form>';
    } else {
        echo "Error executing questions query: " . $conn->error;
    }
     
} else {
  
}

// Close the database connection
$conn->close();
?>

</body>
</html>

