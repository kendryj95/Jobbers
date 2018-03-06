<?php

  

  require 'vendor/phpmailer/class.phpmailer.php';

  require 'vendor/phpmailer/class.smtp.php';

  #require 'vendor/phpmailer/PHPMailerAutoload.php';


  $mail = new PHPMailer;



  $mail->SMTPDebug = 3;                               // Enable verbose debug output



  $mail->isSMTP();                                      // Set mailer to use SMTP

  $mail->Host = 'a2plcpnl0525.prod.iad2.secureserver.net';  // Specify main and backup SMTP servers

  $mail->SMTPAuth = true;                               // Enable SMTP authentication

  $mail->Username = 'administracion@jobbersargentina.net';                 // SMTP username

  $mail->Password = '=E!74f$WC?8_';                           // SMTP password

  $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted

  $mail->Port = 465;                                    // TCP port to connect to



  $mail->setFrom('administracion@jobbersargentina.net', 'Jobbers Argentina');

  $mail->addAddress('ortizkendry95@gmail.com', 'Kendry Ortiz');     // Add a recipient

  $mail->addAddress('ingvictorfernandezs@gmail.com', 'Victor Fernandez');     // Add a recipient



  $mail->isHTML(true);                                  // Set email format to HTML



  $mail->Subject = 'Prueba';

  $mail->Body    = 'Hola mundo';

  $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';



  if(!$mail->send()) {

      echo 'Message could not be sent.';

      echo 'Mailer Error: ' . $mail->ErrorInfo;

  } else {

      echo 'Message has been sent';

  }





?>