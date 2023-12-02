<?php
session_start();

// Unset session variables and destroy the session
session_unset();
session_destroy();

// Redirect to the login page
header("Location: login.html");
exit;
?>
