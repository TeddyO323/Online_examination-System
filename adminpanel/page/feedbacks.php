<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examiner Panel</title>
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
            margin: 20px auto;
            max-width: 800px;
        }

        .card-header {
            padding: 10px 15px;
            background-color: #4ef037;
            color: #fff;
            font-size: 18px;
            margin-bottom: 15px;
            border-radius: 5px 5px 0 0;
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

        .no-feedback {
            text-align: center;
            color: #555;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="app-main__outer">
    <div class="app-main__inner">
    <div class="card">
        <div class="card-header">Feedback</div>
        <table>
            <thead>
                <tr>
                    <th>Feedback ID</th>
                    <th>Feedback Category</th>
                    <th>Feedback Type</th>
                    <th>Feedback Text</th>
                    <!-- <th>File Name</th> -->
                    <th>Submission Date</th>
                    <th>Examinee Registration Number</th>
                </tr>
            </thead>
            <tbody>

                <?php
                // Include the database connection file
                include('database.php');

                // Fetch all feedback for examiners
                $query = "SELECT * FROM feedback_tbl ORDER BY submission_date DESC";
                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                        ?>
                        <tr>
                            <td><?php echo $row['feedback_id']; ?></td>
                            <td><?php echo $row['feedback_category']; ?></td>
                            <td><?php echo $row['feedback_type']; ?></td>
                            <td><?php echo $row['feedback_text']; ?></td>
                            <td><?php echo $row['submission_date']; ?></td>
                            <td><?php echo $row['reg_no']; ?></td>
                        </tr>
                        <?php
                    }
                } else {
                    echo '<tr><td colspan="7" class="no-feedback">No feedback found</td></tr>';
                }
                ?>

            </tbody>
        </table>
    </div>
</body>
</html>
