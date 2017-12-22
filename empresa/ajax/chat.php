<?php
	require_once("../../classes/DatabasePDOInstance.function.php");
	// require_once("$_SERVER[DOCUMENT_ROOT]/classes/DatabasePDOInstance.function.php");
	require_once("../../classes/Chat.class.php");
	// require_once("$_SERVER[DOCUMENT_ROOT]/classes/Chat.class.php");

	define('GET_MESSAGES', 1);
	define('ADD_MESSAGE', 2);
	define('GET_UNREAD_COUNT', 3);
	define('GET_MESSAGES_RECEIVED', 4);
	define('SEND_MESSAGE', 5);

	$db = DatabasePDOInstance();
	$chat = new Chat();

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
				$msg  = isset($_REQUEST["msg"])  ? $_REQUEST["msg"]  : false;
                if($idc1 && $idc2 && $msg) {
					$bln = $chat->addMessage($idc1, $idc2, $msg);
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
					if($t) {
						$data = $db->getRow("
							SELECT correo_electronico, CONCAT(nombres, ' ', apellidos) AS nombre FROM trabajadores WHERE uid = $idc
						");
					}
					else {
						$data = $db->getRow("
							SELECT correo_electronico, nombre FROM empresas WHERE uid = $idc2
						");
					}
					if(@mail($data["correo_electronico"], "Nuevo mensaje recibido - JOBBERS", "Nuevo mensge recibido de $data[nombre]", "From: jobbers <administracion@jobbers.com>\r\n" . 
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