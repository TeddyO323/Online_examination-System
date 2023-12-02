<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback History</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha384-rzv+ES9PZLWWR1xfJWgDXNdBPr8+j9Q4Sn6fkd5fsKG6pQ2zn0IEI3xs0tU9fWpi" crossorigin="anonymous">
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
        }
        .card-header {
            padding: 10px 15px;
            background-color: #e48d2a;
            color: #fff;
            font-size: 18px;
            margin-bottom: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .btn {
            padding: 6px 12px;
            font-size: 14px;
            border: 1px solid transparent;
            border-radius: 4px;
        }
        .btn-primary {
            color: #fff;
            background-color: #e48d2a;
            border-color: #e48d2a;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
    .action-button {
        display: inline-block;
        padding: 8px 12px;
        border: 1px solid #ccc;
        border-radius: 4px;
        text-decoration: none;
        margin-right: 5px;
    }

    .action-button:hover {
        background-color: #f0f0f0;
    }

    .delete-button {
        color: #fff;
        background-color: #dc3545;
        border-color: #dc3545;
    }

    .delete-button:hover {
        background-color: #c82333;
        border-color: #bd2130;
    }
    .edit-button {
        background-color: #e48d2a;
        color: white;
    }

    .edit-button:hover {
        background-color: #45a049;
    }
    </style>
</head>
<body>
    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="card">
                <div class="card-header">Feedback History</div>
                <table>
                    <thead>
                        <tr>
                            <th>Feedback ID</th>
                            <th>Feedback Category</th>
                            <th>Feedback Type</th>
                            <th>Feedback Text</th>
                            <th>File Name</th>
                            <th>Submission Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Include the database connection file
                        include('database.php');

                        // Start the PHP session
                        if (session_status() == PHP_SESSION_NONE) {
                            session_start();
                        }
                        // Check if the user is logged in
                        if (isset($_SESSION['reg_no'])) {
                            $regNo = $_SESSION['reg_no'];

                            // Fetch feedback history for the specific examinee
                            $query = "SELECT * FROM feedback_tbl WHERE reg_no = '$regNo' ORDER BY submission_date DESC";
                            $result = mysqli_query($conn, $query);

                            $counter = 0;
                            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                $counter++;
                                ?>
                                <tr class="<?php echo ($counter % 2 == 0) ? 'even' : 'odd'; ?>">
                                    <td><?php echo $row['feedback_id']; ?></td>
                                    <td><?php echo $row['feedback_category']; ?></td>
                                    <td>
                                        <?php
                                        echo '<i class="fa-icon ' . (($row['feedback_type'] == 'Anonymous') ? 'fas fa-user-secret' : 'far fa-user') . '"></i>';
                                        echo $row['feedback_type'];
                                        ?>
                                    </td>
                                    <td><?php echo $row['feedback_text']; ?></td>
                                    <td><?php echo $row['file_name']; ?></td>
                                    <td><?php echo $row['submission_date']; ?></td>
                                    <td class="actions">
                                        <span class="action-button edit-button" onclick="editFeedback(<?php echo $row['feedback_id']; ?>)">Edit</span>
                                        <span class="action-button delete-button" onclick="confirmDelete(<?php echo $row['feedback_id']; ?>)">Delete</span>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            // If not logged in, redirect to the login page or display an error message
                            header("Location: login_page.php");
                            exit();
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        function editFeedback(feedbackId) {
            // Implement edit functionality as needed
            // You may redirect the user to an edit page or show a modal
            console.log('Edit feedback with ID:', feedbackId);
        }

        function confirmDelete(feedbackId) {
            var confirmDelete = confirm('Are you sure you want to delete this feedback?');

            if (confirmDelete) {
                // Implement delete functionality as needed
                // You may use AJAX to send a request to the server for deletion
                console.log('Delete feedback with ID:', feedbackId);
            }
        }
    </script>
</body>
</html>
