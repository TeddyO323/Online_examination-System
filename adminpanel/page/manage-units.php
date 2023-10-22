<style>
    /* Customize the appearance of the dropdown */
.custom-select {
    display: block;
    width: 30%;
    height: calc(2.25rem + 2px);
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #495057;
    vertical-align: middle;
    background: #fff;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

</style>
<?php
include("database.php");

// Check for delete requests
if(isset($_GET['delete_unit_id'])){
    $unit_id = $_GET['delete_unit_id'];
    $delete_query = $conn->query("DELETE FROM units_tbl WHERE unit_id='$unit_id'");

    if($delete_query === TRUE){
        echo "Unit deleted successfully.";
    } else {
        echo "Error deleting unit: " . $conn->error;
    }
}

// Check for edit submissions
if(isset($_POST['edit_unit_id'])){
    $unit_id = $_POST['edit_unit_id'];
    $unit_name = $_POST['unit_name'];
    $unit_code = $_POST['unit_code'];

    $update_query = $conn->query("UPDATE units_tbl SET unit_name='$unit_name', unit_code='$unit_code' WHERE unit_id='$unit_id'");

    if($update_query === TRUE){
        echo "Unit updated successfully.";
    } else {
        echo "Error updating unit: " . $conn->error;
    }
}

// Rest of your PHP and HTML code
// ...
?>

<?php
// Database connection
include("database.php");

// Query to get the list of courses
$coursesQuery = $conn->query("SELECT * FROM course_tbl ORDER BY cou_id DESC");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['course_name'])) {
    // Fetch units based on the selected course
    $selectedCourse = $_POST['course_name'];
    $unitsQuery = $conn->query("SELECT * FROM units_tbl WHERE course_name='$selectedCourse' ORDER BY unit_id DESC");
}

$rowNumber = 1;
?>

<head>
    <style>
        /* Custom CSS for button display */
        .btns {
            display: inline-block;
            width: 70px;
            height: 50px;
            text-align: center;
            border: gray;
            color: #fff;
            cursor: pointer;
            font-weight: bold;
        }
    </style>
</head>

<link rel="stylesheet" type="text/css" href="css/mycss.css">

<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div>MANAGE UNITS</div>
                </div>
            </div>
        </div>        
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-header">Unit List</div>
                <div class="table-responsive">
                    <form action="index.php?page=manage-units" method="post" id="courseForm">
    <label for="course_name">Select Course:</label><br>
    <select name="course_name" id="courseSelect" class="custom-select">
        <option value="" disabled selected>Select a course</option>
        <?php while ($row = $coursesQuery->fetch_assoc()) : ?>
            <option value="<?php echo $row['course_name']; ?>"><?php echo $row['course_name']; ?></option>
        <?php endwhile; ?>
    </select>
</form>

                    <h2>
                        <?php
                            if (isset($_POST['course_name'])) {
                                echo $_POST['course_name'] . " Units";
                            }
                        ?>
                    </h2>
                    <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="tableList">
                        <thead>
                            <tr>
                                <th class="text-left">No</th>
                                <th class="text-left pl-4">Unit Name</th>
                                <th class="text-left">Unit Code</th>
                                <th class="text-center" width="20%">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="unitList">
                            <!-- Your PHP code to display the list of units -->
<?php
if (isset($unitsQuery)) {
    if ($unitsQuery->num_rows > 0) {
        while ($row = $unitsQuery->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $rowNumber . ".)</td>";
            echo "<td>" . $row['unit_name'] . "</td>";
            echo "<td>" . $row['unit_code'] . "</td>";
            echo "<td class='text-center'>
            <button class='btns btn-outline-secondary' type='button' onclick='if (confirm(\"Are you sure you want to edit this unit?\")) editUnit(" . $row['unit_id'] . ")' style='background-color: #4CAF50;'>Edit</button>
            <button class='btns btn-danger btn-sm' onclick='if (confirm(\"Are you sure you want to delete this unit?\")) confirmDelete(" . $row['unit_id'] . ")'>Delete</button>
      </td>";
            echo "</tr>";
            $rowNumber++;
        }
    } else {
        echo "<tr><td colspan='4'>No units found for the selected course.</td></tr>";
    }
}
?>
    </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById("courseSelect").addEventListener("change", function() {
        document.getElementById("courseForm").submit();
    });
</script>
