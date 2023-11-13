<?php
session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Exam Marking Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h2 {
            color: #333;
        }

        form {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            margin-right: 10px;
        }

        select {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        input[type="submit"] {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
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
    </style>
</head>

<body>

    <h2>Exam Marking Page for Examiner</h2>

    <?php
// Include the database connection file
include 'database.php';

// Check if the examiner is logged in
if (isset($_SESSION['examiner_number'])) {
    $examiner_number = $_SESSION['examiner_number'];

    // Step 1: Retrieve course names and exam titles for the examiner
    $coursesQuery = "SELECT DISTINCT course_name, exam_title, ex_id FROM exam_tbl WHERE examiner_number = $examiner_number";
    $coursesResult = $conn->query($coursesQuery);

    // Step 2: Display a form for course and exam title selection
    echo '<h1>Exam Marking</h1>';
    echo '<form method="post" action="mark-exam.php">';
    echo '<label for="course">Select Course:</label>';
    echo '<select name="course" id="course">';
    while ($courseRow = $coursesResult->fetch_assoc()) {
        echo "<option value='" . $courseRow['ex_id'] . "'>" . $courseRow['course_name'] . "</option>";
    }
    echo '</select>';

    echo '<label for="exam_title">Select Exam Title:</label>';
    echo '<select name="exam_title" id="exam_title">';
    $coursesResult->data_seek(0); // Reset the result set to the first row
    while ($courseRow = $coursesResult->fetch_assoc()) {
        echo "<option value='" . $courseRow['ex_id'] . "'>" . $courseRow['exam_title'] . "</option>";
    }
    echo '</select>';

    echo '<input type="submit" value="View Exam Attempts">';
    echo '</form>';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $selectedCourse = $conn->real_escape_string($_POST['course']);
        $selectedExamTitle = $conn->real_escape_string($_POST['exam_title']);
    
        if (isset($selectedExamTitle)) {
            // Retrieve exam attempts for the selected course and exam title
            $attemptsQuery = "SELECT exam_attempt.reg_no, examinee_tbl.exmne_fullname, COUNT(exam_attempt.reg_no) as num_attempts 
                            FROM exam_attempt 
                            JOIN examinee_tbl ON exam_attempt.reg_no = examinee_tbl.reg_no
                            WHERE exam_attempt.exam_id = '$selectedExamTitle' 
                            GROUP BY exam_attempt.reg_no";
    
            $attemptsResult = $conn->query($attemptsQuery);
    
            if ($attemptsResult) {
                if ($attemptsResult->num_rows > 0) {
                    echo '<h2>Exam Attempts</h2>';
                    echo '<table>';
                    echo '<tr><th>Examinee Name</th><th>Registration Number</th><th>Number of Attempts</th><th>Status</th></tr>';
    
                    while ($attemptRow = $attemptsResult->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . $attemptRow['exmne_fullname'] . '</td>';
                        echo '<td>' . $attemptRow['reg_no'] . '</td>';
                        echo '<td>' . $attemptRow['num_attempts'] . '</td>';
                        echo '<td><a href="grading-page.php?reg_no=' . $attemptRow['reg_no'] . '&exam_title=' . $selectedExamTitle . '">Grade Exam</a></td>';

                        echo '</tr>';
                    }
    
                    echo '</table>';
                } else {
                    echo '<h2>Exam Attempts</h2>';
                    echo '<p>No attempts found for the selected exam title.</p>';
                }
            } else {
                echo '<p>Error executing the query: ' . $conn->error . '</p>';
            }
        }
    }
}    

?>

</body>

</html>
