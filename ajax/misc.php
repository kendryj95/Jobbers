<?php
	session_start();
	require_once('../classes/DatabasePDOInstance.function.php');
	$db = DatabasePDOInstance();
	
	$op = isset($_REQUEST["op"]) ? $_REQUEST["op"] : false;

	define('GET_SUBAREAS', 1);
	define('ADD_POSTULATE', 2);
	define('GET_POSTULATES', 3);

	switch($op) {
		case GET_SUBAREAS:
			$ida = isset($_REQUEST["ida"]) ? $_REQUEST["ida"] : false;
			if($ida) {
				$sectores = $db->getAll("
					SELECT
						areas_sectores.nombre,
						areas_sectores.amigable
					FROM
						areas
					INNER JOIN areas_sectores ON areas.id = areas_sectores.id_area
					WHERE
						areas.id = '$ida'
					OR areas.amigable = '$ida'
				");
				echo json_encode($sectores);
			}
		break;
		case ADD_POSTULATE:
			$idp = isset($_REQUEST["idp"]) ? $_REQUEST["idp"] : false;
			$idt = isset($_REQUEST["idt"]) ? $_REQUEST["idt"] : false;

			$db->beginTransaction();

			try{
				if($idp && $idt) {
					$db->query("
						INSERT INTO postulaciones (
							id_publicacion,
							id_trabajador,
							fecha_hora
						)
						VALUES (
							'$idp',
							'$idt',
							'" . date('Y-m-d H:i:s') . "'
						)
					");

					$db->commitTransaction();
					echo json_encode(
						array(
							"msg" => "OK"
						)
					);
				}
			} catch(Exception $e){
				$db->rollBackTransaction();
				echo json_encode(
					array(
						"msg" => "Ah ocurrido un error, intentelo más tarde.",
						"console" => $e->getMessage()
					)
				);
			}

			break;
		case GET_POSTULATES:
			$arr = array(
				"data" => array()
			);
			$idt = isset($_REQUEST["idt"]) ? $_REQUEST["idt"] : false;
			$data = $db->getAll("
				SELECT
					pub.titulo,
					pub.descripcion,
					pub.amigable,
					CONCAT(
						img.directorio,
						' ',
						img.nombre,
						img.extension
					) AS empresa_imagen,
					emp.id AS empresa_id,
					emp.nombre AS empresa_nombre,
					are.nombre AS area_nombre,
					are.amigable AS area_amigable,
					ase.nombre AS sector_nombre,
					ase.amigable AS sector_amigable,
					pub.amigable,
					pos.fecha_hora
				FROM
					postulaciones AS pos
				INNER JOIN publicaciones AS pub ON pos.id_publicacion = pub.id
				INNER JOIN publicaciones_sectores AS ps ON pub.id = ps.id_publicacion
				INNER JOIN areas_sectores AS ase ON ps.id_sector = ase.id
				INNER JOIN areas AS are ON ase.id_area = are.id
				INNER JOIN empresas AS emp ON pub.id_empresa = emp.id
				LEFT JOIN imagenes AS img ON emp.id_imagen = img.id
				WHERE pos.id_trabajador = $idt
			");
			
			if($data) {
				$ind = 0;
				foreach($data as $i => $row) {
					$arr["data"][] = array(
						$i + 1,
						'<span class="tag tag-primary text-uppercase" style="font-size: 12px;">Postulado</span>',
						'<a href="empresa/perfil.php?e='.(strtolower(str_replace(" ", "-", $row["empresa_nombre"])))."-$row[empresa_id]".'">'.$row["empresa_nombre"].'</a>',
						'<a href="empleos-detalle.php?a=' . $row["area_amigable"] . '&s=' . $row["sector_amigable"] . '&p=' . $row["amigable"] . '">' . $row["titulo"] . '</a>',
						date('d/m/Y h:i:s A', strtotime($row["fecha_hora"])),
					);
				}
			}
			echo json_encode($arr);
			break;
	}
	
?>