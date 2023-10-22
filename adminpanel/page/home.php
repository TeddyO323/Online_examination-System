

<div class="app-main__outer">
    <div id="refreshData">
    <div class="app-main__inner">
            <div class="app-page-title">
         
                <div class="page-title-wrapper">
                    <div class="page-title-heading">
                    
                        <div>Welcome to Online Examenation Admin Panel
                        </div>
                    </div>
                    <div class="page-title-actions">
                       
                        
                    </div>   
                 </div>
            </div>            <div class="row">
                <div class="col-md-6 col-xl-4">
                    <div class="card mb-3 widget-content bg-midnight-bloom">
                        <div class="widget-content-wrapper text-white">
                            <div class="widget-content-left">
                                <div class="widget-heading">Total Course</div>
                                <div class="widget-subheading" style="color:transparent;">.</div>
                            </div>
                            <div class="widget-content-right">
                                <div class="widget-numbers text-white">
                                    <span><?php
// Assuming $conn is your mysqli connection

// Query to count the number of courses
$result = $conn->query("SELECT COUNT(*) as totalCourses FROM course_tbl");

// Check if the query was successful
if ($result) {
    // Fetch the row as an associative array
    $row = $result->fetch_assoc();

    // Retrieve the total number of courses
    $totalCourses = $row['totalCourses'];
} else {
    // If the query fails, set the total number of courses to 0
    $totalCourses = 0;
}

// Display the total number of courses
echo  $totalCourses;
?>
</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4">
                    <div class="card mb-3 widget-content bg-arielle-smile">
                        <div class="widget-content-wrapper text-white">
                            <div class="widget-content-left">
                                <div class="widget-heading">Total Exam</div>
                                <div class="widget-subheading" style="color:transparent;">.</div>
                            </div>
                            <div class="widget-content-right">
                                <div class="widget-numbers text-white">
                                    <span><?php
// Assuming $conn is your mysqli connection

// Query to count the number of exams
$result = $conn->query("SELECT COUNT(*) as totalExams FROM exam_tbl");

// Check if the query was successful
if ($result) {
    // Fetch the row as an associative array
    $row = $result->fetch_assoc();

    // Retrieve the total number of exams
    $totExam = $row['totalExams'];
} else {
    // If the query fails, set the total number of exams to 0
    $totExam = 0;
}

// Display the total number of exams
echo $totExam;
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
                                <div class="widget-heading">Total Examinee</div>
                                <div class="widget-subheading" style="color:transparent;">.</div>
                            </div>
                            <div class="widget-content-right">
                                <div class="widget-numbers text-white"><span>46%</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-xl-none d-lg-block col-md-6 col-xl-4">
                    <div class="card mb-3 widget-content bg-premium-dark">
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
