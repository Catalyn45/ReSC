<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

global $mail;
$mail = new PHPMailer();

$mail->isSMTP();
//$mail->SMTPDebug  = 1;
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'ssl';
$mail->Username = 'ancutei.catalin@gmail.com';
$mail->Password = '<password>';
$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
$mail->Port = 465;
$mail->setFrom('ancutei.catalin@gmail.com');

$mail->isHTML(true);

function send_mail($address, $subject, $body) {
    global $mail;
    $mail->ClearAddresses();
    $mail->addAddress($address);
    $mail->Subject = $subject;
    $mail->Body = $body;
    return $mail->send();
}