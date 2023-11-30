<?php
include 'database.php';

// Get POST data
$examineeId = isset($_POST['examineeId']) ? $_POST['examineeId'] : '';

// Delete from Suspended Table
$deleteSuspensionQuery = $conn->prepare("DELETE FROM suspended_examinee_accounts_tbl WHERE examinee_id = ?");
$deleteSuspensionQuery->bind_param('s', $examineeId);
$deleteSuspensionResult = $deleteSuspensionQuery->execute();

if ($deleteSuspensionResult) {
    // Update Examinee Status
    $updateStatusQuery = $conn->prepare("UPDATE examinee_tbl SET exmne_status = 'active' WHERE exmne_id = ?");
    $updateStatusQuery->bind_param('s', $examineeId);
    $updateStatusResult = $updateStatusQuery->execute();

    if ($updateStatusResult) {
        echo 'Account restored successfully.';
    } else {
        echo 'Error updating examinee status.';
    }
} else {
    echo 'Error deleting from suspended table.';
}

$conn->close();
?>
