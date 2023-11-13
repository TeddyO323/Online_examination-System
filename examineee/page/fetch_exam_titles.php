<?php
// Fetch_exam_titles.php
include("database.php");


$course_name = $_POST['course_name'];

$sql = "SELECT exam_title FROM exam_tbl WHERE course_name = '$course_name'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<option value='" . $row['exam_title'] . "'>" . $row['exam_title'] . "</option>";
    }
} else {
    echo "<option value=''>No exams found</option>";
}

$conn->close();
?>
