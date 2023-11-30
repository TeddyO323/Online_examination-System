<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once('database.php');

// Check if the exam ID is provided in the URL
if (isset($_GET['ex_id'])) {
    $examId = $_GET['ex_id'];

    // Fetch exam details from the database
    $sqlExam = "SELECT * FROM exam_tbl WHERE ex_id = '$examId'";
    $resultExam = $conn->query($sqlExam);

    if ($resultExam && $resultExam->num_rows > 0) {
        $examDetails = $resultExam->fetch_assoc();
    } else {
        // Exam not found, handle accordingly (redirect, show error, etc.)
        header("Location: index.php"); // Redirect to the exam list page
        exit();
    }
} else {
    // Exam ID not provided in the URL, handle accordingly (redirect, show error, etc.)
    header("Location: index.php"); // Redirect to the exam list page
    exit();
}

// Process form submission if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize form data
    $courseName = mysqli_real_escape_string($conn, $_POST['course_name']);
    $examinerNumber = mysqli_real_escape_string($conn, $_POST['examiner_number']);
    $examinerName = mysqli_real_escape_string($conn, $_POST['examiner_name']);
    $examTitle = mysqli_real_escape_string($conn, $_POST['exam_title']);
    $examDescription = mysqli_real_escape_string($conn, $_POST['exam_description']);
    $examTimeLimit = mysqli_real_escape_string($conn, $_POST['exam_time_limit']);
    $examStartDate = mysqli_real_escape_string($conn, $_POST['exam_start_date']);
    $examEndDate = mysqli_real_escape_string($conn, $_POST['exam_end_date']);

    // Update exam details in the database
    $sqlUpdateExam = "UPDATE exam_tbl SET
        course_name = '$courseName',
        examiner_number = '$examinerNumber',
        examiner_name = '$examinerName',
        exam_title = '$examTitle',
        exam_description = '$examDescription',
        exam_time_limit = '$examTimeLimit',
        exam_start_datetime = '$examStartDate',
        exam_end_datetime = '$examEndDate'
        WHERE ex_id = '$examId'";

    if ($conn->query($sqlUpdateExam) === TRUE) {
        // Exam details updated successfully, redirect to exam list page
        header("Location: index.php");
        exit();
    } else {
        // Error updating exam details
        echo "Error: " . $sqlUpdateExam . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Exam</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        h2 {
            text-align: center;
            color: blue;
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
            display: block;
            margin-bottom: 10px;
        }
        input[type="text"], input[type="email"], input[type="password"], input[type="date"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        select {
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
        button[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4caf50;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }
        input,
        textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        textarea {
            resize: vertical;
            height: 100px; /* Adjust the height as needed */
        }
        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style></head>
<body>
<div class="app-main__outer">
    <div class="app-main__inner">
  
    <h1 style="text-align: center;">Edit Exam</h1>
    <form method="post" action="">
        
        <label for="course_name">Course Name:</label>
        <input type="text" name="course_name" value="<?php echo $examDetails['course_name']; ?>" required>

        <label for="examiner_number">Examiner Number:</label>
        <input type="text" name="examiner_number" value="<?php echo $examDetails['examiner_number']; ?>">

        <label for="examiner_name">Examiner Name:</label>
        <input type="text" name="examiner_name" value="<?php echo $examDetails['examiner_name']; ?>">

        <label for="exam_title">Exam Title:</label>
        <input type="text" name="exam_title" value="<?php echo $examDetails['exam_title']; ?>" required>

        <label for="exam_description">Exam Description:</label>
        <textarea name="exam_description"><?php echo $examDetails['exam_description']; ?></textarea>

        <label for="exam_time_limit">Exam Time Limit (in minutes):</label>
        <input type="number" name="exam_time_limit" value="<?php echo $examDetails['exam_time_limit']; ?>" required>

        <label for="exam_start_date">Exam Start Date:</label>
        <input type="datetime-local" name="exam_start_date" value="<?php echo date('Y-m-d\TH:i', strtotime($examDetails['exam_start_datetime'])); ?>" required>

        <label for="exam_end_date">Exam End Date:</label>
        <input type="datetime-local" name="exam_end_date" value="<?php echo date('Y-m-d\TH:i', strtotime($examDetails['exam_end_datetime'])); ?>" required>

        <input type="submit" value="Save Changes">
    </form>
    </div>
    </div>
  


</body>
</html>
