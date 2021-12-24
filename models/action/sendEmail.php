<?php
define("PASSWORD_EMAIL", "MasterNews247");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require $_SERVER['DOCUMENT_ROOT'] . '/e-news-master/mail/Exception.php';
require $_SERVER['DOCUMENT_ROOT'] . '/e-news-master/mail/PHPMailer.php';
require $_SERVER['DOCUMENT_ROOT'] . '/e-news-master/mail/SMTP.php';
$mail = new PHPMailer();
try {
    $mail->isSMTP();
    $mail->SMTPDebug = 0;
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 587; // TLS only 
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth = true;
    $mail->Username = 'masternews247@gmail.com'; // email 
    $mail->Password = PASSWORD_EMAIL; // password 
    $mail->setFrom($from, $usernameFrom); // From email and name 
    $mail->addAddress($to, $usernameTo); // to email and name 
    $mail->Subject = $subject;
    $mail->Body = $message;
    $mail->msgHTML($messageHTML);
    $mail->AltBody = 'testing';
    $mail->SMTPOptions = array('ssl' => array('verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true));
    if (!$mail->send()) {
        echo $mail->ErrorInfo;
    }
} catch (Exception $e) {
    echo $e->getMessage();
}
