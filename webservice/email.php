<?php



require_once "lib/nusoap.php";

require_once "phpmailer/class.phpmailer.php";

require_once "phpmailer/class.smtp.php";



function initPhpmailer(){

	$mail = new PHPMailer();

	$mail->IsSMTP();

	$mail->SMTPAuth   = true;

	$mail->SMTPSecure = "ssl";

	$mail->Host       = "www.ingvictorfernandez.com.ve";

	$mail->Port       = 465;

	$mail->Username = 'admin@ingvictorfernandez.com.ve';

	$mail->Password = '22058481112233vf'; //Su password

	$mail->setFrom("notificaciones@jobbersargentina.com", "Jobbers Argentina");

	$mail->isHTML(true);

	return $mail;
}





function enviarMail($accion, $params){



	switch ($accion) {

		case 1:

			$mail = initPhpmailer();

			$emisorMsg = $params["emisorMsg"];
			$destEmail = $params["destEmail"];
			$destName = $params["destName"];
			$msg = $params["msg"];

			$mail->addAddress($destEmail, $destName);

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
					  return "0";
					} else {
					  return "1";
					}

			break;

		case 2:

			$mail = initPhpmailer();

			$destEmail = $params['destEmail'];

			$destName = $params['destName'];

			$code = $params['code'];



			$mail->addAddress($destEmail, $destName);

			

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

			  return "0";

			} else {

			  return "1";

			}




			break;

		case 3:

			$email = $params["email"];
			$name = $params["name"];
			$asunto2 = $params["asunto2"];
			$mensaje = $params["mensaje"];
			$asunto1 = $params["asunto1"];

			$mail = initPhpmailer();

			$mail->setFrom($email, $name);
			$mail->addAddress('jobbersargentina@gmail.com', 'Jobbers Argentina');
			$mail->addCC('ortizkendry95@gmail.com', 'Ing. Kendry Ortiz');
			$mail->addCC('ingvictorfernandezs@gmail.com', 'Ing. Victor Fernandez');
			$mail->addCC('miguelmendozafiguera@gmail.com', 'Miguel Mendoza');
			$mail->addReplyTo($email, $name);

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
			                <h2 style="color: #3F429A">Soporte Técnico</h2>
			                <!-- <img style="padding: 0; display: block" src="https://s19.postimg.org/y5abc5ryr/alola_region.jpg" width="100%"> -->
			            </td>
			        </tr>

			        <tr>
			            <td style="background-color: #fff; padding-bottom: 20px;">
			                <div style="color: #34495e; margin: 4% 10% 2%; text-align: justify;font-family: sans-serif">
			                    <h2 style="color:#3F429A; margin: 0 0 7px">'.$asunto2.'</h2>
			                    <p style="margin: 2px; font-size: 15px"> '.$mensaje.'</p>
			                        
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

			$mail->Subject = "Soporte Técnico - $asunto1";
			$mail->Body    = $contenido;

			if(!$mail->send()) {
			  return "0";
			} else {
			  return "1";
			}


			break;

	}

}



$server = new soap_server();

$server->configureWSDL("emails", "urn:emails");

/*$server->wsdl->addComplexType(  'parametros', 
                                'complexType', 
                                'struct', 
                                'all', 
                                '',
                                array('destEmail'              => array('name' => 'destEmail','type' => 'xsd:string'),
                                      'destName'              => array('name' => 'destName','type' => 'xsd:string'),
                                      'code'     => array('name' => 'code','type' => 'xsd:string'))
);*/

$server->register("enviarMail",

        array("accion" => "xsd:integer", "params" => "xsd:Array"),

        array("return" => "xsd:string"),

        "urn:emails",

        "urn:emails#enviarMail",

        "rpc",

        "encoded",

        "Envio de emails");

$server->service($HTTP_RAW_POST_DATA);





?>