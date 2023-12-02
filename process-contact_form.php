<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $subject = htmlspecialchars($_POST["subject"]);
    $comment = htmlspecialchars($_POST["comment"]);

    // Validate form data (add more validation as needed)
    if (empty($name) || empty($email) || empty($subject) || empty($comment)) {
        // Handle validation errors, e.g., redirect back to the form with an error message
        header("Location: contact.html?error=Please fill in all fields");
        exit();
    }

    // Send an email
    $to = "omosh60@gmail.com";
    $headers = "From: $email";
    $message = "Name: $name\nEmail: $email\nSubject: $subject\nComment: $comment";

    // Use additional headers for content type and encoding
    $headers .= "\r\nContent-type: text/plain; charset=UTF-8";

    // Send the email
    $mailSent = mail($to, "New Contact Form Submission", $message, $headers);

    // Check if the email was sent successfully
    if ($mailSent) {
        // Redirect to a success page or display a success message
        header("Location: success_page.php");
        exit();
    } else {
        // Handle the case where the email failed to send
        header("Location: contact.html?error=Sorry, there was an error submitting your form. Please try again later.");
        exit();
    }
} else {
    // If the form is not submitted, redirect back to the form page
    header("Location: contact.html");
    exit();
}
?>
