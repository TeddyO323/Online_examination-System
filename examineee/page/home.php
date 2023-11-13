<div class="app-main__outer">
    <div id="refreshData">
        <div class="app-main__inner">
            <div class="app-page-title">
                <div class="page-title-wrapper">
                    <div class="page-title-heading">
                        <div>Welcome to Online Examination Examiner's Panel</div>
                    </div>
                    <div class="page-title-actions">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-xl-4">
                    <div class="card mb-3 widget-content bg-midnight-bloom">
                        <div class="widget-content-wrapper text-white">
                            <div class="widget-content-left">
                                <div class="widget-heading">Total Units</div>
                                <div class="widget-subheading" style="color: transparent;">.</div>
                            </div>
                            <div class="widget-content-right">
                                <div class="widget-numbers text-white">
                                    <span>
                                        <?php
                                            $sql = "SELECT COUNT(unit_name) AS total_units FROM exam_tbl WHERE examiner_number = '$examinerNumber'";
                                            $result = $conn->query($sql);
                                            $row = $result->fetch_assoc();
                                            echo $row['total_units'];
                                        ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- The rest of your code remains unchanged -->
   
                <div class="col-md-6 col-xl-4">
    <div class="card mb-3 widget-content bg-arielle-smile">
        <div class="widget-content-wrapper text-white">
            <div class="widget-content-left">
                <div class="widget-heading">Total Exam</div>
                <div class="widget-subheading" style="color: transparent;">.</div>
            </div>
            <div class="widget-content-right">
                <div class="widget-numbers text-white">
                    <span>
                        <?php
                            $sql = "SELECT COUNT(exam_title) AS total_exams FROM exam_tbl WHERE examiner_number = '$examinerNumber'";
                            $result = $conn->query($sql);
                            $row = $result->fetch_assoc();
                            echo $row['total_exams'];
                        ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

                <div class="col-md-6 col-xl-4">
                    <div class="card mb-3 widget-content bg-grow-early">
                        <div class="widget-content-wrapper text-white">
                            <div class="widget-content-left">
                                <div class="widget-heading">Total Examiners</div>
                                <div class="widget-subheading" style="color: transparent;">.</div>
                            </div>
                            <div class="widget-content-right">
                                <div class="widget-numbers text-white">
                                    <span>20</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-xl-none d-lg-block col-md-6 col-xl-4">
                    <div class="card mb-3 widget-content bg-grow-early">
                        <div class="widget-content-wrapper text-white">
                            <div class="widget-content-left">
                                <div class="widget-heading">Products Sold</div>
                                <div class="widget-subheading">Revenue streams</div>
                            </div>
                            <div class="widget-content-right">
                                <div class="widget-numbers text-warning"><span>$14M</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
