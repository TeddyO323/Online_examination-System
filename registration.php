<?php
session_start();
if (isset($_SESSION["user"])) {
   header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
 
</head>
<body>
    <div class="container">
    <?php
        if (isset($_POST["submit"])) {
            $username = ($_POST['username']);
            
            $fullName = $_POST["fullname"];
            $email = $_POST["email"];
            $date_of_birth = ($_POST['date_of_birth']);
            $gender = ($_POST['gender']);
            $phone_number = ($_POST['phone_number']);
            $address = ($_POST['address']);
            $security_question = ($_POST['security_question']);
            $security_answer = ($_POST['security_answer']);
            $terms_and_conditions = isset($_POST['terms']) ? 1 : 0;
            $privacy_policy = isset($_POST['privacy']) ? 1 : 0;
            $newsletter_subscription = isset($_POST['newsletter']) ? 1 : 0;
        
            $password = $_POST["password"];
            $passwordRepeat = $_POST["repeat_password"];
           
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            $errors = array();
         
           if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($errors, "Email is not valid");
           }
           if (strlen($password)<8) {
            array_push($errors,"Password must be at least 8 charactes long");
           }
           if ($password!==$passwordRepeat) {
            array_push($errors,"Password does not match");
           }
           require_once "database.php";
           $sql = "SELECT * FROM users WHERE email = '$email'";
           $result = mysqli_query($conn, $sql);
           $rowCount = mysqli_num_rows($result);
           if ($rowCount>0) {
            array_push($errors,"Email already exists!");
           }
           if (count($errors)>0) {
            foreach ($errors as  $error) {
                echo "<div class='alert alert-danger'>$error</div>";
            }
           }else{
            
            $sql = "INSERT INTO users (full_name, email, password) VALUES ( ?, ?, ? )";
            $stmt = mysqli_stmt_init($conn);
            $prepareStmt = mysqli_stmt_prepare($stmt,$sql);
            if ($prepareStmt) {
                mysqli_stmt_bind_param($stmt,"sss",$fullName, $email, $passwordHash);
                mysqli_stmt_execute($stmt);
                echo "<div class='alert alert-success'>You are registered successfully.</div>";
            }else{
                die("Something went wrong");
            }
           }
          

        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Include your database connection logic here
        
            // ... Your other code ...
        
            // Displaying actual data instead of NULL
            $phone_number = isset($_POST['phone_number']) ? mysqli_real_escape_string($db, $_POST['phone_number']) : 'Not provided';
            $address = isset($_POST['address']) ? mysqli_real_escape_string($db, $_POST['address']) : 'Not provided';
        
            // ... Your database insertion logic ...
        
            // Close the database connection
            mysqli_close($db);
        }
        ?>

<form action="registration.php" method="post">
            <div class="form-group">
                <input type="text" class="form-control" name="fullname" placeholder="Full Name" required>
            </div>
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password" required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="repeat_password" placeholder="Repeat Password:" required>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="username" placeholder="Username" required>
            </div>
            <div class="form-group">
                <input type="date" class="form-control" name="date_of_birth" placeholder="Date of Birth" required>
            </div>
            <div class="form-group">
                <select class="form-control" name="gender" required>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="phone_number" placeholder="Phone Number" required>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="address" placeholder="Address" required>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="security_question" placeholder="Security Question" required>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="security_answer" placeholder="Security Answer" required>
            </div>
            <div class="form-group">
                <label>
                    <input type="checkbox" name="terms" value="1" required> I agree to the terms and conditions
                </label>
            </div>
            <div class="form-group">
                <label>
                    <input type="checkbox" name="privacy" value="1" required> I agree to the privacy policy
                </label>
            </div>
            <div class="form-group">
                <label>
                    <input type="checkbox" name="newsletter" value="1" required> Subscribe to newsletter
                </label>
            </div>
            <div class="form-btn">
                <input type="submit" class="btn" value="Register" name="submit">
            </div>
        </form>
        <div>
            <p>Already Registered? <a href="login.php">Login Here</a></p>
        </div>
    </div>
    <script>
        function validateForm() {
            var inputs = document.getElementsByTagName('input');
            for (var i = 0; i < inputs.length; i++) {
                if (inputs[i].hasAttribute("required") && inputs[i].value.trim() === "") {
                    alert("Please fill in all required fields.");
                    return false;
                }
            }
            return true;
        }
    </script>
</body>

</html>