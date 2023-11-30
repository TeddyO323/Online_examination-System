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
        /* Add this style block to your existing CSS */
select {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    background-color: #f8f8f8; /* Background color */
    color: #333; /* Text color */
}

select:hover {
    background-color: #e0e0e0; /* Hover background color */
}

select:focus {
    outline: none;
    border-color: #66afe9; /* Focus border color */
    box-shadow: 0 0 5px rgba(102, 175, 233, 0.6); /* Focus box shadow */
}

/* Style for the dropdown arrow */
select::after {
    content: '\25BC'; /* Unicode character for the down arrow */
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
    pointer-events: none;
}

/* Reset styles for Firefox */
select::-moz-focus-inner {
    border: 0;
    padding: 0;
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

                <!-- <label for="course_level">Course Level:</label><br>
                <select id="course_level" name="course_level">
    <option value="" disabled selected>Select Course Level</option>
    <option value="doctorate">Doctorate (Ph.D. or Doctoral Degree)</option>
    <option value="professional_degree">Professional Degree</option>
    <option value="masters">Master's Degree</option>
    <option value="bachelors">Bachelor's Degree</option>
    <option value="postgraduate">Postgraduate</option>
    <option value="undergraduate">Undergraduate</option>
    <option value="associate_degree">Associate Degree</option>
    <option value="diploma">Diploma</option>
    <option value="certificate">Certificate</option>
    <option value="continuing_education">Continuing Education</option>
    <option value="postdoctoral_studies">Postdoctoral Studies</option>
    <option value="non_degree_programs">Non-Degree Programs</option>
    <option value="online_courses_certifications">Online Courses and Certifications</option>
    <option value="other">Other</option>
</select><br><br> -->

                <label for="course_materials">Course Materials:</label><br>
                <input type="text" id="course_materials" name="course_materials"><br><br>

                <label for="course_prerequisites">Prerequisites:</label><br>
                <input type="text" id="course_prerequisites" name="course_prerequisites"><br><br>

                <input type="submit" value="Submit">
            </form>
        </div>
    </div>
</body>
</html>
