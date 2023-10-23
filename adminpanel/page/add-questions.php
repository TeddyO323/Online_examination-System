<?php
// Include the file for database connection
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape user inputs for security
    $question = $conn->real_escape_string($_POST['question']);
    $choice1 = $conn->real_escape_string($_POST['choice1']);
    $choice2 = $conn->real_escape_string($_POST['choice2']);
    $choice3 = $conn->real_escape_string($_POST['choice3']);
    $choice4 = $conn->real_escape_string($_POST['choice4']);
    $correct_answer = $conn->real_escape_string($_POST['correct_answer']);
    $ex_id = $conn->real_escape_string($_POST['ex_id']); // Make sure to get ex_id

    // Attempt to insert the data
    $sql = "INSERT INTO exam_question_tbl (ex_id, exam_question, exam_ch1, exam_ch2, exam_ch3, exam_ch4, exam_answer) VALUES ('$ex_id', '$question', '$choice1', '$choice2', '$choice3', '$choice4', '$correct_answer')";

    if ($conn->query($sql) === TRUE) {
        // Redirect to prevent form resubmission
        echo '<script>window.location.href = window.location.href;</script>';
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        .card-container {
            display: flex;
            justify-content: space-between;
            align-items: stretch;
            flex-wrap: wrap;
        }
        .main-card {
            flex: 0 0 48%;
        }
        .question-form {
    width: 100%;
    margin: auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #f9f9f9;
}

.form-title {
    text-align: center;
    color: #333;
}
  
label {
    font-weight: bold;
}

input[type="text"], select {
    width: 100%;
    padding: 10px;
    margin: 5px 0;
    box-sizing: border-box;
    border: 1px solid #ccc;
    border-radius: 4px;
}

input[type="submit"] {
    width: 100%;
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #45a049;
}

    </style>
</head>
<body>
    
    <<?php
// Include the file for database connection
include 'database.php';

// Retrieve the ex_id from the URL
if (isset($_GET['ex_id'])) {
    $exId = $_GET['ex_id'];
    // Fetch the exam title based on the ex_id
    $examTitleQuery = $conn->query("SELECT exam_title FROM exam_tbl WHERE ex_id = $exId");

    if ($examTitleQuery->num_rows > 0) {
        $row = $examTitleQuery->fetch_assoc();
        $examTitle = $row['exam_title'];

        // Display the exam title
        echo '<div class="app-main">';
        echo '<div class="app-main__outer">';
        echo '<div class="app-main__inner">';
        echo '<div class="app-page-title">';
        echo '<div class="page-title-wrapper">';
        echo '<div class="page-title-heading">';
        echo '<div> MANAGE EXAM';
        echo '<div class="page-title-subheading">';
echo 'Add Question for <span style="color: blue; font-weight: bold;">' . $examTitle . '</span>';
echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '<div class="col-md-12">';
        echo '<div id="refreshData">';
        // Rest of your HTML content
    } else {
        echo "No exam found with the specified ID";
    }
} else {
    echo "No exam ID specified in the URL";
}
?>

                        <div class="card-container">
                            <div class="main-card mb-3 card">
                                <div class="card-header">
                                    <i class="header-icon lnr-license icon-gradient bg-plum-plate"> </i>Exam Information
                                </div>
                                <div class="card-body">
                                    <form action="index.php?page=add-questions" method="post" class="question-form">
                                        <h1 class="form-title">Add Question</h1>

                                        <label for="question">Question:</label><br>
                                        <input type="text" id="question" name="question" required><br><br>

                                        <label for="choice1">Choice 1:</label><br>
                                        <input type="text" id="choice1" name="choice1" required><br>

                                        <label for="choice2">Choice 2:</label><br>
                                        <input type="text" id="choice2" name="choice2" required><br>

                                        <label for="choice3">Choice 3:</label><br>
                                        <input type="text" id="choice3" name="choice3" required><br>

                                        <label for="choice4">Choice 4:</label><br>
                                        <input type="text" id="choice4" name="choice4" required><br><br>

                                        <label for="correct_answer">Correct Answer:</label><br>
                                        <select name="correct_answer" id="correctAnswer">
                                            <option value="choice1" name="choice1">Choice 1</option>
                                            <option value="choice2" name="choice2">Choice 2</option>
                                            <option value="choice3" name="choice3">Choice 3</option>
                                            <option value="choice4" name="choice4">Choice 4</option>
                                        </select><br><br>

                                        <input type="submit" value="Add Question">
                                    </form>
                                </div>
                            </div>
                            <div class="main-card mb-3 card">
    <div class="card-header">
        <i class="header-icon lnr-license icon-gradient bg-plum-plate"> </i>Exam Question's
        <span class="badge badge-pill badge-primary ml-2"></span>
        <div class="btn-actions-pane-right"></div>
    </div>
    <div class="card-body">
        <div class="scroll-area-sm" style="min-height: 400px;">
            <div class="scrollbar-container">
                <div class="table-responsive">
                    <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="tableList">
                        <thead>
                            <tr>
                                <th class="text-left pl-1">Questions</th>
                                <th class="text-center" width="20%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Include the file for database connection
                            include 'database.php';

                            // Fetch data from the database
                            $sql = "SELECT * FROM exam_question_tbl";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                $questionNumber = 1; // Initialize the question counter
                                // Output data of each row
                                while ($row = $result->fetch_assoc()) {
                                    echo '<tr>';
                                    echo '<td class="text-left pl-1"><strong> ' . $questionNumber . '.)</strong> ' . $row['exam_question'] . '</td>';
                                    echo '<td class="text-center" width="20%">';
                                    echo '<button class="btn btn-primary" onclick="editQuestion(' . $row['eqt_id'] . ')">Edit</button>';
// ...
echo '<button class="btn btn-danger" onclick="deleteQuestion(' . $row['eqt_id'] . ')">Delete</button>';
// ...
                                    echo '</td>';
                                    

                                    echo '<tr><td class="text-left pl-1"><strong>A:</strong> ' . $row['exam_ch1'] . '</td></tr>';
                                    echo '<tr><td class="text-left pl-1"><strong>B:</strong> ' . $row['exam_ch2'] . '</td></tr>';
                                    echo '<tr><td class="text-left pl-1"><strong>C:</strong> ' . $row['exam_ch3'] . '</td></tr>';
                                    echo '<tr><td class="text-left pl-1"><strong>D:</strong> ' . $row['exam_ch4'] . '</td></tr>';
                                    echo '</td>';
                                    echo '</tr>';
// ...
echo '<tr><td class="text-left pl-1" style="color: green;"><strong>Correct Answer:</strong> ' . $row['exam_answer'] . '</td></tr>';
echo '</td>';
echo '</tr>';
$questionNumber++; // Increment the question counter
// ...
                                }
                            } else {
                                echo '<tr><td colspan="2">No questions found</td></tr>';
                            }
                            $conn->close();
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


                                                      
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    function editQuestion(questionId) {
        // Redirect to the edit page with the questionId as a parameter
        window.location.href = 'index.php?page=edit-question&eqt_id=' + questionId;
    }
</script>
<script>
    function deleteQuestion(questionId) {
        if (confirm("Are you sure you want to delete this question?")) {
            // Make an AJAX request to delete the question
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "delete-question.php", true);
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
            xhr.send("eqt_id=" + questionId);
        }
    }
</script>
<script>
    document.querySelector('.question-form').addEventListener('submit', function (event) {
        // Prevent the default form submission
        event.preventDefault();

        // Get the current ex_id
        var exId = <?php echo $exId; ?>;

        // Serialize the form data
        var formData = new URLSearchParams(new FormData(this));

        // Append the ex_id to the form data
        formData.append('ex_id', exId);

        // Send the form data via AJAX
        fetch('index.php?page=add-questions', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            console.log(data); // You can use this for debugging purposes
            // Reload the page or perform any necessary actions after successful submission
            window.location.reload();
        })
        .catch(error => console.error('Error:', error));
    });
</script>




</body>
</html>
