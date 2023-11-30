<!DOCTYPE html>
<html>

<head>
    <title>Add Questions</title>
    <style>
        /* Style for the buttons */
        button[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }

        /* Adjust the margins for the panels */
        .panel {
            margin-top: 20px;
            margin-bottom: 20px;
        }

        /* Style for the panel headings */
        .panel-heading {
            font-size: 20px;
            font-weight: bold;
        }

        /* Style for the panel body */
        .panel-body {
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        /* Style for the input fields */
        input[type="text"],
        textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            margin-bottom: 10px;
        }

        /* Style for the file upload input */
        input[type="file"] {
            margin-bottom: 10px;
        }

        /* Adjust the margin for the label and select elements */
        label,
        select {
            margin-bottom: 10px;
        }
        #marks {
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        box-sizing: border-box;
        border: 1px solid #ccc;
        border-radius: 4px;
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
    <form method="post" action="page/process-questions.php" enctype="multipart/form-data">
    <div class="panel">
        <div class="panel-heading">Multiple Choice Questions with Single Answer</div>
        <div class="panel-body">
            <label for="mc_single_question">Question:</label><br>
            <textarea id="mc_single_question" name="mc_single_question" rows="4" cols="50"></textarea><br>

            <label for="mc_single_image">Upload Image:</label><br>
            <input type="file" id="mc_single_image" name="mc_single_image"><br>
            <label for="marks">Marks:</label><br>
            <input type="number" id="marks" name="marks"><br>

            <label>Options:</label><br>
            <div id="single-option-container">
                <label for="s_option1">Option 1</label>
                <input type="text" id="s_option1_value" name="s_option1_value" placeholder="Value for Option 1" oninput="updateSingleAnswerOptions()"><br>

                <label for="s_option2">Option 2</label>
                <input type="text" id="s_option2_value" name="s_option2_value" placeholder="Value for Option 2" oninput="updateSingleAnswerOptions()"><br>

                <label for="s_option3">Option 3</label>
                <input type="text" id="s_option3_value" name="s_option3_value" placeholder="Value for Option 3" oninput="updateSingleAnswerOptions()"><br>

                <label for="s_option4">Option 4</label>
                <input type="text" id="s_option4_value" name="s_option4_value" placeholder="Value for Option 4" oninput="updateSingleAnswerOptions()"><br>
            </div>

            <label>Correct Answer:</label><br>
            <select id="single-answer-dropdown" name="mc_single_correct_answer"></select>

          

            <input type="hidden" name="ex_id" value="<?php echo $exId; ?>">

            <button type="submit">Add Question</button>
        </div>
    </div>
</form>

<script>
    function updateSingleAnswerOptions() {
        var options = document.getElementById("single-option-container").getElementsByTagName("input");
        var selectOptions = document.getElementById("single-answer-dropdown");

        // Clear the existing options
        selectOptions.innerHTML = "";

        // Add new options based on the input values
        for (var i = 0; i < options.length; i++) {
            var optionValue = options[i].value;
            var optionText = options[i].value; // You can modify this to use specific values

            var newOption = document.createElement("option");
            newOption.value = optionValue;
            newOption.text = optionText;

            selectOptions.appendChild(newOption);
        }
    }
</script>


<form method="post" action="page/process-questions.php" enctype="multipart/form-data">
    <div class="panel">
        <div class="panel-heading">Multiple Choice Questions with Multiple Answers</div>
        <div class="panel-body">
            <label for="mc_multiple_question">Question:</label><br>
            <textarea id="mc_multiple_question" name="mc_multiple_question" rows="4" cols="50"></textarea><br>

            <label for="mc_multiple_image">Upload Image:</label><br>
            <input type="file" id="mc_multiple_image" name="mc_multiple_image"><br>
            <label for="marks">Marks:</label><br>
            <input type="number" id="marks" name="marks"><br>


            <label>Options:</label><br>
            <div id="multiple-option-container">
                <label for="m_option1">Option 1</label>
                <input type="text" id="m_option1_value" name="mc_multiple_option1_value" placeholder="Value for Option 1" oninput="updateDropDownOptions()"><br>

                <label for="m_option2">Option 2</label>
                <input type="text" id="m_option2_value" name="mc_multiple_option2_value" placeholder="Value for Option 2" oninput="updateDropDownOptions()"><br>

                <label for="m_option3">Option 3</label>
                <input type="text" id="m_option3_value" name="mc_multiple_option3_value" placeholder="Value for Option 3" oninput="updateDropDownOptions()"><br>

                <label for="m_option4">Option 4</label>
                <input type="text" id="m_option4_value" name="mc_multiple_option4_value" placeholder="Value for Option 4" oninput="updateDropDownOptions()"><br>
            </div>

            <label for="correct_answer">Correct Answer:</label><br>
<select id="correct_answer" name="correct_answer[]" multiple>
    <option value="m_option1">Option 1</option>
    <option value="m_option2">Option 2</option>
    <option value="m_option3">Option 3</option>
    <option value="m_option4">Option 4</option>
    <div id="selected-options-container"></div>

</select>


            <input type="hidden" name="ex_id" value="<?php echo $exId; ?>">

            <button type="submit">Add Question</button>
        </div>
    </div>
</form>
<script>
    function updateDropDownOptions() {
        var options = document.getElementById("multiple-option-container").getElementsByTagName("input");
        var selectOptions = document.getElementById("correct_answer");

        // Clear the existing options
        selectOptions.innerHTML = "";

        // Add new options based on the input values
        for (var i = 0; i < options.length; i++) {
            var optionValue = options[i].value;
            var optionText = options[i].value; // You can modify this to use specific values

            var newOption = document.createElement("option");
            newOption.value = optionValue;
            newOption.text = optionText;

            selectOptions.appendChild(newOption);
        }
    }

    // Modified function to allow multiple selections
    function allowMultipleSelection() {
        var selectOptions = document.getElementById("correct_answer");
        selectOptions.multiple = true;
    }
</script>




<h1>Adding Questions</h1>

<form method="post" action="page/process-questions.php" enctype="multipart/form-data">
    <div class="panel">
        <div class="panel-heading">Essay Question</div>
        <div class="panel-body">
            <label for="essay_question">Question:</label><br>
            <textarea id="essay_question" name="essay_question" rows="4" cols="50"></textarea><br>

            <label for="essay_image">Upload Image:</label><br>
            <input type="file" id="essay_image" name="essay_image"><br>
            <input type="hidden" name="ex_id" value="<?php echo $exId; ?>">
            <label for="marks">Marks:</label><br>
            <input type="number" id="marks" name="marks"><br>



            <button type="submit">Add Question</button>
        </div>
    </div>
</form>

</body>

</html>

