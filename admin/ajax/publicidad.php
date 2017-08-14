<?php
	session_start();

	define('CARGAR', 1);
	define('AGREGAR', 2);
	define('DETALLE', 3);
	define('MODIFICAR', 4);
	define('ELIMINAR', 5);
	define('CARGAR_ANIMADO', 6);

	require_once('../../classes/DatabasePDOInstance.function.php');

	$db = DatabasePDOInstance();

	$op = isset($_REQUEST["op"]) ? $_REQUEST["op"] : false;

	if($op) {
		switch($op) {
			case CARGAR:
				$noticias["data"] = array();
				$datos = $db->getAll("
					SELECT
						*
					FROM
						publicidad
				");

				if($datos) {
					$datos = array_reverse($datos);					
					foreach($datos as $k => $pub) {
						$noticias["data"][] = array(
							$k + 1,
							$pub["titulo"],
							date('d/m/Y', strtotime($pub["fecha_creacion"])),
							date('d/m/Y', strtotime($pub["fecha_creacion"])),
							'<div class="acciones-publicacion" data-target="' . $pub["id"] . '"> <button type="button" class="accion-publicacion btn btn-primary waves-effect waves-light" onclick="modificarPublicacion(this);" title="Modificar publicidad"><span class="ti-pencil"></span></button> <button type="button" class="accion-publicacion btn btn-danger waves-effect waves-light" title="Eliminar publicidad" onclick="eliminarPublicacion(this);"><span class="ti-close"></span></button> </div>'
						);
					}
				}
				echo json_encode($noticias);
				break;
			case AGREGAR:
				if(isset($_REQUEST["option"])) {
					$db->query("INSERT INTO publicidad (titulo, url, id_imagen, fecha_creacion, fecha_actualizacion, tipo_publicidad, mi_publicidad) VALUES ('$_REQUEST[titulo]', '$_REQUEST[linkVideo]', 0, '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."', 1, '$_REQUEST[p]');");
						$msg = "OK";
				}
				else {
					$ext = getExtension($_FILES["file"]["name"]);
					$id = $db->getOne("SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'db678638694' AND TABLE_NAME = 'imagenes'");				
					if(move_uploaded_file($_FILES["file"]["tmp_name"], "../../img/ad/$id.$ext")) {
						$db->query("INSERT INTO imagenes (id, titulo, directorio, extension, fecha_creacion, fecha_actualizacion, nombre) VALUES ('$id', '$id', 'ad', '$ext', '".date('Y-m-d h:i:s')."', '".date('Y-m-d h:i:s')."', '$id')");
						$db->query("INSERT INTO publicidad (titulo, url, id_imagen, fecha_creacion, fecha_actualizacion, tipo_publicidad, mi_publicidad) VALUES ('$_REQUEST[titulo]', '$_REQUEST[link]', $id, '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."', 2, '$_REQUEST[p]');");
						$msg = "OK";
					}
					else{
						$msg = "ERROR";
					}
				}
				echo json_encode(array("msg" => $msg));
				break;
			case DETALLE:
				$info = $db->getRow("SELECT publicidad.*, CONCAT(imagenes.directorio,'/',imagenes.nombre,'.',imagenes.extension) AS imagen FROM publicidad LEFT JOIN imagenes ON imagenes.id=publicidad.id_imagen WHERE publicidad.id=$_REQUEST[i]");
				echo json_encode(array("msg" => "OK", "data" => $info));
				break;
			case MODIFICAR:
				if(isset($_REQUEST["option"])) {
					$pic = $db->getRow("SELECT imagenes.id, CONCAT(imagenes.directorio,'/',imagenes.nombre,'.',imagenes.extension) AS imagen FROM publicidad INNER JOIN imagenes ON imagenes.id=publicidad.id_imagen WHERE publicidad.id=$_REQUEST[i]");
					if($pic) {
						if(file_exists("../../img/$pic[imagen]")) {
							unlink("../../img/$pic[imagen]");
						}
						$db->query("DELETE FROM imagenes WHERE id=$pic[id]");
					}
					$db->query("UPDATE publicidad SET titulo='$_REQUEST[titulo]', url='$_REQUEST[linkVideo2]' fecha_actualizacion='".date('Y-m-d H:i:s')."', mi_publicidad='$_REQUEST[p]' WHERE id=$_REQUEST[i]");
				}
				else {
					$foto = count($_FILES) > 0 ? getExtension($_FILES["file"]["name"]) : false;
					$text = "";
					if($foto) {
						$pic = $db->getRow("SELECT imagenes.id, CONCAT(imagenes.directorio,'/',imagenes.nombre,'.',imagenes.extension) AS imagen FROM publicidad INNER JOIN imagenes ON imagenes.id=publicidad.id_imagen WHERE publicidad.id=$_REQUEST[i]");
						if(file_exists("../../img/$pic[imagen]")) {
							unlink("../../img/$pic[imagen]");
						}
						if(move_uploaded_file($_FILES["file"]["tmp_name"], "../img/notices/$pic[id].$foto")) {
							$db->query("UPDATE imagenes SET extension='$foto', fecha_actualizacion='".date('Y-m-d H:i:s')."' WHERE id=$pic[id]");
							$text = "OK";
						}
						else {
							$text = "ERROR";
						}
					}
					$db->query("UPDATE publicidad SET titulo='$_REQUEST[titulo]', url='$_REQUEST[link]' fecha_actualizacion='".date('Y-m-d H:i:s')."', mi_publicidad='$_REQUEST[p]' WHERE id=$_REQUEST[i]");
				}
				echo json_encode(array("msg" => "OK", "foto" => $text));
				break;
			case ELIMINAR:
				$pic = $db->getRow("SELECT imagenes.id, CONCAT(imagenes.directorio,'/',imagenes.nombre,'.',imagenes.extension) AS imagen FROM publicidad INNER JOIN imagenes ON imagenes.id=publicidad.id_imagen WHERE publicidad.id=$_REQUEST[i]");
				if(file_exists("../../img/$pic[imagen]")) {
					unlink("../../img/$pic[imagen]");
				}
				$db->query("DELETE FROM imagenes WHERE id=$pic[id]");
				$db->query("DELETE FROM publicidad WHERE id=$_REQUEST[i]");
				echo json_encode(array("msg" => "OK"));
				break;
			case CARGAR_ANIMADO:
				$publicidad = $db->getAll("SELECT publicidad.titulo, publicidad.url, CONCAT(imagenes.directorio,'/', imagenes.nombre,'.', imagenes.extension) AS imagen FROM publicidad INNER JOIN imagenes ON imagenes.id=publicidad.id_imagen ORDER BY RAND() LIMIT 4");
				$tmp = array();
				foreach($publicidad as $p) {
					if (strstr($p["url"], 'http')) {
						$p["url"] = $p["url"];
					}
					else {
						$p["url"] = "http://$p[url]";
					}
					$tmp[] = $p;
				}
				$publicidad = $tmp;
				echo json_encode($publicidad);
				break;
		}
	}
	function getExtension($str) {$i=strrpos($str,".");if(!$i){return"";}$l=strlen($str)-$i;$ext=substr($str,$i+1,$l);return $ext;}
?>