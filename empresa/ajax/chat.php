<?php
	require_once("$_SERVER[DOCUMENT_ROOT]/classes/DatabasePDOInstance.function.php");
	require_once("$_SERVER[DOCUMENT_ROOT]/classes/Chat.class.php");
	require_once("$_SERVER[DOCUMENT_ROOT]/classes/Email.class.php");

	define('GET_MESSAGES', 1);
	define('ADD_MESSAGE', 2);
	define('GET_UNREAD_COUNT', 3);
	define('GET_MESSAGES_RECEIVED', 4);
	define('SEND_MESSAGE', 5);

	$db = DatabasePDOInstance();
	$chat = new Chat();
	$email = new Email();

	$op = isset($_REQUEST["op"]) ? $_REQUEST["op"] : false;
	
	if($op) {
		switch($op) {
            case GET_MESSAGES:
				$idc = isset($_REQUEST["idc"]) ? $_REQUEST["idc"] : false;
				$idc2 = isset($_REQUEST["idc2"]) ? $_REQUEST["idc2"] : false;
				$t = isset($_REQUEST["t"]) ? $_REQUEST["t"] : false;
                $maskAsReaded = isset($_REQUEST["mr"]) ? $_REQUEST["mr"] : false;
				$messages = $chat->getMessages($idc, $idc2, $t, $maskAsReaded);
				echo json_encode($messages);
                break;
            case ADD_MESSAGE:
                $idc1 = isset($_REQUEST["idc1"]) ? $_REQUEST["idc1"] : false;
				$idc2 = isset($_REQUEST["idc2"]) ? $_REQUEST["idc2"] : false;
				$t = isset($_REQUEST["t"]) ? $_REQUEST["t"] : false;
				$msg  = isset($_REQUEST["msg"])  ? $_REQUEST["msg"]  : false;
                if($idc1 && $idc2 && $msg) {
					$bln = $chat->addMessage($idc1, $idc2, $msg);

					if ($bln) {
						/*if ($t) {
							$data = $db->getRow("
                                SELECT correo_electronico, CONCAT(nombres, ' ', apellidos) AS nombre FROM trabajadores WHERE uid = $idc2
                            ");

						} else {
							$data = $db->getRow("
                                SELECT correo_electronico, nombre FROM empresas WHERE uid = $idc2
                            ");

						}*/

						$empresa = $db->getRow("
                                SELECT correo_electronico, nombre FROM empresas WHERE uid = $idc1
                            ");

						$trab = $db->getRow("
                                SELECT correo_electronico, CONCAT(nombres, ' ', apellidos) AS nombre FROM trabajadores WHERE uid = $idc2
                            ");

						if ($empresa && $trab) {
							/*@mail($trab['correo_electronico'], "Nuevo mensaje recibido - JOBBERS", "Nuevo mensaje recibido de $empresa[nombre]", "From: jobbers <administracion@jobbers.com>\r\n" .
							"Reply-To: administracion@jobbers.com\r\n" .
                            "Return-path: administracion@jobbers.com\r\n" .
                            "MIME-Version: 1.0\n" .
                            "Content-type: text/html; charset=utf-8");*/
                            $email->email_chat($empresa["nombre"], $trab['correo_electronico'], $trab['nombre'], $msg);
						} else {
							$empresa = $db->getRow("
                                SELECT correo_electronico, nombre FROM empresas WHERE uid = $idc2
                            ");

							$trab = $db->getRow("
                                SELECT correo_electronico, CONCAT(nombres, ' ', apellidos) AS nombre FROM trabajadores WHERE uid = $idc1
                            ");

                            /*@mail($empresa['correo_electronico'], "Nuevo mensaje recibido - JOBBERS", "Nuevo mensaje recibido de $trab[nombre]", "From: jobbers <administracion@jobbers.com>\r\n" .
							"Reply-To: administracion@jobbers.com\r\n" .
                            "Return-path: administracion@jobbers.com\r\n" .
                            "MIME-Version: 1.0\n" .
                            "Content-type: text/html; charset=utf-8");*/
                            $email->email_chat($trab["nombre"], $empresa['correo_electronico'], $empresa['nombre'], $msg);
						}

						
					}


                    echo json_encode($bln ? array(
                        "msg" => "OK"
                    ) : array(
                        "msg" => "ERROR"
                    ));
                }
                break;
            case GET_UNREAD_COUNT:
                $idc = isset($_REQUEST["idc"]) ? $_REQUEST["idc"] : false;
                $t = isset($_REQUEST["t"]) ? $_REQUEST["t"] : false;
                if($idc) {
					$messages = $chat->getMessages($idc, null, $t, 0);
					$result = array();
					foreach($messages as $row) {
						$result[] = array(
							"info" => array(
								"uid" => $row["info"]["uid"]
							),
							"messages_unreaded_count" => $row["messages_unreaded_count"]
						);
					}
					echo json_encode($result);
                }
                break;
			case GET_MESSAGES_RECEIVED:
				$idc = isset($_REQUEST["idc"]) ? $_REQUEST["idc"] : false;
				$t = isset($_REQUEST["t"]) ? $_REQUEST["t"] : false;
				$messages = $chat->getMessagesReceived($idc, $t);
				echo json_encode($messages);
				break;
			case SEND_MESSAGE:
				$idc = isset($_REQUEST["idc"]) ? $_REQUEST["idc"] : false;
				$idc2 = isset($_REQUEST["idc2"]) ? $_REQUEST["idc2"] : false;
				$t = isset($_REQUEST["t"]) ? $_REQUEST["t"] : false;
				$msg = isset($_REQUEST["msg"]) ? $_REQUEST["msg"] : false;		
				$sent = $chat->addMessage($idc, $idc2, $msg);
				if($sent) {
					/*if($t) {
						$data = $db->getRow("
							SELECT correo_electronico, CONCAT(nombres, ' ', apellidos) AS nombre FROM trabajadores WHERE uid = $idc2
						");
						
					}
					else {
						$data = $db->getRow("
							SELECT correo_electronico, nombre FROM empresas WHERE uid = $idc2
						");
						
					}*/
					$empresa = $db->getRow("
                                SELECT correo_electronico, nombre FROM empresas WHERE uid = $idc2
                            ");

					$trab = $db->getRow("
                                SELECT correo_electronico, CONCAT(nombres, ' ', apellidos) AS nombre FROM trabajadores WHERE uid = $idc
                            ");

					if(@mail($empresa['correo_electronico'], "Nuevo mensaje recibido - JOBBERS", "Nuevo mensaje recibido de $trab[nombre]", "From: jobbers <administracion@jobbers.com>\r\n" .
							 "Reply-To: administracion@jobbers.com\r\n" . 
							 "Return-path: administracion@jobbers.com\r\n" . 
							 "MIME-Version: 1.0\n" . 
							 "Content-type: text/html; charset=utf-8")) {
						$ms = true;
					}
					else {
						$ms = false;
					}
					echo json_encode(array(
						"msg" => "OK",
						"mailSent" => $ms
					));
				}
				else {
					echo json_encode(array(
						"msg" => "ERROR"
					));
				}
				break;
		}
	}
?>