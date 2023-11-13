<style>
    .action-button {
        display: inline-block;
        padding: 8px 12px;
        border: 1px solid #ccc;
        border-radius: 4px;
        text-decoration: none;
        margin-right: 5px;
    }

    .action-button:hover {
        background-color: #f0f0f0;
    }

    .delete-button {
        color: #fff;
        background-color: #dc3545;
        border-color: #dc3545;
    }

    .delete-button:hover {
        background-color: #c82333;
        border-color: #bd2130;
    }
</style>


<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div>MANAGE COURSE</div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-header">Course List</div>
                <div class="table-responsive">
                    <table class="align-middle mb-0 table table-bordered table-striped table-hover" id="tableList" style="width: 100%;">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Course Name</th>
                                <th class="text-center">Description</th>
                                <th class="text-center">Code</th>
                                <th class="text-center">Category</th>
                                <!-- <th class="text-center">Instructor</th> -->
                                <th class="text-center">Materials</th>
                                <th class="text-center">Prerequisites</th>
                                <th class="text-center">Fees</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Include the database connection file
                            include("database.php");

                            $rowNumber = 1;

                            // Query to fetch data from the database
                            $sql = "SELECT * FROM course_tbl";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                // Output data of each row
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $rowNumber . "</td>";
                                    echo "<td>" . $row['course_name'] . "</td>";
                                    echo "<td>" . $row['course_description'] . "</td>";
                                    echo "<td>" . $row['course_code'] . "</td>";
                                    echo "<td>" . $row['course_category'] . "</td>";
                                    // echo "<td>" . $row['course_instructor'] . "</td>";
                                    echo "<td>" . $row['course_materials'] . "</td>";
                                    echo "<td>" . $row['course_prerequisites'] . "</td>";
                                    echo "<td>" . $row['course_fees'] . "</td>";
                                    echo "<td>
                                    <a class='action-button' href='index.php?page=edit-course&id=".$row['cou_id']."'>Edit</a>
                                    <a class='action-button delete-button' onclick='confirmDelete(".$row['cou_id'].")'>Delete</a>
                                </td>";
                               
                                
                                    echo "</tr>";
                                    $rowNumber++;
                                }
                            } else {
                                echo "<tr><td colspan='10'>0 results</td></tr>";
                            }
                            $conn->close();
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function confirmDelete(id) {
        var confirmation = confirm("Are you sure you want to delete this course? The entire units under this course will also be deleted.");
        if (confirmation) {
            // AJAX call to the delete script
            window.location.href = 'index.php?page=manage-course&id=' + id + '&confirm=true';
        }
    }
</script>

<?php
// Include the database connection file
include("database.php");

// Check if the 'id' parameter is set in the URL
if (isset($_GET['id']) && isset($_GET['confirm']) && $_GET['confirm'] === 'true') {
    // Retrieve the course ID from the URL
    $courseId = $_GET['id'];

    // SQL query to delete the course with the given ID
    $sql = "DELETE FROM course_tbl WHERE cou_id = $courseId";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Successfully deleted course');</script>";
    } else {
        echo "<script>alert('Error deleting course: ".$conn->error."');</script>";
    }
}

// Close the database connection
$conn->close();
?>
