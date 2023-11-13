<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examinee Information</title>
    <style>
        .examinee-container {
            margin: auto;
        margin-top: 100px;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 5px;
        width: 70%; /* Adjusted width for the form */
        font-family: Arial, sans-serif;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);

        }
        .my-exams-container{
            border: 1px solid #dddddd;
            border-radius: 5px;
            padding: 10px;
            margin: 10px;
            width: 100%;
        }
        .my-exams-container:hover{
            background-color: #e2e2e2;

        }
        .courses-container {
            border: 1px solid #dddddd;
            border-radius: 5px;
            padding: 10px;
            margin: 10px;
            width: 100%;
        }

        .courses-container:hover {
            background-color: #e2e2e2;
        }
        
        .examinee-details {
            border: 1px solid #dddddd;
            border-radius: 5px;
            padding: 10px;
            margin: 10px;
            width: 100%;
            
        }
        .examinee-details:hover {
            background-color: #e2e2e2;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 6px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    
<div class="app-main__outer">
        <div class="app-main__inner">
            <div class="examinee-container">
            <h2 style="text-align: center;">My Information</h2>
    <?php
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in
if (!isset($_SESSION['reg_no'])) {
    header("Location: login.php");
    exit();
}

    // Include the file containing the database connection details
    require_once('database.php');

    // Retrieve the examinee's information from the database based on the registration number
    $reg_no = $_SESSION['reg_no'];
    $sql = "SELECT * FROM examinee_tbl WHERE reg_no = '$reg_no'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Display the examinee's information
        echo "<p><strong>Full Name:</strong> " . $row['exmne_fullname'] . "</p>";
        echo "<p><strong>Examinee Course:</strong> " . $row['exmne_course'] . "</p>";
        echo "<p><strong>Gender:</strong> " . $row['exmne_gender'] . "</p>";
        echo "<p><strong>Birth Date:</strong> " . $row['exmne_birthdate'] . "</p>";
        echo "<p><strong>Registration Number:</strong> " . $row['reg_no'] . "</p>";
        echo "<p><strong>Address:</strong> " . $row['address'] . "</p>";
        echo "<p><strong>Contact Number:</strong> " . $row['contact_no'] . "</p>";
        echo "<p><strong>Exam Year Level:</strong> " . $row['exmne_year_level'] . "</p>";
        echo "<p><strong>Email:</strong> " . $row['exmne_email'] . "</p>";
    
        // Add the edit button
        echo '<button class="edit-button" onclick="window.location.href=\'index.php?pages=edit_examinee_info\'">Edit</button>';
    } else {
        echo "Examinee information not found.";
    }

    // Check if the update_success session variable is set
if (isset($_SESSION['update_success']) && $_SESSION['update_success'] === true) {
    // Display the success message using JavaScript
    echo "<script>alert('You have successfully updated your details');</script>";

    // Unset the session variable after displaying the message
    unset($_SESSION['update_success']);
}
    
    ?>
  
  

<div class="my-exams-container">

<!-- Your existing HTML code -->
<?php
// Your existing PHP code

// Establish database connection
require_once('database.php');

// Check the database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$course_name = $row['exmne_course']; // Fetch the examinee's course
$exam_sql = "SELECT * FROM exam_tbl WHERE course_name = '$course_name'";
$exam_result = $conn->query($exam_sql);

if ($exam_result) {
    if ($exam_result->num_rows > 0) {
        echo "<h2>My Exams</h2>";
        echo "<table>";
        echo "<tr><th>Exam ID</th><th>Exam Title</th></tr>";
        while ($exam_row = $exam_result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $exam_row['ex_id'] . "</td>";
            echo "<td>" . $exam_row['exam_title'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No exams found for this course.</p>";
    }
} else {
    echo "Error: " . $exam_sql . "<br>" . $conn->error; // Display the specific error if the query fails
}
$conn->close(); // Close the database connection
?>
<!-- Remaining HTML code -->

        </table>
    </div>
                </div>
            </div>
            
       
        </div>
    </div>
</body>
</html>