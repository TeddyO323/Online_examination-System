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
                        <?php
                                include("database.php");

                            $sql = "SELECT * FROM exam_tbl WHERE examiner_number = '$examinerNumber'";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row['course_name'] . "</td>";
                                    echo "<td>" . $row['examiner_number'] . "</td>";
                                    echo "<td>" . $row['examiner_name'] . "</td>";
                                    echo "<td>" . $row['exam_title'] . "</td>";
                                    echo "<td>" . $row['exam_description'] . "</td>";
                                    echo "<td>" . $row['exam_time_limit'] . "</td>";
                                    echo "<td>" . $row['exam_time_limit'] . "</td>";
                                    echo "<td class='text-center'>";
                                    echo "<a href='index.php?page=add-questions&ex_id=" . $row['ex_id'] . "' class='btn btn-primary'>Manage</a>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='8' class='text-center'>No exams found</td></tr>";
                            }
                        ?>
                        <!-- Additional rows can be added here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
