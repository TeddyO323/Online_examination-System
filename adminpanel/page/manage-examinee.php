<!DOCTYPE html>
<html lang="en">
<head>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            margin-bottom: 10px; /* Adjust the margin as needed */

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
        .btn-danger {
            color: #fff;
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }
        .suspended-row {
        background-color: #ff6666; /* Red background for suspended rows */
    }

    </style>
</head>
<body>
    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="app-page-title">
                <div class="page-title-wrapper">
                    <div class="page-title-heading">
                        <div class="app-page-title">MANAGE EXAMINEE</div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="main-card card">
                    <div class="card-header">Examinee List</div>
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>Fullname</th>
                                    <th>Gender</th>
                                    <th>Birthdate</th>
                                    <th>Course</th>
                                    <th>Email</th>
                                    <th>Password</th>
                                    <th>Contact Number</th>
                                    <th>Address</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                // Include the database connection
                                include 'database.php';
                                $selExmne = $conn->query("SELECT * FROM examinee_tbl ORDER BY exmne_id DESC ");
                                if($selExmne->num_rows > 0) {
                                    while ($selExmneRow = $selExmne->fetch_assoc()) { 
                                            // Check if the account is suspended
                                            $isSuspended = ($selExmneRow['exmne_status'] === 'suspended');
                                        
                                            // Add a class based on suspension status
                                            $rowClass = $isSuspended ? 'suspended-row' : '';
                                        $rowClass = $isSuspended ? 'suspended-row' : '';

                                        echo "<tr class='$rowClass'>";
                                        echo "<td>".$selExmneRow['exmne_fullname']."</td>";
                                        echo "<td>".$selExmneRow['exmne_gender']."</td>";
                                        echo "<td>".$selExmneRow['exmne_birthdate']."</td>";
                                        echo "<td>".$selExmneRow['exmne_course']."</td>";
                                        echo "<td>".$selExmneRow['exmne_email']."</td>";
                                        echo "<td>".$selExmneRow['exmne_password']."</td>";
                                        echo "<td>".$selExmneRow['contact_no']."</td>";
                                        echo "<td>".$selExmneRow['address']."</td>";
                                        echo "<td>".$selExmneRow['exmne_status']."</td>";
                                        echo "<td>";
                                        echo "<a href='index.php?page=edit_examinee&id=".$selExmneRow['exmne_id']."' class='btn btn-primary'>Edit</a>";
                                        echo " <button onclick=\"confirmDelete('".$selExmneRow['exmne_id']."')\" class='btn btn-danger'>Delete</button>";
                                     
                                        if ($isSuspended) {
                                            echo "<button onclick=\"restoreAccount('".$selExmneRow['exmne_id']."')\" class='btn btn-success'>Restore Account</button>";
                                        } else {
                                            echo "<a href='page/suspend-account.php?id=".$selExmneRow['exmne_id']."&name=".urlencode($selExmneRow['exmne_fullname'])."&reg_number=".urlencode($selExmneRow['reg_no'])."' class='btn btn-warning'>Suspend Account</a>";
                                        }
                                        
                                        echo "</td>";
                                      
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='12'><h3 class='p-3'>No Examinee Found</h3></td></tr>";
                                }
                                $conn = null;
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
            if (confirm("Are you sure you want to delete the examinee?")) {
                window.location.href = 'page/delete-examinee.php?id=' + id;
            }
        }
    </script>
       <script>
        function confirmDelete(id) {
            if (confirm("Are you sure you want to delete the examinee?")) {
                window.location.href = 'page/delete-examinee.php?id=' + id;
            }
        }

        function suspendAccount(userId) {
    window.location.href = 'page/suspend-account.php?id=' + userId;
}

    </script>

    <!-- Add this JavaScript function -->
<script>
    function restoreAccount(examineeId) {
        if (confirm("Are you sure you want to restore the examinee's account?")) {
            // Make an AJAX request to restore-account.php
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'page/restore-account.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                if (xhr.status >= 200 && xhr.status < 300) {
                    // Successful restoration
                    alert(xhr.responseText);
                    // Optionally, you can reload the page or update the UI
                    location.reload();
                } else {
                    // Error during restoration
                    alert('Error restoring account. Please try again.');
                }
            };
            xhr.send('examineeId=' + encodeURIComponent(examineeId));
        }
    }
</script>

</body>
</html>
