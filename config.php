<?php

require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$configuration = json_decode(@file_get_contents('config.json'));
if (empty($configuration)) {
	echo 'Configuration error.';
	exit;
}

$database = new PDO('pgsql:host=' . $configuration->database_host . ';dbname=gillyphotos', $configuration->database_username, $configuration->database_password, [
	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
	PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
]);

function sendEmail($to, $subject, $body) {
	global $configuration;

	$mail = new PHPMailer(true);
	$mail->isSMTP();
	$mail->Host = 'smtp.gmail.com';
	$mail->Port = 587;
	$mail->SMTPAuth = true;
	$mail->Username = $configuration->email_username;
	$mail->Password = $configuration->email_password;
	$mail->SMTPSecure = 'tls';

	$mail->setFrom($configuration->email_username, 'GillyPhotos');
	$mail->addAddress($to);
	$mail->isHTML(true);
	$mail->Subject = $subject;
	$mail->Body = $body;

	$mail->send();
}
