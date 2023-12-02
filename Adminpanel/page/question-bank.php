<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Question Bank</title>
    <style>
        /* Your existing styles here */

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-select {
            appearance: none;
            outline: none;
            padding: 10px 20px;
            font-size: 16px;
            border: 2px solid #ddd;
            border-radius: 5px;
            background-color: #fff;
            color: #333;
            cursor: pointer;
        }

        .dropdown-options {
            display: none;
            position: absolute;
            background-color: #fff;
            min-width: 160px;
            overflow: auto;
            border: 2px solid #ddd;
            border-radius: 5px;
            z-index: 1;
        }

        .dropdown-options button {
            display: block;
            width: 100%;
            text-align: left;
            padding: 10px 20px;
            border: none;
            background-color: transparent;
            color: #333;
            cursor: pointer;
        }

        .dropdown-options button:hover {
            background-color: #f9f9f9;
        }

        .select-exam-button {
            padding: 10px 20px;
            font-size: 16px;
            border: 2px solid #4ef037;
            border-radius: 5px;
            background-color: #4ef037;
            color: #fff;
            cursor: pointer;
        }

        .select-exam-button:hover {
            background-color: #45a049;
        }
        .card {
            margin-top: 40px;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .question {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }

        .options {
            font-size: 16px;
            color: #666;
        }

        .answer {
            color: green;
        }
        .scrollarea {
        max-height: 400px;
        overflow-y: scroll;
        border: 1px solid #e6e6e6;
        border-radius: 5px;
        padding: 10px;
    }
    </style>
</head>

<body>
<div class="app-main__outer">
    <div class="app-main__inner">
    <h1>Question Bank</h1>

    <form method="post" action="index.php?page=question-bank">
        <div class="dropdown">
            <select class="dropdown-select" id="exam_id" name="exam_id">
            <option value="" selected disabled hidden>Select Exam Title</option>

                <?php
                // Fetch exams from exam_tbl
                $examQuery = "SELECT * FROM exam_tbl";
                $result = $conn->query($examQuery);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['ex_id'] . "'>" . $row['exam_title'] . "</option>";
                    }
                } else {
                    echo "No exams found.";
                }
                ?>
            </select>
            <div class="dropdown-options">
                <?php
                if ($result->num_rows > 0) {
                    mysqli_data_seek($result, 0);
                    while ($row = $result->fetch_assoc()) {
                        echo "<button value='" . $row['ex_id'] . "'>" . $row['exam_title'] . "</button>";
                    }
                } else {
                    echo "No exams found.";
                }
                ?>
            </div>
        </div>
        <button class="select-exam-button" type="submit">Select Exam</button>
    </form>
 

        <div class="scrollarea" style="min-height: 400px;">
            <div class="scrollbar-container">
                <div class="table-responsive">
                <?php
// Include the database connection file
include 'database.php';

// Initialize total marks variable
$totalMarks = 0;

// Check if the exam ID is set
if (isset($_POST['exam_id'])) {
    $exId = $_POST['exam_id'];

    // Fetch the questions for the selected exam
    $questionQuery = "SELECT * FROM exam_question_tbl WHERE ex_id = $exId";
    $result = $conn->query($questionQuery);

    if ($result->num_rows > 0) {
        // Iterate through each question to sum up the marks
        while ($row = $result->fetch_assoc()) {
            // Add the marks for each question to the total marks
            $totalMarks += $row['marks'];
        }
    } else {
        echo "No questions found for the selected exam.";
    }
}
?>
<?php
// Check if the exam_id is set and fetch the exam title
if (isset($_POST['exam_id'])) {
    $selectedExamId = $_POST['exam_id'];
    $examTitleQuery = "SELECT exam_title FROM exam_tbl WHERE ex_id = $selectedExamId";
    $examTitleResult = $conn->query($examTitleQuery);
    $examTitle = "";

    if ($examTitleResult->num_rows > 0) {
        $row = $examTitleResult->fetch_assoc();
        $examTitle = $row['exam_title'];
    } else {
        $examTitle = "Unknown";
    }
    echo "<h2>Questions for $examTitle</h2>";
    echo "<h3>Total Marks: $totalMarks</h3>";}
?>

<div class="main-card mb-3 car">
    <div class="card-header">
        <i class="header-icon lnr-license icon-gradient bg-plum-plate"> </i>Exam Question's
        <span class="badge badge-pill badge-primary ml-2"></span>
        <div class="btn-actions-pane-right"></div>
    </div>
    <div class="">
        <div class="scrollarea" style="min-height: 400px;">
            <div class="scrollbar-container">
                <div class="table-responsive">
                    <?php
                    include 'database.php';

                    // Fetch questions for the selected exam
                    if (isset($_POST['exam_id'])) {
                        $exId = $_POST['exam_id'];

                        $questionQuery = "SELECT * FROM exam_question_tbl WHERE ex_id = $exId";
                        $result = $conn->query($questionQuery);
                        $count = 1;

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<div class="row">';
                                echo '<div class="col-10 question">' . $count . '. ' . $row['exam_question'] . '</div>';
                                // Display marks for the question
                                echo '<div class="col-2">';
                                echo '<p> ' . $row['marks'] . ' Marks</p>';
                                echo '<button onclick="editQuestion(' . $row['eqt_id'] . ')" class="btn btn-primary">Edit</button>';
                                echo '<button onclick="deleteQuestion(' . $row['eqt_id'] . ')" class="btn btn-danger">Delete</button>';
                                echo '</div>';
                                echo '</div>';

                                // Display image for essay questions
                                if ($row['question_type'] === 'essay' && !empty($row['photo'])) {
                                    echo "<div class='row'><img src='page/uploads/" . $row['photo'] . "' alt='Question Image' style='max-width: 300px; max-height: 300px; margin-left: 20px;' /></div>";
                                }

                                // Display options for multiple-choice questions
                                if ($row['question_type'] !== 'essay') {
                                    if (!empty($row['photo'])) {
                                        echo "<div class='row'><img src='page/uploads/" . $row['photo'] . "' alt='Question Image' style='max-width: 300px; max-height: 300px; margin-left: 20px;' /></div>";
                                    }
                                    echo "<div class='options'>";
                                    echo "<p>A. " . $row['exam_ch1'] . "</p>";
                                    echo "<p>B. " . $row['exam_ch2'] . "</p>";
                                    echo "<p>C. " . $row['exam_ch3'] . "</p>";
                                    echo "<p>D. " . $row['exam_ch4'] . "</p>";
                                    echo "<p class='answer'>Answer: " . $row['exam_answer'] . "</p>";
                                    echo '</div>';
                                }

                                echo '<hr>'; // Adding a horizontal line for separation
                                $count++;
                            }
                        } else {
                            echo "No questions found for the selected exam.";
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<form method="post" action="page/export-questions.php">
    <input type="hidden" name="exam_id" value="<?php echo $exId; ?>">
    <button type="submit" class="btn btn-success">Export Questions</button>
</form>

    </div>
</div>

<script>
    function deleteQuestion(questionId) {
        if (confirm("Are you sure you want to delete this question?")) {
            // Make an AJAX request to delete the question
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "page/delete-question.php", true); // Replace delete-question.php with the appropriate file name
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // Optionally, you can handle the response from the server here
                        alert(xhr.responseText); // Display the response message
                        // Reload the page or perform other actions
                        location.reload();
                    } else {
                        alert("Error occurred while deleting the question. Please try again.");
                    }
                }
            };
            xhr.send("eqt_id=" + questionId); // Replace question_id with the appropriate parameter name
        }
    }
</script>

</body>

</html>
