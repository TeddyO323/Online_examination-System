<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <div class="container">
        <form action="send_reset_link.php" method="post">
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Enter your email" required>
            </div>
            <div class="form-btn">
                <input type="submit" class="btn" value="Reset Password" name="submit">
            </div>
        </form>
    </div>
</body>

</html>
