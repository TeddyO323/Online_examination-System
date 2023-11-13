<?php
    // Include the necessary files and establish the database connection
    include("database.php");

    // Fetch exams for the particular examiner
    $examinerId = "ex_id"; // Use the examiner's id from the session or query string
    $examsQuery = $conn->query("SELECT * FROM exam_tbl WHERE examiner_id = '$examinerId'");

    // Handling the form submission to schedule the exam
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['selected_exam'])) {
        $selectedExamId = $_POST['selected_exam'];
        $examDate = $_POST['exam_date'];
        $examTime = $_POST['exam_time'];
        $examDuration = $_POST['exam_duration'];

        // Code to schedule the exam goes here
        // Implement the necessary logic to save the scheduling details into the database

        // For example:
        $insertQuery = "INSERT INTO exam_schedule (examiner_id, exam_id, exam_date, exam_time, exam_duration) VALUES ('$examinerId', '$selectedExamId', '$examDate', '$examTime', '$examDuration')";
         $conn->query($insertQuery);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Scheduling</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .app-main__outer {
            margin: 50px;
        }
        .app-page-title {
            text-align: center;
            margin-bottom: 30px;
        }
        form {
            display: flex;
            flex-direction: column;
            width: 300px;
            margin: auto;
        }
        select, input {
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="app-page-title">
                <h2>Exam Scheduling</h2>
            </div>
            <div class="exam-selection">
                <form method="post">
                    <label for="selected_exam">Select an Exam:</label>
                    <select name="selected_exam">
                        <?php 
                            while ($row = $examsQuery->fetch_assoc()) {
                                echo "<option value='" . $row['exam_id'] . "'>" . $row['exam_title'] . "</option>";
                            }
                        ?>
                    </select>
                    <label for="exam_date">Exam Date:</label>
                    <input type="date" name="exam_date">
                    <label for="exam_time">Exam Time:</label>
                    <input type="time" name="exam_time">
                    <label for="exam_duration">Exam Duration (in minutes):</label>
                    <input type="number" name="exam_duration">
                    <input type="submit" value="Schedule Exam">
                </form>
            </div>
        </div>
    </div>
</body>
</html>
