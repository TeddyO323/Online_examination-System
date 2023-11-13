<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Your head content here -->
    <style>
    body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
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
        input[type="text"],
        input[type="email"],
        input[type="date"] {
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
        input[readonly] {
            background-color: #f4f4f4;
        }
        .non-editable-field {
            position: relative;
            display: inline-block;
        }
        .tooltip {
            visibility: hidden;
            width: 120px;
            background-color: black;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 5px;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            margin-left: -60px;
        }
        .non-editable-field:hover .tooltip {
            visibility: visible;
        }
        .tooltip::after {
            content: "cannot edit this field";
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            font-size: 12px;
            color: white;
        }
        select {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
    </style>
</head>
<body>
<div class="app-main__outer">
        <div class="app-main__inner">
        <h1 class = "text-center">Edit your Details</h1>
    <form action="pages/update_examinee_info.php" method="post">
    <?php
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
        // Check if the user is logged in
        if (isset($_SESSION['reg_no'])) {
            $reg_no = $_SESSION['reg_no'];
            $sql = "SELECT * FROM examinee_tbl WHERE reg_no = '$reg_no'";
            $result = $conn->query($sql);

            if ($result) {
                $row = $result->fetch_assoc();

                if ($row) {
                    // Add the form fields
                    echo '<label for="fullname">Full Name:</label><br>';
                    echo '<input type="text" id="fullname" name="fullname" value="' . $row['exmne_fullname'] . '" required><br><br>';

                    echo '<label for="course">Examinee Course:</label><br>';
                    echo '<input type="text" id="course" name="course" value="' . $row['exmne_course'] . '"  readonly title="You are not allowed to edit this field!><br><br>';

                    echo '<label for="gender">Gender:</label><br>';
                    echo '<select id="gender" name="gender" required>';
                    echo '<option value="Male" ' . ($row['exmne_gender'] === 'Male' ? 'selected' : '') . '>Male</option>';
                    echo '<option value="Female" ' . ($row['exmne_gender'] === 'Female' ? 'selected' : '') . '>Female</option>';
                    echo '</select><br><br>';


                    echo '<label for="birthdate">Birth Date:</label><br>';
                    echo '<input type="date" id="birthdate" name="birthdate" value="' . $row['exmne_birthdate'] . '" required><br><br>';

                    echo '<label for="reg_no">Registration Number:</label><br>';
                    echo '<input type="text" id="reg_no" name="reg_no" value="' . $row['reg_no'] . '"  readonly title="You are not allowed to edit this field!><br><br>';

                    echo '<label for="address">Address:</label><br>';
                    echo '<input type="text" id="address" name="address" value="' . $row['address'] . '" required><br><br>';

                    echo '<label for="contact_no">Contact Number:</label><br>';
                    echo '<input type="text" id="contact_no" name="contact_no" value="' . $row['contact_no'] . '" required><br><br>';

                    echo '<label for="year_level">Exam Year Level:</label><br>';
                    echo '<input type="text" id="year_level" name="year_level" value="' . $row['exmne_year_level'] . '"  readonly title="You are not allowed to edit this field!><br><br>';

                    echo '<label for="email">Email:</label><br>';
                    echo '<input type="email" id="email" name="email" value="' . $row['exmne_email'] . '" required><br><br>';

                    echo '<input type="submit" value="Update">';
                } else {
                    echo "Examinee information not found.";
                }
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "User not logged in.";
        }
        $conn->close();
        ?>
    </form>
    </div>
    </div>
</body>
</html>
