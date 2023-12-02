
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
    </style>
<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div>MANAGE EXAMINER</div>
                </div>
            </div>
        </div>
        
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-header">Examiner List
                </div>
                <div class="table-responsive">
                    <table class="align-middle mb-0 table table-bordered table-striped table-hover" id="tableList" style="width: 100%;">
                        <thead>
                            <tr>
                                <th class="text-center">Examiner Number</th>
                                <th class="text-center">Examiner Name</th>
                                <th class="text-center">Examiner Email</th>
                                <th class="text-center">Examiner Password</th>
                                <th class="text-center">Contact Number</th>
                                <th class="text-center">Address</th>
                                <th class="text-center">Department</th>
                                <th class="text-center">Role</th>
                                <th class="text-center">Access Level</th>
                                <th class="text-center">Specialization</th>
                                <th class="text-center">Date of Birth</th>
                                <th class="text-center">Joining Date</th>
                                <th class="text-center">Certification</th>
                                <th class="text-center">Notes</th>
                                <th class="text-center">Gender</th>
                                <!-- <th class='text-center'>Last Login</th> -->
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Include the file for database connection
                            include 'database.php';

                            // Fetch data from the database
                            $sql = "SELECT * FROM examiner_tbl";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td class='text-center'>" . $row["examiner_number"] . "</td>";
                                    echo "<td class='text-center'>" . $row["examiner_name"] . "</td>";
                                    echo "<td class='text-center'>" . $row["examiner_email"] . "</td>";
                                    echo "<td class='text-center'>" . $row["examiner_password"] . "</td>";
                                    echo "<td class='text-center'>" . $row["contact_number"] . "</td>";
                                    echo "<td class='text-center'>" . $row["address"] . "</td>";
                                    echo "<td class='text-center'>" . $row["department"] . "</td>";
                                    echo "<td class='text-center'>" . $row["role"] . "</td>";
                                    echo "<td class='text-center'>" . $row["access_level"] . "</td>";
                                    echo "<td class='text-center'>" . $row["specialization"] . "</td>";
                                    echo "<td class='text-center'>" . $row["date_of_birth"] . "</td>";
                                    echo "<td class='text-center'>" . $row["joining_date"] . "</td>";
                                    echo "<td class='text-center'>" . $row["certification"] . "</td>";
                                    echo "<td class='text-center'>" . $row["notes"] . "</td>";
                                    echo "<td class='text-center'>" . $row["gender"] . "</td>";
                                    // echo "<td>".($row['last_login'] ? $row['last_login'] : "Never")."</td>";

                                    echo "<td class='text-center'>
                                    <a href='index.php?page=edit-examiner&id=".$row['examiner_number']."' class='btn btn-primary'>Edit</a>
                                    <a href='page/delete-examiner.php?id=".$row['examiner_number']."' class='btn btn-danger'>Delete</a>
                                    
                                    </td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='16'>No examiners found</td></tr>";
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

<?php
// Include the file for database connection
include 'database.php';

if (isset($_GET['id'])) {
    $examinerNumber = $_GET['id'];
    // Delete the examiner based on the provided ID
    $sql = "DELETE FROM examiner_tbl WHERE examiner_number = $examinerNumber";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Examiner deleted successfully');</script>";
    } else {
        echo "Error deleting examiner: " . $conn->error;
    }
} 
// Close the database connection
$conn->close();
?>
