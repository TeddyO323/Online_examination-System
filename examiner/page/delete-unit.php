<?php
// Include the database connection
include("database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['unit_id'])) {
    $unitId = $_POST['unit_id'];

    // SQL query to delete the unit
    $deleteQuery = "DELETE FROM units_tbl WHERE unit_id = $unitId";

    if ($conn->query($deleteQuery) === TRUE) {
        echo "Unit deleted successfully";
    } else {
        echo "Error deleting unit: " . $conn->error;
    }
} else {
    echo "Invalid request";
}
?>
