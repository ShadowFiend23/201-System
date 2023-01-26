<?php 
date_default_timezone_set('Asia/Manila');

require 'phpmailer/PHPMailerAutoload.php';

$mail = new PHPMailer;
$mail->isSMTP();
$mail->SMTPDebug = 2;
$mail->Debugoutput = 'html';
$mail->Host = "mail5018.site4now.net";
$mail->Port = 25;
$mail->SMTPAuth = true;
$mail->Username = "201notif@occcicoop.com";
$mail->Password = "P@ssw0rd";
$mail->setFrom('201notif@occcicoop.com', 'OCCCI Notifications');
$mail->addAddress('jumiljaderosales@gmail.com');
$mail->Subject = 'PHPMailer SMTP test';
$mail->msgHTML(file_get_contents('mail.php'), dirname(__FILE__));
$mail->AltBody = 'This is a plain-text message body';
$mail->addAttachment('phpmailer/examples/images/phpmailer_mini.png');


?>