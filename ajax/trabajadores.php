<?php
	session_start();
	require_once('../classes/DatabasePDOInstance.function.php');
	require_once('../slug.function.php');
	$db = DatabasePDOInstance();
	
	$op = isset($_REQUEST["op"]) ? $_REQUEST["op"] : false;
	define('CARGAR_MAS', 1);

	switch ($op) {
		case CARGAR_MAS:
			$result = $db->getAll("
			SELECT
				tra.id,
				tra.fecha_nacimiento, TIMESTAMPDIFF(YEAR, tra.fecha_nacimiento, CURDATE()) AS edad,
                tra.nombres,
				tra.apellidos,
				CONCAT(
					img.directorio,
					'/',
					img.nombre,
					'.',
					img.extension
				) AS imagen,
				tra.calificacion_general,
				pais.nombre AS pais,
				ie.sobre_mi,
				ie.remuneracion_pret
			FROM
				trabajadores AS tra
			LEFT JOIN imagenes AS img ON tra.id_imagen = img.id
			INNER JOIN paises pais ON tra.id_pais = pais.id
			INNER JOIN trabajadores_infextra ie ON tra.id = ie.id_trabajador
			ORDER BY tra.id DESC
			LIMIT $_REQUEST[limit_ini],5
		");

			$data['trabajador'] = array();

			foreach ($result as $val) {
				$imagen = $val["imagen"] == "" ? "avatars/user.png" : $val["imagen"];
				$data['trabajador'][] = '<div class="col-md-12"> <a href="trabajador-detalle.php?t="> <div class="tra box box-block bg-white user-5"> <div class="u-content"> <div class="row"> <div class="col-xs-12 col-md-3  text-center"> <div class="avatar box-96 m-b-2" style="margin-right: 11px;"> <img class="b-a-radius-circle" src="img/'. $imagen .'" alt="" style="max-height: 90px;height: 100%;"> </div> </div> <div class="col-xs-12 col-md-6"> <h4> <span class="text-black pull-left">'. $val["nombres"] ." ". $val["apellidos"] .' </span></h4> <div class="row"> <div class="col-xs-12 col-md-12"> <div class="pull-left"> <b>&nbsp;&nbsp;'. $val["pais"] .'</b> </div> </div> </div> <div style="font-size: 28px;"></div> </div> <div class="col-xs-12 col-md-3"> <button class="btn btn-info" style="margin-bottom: 10px">Ver Perfil</button> <div class="col-xs-12 col-md-12"> <div class="pull-left"> <span style="font-size: 12px">Remuneración Pretendida:</span> <h3>$ '. $val["remuneracion_pret"] .'</h3> </div> </div> </div> <div class="col-xs-12 col-md-12"> <p style="text-align: justify;">'. $val["sobre_mi"] .'</p> </div> </div> </div> </div> </a> </div>';
			}

			echo json_encode($data);

		break;
	}
	
?>