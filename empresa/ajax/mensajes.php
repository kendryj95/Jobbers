<?php
	session_start();

	define('AGREGAR', 1);
	define('OBTENER', 2);

	require_once('../../classes/DatabasePDOInstance.function.php');

	$db = DatabasePDOInstance();

	$op = isset($_REQUEST["op"]) ? $_REQUEST["op"] : false;

	$infoEmpresa = $_SESSION["ctc"]["empresa"];

	if($op) {
		switch($op) {
			case AGREGAR:
				$info = isset($_REQUEST["info"]) ? json_decode($_REQUEST["info"], true) : false;
				if($info) {
					$id = $db->getOne("
						SELECT
							id
						FROM
							mensajes
						WHERE
							(
								id_usuario1 = '$info[id_usuario1]'
								AND id_usuario2 = '$infoEmpresa[id]'
							)
						OR (
							id_usuario1 = '$info[id_usuario1]'
							AND id_usuario2 = '$infoEmpresa[id]'
						)
					");
					
					if($id === false) {
						$id = $db->getOne("
							SELECT
								AUTO_INCREMENT
							FROM
								INFORMATION_SCHEMA. TABLES
							WHERE
								TABLE_SCHEMA = 'db678638694'
							AND TABLE_NAME = 'mensajes'
						");
						$db->query("
							INSERT INTO mensajes (
								id,
								id_usuario1,
								id_usuario2
							)
							VALUES
							(
								'$id',
								'$info[id_usuario1]',
								'$infoEmpresa[id]'
							)
						");
					}
					
					$fechaHora = date('Y-m-d H:i:s');
					
					$db->query("
						INSERT INTO mensajes_respuestas (
							id_mensaje,
							id_usuario,
							tipo_usuario,
							mensaje,
							fecha_hora
						)
						VALUES
						(
							'$id',
							'$infoEmpresa[id]',
							'2',
							'$info[mensaje]',
							'" . $fechaHora . "'
						)
					");
					
					echo json_encode(
						array(
							"msg" => "OK",
							"data" => array(
								"fecha_hora" => $fechaHora,
								"fechaHoraFormateada" => date('d/m/Y h:i:s A', strtotime($fechaHora)),
								"horaFormateada" => date('h:i:s A', strtotime($fechaHora))
							)
						)
					);
				}
				break;
			case OBTENER:
				$m = isset($_REQUEST["m"]) ? $_REQUEST["m"] : false;
				$u1 = isset($_REQUEST["u1"]) ? $_REQUEST["u1"] : false;
				$u2 = isset($_REQUEST["u2"]) ? $_REQUEST["u2"] : false;
				if($m && $u1 && $u2) {
					$t = $db->getRow("
						SELECT
							trabajadores.id AS i,
							trabajadores.nombres,
							trabajadores.apellidos,
							IF (
								imagenes.id IS NULL,
								'img/avatars/user.png',
								CONCAT(
									imagenes.directorio,
									'/',
									imagenes.id,
									'.',
									imagenes.extension
								)
							) AS ruta_imagen
						FROM
							trabajadores
						LEFT JOIN imagenes ON trabajadores.id_imagen = imagenes.id
						WHERE
							trabajadores.id = $u1
					");
					$mensajes = $db->getAll("
						SELECT
							mensajes_respuestas.*
						FROM
							mensajes
						INNER JOIN mensajes_respuestas ON mensajes.id = mensajes_respuestas.id_mensaje
						WHERE
							mensajes.id = $m AND (mensajes.id_usuario1 = $u1 AND mensajes.id_usuario2 = $u2)
					");
					if($mensajes === false) {
						$mensajes = array();
					}
					foreach($mensajes as $i => $mensaje) {
						$mensajes[$i]["fechaHoraFormateada"] = date('d/m/Y h:i:s A', strtotime($mensaje["fecha_hora"]));
						$mensajes[$i]["horaFormateada"] = date('h:i:s A', strtotime($mensaje["fecha_hora"]));
					}
					echo json_encode(array(
						"messages" => $mensajes,
						"t" => $t
					));
				}
				else {
					echo json_encode(array());
				}
				break;
		}
	}
?>