<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
.scrollbar-sidebar {
  color: #fff; /* Text color */
  width: 250px; /* Set the width of the sidebar */
  padding: 20px; /* Add padding to the content inside the sidebar */
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); /* Add a box shadow for depth */
}

/* Optional: Add styles for scrollbar customization */
.scrollbar-sidebar {
  overflow-y: scroll;
  scrollbar-width: thin;
  scrollbar-color: #fff #7d2ae8; /* Change scrollbar colors */
}

/* Optional: Style for the links inside the sidebar */
.scrollbar-sidebar a {
  color: #fff;
  text-decoration: none;
  padding: 8px 0;
  display: block;
}

/* Optional: Hover effect for links */
.scrollbar-sidebar a:hover {
  background-color: #6320a8;
}


    </style>
</head>
<body>
<div class="app-sidebar sidebar-shadow">
                    <div class="app-header__logo">
                        <div class="logo-srca"></div>
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
                    </div>    <div class="scrollbar-sidebar">
                        <div class="app-sidebar__inner">
                            <ul class="vertical-nav-menu">
                                <li class="app-sidebar__heading"><a href="index.php">Dashboard</a></li>

                                <li class="app-sidebar__heading">MANAGE COURSE</li>
                                <li>
                                    <a href="#">
                                         <i class="metismenu-icon pe-7s-display2"></i>
                                         Course
                                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                    </a>
                                    <ul>
                                        <li>
                                            <a href="index.php?page=add_course" data-toggle="modal" data-target="" name = add_course>
                                                <i class="metismenu-icon"></i>
                                                Add Course
                                            </a>
                                        </li>
                                        <li>
                                            <a href="index.php?page=manage-course">
                                                <i class="metismenu-icon">
                                                </i>Manage Course
                                            </a>
                                        </li>
                                       
                                    </ul>
                                </li>
                            
                                <li class="app-sidebar__heading">MANAGE EXAM</li>
                                <li>
                                    <a href="#">
                                         <i class="metismenu-icon pe-7s-display2"></i>
                                         Exam
                                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                    </a>
                                    <ul>
                                        <li>
                                            <a href="index.php?page=add-exam" data-toggle="modal" data-target="">
                                                <i class="metismenu-icon"></i>
                                                Add Exam
                                            </a>
                                        </li>
                                        <li>
                                            <a href="index.php?page=manage-exam">
                                                <i class="metismenu-icon">
                                                </i>Manage Exam
                                            </a>
                                        </li>
                                        <li>
                                            <a href="index.php?page=mark-exam" data-toggle="modal" data-target="">
                                                <i class="metismenu-icon"></i>
                                                Mark Exams
                                            </a>
                                        </li>
                                        <li>
                                            <a href="index.php?page=question-bank" data-toggle="modal" data-target="">
                                                <i class="metismenu-icon"></i>
                                               Question Bank
                                            </a>
                                        </li>
                                    
                                       
                                    </ul>
                                </li>
                           
            
                                <li class="app-sidebar__heading">REPORTS</li>
                                <li>
                                    <a href="index.php?page=examinee-result">
                                        <i class="metismenu-icon pe-7s-cup">
                                        </i>examiner Result
                                    </a>
                                </li>
                              

                                 <li class="app-sidebar__heading">FEEDBACKS</li>
                                <li>
                                    <a href="index.php?page=feedbacks">
                                        <i class="metismenu-icon pe-7s-chat">
                                        </i>All Feedbacks
                                    </a>
                                </li>
                                
                            </ul>
                        </div>
                    </div>
                </div>  

</body>
</html>
