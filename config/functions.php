<?php

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
require 'vendor/autoload.php';

function verificateEmail($destine, $code, $name) {
  $mail = new PHPMailer(true);
  try {
      //Server settings
      $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
      $mail->isSMTP();                                            //Send using SMTP
      $mail->Host       = 'smtp.hostinger.com';                     //Set the SMTP server to send through
      $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
      $mail->Username   = 'support@alexisbr.com';                     //SMTP username
      $mail->Password   = 'secretpassword';                               //SMTP password
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
      $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

      //Recipients
      $mail->setFrom('support@alexisbr.com', 'Suppoprt Register');
      $mail->addAddress($destine, 'Verification code'); /* La direccion que va a recibir el correo destinatario */
      $mail->addCC('support@alexisbr.com'); /* enviar Replica */

      //Content
      $mail->isHTML(true);                                  //Set email format to HTML
      $mail->Subject = 'Verify your email';
      $mail->Body    = 'Hey '. $name .' this is your code to verificate your email: '.$code;

      $mail->send();
      echo 'Message has been sent';
  } catch (Exception $e) {
      echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
  }
}