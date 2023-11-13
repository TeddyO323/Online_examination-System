<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View All Units</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #e2e2e2;
        }
    </style>
</head>
<body>
    <div class="app-main__outer">
        <div class="app-main__inner">
            <h2>Units List</h2>
            <table>
                <tr>
                    <th>Unit Name</th>
                    <th>Unit Code</th>
                    <th>Course Name</th>
                </tr>
                <?php
                    include("database.php");

                    // Fetch all units from units_tbl
                    $sql = "SELECT * FROM units_tbl";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["unit_name"] . "</td>";
                            echo "<td>" . $row["unit_code"] . "</td>";
                            echo "<td>" . $row["course_name"] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>0 results</td></tr>";
                    }

                    // Close the database connection
                    $conn->close();
                ?>
            </table>
        </div>
    </div>
</body>
</html>
