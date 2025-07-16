<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name    = htmlspecialchars($_POST['name']);
    $email   = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'arunkumar944392@gmail.com';
        $mail->Password   = 'hbid kkmv fqha kdwe'; // App password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('arunkumar944392@gmail.com', 'Website Contact');
        $mail->addAddress('arunkumar944392@gmail.com');

        $mail->isHTML(true);
        $mail->Subject = "New Contact Message from $name";
        $mail->Body = "
            <h3>Contact Message</h3>
            <p><strong>Name:</strong> {$name}</p>
            <p><strong>Email:</strong> {$email}</p>
            <p><strong>Message:</strong><br>{$message}</p>
        ";

        $mail->send();

        // Redirect to contact.html with success message
        header("Location: contact.html?status=success");
        exit();
    } catch (Exception $e) {
        // Redirect to contact.html with error message
        header("Location: contact.html?status=error");
        exit();
    }
} else {
    header("Location: contact.html");
    exit();
}
?>
