<?php
 session_start(); 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';
require __DIR__ . '/PHPMailer/src/Exception.php';



if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (
        empty($_POST["name"]) ||
        empty($_POST["email"]) ||
        empty($_POST["phone"]) ||
        empty($_POST["subject"]) ||
        empty($_POST["message"])
    )  {
        header("Location:https://best4ucareers.com/contact.php?error=1");
        exit();
    }



    $name = htmlspecialchars($_POST["name"]);
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars($_POST["phone"]);
    $subject = htmlspecialchars($_POST["subject"]);
    $message = htmlspecialchars($_POST["message"]);


    $email_body = "
        <h2>Contact Form Submission</h2>
        <p><strong>Name:</strong> $name</p>
        <p><strong>Email:</strong> $email</p>
        <p><strong>Phone:</strong> $phone</p>
        <p><strong>Message:</strong><br>$message</p>
    ";

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'recruiter@best4ucareers.com';
        $mail->Password   = 'Recru@best4u#1123';
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // $mail->SMTPDebug = 2;
        // $mail->Debugoutput = 'html';

        $mail->setFrom('recruiter@best4ucareers.com', 'BestForYou Enquiry');
        $mail->addReplyTo($email, $name);
//best4uclt@gmail.com
        // IMPORTANT: MUST HAVE THIS!!!
        $mail->addAddress('recruiter@best4ucareers.com');
        $mail->addAddress('sanarajan124@gmail.com');
         $mail->addAddress('mail.technoveda@gmail.com');

        $mail->isHTML(true);
        $mail->Subject = "Enquiry from BestForYou: $subject";
        $mail->Body    = $email_body;

       
        if ($mail->send()) {
    $_SESSION['success_message'] = "Your message has been sent successfully!";
} else {
    $_SESSION['error_message'] = "Something went wrong! Please try again.";
}
header("Location: https://best4ucareers.com/contact.php");        exit();

    } catch (Exception $e) {
    $_SESSION['error_message'] = "Mail failed! Please try again.";
    header("Location: https://best4ucareers.com/contact.php");
    exit();
}
}
?>
