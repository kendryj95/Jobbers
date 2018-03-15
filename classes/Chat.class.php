<?php
	//require_once("$_SERVER[DOCUMENT_ROOT]/ctc/ctc/classes/DatabasePDOInstance.function.php");
	//require_once("$_SERVER[DOCUMENT_ROOT]/ctc/classes/DatabasePDOInstance.function.php");
	//require_once("$_SERVER[DOCUMENT_ROOT]/classes/DatabasePDOInstance.function.php");
	require_once ("DatabasePDOInstance.function.php");

	class Chat {
		function getMessages($idc, $idc2, $t, $maskAsReaded) {
			$db = DatabasePDOInstance();
			$destinators = array();
			$messages = array();
			if($idc2) {
				$dataMessages = $db->getAll("
					SELECT
						c.id,
						c.uid_usuario1,
						c.uid_usuario2
					FROM
						empresas_chat AS c
					WHERE
						(c.uid_usuario1 = $idc
					OR c.uid_usuario2 = $idc) AND (c.uid_usuario1 = $idc2
					OR c.uid_usuario2 = $idc2)
					ORDER BY fecha_envio DESC
				");						
			}
			else {
				$dataMessages = $db->getAll("
					SELECT
						c.id,
						c.uid_usuario1,
						c.uid_usuario2
					FROM
						empresas_chat AS c
					WHERE
						(c.uid_usuario1 = $idc
					OR c.uid_usuario2 = $idc)
					ORDER BY fecha_envio DESC
				");
			}

			foreach($dataMessages as $row) {
				if($row["uid_usuario1"] == $idc) {
					//echo "Mensaje enviado a $row[uid_usuario2]<br>";
					if(!in_array($row["uid_usuario2"], $destinators)) {
						$destinators[] = $row["uid_usuario2"];
						
						$sql = "";

						if($t == 1) {
							$sql = "
								SELECT
									com.uid,
									CONCAT(com.`nombres`, ' ', com.`apellidos`) AS nombre,
									CONCAT(
										img.directorio,
										'/',
										img.id,
										'.',
										img.extension
									) AS image_path
								FROM
									trabajadores AS com
								LEFT JOIN imagenes AS img ON com.id_imagen = img.id
								WHERE
									com.uid = $row[uid_usuario2]
							";

							$sql2 = "SELECT p.titulo AS titulo_publicacion, p.amigable AS url_publicacion, asec.amigable AS sector, a.amigable AS area FROM publicaciones p INNER JOIN publicaciones_sectores ps ON p.id=ps.id_publicacion INNER JOIN areas_sectores asec ON ps.id_sector=asec.id INNER JOIN areas a ON asec.id_area=a.id INNER JOIN postulaciones pt ON p.id=pt.id_publicacion INNER JOIN trabajadores t ON pt.id_trabajador=t.id INNER JOIN empresas e ON p.id_empresa=e.id WHERE (t.uid=$row[uid_usuario1] AND e.uid=$row[uid_usuario2]) OR (t.uid=$row[uid_usuario2] AND e.uid=$row[uid_usuario1])";									
						}
						else {
							$sql = "
								SELECT
									com.uid,
									com.`nombre`,
									CONCAT(
										img.directorio,
										'/',
										img.id,
										'.',
										img.extension
									) AS image_path
								FROM
									empresas AS com
								LEFT JOIN imagenes AS img ON com.id_imagen = img.id
								WHERE
									com.uid = $row[uid_usuario2]
							";
							$sql2 = "SELECT p.titulo AS titulo_publicacion, p.amigable AS url_publicacion, asec.amigable AS sector, a.amigable AS area FROM publicaciones p INNER JOIN publicaciones_sectores ps ON p.id=ps.id_publicacion INNER JOIN areas_sectores asec ON ps.id_sector=asec.id INNER JOIN areas a ON asec.id_area=a.id INNER JOIN postulaciones pt ON p.id=pt.id_publicacion INNER JOIN trabajadores t ON pt.id_trabajador=t.id INNER JOIN empresas e ON p.id_empresa=e.id WHERE (t.uid=$row[uid_usuario1] AND e.uid=$row[uid_usuario2]) OR (t.uid=$row[uid_usuario2] AND e.uid=$row[uid_usuario1])";
						}
						
						$info = $db->getRow($sql);
						$publicacion = $db->getRow($sql2);

						$messages[] = array(
							"info" => $info,
							"titulo_publicacion" => $publicacion
						);
					}
				}
				else {
					//echo "Mensaje recibido de $row[uid_usuario1]<br>";
					if(!in_array($row["uid_usuario1"], $destinators)) {
						$destinators[] = $row["uid_usuario1"];
						
						$sql = "";

						if($t == 1) {
							$sql = "
								SELECT
									com.uid,
									com.`nombres`,
									com.`apellidos`,
									CONCAT(
										img.directorio,
										'/',
										img.id,
										'.',
										img.extension
									) AS image_path
								FROM
									trabajadores AS com
								LEFT JOIN imagenes AS img ON com.id_imagen = img.id
								WHERE
									com.uid = $row[uid_usuario1]
							";
							$sql2 = "SELECT p.titulo AS titulo_publicacion, p.amigable AS url_publicacion, asec.amigable AS sector, a.amigable AS area FROM publicaciones p INNER JOIN publicaciones_sectores ps ON p.id=ps.id_publicacion INNER JOIN areas_sectores asec ON ps.id_sector=asec.id INNER JOIN areas a ON asec.id_area=a.id INNER JOIN postulaciones pt ON p.id=pt.id_publicacion INNER JOIN trabajadores t ON pt.id_trabajador=t.id INNER JOIN empresas e ON p.id_empresa=e.id WHERE (t.uid=$row[uid_usuario2] AND e.uid=$row[uid_usuario1]) OR (t.uid=$row[uid_usuario1] AND e.uid=$row[uid_usuario2])";
						}
						else {
							$sql = "
								SELECT
									com.uid,
									com.`nombre`,
									CONCAT(
										img.directorio,
										'/',
										img.id,
										'.',
										img.extension
									) AS image_path
								FROM
									empresas AS com
								LEFT JOIN imagenes AS img ON com.id_imagen = img.id
								WHERE
									com.uid = $row[uid_usuario1]
							";
							$sql2 = "SELECT p.titulo AS titulo_publicacion, p.amigable AS url_publicacion, asec.amigable AS sector, a.amigable AS area FROM publicaciones p INNER JOIN publicaciones_sectores ps ON p.id=ps.id_publicacion INNER JOIN areas_sectores asec ON ps.id_sector=asec.id INNER JOIN areas a ON asec.id_area=a.id INNER JOIN postulaciones pt ON p.id=pt.id_publicacion INNER JOIN trabajadores t ON pt.id_trabajador=t.id INNER JOIN empresas e ON p.id_empresa=e.id WHERE (t.uid=$row[uid_usuario2] AND e.uid=$row[uid_usuario1]) OR (t.uid=$row[uid_usuario1] AND e.uid=$row[uid_usuario2])";
						}
						
						$info = $db->getRow($sql);
						$publicacion = $db->getRow($sql2);

						$messages[] = array(
							"info" => $info,
							"titulo_publicacion" => $publicacion
						);
					}
				}
			}
			$destinators = $destinators;

			foreach($destinators as $k => $dest) {
				$unreadedCount = 0;

				$msgs = $db->getAll("
					SELECT
						c.*
					FROM
						empresas_chat AS c
					WHERE
						(
							c.uid_usuario1 = $idc
							AND c.uid_usuario2 = $dest
						)
					OR (
						c.uid_usuario1 = $dest
						AND c.uid_usuario2 = $idc
					)
				");
				foreach($msgs as $ind => $msg) {
					if($msg["uid_usuario1"] == $idc) {
						$msgs[$ind]["readed"] = $msg["fecha_lectura_usuario2"] != null ? 1 : 0;
					} else {
						$msgs[$ind]["unreaded"] = $msg["fecha_lectura_usuario2"] != null ? 0 : 1;
						if($msgs[$ind]["unreaded"]) {
							$unreadedCount++;
						}
					}
				}
				$messages[$k]["messages"] = $msgs;
				$messages[$k]["messages_unreaded_count"] = $unreadedCount;

				if($idc2 && $maskAsReaded) {
					$db->query("
						UPDATE empresas_chat
						SET fecha_lectura_usuario2 = '" . date("Y-m-d H:i:s") . "'
						WHERE
							uid_usuario2 = $idc
						AND uid_usuario1 = $idc2
						AND fecha_lectura_usuario2 IS NULL
					");
				}
			}

			if (isset($idc) && isset($idc2)) {
				$publicacion = $db->getRow("SELECT p.titulo AS titulo_publicacion, p.amigable AS url_publicacion, asec.amigable AS sector, a.amigable AS area FROM publicaciones p INNER JOIN publicaciones_sectores ps ON p.id=ps.id_publicacion INNER JOIN areas_sectores asec ON ps.id_sector=asec.id INNER JOIN areas a ON asec.id_area=a.id INNER JOIN postulaciones pt ON p.id=pt.id_publicacion INNER JOIN trabajadores t ON pt.id_trabajador=t.id INNER JOIN empresas e ON p.id_empresa=e.id WHERE (t.uid=$idc AND e.uid=$idc2) OR (t.uid=$idc2 AND e.uid=$idc)");

				$messages[0]["publicacion"] = $publicacion;
			}

			

			return $messages;
		}
		
		function getMessagesReceived($idc, $t) {
			$db = DatabasePDOInstance();
			$results = array();
			$destinators = array();
			$messages = array();
			$dataMessages = $db->getAll("
				SELECT
					c.id,
					c.uid_usuario1,
					c.uid_usuario2
				FROM
					empresas_chat AS c
				WHERE
					(c.uid_usuario1 = $idc
				OR c.uid_usuario2 = $idc)
				ORDER BY fecha_envio DESC
			");

			foreach($dataMessages as $row) {
				if($row["uid_usuario1"] == $idc) {
					//echo "Mensaje enviado a $row[uid_usuario2]<br>";
					if(!in_array($row["uid_usuario2"], $destinators)) {
						$destinators[] = $row["uid_usuario2"];
						
						$sql = "";

						if($t == 1) {
							$sql = "
								SELECT
									com.uid,
									CONCAT(com.`nombres`, ' ', com.`apellidos`) AS nombre,
									CONCAT(
										img.directorio,
										'/',
										img.id,
										'.',
										img.extension
									) AS image_path
								FROM
									trabajadores AS com
								LEFT JOIN imagenes AS img ON com.id_imagen = img.id
								WHERE
									com.uid = $row[uid_usuario2]
							";									
						}
						else {
							$sql = "
								SELECT
									com.uid,
									com.`nombre`,
									CONCAT(
										img.directorio,
										'/',
										img.id,
										'.',
										img.extension
									) AS image_path
								FROM
									empresas AS com
								LEFT JOIN imagenes AS img ON com.id_imagen = img.id
								WHERE
									com.uid = $row[uid_usuario2]
							";
						}
						
						$info = $db->getRow($sql);

						$messages[] = array(
							"info" => $info
						);
					}
				}
				else {
					//echo "Mensaje recibido de $row[uid_usuario1]<br>";
					if(!in_array($row["uid_usuario1"], $destinators)) {
						$destinators[] = $row["uid_usuario1"];
						
						$sql = "";

						if($t == 1) {
							$sql = "
								SELECT
									com.uid,
									com.`nombres` AS nombre,
									com.`apellidos`,
									CONCAT(
										img.directorio,
										'/',
										img.id,
										'.',
										img.extension
									) AS image_path
								FROM
									trabajadores AS com
								LEFT JOIN imagenes AS img ON com.id_imagen = img.id
								WHERE
									com.uid = $row[uid_usuario1]
							";
						}
						else {
							$sql = "
								SELECT
									com.uid,
									com.`nombre`,
									CONCAT(
										img.directorio,
										'/',
										img.id,
										'.',
										img.extension
									) AS image_path
								FROM
									empresas AS com
								LEFT JOIN imagenes AS img ON com.id_imagen = img.id
								WHERE
									com.uid = $row[uid_usuario1]
							";
						}
						
						$info = $db->getRow($sql);

						$messages[] = array(
							"info" => $info
						);
					}
				}
			}
			$destinators = $destinators;

			foreach($destinators as $k => $dest) {
				$unreadedCount = 0;

				$msgs = $db->getAll("
					SELECT
						c.*
					FROM
						empresas_chat AS c
					WHERE
						(
							c.uid_usuario1 = $idc
							AND c.uid_usuario2 = $dest
						)
					OR (
						c.uid_usuario1 = $dest
						AND c.uid_usuario2 = $idc
					)
				");
				foreach($msgs as $ind => $msg) {
					if($msg["uid_usuario1"] == $idc) {
						$msgs[$ind]["readed"] = $msg["fecha_lectura_usuario2"] != null ? 1 : 0;
					} else {
						$msgs[$ind]["unreaded"] = $msg["fecha_lectura_usuario2"] != null ? 0 : 1;
						if($msgs[$ind]["unreaded"]) {
							$unreadedCount++;
						}
					}
				}
				$messages[$k]["messages"] = $msgs;
				$messages[$k]["messages_unreaded_count"] = $unreadedCount;
			}
			
			foreach($messages as $row) {
				foreach($row["messages"] as $m) {
					if($m["uid_usuario2"] == $idc) {
						$results[] = array(
							"id" => $m["id"],
							"mensaje" => $m["mensaje"],
							"usuario_nombre" => $row["info"]["nombre"]
						);
					}					
				}
			}

			return $results;
		}
		
		function addMessage($idc1, $idc2, $msg) {
			$db = DatabasePDOInstance();
			$db->query("
				INSERT INTO empresas_chat (
					uid_usuario1,
					uid_usuario2,
					mensaje,
					fecha_envio,
					fecha_lectura_usuario1,
					fecha_lectura_usuario2
				)
				VALUES
				(
					'$idc1',
					'$idc2',
					'$msg',
					'" . date('Y-m-d H:i:s') . "',
					'" . date('Y-m-d H:i:s') . "',
					NULL
				)
			");
			return true;
		}
	}
?>