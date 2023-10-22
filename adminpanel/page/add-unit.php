<?php
// Include the database connection
include("database.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['unit_name']) && isset($_POST['unit_code']) && isset($_POST['course_id'])) {
    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO units_tbl (unit_name, unit_code, course_id) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $unitName, $unitCode, $courseId);

    // Set parameters and execute
    $unitName = $_POST['unit_name'];
    $unitCode = $_POST['unit_code'];
    $courseName = $_POST['course_name'];

    $stmt->execute();

    // Close statement
    $stmt->close();

    // Redirect to the manage units page after submission
    header("Location: manage-units.php");
    exit();
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Add Unit</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        form {
            max-width: 300px;
            margin: 0 auto;
            background: #f9f9f9;
            padding: 20px;
            border: 1px solid #c3c3c3;
            border-radius: 5px;
        }
        input[type="text"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #bfbfbf;
            border-radius: 5px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        h2 {
            text-align: center;
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
    <h2>Add Unit</h2>
    <form action="page/add_unit_backend.php" method="post">
        <label for="unit_name">Unit Name:</label><br>
        <input type="text" id="unit_name" name="unit_name"><br>
        <label for="unit_code">Unit Code:</label><br>
        <input type="text" id="unit_code" name="unit_code"><br>
        <!-- PHP code to fetch the list of courses -->
<?php
// Your existing database connection code

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
?>

<!-- HTML code to display the list of courses as a dropdown list -->
<select name="course_name" id="course_name">
<option value="" disabled selected hidden>Select Course</option>

    <?php
    // Iterate through each course in the list and display as an option
    foreach ($courseList as $course) {
        echo "<option value=\"$course\">$course</option>";
    }
    ?>
</select>

        <input type="submit" value="Submit">
    </form>
</body>
</html>
