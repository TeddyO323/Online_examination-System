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
                echo '<form action="page/update-question.php" method="post">';
                echo '<input type="hidden" name="eqt_id" value="' . $row['eqt_id'] . '">';
                
              // ...
echo 'Question: <input type="text" name="question" value="' . $row['exam_question'] . '"><br>';
echo 'Choice 1: <input type="text" name="choice1" value="' . $row['exam_ch1'] . '"><br>';
echo 'Choice 2: <input type="text" name="choice2" value="' . $row['exam_ch2'] . '"><br>';
echo 'Choice 3: <input type="text" name="choice3" value="' . $row['exam_ch3'] . '"><br>';
echo 'Choice 4: <input type="text" name="choice4" value="' . $row['exam_ch4'] . '"><br>';
// ...
echo '<label for="correct_answer" style="margin-top: 10px;">Correct Answer:</label><br>';
echo '<select name="correct_answer" style="padding: 8px; border-radius: 5px; border: 1px solid #ccc; margin-top: 10px; width: 100%;">';
echo '<option value="choice1" ' . ($row['exam_answer'] === 'choice1' ? 'selected' : '') . ' style="background-color: #f4f4f4;">Choice 1</option>';
echo '<option value="choice2" ' . ($row['exam_answer'] === 'choice2' ? 'selected' : '') . ' style="background-color: #f4f4f4;">Choice 2</option>';
echo '<option value="choice3" ' . ($row['exam_answer'] === 'choice3' ? 'selected' : '') . ' style="background-color: #f4f4f4;">Choice 3</option>';
echo '<option value="choice4" ' . ($row['exam_answer'] === 'choice4' ? 'selected' : '') . ' style="background-color: #f4f4f4;">Choice 4</option>';
echo '</select><br>';
// ...


                // Add other form elements for editing the question
                // ...
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
