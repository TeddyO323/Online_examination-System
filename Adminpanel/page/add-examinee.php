<?php
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Set parameters
    $examineeFullName = $_POST['examineeFullName'];
    $registrationNumber = $_POST['registrationNumber'];
    $birthdate = $_POST['birthdate'];
    $gender = $_POST['gender'];
    $course = $_POST['course'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $contactNumber = $_POST['contactNumber'];
    $address = $_POST['address'];

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO examinee_tbl (exmne_fullname, reg_no, exmne_birthdate, exmne_gender, exmne_course, exmne_email, exmne_password, contact_no, address) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    // Check if the prepare was successful
    if (!$stmt) {
        die("Error: " . $conn->error);
    }

    $stmt->bind_param("sssssssss", $examineeFullName, $registrationNumber, $birthdate, $gender, $course, $email, $password, $contactNumber, $address);

    // Execute the statement
    $success = $stmt->execute();

    // Check for errors
    if ($success) {
        echo "<script>alert('New record added successfully');</script>";
        header("Location: index.php?page=add-examinee");
        exit();
    } else {
        if ($conn->errno == 1062) {
            echo "<script>alert('Registration Number Already exists!');</script>";
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    // Close the statement
    $stmt->close();
    
    // Close the connection
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        h2 {
            text-align: center;
            color: black;
        }
        form {
            margin: auto;
        margin-top: 100px;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 5px;
        width: 70%; /* Adjusted width for the form */
        font-family: Arial, sans-serif;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            font-weight: bold;
            display: block;
            margin-bottom: 10px;
        }
        input[type="text"], input[type="email"], input[type="password"], input[type="date"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        button {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: none;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }
        button:active {
            background-color: #004080;
        }

        button:focus {
            outline: none;
        }
    </style>
</head>

<body>
<div class="app-main__outer">
        <div class="app-main__inner">
        <h2>Add Examinee</h2>

    <div class="container">
    <form id="addExamineeForm" method="post" action="index.php?page=add-examinee">
            <div class="form-group">
                <label for="examineeFullName">Examinee Full Name</label>
                <input type="text" class="form-control" id="examineeFullName" name="examineeFullName" required>
            </div>
            <div class="form-group">
                <label for="registrationNumber">Registration Number</label>
                <input type="text" class="form-control" id="registrationNumber" name="registrationNumber" required>
            </div>
            <div class="form-group">
                <label for="birthdate">Birthdate</label>
                <input type="date" class="form-control" id="birthdate" name="birthdate" required>
            </div>
            <div class="form-group">
                <label for="gender">Gender</label>
                <select class="form-control" id="gender" name="gender">
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </div>
            <label>Course</label>
    <select class="form-control" name="course" id="course">
        <option value="0">Select course</option>
        <?php
// Your existing database connection code
include("database.php");

// Query to fetch all courses from the database
$result = $conn->query("SELECT * FROM `course_tbl` ORDER BY cou_id DESC");

// Initialize an empty array to store course names
$courseList = [];

// Check if any courses are found
if ($result->num_rows > 0) {
    // Loop through each row and add the course name to the list
    while ($row = $result->fetch_assoc()) {
        $courseList[] = $row['course_name'];
    }
}
// Iterate through each course in the list and display as an option
foreach ($courseList as $course) {
  echo "<option value=\"$course\">$course</option>";
}
?>
    </select>
    
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" class="form-control" id="address" name="address" required>
            </div>
            <div class="form-group">
                <label for="contactNumber">Contact Number</label>
                <input type="text" class="form-control" id="contactNumber" name="contactNumber" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit">Add Examinee</button>
        </form>
    </div>
</body>

</html>
