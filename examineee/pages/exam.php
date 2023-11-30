<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once('database.php');

$examId = $_GET['exam_id'];
$userRegistrationNumber = $_SESSION['reg_no'];

// Fetch exam_time_limit and max_leave_attempts from the database
$sqlExamDetails = "SELECT exam_time_limit, max_leave_attempts FROM exam_tbl WHERE ex_id='$examId'";
$resultExamDetails = $conn->query($sqlExamDetails);

if ($resultExamDetails && $resultExamDetails->num_rows > 0) {
    $rowExamDetails = $resultExamDetails->fetch_assoc();
    $examTimeLimitInMinutes = $rowExamDetails['exam_time_limit'];
    $maxLeaveAttempts = $rowExamDetails['max_leave_attempts'];
} else {
    echo '<p>Error retrieving exam details. Please contact your administrator.</p>';
    // Optionally, exit or redirect here
}

// Fetch questions from the database
$sqlQuestions = "SELECT * FROM exam_question_tbl WHERE ex_id='$examId'";
$resultQuestions = $conn->query($sqlQuestions);

if (!$resultQuestions) {
    echo "Error: " . $sqlQuestions . "<br>" . $conn->error;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam</title>
    <link rel="stylesheet" href="main.css">
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>



    <style>
       
  
        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }



        body {
          
            line-height: 1.6;
            letter-spacing: 0.5px;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .exam-header {
    background-color: #007bff;
    color: #fff;
    padding: 20px;
    text-align: center;
}

.exam-header h1 {
    margin: 0;
    font-size: 24px;
}

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        img {
            max-width: 100%;
            height: auto;
            margin-bottom: 10px;
        }

     
        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        hr {
            border: 1px solid #ddd;
            margin: 20px 0;
        }
        #timer {
            position: fixed;
            top: 10px; /* Adjust the top distance as needed */
            right: 10px; /* Adjust the right distance as needed */
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            border-radius: 5px;
            font-size: 16px;
            z-index: 1000; /* Adjust the z-index as needed */
        }
    </style>
</head>
<body>
    
