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



<?php 
   @$page = $_GET['page'];


   if($page != '')
   {
     if($page == "examiner-account")
     {
     include("page/examiner-account.php");
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
     else if($page == "update-question")
     {
     	include("page/update-question.php");
     }
     else if($page == "add-examiner")
     {
     	include("page/add-examiner.php");
     }
     else if($page == "manage-exam")
     {
      include("page/manage-exam.php");
     }
     else if($page == "edit-examiner")
     {
      include("page/edit-examiner.php");
     }
     else if($page == "edit-unit")
     {
      include("page/edit-unit.php");
     }
     else if($page == "update_unit")
     {
      include("page/update_unit.php");
     }
     else if($page == "manage-examiner")
     {
      include("page/manage-examiner.php");
     }
     else if($page == "ranking-exam")
     {
      include("page/ranking-exam.php");
     }
     else if($page == "feedbacks")
     {
      include("page/feedbacks.php");
     }
     else if($page == "examiner-result")
     {
      include("page/examiner-result.php");
     }
     else if($page == "edit-question")
     {
      include("page/edit-question.php");
     }

     else if($page == "edit-course")
     {
      include("page/edit-course.php");
     }
     
       
   }
 

   else
   {
     include("page/home.php"); 
   }

 ?> 


<?php include("includes/footer.php"); ?>

<?php include("includes/modals.php"); ?>
