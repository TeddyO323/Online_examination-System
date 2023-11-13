<?php
// Include the database connection
include("database.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['unit_name']) && isset($_POST['unit_code']) && isset($_POST['course_name'])) {
    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO units_tbl (unit_name, unit_code, course_name) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $unitName, $unitCode, $courseId);

    // Set parameters and execute
    $unitName = $_POST['unit_name'];
    $unitCode = $_POST['unit_code'];
    $courseId = $_POST['course_name'];

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
        select {
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
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
    </style>
</head>
<body>
<div class="app-main__outer">
        <div class="app-main__inner">
    <!-- PHP code to fetch the list of courses -->
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
?>
    <h2>Add Unit</h2>
    <form action="page/add_unit_backend.php" method="post">
        <label for="unit_name">Unit Name:</label><br>
        <input type="text" id="unit_name" name="unit_name"><br>
        <label for="unit_code">Unit Code:</label><br>
        <input type="text" id="unit_code" name="unit_code"><br>
        <select name="course_name" id="course_name" required>
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