<div class="app-main__outer">
    <div class="app-main__inner">
        <header class="exam-header">
            <?php
            // Fetch exam title from the database
            $sqlExamTitle = "SELECT exam_title FROM exam_tbl WHERE ex_id='$examId'";
            $resultExamTitle = $conn->query($sqlExamTitle);

            if ($resultExamTitle && $resultExamTitle->num_rows > 0) {
                $rowExamTitle = $resultExamTitle->fetch_assoc();
                $examTitle = $rowExamTitle['exam_title'];
                echo '<h1>' . $examTitle . '</h1>';
            } else {
                echo '<p>Error retrieving exam title. Please contact your administrator.</p>';
                // Optionally, exit or redirect here
            }
            ?>
        </header>
            <form id="examForm" action="submit-questions.php?exam_id=<?php echo $examId; ?>" method="post">
                <div id="timer"></div>
                <!-- Rest of your form content -->


            <?php
            
            
            while ($rowQuestion = $resultQuestions->fetch_assoc()) {
                $questionType = $rowQuestion['question_type'];
                $questionId = $rowQuestion['eqt_id'];

                echo '<label for="question_' . $questionId . '">' . $rowQuestion['exam_question'] . '</label>';
                echo '<p' . $questionId . '">' . $rowQuestion['marks'] . ' marks'. '</p>';
               // Display the photo if available
    if ($rowQuestion['photo'] !== '') {
        echo '<img src="/exam/adminpanel/page/uploads/' . $rowQuestion['photo'] . '" alt="Question Photo" style="max-width: 300px; max-height: 300px;">';
    }
                

// Inside your while loop where questions are rendered
switch ($questionType) {
    case 'essay':
        echo '<textarea name="answer_' . $questionId . '" id="question_' . $questionId . '" rows="4" cols="50"></textarea>';
        echo '<script>
                tinymce.init({
                    selector: "#question_' . $questionId . '",
                    height: 300,
                    plugins: "autoresize",
                    autoresize_bottom_margin: 16,
                });
              </script>';
        break;
    case 'single_choice':
        // Single-choice (radio button)
        echo '<label><input type="radio" name="answer_' . $questionId . '" value="' . $rowQuestion['exam_ch1'] . '"> ' . $rowQuestion['exam_ch1'] . '</label>';
        echo '<label><input type="radio" name="answer_' . $questionId . '" value="' . $rowQuestion['exam_ch2'] . '"> ' . $rowQuestion['exam_ch2'] . '</label>';
        echo '<label><input type="radio" name="answer_' . $questionId . '" value="' . $rowQuestion['exam_ch3'] . '"> ' . $rowQuestion['exam_ch3'] . '</label>';
        echo '<label><input type="radio" name="answer_' . $questionId . '" value="' . $rowQuestion['exam_ch4'] . '"> ' . $rowQuestion['exam_ch4'] . '</label>';
        break;

    case 'multiple_choice':
        // Multiple-choice (checkbox)
        echo '<label><input type="checkbox" name="answer_' . $questionId . '[]" value="' . $rowQuestion['exam_ch1'] . '"> ' . $rowQuestion['exam_ch1'] . '</label>';
        echo '<label><input type="checkbox" name="answer_' . $questionId . '[]" value="' . $rowQuestion['exam_ch2'] . '"> ' . $rowQuestion['exam_ch2'] . '</label>';
        echo '<label><input type="checkbox" name="answer_' . $questionId . '[]" value="' . $rowQuestion['exam_ch3'] . '"> ' . $rowQuestion['exam_ch3'] . '</label>';
        echo '<label><input type="checkbox" name="answer_' . $questionId . '[]" value="' . $rowQuestion['exam_ch4'] . '"> ' . $rowQuestion['exam_ch4'] . '</label>';
        break;

    // Add additional cases for other question types if needed

    default:
        // Handle unsupported question types
        echo '<p>Unsupported question type: ' . $questionType . '</p>';
        break;
}

                echo '<hr>';
            }
            ?>
            <button type="submit">Submit Exam</button>
        </form>
        <script>
    document.addEventListener('DOMContentLoaded', function () {
        var timerElement = document.getElementById('timer');
        var timeRemaining;

        // Check if the initial time and original time limit are stored in localStorage for the current user and exam
        var userStartTimeKey = 'examStartTime_<?php echo $userRegistrationNumber; ?>_exam<?php echo $examId; ?>';
        var userOriginalTimeLimitKey = 'examOriginalTimeLimit_<?php echo $userRegistrationNumber; ?>_exam<?php echo $examId; ?>';

        var storedStartTime = localStorage.getItem(userStartTimeKey);
        var storedOriginalTimeLimit = localStorage.getItem(userOriginalTimeLimitKey);

        if (storedStartTime && storedOriginalTimeLimit) {
            // Calculate the remaining time based on the stored initial time and original time limit
            var currentTime = new Date().getTime();
            var elapsedTime = currentTime - parseInt(storedStartTime);
            timeRemaining = Math.max(parseInt(storedOriginalTimeLimit) - Math.floor(elapsedTime / 1000), 0);

            // If the time is already up, reset the timer
            if (timeRemaining === 0) {
                resetTimer();
            }
        } else {
            // If no initial time or original time limit is stored, set the initial time and calculate remaining time
            localStorage.setItem(userStartTimeKey, new Date().getTime());
            localStorage.setItem(userOriginalTimeLimitKey, <?php echo $examTimeLimitInMinutes * 60; ?>);
            timeRemaining = <?php echo $examTimeLimitInMinutes * 60; ?>;
        }

        function updateTimer() {
            var minutes = Math.floor(timeRemaining / 60);
            var seconds = timeRemaining % 60;

            // Display the timer in the 'timer' div
            timerElement.innerHTML = 'Time Remaining: ' + minutes + ' minutes ' + seconds + ' seconds';

            if (timeRemaining > 0) {
                timeRemaining--;
            } else {
                // If the time is up, show an alert and submit the form
                alert('Time is up! Your answers will be submitted automatically.');
                // document.getElementById('examForm').submit();
                // Reset the timer
                resetTimer();
            }
        }

        function resetTimer() {
            timeRemaining = <?php echo $examTimeLimitInMinutes * 60; ?>;
            localStorage.setItem(userStartTimeKey, new Date().getTime());
            localStorage.setItem(userOriginalTimeLimitKey, <?php echo $examTimeLimitInMinutes * 60; ?>);
        }

        // Update the timer every second
        var timerInterval = setInterval(updateTimer, 1000);

        // Clear localStorage when the form is manually submitted or when the exam ends
        document.getElementById('examForm').addEventListener('submit', function () {
            clearInterval(timerInterval);
            localStorage.removeItem(userStartTimeKey);
            localStorage.removeItem(userOriginalTimeLimitKey);
        });
    });
</script>



    </div>
    
<script>
    var leaveCount = 0;
    var maxLeaveAttempts = <?php echo $maxLeaveAttempts; ?>;

    function handleVisibilityChange() {
        if (document.hidden) {
            if (leaveCount < maxLeaveAttempts) {
                alert('Warning: Leaving the exam page is not allowed. You have ' + (maxLeaveAttempts - leaveCount) + ' more attempts.');
                leaveCount++;
            } else {
                alert('You have exceeded the allowed number of tab switches.');
                // Submit the form here
                // document.getElementById('examForm').submit();
            }
        }
    }

    document.addEventListener('visibilitychange', handleVisibilityChange);
</script>


 </body>
</html>