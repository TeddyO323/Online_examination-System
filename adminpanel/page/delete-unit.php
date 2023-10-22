<?php
// Include the database connection
include("database.php");

// Check if the 'id' parameter is set and not empty
if(isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    // Delete Query
    $deleteQuery = "DELETE FROM units_tbl WHERE unit_id = $id";

    // Execute the delete query
    if (mysqli_query($conn, $deleteQuery)) {
        // Redirect to the desired page after the operation is completed
        header("Location: manage-units.php");
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
} else {
    // Handle the case when the ID is not provided
    echo "Invalid request!";
}
?>
