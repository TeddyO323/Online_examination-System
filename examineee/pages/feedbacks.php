<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Feedback</title>
    <link rel="stylesheet" href="styles.css">

<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        h2 {
            text-align: center;
            color: black;
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
        select,
    button,
    input,
    textarea {
        margin-bottom: 15px;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ddd;
        width: 100%; /* Adjusted width for the form elements */
        font-size: 16px;
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
        button {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: none;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }
        button:active {
            background-color: #004080;
        }

        button:focus {
            outline: none;
        }
    </style>

</head>
<body>
<div class="app-main__outer">
        <div class="app-main__inner">
    <div class="container">
        <h1 style="text-align: center;">Exam Feedback</h1>
        <form action="pages/submit_feedback.php" method="post" enctype="multipart/form-data">
        <?php
// Include the database connection file
include('database.php');

// Start the PHP session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the reg_no is set in the session
if (isset($_SESSION['reg_no'])) {
    $regNo = $_SESSION['reg_no'];

    // Fetch the examinee's full name from the database based on the registration number
    $query = "SELECT exmne_fullname FROM examinee_tbl WHERE reg_no = '$regNo'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);

        // Check if the column 'exmne_fullname' exists in the result
        if (isset($row['exmne_fullname'])) {
            $examineeFullName = $row['exmne_fullname'];
        } else {
            // Handle the case where the examinee with the given reg_no is not found
            echo 'Error: Examinee not found.';
        }
    } else {
        // Handle the case where the query fails
        echo 'Error: Query failed.';
    }
} else {
    // If not logged in, display an error message
    echo '<p>Error: Unable to retrieve examinee information. Please log in.</p>';
}
?>

<label for="feedbackCategory">Feedback Category:</label>
<select id="feedbackCategory" name="feedbackCategory">
    <option value="Content Clarity">Content Clarity</option>
    <option value="Technical Issues">Technical Issues</option>
    <option value="User Experience">User Experience</option>
    <!-- Add more categories as needed -->
</select>
<br>
            <label for="feedback">Feedback:</label>
            <textarea id="feedback" name="feedback" rows="4" required></textarea>
            <!-- <label for="fileUpload">Upload File (Optional):</label>
<input type="file" id="fileUpload" name="fileUpload"> -->
<br>

            <label for="feedbackType">Give feedback as:</label>
<select id="feedbackType" name="feedbackType">
<option value="" disabled selected>How you want to provide your feedback</option>

    <option value=""><?php echo $regNo; ?> <?php echo $examineeFullName; ?> - You</option>
    <option value="Anonymous">Anonymous(Name and reg no will not be shown)</option>
</select>

            <button type="submit">Submit Feedback</button>
        </form>
    </div>
</body>
</html>