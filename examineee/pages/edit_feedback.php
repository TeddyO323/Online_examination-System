<?php
// Include the database connection file
include('database.php');

// Check if the 'id' parameter is set in the URL
if (isset($_GET['id'])) {
    $feedbackId = $_GET['id'];

    // Fetch feedback details based on the provided ID
    $query = "SELECT * FROM feedback_tbl WHERE feedback_id = $feedbackId";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $feedbackData = mysqli_fetch_assoc($result);
    } else {
        // Redirect or handle the case where the feedback is not found
        header("Location: feedback_history.php");
        exit();
    }
} else {
    // Redirect or handle the case where 'id' is not provided
    header("Location: feedback_history.php");
    exit();
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Feedback</title>
    <!-- Add your styles or include a CSS file if needed -->
</head>
<body>
    <h2>Edit Feedback</h2>
    <form action="update_feedback.php" method="post">
        <!-- Include the necessary input fields for editing -->
        <input type="hidden" name="feedback_id" value="<?php echo $feedbackData['feedback_id']; ?>">
        <label for="feedback_category">Feedback Category:</label>
        <input type="text" id="feedback_category" name="feedback_category" value="<?php echo $feedbackData['feedback_category']; ?>" required>

        <label for="feedback_text">Feedback Text:</label>
        <textarea id="feedback_text" name="feedback_text" rows="4" required><?php echo $feedbackData['feedback_text']; ?></textarea>

        <!-- Add other input fields as needed -->

        <button type="submit">Update Feedback</button>
    </form>
</body>
</html>
