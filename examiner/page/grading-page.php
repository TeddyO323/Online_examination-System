<!DOCTYPE html>
<html>

<head>
    <title>Exam Grading Page</title>
    <link rel="stylesheet" href="main.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        a {
            display: inline-block;
            padding: 8px 16px;
            text-decoration: none;
            background-color: #4CAF50;
            color: white;
            border-radius: 5px;
        }

        a:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <div class="container">

        <h2>Exam Grading Page</h2>

        <?php
// Include the database connection file
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['reg_no'])) {
    $reg_no = $_GET['reg_no'];

    $exam_title = null; // Initialize exam_title to null

    // Fetch the exam_title for the selected exam
    if (isset($_GET['exam_title'])) {
        $exam_title = $conn->real_escape_string($_GET['exam_title']);
    } else {
        // Handle the case where exam_title is not provided
        echo "Error: Exam title not provided";
        exit;
    }

    // Fetch the answers for the examinee, considering the attempt
    $answersQuery = "SELECT exam_question_tbl.eqt_id, exam_question_tbl.exam_question, exam_question_tbl.exam_answer, exam_answers.exans_answer
        FROM exam_question_tbl
        JOIN exam_answers ON exam_question_tbl.eqt_id = exam_answers.quest_id
        WHERE exam_answers.reg_no = '$reg_no' AND exam_answers.exam_id = '$exam_title'
        ORDER BY exam_answers.examat_id DESC"; // Order by attempt in descending order

    $answersResult = $conn->query($answersQuery);

    if ($answersResult) {
        // Display the questions and answers
        echo '<h2>Exam Answers</h2>';
        echo '<form method="post" action="process-grades.php?exam_title=' . $exam_title . '">';
        echo '<input type="hidden" name="reg_no" value="' . $reg_no . '">';
        echo '<input type="hidden" name="exam_title" value="' . $exam_title . '">';

        echo '<table>';
        echo '<tr><th>Question</th><th>Correct Answer</th><th>Examinee Answer</th><th>Automated Grade</th><th>Marks</th></tr>';
      
        while ($answerRow = $answersResult->fetch_assoc()) {
            $eqt_id = $answerRow['eqt_id']; // Define eqt_id here
        
            // Fetch the marks for the question
            $marks = 0; // Initialize marks to 0
            $marksQuery = "SELECT marks FROM exam_question_tbl WHERE eqt_id = '$eqt_id'";
            $marksResult = $conn->query($marksQuery);
        
            if ($marksResult && $marksResult->num_rows > 0) {
                $marksRow = $marksResult->fetch_assoc();
                $marks = $marksRow['marks'];
        
                // Now you can display the table row
                echo '<tr>';
                echo '<td>' . $answerRow['exam_question'] . '</td>';
                echo '<td>' . $answerRow['exam_answer'] . '</td>';
                echo '<td>' . $answerRow['exans_answer'] . '</td>';
        
                // Automated grading logic with checkboxes
                $isCorrect = ($answerRow['exam_answer'] == $answerRow['exans_answer']);
                $checkboxName = 'question_' . $eqt_id;
        
                echo '<td><input type="checkbox" name="' . $checkboxName . '" value="1" ' . ($isCorrect ? 'checked' : '') . '></td>';
        
                // Display the editable total marks input with JavaScript validation
                echo '<td><input type="number" name="marks_' . $eqt_id . '" value="' . $marks . '" max="' . $marks . '" oninput="validateMarks(this)"></td>';
        
                echo '</tr>';
            } else {
                echo "Error fetching marks for the question: " . $conn->error;
            }
        }
        
        // Add the JavaScript function for validation
        echo '<script>
            function validateMarks(input) {
                if (input.value > input.max) input.value = input.max;
                if (input.value < 0) input.value = 0;
            }
        </script>';
        
        
        echo '</table>';
        echo '<input type="hidden" name="reg_no" value="' . $reg_no . '">';
        echo '<input type="submit" value="Grade Automatically">';
        echo '</form>';
    } else {
        echo "Error executing the query: " . $conn->error;
    }
} else {
    echo "Invalid request. Please provide the registration number.";
}
?>

    </div>
</body>

</html>
