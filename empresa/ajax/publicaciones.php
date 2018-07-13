<?php
	session_start();

	define('AGREGAR', 1);
	define('DETALLES', 2);
	define('MODIFICAR', 3);
	define('ELIMINAR', 4);
	define('CARGAR_TODAS', 5);
	define('OBTENER_POSTULADOS', 6);
	define('AGREGAR_ESPECIAL', 7);
	define('CARGAR_ESPECIAL', 8);
	define('VALIDAR_PUB', 9);
	define('RENOVAR_PUB', 10);
	define('DETENER_RENAUDAR', 11);

	require_once('../../classes/DatabasePDOInstance.function.php');
	require_once('../../slug.function.php');

	$db = DatabasePDOInstance();

	$op = isset($_REQUEST["op"]) ? $_REQUEST["op"] : false;

	$infoEmpresa = $_SESSION["ctc"]["empresa"];

	if($op) {
		switch($op) {
			case AGREGAR:
				$info = isset($_REQUEST["info"]) ? json_decode($_REQUEST["info"], true) : false;

				$db->beginTransaction();

				try{
					if($info) {
						$coordenadas = "";
						if($info["latitud"] != "" && $info["latitud"] != null  && $info["longitud"] != "" && $info["longitud"] != null) {
							$coordenadas = "$info[latitud],$info[longitud]";
						}
						$id = $db->getOne("
							SELECT
								AUTO_INCREMENT
							FROM
								INFORMATION_SCHEMA.TABLES
							WHERE
								TABLE_SCHEMA = 'db678638694'
							AND TABLE_NAME = 'publicaciones'
						");

						$sql="
							INSERT INTO publicaciones (
								id,
								id_empresa,
								titulo,
								descripcion,
								amigable,
								fecha_creacion,
								fecha_actualizacion,
								coordenadas,
								ubicacion,
								disponibilidad,
								provincia,
								localidad
							)
							VALUES
							(
								'$id',
								'$infoEmpresa[id]',
								'$info[titulo]',
								'$info[descripcion]',
								'" . slug($info["titulo"]) . "',
								'" . date('Y-m-d H:i:s') . "',
								'" . date('Y-m-d H:i:s') . "',
								'$coordenadas',
								'',
								'$info[disponibilidad]',
								 $info[provincia],
								 $info[localidad]
							)";
						$db->query($sql);

						$db->query("
							INSERT INTO publicaciones_sectores (
								id_publicacion,
								id_sector
							)
							VALUES (
								'$id',
								'$info[sector]'
							)
						");

						$publicacion = $db->getRow("
							SELECT
								*
							FROM
								publicaciones
							WHERE
								id = $id
						");

						$db->commitTransaction();

						echo json_encode(array(
							"msg" => "OK",
							"data" => array(
								"publicacion" => $publicacion
							)
						));
					}
				} catch(Exception $e){
					$db->rollBackTransaction();
					echo json_encode(
						array(
							"msg" => "Ah ocurrido un error de comunicación con el servidor, por favor verifique su conexión a internet e intente de nuevo.",
							"console" => $e->getMessage()
						)
					);
				}


				break;
			case MODIFICAR:
				$id = isset($_REQUEST["i"]) ? json_decode($_REQUEST["i"], true) : false;
				$info = isset($_REQUEST["info"]) ? json_decode($_REQUEST["info"], true) : false;

				$db->beginTransaction();

				try {
					if($id && $info) {

						$coordenadas = "";
						if($info["latitud"] != "" && $info["latitud"] != null  && $info["longitud"] != "" && $info["longitud"] != null) {
							$coordenadas = "$info[latitud],$info[longitud]";
						}
						$sql="
							UPDATE publicaciones
							SET
							titulo = '$info[titulo]',
							descripcion = '$info[descripcion]',
							amigable = '" . slug($info["titulo"]) . "',
							fecha_actualizacion = '" . date('Y-m-d H:i:s') . "',
							coordenadas='$coordenadas',
							provincia=$info[provincia],
							localidad=$info[localidad],
							disponibilidad=$info[disponibilidad]
							WHERE
								id = $id
						";


						$db->query($sql);

						$db->query("
							DELETE
							FROM
								publicaciones_sectores
							WHERE
								id_publicacion = $id
						");

						$db->query("
							INSERT INTO publicaciones_sectores (
								id_publicacion,
								id_sector
							)
							VALUES (
								'$id',
								'$info[sector]'
							)
						");

						$publicacion = $db->getRow("
							SELECT
								*
							FROM
								publicaciones
							WHERE
								id = $id
						");

						$db->commitTransaction();

						echo json_encode(array(
							"msg" => "OK",
							"data" => array(
								"publicacion" => $publicacion
							)
						));
					}
				}catch(Exception $e){
					$db->rollBackTransaction();
					echo json_encode(
						array(
							"msg" => "Ah ocurrido un error de comunicación con el servidor, por favor verifique su conexión a internet e intente de nuevo.",
							"console" => $e->getMessage()
						)
					);
				}


				break;
			case ELIMINAR:
				$id = isset($_REQUEST["i"]) ? json_decode($_REQUEST["i"], true) : false;

				$db->beginTransaction();

				try{
					if($id) {
						$db->query("
							DELETE
							FROM
								publicaciones
							WHERE
								id = $id
						");

						$db->commitTransaction();

						echo json_encode(array(
							"msg" => "OK"
						));
					}
				}catch(Exception $e){
					$db->rollBackTransaction();
					echo json_encode(
						array(
							"msg" => "Ah ocurrido un error de comunicación con el servidor, por favor verifique su conexión a internet e intente de nuevo.",
							"console" => $e->getMessage()
						)
					);
				}

				break;
			case CARGAR_TODAS:
				$publicaciones = array();
				$publicaciones["data"] = array();

				$datos = $db->getAll("
					SELECT
						r.*
					FROM
						(
							SELECT
								p.*, a.amigable AS area_amigable,
								asec.amigable AS sector_amigable,
								(
									SELECT
										COUNT(*)
									FROM
										postulaciones
									WHERE
										id_publicacion = p.id
								) AS postulados,
								(
									SELECT
										MAX(fecha_hora)
									FROM
										postulaciones
									WHERE
										id_publicacion = p.id
								) AS ultima_fecha_postulacion
							FROM
								publicaciones AS p
							LEFT JOIN publicaciones_sectores AS ps ON p.id = ps.id_publicacion
							LEFT JOIN areas_sectores AS asec ON ps.id_sector = asec.id
							LEFT JOIN areas AS a ON asec.id_area = a.id
							WHERE
								id_empresa = $infoEmpresa[id]
						) AS r
					ORDER BY
						r.ultima_fecha_postulacion,
						r.postulados DESC
				");

                $plan = $db->getRow("SELECT id_plan FROM empresas_planes WHERE id_empresa=".$_SESSION['ctc']['empresa']['id']);

                if($datos) {
					$datos = array_reverse($datos);
					foreach($datos as $k => $pub) {
						$pub["link_postulados"] = $pub["postulados"] > 0 ? ('<a value="'.$pub["titulo"].'" class="text-primary" href="javascript: void(0);" onclick="limpiarFiltros()" data-toggle="modal" data-target="#modal-postulados" data-id="' . $pub["id"] . '"><span class="underline">' . $pub["postulados"] . ' trabajador(es)</span></a>') : "";

						$fecha_creac_pub = date('d/m/Y', strtotime($pub["fecha_actualizacion"]));
						$fecha_final_pub = '&#x221e;';

						switch ($plan['id_plan']){ // Planes
                            case 1: // Plan Gratis
                                $timestamp_final = strtotime("+15 day", strtotime($pub["fecha_actualizacion"]));
                                $fecha_final_pub = date('d/m/Y', $timestamp_final);

                                $timestamp_today = strtotime(date('Y-m-d'));

                                if ($timestamp_today >= $timestamp_final) { // ¿Caducó?
                                	if ($pub["estatus"] == 1) { // Si la publicacion caducó pero sigue estando activa, desactivarla.
                                		$db->query("UPDATE publicaciones SET estatus=0 WHERE id=".$pub["id"]);
                                	}
                                } 

                                $startStopPub = $pub["estatus"] == 1 ? '<button type="button" class="accion-publicacion btn btn-default waves-effect waves-light" title="Detener publicación" onclick="stopStartPub(this,0)"><i class="fa fa-pause"></i></button>' : '<button type="button" class="accion-publicacion btn btn-default waves-effect waves-light" title="Renaudar publicación" onclick="stopStartPub(this,1)"><i class="fa fa-play"></i></button>';

                                $accion = $timestamp_today <= $timestamp_final ? '<div class="acciones-publicacion btn-group" role="group" data-target="' . $pub["id"] . '"> <a class="accion-publicacion btn btn-success waves-effect waves-light" title="Previsualizar publicación" href="../empleos-detalle.php?a=' . $pub["area_amigable"] . '&s=' . $pub["sector_amigable"] . '&p=' . $pub["amigable"] . '&e='.$_SESSION['ctc']['id'].'"><i class="icon icon-eye-plus"></i></a> <button type="button" class="accion-publicacion btn btn-primary waves-effect waves-light" onclick="modificarPublicacion(this);" title="Modificar publicación"><i class="fa fa-pencil-square-o"></i></button> <button type="button" class="accion-publicacion btn btn-danger waves-effect waves-light" title="Eliminar publicación" onclick="eliminarPublicacion(this);"><i class="fa fa-trash"></i></button> ' . $startStopPub . '</div>' : '
                                	<div class="acciones-publicacion btn-group" role="group" data-target="' . $pub["id"] . '">
                                	<a class="accion-publicacion btn btn-success waves-effect waves-light" title="Previsualizar publicación" href="../empleos-detalle.php?a=' . $pub["area_amigable"] . '&s=' . $pub["sector_amigable"] . '&p=' . $pub["amigable"] . '&e='.$pub["id_empresa"].'"><i class="icon icon-eye-plus"></i></a> <button type="button" class="accion-publicacion btn btn-primary waves-effect waves-light" onclick="renovarPublicacion(this);" title="Renovar publicación"><i class="fa fa-retweet"></i></button> <button type="button" class="accion-publicacion btn btn-danger waves-effect waves-light" title="Eliminar publicación" onclick="eliminarPublicacion(this);"><i class="fa fa-trash"></i></button> </div> ';

                                $caducada = $timestamp_today <= $timestamp_final ? '' : '<br><span class="label label-danger">OFERTA CADUCADA</span>';

                                // if ($timestamp_today <= $timestamp_final) {
                                    $publicaciones["data"][] = array(
                                        $k + 1,
                                        $pub["titulo"].$caducada,
                                        $pub["descripcion"],
                                      	$pub["link_postulados"],
                                        $fecha_creac_pub,
                                        $fecha_final_pub,
                                        $accion,
                                    );
                                // }
                                break;
                            case 2: // Plan Bronce
                                $timestamp_final = strtotime("+30 day", strtotime($pub["fecha_actualizacion"]));
                                $fecha_final_pub = date('d/m/Y', $timestamp_final);

                                $timestamp_today = strtotime(date('Y-m-d'));

                                if ($timestamp_today >= $timestamp_final) { // ¿Caducó?
                                	if ($pub["estatus"] == 1) { // Si la publicacion caducó pero sigue estando activa, desactivarla.
                                		$db->query("UPDATE publicaciones SET estatus=0 WHERE id=".$pub["id"]);
                                	}
                                } 

                                $startStopPub = $pub["estatus"] == 1 ? '<button type="button" class="accion-publicacion btn btn-default waves-effect waves-light" title="Detener publicación" onclick="stopStartPub(this,0)"><span class="ti-hand-stop"></span></button>' : '<button type="button" class="accion-publicacion btn btn-default waves-effect waves-light" title="Renaudar publicación" onclick="stopStartPub(this,1)"><span class="ti-control-play"></span></button>';

                                $accion = $timestamp_today <= $timestamp_final ? '<div class="acciones-publicacion btn-group" role="group" data-target="' . $pub["id"] . '"> <a class="accion-publicacion btn btn-success waves-effect waves-light" title="Previsualizar publicación" href="../empleos-detalle.php?a=' . $pub["area_amigable"] . '&s=' . $pub["sector_amigable"] . '&p=' . $pub["amigable"] . '&e='.$pub["id_empresa"].'"><i class="icon icon-eye-plus"></i></a> <button type="button" class="accion-publicacion btn btn-primary waves-effect waves-light" onclick="modificarPublicacion(this);" title="Modificar publicación"><i class="fa fa-pencil-square-o"></i></button> <button type="button" class="accion-publicacion btn btn-danger waves-effect waves-light" title="Eliminar publicación" onclick="eliminarPublicacion(this);"><i class="fa fa-trash"></i></button> ' . $startStopPub . '</div>' : '
                                	<div class="acciones-publicacion btn-group" role="group" data-target="' . $pub["id"] . '">
                                	<a class="accion-publicacion btn btn-success waves-effect waves-light" title="Previsualizar publicación" href="../empleos-detalle.php?a=' . $pub["area_amigable"] . '&s=' . $pub["sector_amigable"] . '&p=' . $pub["amigable"] . '"><i class="icon icon-eye-plus"></i></a> <button type="button" class="accion-publicacion btn btn-primary waves-effect waves-light" onclick="renovarPublicacion(this);" title="Renovar publicación"><i class="fa fa-retweet"></i></button> <button type="button" class="accion-publicacion btn btn-danger waves-effect waves-light" title="Eliminar publicación" onclick="eliminarPublicacion(this);"><i class="fa fa-trash"></i></button> </div> ';

                                $caducada = $timestamp_today <= $timestamp_final ? '' : '<br><span class="label label-danger">OFERTA CADUCADA</span>';

                                // if ($timestamp_today <= $timestamp_final) {
                                    $publicaciones["data"][] = array(
                                        $k + 1,
                                        $pub["titulo"].$caducada,
                                        $pub["descripcion"],
                                        $pub["link_postulados"],
                                        $fecha_creac_pub,
                                        $fecha_final_pub,
                                        $accion,
                                    );
                                // }
                                break;
                            case 3: // Plan Plata
                            	$timestamp_final = strtotime("+30 day", strtotime($pub["fecha_actualizacion"]));
                                $fecha_final_pub = date('d/m/Y', $timestamp_final);

                                $timestamp_today = strtotime(date('Y-m-d'));

                                if ($timestamp_today >= $timestamp_final) { // ¿Caducó?
                                	if ($pub["estatus"] == 1) { // Si la publicacion caducó pero sigue estando activa, desactivarla.
                                		$db->query("UPDATE publicaciones SET estatus=0 WHERE id=".$pub["id"]);
                                	}
                                } 

                                $startStopPub = $pub["estatus"] == 1 ? '<button type="button" class="accion-publicacion btn btn-default waves-effect waves-light" title="Detener publicación" onclick="stopStartPub(this,0)"><span class="ti-hand-stop"></span></button>' : '<button type="button" class="accion-publicacion btn btn-default waves-effect waves-light" title="Renaudar publicación" onclick="stopStartPub(this,1)"><span class="ti-control-play"></span></button>';

								$accion = $timestamp_today <= $timestamp_final ? '<div class="acciones-publicacion btn-group" role="group" data-target="' . $pub["id"] . '"> <a class="accion-publicacion btn btn-success waves-effect waves-light" title="Previsualizar publicación" href="../empleos-detalle.php?a=' . $pub["area_amigable"] . '&s=' . $pub["sector_amigable"] . '&p=' . $pub["amigable"] . '&e='.$pub["id_empresa"].'"><i class="icon icon-eye-plus"></i></a> <button type="button" class="accion-publicacion btn btn-primary waves-effect waves-light" onclick="modificarPublicacion(this);" title="Modificar publicación"><i class="fa fa-pencil-square-o"></i></button> <button type="button" class="accion-publicacion btn btn-danger waves-effect waves-light" title="Eliminar publicación" onclick="eliminarPublicacion(this);"><i class="fa fa-trash"></i></button> ' . $startStopPub . '</div>' : '
								<div class="acciones-publicacion btn-group" role="group" data-target="' . $pub["id"] . '">
								<a class="accion-publicacion btn btn-success waves-effect waves-light" title="Previsualizar publicación" href="../empleos-detalle.php?a=' . $pub["area_amigable"] . '&s=' . $pub["sector_amigable"] . '&p=' . $pub["amigable"] . '"><i class="icon icon-eye-plus"></i></a> <button type="button" class="accion-publicacion btn btn-primary waves-effect waves-light" onclick="renovarPublicacion(this);" title="Renovar publicación"><i class="fa fa-retweet"></i></button> <button type="button" class="accion-publicacion btn btn-danger waves-effect waves-light" title="Eliminar publicación" onclick="eliminarPublicacion(this);"><i class="fa fa-trash"></i></button> </div> ';

							$caducada = $timestamp_today <= $timestamp_final ? '' : '<br><span class="label label-danger">OFERTA CADUCADA</span>';

                                // if ($timestamp_today <= $timestamp_final) {
                                    $publicaciones["data"][] = array(
                                        $k + 1,
                                        $pub["titulo"].$caducada,
                                        $pub["descripcion"],
                                        $pub["link_postulados"],
                                        $fecha_creac_pub,
                                        $fecha_final_pub,
                                        $accion,
                                    );
                                // }
                            	break;
                            default: // Plan Oro

                            	$timestamp_final = strtotime("+35 day", strtotime($pub["fecha_actualizacion"]));
                            	$fecha_final_pub = date('d/m/Y', $timestamp_final);

                            	$timestamp_today = strtotime(date('Y-m-d'));

                            	if ($timestamp_today >= $timestamp_final) { // ¿Caducó?
                            		if ($pub["estatus"] == 1) { // Si la publicacion caducó pero sigue estando activa, desactivarla.
                            			$db->query("UPDATE publicaciones SET estatus=0 WHERE id=".$pub["id"]);
                            		}
                            	} 

                            	$startStopPub = $pub["estatus"] == 1 ? '<button type="button" class="accion-publicacion btn btn-default waves-effect waves-light" title="Detener publicación" onclick="stopStartPub(this,0)"><i class="fa fa-pause"></i></button>' : '<button type="button" class="accion-publicacion btn btn-default waves-effect waves-light" title="Renaudar publicación" onclick="stopStartPub(this,1)"><i class="fa fa-play"></i></button>';

                            	$accion = $timestamp_today <= $timestamp_final ? '<div class="acciones-publicacion btn-group" role="group" data-target="' . $pub["id"] . '"> <a class="accion-publicacion btn btn-success waves-effect waves-light" title="Previsualizar publicación" href="../empleos-detalle.php?a=' . $pub["area_amigable"] . '&s=' . $pub["sector_amigable"] . '&p=' . $pub["amigable"] . '&e='.$pub["id_empresa"].'"><i class="icon icon-eye-plus"></i></a> <button type="button" class="accion-publicacion btn btn-primary waves-effect waves-light" onclick="modificarPublicacion(this);" title="Modificar publicación"><i class="fa fa-pencil-square-o"></i></button> <button type="button" class="accion-publicacion btn btn-danger waves-effect waves-light" title="Eliminar publicación" onclick="eliminarPublicacion(this);"><i class="fa fa-trash"></i></button> ' . $startStopPub . '</div>' : '
                                	<div class="acciones-publicacion btn-group" role="group" data-target="' . $pub["id"] . '">
                                	<a class="accion-publicacion btn btn-success waves-effect waves-light" title="Previsualizar publicación" href="../empleos-detalle.php?a=' . $pub["area_amigable"] . '&s=' . $pub["sector_amigable"] . '&p=' . $pub["amigable"] . '"><i class="icon icon-eye-plus"></i></a> <button type="button" class="accion-publicacion btn btn-primary waves-effect waves-light" onclick="renovarPublicacion(this);" title="Renovar publicación"><i class="fa fa-retweet"></i></button> <button type="button" class="accion-publicacion btn btn-danger waves-effect waves-light" title="Eliminar publicación" onclick="eliminarPublicacion(this);"><i class="fa fa-trash"></i></button> </div> ';

                                $caducada = $timestamp_today <= $timestamp_final ? '' : '<br><span class="label label-danger">OFERTA CADUCADA</span>';

                                $publicaciones["data"][] = array(
                                    $k + 1,
                                    $pub["titulo"].$caducada,
                                    $pub["descripcion"],
                                    $pub["link_postulados"],
                                    $pub["fecha_actualizacion"],
                                    $fecha_final_pub,
                                    $accion,
                                );
                                break;
                        }

					}
				}

				echo json_encode($publicaciones);
				break;
			case DETALLES:
				$id = isset($_REQUEST["i"]) ? $_REQUEST["i"] : false;
				if($id) {
					$publicacion = $db->getRow("
						SELECT
							p.*, a.id AS area_id,
							s.id AS sector_id
						FROM
							publicaciones AS p
						LEFT JOIN publicaciones_sectores AS ps ON p.id = ps.id_publicacion
						LEFT JOIN areas_sectores AS s ON ps.id_sector = s.id
						LEFT JOIN areas AS a ON s.id_area = a.id
						WHERE
							p.id = $id
					");

					echo json_encode(array(
						"msg" => "OK",
						"data" => array(
							"publicacion" => $publicacion
						)
					));
				}
				break;
			case OBTENER_POSTULADOS:
				$id = isset($_REQUEST["i"]) ? $_REQUEST["i"] : false;
				$condicion_nivel_estudio = isset($_REQUEST["n"]) ? " AND t4.id_nivel_estudio=" . $_REQUEST["n"] : "";
				$postulados = array();

				$plan = $db->getRow("SELECT id_plan FROM empresas_planes WHERE id_empresa=".$_SESSION['ctc']['empresa']['id']);

				$limit = '';

				switch ($plan['id_plan']) {
					case 1: // Plan Gratis
						$limit = "LIMIT 10";
						break;
					case 2: // Plan Bronce
						$limit = "LIMIT 40";
						break;
					case 3: // Plan Plata
						$limit = "LIMIT 100";
						break;
				}
				$sql="SELECT
					t1.id,
					t2.id_trabajador,
					t3.uid AS uid_trabajador,
					t3.id_sexo,
					t2.fecha_hora,
					t3.provincia,
					t4.id_area_estudio,
					UPPER(CONCAT(t3.nombres,' ',t3.apellidos)) as nombre,
					TIMESTAMPDIFF(YEAR,t3.fecha_nacimiento,CURDATE()) AS edad,
					t5.calificacion,
					t6.marcador,
					t7.remuneracion_pret,
					group_concat(t8.id_idioma) as idiomas,
					group_concat(t10.nombre) as actividad_empresa,
					IF(t4.ano_finalizacion<>0,YEAR(CURDATE()) - t4.ano_finalizacion,0) AS anio_graduado
					FROM publicaciones t1
					LEFT JOIN postulaciones t2 ON t2.id_publicacion = t1.id
					LEFT JOIN trabajadores t3 ON t3.id = t2.id_trabajador
					LEFT JOIN trabajadores_educacion t4 ON t4.id_trabajador = t3.id
					LEFT JOIN trabajadores_calificacion t5 ON t5.id_trabajador = t3.id and t5.id_publicacion = t1.id
					LEFT JOIN trabajadores_marcadores t6 ON t6.id_trabajador = t3.id and t6.id_publicacion = t1.id
					LEFT JOIN trabajadores_infextra t7 ON t7.id_trabajador = t3.id
					LEFT JOIN trabajadores_idiomas t8 ON t8.id_trabajador = t3.id

					LEFT JOIN trabajadores_experiencia_laboral t9 ON t9.id_trabajador = t3.id
					LEFT JOIN actividades_empresa t10 ON t10.id = t9.id_actividad_empresa

					WHERE t1.id=".$id . $condicion_nivel_estudio."
					GROUP by t3.id $limit";



				$datos = $db->getAll($sql);



				if($datos) {

					 $calificar = array(
					 	'' => '',
					 	'1' => '★',
					 	'2' => '★★',
					 	'3' => '★★★',
					 	'4' => '★★★★',
					 	'5' => '★★★★★',
					 	);
					foreach($datos as $k => $fila) {

						$sexos = array(1 => "M", 2 => "F");
						$marcadores = array("" => "Normal",
							"0" => "Descartado",
							"1" => "Contactado",
							"2" => "En proceso",
							"3" => "Evaluando",
							"4" => "Finalista",
							"5" => "Contratado",

							);
						$postulados[] = array(

							$k + 1,
							'<a target="_blank" style="font-size:12px;" href="../trabajador-detalle.php?t=' . $fila["id_trabajador"] . '&pubid=' . $fila["id"] . '"><strong>' . "$fila[nombre]" . '</strong></a>
							<div style="color: #ffde00;font-size:14px;">'.$calificar[$fila['calificacion']].'</div>
							<div style="font-size:11px;">
							<strong>Edad: </strong>' . $fila["edad"] . '<strong>
							Sexo: </strong>' . $sexos[$fila["id_sexo"] ]. '

							</div>
							',
							$fila['edad'],
							$fila['id_area_estudio'],
							$fila['provincia'],
							$fila['id_sexo'],
							$fila['remuneracion_pret'],
							$fila['calificacion'],
							$fila['idiomas'],
							$fila['actividad_empresa'],
							$fila['marcador'],
							$fila['anio_graduado'],
							$fila['fecha_hora'],
							'<div class="acciones-publicacion text-center" data-target="' . $fila["id_trabajador"] . '">
							 <strong></strong>'. $marcadores[$fila["marcador"]].'
							</div>',
						);
					}
				}
				echo json_encode(array(
					"data" => $postulados,
				));
				break;
			case AGREGAR_ESPECIAL:

				$db->beginTransaction();

				if(isset($_REQUEST["edit"])) {
					if(isset($_REQUEST["video"])) {

						try{
							$id_imagen = $db->getOne("SELECT id_imagen FROM empresas_publicaciones_especiales WHERE id_empresa=".$_SESSION["ctc"]["id"]);
							if($id_imagen != "") {
								$imagen = $db->getOne("SELECT CONCAT(directorio,'/',nombre,'.',extension) FROM imagenes WHERE id=$id_imagen");
								if(file_exists("../img/$imagen")) {
									unlink("../img/$imagen");
								}
								$db->query("DELETE FROM imagenes WHERE id=$id_imagen");
							}
							$db->query("UPDATE empresas_publicaciones_especiales SET titulo='$_REQUEST[titulo]', url='$_REQUEST[url]'");
							$t = 1;

							$db->commitTransaction();

						}catch(Exception $e){
							$db->rollBackTransaction();
							$t = 3;
						}

					}
					else {

						try{
							$ext = getExtension($_FILES["file"]["name"]);
							$id_imagen = $db->getOne("SELECT id_imagen FROM empresas_publicaciones_especiales WHERE id_empresa=".$_SESSION["ctc"]["id"]);
							$imagen = $db->getOne("SELECT CONCAT(directorio,'/',nombre,'.',extension) FROM imagenes WHERE id=$id_imagen");
							if(file_exists("../img/$imagen")) {
								unlink("../img/$imagen");
							}
							$db->query("INSERT INTO empresas_publicaciones_especiales (id, id_empresa, tipo, titulo, descripcion, id_imagen, enlace, fecha_creacion) VALUES ($id, '".$_SESSION["ctc"]["id"]."', 1, '$_REQUEST[titulo]', '$_REQUEST[descripcion]', $id_imagen, NULL, '".date('Y-m-d')."');");
							if(move_uploaded_file($_FILES["file"]["tmp_name"], "../img/product/$id_imagen.$ext")) {
								$db->query("UPDATE empresas_publicaciones_especiales SET extension='$ext', fecha_actualizacion='".date('Y-m-d h:i:s')."' WHERE id=$id_imagen");
								$t = 1;
							}
							else {
								$t = 2;
							}

							$db->commitTransaction();
						}catch(Exception $e){
							$db->rollBackTransaction();
							$t = 3;
						}
					}
				}
				else {
					$id = $db->getOne("SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'db678638694' AND TABLE_NAME = 'empresas_publicaciones_especiales'");
					if(isset($_REQUEST["video"])) {

						try{
							$db->query("INSERT INTO empresas_publicaciones_especiales (id, id_empresa, tipo, titulo, descripcion, id_imagen, enlace, fecha_creacion) VALUES ($id, '".$_SESSION["ctc"]["id"]."', 2, '$_REQUEST[titulo]', '', 0, '$_REQUEST[url]', '".date('Y-m-d')."');");
							$t = 1;

							$db->commitTransaction();
						}catch(Exception $e){
							$db->rollBackTransaction();
							$t = 3;
						}
					}
					else {

						try{
							$ext = getExtension($_FILES["file"]["name"]);
							$id_imagen = $db->getOne("SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'db678638694' AND TABLE_NAME = 'imagenes'");
							$db->query("INSERT INTO empresas_publicaciones_especiales (id, id_empresa, tipo, titulo, descripcion, id_imagen, enlace) VALUES ($id, '".$_SESSION["ctc"]["id"]."', 1, '$_REQUEST[titulo]', '$_REQUEST[descripcion]', $id_imagen, NULL);");
							if(move_uploaded_file($_FILES["file"]["tmp_name"], "../img/product/$id_imagen.$ext")) {
								$db->query("INSERT INTO imagenes (id, titulo, directorio, extension, fecha_creacion, fecha_actualizacion, nombre) VALUES ('$id_imagen', '$id_imagen', 'product', '$ext', '".date('Y-m-d h:i:s')."', '".date('Y-m-d h:i:s')."', '$id_imagen')");
								$t = 1;
							}
							else {
								$t = 2;
							}
							$db->commitTransaction();
						}catch(Exception $e){
							$db->rollBackTransaction();
							$t = 3;
						}
					}
				}
				echo json_encode(array("status" => $t));
				break;
			case CARGAR_ESPECIAL:
				$info = $db->getRow("SELECT * FROM empresas_publicaciones_especiales WHERE id_empresa=".$_SESSION["ctc"]["id"]);
				if($info) {
					$info["imagen"] = $db->getOne("SELECT CONCAT(directorio,'/',nombre,'.',extension) FROM imagenes WHERE id=$info[id_imagen]");
					echo json_encode(array("msg" => "OK", "info" => $info));
				}
				else {
					echo json_encode(array("msg" => "ERROR"));
				}
				break;
			case VALIDAR_PUB:
				$info = $db->getRow("SELECT id_plan FROM empresas_planes WHERE id_empresa = ".$_SESSION['ctc']['id']);
				if ($info['id_plan'] != 1){
					echo json_encode(array("msg" => "OK"));
				} else {
					$pub = $db->getRow("SELECT COUNT(*) AS pub FROM publicaciones WHERE id_empresa=".$_SESSION['ctc']['id']);

					if ($pub['pub'] >= 2){
						echo json_encode(array("msg" => "NO"));
					} else {
						echo json_encode(array("msg" => "OK"));
					}
				}
				break;
			case RENOVAR_PUB:
				$id = isset($_REQUEST["i"]) ? json_decode($_REQUEST["i"], true) : false;
				$db->beginTransaction();

				try{
					if($id) {
						$db->query("UPDATE publicaciones SET fecha_actualizacion='".date('Y-m-d H:i:s')."', estatus=1 WHERE id=".$id);
						$db->commitTransaction();
						echo json_encode(array(
							"msg" => "OK"
						));
					}
				}catch(Exception $e){
					$db->rollBackTransaction();
					echo json_encode(
						array(
							"msg" => "Ah ocurrido un error de comunicación con el servidor, por favor verifique su conexión a internet e intente de nuevo.",
							"console" => $e->getMessage()
						)
					);
				}
				break;
			case DETENER_RENAUDAR:
				$id = isset($_REQUEST["i"]) ? json_decode($_REQUEST["i"], true) : false;
				$db->beginTransaction();
				$estatus = $_REQUEST["valor"];

				/*echo "UPDATE publicaciones SET estatus=$estatus WHERE id=".$id;
				exit;*/

				try{
					if($id) {
						$db->query("UPDATE publicaciones SET estatus=$estatus WHERE id=".$id);
						$db->commitTransaction();
						echo json_encode(array(
							"msg" => "OK"
						));
					}
				}catch(Exception $e){
					$db->rollBackTransaction();
					echo json_encode(
						array(
							"msg" => "Ah ocurrido un error de comunicación con el servidor, por favor verifique su conexión a internet e intente de nuevo.",
							"console" => $e->getMessage()
						)
					);
				}
				break;

		}
	}
	function getExtension($str) {$i=strrpos($str,".");if(!$i){return"";}$l=strlen($str)-$i;$ext=substr($str,$i+1,$l);return $ext;}
?>
