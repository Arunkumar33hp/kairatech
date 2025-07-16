<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name       = htmlspecialchars($_POST['name']);
    $email      = htmlspecialchars($_POST['email']);
    $phone      = htmlspecialchars($_POST['phone']);
    $role       = htmlspecialchars($_POST['role']);
    $experience = htmlspecialchars($_POST['experience']);

    $upload_dir = "uploads/";
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $file_tmp  = $_FILES["resume"]["tmp_name"];
    $file_name = basename($_FILES["resume"]["name"]);
    $target_file = $upload_dir . time() . "_" . $file_name;

    if (move_uploaded_file($file_tmp, $target_file)) {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'arunkumar944392@gmail.com';
            $mail->Password   = 'hbid kkmv fqha kdwe'; // Gmail app password
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            $mail->setFrom('arunkumar944392@gmail.com', 'Career Application');
            $mail->addAddress('arunkumar944392@gmail.com');

            $mail->Subject = "New Career Application: $name";
            $mail->isHTML(true);
            $mail->Body = "
                <h2>New Application Details</h2>
                <p><strong>Name:</strong> $name</p>
                <p><strong>Email:</strong> $email</p>
                <p><strong>Phone:</strong> $phone</p>
                <p><strong>Role:</strong> $role</p>
                <p><strong>Experience:</strong> $experience</p>
            ";

            $mail->addAttachment($target_file);
            $mail->send();

            header("Location: carriers.html?application=success");
            exit();

        } catch (Exception $e) {
            header("Location: carriers.html?application=error");
            exit();
        }
    } else {
        header("Location: carriers.html?application=upload-failed");
        exit();
    }
} else {
    header("Location: carriers.html");
    exit();
}
