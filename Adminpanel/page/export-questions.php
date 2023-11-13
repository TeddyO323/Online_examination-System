<?php
// Include database connection
include 'database.php';

if (isset($_POST['exam_id'])) {
    $exId = $_POST['exam_id'];

    // Retrieve data from the database
    $questionQuery = "SELECT * FROM exam_question_tbl WHERE ex_id = $exId";
    $result = $conn->query($questionQuery);

    if ($result && $result->num_rows > 0) {
        $filename = "export_questions.csv"; // Name the CSV file

        // Set appropriate headers for the CSV file
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'w');

        // Output the CSV column headers
        fputcsv($output, array('Question', 'Choice 1', 'Choice 2', 'Choice 3', 'Choice 4', 'Answer'));

        // Output the data to the CSV file
        while ($row = $result->fetch_assoc()) {
            fputcsv($output, array($row['exam_question'], $row['exam_ch1'], $row['exam_ch2'], $row['exam_ch3'], $row['exam_ch4'], $row['exam_answer']));
        }

        fclose($output);
    } else {
        echo "No questions found for the selected exam.";
    }
}
?>
