<?php
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require 'vendor/autoload.php';

function verificateEmail($destine, $reason, $subject, $title) {
  $mail = new PHPMailer(true);
  try {
      //Server settings
      $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
      $mail->isSMTP();                                            //Send using SMTP
      $mail->Host       = 'smtp.hostinger.com';                   //Set the SMTP server to send through
      $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
      $mail->Username   = 'support@alexisbr.com';                 //SMTP username
      $mail->Password   = 'secret';                               //SMTP password
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
      $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
      //Recipients
      $mail->setFrom('support@alexisbr.com', $title);
      $mail->addAddress($destine, 'Support');           /* La direccion que va a recibir el correo destinatario */
      $mail->addCC('support@alexisbr.com');                       /* enviar Replica */
      //Content
      $mail->isHTML(true);                                        //Set email format to HTML
      $mail->Subject = $subject;
      $mail->Body    = $reason;
      $mail->send(); // Send email
  } catch (Exception $e) {
      echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
  }
}