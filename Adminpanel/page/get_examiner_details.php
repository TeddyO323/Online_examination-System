<?php
// Include your database connection file
include("database.php");

if (isset($_GET['examiner_number'])) {
    $examinerNumber = $_GET['examiner_number'];

    // Query to get examiner details based on the examiner number
    $examinerDetailsQuery = "SELECT examiner_name FROM examiner_tbl WHERE examiner_number = '$examinerNumber' ORDER BY examiner_id DESC";
    $examinerDetailsResult = $conn->query($examinerDetailsQuery);

    if ($examinerDetailsResult->num_rows > 0) {
        $data = $examinerDetailsResult->fetch_assoc();
        echo json_encode($data);
    } else {
        echo json_encode(['examiner_name' => 'No Examiner Name Found']);
    }
}
?>
