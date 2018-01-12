<?php
	session_start();
	require_once('../classes/DatabasePDOInstance.function.php');
	require_once("../classes/Email.class.php");
	$db = DatabasePDOInstance();
	$email = new Email();
	
	$op = isset($_REQUEST["op"]) ? $_REQUEST["op"] : false;
	define('LOGIN', 1);
	define('ADD', 2);
	define('LOGOUT', 3);
	define('EDIT_PASS', 4);
	define('RESET_PASS', 5);
	define('CHECK_CODE', 6);
	define('EDIT_PASS_FORGOT', 7);
	define('SAVE_COMPANY', 8);
	define('LOGIN_FB', 9);
	define('ADD_FB', 10);
	define('LOGIN_ADMIN', 11);
	define('SENT_MAIL', 12);
	switch($op) {
		case LOGIN:
			$info = $db->getRow("SELECT * FROM trabajadores WHERE (correo_electronico='".strtolower($_REQUEST['email'])."' OR usuario='".strtolower($_REQUEST['email'])."') AND clave='".md5($_REQUEST["password"])."'");
			if($info) {

				$confirmar = $db->getRow("SELECT confirmar FROM trabajadores WHERE correo_electronico='".strtolower($_REQUEST['email'])."' OR usuario='".strtolower($_REQUEST['email'])."'");
				$estudios = $db->getOne("SELECT COUNT(*) AS estudios FROM trabajadores_educacion WHERE id_trabajador=".$info["id"]);
				$idiomas = $db->getOne("SELECT COUNT(*) AS idiomas FROM trabajadores_idiomas WHERE id_trabajador=".$info["id"]);
				$info_extra = $db->getOne("SELECT remuneracion_pret FROM trabajadores_infextra WHERE id_trabajador=".$info["id"]);


				if ($confirmar['confirmar'] == 1) {
					$_SESSION["ctc"]["id"] = $info["id"];
					$_SESSION["ctc"]["uid"] = $info["uid"];
					$_SESSION["ctc"]["name"] = $info["nombres"];
					$_SESSION["ctc"]["lastName"] = $info["apellidos"];
					$_SESSION["ctc"]["email"] = $info["correo_electronico"];
					$_SESSION["ctc"]["type"] = 2;

					if ($info["id_imagen"] != 0 && $info["nombres"] != "" && $info["apellidos"] != "" && $info["correo_electronico"] != "" && $info["id_estado_civil"] != "" && $info["id_tipo_documento_identificacion"] != "" && $info["id_pais"] != "" && $info["provincia"] != "" && $info["localidad"] != "" && $info["calle"] != "" && $info["numero_documento_identificacion"] != "" && $info["fecha_nacimiento"] != "" && $info["telefono"] != "" && intval($estudios["estudios"]) != 0 && intval($idiomas["idiomas"]) != 0 && $info_extra["remuneracion_pret"] != "") {
						$_SESSION["ctc"]["postulate"] = 1;
					} else {
						$_SESSION["ctc"]["postulate"] = 0;
					}

					if ($info["id_imagen"] != 0) {
						$pic = $db->getOne("SELECT CONCAT(directorio,'/',titulo,'.',extension) FROM imagenes WHERE id=" . $info["id_imagen"]);
						$_SESSION["ctc"]["pic"] = $pic;
					}
                    else {
                        $_SESSION["ctc"]["pic"] = 'avatars/user.png';
                    }
					echo json_encode(array("status" => 1));
				} else {
					echo json_encode(array("status" => 3));
				}
			}
            else {
				echo json_encode(array("status" => 2));
            }
		break;
         case ADD:
			$id = $db->getOne("SELECT id FROM trabajadores WHERE correo_electronico='".strtolower($_REQUEST['email'])."' OR usuario='".strtolower($_REQUEST['email'])."'");
			if($id) {
				echo json_encode(array("status" => 2));
			}
			else {
				$id = $db->getOne("SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'db678638694' AND TABLE_NAME = 'trabajadores'");
				$uid = $db->getOne("SELECT valor FROM uid");
				$db->query("INSERT INTO trabajadores (id, uid, id_imagen, id_sexo, id_estado_civil, id_tipo_documento_identificacion, id_pais, provincia, localidad, calle, id_metodo_acceso, nombres, apellidos, numero_documento_identificacion, fecha_nacimiento, telefono, telefono_alternativo, clave, correo_electronico, fecha_creacion, fecha_actualizacion, publicidad, newsletter) VALUES ('$id', '$uid', '0', '', '', '', '', '', '', '', '', '$_REQUEST[name]', '$_REQUEST[lastName]', '', NULL, '', '', '".md5($_REQUEST["password"])."', '".strtolower($_REQUEST['email'])."', '".date("Y-m-d h:i:s")."', '".date("Y-m-d h:i:s")."', '$_REQUEST[publicidad]', '$_REQUEST[newsletter]')");

				//$idU = $db->getInsertID();

				$db->query("UPDATE uid SET valor = (valor + 1) WHERE id = 1");
				$_SESSION["ctc"]["id"] = $id;
				$_SESSION["ctc"]["uid"] = $uid;
				$_SESSION["ctc"]["name"] = $_REQUEST["name"];
				$_SESSION["ctc"]["lastName"] = $_REQUEST["lastName"];
				$_SESSION["ctc"]["email"] = $_REQUEST["email"];
				$_SESSION["ctc"]["type"] = 2;
				$_SESSION["ctc"]["pic"] = 'avatars/user.png';
				$_SESSION["ctc"]["postulate"] = 0;

				//$idU = $db->getOne("SELECT id FROM trabajadores ORDER BY id DESC LIMIT 1");

				/*$destinatario = $_REQUEST['email'];
				$asunto = "Confirmación de correo electronico - JOBBERS ARGENTINA";
				$headers = "MIME-Version: 1.0\r\n";
				$headers .= "Content-type: text/html; charset= iso-8859-1\r\n";
				$headers .= "From: Jobbers Argentina < administracion@jobbers.com >\r\n";

				$mensaje = "Hola $_REQUEST[name],<br><br>";

				$nombre_link = str_replace(array(" ","á","é","í","ó","ú","Á","É","Í","Ó","Ú"),array("%20","a","e","i","o","u","A","E","I","O","U"),$_REQUEST['name']);

				$apellido_link = str_replace(array(" ","á","é","í","ó","ú","Á","É","Í","Ó","Ú"),array("%20","a","e","i","o","u","A","E","I","O","U"),$_REQUEST['lastName']);

				$mensaje .= "Por favor confirma tu registro en la plataforma de Jobbers Argentina haciendo clic <a href='www.jobbersargentina.com/bienvenida.php?id=$idU&n=$nombre_link&a=$apellido_link'>aquí</a>. <br><br><br>";

				$enlace = "<a href='www.jobbersargentina.com/bienvenida.php?id=$idU&n=$nombre_link&a=$apellido_link'>www.jobbersargentina.com/bienvenida.php?id=$idU&n=$nombre_link&a=$apellido_link</a>";

				$mensaje .= "Si no funciona el enlace anterior puedes acceder a la siguiente URL: $enlace";

				$mensaje .= "<br>
				<br>
				<br> Gracias, <br><br> <b>Team JobbersArgentina.</b>";

				# CONDICIONAL PARA VALIDAR SI EL CORREO PERTENECE A "HOTMAIL" U "OUTLOOK"
				if (strstr($destinatario, "hotmail") || strstr($destinatario, "outlook")) {
					$mensaje= "Saludos $_REQUEST[name],<br><br>";

					$nombre_link = str_replace(array(" ","á","é","í","ó","ú","Á","É","Í","Ó","Ú"),array("%20","a","e","i","o","u","A","E","I","O","U"),$_REQUEST['name']);

					$mensaje .= "Por favor confirma el registro de su empresa en la plataforma de Jobbers Argentina copiando la siguiente URL: <b>www.jobbersargentina.com/bienvenida.php?id=$idU&n=$nombre_link&a=$apellido_link </b> y pegandola en su navegador. <br><br><br>";

					$mensaje .= "<br>
					<br>
					<br> Gracias, <br><br> <b>Team JobbersArgentina.</b>";
				}


				if (mail($destinatario,$asunto,$mensaje,$headers)) {
					echo json_encode(array(
						"status" => 1,
					));
				} else {
					echo json_encode(array(
						"status" => 0,
					));
				}*/ # COMENTADO PORQUE DANIEL MAIDANA LE PARECE MUY DIFICIL PARA LOS USUARIOS CONFIRMAR SU CORREO

				echo json_encode(array(
						"status" => 1,
					));
              }
         break;
         case LOGOUT:
               session_unset();
               session_destroy();
              echo json_encode(array("status" => 1));
              break;
         case EDIT_PASS:
		  	$id = $db->getOne("SELECT id FROM trabajadores WHERE clave='".md5($_REQUEST["current"])."' AND id=".$_SESSION["ctc"]["id"]);
			if($id) {
				$db->query("UPDATE trabajadores SET clave='".md5($_REQUEST["p"])."' WHERE id=".$_SESSION["ctc"]["id"]);
				echo json_encode(array("status" => 1));
			}
			else {
				echo json_encode(array("status" => 2));
			}
            break;
		case RESET_PASS:
			//require_once("../vendor/phpmailer/PHPMailerAutoload.php");
			$exist = $db->getRow("SELECT id, CONCAT(nombres,' ',apellidos) AS name FROM trabajadores WHERE correo_electronico='$_REQUEST[email]'");
			if($exist) {
				$controlador = strtotime(date('Hms'));
				$para = $_REQUEST["email"];

				$mail = $email->userForgotPass($para, $exist['name'], $controlador);
				
				if($mail) {
					$db->query("UPDATE trabajadores SET codigo_recuperacion='$controlador' WHERE correo_electronico='$_REQUEST[email]'");
					echo json_encode(array("status" => 1));
				}
				else {
					$db->query("UPDATE trabajadores SET codigo_recuperacion='$controlador' WHERE correo_electronico='$_REQUEST[email]'");
					echo json_encode(array("status" => 1));
				}
			}
			else {
				echo json_encode(array("status" => 2));
			}
			
			break;
		case CHECK_CODE:
			$exist = $db->getOne("SELECT id FROM trabajadores WHERE correo_electronico='$_REQUEST[email]' AND codigo_recuperacion='$_REQUEST[code]'");
			if($exist) {
				echo json_encode(array("status" => 1));
			}
			else {
				echo json_encode(array("status" => 2));
			}
			break;
		case EDIT_PASS_FORGOT:
			$db->query("UPDATE trabajadores SET clave='".md5($_REQUEST["p"])."' WHERE correo_electronico='$_REQUEST[email]'");
			$info = $db->getRow("SELECT * FROM trabajadores WHERE correo_electronico='$_REQUEST[email]' AND clave='".md5($_REQUEST["p"])."'");
		 	$_SESSION["ctc"]["id"] = $info["id"];
			$_SESSION["ctc"]["name"] = $info["nombres"];
			$_SESSION["ctc"]["lastName"] = $info["apellidos"];
			$_SESSION["ctc"]["email"] = $info["correo_electronico"];
			$_SESSION["ctc"]["type"] = 2;
			if($info["id_imagen"] != 0) {
				$pic = $db->getOne("SELECT CONCAT(directorio,'/',titulo,'.',extension) FROM imagenes WHERE id=".$info["id_imagen"]);
				$_SESSION["ctc"]["pic"] = $pic;
			}
			else {
				$_SESSION["ctc"]["pic"] = 'avatars/user.png';
			}
			echo json_encode(array("status" => 1));
			break;
		case SAVE_COMPANY:
			
			break;
		case LOGIN_FB:
			$info = $db->getRow("SELECT * FROM trabajadores WHERE correo_electronico='$_REQUEST[e]' and correo_electronico != 'undefined' limit 1");
			
			if($info){
				if($info["fb_id"] == ''){
					$db->query("UPDATE trabajadores SET fb_id = '$_REQUEST[i]'  WHERE id=$info[id] ");
				}
			}

			if(isset($_REQUEST['e']) && $_REQUEST['e'] != '' && $_REQUEST['e'] != 'undefined'){
				$info = $db->getRow("SELECT * FROM trabajadores WHERE correo_electronico='$_REQUEST[e]' and fb_id='$_REQUEST[i]' limit 1");
			}elseif(isset($_REQUEST['i']) && $_REQUEST['i'] != ''){
				$info = $db->getRow("SELECT * FROM trabajadores WHERE fb_id='$_REQUEST[i]' limit 1");
			}


			if($info) {

                $_SESSION["ctc"]["id"] = $info["id"];
				$_SESSION["ctc"]["name"] = $info["nombres"];
				$_SESSION["ctc"]["lastName"] = $info["apellidos"];
				$_SESSION["ctc"]["email"] = $info["correo_electronico"];
				$_SESSION["ctc"]["type"] = 2;


				if ($info["nombres"] != "" && $info["apellidos"] != "" && $info["correo_electronico"] != "" && $info["id_imagen"] != "" && $info["id_estado_civil"] != "" && $info["id_tipo_documento_identificacion"] != "" && $info["id_pais"] != "" && $info["provincia"] != "" && $info["localidad"] != "" && $info["calle"] != "" && $info["numero_documento_identificacion"] != "" && $info["fecha_nacimiento"] != "" && $info["telefono"] != "") {
					$_SESSION["ctc"]["postulate"] = 1;
				} else {
					$_SESSION["ctc"]["postulate"] = 0;
				}

				if($info["id_imagen"] != 0) {
					/*$isfb = $db->getOne("SELECT id FROM imagenes WHERE id=".$info["id_imagen"]." AND nombre='$_REQUEST[p]'");
					if($isfb) {
						$pic = $_REQUEST["p"];
					}
					else {
						$pic = $db->getOne("SELECT CONCAT(directorio,'/',titulo,'.',extension) FROM imagenes WHERE id=".$info["id_imagen"]);
					}*/
					$pic = $db->getOne("SELECT CONCAT(directorio,'/',titulo,'.',extension) FROM imagenes WHERE id=".$info["id_imagen"]);
					$_SESSION["ctc"]["pic"] = $pic;
				}
				else {
					$_SESSION["ctc"]["pic"] = 'avatars/user.png';
				}
				echo json_encode(array("status" => 1));
			}
            else {
				echo json_encode(array("status" => 2));
            }
			break;
		case ADD_FB:

			if($_REQUEST[i] != '' && isset($_REQUEST[i])){
				$info = $db->getRow("SELECT * FROM trabajadores WHERE correo_electronico='$_REQUEST[e]' and correo_electronico!='undefined' ");

				if($info) {
					if($info["fb_id"] == ''){
						$db->query("UPDATE trabajadores SET fb_id = '$_REQUEST[i]'  WHERE id=$info[id] ");
					}
				}
				$info = $db->getRow("SELECT * FROM trabajadores WHERE fb_id='$_REQUEST[i]'");

				if($info) {
					echo json_encode(array("status" => 2));
				}else {
					$id = $db->getOne("SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'db678638694' AND TABLE_NAME = 'trabajadores'");
					$uid = $db->getOne("SELECT valor FROM uid");
					//$idi = $db->getOne("SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'db678638694' AND TABLE_NAME = 'imagenes'");
					$nombres = $_REQUEST['n'];
					$apellidos = $_REQUEST['a'];
					$correo = $_REQUEST['e'] == 'undefined'?'':$_REQUEST['e'];
					$pictureURL = $_REQUEST['p'];
					$genero = $_REQUEST['g'];
					$fb_id = $_REQUEST['i'];
					$db->query("INSERT INTO trabajadores (id,uid,fb_id, id_imagen, id_sexo, id_estado_civil, 
					id_tipo_documento_identificacion, id_pais, provincia, localidad, 
					calle, id_metodo_acceso, nombres, apellidos, numero_documento_identificacion,
					fecha_nacimiento, telefono, telefono_alternativo, usuario, clave, correo_electronico,
					fecha_creacion, fecha_actualizacion) 
					VALUES ('$id','$uid','$fb_id' ,'0', '$genero', '', '', '', '', '', '', '', '$nombres', '$apellidos', '', NULL, '', '',  '', '', '$correo', '".date("Y-m-d h:i:s")."', '".date("Y-m-d h:i:s")."')");
					//$db->query("INSERT INTO imagenes (id, titulo, directorio, extension, fecha_creacion, fecha_actualizacion, nombre) VALUES ($idi, '', '', '', '".date("Y-m-d h:i:s")."', '".date("Y-m-d h:i:s")."', '$_REQUEST[p]')");
					$_SESSION["ctc"]["id"] = $id;
					$_SESSION["ctc"]["name"] = $nombres;
					$_SESSION["ctc"]["lastName"] = $apellidos;
					$_SESSION["ctc"]["email"] = $correo;
					$_SESSION["ctc"]["type"] = 2;
					$_SESSION["ctc"]["pic"] = $pictureURL;
					echo json_encode(array("status" => 1));
				}
			}
			break;
		case LOGIN_ADMIN:
			$info = $db->getRow("SELECT * FROM usuarios WHERE (correo_electronico='$_REQUEST[usuario]' OR usuario='$_REQUEST[usuario]') AND clave='".$_REQUEST["clave"]."'");
			if($info) {
                $_SESSION["ctc"]["id"] = $info["id"];
				$_SESSION["ctc"]["name"] = $info["nombre"];
				$_SESSION["ctc"]["lastName"] = $info["apellido"];
				$_SESSION["ctc"]["email"] = $info["correo_electronico"];
				$_SESSION["ctc"]["type"] = 3;
				$_SESSION["ctc"]["pic"] = 'avatars/user.png';
				$_SESSION["ctc"]["rol"] = $info["rol"];
				echo json_encode(array("msg" => "OK"));
			}
            else {
				echo json_encode(array("msg" => "ERROR"));
            }
			break;
		case SENT_MAIL:
			$email = $db->getOne("SELECT correo_contacto FROM plataforma WHERE id=1");
			$para = empty($_REQUEST["to"]) ? $email : $_REQUEST["to"];
			$asunto = "Contacto Jobbers Argentina - " . $_REQUEST["subject"];
			$cuerpo = $_REQUEST['message'];
				$headers_mensaje = 	"From: ".$_REQUEST['name']." <".$_REQUEST['email'].">\r\n" . 
					 "MIME-Version: 1.0\n" . 
					 "Content-type: text/html; charset=utf-8";
				if(@mail($para,$asunto,$cuerpo,$headers_mensaje)) {
					echo json_encode(array("msg" => "OK"));
				}
				else {
					echo json_encode(array("msg" => "ERROR"));
				}
			break;
	}
	
?>