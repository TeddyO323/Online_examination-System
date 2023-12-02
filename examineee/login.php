<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once('database.php');

$loginMessage = '';
$suspendMessage = '';
$loginMessages = '';



if (isset($_POST['reg_no']) && isset($_POST['exmne_password'])) {
    $reg_no = $_POST['reg_no'];
    $exmne_password = $_POST['exmne_password'];

    $sql = "SELECT * FROM examinee_tbl WHERE reg_no = '$reg_no' AND exmne_password = '$exmne_password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if ($row['exmne_status'] == 'active') {
            $_SESSION['reg_no'] = $reg_no;
            header("Location: index.php");
            exit();
        } else {
            $suspendMessage = "Your account is suspended. Please contact the administrator for assistance.";
        }
    } else {
        $loginMessage = "Invalid login credentials. Please try again.";
    }
} else {
    $loginMessages = "Please fill in both the registration number and password fields.";
}
$successMessageClass = 'success-message';
$errorMessageClass = 'error-message';
$conn->close();
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <!-- Fontawesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jack Blogger</title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
     
      <link href="assets/img/T-400.png" rel="icon">
      <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon"><!-- Google Fonts -->
      <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
      <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet"><!-- Vendor CSS Files -->
     
	<style>
		/* Google Font Link */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');
*{
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Poppins" , sans-serif;
}
body{
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #f2f2f2;
  padding: 30px;
  box-sizing: border-box;
    font-family: "Poppins", sans-serif;
    background: #f2f2f2;
    padding: 30px;
    margin-top: 5%; /* Adjust the margin as needed */
}

.container{
  position: relative;
  max-width: 850px;
  width: 100%;
  margin-top: 60px; /* Adjust this margin to create space below the fixed header */
  background: #fff;
  padding: 40px 30px;
  box-shadow: 0 5px 10px rgba(0,0,0,0.2);
  perspective: 2700px;
}


.container .cover{
  position: absolute;
  top: 0;
  left: 50%;
  height: 100%;
  width: 50%;
  z-index: 98;
  transition: all 1s ease;
  transform-origin: left;
  transform-style: preserve-3d;
}
.container #flip:checked ~ .cover{
  transform: rotateY(-180deg);
}
 .container .cover .front,
 .container .cover .back{
  position: absolute;
  top: 0;
  left: 0;
  height: 100%;
  width: 100%;
}
.cover .back{
  transform: rotateY(180deg);
  backface-visibility: hidden;
}
.container .cover::before,
.container .cover::after{
  content: '';
  position: absolute;
  height: 100%;
  width: 100%;
  background: #e48d2a;
  opacity: 0.5;
  z-index: 12;
}
.container .cover::after{
  opacity: 0.3;
  transform: rotateY(180deg);
  backface-visibility: hidden;
}
.container .cover img{
  position: absolute;
  height: 100%;
  width: 100%;
  object-fit: cover;
  z-index: 10;
}
.container .cover .text{
  position: absolute;
  z-index: 130;
  height: 100%;
  width: 100%;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}
.cover .text .text-1,
.cover .text .text-2{
  font-size: 26px;
  font-weight: 600;
  color: #fff;
  text-align: center;
}
.cover .text .text-2{
  font-size: 15px;
  font-weight: 500;
}
.container .forms{
  height: 50%;
  width: 100%;
  background: #fff;
}
.container .form-content{
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.form-content .login-form,
.form-content .signup-form{
  width: calc(100% / 2 - 25px);
}
.forms .form-content .title{
  position: relative;
  font-size: 24px;
  font-weight: 500;
  color: #333;
}
.forms .form-content .title:before{
  content: '';
  position: absolute;
  left: 0;
  bottom: 0;
  height: 3px;
  width: 25px;
  background: #e48d2a;
}
.forms .signup-form  .title:before{
  width: 20px;
}
.forms .form-content .input-boxes{
  margin-top: 30px;
}
.forms .form-content .input-box{
  display: flex;
  align-items: center;
  height: 50px;
  width: 100%;
  margin: 10px 0;
  position: relative;
}
.form-content .input-box input{
  height: 100%;
  width: 100%;
  outline: none;
  border: none;
  padding: 0 30px;
  font-size: 16px;
  font-weight: 500;
  border-bottom: 2px solid rgba(0,0,0,0.2);
  transition: all 0.3s ease;
}
.form-content .input-box input:focus,
.form-content .input-box input:valid{
  border-color: #e48d2a;
}
.form-content .input-box i{
  position: absolute;
  color: #e48d2a;
  font-size: 17px;
}
.forms .form-content .text{
  font-size: 14px;
  font-weight: 500;
  color: #333;
}
.forms .form-content .text a{
  text-decoration: none;
}
.forms .form-content .text a:hover{
  text-decoration: underline;
}
.forms .form-content .button{
  color: #fff;
  margin-top: 40px;
}
.forms .form-content .button input{
  color: #fff;
  background: #e48d2a;
  border-radius: 6px;
  padding: 0;
  cursor: pointer;
  transition: all 0.4s ease;
}
.forms .form-content .button input:hover{
  background: #red;
}
.forms .form-content label{
  color: #red;
  cursor: pointer;
}
.forms .form-content label:hover{
  text-decoration: underline;
}
.forms .form-content .login-text,
.forms .form-content .sign-up-text{
  text-align: center;
  margin-top: 25px;
}
.container #flip{
  display: none;
}
@media (max-width: 730px) {
  .container .cover{
    display: none;
  }
  .form-content .login-form,
  .form-content .signup-form{
    width: 100%;
  }
  .form-content .signup-form{
    display: none;
  }
  .container #flip:checked ~ .forms .signup-form{
    display: block;
  }
  .container #flip:checked ~ .forms .login-form{
    display: none;
  }
}
.message-box {
    transition: opacity 0.5s ease-in-out;
  }
  .message {
            background-color: #e48d2a;
            padding: 10px;
            border: 1px solid #f5c6cb; 
            border-radius: 5px; 
            margin-top: 10px;
        }
