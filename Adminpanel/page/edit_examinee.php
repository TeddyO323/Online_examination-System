<?php
    // Include the database connection
    include 'database.php';

    // Check if the ID parameter is set
    if (isset($_GET['id'])) {
        $exmne_id = $_GET['id'];

        // Fetch examinee details from the database
        $query = "SELECT * FROM examinee_tbl WHERE exmne_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $exmne_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            // Examinee found, populate form fields with data
            $examinee = $result->fetch_assoc();
            // Populate the form fields with examinee data
            $fullname = $examinee['exmne_fullname'];
            $reg_no = $examinee['reg_no'];
            $birthdate = $examinee['exmne_birthdate'];
            $gender = $examinee['exmne_gender'];
            $course = $examinee['exmne_course'];
            $year_level = $examinee['exmne_year_level'];
            $email = $examinee['exmne_email'];
            $password = $examinee['exmne_password'];
            $contact_no = $examinee['contact_no'];
            $address = $examinee['address'];
            $examinee = $result->fetch_assoc();


            // Close the statement
            $stmt->close();
        } else {
            // Examinee not found, handle accordingly
            echo "Examinee not found.";
        }
    }
    $conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
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
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        button[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4caf50;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }
    </style></head>
<body>
<div class="app-main__outer">
        <div class="app-main__inner">
            <h2>Edit Examinee</h2>
    <form action="page/update_examinee.php" method="POST">
    <input type="hidden" name="exmne_id" value="<?php echo $exmne_id; ?>">

        <!-- Populate form fields with the fetched examinee data -->
        <label>Fullname</label>
        <input type="text" name="fullname" value="<?php echo $fullname; ?>"><br><br>

        <label>Registration Number</label>
        <input type="text" name="reg_no" value="<?php echo $reg_no; ?>"><br><br>

        <label>Birthdate</label>
        <input type="date" name="birthdate" value="<?php echo $birthdate; ?>"><br><br>

        <label>Gender</label>
    <select name="gender">
        <option value="male" <?php if($gender == 'male') echo 'selected'; ?>>Male</option>
        <option value="female" <?php if($gender == 'female') echo 'selected'; ?>>Female</option>
    </select><br><br>

    <label>Course</label>
<select class="form-control" name="course" id="course">
    <option value="0">Select course</option>
    <?php
        // Your existing database connection code
        include("database.php");

        // Query to fetch all courses from the database
        $result = $conn->query("SELECT * FROM `course_tbl` ORDER BY cou_id DESC");

        // Check if any courses are found
        if ($result->num_rows > 0) {
            // Loop through each row and display the course name
            while ($row = $result->fetch_assoc()) {
                $cou_id = $row['cou_id'];
                $course_name = $row['course_name'];
                // Check if the current course ID matches the one from the database
                if ($course == $cou_id) {
                    // Set the option as selected if the IDs match
                    echo "<option value=\"$cou_id\" selected>$course_name</option>";
                } else {
                    echo "<option value=\"$cou_id\">$course_name</option>";
                }
            }
        }
    ?>
</select>



        <label>Year Level</label>
    <select name="year_level">
        <option value="first year" <?php if($year_level == 'first year') echo 'selected'; ?>>First Year</option>
        <option value="second year" <?php if($year_level == 'second year') echo 'selected'; ?>>Second Year</option>
        <option value="third year" <?php if($year_level == 'third year') echo 'selected'; ?>>Third Year</option>
        <option value="fourth year" <?php if($year_level == 'fourth year') echo 'selected'; ?>>Fourth Year</option>
    </select><br><br>
        <label>Email</label>
        <input type="email" name="email" value="<?php echo $email; ?>"><br><br>

        <label>Password</label>
        <input type="password" name="password" value="<?php echo $password; ?>"><br><br>

        <label>Contact Number</label>
        <input type="text" name="contact_no" value="<?php echo $contact_no; ?>"><br><br>

        <label>Address</label>
        <input type="text" name="address" value="<?php echo $address; ?>"><br><br>

        <button type="submit">Update Examinee</button>
    </form>

    <!-- Rest of your HTML content -->
</body>
</html>
