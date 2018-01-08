<?php

require_once("$_SERVER[DOCUMENT_ROOT]/vendor/phpmailer/class.phpmailer.php");
require_once("$_SERVER[DOCUMENT_ROOT]/vendor/phpmailer/class.smtp.php");

Class Email {

	private $host = "smtp.1and1.com";
	private $smtpAuth = true;
	private $userName = "empleos@jobbersargentina.com";
	private $password = "Paviliong11+";
	private $smtpSecure = "tls";
	private $port = 25;
	private $from = "administracion@jobbers.com";
	private $fromName = "Jobbers Argentina";


	public function email_chat($emisorMsg,$destEmail,$destName, $msg){

		$mail = new PHPMailer;
		$mail->isSMTP();
		$mail->Host = $this->host;
		$mail->SMTPAuth = $this->smtpAuth;
		$mail->Username = $this->userName;
		$mail->Password = $this->password;
		$mail->SMTPSecure = $this->smtpSecure;
		$mail->Port = $this->port;

		$mail->setFrom($this->from, $this->fromName);
		$mail->addAddress($destEmail, $destName);

		$mail->isHTML(true);

		$contenido = '<!DOCTYPE html>
		<html lang="en">

		<head>
		    <meta charset="UTF-8">
		    <meta name="viewport" content="width=device-width, initial-scale=1.0">
		    <meta http-equiv="X-UA-Compatible" content="ie=edge">
		    <title>Document</title>
		</head>

		<body>

		    <table style="max-width: 600px; padding: 10px; margin:0 auto; border-collapse: collapse; border: 1px solid #bdc0c1">
		        <tr>
		            <td style="background-color: #fff; text-align: left; padding: 0">
		                <a href="#" style="text-decoration: none;">
		                    <img width="30%" style="display:inline; margin: 20px 3% 0px 3%" src="https://jobbersargentina.com/img/logo.png">
		                </a>
		                <div style="display: inline-block;margin:32px 0; float: right">
		                    <a href="https://www.facebook.com/jobbersargentina" style="text-decoration: none; margin-right: 10px;">
		                        <img src="https://jobbersargentina.com/img/email/fb.png" alt="FB">
		                    </a>
		                    <a href="https://www.instagram.com/jobbersargentina/" style="text-decoration: none; margin-right: 10px;">
		                        <img src="https://jobbersargentina.com/img/email/brand2.png" alt="IG">
		                    </a>
		                    <a href="https://jobbersargentina.com/" style="text-decoration: none; margin-right: 10px;">
		                        <img src="https://jobbersargentina.com/img/email/sphere.png" alt="WEB">
		                    </a>
		                </div>
		            </td>
		        </tr>

		        <tr>
		            <td style="padding: 0; background-color: rgba(0, 174, 239, 0.3); text-align: center; font-family: sans-serif">
		                <h2 style="color: #3F429A">Nueva Notificación !</h2>
		                <!-- <img style="padding: 0; display: block" src="https://s19.postimg.org/y5abc5ryr/alola_region.jpg" width="100%"> -->
		            </td>
		        </tr>

		        <tr>
		            <td style="background-color: #fff; padding-bottom: 20px;">
		                <div style="color: #34495e; margin: 4% 10% 2%; text-align: justify;font-family: sans-serif">
		                    <h2 style="color:#3F429A; margin: 0 0 7px">Hola '.$destName.'!</h2>
		                    <p style="margin: 2px; font-size: 15px">
		                        '.$emisorMsg.' te ha enviado un nuevo mensaje: </p>
		                        <ul style="font-size: 15px;  margin: 10px 0">
		                            <li>'.$msg.'.</li>
		                        </ul>
		                        <div style="width: 100%; text-align: center; margin-top: 40px;">
		                            <a style="text-decoration: none; border-radius: 5px; padding: 11px 23px; color: white; background-color: #3498db" href="https://jobbersargentina.com">Responder el Mensaje</a>
		                        </div>
		                </div>
		            </td>
		        </tr>
		        <tr style="border-top: 1px solid #bdc0c1">
		            <td style="background-color: rgba(0, 174, 239, 0.3); padding-bottom: 20px;">
		                <p style="color:#3F429A; font-size: 14px; text-align: center;margin: 20px 0 0; font-family: sans-serif">Visitanos en</p>
		                <div style="display:block;margin:20px 0; text-align: center;">
		                    <a href="https://www.facebook.com/jobbersargentina" style="text-decoration: none; margin-right: 10px;">
		                        <img src="https://jobbersargentina.com/img/email/fb.png" alt="FB" style="width: 20px; height: 20px;">
		                    </a>
		                    <a href="https://www.instagram.com/jobbersargentina/" style="text-decoration: none; margin-right: 10px;">
		                        <img src="https://jobbersargentina.com/img/email/brand2.png" alt="IG" style="width: 20px; height: 20px;">
		                    </a>
		                    <a href="https://jobbersargentina.com/" style="text-decoration: none; margin-right: 10px;">
		                        <img src="https://jobbersargentina.com/img/email/sphere.png" alt="WEB" style="width: 20px; height: 20px;">
		                    </a>
		                </div>
		                <p style="color:#3F429A; font-size: 12px; text-align: center;margin: 30px 0 0; font-weight: bolder; font-family: sans-serif">© 2017 - 2018 | Jobbers - Todos los derechos reservados</p>
		            </td>
		        </tr>
		    </table>
		</body>

		</html>';

		$mail->Subject = "Nuevo mensaje de " . $emisorMsg;
		$mail->Body    = $contenido;

		if(!$mail->send()) {
		  return false;
		} else {
		  return true;
		}

	}

	public function userForgotPass($destEmail,$destName, $code){

		$mail = new PHPMailer;
		$mail->isSMTP();
		$mail->Host = $this->host;
		$mail->SMTPAuth = $this->smtpAuth;
		$mail->Username = $this->userName;
		$mail->Password = $this->password;
		$mail->SMTPSecure = $this->smtpSecure;
		$mail->Port = $this->port;

		$mail->setFrom($this->from, $this->fromName);
		$mail->addAddress($destEmail, $destName);

		$mail->isHTML(true);

		$contenido = '<!DOCTYPE html>
		<html lang="en">

		<head>
		    <meta charset="UTF-8">
		    <meta name="viewport" content="width=device-width, initial-scale=1.0">
		    <meta http-equiv="X-UA-Compatible" content="ie=edge">
		    <title>Document</title>
		</head>

		<body>

		    <table style="max-width: 600px; padding: 10px; margin:0 auto; border-collapse: collapse; border: 1px solid #bdc0c1">
		        <tr>
		            <td style="background-color: #fff; text-align: left; padding: 0">
		                <a href="#" style="text-decoration: none;">
		                    <img width="30%" style="display:inline; margin: 20px 3% 0px 3%" src="https://jobbersargentina.com/img/logo.png">
		                </a>
		                <div style="display: inline-block;margin:32px 0; float: right">
		                    <a href="https://www.facebook.com/jobbersargentina" style="text-decoration: none; margin-right: 10px;">
		                        <img src="https://jobbersargentina.com/img/email/fb.png" alt="FB">
		                    </a>
		                    <a href="https://www.instagram.com/jobbersargentina/" style="text-decoration: none; margin-right: 10px;">
		                        <img src="https://jobbersargentina.com/img/email/brand2.png" alt="IG">
		                    </a>
		                    <a href="https://jobbersargentina.com/" style="text-decoration: none; margin-right: 10px;">
		                        <img src="https://jobbersargentina.com/img/email/sphere.png" alt="WEB">
		                    </a>
		                </div>
		            </td>
		        </tr>

		        <tr>
		            <td style="padding: 0; background-color: rgba(0, 174, 239, 0.3); text-align: center; font-family: sans-serif">
		                <h2 style="color: #3F429A">Recuperar contraseña !</h2>
		                <!-- <img style="padding: 0; display: block" src="https://s19.postimg.org/y5abc5ryr/alola_region.jpg" width="100%"> -->
		            </td>
		        </tr>

		        <tr>
		            <td style="background-color: #fff; padding-bottom: 20px;">
		                <div style="color: #34495e; margin: 4% 10% 2%; text-align: justify;font-family: sans-serif">
		                    <h2 style="color:#3F429A; margin: 0 0 7px">Hola '.$destName.'!</h2>
		                    <p style="margin: 2px; font-size: 15px"> No hay de qué preocuparse, puedes restablecer tu contraseña de JOBBERS introduciendo el siguiente código:</p>
		                        <ul style="font-size: 15px;  margin: 10px 0">
		                            <li>'.$code.'.</li>
		                        </ul>
		                        <p style="margin: 2px; font-size: 15px">Si no solicitaste el restablecimiento de tu contraseña, puedes borrar este correo y continuar disfrutando de JOBBERS.</p>

		                        <p style="margin: 2px; font-size: 15px">El equipo JOBBERS</p>
		                </div>
		            </td>
		        </tr>
		        <tr style="border-top: 1px solid #bdc0c1">
		            <td style="background-color: rgba(0, 174, 239, 0.3); padding-bottom: 20px;">
		                <p style="color:#3F429A; font-size: 14px; text-align: center;margin: 20px 0 0; font-family: sans-serif">Visitanos en</p>
		                <div style="display:block;margin:20px 0; text-align: center;">
		                    <a href="https://www.facebook.com/jobbersargentina" style="text-decoration: none; margin-right: 10px;">
		                        <img src="https://jobbersargentina.com/img/email/fb.png" alt="FB" style="width: 20px; height: 20px;">
		                    </a>
		                    <a href="https://www.instagram.com/jobbersargentina/" style="text-decoration: none; margin-right: 10px;">
		                        <img src="https://jobbersargentina.com/img/email/brand2.png" alt="IG" style="width: 20px; height: 20px;">
		                    </a>
		                    <a href="https://jobbersargentina.com/" style="text-decoration: none; margin-right: 10px;">
		                        <img src="https://jobbersargentina.com/img/email/sphere.png" alt="WEB" style="width: 20px; height: 20px;">
		                    </a>
		                </div>
		                <p style="color:#3F429A; font-size: 12px; text-align: center;margin: 30px 0 0; font-weight: bolder; font-family: sans-serif">© 2017 - 2018 | Jobbers - Todos los derechos reservados</p>
		            </td>
		        </tr>
		    </table>
		</body>

		</html>';

		$mail->Subject = "JOBBERS - Recuperacion de contraseña";
		$mail->Body    = $contenido;

		if(!$mail->send()) {
		  return false;
		} else {
		  return true;
		}

	}


}


?>