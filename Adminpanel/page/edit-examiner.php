<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Examiner</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        h2 {
            text-align: center;
            color: blue;
        }
        form {
            width: 60%;
            margin: 0 auto;
            background: #fff;
            padding: 40px;
            border-radius: 5px;
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
            background-color: #4ef037;
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
<?php
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $examiner_number = $_POST['examiner_number'];
    $examiner_name = $_POST['examiner_name'];
    $examiner_email = $_POST['examiner_email'];
    $gender = $_POST['gender'];
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

    $sql = "UPDATE examiner_tbl SET 
            examiner_name = '$examiner_name', 
            examiner_email = '$examiner_email', 
            gender = '$gender', 
            examiner_password = '$examiner_password', 
            contact_number = '$contact_number', 
            address = '$address', 
            department = '$department', 
            role = '$role', 
            access_level = '$access_level', 
            specialization = '$specialization', 
            date_of_birth = '$date_of_birth', 
            joining_date = '$joining_date', 
            certification = '$certification', 
            notes = '$notes' 
            WHERE examiner_number = $examiner_number";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Examiner updated successfully');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} 

$conn->close();
?>

<?php
// Include the file for database connection
include 'database.php';

if (isset($_GET['id'])) {
    $examinerNumber = $_GET['id'];
    // Fetch the examiner details based on the provided ID
    $sql = "SELECT * FROM examiner_tbl WHERE examiner_number = $examinerNumber";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            // Example form for editing the examiner details
            echo "
            <h2>Edit Examiner</h2>
            <form action='index.php?page=edit-examiner' method='post'>
                <input type='hidden' name='examiner_number' value='".$row['examiner_number']."'>
                <label for='examiner_name'>Examiner Full Name</label>
                <input type='text' id='examiner_name' name='examiner_name' value='".$row['examiner_name']."' required><br>

                <label for='examiner_email'>Examiner Email</label>
                <input type='email' id='examiner_email' name='examiner_email' value='".$row['examiner_email']."' required><br>

                <label for='gender'>Gender</label>
                <select id='gender' name='gender'>
                    <option value='male' " . (($row['gender'] == 'male') ? 'selected' : '') . ">Male</option>
                    <option value='female' " . (($row['gender'] == 'female') ? 'selected' : '') . ">Female</option>
                    <option value='other' " . (($row['gender'] == 'other') ? 'selected' : '') . ">Other</option>
                </select>
                <br>

                <label for='examiner_password'>Examiner Password</label>
                <input type='password' id='examiner_password' name='examiner_password' value='".$row['examiner_password']."' required><br>

                <label for='contact_number'>Contact Number</label>
                <input type='text' id='contact_number' name='contact_number' value='".$row['contact_number']."' required><br>

                <label for='address'>Address</label>
                <input type='text' id='address' name='address' value='".$row['address']."' required><br>

                <label for='department'>Department</label>
                <input type='text' id='department' name='department' value='".$row['department']."' required><br>

                <label for='role'>Role</label>
                <input type='text' id='role' name='role' value='".$row['role']."' required><br>

                <label for='access_level'>Access Level</label>
                <select id='access_level' name='access_level'>
                    <option value='1' " . (($row['access_level'] == 1) ? 'selected' : '') . ">Level 1</option>
                    <option value='2' " . (($row['access_level'] == 2) ? 'selected' : '') . ">Level 2</option>
                    <option value='3' " . (($row['access_level'] == 3) ? 'selected' : '') . ">Level 3</option>
                </select><br>

                <label for='specialization'>Specialization</label>
                <input type='text' id='specialization' name='specialization' value='".$row['specialization']."' required><br>

                <label for='date_of_birth'>Date of Birth</label>
                <input type='date' id='date_of_birth' name='date_of_birth' value='".$row['date_of_birth']."' required><br>

                <label for='joining_date'>Joining Date</label>
                <input type='date' id='joining_date' name='joining_date' value='".$row['joining_date']."' required><br>

                <label for='certification'>Certification Information</label>
                <input type='text' id='certification' name='certification' value='".$row['certification']."' required><br>

                <label for='notes'>Notes or Comments</label>
                <input type='text' id='notes' name='notes' value='".$row['notes']."' required><br>

                <input type='submit' value='Update Examiner'>
            </form>";
        }
    } else {
        echo "<script>alert('Examiner not found');</script>";
    }
} 

// Close the database connection
$conn->close();
?>
</body>
</html>
