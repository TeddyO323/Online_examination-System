<?php
// Include the database connection file
include 'database.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Assume $_SESSION['reg_no'] contains the registration number of the logged-in examinee
$reg_no = $_SESSION['reg_no'];

// Fetch examinee details
$examineeQuery = "SELECT exmne_fullname FROM examinee_tbl WHERE reg_no = '$reg_no'";
$examineeResult = $conn->query($examineeQuery);

// Retrieve the exam title from the URL parameter
$examTitle = isset($_GET['examTitle']) ? $_GET['examTitle'] : '';

if ($examineeResult && $examineeRow = $examineeResult->fetch_assoc()) {
    $examineeName = $examineeRow['exmne_fullname'];

    // Other details you want to include in the certificate
    $examName = "Your Exam Name"; // Replace with actual exam name
    $examDate = "Your Exam Date"; // Replace with actual exam date

    // Certificate content with enhanced styles
    $certificateContent = "
        <html>
        <head>
            <title>Certificate of Completion</title>
            <style>
                body {
                    font-family: 'Arial', sans-serif;
                    margin: 20px;
                    text-align: center;

                }

                h1 {
                    color: #1a75ff;
                    margin-bottom: 20px;
                }

                h2 {
                    color: #333;
                }

                p {
                    color: #555;
                    margin: 10px 0;
                }

                h3 {
                    color: #1a75ff;
                }

                .congratulations {
                    color: #009900;
                    font-weight: bold;
                    font-size: 18px;
                    margin-top: 20px;
                }

                .button-container {
                    margin-top: 30px;
                }

                button {
                    padding: 10px;
                    font-size: 16px;
                    background-color: #1a75ff;
                    color: #fff;
                    border: none;
                    cursor: pointer;
                }

                button:hover {
                    background-color: #005bb5;
                }
            
           
               body {
    font-family: 'Arial', sans-serif;
    margin: 0;
    padding: 0;
    height: 100vh; /* Set the body height to full viewport height */
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #f0f0f0; /* Add a background color for better visibility */
}

.container {
    border: 20px solid tan;
    width: 750px;
    height: 563px;
    display: table-cell;
    vertical-align: middle;
    background-color: #fff; /* Set a background color for the certificate */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Add a subtle box shadow for depth */
}

/* Your existing styles... */
.logo {
    color: tan;
}

.marquee {
    color: tan;
    font-size: 48px;
    margin: 20px;
}

.assignment {
    margin: 20px;
}

.person {
    border-bottom: 2px solid black;
    font-size: 32px;
    font-style: italic;
    margin: 20px auto;
    width: 400px;
}

.reason {
    margin: 20px;
}

            </style>
        </head>
        <body>
        <div class='container'>
            <h1>Certificate of Completion</h1>
            <div class='assignment'> <p>This is to certify that</p></div>
            <div class='person'>
            <h2>$examineeName</h2>
            <p>Registration Number: $reg_no</p></div>
            <div class='reason'> <p>has successfully passed the exam:</p>
            <h3>$examTitle</h3> <!-- Use the exam title passed from the URL -->
            <p>Awarded on: $examDate</p></div>
            <p class='congratulations'>Congratulations!</p>

            </div>
        </body>
        </html>
    ";

    // Output the certificate content
    echo $certificateContent;
} else {
    echo "Error fetching examinee details.";
}
?>

