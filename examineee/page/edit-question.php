<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Question</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        form {
            max-width: 400px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
<div class="app-main__outer">
    <div class="app-main__inner">
    <h2>Edit Question</h2>
    
    <?php
    // Include the file for database connection
    include 'database.php';

    // Check if the eqt_id is set
    if (isset($_GET['eqt_id'])) {
        $questionId = $_GET['eqt_id'];

        // Retrieve the question details from the database based on the eqt_id
        $sql = "SELECT * FROM exam_question_tbl WHERE eqt_id = $questionId";
        $result = $conn->query($sql);

        if ($result) {
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                // Display the form to edit the question
                echo '<form action="update-question.php" method="post">';
                echo '<input type="hidden" name="eqt_id" value="' . $row['eqt_id'] . '">';
                echo '<input type="hidden" name="ex_id" value="' . $row['ex_id'] . '">'; // Include the ex_id here

                if ($row['question_type'] === 'essay') {
                    // Add form elements for the essay question
                    echo 'Essay Question: <textarea name="essay_question">' . $row['exam_question'] . '</textarea><br>';
                } elseif ($row['question_type'] === 'single_choice' || $row['question_type'] === 'multiple_choice') {
                    // Add form elements for both single and multiple-choice questions
                    echo 'Question: <input type="text" name="question" value="' . $row['exam_question'] . '"><br>';
                    echo 'Choice 1: <input type="text" name="choices[]" value="' . $row['exam_ch1'] . '"><br>';
                    echo 'Choice 2: <input type="text" name="choices[]" value="' . $row['exam_ch2'] . '"><br>';
                    echo 'Choice 3: <input type="text" name="choices[]" value="' . $row['exam_ch3'] . '"><br>';
                    echo 'Choice 4: <input type="text" name="choices[]" value="' . $row['exam_ch4'] . '"><br>';
                    // Add a field for the correct answer
                    echo 'Correct Answer: <input type="text" name="correct_answer" value="' . $row['exam_answer'] . '"><br>';

                    // Add hidden input for the number of choices
                    echo '<input type="hidden" name="num_choices" value="4">'; // Change the value if the number of choices varies
                }

                // Add other necessary form elements

                echo '<input type="submit" value="Update Question">';
                echo '</form>';
            } else {
                echo "<p style='text-align: center; color: red;'>No question found with the specified ID.</p>";
            }
        } else {
            echo "<p style='text-align: center; color: red;'>Error: " . $sql . "<br>" . $conn->error . "</p>";
        }
    } else {
        echo "<p style='text-align: center; color: red;'>No question ID specified in the URL.</p>";
    }
    $conn->close();
    ?>
</body>
</html>