.login-message{
  color: red;
}
.login-messages{
  color: #fff;
}
.suspend-message{
  color: brown;
}
.header {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 20px;
    z-index: 1000;
    overflow: hidden; 
    background: linear-gradient(45deg, #fff 30%, #e48d2a 30%);
    padding: px 0;
    color: #5b13b9; 
}

.left-part {
    background-color: red;
    color: red;
    padding: 10px;
}

.right-part {
    background-color: red;
    color: red;
    padding: 10px;
}



.divider {
    position: relative;
    width: 15px; 
    height: 2px;
    background-color: #fff; 
    transform: rotate(45deg); 
}


.header a {
    text-decoration: none;
    color: inherit; 
    margin-right: 10px;
}

.header a:hover {
    text-decoration: underline;
}

.header-right a {
    color: #fff; 
}


.header-left a img {
        max-width: 100px; 
        height: auto;
        display: block;
    }
    .dropdown {
        display: inline-block;
    }

    .dropbtn {
        padding: 14px 16px;
        font-size: 16px;
        border: none;
        cursor: pointer;
    }

    .dropdown-content {
        display: none;
        background-color: #f9f9f9;
        min-width: 160px;
        box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
        z-index: 1;
    }

    .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }

    .dropdown-content a:hover {
        background-color: #f1f1f1;
    }

    .dropdown:hover .dropdown-content {
        display: block;
    }

    .dropdown:hover .dropbtn {
        background-color: #e48d2a;
        color: white;
    }

	</style>
   </head>
<body>

 <!-- Header Section -->
 <div class="header">
        <!-- Left Section -->
        <div class="header-left">
    <a href="#"><img src="../images/ExamLogo.png" alt="Your Logo"></a>
</div>

        <!-- Divider Line -->
        <div class="header-divider"></div>
        <!-- Right Section -->
        <!-- Right Section -->
        <div class="header-right">
        <a href="../index.html">Home</a>
        <a href="../about.html">About</a>

        <!-- Dropdown -->
        <div class="dropdown">
            <button class="dropbtn">Login</button>
            <div class="dropdown-content">
                <a href="../examiner/login.php">Examiner Login</a>
                <a href="login.php">Examinee Login</a>
            </div>
        </div>
        <!-- End Dropdown -->
    </div>


    </div>


  <div class="container">
    <input type="checkbox" id="flip">
    <div class="cover">
      <div class="front">
        <img src="assets/images/frontImg.jpg" alt="">
        <div class="text">
        <div class="message-box">
  <span class="text-1">Every new friend is a <br> new adventure</span>
  <span class="text-2">Let's get connected</span>
</div>
<script>
  var messages = [
    "Prepare well and <br>success will  follow!",
  "Hard work beats talent when talent doesn't work hard.",
  "Stay focused, stay positive, and give it your best shot.",
  "Success is the sum of small efforts repeated day in and day out.",
  "Every mistake is a chance to learn. Keep going!",
  "Believe you can and you're halfway there.",
  "Your education is a dress rehearsal for a life that is yours to lead.",
  "The only way to do great work is to love what you do.",
  "Success is not final, failure is not fatal: It is the courage to continue that counts.",
  "Dream big, work hard, stay focused.",
  "You are capable of amazing things. Believe in yourself!",
  "The expert in anything was once a beginner. Keep learning.",
  "Success usually comes to those who are too busy to be looking for it.",
  "Your time is limited, don't waste it living someone else's life.",
  "You've got this! Good luck!",
];

  var currentIndex = 0;
  var messageBox = document.querySelector('.message-box');

  function changeMessage() {
    messageBox.style.opacity = 0;

    setTimeout(function () {
      messageBox.innerHTML = '<span class="text-1">' + messages[currentIndex] + '</span>';
      currentIndex = (currentIndex + 1) % messages.length;
      messageBox.style.opacity = 1;
    }, 500); // Adjust the timeout based on your transition duration
  }

  changeMessage();

  setInterval(changeMessage, 3000);
</script>
        </div>
      </div>
      <div class="back">
        <img class="backImg" src="assets/images/backImg.jpg" alt="">
        <div class="text">
          <span class="text-1">Complete miles of journey <br> with one step</span>
          <span class="text-2">Let's get started</span>
        </div>
      </div>
    </div>
    <div class="forms">
  
   
        
        <div class="form-content">
          <div class="login-form">
          <div class="message">
        <span class="login-message"><?php echo $loginMessage; ?></span>
        <span class="suspend-message"><?php echo $suspendMessage; ?></span>
        <span class="login-messages"><?php echo $loginMessages; ?></span>

    </div>
    
            <div class="title">Examiner Login</div>
            <form method="post" action="login.php">

            <?php
if (isset($_GET['exmne_status']) && $_GET['exmne_status'] == 'suspended') {
    echo '<p style="color: red;">Your account is suspended. Please contact the administrator for assistance.</p>';
}
?>


            <div class="input-boxes">
              <div class="input-box">
                <i class="fas fa-envelope"></i>
            <input type="text" id="reg_no" placeholder = "Enter Your Registration Number"name="reg_no" required>              </div>
              <div class="input-box">
                <i class="fas fa-lock"></i>
            <input type="password" id="exmne_password" placeholder = "Enter password" name="exmne_password" required>
              </div>
              <div class="text"><a href="#">Forgot password?</a></div>
              <div class="button input-box">
			  <input type="submit" value="Log In">
              </div>
       
        </form>
      </div>
     
    </div>
    
    </div>
    
</body>
</html>


