<?php
// Include the file for database connection
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $examiner_name = $_POST['examiner_name'];
    $examiner_email = $_POST['examiner_email'];
    $examiner_password = $_POST['examiner_password'];
    $contact_number = $_POST['contact_number'];
    $address = $_POST['address'];
    $department = $_POST['department'];
    $role = $_POST['role'];
    $access_level = $_POST['access_level'];
    $specialization = $_POST['specialization'];
    $date_of_birth = $_POST['date_of_birth'];
    $joining_date = $_POST['joining_date'];
    $certification = $_POST['certification'];
    $notes = $_POST['notes'];
    $gender = $_POST['gender'];
    $examiner_number = $_POST['examiner_number'];

    // Check if the examiner number already exists
    $checkExaminerNumberQuery = "SELECT * FROM examiner_tbl WHERE examiner_number = '$examiner_number'";
    $resultExaminerNumber = $conn->query($checkExaminerNumberQuery);

    // Check if the email already exists
    $checkExaminerEmailQuery = "SELECT * FROM examiner_tbl WHERE examiner_email = '$examiner_email'";
    $resultExaminerEmail = $conn->query($checkExaminerEmailQuery);

    if ($resultExaminerNumber->num_rows > 0) {
        echo "<script>alert('ID already exists');</script>";
    } elseif ($resultExaminerEmail->num_rows > 0) {
        echo "<script>alert('Email already exists');</script>";
    } else {
        $sql = "INSERT INTO examiner_tbl (examiner_number, examiner_name, examiner_email, examiner_password, contact_number, address, department, role, access_level, specialization, date_of_birth, joining_date, certification, notes, gender) 
            VALUES ('$examiner_number', '$examiner_name', '$examiner_email', '$examiner_password', '$contact_number', '$address', '$department', '$role', '$access_level', '$specialization', '$date_of_birth', '$joining_date', '$certification', '$notes', '$gender')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('New record added successfully');</script>";
            header("Location: index.php?page=manage-examiner"); // Redirect to the same page to clear the POST data
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
} 

// Close the database connection
$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Examiner</title>
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
        
    </style>
</head>

<body>

<div class="app-main__outer">
        <div class="app-main__inner">
        <h2>Add Examiner</h2>

        <form action="index.php?page=add-examiner" method="post">

        <label for="examiner_name">Examiner Full Name</label>
        <input type="text" id="examiner_name" name="examiner_name" required><br>

        <label for="examiner_email">Examiner Email</label>
        <input type="email" id="examiner_email" name="examiner_email" required><br>

        <label for="gender">Gender</label>
                <select id="gender" name="gender">
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>

                </select>
                <br>

               

        <label for="examiner_password">Examiner Password</label>
        <input type="password" id="examiner_password" name="examiner_password" required><br>

        <label for="examiner_number">Examiner ID</label>
        <input type="text" id="examiner_number" name="examiner_number" required><br>

        <label for="contact_number">Contact Number</label>
        <input type="text" id="contact_number" name="contact_number" required><br>

        <label for="address">Address</label>
        <input type="text" id="address" name="address" required><br>

        <label for="department">Department</label>
        <input type="text" id="department" name="department" required><br>

        <label for="role">Role</label>
        <input type="text" id="role" name="role" required><br>

        <label for="access_level">Access Level</label>
        <select id="access_level" name="access_level">
            <option value="1">Level 1</option>
            <option value="2">Level 2</option>
            <option value="3">Level 3</option>
        </select><br>

        <label for="specialization">Specialization</label>
        <input type="text" id="specialization" name="specialization" required><br>

        <label for="date_of_birth">Date of Birth</label>
        <input type="date" id="date_of_birth" name="date_of_birth" required><br>

        <label for="joining_date">Joining Date</label>
        <input type="date" id="joining_date" name="joining_date" required><br>

        <label for="certification">Certification Information</label>
        <input type="text" id="certification" name="certification" required><br>

        <label for="notes">Notes or Comments</label>
        <input type="text" id="notes" name="notes" required><br>

        <input type="submit" value="Add Examiner">
    </form>
    
    </div>
    </div>
</body>
</html>
