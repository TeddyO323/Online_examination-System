
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Completed Exams</title>
        <!-- Add your stylesheets, scripts, and other head elements here -->
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
        
    <?php
// Include the database connection file
include 'database.php';

// Assume $_SESSION['reg_no'] contains the registration number of the logged-in examinee
$reg_no = $_SESSION['reg_no'];

// Fetch completed exams for the logged-in examinee
$completedExamsQuery = "SELECT DISTINCT etl.ex_id, etl.exam_title
                        FROM exam_attempt ea
                        INNER JOIN exam_tbl etl ON ea.exam_id = etl.ex_id
                        WHERE ea.reg_no = '$reg_no'";

$completedExamsResult = $conn->query($completedExamsQuery);

// Check if the query execution was successful
if ($completedExamsResult) {
    ?>

<div class="app-main__outer">
    <div class="app-main__inner">
        <div id="refreshData">
            <div class="col-md-12">
                <h1 class="text-primary">EXAM RESULTS</h1>
                    <?php
                    // Check if there are completed exams to display
                    if ($completedExamsResult->num_rows > 0) {
                        ?>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>EXAM NAME</th>
                                    <th>GRADE</th>
                                    <th>RANK</th>

                                    <th>PERCENTAGE</th>
                                    <th>STATUS</th>
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Display completed exams
                                while ($examRow = $completedExamsResult->fetch_assoc()) {
                                    $examId = $examRow['ex_id'];
                                    $examTitle = $examRow['exam_title'];

                                    // Retrieve the total marks for the selected exam
                                    $totalMarksQuery = "SELECT SUM(marks) as total_marks FROM exam_question_tbl WHERE ex_id = $examId";
                                    $totalMarksResult = $conn->query($totalMarksQuery);
                                    $totalMarksRow = $totalMarksResult->fetch_assoc();
                                    $totalMarks = ($totalMarksRow && isset($totalMarksRow['total_marks'])) ? $totalMarksRow['total_marks'] : 0;

                                    // Calculate average grade and percentage for the exam
                                    $averageGradeQuery = "
                                    SELECT
                                        FORMAT(SUM(eg.grade) / COUNT(DISTINCT eg.examat_id), 2) AS average_grade,
                                        FORMAT((SUM(eg.grade) / COUNT(DISTINCT eg.examat_id)) / $totalMarks * 100, 2) AS percentage
                                    FROM
                                        exam_grades eg
                                    INNER JOIN examinee_tbl et ON eg.examinee_id = et.exmne_id 
                                    INNER JOIN exam_tbl etl ON eg.exam_id = etl.ex_id
                                    INNER JOIN exam_question_tbl eq ON eg.question_id = eq.eqt_id
                                    WHERE
                                        et.reg_no = '$reg_no' AND etl.ex_id = '$examId'";

                                       
                                
                                

                                    $averageGradeResult = $conn->query($averageGradeQuery);

                                    if ($averageGradeResult && $averageGradeRow = $averageGradeResult->fetch_assoc()) {
                                        $averageGrade = $averageGradeRow['average_grade'];
                                        $percentage = $averageGradeRow['percentage'];

                                        // Assuming you have a function to determine the grade based on the average score
                                 // Fetch the examinee's full name based on the logged-in reg_no
$examineeFullNameQuery = "SELECT exmne_fullname FROM examinee_tbl WHERE exmne_id = '$reg_no'";
$examineeFullNameResult = $conn->query($examineeFullNameQuery);

// Check if the query execution was successful
if ($examineeFullNameResult) {
    // Fetch the examinee's full name
    $examineeFullNameRow = $examineeFullNameResult->fetch_assoc();
    $loggedInExamineeFullName = $examineeFullNameRow['exmne_fullname'];
    

                                        $grade = determineGrade($percentage);
                                        $passOrFail = determinePassOrFail($grade);
                                        $rank = determineRank($grade);
                                        $textColor = ($passOrFail === 'Pass') ? 'green' : 'red';




                                        echo "<tr>";
                                        echo "<td>{$examTitle}</td>";
                                        echo "<td>{$grade}</td>";
                                        echo "<td>{$rank}</td>";
                                        echo "<td>{$percentage}%</td>";
                                        echo "<td style='color: $textColor;'>{$passOrFail}</td>";
                                     // Add button for printing certificate if the status is "Pass"
// Output the button for printing certificate
echo "<td><button onclick='printCertificate(\"$examTitle\")'>Print Certificate</button></td>";

                                    }
                                
                                  echo "</tr>";
                                    } else {
                                        echo "Error calculating average grade: " . $conn->error;
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                        <?php
                    } else {
                        // Display message if no results found
                        echo "<p>No results found.</p>";
                    }
                    ?>
                </div>
            </div>
     

    </body>
    </html>
    <?php
} else {
    echo "Error executing query: " . $conn->error;
}

// Function to determine grade based on percentage (customize this based on your grading system)
function determineGrade($percentage) {
    // Your grading logic here
    if ($percentage >= 100) {
        return 'A*';
    } elseif ($percentage >= 90) {
        return 'A+';
    } elseif ($percentage >= 80) {
        return 'A';
    } elseif ($percentage >= 70) {
        return 'B';
    }
    elseif ($percentage >= 60) {
        return 'C';
    } 
    elseif ($percentage >= 40) {
        return 'D';
    } 
     else {
        return 'E';  // Grade for percentages below 60
    }
}

// Function to determine rank based on grade (customize this based on your ranking system)
function determineRank($grade) {
    // Your ranking logic here
    switch ($grade) {
        case 'A*':
            return 'Grand Master';
        case 'A+':
            return 'World Class';
        case 'A':
            return 'Expert';
        case 'B':
            return 'Proficient';
        case 'C':
            return 'Competent';
        case 'D':
            return 'Novice';
        case 'E':
            return 'Beginner';
        default:
            return 'Unknown Rank';
    }
}


// Function to determine pass or fail based on grade
function determinePassOrFail($grade) {
    // Your pass/fail logic here
    return ($grade <= 'D') ? 'Pass' : 'Fail';
}
// Example loop to display results with grades, ranks, and pass/fail status
while ($examRow = $completedExamsResult->fetch_assoc()) {


    // Assuming $percentage is fetched from your database for each exam
    $percentage = $examRow['percentage'];

    // Determine grade based on percentage
    $grade = determineGrade($percentage);

    // Initialize $textColor with a default color
    $textColor = 'black';

    // Determine rank based on grade
    $rank = determineRank($grade);

    // Determine pass or fail based on grade
    $passOrFail = ($grade >= 'D') ? 'Pass' : 'Fail';

    // Update text color based on pass/fail status
    

  
}




?>



<script>
    function printCertificate(examTitle) {
        // Replace 'generate_certificate.php' with the actual path to your script
        var certificateWindow = window.open('pages/generate_certificate.php?examTitle=' + encodeURIComponent(examTitle), '_blank');

        // Check if the window was opened successfully
        if (certificateWindow) {
            // Wait for the window to load and then trigger print
            certificateWindow.onload = function () {
                certificateWindow.print();
            };
        } else {
            alert('Unable to open the certificate. Please check your pop-up blocker settings.');
        }
    }
</script>
<div class="col-md-10">

      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Grade Explanations</h5>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Grade</th>
                                <th>Rank</th>
                                <th>Explanation</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Add rows for each grade and rank -->
                            <tr>
                                <td>A*</td>
                                <td>Grand Master</td>
                                <td>You're in a league of your own! Your mastery of the subject is like reaching the summit of academic excellence. Others study; you conquer.</td>
                            </tr>
                            <tr>
                                <td>A+</td>
                                <td>World Class</td>
                                <td> Outstanding achievement! Your performance is akin to finding a rare unicorn – magical, impressive, and leaving everyone in awe.</td>
                            </tr>
                            <!-- Add similar rows for other grades and ranks -->
                            <tr>
                                <td>A</td>
                                <td>Expert</td>
                                <td>Stellar performance! You've practically turned the subject into your own personal playground. Your understanding is so deep; even the textbooks are asking for your autograph.</td>
                            </tr> <tr>
                                <td>B</td>
                                <td>Proficient</td>
                                <td>Bravo! You've got a solid grip on the material. Your performance is like a blockbuster movie – entertaining, well-executed, and leaving everyone wanting more.
</td>
                            </tr> <tr>
                                <td>C</td>
                                <td>Competent</td>
                                <td> Nice work! You've navigated the subject like a champ. Your understanding is like a reliable sidekick – not flashy, but always there when you need it.
</td>
                            </tr>
                            <tr>
                                <td>D</td>
                                <td>Novice</td>
                                <td>Decent effort! While not at the top, you've shown a satisfactory understanding of the material. Keep pushing for greater heights..</td>
                            </tr>
                            <tr>
                                <td>E</td>
                                <td>Beginner</td>
                                <td>Effort in progress! You've taken steps through the subject, but there's room for improvement. Consider this a launching pad for future success.
</td>
                            </tr>
                            
                        </tbody>
                    </table>
                </div>
                <!-- End of Grade and Rank Explanation section -->
            </div>
    </div>
    </div>
</div>

<!-- Bootstrap JS and jQuery (if needed) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</div>
</div>
</div>
</div>

