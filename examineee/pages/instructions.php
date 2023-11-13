<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Instructions</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            text-align: center;
        }
        h1 {
            margin-bottom: 20px;
        }
        .instructions {
            background: #f4f4f4;
            border: 1px solid #ccc;
            padding: 10px;
            display: inline-block;
            align: left;
        }
        .start-button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }
    </style>
</head>
<body>
<div class="app-main__outer">
        <div class="app-main__inner">
    <h1>Exam Instructions</h1>
    <div class="instructions">
        <h2>General Instructions:</h2>
        <ul>
            <li>Read all instructions carefully before starting the exam.</li>
            <li>Make sure you have a stable internet connection.</li>
            <li>Do not refresh the page during the exam.</li>
            <!-- Add more general instructions here -->
        </ul>
        <h2>Exam-Specific Instructions:</h2>
        <p>Write your specific instructions here...</p>
    </div>
   <br>
   <?php
// Retrieve the 'exam_id' from the URL
$examId = $_GET['exam_id'];

// Use the $examId in your code as needed
// ...
?>

   <a href="pages/exam.php?exam_id=<?php echo $examId; ?>">Start Exam</a>
    </div>
    </div>
    <script>
        function redirectToExam() {
            // Redirect the user to the exam page
            window.location.href = 'pages/exam.php'; // Replace 'your_exam_page_url' with your actual exam page URL
        }
    </script>
</body>
</html>
