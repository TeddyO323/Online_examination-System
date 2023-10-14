<?php
session_start();
if (!isset($_SESSION["user"])) {
   header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1>Welcome to the Admin Panel</h1>
    <div class="card-container">
        <div class="card">
            <a href="#">User Management</a>
        </div>
        <div class="card">
            <a href="#">Exam Management</a>
        </div>
        <div class="card">
            <a href="#">Result Management</a>
        </div>
        <div class="card">
            <a href="#">System Configuration</a>
        </div>
        <div class="card">
            <a href="#">Reporting and Analytics</a>
        </div>

    </div>
</body>

</html>

    <a href="logout.php" class="btn btn-warning">Logout</a>

</body>

</html>



