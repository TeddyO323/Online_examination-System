<?php
// Include the file for database connection
include 'database.php';

if (isset($_GET['id'])) {
    $examinerNumber = $_GET['id'];
    // Delete the examiner based on the provided ID
    $sql = "DELETE FROM examiner_tbl WHERE examiner_number = $examinerNumber";

    if ($conn->query($sql) === TRUE) {

        echo "<script>alert('Are you sure you want to delete examiner?');</script>";
    } else
        
        echo "<script>alert('Examiner deleted successfully');</script>";
    } else {
        echo "Error deleting examiner: " . $conn->error;
    }
 
// Close the database connection
$conn->close();
?>