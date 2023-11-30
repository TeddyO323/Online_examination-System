<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}// Rest of your code...
// Check if the user is logged in, if not, redirect to the login page
if (!isset($_SESSION['reg_no'])) {
    header("Location: login.php");
    exit();
}

require_once('database.php');
?>
<?php include("includes/header.php"); ?>      

<?php include("includes/ui-theme.php"); ?>

<div class="app-main">
<?php include("includes/sidebar.php"); ?>

<a href=""></a>


<?php 
   @$page = $_GET['pages'];


   if($page != '')
   {
     if($page == "instructions")
     {
       include("pages/instructions.php");
     }
     else if($page == "result")
     {
       include("pages/result.php");
     }
     else if($page == "examinee_info")
     {
       include("pages/examinee_info.php");
     }
     else if($page == "myscores")
     {
       include("pages/myscores.php");
     }
     else if($page == "edit_examinee_info")
     {
       include("pages/edit_examinee_info.php");
     }
     else if($page == "feedbacks")
     {
       include("pages/feedbacks.php");
     }
     else if($page == "feedback_history")
     {
       include("pages/feedback_history.php");
     }
     
   }
  
   else
   {
     include("pages/home.php"); 
   }


 ?> 


<?php include("includes/footer.php"); ?>

<?php include("includes/modals.php"); ?>


