<?php
// Check if a session has already been started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include the database connection file
include 'database.php';

// Assuming the logged-in examiner number is stored in a session variable
$loggedInExaminerNumber = isset($_SESSION['examiner_number']) ? $_SESSION['examiner_number'] : null;

// Fetch the list of exams assigned to the logged-in examiner
$examDropdownQuery = "SELECT ex_id, exam_title FROM exam_tbl WHERE examiner_number = $loggedInExaminerNumber";
$examDropdownResult = $conn->query($examDropdownQuery);
?>


<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examinee Results</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        form {
            margin: 20px;
        }

        label {
            font-weight: bold;
            margin-right: 10px;
        }

        select {
            padding: 8px;
            font-size: 16px;
        }

        input[type="submit"] {
            padding: 10px 15px;
            font-size: 16px;
            background-color: #4285f4;
            color: #ffffff;
            border: none;
            cursor: pointer;
        }

        table {
            width: 80%;
            margin: 20px;
            border-collapse: collapse;
        }
        button {
        padding: 10px 20px;
        background-color: #3498db; /* Adjust the background color as needed */
        color: #fff; /* Text color */
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    button:hover {
        background-color: #2980b9; /* Adjust the background color for the hover state */
    }
        th, td {
            border: 1px solid #dddddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #4285f4;
            color: #ffffff;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }
        #examSelect option[disabled] {
        color: #a0a0a0; /* Adjust the color as needed */
    }
    </style>
</head>
<body>
<div class="app-main__outer">
        <div class="app-main__inner">
    <form method="post">
        <label for="examSelect">Select Exam:</label>
        <select name="examSelect" id="examSelect">
        <option value="" disabled selected>Select Exam</option>

            <?php
            while ($examRow = $examDropdownResult->fetch_assoc()) {
                echo '<option value="' . $examRow['ex_id'] . '">' . $examRow['exam_title'] . '</option>';
            }
            ?>
        </select>
        <input type="submit" name="submit" value="Show Results">
    </form>
    <?php
if (isset($_POST['submit'])) {
    $selectedExamId = $_POST['examSelect'];

    // Retrieve the total marks for the selected exam
    $totalMarksQuery = "SELECT SUM(marks) as total_marks FROM exam_question_tbl WHERE ex_id = $selectedExamId";
    $totalMarksResult = $conn->query($totalMarksQuery);
    $totalMarksRow = $totalMarksResult->fetch_assoc();
    $totalMarks = ($totalMarksRow && isset($totalMarksRow['total_marks'])) ? $totalMarksRow['total_marks'] : 0;

    // Fetch the examinee data and calculate percentage
    $selExmneQuery = "
    SELECT
        et.reg_no,
        etl.exam_title,
        et.exmne_fullname,
        FORMAT(SUM(eg.grade) / COUNT(DISTINCT eg.examat_id), 2) AS average_grade,
        FORMAT((SUM(eg.grade) / COUNT(DISTINCT eg.examat_id)) / $totalMarks * 100, 2) AS percentage
    FROM
        exam_grades eg
    INNER JOIN examinee_tbl et ON eg.examinee_id = et.exmne_id 
    INNER JOIN exam_tbl etl ON eg.exam_id = etl.ex_id
    WHERE etl.ex_id = $selectedExamId
    GROUP BY
        et.reg_no, etl.exam_title, et.exmne_fullname
    ORDER BY
        average_grade DESC";


    $selExmne = $conn->query($selExmneQuery);

    if ($selExmne->num_rows > 0) {
        ?>
<table id="examResultsTable">
            <thead>
                <tr>
                    <th>Registration Number</th>
                    <th>Exam Name</th>
                    <th>Fullname</th>
                    <th>Average Scores</th>
                    <th>Percentage</th>
                    <th>Ratings</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php
                while ($selExmneRow = $selExmne->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo $selExmneRow['reg_no']; ?></td>
                        <td><?php echo $selExmneRow['exam_title']; ?></td>
                        <td><?php echo $selExmneRow['exmne_fullname']; ?></td>
                        <td><?php echo $selExmneRow['average_grade']; ?></td>
                        <td><?php echo $selExmneRow['percentage']; ?>%</td>
                        <td><?php echo getRating($selExmneRow['percentage']); ?></td>
                 

                    </tr>
                    <?php
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6">
                        <button onclick="printResults()">Print Results</button>
                    </td>
                </tr>
            </tfoot>
            
        </table>
        <script>
            function printResults() {
                window.print();
            }
        </script>
        <?php
    } else {
        ?>
        <p>No Exam Results Found</p>
        <?php
    }
}

// Function to determine ratings based on average grade
function getRating($averageGrade) {
    // Define rating ranges and corresponding ratings
    $ratings = [
        ['min' => 90, 'rating' => 'A+'],
        ['min' => 80, 'rating' => 'A'],
        ['min' => 70, 'rating' => 'B'],
        ['min' => 60, 'rating' => 'C'],
        ['min' => 50, 'rating' => 'D'],
        ['min' => 0, 'rating' => 'E'],
    ];

    // Iterate through ratings and return the first matching rating
    foreach ($ratings as $rating) {
        if ($averageGrade >= $rating['min']) {
            return $rating['rating'];
        }
    }

    return 'N/A'; // Default if no match is found
}

?>
<!-- Add this where you want the chart to appear -->
<canvas id="gradeChart" width="400" height="200"></canvas>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var table = document.getElementById('examResultsTable');
        var rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

        var grades = {
            'A+': 0,
            'A': 0,
            'B': 0,
            'C': 0,
            'D': 0,
            'E': 0,
           
            // Add more grades as needed
        };

        for (var i = 0; i < rows.length; i++) {
            var rating = rows[i].cells[5].textContent.trim(); // Assuming Ratings is in the 6th column

            // Increment the count for the corresponding grade
            grades[rating]++;
        }

        // Convert the grades data to arrays for Chart.js
        var labels = Object.keys(grades);
        var data = Object.values(grades);

        // Create a bar chart
        var ctx = document.getElementById('gradeChart').getContext('2d');

        var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'Number of Examinees',
            data: data,
            backgroundColor: [
                'rgba(75, 192, 192, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 205, 86, 0.2)',
                // Add more colors as needed
            ],
            borderColor: [
                'rgba(75, 192, 192, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(255, 205, 86, 1)',
                // Add more colors as needed
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                suggestedMin: 1
            }
        }
    }
});


    });
</script>


</body>
</html>
