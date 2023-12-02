<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Course</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        h2 {
            text-align: center;
            margin-top: 40px;
        }
        form {
            max-width: 400px;
            margin: 0 auto;
            background: #f9f9f9;
            padding: 20px;
            border: 1px solid #c9c9c9;
            border-radius: 5px;
            margin-top: 20px;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            width: 100%;
            background-color: #4ef037;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
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
        // Include the database connection file
        include("database.php");

        // Check if the 'id' parameter is set in the URL
        if (isset($_GET['id'])) {
            // Retrieve the course ID from the URL
            $courseId = $_GET['id'];

            // Query the database to fetch the course details based on the $courseId
            $sql = "SELECT * FROM course_tbl WHERE cou_id = $courseId";
            $result = $conn->query($sql);

            // Check if the query returned any results
            if ($result->num_rows > 0) {
                // Fetch the course details
                $row = $result->fetch_assoc();

                // Display the form with the fetched course details
            // Display the form with the fetched course details
echo "<h2>Edit Course for " . $row['course_name'] . "</h2>";
echo "<form action='page/update_course.php' method='post'>";
echo "<input type='hidden' name='course_id' value='" . $row['cou_id'] . "'>";

                echo "Course Name: <input type='text' name='course_name' value='" . $row['course_name'] . "'><br><br>";
                echo "Course Description: <input type='text' name='course_description' value='" . $row['course_description'] . "'><br><br>";
                echo "Course Code: <input type='text' name='course_code' value='" . $row['course_code'] . "'><br><br>";
                // echo "Category: <input type='text' name='course_category' value='" . $row['course_category'] . "'><br><br>";
                // echo "Instructor: <input type='text' name='course_instructor' value='" . $row['course_instructor'] . "'><br><br>";
                echo "Materials: <input type='text' name='course_materials' value='" . $row['course_materials'] . "'><br><br>";
                echo "Prerequisites: <input type='text' name='course_prerequisites' value='" . $row['course_prerequisites'] . "'><br><br>";
                // echo "Fees: <input type='text' name='course_fees' value='" . $row['course_fees'] . "'><br><br>";
                
                echo "<input type='submit' value='Update Course'>";
                echo "</form>";
            } else {
                echo "No course found with the provided ID.";
            }
        } else {
            echo "No course ID provided.";
        }

        // Close the database connection
        $conn->close();
    ?>
</body>
</html>
