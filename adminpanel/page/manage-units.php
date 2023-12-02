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
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
      
        .card {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            padding: 10px 15px;
            background-color: #4ef037;
            color: #fff;
            font-size: 18px;
            margin-bottom: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .btn {
            padding: 6px 12px;
            font-size: 14px;
            border: 1px solid transparent;
            border-radius: 4px;
        }
        .btn-primary {
            color: #fff;
            background-color: #4ef037;
            border-color: #4ef037;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

    select#courseSelect {
        width: 30%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        margin-bottom: 20px;
    }
    .edit-button {
        display: inline-block;
        padding: 10px 15px;
        background-color: #4ef037;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        text-align: center;
        text-decoration: none;
        font-size: 16px;
        margin-right: 10px;
    }

    .edit-button:hover {
        background-color: #45a049;
    }
   
    .edit-button,
    .delete-button {
        display: inline-block;
        padding: 8px 15px;
        border-radius: 4px;
        cursor: pointer;
        text-align: center;
        text-decoration: none;
        font-size: 16px;
        margin-right: 10px;
    }

    .edit-button {
        background-color: #4ef037;
        color: white;
    }

    .edit-button:hover {
        background-color: #45a049;
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
    <label for="course_name">Select Course:</label>
    <select name="course_name" id="courseSelect">
        <option value="" disabled selected>Select a course</option>
        <?php while ($row = $coursesQuery->fetch_assoc()) : ?>
            <option value="<?php echo $row['course_name']; ?>"><?php echo $row['course_name']; ?></option>
        <?php endwhile; ?>
    </select>
</form>
                    <?php if (isset($_POST['course_name'])) : ?>
                        <h2><?php echo $_POST['course_name'] . " Units"; ?></h2>
                    <?php endif; ?>
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
                                        <a class='edit-button' href='index.php?page=edit-unit&unit_id=" . $row['unit_id'] . "'>Edit</a>
                                        <button class='delete-button' onclick='deleteUnit(" . $row['unit_id'] . ")'>Delete</button>
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
<script>
    function deleteUnit(unitId) {
        if (confirm("Are you sure you want to delete this unit?")) {
            fetch('page/delete-unit.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'unit_id=' + unitId,
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

