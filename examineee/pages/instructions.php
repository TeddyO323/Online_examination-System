<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once('database.php');

$examId = $_GET['exam_id'];
$userRegistrationNumber = $_SESSION['reg_no'];

// Initialize the variables to avoid "undefined variable" notices
$attemptsAllowed = $startDateTime = $endDateTime = $currentDateTime = $attemptsLeft = $numAttemptsMade = '';

// Retrieve the allowed number of attempts, start datetime, and end datetime for the exam
$sqlExam = "SELECT attempts_allowed, exam_start_datetime, exam_end_datetime FROM exam_tbl WHERE ex_id='$examId'";
$resultExam = $conn->query($sqlExam);

if ($resultExam && $resultExam->num_rows > 0) {
    $rowExam = $resultExam->fetch_assoc();
    $attemptsAllowed = $rowExam['attempts_allowed'];
    $startDateTime = $rowExam['exam_start_datetime'];
    $endDateTime = $rowExam['exam_end_datetime'];

    // Check if the current datetime is within the allowed range
    $currentDateTime = (new DateTime(null, new DateTimeZone('GMT+3')))->format('Y-m-d H:i:s');

    // Additional check to determine if the exam is accessible
    $isExamAccessible = ($currentDateTime >= $startDateTime && $currentDateTime <= $endDateTime);

    // Retrieve the number of attempts made by the user for this exam
    $sqlAttempts = "SELECT COUNT(*) as num_attempts FROM exam_attempt WHERE reg_no='$userRegistrationNumber' AND exam_id='$examId'";
    $resultAttempts = $conn->query($sqlAttempts);

    if (!$resultAttempts) {
        echo "Error: " . $sqlAttempts . "<br>" . $conn->error;
    }

    if ($resultAttempts && $resultAttempts->num_rows > 0) {
        $rowAttempts = $resultAttempts->fetch_assoc();
        $numAttemptsMade = $rowAttempts['num_attempts'];

        // Calculate the remaining attempts
        $attemptsLeft = $attemptsAllowed - $numAttemptsMade;
    } else {
        echo '<p>Error retrieving user attempts. Please contact your administrator.</p>';
        // Optionally, exit or redirect here
    }
} else {
    echo '<p>Error retrieving exam information. Please contact your administrator.</p>';
    // Optionally, exit or redirect here
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Instructions</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 16px;
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

        .instructions-section,
        .exam-details-section {
            margin-bottom: 20px;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            text-decoration: none;
            color: #fff;
            background-color: #e48d2a;
            border-radius: 5px;
        }

        .button:hover {
            background-color: #dd7e12;
        }

        .alert {
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            background-color: #f8d7da;
            color: #721c24;
        }
        .message-container {
            color: red; /* Change this to the desired color */
            background-color: #f8d7da;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Exam Instructions</h1>

        <div class="instructions-section">
            <h2>General Instructions:</h2>
            <ul>
                <li>Read all instructions carefully before starting the exam.</li>
                <li>Make sure you have a stable internet connection.</li>
                <li>Do not refresh the page during the exam.</li>
                <!-- Add more general instructions here -->
            </ul>
        </div>

        <div class="exam-details-section">
            <h2>Exam-Specific Instructions:</h2>
            <p>Write your specific instructions here...</p>
            <p>Opening Date and Time: <?php echo $startDateTime; ?></p>
            <p>Closing Date and Time: <?php echo $endDateTime; ?></p>
            
            <?php
            if (isset($attemptsLeft)) {
                echo '<p>You have ' . $attemptsLeft . ' attempts remaining for this exam.</p>';
            }

            // Check if the user has exceeded the allowed attempts
            if (isset($numAttemptsMade) && $numAttemptsMade >= $attemptsAllowed) {
                echo '<div class="alert">
                          <p>You have reached the maximum number of attempts for this exam. Contact your examiner for assistance.</p>
                      </div>';
            } else if ($currentDateTime >= $startDateTime && $currentDateTime <= $endDateTime) {
                // Display the "Start Exam" button only if the exam is accessible
                echo '<button id="startExamButton" onclick="startExam(' . $examId . ', \'' . $currentDateTime . '\', \'' . $startDateTime . '\', \'' . $endDateTime . '\')"';
                echo ' style="padding: 10px 20px;
                             text-decoration: none;
                             color: #fff;
                             background-color: #007bff;
                             border-radius: 5px;
                             cursor: pointer;">Start Exam</button>';
            } else {
                // Display a message if the exam is not accessible
                echo '<p class="alert">Sorry, the exam is not currently accessible. Please check the opening and closing date and time.</p>';
            }
            ?>
        </div>
    </div>
    
    <script>
        function startExam(examId, currentDateTime, startDateTime, endDateTime) {
            var currentTimestamp = Date.parse(currentDateTime);
            var startTimestamp = Date.parse(startDateTime);
            var endTimestamp = Date.parse(endDateTime);

            if (currentTimestamp < startTimestamp || currentTimestamp > endTimestamp) {
                alert('Sorry, the exam is not currently accessible. Please check the opening date and time.');
            } else {
                // Specify the URL of your exam page
                var examUrl = 'pages/exam.php?exam_id=' + examId;

                // Open the exam in a new window with specified features
                window.open(examUrl, '_blank', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes');
            }
        }
    </script>
</body>
</html>