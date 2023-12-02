<?php
// Database connection
include("database.php");

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['unit_id'])) {
    $unitId = $_GET['unit_id'];

    // Fetch unit data based on the provided unit_id
    $unitQuery = $conn->query("SELECT * FROM units_tbl WHERE unit_id = $unitId");

    if ($unitQuery->num_rows > 0) {
        $unitData = $unitQuery->fetch_assoc();
    } else {
        // Handle the case when no unit is found with the provided unit_id
        echo "Unit not found";
        exit;
    }
}

// Implement the logic for updating the unit here

?>
<!DOCTYPE html>
<html>

<head>
    <title>Edit Unit</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        .app-main__outer {
            width: 70%;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
        }

        .app-main__inner {
            padding: 20px;
        }

        h1 {
            text-align: center;
        }

        form {
            width: 60%;
            margin: auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
        }
        select {
        width: 100%;
        padding: 10px;
        margin-bottom: 20px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: none;
            background-color: #4ef037;
            color: white;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="app-main__outer">
        <div class="app-main__inner">
            <h1>Edit Unit</h1>
            <form method="post" action="index.php?page=update_unit">
                <input type="hidden" name="unit_id" value="<?php echo $unitData['unit_id']; ?>">
                Unit Name: <input type="text" name="unit_name" value="<?php echo $unitData['unit_name']; ?>"><br><br>
                Unit Code: <input type="text" name="unit_code" value="<?php echo $unitData['unit_code']; ?>"><br><br>
                <select name="course_name">
        <?php
        $selectedCourse = $unitData['course_name'];
        $coursesQuery = $conn->query("SELECT * FROM course_tbl ORDER BY cou_id DESC");
        while ($row = $coursesQuery->fetch_assoc()) {
            if ($row['course_name'] === $selectedCourse) {
                echo "<option value='" . $row['course_name'] . "' selected>" . $row['course_name'] . "</option>";
            } else {
                echo "<option value='" . $row['course_name'] . "'>" . $row['course_name'] . "</option>";
            }
        }
        ?>
                </select><br><br>
                <!-- Add other fields as needed -->
                <input type="submit" value="Update Unit">
            </form>
        </div>
    </div>
</body>

</html>
