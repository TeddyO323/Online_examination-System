<?php
// Database connection
include("database.php");

if (isset($_GET['course'])) {
    $selectedCourse = $_GET['course'];

    // Fetch units based on the selected course
    $unitsQuery = $conn->query("SELECT * FROM units_tbl WHERE course_name='$selectedCourse' ORDER BY unit_id DESC");
    $units = [];

    while ($row = $unitsQuery->fetch_assoc()) {
        $units[] = $row;
    }

    if (empty($units)) {
        // Return a JSON array with an error message if no units are found for the course
        echo json_encode([['unit_name' => 'No exam found for the course']]);
    } else {
        // Return the list of units as a JSON array
        echo json_encode($units);
    }
} else {
    // Return an empty JSON array if no course is selected
    echo json_encode([]);
}
?>
