<?php
// Database connection
include("database.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO course_tbl (course_name,  course_description, course_code, course_category, course_instructor, course_materials, course_prerequisites, course_fees) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssd", $courseName, $courseDescription, $courseCode, $courseCategory, $courseInstructor, $courseMaterials, $coursePrerequisites, $courseFees);

    // Set parameters and execute
    $courseName = $_POST['course_name'];
    $courseDescription = $_POST['course_description'];
    $courseCode = $_POST['course_code'];
    $courseCategory = $_POST['course_category'];
    $courseInstructor = $_POST['course_instructor'];
    $courseMaterials = $_POST['course_materials'];
    $coursePrerequisites = $_POST['course_prerequisites'];
    $courseFees = $_POST['course_fees'];

    $stmt->execute();

    // Close statement
    $stmt->close();

    // Redirect to the manage course page after submission
    header("Location: manage-course.php");
    exit();
}
$rowNumber = 1;

?>

<!-- manage-course.php -->
<!-- Your existing PHP code to display the list of courses -->

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
<script>
    function confirmDelete(id) {
        if (confirm("Are you sure you want to delete this course? The entire units under the course will also be deleted.")) {
            // AJAX call to the delete script
            fetch('page/delete_course.php?id=' + id)
                .then(response => {
                    if (response.ok) {
                        return response.text();
                    } else {
                        throw new Error('Network response was not ok.');
                    }
                })
                .then(data => {
                    alert('Successfully deleted course');
                    // Refresh the page after successful deletion
                    location.reload();
                })
                .catch(error => {
                    console.error('There has been a problem with your fetch operation:', error);
                });
        }
    }
</script>
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
                    <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="tableList">
                        <thead>
                            <tr>
                            <th class="text-left" >No</th>

                                <th class="text-left pl-4">Course Name</th>
                                <th class="text-left" >Description</th>
                                <th class="text-left">Code</th>
                                <th class="text-left" >Category</th>
                                <th class="text-left">Instructor</th>
                                <th class="text-left">Materials</th>
                                <th class="text-left">Prerequisites</th>
                                <th class="text-left">Fees</th>
                                <th class="text-center" width="20%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                                // Query to fetch all courses from the database
                                $result = $conn->query("SELECT * FROM `course_tbl` ORDER BY cou_id DESC" );

                                // Check if any courses are found
                                if ($result->num_rows > 0) {
                                    // Loop through each row and display the course details in a table row
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $rowNumber . ".)</td>"; // Display the row number

                                        echo "<td>" . $row['course_name'] . "</td>";
                                        echo "<td>" . $row['course_description'] . "</td>";
                                        echo "<td>" . $row['course_code'] . "</td>";
                                        echo "<td>" . $row['course_category'] . "</td>";
                                        echo "<td>" . $row['course_instructor'] . "</td>";
                                        echo "<td>" . $row['course_materials'] . "</td>";
                                        echo "<td>" . $row['course_prerequisites'] . "</td>";
                                        echo "<td>" . $row['course_fees'] . "</td>";

                                        echo "<td class='text-center'>
                                                <form method='POST' action='index.php?page=manage-course?id=".$row['cou_id']."'>
                                                    <div class='input-group mb-3'>
                                                        <input type='text' class='form-control' name='course_name' value='".$row['course_name']."' aria-label='Course Name' aria-describedby='button-addon2'>
                                                        <button class='btns btn-outline-secondary' type='submit' id='button-addon2'>Update Course</button>
                                                    </div>
                                                </form>
                                                <button class='btns btn-danger btn-sm' onclick='confirmDelete(".$row['cou_id'].")'>Delete Course</button>
                                              </td>";
                                        echo "</tr>";
                                        $rowNumber++;

                                    }
                                } else {
                                    // If no courses are found, display a message in a table row
                                    echo "<tr><td colspan='2'>No course found.</td></tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
