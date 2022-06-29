<?php
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require 'vendor/autoload.php';
require_once 'routes.php';

function verificateEmail($destine, $reason, $subject, $title) {
  $mail = new PHPMailer(true);
  try {
      //Server settings
      $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
      $mail->isSMTP();                                            //Send using SMTP
      $mail->Host       = SMTP_SERVER;                   //Set the SMTP server to send through
      $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
      $mail->Username   = SMTP_EMAIL;                             //SMTP username
      $mail->Password   = SMTP_PASS;                              //SMTP password
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
      $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
      //Recipients
      $mail->setFrom(SMTP_EMAIL, $title);
      $mail->addAddress($destine, 'Support');           /* La direccion que va a recibir el correo destinatario */
      $mail->addCC(SMTP_EMAIL);                       /* enviar Replica */
      //Content
      $mail->isHTML(true);                                        //Set email format to HTML
      $mail->Subject = $subject;
      $mail->Body    = $reason;
      $mail->send(); // Send email
  } catch (Exception $e) {
      echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
  }
}