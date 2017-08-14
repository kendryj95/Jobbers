<?php
	session_start();

	define('CARGAR_TODAS', 1);
	define('CARGAR_DETALLE', 2);
	define('ACTION', 3);

	require_once('../../classes/DatabasePDOInstance.function.php');
	require_once('../../slug.function.php');

	$db = DatabasePDOInstance();

	$op = isset($_REQUEST["op"]) ? $_REQUEST["op"] : false;

	if($op) {
		switch($op) {
			case CARGAR_TODAS:
				$publicaciones = array();
				$publicaciones["data"] = array();
				
				$datos = $db->getAll("
					SELECT publicaciones.id, publicaciones.titulo, publicaciones.descripcion, CONCAT(trabajadores.nombres, ' ', trabajadores.apellidos) as trabajador, CONCAT(trabajadores.nombres,'-',trabajadores.apellidos,'-',trabajadores.id) AS link
					FROM publicaciones
					INNER JOIN empresas_contrataciones ON empresas_contrataciones.id_publicacion=publicaciones.id
					INNER JOIN trabajadores ON trabajadores.id=empresas_contrataciones.id_trabajador
					WHERE publicaciones.id_empresa = 
				".$_SESSION["ctc"]["id"]);

				if($datos) {
					$datos = array_reverse($datos);					
					foreach($datos as $k => $pub) {
						$pub["link_postulados"] = '<a class="text-primary" href="../trabajador-detalle.php?t='.$pub["link"].'" target="_blank"><span class="underline">'.$pub["trabajador"].'</span></a>';
						$publicaciones["data"][] = array(
							$k + 1,
							$pub["titulo"],
							$pub["descripcion"],
							$pub["link_postulados"],
							'<div class="acciones-publicacion"> <a class="accion-publicacion btn btn-success waves-effect waves-light" title="Previsualizar publicación" href="javascript:void(0)" onclick="verPublicacion(this);" data-target="' . $pub["id"] . '"><span class="ti-eye"></span></a>',
						);
					}
				}
				
				echo json_encode($publicaciones);
				break;
			case CARGAR_DETALLE:
				$info = $db->getRow("
					SELECT publicaciones.*, empresas_contrataciones.*, CONCAT(trabajadores.nombres, ' ', trabajadores.apellidos) as trabajador, CONCAT(trabajadores.nombres,'-',trabajadores.apellidos,'-',trabajadores.id) AS link
					FROM publicaciones
					INNER JOIN empresas_contrataciones ON empresas_contrataciones.id_publicacion=publicaciones.id
					INNER JOIN trabajadores ON trabajadores.id=empresas_contrataciones.id_trabajador
					WHERE publicaciones.id=$_REQUEST[i]
				");
				$info["fecha_finalizado"] = $info["fecha_finalizado"] != "" ? date('d/m/Y', strtotime($info["fecha_finalizado"])) : '';
				echo json_encode($info);
				break;
			case ACTION:
				if(isset($_REQUEST["r"])) {
					$id_trabajador = $db->getOne("SELECT id_trabajador FROM empresas_contrataciones WHERE id=$_REQUEST[i]");
					$calificacion_actual = $db->getOne("SELECT calificacion_general FROM trabajadores WHERE id=$id_trabajador");
					$total = (floatval($calificacion_actual) + floatval($_REQUEST["r"])) / 2;
					$db->query("UPDATE empresas_contrataciones SET finalizado=1, calificacion=$_REQUEST[r], comentario='$_REQUEST[c]', fecha_finalizado='".date('Y-m-d')."' WHERE id=$_REQUEST[i]");
					$db->query("UPDATE trabajadores SET calificacion_general=$total WHERE id=$id_trabajador");
				}
				else {
					$db->query("UPDATE empresas_contrataciones SET cancelado=1, fecha_finalizado='".date('Y-m-d')."' WHERE id=$_REQUEST[i]");
				}
				echo json_encode(array("status" => 1));
				break;
		}
	}
?>