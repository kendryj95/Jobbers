<?php
	session_start();
	require_once('../classes/DatabasePDOInstance.function.php');
	$db = DatabasePDOInstance();
	
	$op = isset($_REQUEST["op"]) ? $_REQUEST["op"] : false;
	define('ADD_TO_CURRICULUM', 1);
	define('LOAD_OPTION_CURRICULUM', 2);
	define('DELETE_OPTION_CURRICULUM', 3);
	define('EDIT_OPTION_CURRICULUM', 4);
	define('DELETE', 5);
	define('ADD_PHOTO', 6);
	define('LOAD_CURRICULUM', 7);
	define('REMOVE_ACCOUNT', 8);
	define('SAVE_PUBLIC', 9);
	define('LOAD_PROVINCE', 10);
	switch($op) {
		case ADD_TO_CURRICULUM:
			$id = isset($_REQUEST["i"]) ? $_REQUEST["i"] : false;
			$e = isset($_REQUEST["i"]) ? $_REQUEST["i"] : false;
			switch($_REQUEST["opt"]) {
				case 1:

					$db->query("UPDATE trabajadores SET id_sexo='$_REQUEST[sex]', id_estado_civil='$_REQUEST[estadoCivil]', id_tipo_documento_identificacion='$_REQUEST[dni]', id_pais='$_REQUEST[country]', provincia='$_REQUEST[province]', localidad='$_REQUEST[city]', calle='$_REQUEST[street]', nombres='$_REQUEST[name]',  apellidos='$_REQUEST[lastName]', correo_electronico='$_REQUEST[email]', numero_documento_identificacion='$_REQUEST[numberdni]', cuil='$_REQUEST[cuil]', fecha_nacimiento='".date('Y-m-d', strtotime($_REQUEST['birthday']))."', telefono='$_REQUEST[phone]', telefono_alternativo='$_REQUEST[phoneAlt]', fecha_actualizacion='".date('Y-m-d h:i:s')."' WHERE id=".$_SESSION["ctc"]["id"]);

					//Actualizar nombre y apellido en la variable de session.
					$_SESSION["ctc"]["name"] = explode(" ",$_REQUEST["name"])[0];
					$_SESSION["ctc"]["lastName"] = explode(" ",$_REQUEST["lastName"])[0];
					$data = array();
					$info = $db->getRow("SELECT * FROM trabajadores WHERE id = ".$_SESSION["ctc"]["id"]);
					if($info["nombres"] != "" && $info["apellidos"] != "" && $info["correo_electronico"] != "" && $info["id_imagen"] != "" && $info["id_estado_civil"] != "" && $info["id_tipo_documento_identificacion"] != ""  && $info["id_pais"] != ""  && $info["provincia"] != "" && $info["localidad"] != "" && $info["calle"] != "" && $info["numero_documento_identificacion"] != "" && $info["fecha_nacimiento"] != "" && $info["telefono"] != "") {
						$_SESSION["ctc"]["postulate"] = 1;
					}
					else {
						$_SESSION["ctc"]["postulate"] = 0;
					}
					
					break;
				case 2:
					if($id != "" && $id != "undefined") {
						$db->query("UPDATE trabajadores_experiencia_laboral SET nombre_empresa='$_REQUEST[company]', id_pais='$_REQUEST[rCompany]', id_actividad_empresa='$_REQUEST[tCompany]', tipo_puesto='$_REQUEST[tEmployeer]', mes_ingreso='$_REQUEST[monthI]', ano_ingreso='$_REQUEST[yearI]', mes_egreso='$_REQUEST[monthE]', ano_egreso='$_REQUEST[yearE]', trab_actualmt=$_REQUEST[trab_actual], nombre_encargado='$_REQUEST[nom_enc]', tlf_encargado='$_REQUEST[tlf_enc]', descripcion_tareas='$_REQUEST[descriptionArea]' WHERE id=$_REQUEST[i]");
					}
					else {
						if ($_REQUEST["company"] != "") {
							
							$id = $db->getOne("SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'db678638694' AND TABLE_NAME = 'trabajadores_experiencia_laboral'");
							
							$db->query("INSERT INTO trabajadores_experiencia_laboral (id_trabajador, nombre_empresa, id_pais, id_actividad_empresa, tipo_puesto, mes_ingreso, ano_ingreso, mes_egreso, ano_egreso, trab_actualmt, nombre_encargado, tlf_encargado, descripcion_tareas) VALUES ('".$_SESSION["ctc"]["id"]."', '$_REQUEST[company]', '$_REQUEST[rCompany]', '$_REQUEST[tCompany]', '$_REQUEST[tEmployeer]', '$_REQUEST[monthI]', '$_REQUEST[yearI]', '$_REQUEST[monthE]', '$_REQUEST[yearE]', '$_REQUEST[trab_actual]', '$_REQUEST[nom_enc]', '$_REQUEST[tlf_enc]', '$_REQUEST[descriptionArea]')");
						}
					}
					$data = $db->getAll("SELECT trabajadores_experiencia_laboral.*, paises.nombre as nombre_pais, actividades_empresa.nombre as actividad_empresa FROM trabajadores_experiencia_laboral INNER JOIN paises ON paises.id=trabajadores_experiencia_laboral.id_pais INNER JOIN actividades_empresa ON actividades_empresa.id=trabajadores_experiencia_laboral.id_actividad_empresa WHERE trabajadores_experiencia_laboral.id=$id");
					break;
				case 3:
					if($id != "" && $id != "undefined") {
						$db->query("UPDATE trabajadores_educacion SET id_nivel_estudio=$_REQUEST[sNivel], titulo='$_REQUEST[titleS]', id_estado_estudio=$_REQUEST[stateS], id_area_estudio=$_REQUEST[areaS], nombre_institucion='$_REQUEST[institute]', id_pais=$_REQUEST[countryS], mes_inicio=$_REQUEST[monthIn], ano_inicio=$_REQUEST[yearIn], mes_finalizacion=$_REQUEST[monthFi], ano_finalizacion=$_REQUEST[yearFi], materias_carrera=$_REQUEST[mat], materias_aprobadas=$_REQUEST[aprob] WHERE id=$_REQUEST[i]");
					}else {
						$id = $db->getOne("SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'db678638694' AND TABLE_NAME = 'trabajadores_educacion'");
						if ((isset($_REQUEST[monthFi]) || ($_REQUEST[monthFi] != ''))  && (isset($_REQUEST[yearFi]) || ($_REQUEST[yearFi] != ''))){
							$db->query("INSERT INTO trabajadores_educacion (id_trabajador, id_nivel_estudio, titulo, id_estado_estudio, id_area_estudio, nombre_institucion, id_pais, mes_inicio, ano_inicio, mes_finalizacion, ano_finalizacion, materias_carrera, materias_aprobadas) VALUES ('".$_SESSION["ctc"]["id"]."', '$_REQUEST[sNivel]', '$_REQUEST[titleS]', '$_REQUEST[stateS]', '$_REQUEST[areaS]', '$_REQUEST[institute]', '$_REQUEST[countryS]', '$_REQUEST[monthIn]', '$_REQUEST[yearIn]', '$_REQUEST[monthFi]', '$_REQUEST[yearFi]', '$_REQUEST[mat]', '$_REQUEST[aprob]')");
						}else{
							$db->query("INSERT INTO trabajadores_educacion (id_trabajador, id_nivel_estudio, titulo, id_estado_estudio, id_area_estudio, nombre_institucion, id_pais, mes_inicio, ano_inicio, materias_carrera, materias_aprobadas) VALUES ('".$_SESSION["ctc"]["id"]."', '$_REQUEST[sNivel]', '$_REQUEST[titleS]', '$_REQUEST[stateS]', '$_REQUEST[areaS]', '$_REQUEST[institute]', '$_REQUEST[countryS]', '$_REQUEST[monthIn]', '$_REQUEST[yearIn]', '$_REQUEST[mat]', '$_REQUEST[aprob]')");
						}
					}
					$data = $db->getAll("SELECT trabajadores_educacion.*, paises.nombre as nombre_pais, nivel_estudio.nombre as nivel, areas_estudio.nombre as nombre_estudio, estado_estudio.nombre as estado_estudio FROM trabajadores_educacion INNER JOIN paises ON paises.id=trabajadores_educacion.id_pais INNER JOIN nivel_estudio ON nivel_estudio.id=trabajadores_educacion.id_nivel_estudio INNER JOIN areas_estudio ON areas_estudio.id=trabajadores_educacion.id_area_estudio INNER JOIN estado_estudio ON estado_estudio.id=trabajadores_educacion.id_estado_estudio WHERE trabajadores_educacion.id=$id");
					break;
				case 4:
					if($id != "" && $id != "undefined") {
						$db->query("UPDATE trabajadores_idiomas SET id_idioma='$_REQUEST[idioma]', nivel_oral='$_REQUEST[nivelO]', nivel_escrito='$_REQUEST[nivelE]' WHERE id=$_REQUEST[i]");
					}
					else {
						$id = $db->getOne("SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'db678638694' AND TABLE_NAME = 'trabajadores_idiomas'");
						$db->query("INSERT INTO trabajadores_idiomas (id_trabajador, id_idioma, nivel_oral, nivel_escrito) VALUES ('".$_SESSION["ctc"]["id"]."', '$_REQUEST[idioma]', '$_REQUEST[nivelO]', '$_REQUEST[nivelE]')");
					}
					$idiomas = $db->getAll("SELECT trabajadores_idiomas.*, idiomas.nombre as nombre_idioma FROM trabajadores_idiomas INNER JOIN idiomas ON idiomas.id=trabajadores_idiomas.id_idioma WHERE trabajadores_idiomas.id=$id");
					foreach($idiomas as $i) {
						$nivel_oral = $db->getOne("SELECT nombre FROM nivel_idioma WHERE id=$i[nivel_oral]"); 
						$nivel_escrito = $db->getOne("SELECT nombre FROM nivel_idioma WHERE id=$i[nivel_escrito]");
						$i["nivel_oral"] = $nivel_oral;
						$i["nivel_escrito"] = $nivel_escrito;
						$data[] = $i;
					}
					break;
				case 5:
					if($id != "" && $id != "undefined") {
						$db->query("UPDATE trabajadores_otros_conocimientos SET nombre='$_REQUEST[nameC]', descripcion='$_REQUEST[descriptionC]' WHERE id=$_REQUEST[i]");
					}
					else {
						if ($_REQUEST["nameC"] != "") {
							
							$id = $db->getOne("SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'db678638694' AND TABLE_NAME = 'trabajadores_otros_conocimientos'");
							$db->query("INSERT INTO trabajadores_otros_conocimientos (id_trabajador, nombre, descripcion) VALUES ('".$_SESSION["ctc"]["id"]."', '$_REQUEST[nameC]', '$_REQUEST[descriptionC]')");
						}
					}
					$data = $db->getAll("SELECT * FROM trabajadores_otros_conocimientos WHERE id=$id");
					break;
				case 6:
					if($id != "" && $id != "undefined") {
						$db->query("UPDATE trabajadores_infextra SET remuneracion_pret=$_REQUEST[remuneracion], sobre_mi='$_REQUEST[sobre_mi]', disponibilidad='$_REQUEST[disp]' WHERE id_trabajador=$_REQUEST[i]");

						// Información adicional de las redes sociales
						$db->query("UPDATE trabajadores SET sitio_web ='$_REQUEST[sitio_web]', facebook='$_REQUEST[fb]', twitter='$_REQUEST[tw]', instagram='$_REQUEST[ig]', snapchat ='$_REQUEST[snap]', linkedin='$_REQUEST[lkd]' WHERE id=".$_REQUEST['i']);

						$data = $db->getAll("SELECT * FROM trabajadores_infextra WHERE id=$id");
					} else {

						$id = $db->getOne("SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'db678638694' AND TABLE_NAME = 'trabajadores_infextra'");

						$db->query("INSERT INTO trabajadores_infextra (id_trabajador, remuneracion_pret, sobre_mi,disponibilidad) VALUES ('".$_SESSION["ctc"]["id"]."', $_REQUEST[remuneracion], '$_REQUEST[sobre_mi]', $_REQUEST[disp] )");

						// Información adicional de las redes sociales
						$db->query("UPDATE trabajadores SET sitio_web ='$_REQUEST[sitio_web]', facebook='$_REQUEST[fb]', twitter='$_REQUEST[tw]', instagram='$_REQUEST[ig]', snapchat ='$_REQUEST[snap]', linkedin='$_REQUEST[lkd]' WHERE id=".$_SESSION["ctc"]["id"]);
						
					}

					$data = $db->getAll("SELECT ti.*, d.nombre AS disponibilidad FROM trabajadores_infextra ti INNER JOIN disponibilidad d ON d.id = ti.disponibilidad WHERE id=$id");
					break;
			}
			$v = 0;
			if($e != "" && $e != "undefined") {
				$v = 1;
			}
			echo json_encode(array("msg" => "OK", "data" => $data, "edit" => $v));
			break;
		case LOAD_OPTION_CURRICULUM:
			switch($_REQUEST["opt"]) {
				case 2:
					$data = $db->getRow("SELECT * FROM trabajadores_experiencia_laboral WHERE id=$_REQUEST[i]");
					break;
				case 3:
					$data = $db->getRow("SELECT * FROM trabajadores_educacion WHERE id=$_REQUEST[i]");
					break;
				case 4:
					$data = $db->getRow("SELECT * FROM trabajadores_idiomas WHERE id=$_REQUEST[i]");
					break;
				case 5:
					$data = $db->getRow("SELECT * FROM trabajadores_otros_conocimientos WHERE id=$_REQUEST[i]");
					break;
			}
			echo json_encode($data);
			break;
		case DELETE_OPTION_CURRICULUM:
			switch($_REQUEST["opt"]) {
				case 1:
					$data = $db->getRow("");
					break;
				case 2:
					$db->query("DELETE FROM trabajadores_experiencia_laboral WHERE id=$_REQUEST[i]");
					break;
				case 3:
					$data = $db->getRow("DELETE FROM trabajadores_educacion WHERE id=$_REQUEST[i]");
					break;
				case 4:
					$data = $db->getRow("DELETE FROM trabajadores_idiomas WHERE id=$_REQUEST[i]");
					break;
				case 5:
					$data = $db->getRow("DELETE FROM trabajadores_otros_conocimientos WHERE id=$_REQUEST[i]");
					break;
			}
			echo json_encode(array("msg" => "OK"));
			break;
		case ADD_PHOTO:
			$ext = getExtension($_FILES["file"]["name"]);
			$id = $db->getOne("SELECT id_imagen FROM trabajadores WHERE id=".$_SESSION["ctc"]["id"]);
			if($id) {
				//$file = $db->getRow("SELECT directorio, extension FROM imagenes WHERE id=$id");
				$file = $db->getOne("SELECT CONCAT(directorio, '/', 'id', '.', extension) FROM imagenes WHERE id= $id ");
				if(file_exists("../img/$file")) {
					unlink("../img/$file");
				}
				$db->query("UPDATE extension='$ext', fecha_actualizacion='".date('Y-m-d h:i:s')."' FROM imagenes WHERE id=$id");
			}
			else {
				$id = $db->getOne("SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'db678638694' AND TABLE_NAME = 'imagenes'");
				$db->query("INSERT INTO imagenes (id, titulo, directorio, extension, fecha_creacion, fecha_actualizacion, nombre) VALUES ('$id', '$id', 'profile', '$ext', '".date('Y-m-d h:i:s')."', '".date('Y-m-d h:i:s')."', '$id')");
				$db->query("UPDATE trabajadores SET id_imagen='$id' WHERE id=".$_SESSION["ctc"]["id"]);
			}
			if(move_uploaded_file($_FILES["file"]["tmp_name"], "../img/profile/$id.$ext")) {
				$t = 1;
				$_SESSION["ctc"]["pic"] = "profile/$id.$ext";
			}
			else{
				$t = 0;
			}
			echo json_encode(array("status" => $t));
			break;
		case LOAD_CURRICULUM:
			$data["usuario"] = $db->getRow("SELECT trabajadores.nombres, trabajadores.apellidos, trabajadores.correo_electronico, trabajadores.fecha_nacimiento, TIMESTAMPDIFF(YEAR,trabajadores.fecha_nacimiento,CURDATE()) AS edad, trabajadores.numero_documento_identificacion AS dni, trabajadores.cuil, trabajadores.telefono, trabajadores.telefono_alternativo, trabajadores.calle, paises.nombre as pais, localidades.localidad, provincias.provincia FROM trabajadores INNER JOIN paises ON paises.id = trabajadores.id_pais INNER JOIN localidades ON localidades.id = trabajadores.localidad	INNER JOIN provincias ON provincias.id = trabajadores.provincia WHERE trabajadores.id=".$_SESSION["ctc"]["id"]);
			$data["experiencias"] = $db->getAll("SELECT trabajadores_experiencia_laboral.*, paises.nombre as nombre_pais, actividades_empresa.nombre as actividad_empresa FROM trabajadores_experiencia_laboral INNER JOIN paises ON paises.id=trabajadores_experiencia_laboral.id_pais INNER JOIN actividades_empresa ON actividades_empresa.id=trabajadores_experiencia_laboral.id_actividad_empresa WHERE trabajadores_experiencia_laboral.id_trabajador = " . $_SESSION['ctc']['id'] ." ORDER BY trabajadores_experiencia_laboral.ano_egreso DESC, trabajadores_experiencia_laboral.mes_egreso DESC");
			$data["educacion"] = $db->getAll("SELECT trabajadores_educacion.*, paises.nombre as nombre_pais, nivel_estudio.nombre as nivel, areas_estudio.nombre as nombre_estudio, estado_estudio.nombre as estado_estudio FROM trabajadores_educacion INNER JOIN paises ON paises.id=trabajadores_educacion.id_pais INNER JOIN nivel_estudio ON nivel_estudio.id=trabajadores_educacion.id_nivel_estudio INNER JOIN areas_estudio ON areas_estudio.id=trabajadores_educacion.id_area_estudio INNER JOIN estado_estudio ON estado_estudio.id=trabajadores_educacion.id_estado_estudio WHERE trabajadores_educacion.id_trabajador=".$_SESSION["ctc"]["id"]);
			$idiomas = array();
			$idiomasT = $db->getAll("SELECT trabajadores_idiomas.*, idiomas.nombre as nombre_idioma FROM trabajadores_idiomas INNER JOIN idiomas ON idiomas.id=trabajadores_idiomas.id_idioma WHERE trabajadores_idiomas.id_trabajador=".$_SESSION["ctc"]["id"]);
			foreach($idiomasT as $i) {
				$i["nivel_oral"] = $db->getOne("SELECT nombre FROM nivel_idioma WHERE id=$i[nivel_oral]");
				$i["nivel_escrito"] = $db->getOne("SELECT nombre FROM nivel_idioma WHERE id=$i[nivel_escrito]");
				$idiomas[] = $i;
			}
			$data["idiomas"] = $idiomas;
			$data["otros_conocimientos"] = $db->getAll("SELECT * FROM trabajadores_otros_conocimientos WHERE id_trabajador=".$_SESSION["ctc"]["id"]);
			$data["info_extra"] = $db->getRow("SELECT ti.remuneracion_pret, ti.sobre_mi, d.nombre AS disponibilidad FROM trabajadores_infextra ti INNER JOIN disponibilidad d ON d.id = ti.disponibilidad WHERE id_trabajador =". $_SESSION['ctc']['id']);
			echo json_encode($data);
			break;
		case REMOVE_ACCOUNT:
			/*$pic = $db->getRow("SELECT imagenes.id, CONCAT(imagenes.directorio,'/',imagenes.id,'.', imagenes.extension) AS imagen FROM empresas INNER JOIN imagenes ON imagenes.id = empresas.id_imagen WHERE empresas.id = $_REQUEST[i]");
			if($pic) {
				$db->query("DELETE FROM imagenes WHERE id=$pic[id]");
				if(file_exists("../img/$pic[imagen]")) {
					unlink("../img/$pic[imagen]");
				}
			}
			$post = $db->getAll("SELECT id FROM publicaciones WHERE id_empresa=$_REQUEST[i]");
			foreach($post as $p) {
				$db->query("DELETE FROM publicaciones_imagenes WHERE id_publicacion=$p[id]");
				$db->query("DELETE FROM publicaciones_sectores WHERE id_publicacion=$p[id]");
				$db->query("DELETE FROM publicaciones_videos WHERE id_publicacion=$p[id]");
				$db->query("DELETE FROM publicaciones WHERE id=$p[id]");
			}
			$postE = $db->getAll("SELECT id, id_imagen, CONCAT(imagenes.directorio,'/',imagenes.id,'.', imagenes.extension) AS imagen FROM empresas_publicaciones_especiales LEFT JOIN imagenes ON imagenes.id = empresas_publicaciones_especiales.id_imagen WHERE empresas_publicaciones_especiales.id_empresa=$_REQUEST[i]");
			foreach($postE as  $p) {
				if($p["id_imagen"] == 0 && $p["id_imagen"] != "") {
					$db->query("DELETE FROM imagenes WHERE id=$p[id_imagen]");
					if(file_exists("../img/$p[imagen]")) {
						unlink("../img/$p[imagen]");
					}
				}
			}
			$db->query("DELETE FROM empresas WHERE id=$_REQUEST[i]");*/
			$pic = $db->getRow("SELECT imagenes.id, CONCAT(imagenes.directorio,'/',imagenes.id,'.', imagenes.extension) AS imagen FROM trabajadores INNER JOIN imagenes ON imagenes.id = trabajadores.id_imagen WHERE trabajadores.id = ".$_SESSION["ctc"]["id"]);
			if($pic) {
				$db->query("DELETE FROM imagenes WHERE id=$pic[id]");
				if(file_exists("../img/$pic[imagen]")) {
					unlink("../img/$pic[imagen]");
				}
			}
			$db->query("DELETE FROM trabajadores_educacion WHERE id_trabajador=".$_SESSION["ctc"]["id"]);
			$db->query("DELETE FROM trabajadores_experiencia_laboral WHERE id_trabajador=".$_SESSION["ctc"]["id"]);
			$db->query("DELETE FROM trabajadores_idiomas WHERE id_trabajador=".$_SESSION["ctc"]["id"]);
			$db->query("DELETE FROM trabajadores_otros_conocimientos WHERE id_trabajador=".$_SESSION["ctc"]["id"]);
			$post = $db->getAll("SELECT id FROM trabajadores_publicaciones WHERE id_trabajador=".$_SESSION["ctc"]["id"]);
			foreach($post as $p) {
				$db->query("DELETE FROM trabajadores_areas_sectores WHERE id_publicacion=$p[i]");
				$db->query("DELETE FROM trabajadores_publicaciones WHERE id=$p[i]");
			}
			$db->query("DELETE FROM trabajadores WHERE id=".$_SESSION["ctc"]["id"]);
			session_start();
			session_destroy();
			unset($_SESSION["ctc"]["empresa"]);
			unset($_SESSION["ctc"]);
			echo json_encode(array("msg" => "OK"));
			break;
		case SAVE_PUBLIC:
			$db->query("UPDATE trabajadores SET publico=$_REQUEST[public] WHERE id=" . $_SESSION["ctc"]["id"]);
			echo json_encode(array("msg" => "OK"));
			break;
		case LOAD_PROVINCE:
			
			$provincia = $_POST['provincia'];
			
			$json['localidades'] = $db->getAll("SELECT * FROM localidades WHERE id_provincia=". $provincia . " ORDER BY localidad");
			
			echo json_encode($json);
			break;
	}
	function getExtension($str) {$i=strrpos($str,".");if(!$i){return"";}$l=strlen($str)-$i;$ext=substr($str,$i+1,$l);return $ext;}
?>