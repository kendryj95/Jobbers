<?php
//Librerías para el envío de mail
include_once 'PHPMailer/class.phpmailer.php';
include_once 'PHPMailer/class.smtp.php';

/*
   
  private $smtpSecure = "ssl"; 
  private $from = "";
  private $fromName = "Jobbers Argentina";
*/

//Este bloque es importante
$mail = new PHPMailer();
$mail->
    IsSMTP();
$mail->SMTPAuth   = true;
$mail->SMTPSecure = "ssl";
$mail->Host       = "a2plcpnl0525.prod.iad2.secureserver.net";
$mail->Port       = 465;

//Agregamos el remitente
$mail->setFrom("administracion@jobbersargentina.net", "Jobbers Argentina");
//Nuestra cuenta
$mail->Username = 'administracion@jobbersargentina.net';
$mail->Password = '=E!74f$WC?8_'; //Su password

//Agregar destinatario
$mail->AddAddress($_POST['correo_cliente']); 
$mail->Subject = "Jobbers Argentina - Una empresa quiere contactarlo.";

$mail->Body = '
<!DOCTYPE html>
<html>
   <head>
      <title>
         correo
      </title>
   </head>

   <body>
    <strong>Mensaje:</strong><br>
    '.$_POST['detalle_cliente'].'<br><br>
    <strong>Información de contacto:</strong><br>
    Correo: '.$_POST['correo_empresa'].'<br>
    Teléfono: '.$_POST['telefono_empresa'].'<br>
   </body>    
</html>  
';

//Para adjuntar archivo

$mail->MsgHTML(utf8_decode($mail->Body));
$mail->charSet = "UTF-8";
//Avisar si fue enviado o no y dirigir al index
if ($mail->Send()) {
  echo "1";
    //header('Location:../index.php?res=1');
} else {
  echo "0";
    //header('Location:../index.php?res=0');
}
