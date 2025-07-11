<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer files
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name       = htmlspecialchars($_POST['name']);
    $email      = htmlspecialchars($_POST['email']);
    $phone      = htmlspecialchars($_POST['phone']);
    $role       = htmlspecialchars($_POST['role']);
    $experience = htmlspecialchars($_POST['experience']);

    // File upload
    $upload_dir = "uploads/";
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $file_tmp  = $_FILES["resume"]["tmp_name"];
    $file_name = basename($_FILES["resume"]["name"]);
    $target_file = $upload_dir . time() . "_" . $file_name;

    if (move_uploaded_file($file_tmp, $target_file)) {
        // Mail setup
        $mail = new PHPMailer(true);
        try {
            // SMTP server config
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com'; // SMTP server
            $mail->SMTPAuth   = true;
            $mail->Username   = 'arunkumar944392@gmail.com'; // your email
            $mail->Password   = 'hbid kkmv fqha kdwe'; // app-specific password or your SMTP pass
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            // Mail content
            $mail->setFrom('arunkumar944392@gmail.com', 'Career Application');
            $mail->addAddress('arunkumar944392@gmail.com'); // where you want to receive applications

            $mail->Subject = "New Career Application: $name";

            $body  = "<h2>New Application Details</h2>";
            $body .= "<p><strong>Name:</strong> $name</p>";
            $body .= "<p><strong>Email:</strong> $email</p>";
            $body .= "<p><strong>Phone:</strong> $phone</p>";
            $body .= "<p><strong>Role:</strong> $role</p>";
            $body .= "<p><strong>Experience:</strong> $experience</p>";

            $mail->isHTML(true);
            $mail->Body = $body;

            // Attach uploaded resume
            $mail->addAttachment($target_file);

            $mail->send();
            echo "<h2 style='color:green; text-align:center;'>Application submitted & emailed successfully!</h2>";
            echo "<p style='text-align:center;'><a href='index.html'>Back to Home</a></p>";

        } catch (Exception $e) {
            echo "<h2 style='color:red; text-align:center;'>Message could not be sent. Mailer Error: {$mail->ErrorInfo}</h2>";
        }

    } else {
        echo "<h2 style='color:red; text-align:center;'>Failed to upload resume.</h2>";
    }
} else {
    header("Location: index.html");
    exit();
}
?>
