<?php
// Include the database connection file
include('database.php');

// Start the PHP session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Retrieve form data
    $feedbackCategory = mysqli_real_escape_string($conn, $_POST['feedbackCategory']);
    $feedbackType = mysqli_real_escape_string($conn, $_POST['feedbackType']);
    $feedbackText = mysqli_real_escape_string($conn, $_POST['feedback']);

//     // Handle file upload if a file is selected
//     $targetDir = "uploads/";  // Specify the directory where uploaded files will be stored
//     // Check if a file was selected for upload
// if (isset($_FILES["fileUpload"]) && $_FILES["fileUpload"]["error"] == UPLOAD_ERR_OK) {
//     // Handle file upload
//     $fileName = basename($_FILES["fileUpload"]["name"]);
//     $targetFilePath = $targetDir . $fileName;
//     $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

//     // Upload the file
//     move_uploaded_file($_FILES["fileUpload"]["tmp_name"], $targetFilePath);
// } else {
//     $fileName = null; // No file uploaded
// }


  // Check if the user is logged in
if (isset($_SESSION['reg_no'])) {
    $regNo = $_SESSION['reg_no'];

    // Check if feedback should be anonymous
    $isAnonymous = ($feedbackType === 'Anonymous');

    // Determine the value for the reg_no and feedback_type columns
    $regNoColumnValue = $isAnonymous ? 'Anonymous' : $regNo;
    $feedbackTypeColumnValue = $isAnonymous ? 'Anonymous' : 'Not Anonymous';

    // Insert feedback into the database
    $insertQuery = "INSERT INTO feedback_tbl (reg_no, feedback_category, feedback_type, feedback_text, file_name)
                    VALUES ('$regNoColumnValue', '$feedbackCategory', '$feedbackTypeColumnValue', '$feedbackText', '$fileName')";
    $result = mysqli_query($conn, $insertQuery);

    if ($result) {
        // Feedback submitted successfully
        echo "Feedback submitted successfully!";
    } else {
        // Handle the case where the query fails
        echo "Error: Unable to submit feedback.";
    }
} else {
    // If not logged in, display an error message
    echo "Error: Unable to retrieve examinee information. Please log in.";
}

} else {
    // If the form is not submitted, redirect to the feedback page
    header("Location: feedback_page.php");
    exit();
}
?>
