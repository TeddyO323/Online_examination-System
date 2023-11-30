<!DOCTYPE html>
<html>

<head>
<link rel="stylesheet" href="main.css">

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
        #examAttemptsDropdown {
        padding: 10px;
        font-size: 16px;
    }

    #examAttemptDetailsContainer {
        margin-top: 20px;
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

// Fetch the attempts for the examinee
$attemptsQuery = "SELECT examat_id FROM exam_attempt WHERE reg_no = '$reg_no'";
$attemptsResult = $conn->query($attemptsQuery);

if ($attemptsResult) {
    // Display the attempts in a dropdown menu
    echo '<h2>Select Exam Attempt:</h2>';
    echo '<select id="examAttemptsDropdown">';
    echo '<option value="" disabled selected>Select Exam Attempt</option>'; // Placeholder

    while ($attemptRow = $attemptsResult->fetch_assoc()) {
        $exam_attempt_id = $attemptRow['examat_id'];
        echo '<option value="' . $exam_attempt_id . '">Attempt ' . $exam_attempt_id . '</option>';
    }
    echo '</select>';

    // Container to display questions, choices, correct answers, and examinee answers
    echo '<div id="examAttemptDetailsContainer"></div>';

    // JavaScript to handle the dropdown change event and fetch details
    echo '<script>
            document.getElementById("examAttemptsDropdown").addEventListener("change", function() {
                var selectedAttempt = this.value;
                var detailsContainer = document.getElementById("examAttemptDetailsContainer");

                // Fetch and display details for the selected attempt
                fetch("get-attempt-details.php?reg_no=' . $reg_no . '&examat_id=" + selectedAttempt)
                    .then(response => response.text())
                    .then(data => detailsContainer.innerHTML = data);
            });
        </script>';
} else {
    echo "Error executing the attempts query: " . $conn->error;
}


    if ($attemptsResult) {
        // Display the attempts and related information
        echo '<h2>Examinee Attempts</h2>';
        echo '<ul>';
        while ($attemptRow = $attemptsResult->fetch_assoc()) {
            $exam_attempt_id = $attemptRow['examat_id'];

            echo '<li><a href="grading-page.php?reg_no=' . $reg_no . '&examat_id=' . $exam_attempt_id . '">Attempt ' . $exam_attempt_id . '</a></li>';
        }
        echo '</ul>';
    } else {
        echo "Error executing the attempts query: " . $conn->error;
    }
} else {
    echo "Invalid request. Please provide the registration number.";
}


?>


    </div>
</body>

</html>
