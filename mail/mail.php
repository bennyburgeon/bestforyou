<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (
        empty($_POST["name"]) ||
        empty($_POST["email"]) ||
        empty($_POST["phone"]) ||
        empty($_POST["subject"]) ||
        empty($_POST["message"])
    ) {
        header("Location: ../contact.html?error=1");
        exit();
    }

    $name = htmlspecialchars($_POST["name"]);
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars($_POST["phone"]);
    $subject = htmlspecialchars($_POST["subject"]);
    $message = htmlspecialchars($_POST["message"]);

    // $to = "best4uclt@gmail.com";
    $to = "sanamol87@gmail.com";
    $email_subject = "New Contact Form Message: $subject";

    $email_body = "
        <h2>Contact Form Submission</h2>
        <p><strong>Name:</strong> $name</p>
        <p><strong>Email:</strong> $email</p>
        <p><strong>Phone:</strong> $phone</p>
        <p><strong>Message:</strong><br>$message</p>
    ";

    $headers = "From: $name <$email>\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/html\r\n";

    if (mail($to, $email_subject, $email_body, $headers)) {
        header("Location: ../contact.html?success=1");
        exit();
    } else {
        header("Location: ../contact.html?error=1");
        exit();
    }

} else {
    header("Location: ../contact.html?error=1");
    exit();
}
?>
