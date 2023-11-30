<?php
// Include the database connection
include 'database.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $examineeId = isset($_POST['examineeId']) ? $_POST['examineeId'] : '';

// Check if there is an existing suspension
$existingSuspensionQuery = $conn->prepare("SELECT COUNT(*) AS suspensionCount FROM suspended_examinee_accounts_tbl WHERE examinee_id = ?");
$existingSuspensionQuery->bind_param('s', $examineeId);
$existingSuspensionQuery->execute();
$existingSuspensionResult = $existingSuspensionQuery->get_result();
$existingSuspensionData = $existingSuspensionResult->fetch_assoc();

if ($existingSuspensionData['suspensionCount'] > 0) {
    echo 'Error: Account is already suspended.';
    exit();
}

        $examineeId = $_POST['examineeId'];
        $suspensionDuration = $_POST['duration'];
        $suspensionType = $_POST['suspensionType'];
        $reasonForSuspension = $_POST['reason'];

        // Fetch user_fullname from examinee_tbl
        $fetchUserDataQuery = $conn->prepare("SELECT exmne_fullname FROM examinee_tbl WHERE exmne_id = ?");
        $fetchUserDataQuery->bind_param("i", $examineeId);
        $fetchUserDataQuery->execute();
        $fetchUserDataQuery->bind_result($examineeName);
        $fetchUserDataQuery->fetch();
        $fetchUserDataQuery->close();

        // Insert suspension data into suspended_examinee_accounts_tbl
        $dateOfSuspension = date('Y-m-d H:i:s'); // Get current date and time
        $insertSuspendQuery = $conn->prepare("INSERT INTO suspended_examinee_accounts_tbl (examinee_id, user_fullname, suspension_duration, suspension_type, reason_for_suspension, date_of_suspension) VALUES (?, ?, ?, ?, ?, ?)");
        $insertSuspendQuery->bind_param("isssis", $examineeId, $examineeName, $suspensionDuration, $suspensionType, $reasonForSuspension, $dateOfSuspension);

        if ($insertSuspendQuery->execute()) {
            // Update exmne_status to 'suspended' in examinee_tbl
            $updateStatusQuery = $conn->prepare("UPDATE examinee_tbl SET exmne_status = 'suspended' WHERE exmne_id = ?");
            $updateStatusQuery->bind_param("i", $examineeId);
            $updateStatusQuery->execute();
            $updateStatusQuery->close();

            echo "Account suspended successfully!";
        } else {
            echo "Error preparing suspension data. Please try again.";
        }

        $insertSuspendQuery->close();

    } elseif (isset($_POST['examinerId'], $_POST['duration'], $_POST['suspensionType'], $_POST['reason'])) {
        // Process suspension for examiners
        // Similar logic as above, but fetch data from examiner_tbl and insert into suspended_examiner_accounts_tbl
        // ...

    } else {
        // If any required field is not set, display an error message
        echo "Incomplete form data. Please fill in all required fields.";
    }


// Close the database connection
$conn->close();
?>
