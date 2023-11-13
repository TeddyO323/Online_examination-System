<?php
// Fetch the number of questions from the database
require_once('database.php');

// Check if the exam_id is set before using it
if (isset($_GET['exam_id'])) {
    $examId = $_GET['exam_id'];

    // ... Rest of the code for fetching questions and rendering the form goes here

} else {
    // Handle the case where the exam_id is not set
    die("Exam ID is not set.");
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        p {
            text-align: center;
            color: #555;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            justify-content: center;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 12px 20px;
            text-decoration: none;
            margin: 10px 5px;
            cursor: pointer;
            border-radius: 5px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Confirm Exam Submission</h2>
        <p>Are you sure you want to submit the exam?</p>
        <form method="post" action="submit_exam.php?exam_id=<?php echo $examId; ?>">
    <input type="submit" value="Yes, Submit Exam" name="confirm_submit">
</form>

        <form method="get" action="exam.php">
            <input type="hidden" name="exam_id" value="<?php echo $examId; ?>">
            <input type="submit" value="No, Go Back to Exam" name="cancel_submit">
        </form>
    </div>
</body>

</html>
