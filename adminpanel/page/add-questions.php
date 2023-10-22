<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addQuestion'])) {

    include("database.php");


    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO exam_question_tbl (exam_question, exam_ch1, exam_ch2, exam_ch3, exam_ch4, exam_answer) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $question, $choice1, $choice2, $choice3, $choice4, $correctChoice);

    $question = $_POST["examTitle"];
    $choice1 = $_POST["examTitle1"];
    $choice2 = $_POST["examTitle2"];
    $choice3 = $_POST["examTitle3"];
    $choice4 = $_POST["examTitle4"];
    $correctChoice = $_POST["examTitle5"];

    // Execute the statement
    if ($stmt->execute() === TRUE) {
        echo "<script>alert('Successfully added question');</script>";
    } else {
        echo "Error: " . $stmt . "<br>" . $conn->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>

<style>
    .card-container {
        display: flex;
        justify-content: space-between;
    }

    .card-container .main-card {
        width: 48%; /* Adjust this width as needed */
    }

    .question-form {
    width: 50%;
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

<div class="app-main">
    <!-- sidebar diri  -->
    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="app-page-title">
                <div class="page-title-wrapper">
                    <div class="page-title-heading">
                        <div> MANAGE EXAM
                            <div class="page-title-subheading">
                                Add Question for
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                    <div id="refreshData">
                        <div class="card-container">
                            <div class="main-card mb-3 card">
                                <div class="card-header">
                                    <i class="header-icon lnr-license icon-gradient bg-plum-plate"> </i>Exam Information
                                </div>
                                <div class="card-body">
                                <form action="add_question.php" method="post" class="question-form">
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
      <option value="choice1">Choice 1</option>
      <option value="choice2">Choice 2</option>
      <option value="choice3">Choice 3</option>
      <option value="choice4">Choice 4</option>
    </select><br><br>

    <input type="submit" value="Add Question">
</form>

                                </div>
                            </div>
                        </div>
                        <div class="main-card mb-3 card">
                                <div class="card-header">
                                    <i class="header-icon lnr-license icon-gradient bg-plum-plate"> </i>Exam Question's
                                    <span class="badge badge-pill badge-primary ml-2">
                                    </span>
                                    <div class="btn-actions-pane-right">
                                       
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="scroll-area-sm" style="min-height: 400px;">
                                        <div class="scrollbar-container">
                                            <div class="table-responsive">
                                                <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="tableList">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-left pl-1">Course Name</th>
                                                            <th class="text-center" width="20%">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
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


    <!-- MAO NI IYA FOOTER -->
</div>
