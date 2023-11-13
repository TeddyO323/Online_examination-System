<?php
    // Include the database connection
    include 'database.php';

    if (isset($_GET['id'])) {
        $exmne_id = $_GET['id'];

        // Prepare and bind the SQL statement to delete the examinee
        $stmt = $conn->prepare("DELETE FROM examinee_tbl WHERE exmne_id = ?");
        $stmt->bind_param("i", $exmne_id);

        // Execute the statement
        if ($stmt->execute()) {
            // Examinee deleted successfully
            echo "Examinee deleted successfully.";
        } else {
            // Error in deleting examinee
            echo "Error: " . $stmt->error;
        }

        // Close the statement and the connection
        $stmt->close();
        $conn->close();
    }
?>
