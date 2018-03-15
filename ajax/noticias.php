<?php
	session_start();

	define('CARGAR_CATEGORIAS', 1);
	define('AGREGAR_CATEGORIA', 2);
	define('DETALLE_CATEGORIA', 3);
	define('MODIFICAR_CATEGORIA', 4);
	define('ELIMINAR_CATEGORIA', 5);
	define('CARGAR_NOTICIAS', 7);
	define('AGREGAR_NOTICIA', 8);
	define('DETALLE_NOTICIA', 9);
	define('MODIFICAR_NOTICIA', 10);
	define('ELIMINAR_NOTICIA', 11);

	require_once('../classes/DatabasePDOInstance.function.php');
	require_once('../slug.function.php');

	$db = DatabasePDOInstance();

	$op = isset($_REQUEST["op"]) ? $_REQUEST["op"] : false;

	if($op) {
		switch($op) {
			case CARGAR_CATEGORIAS:
				$categorias["data"] = array();
				$datos = $db->getAll("
					SELECT
						*
					FROM
						categorias
				");

				if($datos) {
					$datos = array_reverse($datos);					
					foreach($datos as $k => $pub) {
						$categorias["data"][] = array(
							$k + 1,
							$pub["nombre"],
							date('d/m/Y', strtotime($pub["fecha_creacion"])),
							date('d/m/Y', strtotime($pub["fecha_creacion"])),
							'<div class="acciones-categoria" data-target="' . $pub["id"] . '"> <button type="button" class="accion-categoria btn btn-primary waves-effect waves-light" onclick="modificarCategoria(this);" title="Modificar categoría"><span class="ti-pencil"></span></button> <button type="button" class="accion-categoria btn btn-danger waves-effect waves-light" title="Eliminar categoría" onclick="eliminarCategoria(this);"><span class="ti-close"></span></button> </div>'
						);
					}
				}
				echo json_encode($categorias);
				break;
			case AGREGAR_CATEGORIA:
				$db->query("INSERT INTO categorias (nombre, fecha_creacion, fecha_actualizacion) VALUES ('$_REQUEST[titulo]', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."');");
				echo json_encode(array("msg" => "OK"));
				break;
			case DETALLE_CATEGORIA:
				$info = $db->getRow("SELECT * FROM categorias WHERE id=$_REQUEST[i]");
				echo json_encode(array("msg" => "OK", "data" => $info));
				break;
			case MODIFICAR_CATEGORIA:
				$db->query("UPDATE categorias SET nombre='$_REQUEST[titulo]', fecha_actualizacion='".date('Y-m-d H:i:s')."' WHERE id=$_REQUEST[i]");
				echo json_encode(array("msg" => "OK"));
				break;
			case ELIMINAR_CATEGORIA:
				$db->query("DELETE FROM categorias WHERE id=$_REQUEST[i]");
				$db->query("UPDATE noticias SET id_categoria='0' WHERE id_categoria=$_REQUEST[i]");
				echo json_encode(array("msg" => "OK"));
				break;
			case CARGAR_NOTICIAS:
				$noticias["data"] = array();
				$datos = $db->getAll("
					SELECT
						noticias.*,
						categorias.nombre 
					FROM
						noticias
					LEFT JOIN
						categorias ON categorias.id=noticias.id_categoria
				");

				if($datos) {
					$datos = array_reverse($datos);					
					foreach($datos as $k => $pub) {
						$noticias["data"][] = array(
							$k + 1,
							$pub["titulo"],
							($pub["nombre"] == "" ? "Sin categoría" : $pub["nombre"]),
							($pub["nombre"] == "" ? "Sin categoría" : $pub["nombre"]),
							date('d/m/Y', strtotime($pub["fecha_creacion"])),
							'<div class="acciones-publicacion" data-target="' . $pub["id"] . '"> <button type="button" class="accion-publicacion btn btn-primary waves-effect waves-light" onclick="modificarPublicacion(this);" title="Modificar noticia"><span class="ti-pencil"></span></button> <button type="button" class="accion-publicacion btn btn-danger waves-effect waves-light" title="Eliminar noticia" onclick="eliminarPublicacion(this);"><span class="ti-close"></span></button> </div>'
						);
					}
				}
				echo json_encode($noticias);
				break;
			case AGREGAR_NOTICIA:
				$ext = getExtension($_FILES["file"]["name"]);
				$db->beginTransaction();

				try {
					$id = $db->getOne("SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'db678638694' AND TABLE_NAME = 'imagenes'");				
					if(move_uploaded_file($_FILES["file"]["tmp_name"], "../img/notices/$id.$ext")) {
						$db->query("INSERT INTO imagenes (id, titulo, directorio, extension, fecha_creacion, fecha_actualizacion, nombre) VALUES ('$id', '$id', 'notices', '$ext', '".date('Y-m-d h:i:s')."', '".date('Y-m-d h:i:s')."', '$id')");
						$amigable = str_replace(array("\"", "'", " "), array("", "", "-"), $_REQUEST["titulo"]);
						$query = "INSERT INTO noticias (id_imagen, id_categoria, titulo, amigable, descripcion, fecha_creacion, fecha_actualizacion, veces_leido) VALUES ($id, '$_REQUEST[id_categoria]', '$_REQUEST[titulo]', '$amigable', '".addslashes($_REQUEST["descripcion"])."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."', 0)";
						$db->query($query);
						$db->commitTransaction();
						$msg = "OK";
					}
					else{
						$msg = "ERROR";
					}
				} catch(Exception $e){
					$db->rollBackTransaction();
					$msg = "ERROR";
				}
				
				echo json_encode(array("msg" => $msg));
				break;
			case DETALLE_NOTICIA:
				$info = $db->getRow("SELECT noticias.*, CONCAT(imagenes.directorio,'/',imagenes.nombre,'.',imagenes.extension) AS imagen, categorias.id AS id_categoria FROM noticias INNER JOIN imagenes ON imagenes.id=noticias.id_imagen LEFT JOIN categorias ON categorias.id=noticias.id_categoria WHERE noticias.id=$_REQUEST[i]");
				echo json_encode(array("msg" => "OK", "data" => $info));
				break;
			case MODIFICAR_NOTICIA:
				$foto = count($_FILES) > 0 ? getExtension($_FILES["file"]["name"]) : false;
				$text = "";
				if($foto) {
					$pic = $db->getRow("SELECT imagenes.id, CONCAT(imagenes.directorio,'/',imagenes.nombre,'.',imagenes.extension) AS imagen FROM noticias INNER JOIN imagenes ON imagenes.id=noticias.id_imagen WHERE noticias.id=$_REQUEST[i]");
					if(file_exists("../img/$pic[imagen]")) {
						unlink("../img/$pic[imagen]");
					}
					if(move_uploaded_file($_FILES["file"]["tmp_name"], "../img/notices/$pic[id].$foto")) {
						$db->query("UPDATE imagenes SET extension='$foto', fecha_actualizacion='".date('Y-m-d H:i:s')."' WHERE id=$pic[id]");
						$text = "OK";
					}
					else {
						$text = "ERROR";
					}
				}
				$amigable = str_replace(" ", "-", $_REQUEST["titulo"]);
				$db->query("UPDATE noticias SET id_categoria='$_REQUEST[id_categoria]', titulo='$_REQUEST[titulo]', amigable='$amigable', descripcion='$_REQUEST[descripcion]', fecha_actualizacion='".date('Y-m-d H:i:s')."' WHERE id=$_REQUEST[i]");
				echo json_encode(array("msg" => "OK", "foto" => $text));
				break;
			case ELIMINAR_NOTICIA:
				$pic = $db->getRow("SELECT imagenes.id, CONCAT(imagenes.directorio,'/',imagenes.nombre,'.',imagenes.extension) AS imagen FROM noticias INNER JOIN imagenes ON imagenes.id=noticias.id_imagen WHERE noticias.id=$_REQUEST[i]");
				if(file_exists("../img/$pic[imagen]")) {
					unlink("../img/$pic[imagen]");
				}
				$db->query("DELETE FROM imagenes WHERE id=$pic[id]");
				$db->query("DELETE FROM noticias WHERE id=$_REQUEST[i]");
				echo json_encode(array("msg" => "OK"));
				break;
		}
	}
	function getExtension($str) {$i=strrpos($str,".");if(!$i){return"";}$l=strlen($str)-$i;$ext=substr($str,$i+1,$l);return $ext;}
?>