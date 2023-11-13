
<!doctype html>
<html lang="en">
<?php
// Start session
// Ensure that session is not started before
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in
if (!isset($_SESSION['reg_no'])) {
    header("Location: login.php");
    exit();
}
// Include the file containing the database connection details
require_once('database.php');

// Retrieve the examinee's name from the database based on the registration number
$reg_no = $_SESSION['reg_no'];
$sql = "SELECT exmne_fullname FROM examinee_tbl WHERE reg_no = '$reg_no'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $exmne_fullname = $row['exmne_fullname'];
} else {
    $exmne_fullname = "Examinee";
}
?>
<style>
    .welcome-message {
    font-size: 15px; /* Adjust the font size as needed */
    margin: 0; /* Reset margin if necessary */
}

</style>


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Examinee Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
     
    <!-- MAIN CSS NIYA -->
    <link href="./main.css" rel="stylesheet">
    <link href="css/sweetalert.css" rel="stylesheet">
    <link href="css/facebox.css" rel="stylesheet">
    <style>
        
    </style>
</head>

<body id="body">
    <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
        <div class="app-header header-shadow">
            <div class="app-header__logo">
                <div class="logo-srsc"><b style="margin-left: 2px;"></b></div>
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
            </div>    <div class="app-header__content">
                <div class="app-header-left">
                   
                          </div>
                <div class="app-header-right">
                    <div class="header-btn-lg pr-0">
                        <div class="widget-content p-0">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-left">
                                   <!-- Change the "Examiner" text to the dynamic examiner name -->
                                   <div class="btn-group">
    <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn">
            Welcome, <?php echo $exmne_fullname . " (" . $reg_no . ")"; ?>
        <i class="fa fa-angle-down ml-2 opacity-8"></i>
    </a>
    <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
        <button type="button" tabindex="0" class="dropdown-item">
            <a href="index.php?pages=examinee_info" style="text-decoration: none; color: #333;">My Account</a>
        </button>
        <a href="page/change-password.php" class="dropdown-item">Change Password</a>
        <div tabindex="-1" class="dropdown-divider"></div>
        <a href="query/logoutExe.php" class="dropdown-item">LOG OUT</a>
    </div>
</div>
                                </div>
                            </div>
                        </div>
                    </div>        </div>
            </div>
        </div> 
