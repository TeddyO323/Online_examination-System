<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Your head content here -->
    <style>
        .examiner-container {
            margin: auto;
        margin-top: 100px;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 5px;
        width: 70%; /* Adjusted width for the form */
        font-family: Arial, sans-serif;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);

        }
        .my-exams-container{
            border: 1px solid #dddddd;
            border-radius: 5px;
            padding: 10px;
            margin: 10px;
            width: 100%;
        }
        .my-exams-container:hover{
            background-color: #e2e2e2;

        }
        .courses-container {
            border: 1px solid #dddddd;
            border-radius: 5px;
            padding: 10px;
            margin: 10px;
            width: 100%;
        }

        .courses-container:hover {
            background-color: #e2e2e2;
        }
        
        .examiner-details {
            border: 1px solid #dddddd;
            border-radius: 5px;
            padding: 10px;
            margin: 10px;
            width: 100%;
            
        }
        .examiner-details:hover {
            background-color: #e2e2e2;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 6px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="examiner-container">
            <h2 style="text-align: center;">My Information</h2>

                <?php
                include("database.php");

                // Assuming the examiner number is stored in a session variable after login
                $examinerNumber = $_SESSION['examiner_number'];

                // Fetch the examiner information based on the current examiner's ID
                $sql = "SELECT * FROM examiner_tbl WHERE examiner_number = '$examinerNumber'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Display the examiner information in a row format
                    $row = $result->fetch_assoc();
                    echo '<div class="examiner-details">';
                    echo '<p><strong>Examiner Number:</strong> ' . $row["examiner_number"] . '</p>';
                    echo '<p><strong>Examiner Name:</strong> ' . $row["examiner_name"] . '</p>';
                    echo '<p><strong>Examiner Email:</strong> ' . $row["examiner_email"] . '</p>';
                    echo '<p><strong>Contact Number:</strong> ' . $row["contact_number"] . '</p>';
                    echo '<p><strong>Address:</strong> ' . $row["address"] . '</p>';
                    echo '<p><strong>Date of Birth:</strong> ' . $row["date_of_birth"] . '</p>';
                    echo '<p><strong>Certification:</strong> ' . $row["certification"] . '</p>';
                    echo '<p><strong>Gender:</strong> ' . $row["gender"] . '</p>';
                    echo '<p><strong>Department:</strong> ' . $row["department"] . '</p>';
                    echo '<p><strong>Role:</strong> ' . $row["role"] . '</p>';
                    echo '<p><strong>Access Level:</strong> ' . $row["access_level"] . '</p>';
                    echo '<p><strong>Joining Date:</strong> ' . $row["joining_date"] . '</p>';
                    echo '<button onclick="editExaminer(' . $row["examiner_number"] . ')">Edit</button>';
                    echo '</div>';
                } else {
                    echo "0 results";
                }

                // Close the first database connection
                $conn->close();
                ?>
                  <div class="courses-container">
    <h2 style="text-align: center;">My Units</h2>
    <table>
        <?php
        include("database.php");

        // Check the database connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Fetch all the examiner courses from the exam_tbl based on the examiner number
        $sql = "SELECT * FROM exam_tbl WHERE examiner_number = '$examinerNumber'";
        $result = $conn->query($sql);

        if ($result) {
            if ($result->num_rows > 0) {
                // Display the examiner courses in a table
                echo "<tr><th>Unit Name</th></tr>";
                while($row = $result->fetch_assoc()) {
                    echo "<tr><td>" . $row["unit_name"] . "</td></tr>";
                }
            } else {
                echo "<tr><td>No units found</td></tr>";
            }
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Close the second database connection
        $conn->close();
        ?>
    </table>
  

</div>
<div class="my-exams-container">
  <h2 style="text-align: center;">My Exams</h2>
  <table>
    <?php
      include("database.php");

      // Check the database connection
      if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
      }

      $examinerNumber = $_SESSION['examiner_number'];

      // Fetch the exams for the specific examiner from the exam_tbl
      $sql = "SELECT exam_title FROM exam_tbl WHERE examiner_number = '$examinerNumber'";
      $result = $conn->query($sql);

      if ($result) {
          if ($result->num_rows > 0) {
              // Display the exams in a table
              echo "<tr><th>Exam Title</th></tr>";
              while($row = $result->fetch_assoc()) {
                  echo "<tr><td>" . $row["exam_title"] . "</td></tr>";
              }
          } else {
              echo "<tr><td>No exams found</td></tr>";
          }
      } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
      }

      $conn->close();
    ?>
  </table>
</div>

                </div>
            </div>
            
            <script>
                function editExaminer(examinerNumber) {
                    window.location.href = 'index.php?page=edit-examiner&examiner_number=' + examinerNumber;
                }
            </script>
        </div>
    </div>
</body>
</html>