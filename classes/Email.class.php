<?php

$dir = '';
if ($_SERVER["SERVER_NAME"] == "localhost") {
	$dir = $_SERVER["DOCUMENT_ROOT"] . "/jobbers";
} else {
	$dir = $_SERVER["DOCUMENT_ROOT"];
}

require_once("$dir/vendor/phpmailer/class.phpmailer.php");
require_once("$dir/vendor/phpmailer/class.smtp.php");

Class Email {

	private $host = "a2plcpnl0525.prod.iad2.secureserver.net";
	private $smtpAuth = true;
	private $userName = "administracion@jobbersargentina.net";
	private $password = '=E!74f$WC?8_';
	private $smtpSecure = "ssl";
	private $port = 465;
	private $from = "administracion@jobbersargentina.net";
	private $fromName = "Jobbers Argentina";

	public function email_chat($emisorMsg,$destEmail,$destName, $msg){

		$mail = new PHPMailer;
		$mail->isSMTP();
		$mail->Host = $this->host;
		$mail->Helo =$this->host; //Muy importante para que llegue a hotmail y otros
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
		                    <img width="30%" style="display:inline; margin: 20px 3% 0px 3%" src="https://jobbersargentina.net/img/logo.png">
		                </a>
		                <div style="display: inline-block;margin:32px 0; float: right">
		                    <a href="https://www.facebook.com/jobbersargentina" style="text-decoration: none; margin-right: 10px;">
		                        <img src="https://jobbersargentina.net/img/email/fb.png" alt="FB">
		                    </a>
		                    <a href="https://www.instagram.com/jobbersargentina/" style="text-decoration: none; margin-right: 10px;">
		                        <img src="https://jobbersargentina.net/img/email/brand2.png" alt="IG">
		                    </a>
		                    <a href="https://jobbersargentina.net/" style="text-decoration: none; margin-right: 10px;">
		                        <img src="https://jobbersargentina.net/img/email/sphere.png" alt="WEB">
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
		                            <a style="text-decoration: none; border-radius: 5px; padding: 11px 23px; color: white; background-color: #3498db" href="https://jobbersargentina.net">Responder el Mensaje</a>
		                        </div>
		                </div>
		            </td>
		        </tr>
		        <tr style="border-top: 1px solid #bdc0c1">
		            <td style="background-color: rgba(0, 174, 239, 0.3); padding-bottom: 20px;">
		                <p style="color:#3F429A; font-size: 14px; text-align: center;margin: 20px 0 0; font-family: sans-serif">Visitanos en</p>
		                <div style="display:block;margin:20px 0; text-align: center;">
		                    <a href="https://www.facebook.com/jobbersargentina" style="text-decoration: none; margin-right: 10px;">
		                        <img src="https://jobbersargentina.net/img/email/fb.png" alt="FB" style="width: 20px; height: 20px;">
		                    </a>
		                    <a href="https://www.instagram.com/jobbersargentina/" style="text-decoration: none; margin-right: 10px;">
		                        <img src="https://jobbersargentina.net/img/email/brand2.png" alt="IG" style="width: 20px; height: 20px;">
		                    </a>
		                    <a href="https://jobbersargentina.net/" style="text-decoration: none; margin-right: 10px;">
		                        <img src="https://jobbersargentina.net/img/email/sphere.png" alt="WEB" style="width: 20px; height: 20px;">
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
		                    <img width="30%" style="display:inline; margin: 20px 3% 0px 3%" src="https://jobbersargentina.net/img/logo.png">
		                </a>
		                <div style="display: inline-block;margin:32px 0; float: right">
		                    <a href="https://www.facebook.com/jobbersargentina" style="text-decoration: none; margin-right: 10px;">
		                        <img src="https://jobbersargentina.net/img/email/fb.png" alt="FB">
		                    </a>
		                    <a href="https://www.instagram.com/jobbersargentina/" style="text-decoration: none; margin-right: 10px;">
		                        <img src="https://jobbersargentina.net/img/email/brand2.png" alt="IG">
		                    </a>
		                    <a href="https://jobbersargentina.net/" style="text-decoration: none; margin-right: 10px;">
		                        <img src="https://jobbersargentina.net/img/email/sphere.png" alt="WEB">
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
		                        <img src="https://jobbersargentina.net/img/email/fb.png" alt="FB" style="width: 20px; height: 20px;">
		                    </a>
		                    <a href="https://www.instagram.com/jobbersargentina/" style="text-decoration: none; margin-right: 10px;">
		                        <img src="https://jobbersargentina.net/img/email/brand2.png" alt="IG" style="width: 20px; height: 20px;">
		                    </a>
		                    <a href="https://jobbersargentina.net/" style="text-decoration: none; margin-right: 10px;">
		                        <img src="https://jobbersargentina.net/img/email/sphere.png" alt="WEB" style="width: 20px; height: 20px;">
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

	public function soporteTecnico($email, $name, $asunto1, $asunto2, $mensaje){

		$mail = new PHPMailer;
		$mail->isSMTP();
		$mail->Host = $this->host;
		$mail->SMTPAuth = $this->smtpAuth;
		$mail->Username = $this->userName;
		$mail->Password = $this->password;
		$mail->SMTPSecure = $this->smtpSecure;
		$mail->Port = $this->port;

		$mail->setFrom($this->from, $this->fromName);
		$mail->addAddress('jobbersargentina@gmail.com', 'Jobbers Argentina');
		$mail->addCC('ortizkendry95@gmail.com', 'Ing. Kendry Ortiz');
		$mail->addCC('ingvictorfernandezs@gmail.com', 'Ing. Victor Fernandez');
		$mail->addCC('miguelmendozafiguera@gmail.com', 'Miguel Mendoza');
		$mail->addReplyTo($email, $name);

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
		                    <img width="30%" style="display:inline; margin: 20px 3% 0px 3%" src="https://jobbersargentina.net/img/logo.png">
		                </a>
		                <div style="display: inline-block;margin:32px 0; float: right">
		                    <a href="https://www.facebook.com/jobbersargentina" style="text-decoration: none; margin-right: 10px;">
		                        <img src="https://jobbersargentina.net/img/email/fb.png" alt="FB">
		                    </a>
		                    <a href="https://www.instagram.com/jobbersargentina/" style="text-decoration: none; margin-right: 10px;">
		                        <img src="https://jobbersargentina.net/img/email/brand2.png" alt="IG">
		                    </a>
		                    <a href="https://jobbersargentina.net/" style="text-decoration: none; margin-right: 10px;">
		                        <img src="https://jobbersargentina.net/img/email/sphere.png" alt="WEB">
		                    </a>
		                </div>
		            </td>
		        </tr>

		        <tr>
		            <td style="padding: 0; background-color: rgba(0, 174, 239, 0.3); text-align: center; font-family: sans-serif">
		                <h2 style="color: #3F429A">Soporte Técnico</h2>
		                <!-- <img style="padding: 0; display: block" src="https://s19.postimg.org/y5abc5ryr/alola_region.jpg" width="100%"> -->
		            </td>
		        </tr>

		        <tr>
		            <td style="background-color: #fff; padding-bottom: 20px;">
		                <div style="color: #34495e; margin: 4% 10% 2%; text-align: justify;font-family: sans-serif">
		                    <h2 style="color:#3F429A; margin: 0 0 7px">'.$asunto2.'</h2>
		                    <p style="margin: 2px; font-size: 15px"> <b>'.$name .'</b> dice: ' . $mensaje.'</p>
		                        
		                </div>
		            </td>
		        </tr>
		        <tr style="border-top: 1px solid #bdc0c1">
		            <td style="background-color: rgba(0, 174, 239, 0.3); padding-bottom: 20px;">
		                <p style="color:#3F429A; font-size: 14px; text-align: center;margin: 20px 0 0; font-family: sans-serif">Visitanos en</p>
		                <div style="display:block;margin:20px 0; text-align: center;">
		                    <a href="https://www.facebook.com/jobbersargentina" style="text-decoration: none; margin-right: 10px;">
		                        <img src="https://jobbersargentina.net/img/email/fb.png" alt="FB" style="width: 20px; height: 20px;">
		                    </a>
		                    <a href="https://www.instagram.com/jobbersargentina/" style="text-decoration: none; margin-right: 10px;">
		                        <img src="https://jobbersargentina.net/img/email/brand2.png" alt="IG" style="width: 20px; height: 20px;">
		                    </a>
		                    <a href="https://jobbersargentina.net/" style="text-decoration: none; margin-right: 10px;">
		                        <img src="https://jobbersargentina.net/img/email/sphere.png" alt="WEB" style="width: 20px; height: 20px;">
		                    </a>
		                </div>
		                <p style="color:#3F429A; font-size: 12px; text-align: center;margin: 30px 0 0; font-weight: bolder; font-family: sans-serif">© 2017 - 2018 | Jobbers - Todos los derechos reservados</p>
		            </td>
		        </tr>
		    </table>
		</body>

		</html>';

		$mail->Subject = "Soporte Técnico - $asunto1";
		$mail->Body    = $contenido;

		if(!$mail->send()) {
		  return false;
		} else {
		  return true;
		}

	}

	public function recordatorio_cv($destEmail,$destName){

		$mail = new PHPMailer;
		$mail->isSMTP();
		$mail->Host = $this->host;
		$mail->Helo =$this->host; //Muy importante para que llegue a hotmail y otros
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
		                    <img width="30%" style="display:inline; margin: 20px 3% 0px 3%" src="https://jobbersargentina.net/img/logo.png">
		                </a>
		                <div style="display: inline-block;margin:32px 0; float: right">
		                    <a href="https://www.facebook.com/jobbersargentina" style="text-decoration: none; margin-right: 10px;">
		                        <img src="https://jobbersargentina.net/img/email/fb.png" alt="FB">
		                    </a>
		                    <a href="https://www.instagram.com/jobbersargentina/" style="text-decoration: none; margin-right: 10px;">
		                        <img src="https://jobbersargentina.net/img/email/brand2.png" alt="IG">
		                    </a>
		                    <a href="https://jobbersargentina.net/" style="text-decoration: none; margin-right: 10px;">
		                        <img src="https://jobbersargentina.net/img/email/sphere.png" alt="WEB">
		                    </a>
		                </div>
		            </td>
		        </tr>

		        <tr>
		            <td style="padding: 0; background-color: rgba(0, 174, 239, 0.3); text-align: center; font-family: sans-serif">
		                <h2 style="color: #3F429A">Completa tu CV!</h2>
		                <!-- <img style="padding: 0; display: block" src="https://s19.postimg.org/y5abc5ryr/alola_region.jpg" width="100%"> -->
		            </td>
		        </tr>

		        <tr>
		            <td style="background-color: #fff; padding-bottom: 20px;">
		                <div style="color: #34495e; margin: 4% 10% 2%; text-align: justify;font-family: sans-serif">
		                    <h2 style="color:#3F429A; margin: 0 0 7px">Hola '.$destName.'!</h2>
		                        <ul style="font-size: 15px;  margin: 10px 0">
		                            <li>Desde Jobbers estamos para ayudarte a mejorar tus posibilidades de encontrar tu trabajo ideal. Un tema <b>importante</b> en ese circuito sumergido en tecnología, es que las empresas puedan <b>encontrarte</b>! Es por ello que te invitamos a <b>COMPLETAR 100% TU CV</b> en nuestro NUEVO Y MEJORADO portal de empleos!</li>
		                        </ul>
		                        <div style="width: 100%; text-align: center; margin-top: 40px;">
		                            <a style="text-decoration: none; border-radius: 5px; padding: 11px 23px; color: white; background-color: #3498db" href="https://jobbersargentina.net/ingresar.php">Iniciar Sesión</a>
		                        </div>
		                        <br>
		                       <p style="margin: 2px; font-size: 15px"> Jobbers Argentina "Trabajamos para facilitarte tu busqueda de EMPLEO". </p>
		                </div>
		            </td>
		        </tr>
		        <tr style="border-top: 1px solid #bdc0c1">
		            <td style="background-color: rgba(0, 174, 239, 0.3); padding-bottom: 20px;">
		                <p style="color:#3F429A; font-size: 14px; text-align: center;margin: 20px 0 0; font-family: sans-serif">Visitanos en</p>
		                <div style="display:block;margin:20px 0; text-align: center;">
		                    <a href="https://www.facebook.com/jobbersargentina" style="text-decoration: none; margin-right: 10px;">
		                        <img src="https://jobbersargentina.net/img/email/fb.png" alt="FB" style="width: 20px; height: 20px;">
		                    </a>
		                    <a href="https://www.instagram.com/jobbersargentina/" style="text-decoration: none; margin-right: 10px;">
		                        <img src="https://jobbersargentina.net/img/email/brand2.png" alt="IG" style="width: 20px; height: 20px;">
		                    </a>
		                    <a href="https://jobbersargentina.net/" style="text-decoration: none; margin-right: 10px;">
		                        <img src="https://jobbersargentina.net/img/email/sphere.png" alt="WEB" style="width: 20px; height: 20px;">
		                    </a>
		                </div>
		                <p style="color:#3F429A; font-size: 12px; text-align: center;margin: 30px 0 0; font-weight: bolder; font-family: sans-serif">© 2017 - 2018 | Jobbers - Todos los derechos reservados</p>
		            </td>
		        </tr>
		    </table>
		</body>

		</html>';

		$mail->Subject = "Jobbers Argentina - Tu CV está incompleto.";
		$mail->Body    = $contenido;

		if(!$mail->send()) {
		  return false;
		} else {
		  return true;
		}

	}


}


?>