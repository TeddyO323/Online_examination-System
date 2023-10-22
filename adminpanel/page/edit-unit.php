<?php
include("database.php");

if (isset($_POST['edit_unit_id'])) {
    $unit_id = $_POST['edit_unit_id'];
    $unit_name = $_POST['unit_name'];
    $unit_code = $_POST['unit_code'];

    $update_query = $conn->query("UPDATE units_tbl SET unit_name='$unit_name', unit_code='$unit_code' WHERE unit_id='$unit_id'");

    if ($update_query === TRUE) {
        echo "Unit updated successfully.";
    } else {
        echo "Error updating unit: " . $conn->error;
    }
}
?>
