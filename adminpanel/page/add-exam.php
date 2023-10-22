
<style>
    form {
        margin: auto;
        margin-top: 100px;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 5px;
        width: 400px; /* Adjusted width for the form */
        font-family: Arial, sans-serif;
    }
    h1 {
          
        }

    label {
        font-weight: bold;
        margin-bottom: 5px;
        display: inline-block;
        width: 200px; /* Width for the labels */
    }

    select,
    button,
    input,
    textarea {
        margin-bottom: 15px;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ddd;
        width: 100%; /* Adjusted width for the form elements */
        font-size: 16px;
    }

    button {
        background-color: #4CAF50;
        color: white;
        cursor: pointer;
    }

    button:hover {
        background-color: #45a049;
    }
</style>

<?php
include("database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $unitName = $_POST['unit_name']; // Retrieve the selected unit
    $courseName = $_POST['course_name']; // Retrieve the selected course
    $examTitle = $_POST['exam_title'];
    $examTimeLimit = $_POST['exam_time_limit'];
    $numOfQuestions = $_POST['num_of_questions'];
    $examDescription = $_POST['exam_description'];

    // Check if the exam already exists
    $existsQuery = "SELECT * FROM exam_tbl WHERE course_name = '$courseName' AND exam_title = '$examTitle' AND unit_name = '$unitName'";
    $result = $conn->query($existsQuery);

    if ($result->num_rows > 0) {
        echo "<script>alert('Exam already exists!');</script>";
    } else {
        $insertQuery = "INSERT INTO exam_tbl (course_name, exam_title, unit_name,  exam_time_limit, num_of_questions, exam_description) 
                        VALUES ('$courseName', '$examTitle','$unitName', '$examTimeLimit', '$numOfQuestions', '$examDescription')";

        if ($conn->query($insertQuery) === TRUE) {
            echo "<script>alert('Exam added successfully!');</script>";
        } else {
            echo "Error: " . $insertQuery . "<br>" . $conn->error;
        }
    }
}
?>





<?php
// Database connection
include("database.php");

// Fetch list of courses
$coursesQuery = $conn->query("SELECT * FROM course_tbl ORDER BY cou_id DESC");
$courses = [];

while ($row = $coursesQuery->fetch_assoc()) {
    $courses[] = $row;
}
?>
<body>
<!-- HTML code for the dropdown menus -->
<form action="index.php?page=add-exam" method="post" id="courseForm">
<h1 style="text-align: center;">Add Exam</h1>

    <label for="course_name">Select Course:</label><br>
    <select name="course_name" id="courseSelect">
        <option value="" disabled selected>Select a course</option>
        <?php foreach ($courses as $course) : ?>
            <option value="<?php echo $course['course_name']; ?>"><?php echo $course['course_name']; ?></option>
        <?php endforeach; ?>
    </select>
    <br>
    <label for="unit_name">Select Unit:</label><br>
    <select name="unit_name" id="unitSelect">
        <!-- Options will be dynamically populated via JavaScript -->
    </select>
    <br>
    </select>
    <br>
    <label for="exam_title">Exam Title:</label><br>
    <input type="text" name="exam_title" id="exam_title" required>
    <br>
    <label for="exam_time_limit">Exam Time Limit (in minutes):</label><br>
    <input type="number" name="exam_time_limit" id="exam_time_limit" min="1" required>
    <br>
    <label for="num_of_questions">Number of Questions to Display:</label><br>
    <input type="number" name="num_of_questions" id="num_of_questions" min="1" required>
    <br>
    <label for="exam_description">Exam Description:</label><br>
    <textarea name="exam_description" id="exam_description" rows="4" required></textarea>
    <br>
    <button type="submit">Submit</button>
</form>

<script>
    const courseSelect = document.getElementById('courseSelect');
    const unitSelect = document.getElementById('unitSelect');

    courseSelect.addEventListener('change', function() {
        const selectedCourse = courseSelect.value;
        fetchUnits(selectedCourse);
    });

    function fetchUnits(selectedCourse) {
        // AJAX call to fetch units based on the selected course
        fetch('page/get_units.php?course=' + selectedCourse)
            .then(response => response.json())
            .then(data => {
                // Clear existing options
                unitSelect.innerHTML = '';
                // Add new options based on the fetched data
                data.forEach(unit => {
                    const option = document.createElement('option');
                    option.value = unit.unit_name;
                    option.text = unit.unit_name;
                    unitSelect.appendChild(option);
                });
            });
    }
</script>
</body>

