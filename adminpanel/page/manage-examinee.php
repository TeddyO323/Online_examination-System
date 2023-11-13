<!DOCTYPE html>
<html lang="en">
<head>
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
            background-color: #007bff;
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
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
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
                            <th>Year level</th>
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
                                    echo "<tr>";
                                    echo "<td>".$selExmneRow['exmne_fullname']."</td>";
                                    echo "<td>".$selExmneRow['exmne_gender']."</td>";
                                    echo "<td>".$selExmneRow['exmne_birthdate']."</td>";
                                
                                    echo "<td>".$selExmneRow['exmne_course']."</td>";
                                    echo "<td>".$selExmneRow['exmne_year_level']."</td>";
                                    echo "<td>".$selExmneRow['exmne_email']."</td>";
                                    echo "<td>".$selExmneRow['exmne_password']."</td>";
                                    echo "<td>".$selExmneRow['contact_no']."</td>";
                                    echo "<td>".$selExmneRow['address']."</td>";
                                    echo "<td>".$selExmneRow['exmne_status']."</td>";
                                    echo "<td>";
                                    echo "<a href='index.php?page=edit_examinee&id=".$selExmneRow['exmne_id']."' class='btn btn-primary'>Edit</a>";
                                    echo " <button onclick=\"confirmDelete('".$selExmneRow['exmne_id']."')\" class='btn btn-danger'>Delete</a>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='11'><h3 class='p-3'>No Examinee Found</h3></td></tr>";
                            }
                            $conn = null;
                        ?>
                    </tbody>
                </table>
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

</body>
</html>