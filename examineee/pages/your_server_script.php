<?php
session_start();
// Include your database connection script
include('database.php');

if (isset($_GET['day']) && isset($_GET['month']) && isset($_GET['year'])) {
    $day = $_GET['day'];
    $month = $_GET['month'];
    $year = $_GET['year'];
    $regNo = $_SESSION['reg_no'];  // Assuming you have a session for the logged-in user

    // Query to fetch events for the specified day, month, year, and course
// Update your SQL query in your_server_script.php
$query = "SELECT ex_id, exam_title, exam_start_datetime, exam_end_datetime, 
                  exam_time_limit, exam_description, attempts_allowed
          FROM exam_tbl 
          INNER JOIN examinee_tbl ON exam_tbl.course_name = examinee_tbl.exmne_course
          WHERE DAY(exam_start_datetime) = $day 
            AND MONTH(exam_start_datetime) = $month
            AND YEAR(exam_start_datetime) = $year
            AND examinee_tbl.reg_no = '$regNo'";

$result = mysqli_query($conn, $query);

if ($result) {
    $events = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // Return the events in JSON format
    header('Content-Type: application/json');
    echo json_encode($events);
} else {
    // Handle database query error
    $error = mysqli_error($conn);
    echo json_encode(['error' => 'Error fetching events. ' . $error]);
}

} else {
    // Handle missing day, month, or year parameter
    echo json_encode(['error' => 'Day, month, or year parameter is missing']);
    
}

// Close the database connection
mysqli_close($conn);
?>
