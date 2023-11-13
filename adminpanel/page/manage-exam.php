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
            <div class="page-title-heading">
                <div>MANAGE EXAM</div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-header">ExAM List</div>
            <div class="table-responsive">
                <table class="align-middle mb-0 table table-bordered table-striped table-hover" id="tableList" style="width: 100%;">
                    <thead>
                        <tr>
                            <th class="text-center">Course</th>
                            <th class="text-center">Examiner Number</th>
                            <th class="text-center">Examiner Name</th>
                            <th class="text-center">Exam Title</th>
                            <th class="text-center">Description</th>
                            <th class="text-center">Time limit</th>
                            <th class="text-center">Display limit</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Replace this section with your server-side scripting language to fetch data from the database -->
                        <!-- Example: -->
                        <?php
                        include("database.php");
                        $examQuery = $conn->query("SELECT * FROM exam_tbl");

                        if ($examQuery->num_rows > 0) {
                            while ($row = $examQuery->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['course_name'] . "</td>";
                                echo "<td>" . (!empty($row['examiner_number']) ? $row['examiner_number'] : "No Examiner Number") . "</td>";
                                echo "<td>" . (!empty($row['examiner_name']) ? $row['examiner_name'] : "No Examiner Name") . "</td>";
                                echo "<td>" . $row['exam_title'] . "</td>";
                                echo "<td>" . $row['exam_description'] . "</td>";
                                echo "<td>" . $row['exam_time_limit'] . "</td>";
                                echo "<td>" . $row['exam_time_limit'] . "</td>";
                                echo "<td class='text-center'>";
                                echo "<button class='btn btn-danger' onclick='deleteExam(" . $row['ex_id'] . ")'>Delete</button>";
                                echo "<a href='index.php?page=add-questions&ex_id=" . $row['ex_id'] . "' class='btn btn-primary'>Manage</a>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='8'>No exams found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
