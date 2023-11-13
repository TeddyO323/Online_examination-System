<!DOCTYPE html>
<html>
<head>
    <title>Add Course</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
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
        input[type=text] {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type=submit] {
            width: 100%;
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type=submit]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
<div class="app-main__outer">
    <div class="app-main__inner">
    <h2 style="text-align: center;">Add Course</h2>
    <form action="page/add_course_backend.php" method="post">
        <label for="course_name">Course Name:</label><br>
        <input type="text" id="course_name" name="course_name"><br><br>
        <label for="course_description">Course Description:</label><br>
        <input type="text" id="course_description" name="course_description"><br><br>
        <label for="course_code">Course Code:</label><br>
        <input type="text" id="course_code" name="course_code"><br><br>
        <label for="course_category">Course Category:</label><br>
        <input type="text" id="course_category" name="course_category"><br><br>
        <!-- <label for="course_instructor">Course Instructor:</label><br>
        <input type="text" id="course_instructor" name="course_instructor"><br><br> -->
        <label for="course_materials">Course Materials:</label><br>
        <input type="text" id="course_materials" name="course_materials"><br><br>
        <label for="course_prerequisites">Prerequisites:</label><br>
        <input type="text" id="course_prerequisites" name="course_prerequisites"><br><br>
        <label for="course_fees">Course Fees:</label><br>
        <input type="text" id="course_fees" name="course_fees"><br><br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>
