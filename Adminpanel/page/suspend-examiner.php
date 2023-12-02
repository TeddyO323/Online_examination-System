<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suspend Examiner</title>
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
            width: 400px;
            margin: 0 auto;
            margin-top: 50px;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input, select {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
        }

        textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
        }

        button {
            padding: 10px;
            background-color: #4ef037;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="card">
    <h2>Suspend Examiner</h2>
    <?php
    // Retrieve examiner details from URL parameters
    $examinerId = $_GET['id'] ?? '';
    $examinerName = urldecode($_GET['name']) ?? '';
    $examinerRegNumber = urldecode($_GET['reg_number']) ?? '';
    ?>

    <form action="process-suspend-examiner.php" method="post">
        <input type="hidden" name="examinerId" value="<?php echo $examinerId; ?>">
        
        <label for="examinerName">Examiner Name:</label>
        <input type="text" name="examinerName" id="examinerName" value="<?php echo $examinerName; ?>" readonly>

        <label for="examinerRegNumber">Examiner Registration Number:</label>
        <input type="text" name="examinerRegNumber" id="examinerRegNumber" value="<?php echo $examinerRegNumber; ?>" readonly>

        <label for="duration">Suspension Duration:</label>
        <input type="datetime-local" name="duration" id="duration" required>

        <label for="suspensionType">Suspension Type:</label>
        <select name="suspensionType" id="suspensionType" required>
            <option value="temporary">Temporary</option>
            <option value="indefinite">Indefinite</option>
            <option value="permanent">Permanent</option>
        </select>

        <label for="reason">Reason for Suspension:</label>
        <textarea name="reason" id="reason" placeholder="Enter the reason for suspension" rows="4" required></textarea>

        <button type="submit">Suspend Account</button>
    </form>
</div>

</body>
</html>
