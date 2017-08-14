<?php
	session_start();

	define('AGREGAR', 1);
	define('DETALLES', 2);
	define('MODIFICAR', 3);
	define('ELIMINAR', 4);
	define('CARGAR_TODAS', 5);
	define('OBTENER_POSTULADOS', 6);

	require_once('../classes/DatabasePDOInstance.function.php');
	require_once('../slug.function.php');

	$db = DatabasePDOInstance();

	$op = isset($_REQUEST["op"]) ? $_REQUEST["op"] : false;

	$id_t = $_SESSION["ctc"]["id"];

	if($op) {
		switch($op) {
			case AGREGAR:
				$info = isset($_REQUEST["info"]) ? json_decode($_REQUEST["info"], true) : false;
				if($info) {
					$id = $db->getOne("
						SELECT
							AUTO_INCREMENT
						FROM
							INFORMATION_SCHEMA.TABLES
						WHERE
							TABLE_SCHEMA = 'db678638694'
						AND TABLE_NAME = 'trabajadores_publicaciones'
					");
					
					$db->query("
						INSERT INTO trabajadores_publicaciones (
							id,
							id_trabajador,
							titulo,
							descripcion,
							amigable,
							fecha_creacion,
							fecha_actualizacion
						)
						VALUES
						(
							'$id',
							'$id_t',
							'$info[titulo]',
							'$info[descripcion]',
							'" . slug($info["titulo"]) . "',
							'" . date('Y-m-d H:i:s') . "',
							'" . date('Y-m-d H:i:s') . "'
						)
					");
					
					$db->query("
						INSERT INTO trabajadores_areas_sectores (
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
							trabajadores_publicaciones
						WHERE
							id = $id
					");
					
					echo json_encode(array(
						"msg" => "OK",
						"data" => array(
							"publicacion" => $publicacion
						)
					));
				}
				break;
			case MODIFICAR:
				$id = isset($_REQUEST["i"]) ? json_decode($_REQUEST["i"], true) : false;
				$info = isset($_REQUEST["info"]) ? json_decode($_REQUEST["info"], true) : false;
				if($id && $info) {
					
					$db->query("
						UPDATE trabajadores_publicaciones
						SET 
						titulo = '$info[titulo]',
						descripcion = '$info[descripcion]',
						amigable = '" . slug($info["titulo"]) . "',
						 fecha_actualizacion = '" . date('Y-m-d H:i:s') . "'
						WHERE
							id = $id
					");
					
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
							trabajadores_publicaciones
						WHERE
							id = $id
					");
					
					echo json_encode(array(
						"msg" => "OK",
						"data" => array(
							"publicacion" => $publicacion
						)
					));
				}
				break;
			case ELIMINAR:
				$id = isset($_REQUEST["i"]) ? json_decode($_REQUEST["i"], true) : false;
				if($id) {
					$db->query("
						DELETE
						FROM
							trabajadores_publicaciones
						WHERE
							id = $id
					");
					$db->query("
						DELETE
						FROM
							trabajadores_areas_sectores
						WHERE
							id_publicacion = $id
					");
					echo json_encode(array(
						"msg" => "OK"
					));
				}
				break;
			case CARGAR_TODAS:
				$publicaciones = array();
				$publicaciones["data"] = array();
				
				$datos = $db->getAll("
					SELECT
						*
					FROM
						trabajadores_publicaciones
					WHERE
						id_trabajador = ".$_SESSION["ctc"]["id"]
				);
				
				/*$datos = $db->getAll("
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
				");*/

				if($datos) {
					$datos = array_reverse($datos);					
					foreach($datos as $k => $pub) {
						$publicaciones["data"][] = array(
							$k + 1,
							$pub["titulo"],
							$pub["descripcion"],
							$pub["descripcion"],
							'<div class="acciones-publicacion" data-target="' . $pub["id"] . '"> <button type="button" class="accion-publicacion btn btn-primary waves-effect waves-light" onclick="modificarPublicacion(this);" title="Modificar publicación"><span class="ti-pencil"></span></button> <button type="button" class="accion-publicacion btn btn-danger waves-effect waves-light" title="Eliminar publicación" onclick="eliminarPublicacion(this);"><span class="ti-close"></span></button> </div>',
						);
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
							trabajadores_publicaciones AS p
						LEFT JOIN trabajadores_areas_sectores AS ps ON p.id = ps.id_publicacion
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
				$postulados = array();
					
				$datos = $db->getAll("
					SELECT
						tra.id AS trabajador_id,
						tra.nombres AS trabajador_nombres,
						tra.apellidos AS trabajador_apellidos,
						a.amigable AS area_amigable,
						ase.amigable AS sector_amigable,
						p.amigable AS publicacion_amigable,
						pos.fecha_hora
					FROM
						postulaciones AS pos
					INNER JOIN trabajadores AS tra ON pos.id_trabajador = tra.id
					INNER JOIN publicaciones AS p ON pos.id_publicacion = p.id
					INNER JOIN publicaciones_sectores AS ps ON p.id = ps.id_publicacion
					INNER JOIN areas_sectores AS ase ON ps.id_sector = ase.id
					INNER JOIN areas AS a ON ase.id_area = a.id
					WHERE p.id = $id
				");

				if($datos) {
					foreach($datos as $k => $fila) {
						$fila["fecha_hora_formateada"] = date('d/m/Y h:i:s A', strtotime($fila["fecha_hora"]));
						$postulados[] = array(
							$k + 1,
							'<a href="../trabajador-detalle.php?t=' . $fila["trabajador_id"] . '" target="_blank">' . "$fila[trabajador_nombres] $fila[trabajador_apellidos]" . '</a>',
							"$fila[fecha_hora_formateada]",
							'<div class="acciones-publicacion" data-target="' . $fila["trabajador_id"] . '"> <a class="accion-publicacion btn btn-success waves-effect waves-light" href="contratar-trabajador.php?a=' . $fila["area_amigable"] . '&s=' . $fila["sector_amigable"] . '&p=' . $fila["publicacion_amigable"] . '&t=' . slug("$fila[trabajador_nombres] $fila[trabajador_apellidos]-$fila[trabajador_id]") . '" title="Contratar trabajador"><span class="ti-check"></span> Contratar</a> </div>',
						);
					}
				}

				echo json_encode(array(
					"data" => $postulados
				));
				break;
		}
	}
?>