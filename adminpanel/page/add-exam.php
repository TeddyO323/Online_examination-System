
<style>
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
        background-color: #4ef037;
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
    $courseName = $_POST['course_name'];
    $examinerNumber = $_POST['examiner_number'];
    $examinerName = $_POST['examiner_name'];
    $examTitle = $_POST['exam_title'];
    $examTimeLimit = $_POST['exam_time_limit'];
    $examDescription = $_POST['exam_description'];
    $maxLeaveAttempts = $_POST['max_leave_attempts']; // New field
    $Attempts = $_POST['no_of_attempts']; // New field
        // Assuming form fields are named 'examStartDate', 'examStartTime', 'examEndDate', 'examEndTime'
        $examStartDate = $_POST['examStartDate'];
        $examStartTime = $_POST['examStartTime'];
        $examEndDate = $_POST['examEndDate'];
        $examEndTime = $_POST['examEndTime'];
        $examTimeLimitInMinutes = isset($_POST['exam_time_limit']) ? (int)$_POST['exam_time_limit'] : 0;
        
    $existsQuery = "SELECT * FROM exam_tbl WHERE course_name = '$courseName' AND exam_title = '$examTitle'";
    $result = $conn->query($existsQuery);


    
        // Combine start and end date/times into datetime strings
        $examStartDateTime = $examStartDate . ' ' . $examStartTime;
        $examEndDateTime = $examEndDate . ' ' . $examEndTime;
        // Calculate the expected end datetime based on the start datetime and time limit
        $expectedEndDateTime = date('Y-m-d H:i:s', strtotime($examStartDateTime) + $examTimeLimitInMinutes * 60);

        // Check if the actual end datetime is later than or equal to the expected end datetime
        if ($examEndDateTime < $expectedEndDateTime) {
            echo '<script>alert("Error: Exam end datetime should be at least ' . $examTimeLimitInMinutes . ' minutes after the start datetime.");</script>';
            exit; // Optionally, you can redirect or handle the error as needed
        }
    

    if ($result->num_rows > 0) {
        echo "<script>alert('Exam already exists!');</script>";
    } else {
        $insertQuery = "INSERT INTO exam_tbl (course_name, exam_title,  examiner_number, examiner_name, exam_time_limit,  exam_description, max_leave_attempts, attempts_allowed, exam_start_datetime, exam_end_datetime) 
                        VALUES ('$courseName', '$examTitle', '$examinerNumber', '$examinerName', '$examTimeLimit',  '$examDescription', '$maxLeaveAttempts','$Attempts','$examStartDateTime', '$examEndDateTime')";

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
<div class="app-main__outer">
        <div class="app-main__inner">
        <h1 style="text-align: center;">Add Exam</h1>

<!-- HTML code for the dropdown menus -->
<form action="index.php?page=add-exam" method="post" id="courseForm">

    <label for="course_name">Select Course:</label><br>
    <select name="course_name" id="courseSelect">
        <option value="" disabled selected>Select a course</option>
        <?php foreach ($courses as $course) : ?>
            <option value="<?php echo $course['course_name']; ?>"><?php echo $course['course_name']; ?></option>
        <?php endforeach; ?>
    </select>
    <br>
    <!-- <label for="unit_name">Select Unit:</label><br>
    <select name="unit_name" id="unitSelect"> -->
        <!-- Options will be dynamically populated via JavaScript -->
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
    </select>
    <br>
    </select>
    <br>
    <label for="exam_title">Exam Title:</label><br>
    <input type="text" name="exam_title" id="exam_title" required>
    <br>
    <label for="examiner_number">Examiner Number:</label><br>
<select name="examiner_number" id="examiner_number_select">
    <option value="" disabled selected>Select an Examiner Number</option>
    <?php
    include("database.php");
    $examinerQuery = "SELECT examiner_number FROM examiner_tbl";
    $examinerResult = $conn->query($examinerQuery);
    if ($examinerResult->num_rows > 0) {
        while ($row = $examinerResult->fetch_assoc()) {
            echo "<option value='" . $row['examiner_number'] . "'>" . $row['examiner_number'] . "</option>";
        }
    }
    ?>
</select>
<br>
<label for="examiner_name">Examiner Name:</label><br>
<select name="examiner_name" id="examiner_name_select">
    <!-- Options will be dynamically populated via JavaScript -->
</select>

<script>
    const examinerNumberSelect = document.getElementById('examiner_number_select');

    examinerNumberSelect.addEventListener('change', function () {
        const examinerNumber = examinerNumberSelect.value;
        fetchExaminerDetails(examinerNumber);
    });

    function fetchExaminerDetails(examinerNumber) {
        fetch('page/get_examiner_details.php?examiner_number=' + examinerNumber)
            .then(response => response.json())
            .then(data => {
                const examinerNameSelect = document.getElementById('examiner_name_select');
                examinerNameSelect.innerHTML = ''; // Clear the previous options

                const option = document.createElement('option');
                option.value = data.examiner_name;
                option.text = data.examiner_name;
                examinerNameSelect.appendChild(option);
            })
            .catch(error => console.error('Error fetching examiner details:', error));
    }
</script>


</select>
<br>
<label for="examStartDate">Exam Start Date:</label>
<input type="date" id="examStartDate" name="examStartDate">
<br>

<label for="examStartTime">Exam Start Time:</label>
<input type="time" id="examStartTime" name="examStartTime">
<br>

<label for="examEndDate">Exam End Date:</label>
<input type="date" id="examEndDate" name="examEndDate">
<br>

<label for="examEndTime">Exam End Time:</label>
<input type="time" id="examEndTime" name="examEndTime">


<br>

    <label for="exam_time_limit">Exam Time Limit (in minutes):</label><br>
    <input type="number" name="exam_time_limit" id="exam_time_limit" min="1" required>
    <br>
    <label for="no_of_attempts">Number of Attempts:</label><br>
    <input type="number" name="no_of_attempts" id="no_of_attempts" min="0" required>
    <br>
   
    <label for="max_leave_attempts">Max Leave Attempts:</label><br>
    <input type="number" name="max_leave_attempts" id="max_leave_attempts" min="0" required>
    <br>
   
    <label for="exam_description">Exam Description:</label><br>
    <textarea name="exam_description" id="exam_description" rows="4" required></textarea>
    <br>
    <button type="submit" id="submitButton">Submit</button>
</form>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var examStartDate = document.getElementById('examStartDate');
        var examStartTime = document.getElementById('examStartTime');
        var examEndDate = document.getElementById('examEndDate');
        var examEndTime = document.getElementById('examEndTime');
        var submitButton = document.getElementById('submitButton'); // Adjust the actual ID

        submitButton.addEventListener('click', function (event) {
            var startDateTime = new Date(examStartDate.value + ' ' + examStartTime.value);
            var endDateTime = new Date(examEndDate.value + ' ' + examEndTime.value);

            // Check if the end date/time is before or equal to the start date/time
            if (endDateTime <= startDateTime) {
                alert('Ending date and time cannot be before or equal to starting date and time.');
                event.preventDefault(); // Prevent form submission
            }
        });
    });
</script>


<!-- Your existing HTML code -->
</div>
</div>
</body>
