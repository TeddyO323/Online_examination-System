<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div>MY UNITS</div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-header">Unit List</div>
                <div class="table-responsive">
                    <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="tableList">
                        <thead>
                            <tr>
                                <th class="text-left">No</th>
                                <th class="text-left pl-4">Unit Name</th>
                                <th class="text-left">Course Name</th>
                            </tr>
                        </thead>
                        <tbody id="unitList">
                            <!-- Your PHP code to display the list of units -->
                            <?php
                            include("database.php");

                            // Identify the currently logged-in examiner (you should set this in your login process)
                            $examinerNumber = $_SESSION['examiner_number'];

                            // Fetch units based on the currently logged-in examiner
                            $unitsQuery = $conn->query("SELECT * FROM exam_tbl WHERE examiner_number='$examinerNumber' ORDER BY ex_id DESC");

                            $rowNumber = 1;

                            if ($unitsQuery && $unitsQuery->num_rows > 0) {
                                while ($row = $unitsQuery->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $rowNumber . ".)</td>";
                                    echo "<td>" . $row['unit_name'] . "</td>";
                                    echo "<td>" . $row['course_name'] . "</td>";
                                    echo "</tr>";
                                    $rowNumber++;
                                }
                            } else {
                                echo "<tr><td colspan='4'>No units found for the examiner.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
