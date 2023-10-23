<?php
// Database connection
include("database.php");

// Fetch data from exam_tbl
$examQuery = $conn->query("SELECT * FROM exam_tbl");
?>
<?php
// Database connection
include("database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET['action']) && $_GET['action'] === 'delete_exam') {
    $examId = $_POST['exam_id']; // Assuming the exam_id is sent via POST

    // Perform the deletion query here
    $deleteQuery = "DELETE FROM exam_tbl WHERE ex_id = $examId";

    if ($conn->query($deleteQuery) === TRUE) {
        echo "Successfully deleted exam";
    } else {
        echo "Error: " . $deleteQuery . "<br>" . $conn->error;
    }

    // Prevent further execution of the page
    exit();
}
?>


<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-heading">
                <div>MANAGE EXAM</div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-header">ExAM List</div>
            <div class="table-responsive">
                <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="tableList">
                    <thead>
                        <tr>
                            <th class="text-left ">Course</th>
                            <th class="text-left pl-4">Exam Title</th>
                            <th class="text-left ">Description</th>
                            <th class="text-left ">Time limit</th>
                            <th class="text-left ">Display limit</th>
                            <th class="text-center" width="20%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Display the data from the database
                        if ($examQuery->num_rows > 0) {
                            while ($row = $examQuery->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['unit_name'] . "</td>";
                                echo "<td>" . $row['exam_title'] . "</td>";
                                echo "<td>" . $row['exam_description'] . "</td>";
                                echo "<td>" . $row['exam_time_limit'] . "</td>";
                                echo "<td>" . $row['num_of_questions'] . "</td>";
                                echo "<td class='text-center'>";
                                echo "<button class='btn btn-danger' onclick='deleteExam(" . $row['ex_id'] . ")'>Delete</button>";
                                echo "<a href='index.php?page=add-questions&ex_id=" . $row['ex_id'] . "' class='btn btn-primary'>Manage</a>";

                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>No exams found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<script>
    function deleteExam(examId) {
        if (confirm("Are you sure you want to delete this exam?")) {
            // Perform the AJAX call for deleting the exam
            fetch('manage-exam.php?action=delete_exam', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'exam_id=' + examId,
            })
            .then(response => response.text())
            .then(data => {
                alert(data); // Display the response message from the server
                // Reload the page or perform any necessary actions after successful deletion
                location.reload();
            });
        }
    }
</script>
