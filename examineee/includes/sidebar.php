<div class="app-sidebar sidebar-shadow">
    <div class="app-header__logo">
        <div class="logo-srcs"></div>
        <div class="header__pane ml-auto">
            <div>
                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <div class="app-header__mobile-menu">
        <div>
            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>
        </div>
    </div>
    <div class="app-header__menu">
        <span>
            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                <span class="btn-icon-wrapper">
                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                </span>
            </button>
        </span>
    </div>
    <?php
// Include the file containing the database connection details
require_once('database.php');

// Fetch the examinee's course from the database based on the registration number
$reg_no = $_SESSION['reg_no'];
$examineeCourseQuery = $conn->query("SELECT exmne_course FROM examinee_tbl WHERE reg_no='$reg_no'");
$examineeCourseRow = $examineeCourseQuery->fetch_assoc();

// Fetch the available exams for the specific course
$examineeCourse = $examineeCourseRow['exmne_course'];
$availableExamsQuery = $conn->query("SELECT * FROM exam_tbl WHERE course_name='$examineeCourse'");

?>

<div class="scrollbar-sidebar">
    <div class="app-sidebar__inner">
        <ul class="vertical-nav-menu">
            <li class="app-sidebar__heading">AVAILABLE EXAM'S</li>
            <li>
                <a href="#">
                    <i class="metismenu-icon pe-7s-display2"></i>
                    All Exam's
                    <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                </a>
                <ul>
                <?php
    while ($exam = $availableExamsQuery->fetch_assoc()) {
        echo '<li>';
        echo '<a href="index.php?pages=instructions&exam_id=' . $exam['ex_id'] . '">' . $exam['exam_title'] . '</a>';
        echo '</li>';
    }
?>

                </ul>
            </li>
      

                <li class="app-sidebar__heading">TAKEN EXAM</li>
                <li>
                    <a href="#">
                        <!-- Add taken exams here if any -->
                    </a>
                </li>
                <li class="app-sidebar__heading">FEEDBACKS</li>
                <li>
                    <a href="#" data-toggle="modal" data-target="#feedbacksModal">
                        Add Feedbacks
                    </a>
                </li>
            </ul>
        </div>
    </div>
    
</div>
