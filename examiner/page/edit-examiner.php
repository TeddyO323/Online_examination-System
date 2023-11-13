<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Examiner</title>
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
    </style></head>
<body>
<div class="app-main__outer">
        <div class="app-main__inner">
            <h1 class = "text-center">Edit your Details</h1>
    <?php
        // Include the necessary files
        include("database.php");

        // Check if the examiner number is set in the URL
        if (isset($_GET['examiner_number'])) {
            $examinerNumber = $_GET['examiner_number'];

            // Retrieve the examiner details from the database based on the examiner number
            $sql = "SELECT * FROM examiner_tbl WHERE examiner_number = $examinerNumber";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                // Display the form to edit the examiner details

                echo '<form action="update-examiner.php" method="post">';

                echo '<input type="hidden" name="examiner_number" value="' . $row['examiner_number'] . '">';

                echo 'Examiner Name: <input type="text" name="examiner_name" value="' . $row['examiner_name'] . '"><br>';
                echo 'Examiner Email: <input type="email" name="examiner_email" value="' . $row['examiner_email'] . '"><br>';
                echo 'Contact Number: <input type="text" name="contact_number" value="' . $row['contact_number'] . '"><br>';
                echo 'Address: <input type="text" name="address" value="' . $row['address'] . '"><br>';
                echo 'Date of Birth: <input type="date" name="date_of_birth" value="' . $row['date_of_birth'] . '"><br>';
                echo 'Certification: <input type="text" name="certification" value="' . $row['certification'] . '"><br>';
                echo 'Gender: <select name="gender" style="padding: 10px; border-radius: 5px; border: 1px solid #ccc; width: 100%;">';
                echo '<option value="Male" ' . ($row['gender'] === 'Male' ? 'selected' : '') . '>Male</option>';
                echo '<option value="Female" ' . ($row['gender'] === 'Female' ? 'selected' : '') . '>Female</option>';
                echo '<option value="Others" ' . ($row['gender'] === 'Others' ? 'selected' : '') . '>Others</option>';
                echo '</select><br>';
                
                
            // Display non-editable fields
echo 'Department: <input type="text" name="department" value="' . $row['department'] . '" readonly title="You are not allowed to edit this field!"><br>';
echo 'Role: <input type="text" name="role" value="' . $row['role'] . '" readonly title="You are not allowed to edit this field!"><br>';
echo 'Access Level: <input type="text" name="access_level" value="' . $row['access_level'] . '" readonly title="You are not allowed to edit this field!"><br>';
echo 'Joining Date: <input type="date" name="joining_date" value="' . $row['joining_date'] . '" readonly title="You are not allowed to edit this field!"><br>';


                // Add other necessary form elements

                echo '<input type="submit" value="Update Examiner">';
                echo '</form>';
            } else {
                echo "<p>No examiner found with the specified number.</p>";
            }
        } else {
            echo "<p>No examiner number specified in the URL.</p>";
        }

        // Close the database connection
        $conn->close();
    ?>
</body>
</html>
