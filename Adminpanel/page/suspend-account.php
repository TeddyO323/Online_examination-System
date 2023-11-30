<?php
// Include the database connection
include 'database.php';

// Check if examinee_id is set in the URL
if (isset($_GET['id'])) {
    $examineeId = $_GET['id'];

    // Fetch examinee details from the database
    $examineeQuery = $conn->query("SELECT reg_no, exmne_fullname FROM examinee_tbl WHERE exmne_id = $examineeId");

    // Check if the query was successful
    if ($examineeQuery) {
        // Fetch the examinee details
        $examineeDetails = $examineeQuery->fetch_assoc();

        // Check if details are found
        if ($examineeDetails) {
            $examineeName = $examineeDetails['exmne_fullname'];
            $examineeRegNo = $examineeDetails['reg_no'];
        } else {
            // Handle if examinee details are not found
            echo "Examinee details not found.";
        }
    } else {
        // Handle if the query fails
        echo "Error fetching examinee details: " . $conn->error;
    }
} else {
    // Handle if examinee_id is not set in the URL
    echo "Examinee ID not provided.";
}

// Close the database connection
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suspend Account</title>
    <!-- Add your stylesheets and scripts here -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        .card {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 400px;
            margin: auto;
        }

        .btn {
            padding: 6px 12px;
            font-size: 14px;
            border: 1px solid transparent;
            border-radius: 4px;
            margin-right: 10px;
        }

        .btn-warning {
            color: #fff;
            background-color: #ffc107;
            border-color: #ffc107;
        }

        .btn-warning:hover {
            background-color: #e0a800;
            border-color: #e0a800;
        }
        /* Add these styles to your existing CSS styles */
form {
    max-width: 400px;
    margin: 0 auto;
}

label {
    display: block;
    margin-bottom: 5px;
}

input[type="datetime-local"],
select,
textarea {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    box-sizing: border-box;
}

button {
    background-color: #ffc107;
    color: #212529;
    border: 1px solid #ffc107;
    padding: 10px;
    cursor: pointer;
}

button:hover {
    background-color: #e0a800;
    border-color: #e0a800;
}

    </style>
</head>
<body>
    <div class="card">
        <h2>Suspend Account</h2>
        <form action="process-suspend-account.php" method="post">
    <p>Suspending Account for: <?php echo isset($examineeName) ? $examineeName . ' (' . $examineeRegNo . ')' : 'Unknown'; ?></p>
    
    <label for="duration">Suspension Duration:</label>
    <input type="datetime-local" name="duration" id="duration" >

    <label for="suspensionType">Suspension Type:</label>
    <select name="suspensionType" id="suspensionType" required>
        <option value="temporary">Temporary</option>
        <option value="indefinite">Indefinite</option>
        <option value="permanent">Permanent</option>
    </select>

    <label for="reason">Reason for Suspension:</label>
    <textarea name="reason" id="reason" placeholder="Enter the reason for suspension" rows="4" required></textarea>

    <input type="hidden" name="examineeId" value="<?php echo $examineeId; ?>">

    <button type="submit" class="btn btn-warning">Suspend Account</button>
</form>

    </div>
</body>
</html>
