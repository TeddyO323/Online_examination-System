<?php
// Include the file for database connection
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $questionType = $_POST['questionType'];

    if ($questionType === "essay") {
        $essayQuestion = $conn->real_escape_string($_POST['essay_question']);
        $exId = $conn->real_escape_string($_POST['ex_id']); // Make sure to get ex_id

        $sql = "INSERT INTO exam_question_tbl (ex_id, exam_question, question_type) VALUES ('$exId', '$essayQuestion', '$questionType')";
        if ($conn->query($sql) === TRUE) {
            // Redirect to prevent form resubmission
            echo '<script>window.location.href = window.location.href;</script>';
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else if ($questionType === "single_choice" || $questionType === "multiple_choice") {
        $question = $conn->real_escape_string($_POST['question']);
        $choice1 = $conn->real_escape_string($_POST['choice1']);
        $choice2 = $conn->real_escape_string($_POST['choice2']);
        $choice3 = $conn->real_escape_string($_POST['choice3']);
        $choice4 = $conn->real_escape_string($_POST['choice4']);
        $correctAnswer = $conn->real_escape_string($_POST['correct_answer']);
        $exId = $conn->real_escape_string($_POST['ex_id']); // Make sure to get ex_id

        // Handle multiple answers for multiple-choice questions
        if ($questionType === "multiple_choice") {
            $choices = $_POST['choices'];
            $correctAnswer = implode(",", $choices);
        }

        $sql = "INSERT INTO exam_question_tbl (ex_id, exam_question, exam_ch1, exam_ch2, exam_ch3, exam_ch4, exam_answer, question_type) VALUES ('$exId', '$question', '$choice1', '$choice2', '$choice3', '$choice4', '$correctAnswer', '$questionType')";

        if ($conn->query($sql) === TRUE) {
            // Redirect to prevent form resubmission
            echo '<script>window.location.href = window.location.href;</script>';
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
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
form {
            margin: auto;
        margin-top: 100px;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 5px;
        width: 70%; /* Adjusted width for the form */
        font-family: Arial, sans-serif;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);

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
        <form action="index.php?page=add-questions" method="post" class="question-form" id="questionForm">
            <h1 class="form-title">Add Question</h1>

            <label for="questionType">Question Type:</label><br>
<select name="questionType" id="questionType" onchange="showQuestionForm()">
    <option value="" disabled selected>Choose type of question</option>
    <option value="essay">Essay</option>
    <option value="single_choice">Multiple Choice (Single Answer)</option>
    <option value="multiple_choice">Multiple Choice (Multiple Answers)</option>
</select><br><br>
      <div id="questionFields"></div>

            <input type="submit" value="Add Question">
        </form>
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
    </div>
</div>
<script>
    function showQuestionForm() {
        var questionType = document.getElementById("questionType").value;
        var questionFields = document.getElementById("questionFields");
        var addQuestionButton = document.getElementById("addQuestionButton");

        questionFields.innerHTML = "";

        if (questionType === "essay") {
            questionFields.innerHTML = `
                <label for="essay_question">Essay Question:</label><br>
                <textarea id="essayQuestion" name="essay_question" required style="height: 150px; width: 100%;"></textarea><br><br>
            `;
            addQuestionButton.style.display = "block";
        } else if (questionType === "single_choice") {
            questionFields.innerHTML = `
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
            `;
            addQuestionButton.style.display = "block";
        } else if (questionType === "multiple_choice") {
            questionFields.innerHTML = `
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
                <p>Check all that apply:</p>
                <label for="choice1_checkbox">Choice 1:</label>
                <input type="checkbox" id="choice1_checkbox" name="choices[]" value="choice1" onclick="updateSelectedChoices()">
                <br>

                <label for="choice2_checkbox">Choice 2:</label>
                <input type="checkbox" id="choice2_checkbox" name="choices[]" value="choice2" onclick="updateSelectedChoices()">
                <br>

                <label for="choice3_checkbox">Choice 3:</label>
                <input type="checkbox" id="choice3_checkbox" name="choices[]" value="choice3" onclick="updateSelectedChoices()">
                <br>

                <label for="choice4_checkbox">Choice 4:</label>
                <input type="checkbox" id="choice4_checkbox" name="choices[]" value="choice4" onclick="updateSelectedChoices()">
                <br><br>
            `;
            addQuestionButton.style.display = "block";
        }
    }

    function updateSelectedChoices() {
        var selectedChoices = document.getElementById("selectedChoices");
        var choices = document.getElementsByName("choices[]");
        var selectedChoicesText = "Check all that apply: ";

        for (var i = 0; i < choices.length; i++) {
            if (choices[i].checked) {
                selectedChoicesText += choices[i].value + ", ";
            }
        }

        selectedChoices.textContent = selectedChoicesText;
    }
</script>



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
                            $exId = $_GET['ex_id'];
                            $sql = "SELECT * FROM exam_question_tbl WHERE ex_id = $exId";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                $questionNumber = 1; // Initialize the question counter
                                // Output data of each row
                                while ($row = $result->fetch_assoc()) {
                                    echo '<tr>';
                                    echo '<td class="text-left pl-1"><strong>' . $questionNumber . '.)</strong> ' . $row['exam_question'] . '</td>';
                                    echo '<td class="text-center" width="20%">';
                                    echo '<button class="btn btn-primary" onclick="editQuestion(' . $row['eqt_id'] . ')">Edit</button>';
                                    
                                    echo '<button class="btn btn-danger" onclick="deleteQuestion(' . $row['eqt_id'] . ')">Delete</button>';
                                    echo '</td>';
                                    echo '</tr>';
                                    
                                    // Display choices for multiple-choice questions
                                    if ($row['question_type'] !== 'essay') {
                                        echo '<tr><td class="text-left pl-1"><strong>A:</strong> ' . $row['exam_ch1'] . '</td></tr>';
                                        echo '<tr><td class="text-left pl-1"><strong>B:</strong> ' . $row['exam_ch2'] . '</td></tr>';
                                        echo '<tr><td class="text-left pl-1"><strong>C:</strong> ' . $row['exam_ch3'] . '</td></tr>';
                                        echo '<tr><td class="text-left pl-1"><strong>D:</strong> ' . $row['exam_ch4'] . '</td></tr>';
                                        echo '<tr><td class="text-left pl-1" style="color: green;"><strong>Correct Answer:</strong> ' . $row['exam_answer'] . '</td></tr>';
                                    }
                                    $questionNumber++; // Increment the question counter
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
            xhr.open("POST", "page/delete-question.php", true);
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
  



</body>
</html>

<?php
    // Include the file for database connection
    include 'database.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $questionType = $_POST['questionType'];

        if ($questionType === "essay") {
            $essayQuestion = $_POST['essay_question'];

            // Insert the essay question into the database
            $sql = "INSERT INTO exam_question_tbl (exam_question, question_type) VALUES ('$essayQuestion', '$questionType')";
            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('Essay question added successfully');</script>";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else if ($questionType === "single_choice" || $questionType === "multiple_choice") {
            $question = $_POST['question'];
            $choices = array($_POST['choice1'], $_POST['choice2'], $_POST['choice3'], $_POST['choice4']);
            $correctAnswer = $_POST['correct_answer'];

            // Convert the array of choices to a string
            $choicesString = implode(",", $choices);

            // Insert the multiple-choice question into the database
            $sql = "INSERT INTO exam_question_tbl (exam_question, choices, correct_answer, question_type) VALUES ('$question', '$choicesString', '$correctAnswer', '$questionType')";
            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('Multiple choice question added successfully');</script>";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }
    $conn->close();
?>

