<?php
session_start();
if (!isset($_SESSION["user"])) {
   header("Location: login.php");
}
?>
<?php include("database.php"); ?>
<!-- MAO NI ANG HEADER -->
<?php include("includes/header.php"); ?>      

<!-- UI THEME DIRI -->
<?php include("includes/ui-theme.php"); ?>

<div class="app-main">
<!-- sidebar diri  -->
<?php include("includes/sidebar.php"); ?>



<!-- Condition If unza nga page gi click -->
<?php 
   @$page = $_GET['page'];


   if($page != '')
   {
     if($page == "add_course")
     {
     include("page/add_course.php");
     }
     else if($page == "manage-course")
     {
     	include("page/manage-course.php");
     }
     else if($page == "add-unit")
     {
      include("page/add-unit.php");
     }
     else if($page == "manage-units")
     {
      include("page/manage-units.php");
     }
     else if($page == "add-exam")
     {
     	include("page/add-exam.php");
     }
     else if($page == "add-questions")
     {
     	include("page/add-questions.php");
     }
     else if($page == "manage-exam")
     {
      include("page/manage-exam.php");
     }
     else if($page == "manage-examinee")
     {
      include("page/manage-examinee.php");
     }
     else if($page == "ranking-exam")
     {
      include("page/ranking-exam.php");
     }
     else if($page == "feedbacks")
     {
      include("page/feedbacks.php");
     }
     else if($page == "examinee-result")
     {
      include("page/examinee-result.php");
     }

       
   }
   // Else ang home nga page mo display
 

   else
   {
     include("page/home.php"); 
   }

 ?> 


<!-- MAO NI IYA FOOTER -->
<?php include("includes/footer.php"); ?>

<?php include("includes/modals.php"); ?>
