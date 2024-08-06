<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
require 'config.php';

function sentEmail($email, $token){
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';  // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                // Enable SMTP authentication
        $mail->Username   = FROM_EMAIL; // SMTP username
        $mail->Password   =  EMAIL_PASSWORD;     // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption; PHPMailer::ENCRYPTION_SMTPS encouraged
        $mail->Port       = 587;                 // TCP port to connect to

        // Recipients
        $mail->setFrom(FROM_EMAIL, 'Mailer');
        $mail->addAddress($email, 'Recipient Name'); // Add a recipient

        // Content
        $mail->isHTML(true);                      // Set email format to HTML
        $mail->Subject = 'Reset Password OTP';
        $mail->Body    = 'This is the OTP to reset you login Passowrd OTP- '. $token;

        $mail->send();
        return true;
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

?>
