<?php
	session_start();
	require_once('classes/DatabasePDOInstance.function.php');
	require_once('slug.function.php');

	$db = DatabasePDOInstance();

	$busquedaAvanzada = (isset($_REQUEST["accion"]) && $_REQUEST["accion"] == "busqueda") ? true : false;
	$palabrasClave = isset($_REQUEST["busqueda"]) ? $_REQUEST["busqueda"] : false;

	$filtroArea = isset($_REQUEST["area"]) ? $_REQUEST["area"] : false;
	$filtroSector = isset($_REQUEST["sector"]) ? $_REQUEST["sector"] : false;
	$filtroMomento = isset($_REQUEST["momento"]) ? $_REQUEST["momento"] : false;
	$filtroDisp = isset($_REQUEST["disp"]) ? $_REQUEST["disp"] : false;

	$busqueda = isset($_REQUEST["busqueda"]) ? $_REQUEST["busqueda"] : false;

	$filtroActivado = $filtroArea || $filtroMomento || $filtroDisp;

	$cantidadRegistros = 0;

	if($filtroActivado || ($busqueda || $busquedaAvanzada)) {
		$pagina = isset($_REQUEST["pagina"]) ? $_REQUEST["pagina"] : 1;
		//TODO: Avisarle a Kendry cambie valor por 6
		$final = 6;
		$inicial = $final * ($pagina - 1);
	}

	function crearURL($parametros = array()) {
		$url = "empleos.php";
		$cant = count($parametros);
		if($cant > 0) {
			$primerParametro = $parametros[0];
			if($primerParametro["valor"] != "") {
				$url .= "?$primerParametro[clave]=$primerParametro[valor]";
			}
			for($i = 1; $i < $cant; $i++) {
				$parametro = $parametros[$i];
				if($parametro["valor"] != "") {
					$url .= (htmlentities("&") . "$parametro[clave]=$parametro[valor]");
				}
			}
		}
		return $url;
	}

	function formatDate($dateMayor, $dateMenor){
		$menor = new DateTime($dateMenor);
		$mayor = new DateTime(date($dateMayor));
		$intervalo = $mayor->diff($menor);

		if ($intervalo->format("%m") != 0) {
			$m = $intervalo->format("%m") == 1 ? "mes" : "meses";
			return $intervalo->format("Hace %m $m");
		} elseif ($intervalo->format("%a") != 0){
			$d = $intervalo->format("%a") == 1 ? "día" : "días";
			return $intervalo->format("Hace %a $d");
		} elseif ($intervalo->format("%h") != 0){
			$h = $intervalo->format("%h") == 1 ? "hora" : "horas";
			return $intervalo->format("Hace %h $h");
		} elseif ($intervalo->format("%i") != 0){
			return $intervalo->format("Hace %i min");
		} else {
			return $intervalo->format("Hace %s seg");
		}
	}

	

	$infoArea = $db->getRow("
		SELECT
			id,
			nombre
		FROM
			areas
		WHERE
			amigable = '$filtroArea'
	");

	$momentos = array(
		array(
			"nombre" => "Últimas 24 horas",
			"amigable" => "ultimas-24-horas",
			"cantidad" => 0,
			"diff_s" => 86400
		),
		array(
			"nombre" => "Durante los últimos 3 días",
			"amigable" => "durante-los-ultimos-3-dias",
			"cantidad" => 0,
			"diff_s" => 259200
		),
		array(
			"nombre" => "Durante la última semana",
			"amigable" => "durante-la-ultima-semana",
			"cantidad" => 0,
			"diff_s" => 604800
		),
		array(
			"nombre" => "Durante las ultimas 2 semanas",
			"amigable" => "durante-las-ultimas-2-semanas",
			"cantidad" => 0,
			"diff_s" => 1209600
		),
		array(
			"nombre" => "Hace un mes o menos",
			"amigable" => "hace-un-mes-o-menos",
			"cantidad" => 0,
			"diff_s" => 2592000
		),
		array(
			"nombre" => "Hace dos meses o menos",
			"amigable" => "hace-dos-meses-o-menos",
			"cantidad" => 0,
			"diff_s" => 5184000
		)
	);

	$band = false;
	foreach($momentos as $i => $momento) {
		if($momento["amigable"] == $filtroMomento) {
			$infoMomento = $momento;
			$band = true;
		}
	}

	if($band === false) {
		$filtroMomento = false;
	}



	if($filtroDisp) {
		$disps = $db->getRow("
			SELECT
				id,
				nombre
			FROM
				disponibilidad
			WHERE
				nombre = '$filtroDisp'
		");
	}else {
		$disps = $db->getAll("
			SELECT
				id,
				nombre
			FROM
				disponibilidad
			ORDER BY
				nombre
		");

		if($filtroSector) {
			$infoSector = $db->getRow("
				SELECT
					id,
					nombre,
					amigable
				FROM
					areas_sectores
				WHERE
					amigable = '$filtroSector'
			");
		}

		foreach($disps as $i => $disp) {
			$disps[$i]["cantidad"] = $db->getOne("
				SELECT
					COUNT(*)
				FROM
					publicaciones AS p
					INNER JOIN publicaciones_sectores AS ps ON p.id = ps.id_publicacion
					INNER JOIN areas_sectores AS ase ON ps.id_sector = ase.id
					INNER JOIN areas AS a ON ase.id_area = a.id
					INNER JOIN empresas AS e ON p.id_empresa = e.id
					INNER JOIN empresas_planes AS plan ON plan.id_empresa = e.id
				WHERE
					p.disponibilidad = $disp[id]
					AND ".($filtroArea ? "a.id = $infoArea[id]" : " 1=1 ")
					.($filtroSector ? " AND ase.id = $infoSector[id]" : " "). 
					" AND ".($filtroMomento ? "  TIMESTAMPDIFF(SECOND,p.fecha_creacion,NOW()) <= $infoMomento[diff_s] " : " 1=1")."
					AND (e.suspendido IS NULL OR e.suspendido = 0) AND p.estatus=1
			");
		}
	}




	if($filtroArea) {
		$infoArea = $db->getRow("
			SELECT
				id,
				nombre
			FROM
				areas
			WHERE
				amigable = '$filtroArea'
		");
		if($filtroSector) {
			$infoSector = $db->getRow("
				SELECT
					id,
					nombre,
					amigable
				FROM
					areas_sectores
				WHERE
					amigable = '$filtroSector'
			");
		}else {
			$sectores = $db->getAll("
				SELECT
					id,
					nombre,
					amigable
				FROM
					areas_sectores
				WHERE
					id_area = $infoArea[id]
			");
			foreach($sectores as $i => $sector) {
				$sectores[$i]["cantidad"] = $db->getOne("
					SELECT
						COUNT(*)
					FROM
						publicaciones_sectores
					WHERE
						id_sector = $sector[id]
				");
			}
		}
	}else {		
		$areas = $db->getAll("
			SELECT
				id,
				nombre,
				amigable
			FROM
				areas

			ORDER BY
				nombre
		");

		foreach($areas as $i => $area) {
			$areas[$i]["cantidad"] = $db->getOne("
				SELECT
					COUNT(*)
				FROM
					publicaciones_sectores AS psec
				INNER JOIN publicaciones AS p ON psec.id_publicacion = p.id
				INNER JOIN areas_sectores AS asec ON psec.id_sector = asec.id
				WHERE
					asec.id_area = $area[id]
					AND ".($filtroMomento ? "  TIMESTAMPDIFF(SECOND,p.fecha_creacion,NOW()) <= $infoMomento[diff_s] " : " 1=1")."
					AND ".($filtroDisp ? "  p.disponibilidad= $disps[id] " : " 1=1") );
		}
	}

	if($busquedaAvanzada) {
		$query = "
			SELECT
				p.titulo,
				p.descripcion,
				p.fecha_actualizacion,
				CONCAT(img.directorio, '/', img.nombre, '.', img.extension) AS empresa_imagen,
				e.nombre AS empresa_nombre,
				e.sitio_web,
				e.facebook,
				e.twitter,
				e.instagram,
				e.linkedin,
				a.nombre AS area_nombre,
				a.amigable AS area_amigable,
				ase.nombre AS sector_nombre,
				ase.amigable AS sector_amigable,
				p.amigable,
				plan.logo_home
			FROM
				publicaciones AS p
			INNER JOIN publicaciones_sectores AS ps ON p.id = ps.id_publicacion
			INNER JOIN areas_sectores AS ase ON ps.id_sector = ase.id
			INNER JOIN areas AS a ON ase.id_area = a.id
			INNER JOIN empresas AS e ON p.id_empresa = e.id
			INNER JOIN empresas_planes AS plan ON plan.id_empresa = e.id
			LEFT JOIN imagenes AS img ON e.id_imagen = img.id
		";
		
		if($filtroArea) {
			$query .= "
				WHERE
					a.id = $infoArea[id]
			";
			if($filtroSector) {
				$query .= "AND ase.id = $infoSector[id]";
			}

			if($filtroMomento) {
				$query .= "
					AND TIMESTAMPDIFF(
						SECOND,
						p.fecha_creacion,
						NOW()
					) <= $infoMomento[diff_s]"
				;
			}

			$query .= " AND (e.suspendido IS NULL OR e.suspendido = 0) AND p.estatus=1";
		}
		else if($filtroMomento) {
			$query .= "
				AND TIMESTAMPDIFF(
					SECOND,
					p.fecha_creacion,
					NOW()
				) <= $infoMomento[diff_s] AND (e.suspendido IS NULL OR e.suspendido = 0) AND p.estatus=1"
			;
		}
		
		if($palabrasClave != "") {
			$tokens = explode(",", $palabrasClave);
			$l = count($tokens);
			if($l > 1) {
				$query .= " AND (p.titulo LIKE '%$tokens[0]%'";
				for($i = 1; $i < $l; $i++) {
					$query .= " OR p.titulo LIKE '%$tokens[$i]%'";
				}
				$query .= ")";
			}
			else {
				$query .= " AND p.titulo LIKE '%$tokens[0]%'";
			}
		}
		
		$cantidadRegistros = $db->getOne("SELECT COUNT(*) FROM ($query) AS T");
		
		$cantidadPaginas = ceil($cantidadRegistros / $final);
		
		$query .= " AND (e.suspendido IS NULL OR e.suspendido = 0) AND p.estatus=1 ORDER BY p.fecha_actualizacion DESC, plan.logo_home DESC LIMIT $inicial, $final";
		
		$publicaciones = $db->getAll($query);
	}elseif($filtroActivado) {
		$query = "
			SELECT
				p.titulo,
				p.descripcion,
				p.fecha_actualizacion,
				CONCAT(img.directorio, '/', img.nombre, '.', img.extension) AS empresa_imagen,
				e.nombre AS empresa_nombre,
				e.sitio_web,
				e.facebook,
				e.twitter,
				e.instagram,
				e.linkedin,
				a.nombre AS area_nombre,
				a.amigable AS area_amigable,
				ase.nombre AS sector_nombre,
				ase.amigable AS sector_amigable,
				p.amigable,
				plan.logo_home
			FROM
				publicaciones AS p
			INNER JOIN publicaciones_sectores AS ps ON p.id = ps.id_publicacion
			INNER JOIN areas_sectores AS ase ON ps.id_sector = ase.id
			INNER JOIN areas AS a ON ase.id_area = a.id
			INNER JOIN empresas AS e ON p.id_empresa = e.id
			INNER JOIN empresas_planes AS plan ON plan.id_empresa = e.id
			LEFT JOIN imagenes AS img ON e.id_imagen = img.id
			where (e.suspendido IS NULL OR e.suspendido = 0)
		";
		
		if($filtroArea) {
			$query .= " 
				AND a.id = $infoArea[id]
			";
			if($filtroSector) {
				$query .= "AND ase.id = $infoSector[id]";
			}

			/*if($filtroMomento) {
				$query .= "
					AND TIMESTAMPDIFF(
						SECOND,
						p.fecha_creacion,
						NOW()
					) <= $infoMomento[diff_s]"
				;
			}*/

			//$query .= " AND (e.suspendido IS NULL OR e.suspendido = 0) ";
		}

		if($filtroMomento) {
			$query .= "
				AND
				TIMESTAMPDIFF(SECOND,p.fecha_creacion,NOW()) <= $infoMomento[diff_s] 
				"
			;
		}

		if($filtroDisp) {
			$query .= "
				AND 
				p.disponibilidad =  $disps[id]
			";
		}		
		//file_put_contents('sql', $query);
		$cantidadRegistros = $db->getOne("
			SELECT
				COUNT(*)
			FROM
				publicaciones AS p
			INNER JOIN publicaciones_sectores AS ps ON p.id = ps.id_publicacion
			INNER JOIN areas_sectores AS ase ON ps.id_sector = ase.id
			INNER JOIN areas AS a ON ase.id_area = a.id
			INNER JOIN empresas AS e ON p.id_empresa = e.id
			where 1=1 " . ($filtroArea ? "and a.id = $infoArea[id]" : "") . ($filtroSector ? " AND ase.id = $infoSector[id] " : ""). ($filtroDisp ? " AND p.disponibilidad= $disps[id] " : "") . ($filtroMomento ? " AND TIMESTAMPDIFF( SECOND, p.fecha_creacion, NOW() ) <= $infoMomento[diff_s] " : "") . " AND (e.suspendido IS NULL OR e.suspendido = 0) AND p.estatus=1
		");
		
		$cantidadPaginas = ceil($cantidadRegistros / $final);
		
		$query .= " AND (e.suspendido IS NULL OR e.suspendido = 0) AND p.estatus=1 ORDER BY p.fecha_actualizacion DESC, plan.logo_home DESC LIMIT $inicial, $final";
		
		$publicaciones = $db->getAll($query);		
	}else if($busqueda) {
		$publicaciones = $db->getAll("
			SELECT
				p.titulo,
				p.descripcion,
				p.fecha_actualizacion,
				CONCAT(img.directorio, '/', img.nombre, '.', img.extension) AS empresa_imagen,
				e.nombre AS empresa_nombre,
				e.sitio_web,
				e.facebook,
				e.twitter,
				e.instagram,
				e.linkedin,
				a.amigable AS area_amigable,
				a.nombre AS area_nombre,
				ase.amigable AS sector_amigable,
				ase.nombre AS sector_nombre,
				p.amigable,
				plan.logo_home
			FROM
				publicaciones AS p
			INNER JOIN publicaciones_sectores AS ps ON p.id = ps.id_publicacion
			INNER JOIN areas_sectores AS ase ON ps.id_sector = ase.id
			INNER JOIN areas AS a ON ase.id_area = a.id
			INNER JOIN empresas AS e ON p.id_empresa = e.id
			LEFT JOIN imagenes AS img ON e.id_imagen = img.id
			INNER JOIN empresas_planes AS plan ON plan.id_empresa = e.id
			WHERE p.titulo LIKE '%$busqueda%'  AND (e.suspendido IS NULL OR e.suspendido = 0) AND p.estatus=1
			ORDER by p.fecha_actualizacion DESC, plan.logo_home DESC
			LIMIT $inicial, $final
		");
		$cantidadRegistros = $db->getOne("
			SELECT
				COUNT(*)
			FROM
				publicaciones AS p
			INNER JOIN publicaciones_sectores AS ps ON p.id = ps.id_publicacion
			INNER JOIN areas_sectores AS ase ON ps.id_sector = ase.id
			INNER JOIN areas AS a ON ase.id_area = a.id
			INNER JOIN empresas AS e ON p.id_empresa = e.id
			WHERE p.titulo LIKE '%$busqueda%' AND (e.suspendido IS NULL OR e.suspendido = 0) AND p.estatus=1
		");
		
		$cantidadPaginas = ceil($cantidadRegistros / $final);
	}else {
		$publicaciones = $db->getAll("
			SELECT
				p.titulo,
				p.descripcion,
				p.fecha_actualizacion,
				CONCAT(img.directorio, '/', img.nombre, '.', img.extension) AS empresa_imagen,
				e.nombre AS empresa_nombre,
				e.sitio_web,
				e.facebook,
				e.twitter,
				e.instagram,
				e.linkedin,
				a.nombre AS area_nombre,
				a.amigable AS area_amigable,
				ase.nombre AS sector_nombre,
				ase.amigable AS sector_amigable,
				p.amigable
			FROM
				publicaciones AS p
			INNER JOIN publicaciones_sectores AS ps ON p.id = ps.id_publicacion
			INNER JOIN areas_sectores AS ase ON ps.id_sector = ase.id
			INNER JOIN areas AS a ON ase.id_area = a.id
			INNER JOIN empresas AS e ON p.id_empresa = e.id
			INNER JOIN empresas_planes AS ep ON p.id_empresa = ep.id_empresa
			LEFT JOIN imagenes AS img ON e.id_imagen = img.id
			WHERE ep.logo_home=1 AND (e.suspendido IS NULL OR e.suspendido = 0) AND p.estatus=1
			ORDER BY p.fecha_actualizacion DESC
		");
		
		$publicacionesOro = $db->getAll("
			SELECT
				p.titulo,
				p.descripcion,
				p.fecha_actualizacion,
				e.nombre AS empresa_nombre,
				e.sitio_web,
				e.facebook,
				e.twitter,
				e.instagram,
				e.linkedin,
				a.amigable AS area_amigable,
				a.nombre AS area_nombre,
				ase.amigable AS sector_amigable,
				ase.nombre AS sector_nombre,
				p.amigable,
				CONCAT(
					img.directorio,
					'/',
					img.nombre,
					'.',
					img.extension
				) AS imagen
			FROM
				publicaciones AS p
			INNER JOIN publicaciones_sectores AS ps ON p.id = ps.id_publicacion
			INNER JOIN areas_sectores AS ase ON ps.id_sector = ase.id
			INNER JOIN areas AS a ON ase.id_area = a.id
			INNER JOIN empresas AS e ON p.id_empresa = e.id
			INNER JOIN empresas_planes AS ep ON p.id_empresa = ep.id_empresa
			LEFT JOIN imagenes AS img ON img.id=e.id_imagen
			WHERE ep.logo_home=3 AND (e.suspendido IS NULL OR e.suspendido = 0) AND p.estatus=1
			ORDER BY p.fecha_actualizacion DESC
		");
		
		$publicacionesPlata = $db->getAll("
			SELECT
				p.titulo,
				p.descripcion,
				p.fecha_actualizacion,
				e.nombre AS empresa_nombre,
				e.sitio_web,
				e.facebook,
				e.twitter,
				e.instagram,
				e.linkedin,
				a.amigable AS area_amigable,
				a.nombre AS area_nombre,
				ase.amigable AS sector_amigable,
				ase.nombre AS sector_nombre,
				p.amigable,
				CONCAT(
					img.directorio,
					'/',
					img.nombre,
					'.',
					img.extension
				) AS imagen
			FROM
				publicaciones AS p
			INNER JOIN publicaciones_sectores AS ps ON p.id = ps.id_publicacion
			INNER JOIN areas_sectores AS ase ON ps.id_sector = ase.id
			INNER JOIN areas AS a ON ase.id_area = a.id
			INNER JOIN empresas AS e ON p.id_empresa = e.id
			INNER JOIN empresas_planes AS ep ON p.id_empresa = ep.id_empresa
			LEFT JOIN imagenes AS img ON img.id=e.id_imagen
			WHERE ep.logo_home=2 AND (e.suspendido IS NULL OR e.suspendido = 0) AND p.estatus=1
			ORDER BY p.fecha_actualizacion DESC
		");
	}

	if(!$filtroMomento && !$filtroDisp) {
		$band = false;
		foreach($momentos as $i => $momento) {
			if($filtroActivado) {
				$query = "
					SELECT
						COUNT(*)
					FROM
						(
							SELECT
								TIMESTAMPDIFF(SECOND,p.fecha_creacion,NOW()) AS s
							FROM
								publicaciones AS p
							INNER JOIN publicaciones_sectores AS ps ON p.id = ps.id_publicacion
							INNER JOIN areas_sectores AS ase ON ps.id_sector = ase.id
							INNER JOIN areas AS a ON ase.id_area = a.id
							INNER JOIN empresas AS e ON p.id_empresa = e.id
							WHERE
								".($filtroArea ? "a.id = $infoArea[id]" : " 1=1 ")
								 .($filtroSector ? " AND ase.id = $infoSector[id]" : " "). 
								" AND ".($filtroDisp ? "  p.disponibilidad= $disps[id] " : " 1=1")."
								AND (e.suspendido IS NULL OR e.suspendido = 0) AND p.estatus=1
						) AS r
					WHERE
						r.s <= $momento[diff_s] 
				";
			}else {
				$query = "
					SELECT
						COUNT(*)
					FROM
						(SELECT TIMESTAMPDIFF(SECOND,fecha_creacion,NOW()) AS s FROM publicaciones AS p ) AS r
					WHERE
						r.s <= $momento[diff_s]
				";
			}
			$momentos[$i]["cantidad"] = $db->getOne($query);
		}
	}

?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<meta name="description" content="">
		<meta name="author" content="">

		<!-- Title -->
		<title>JOBBERS - Ofertas de empleo</title>
		<?php require_once('includes/libs-css.php'); ?>
		
		<style>
			.pub {
				min-height: 150px;
				margin-bottom: 30px;
				height: 225px;
			}
			.pub-f {
				min-height: 110px;
			}
			.pub, .pub-f {
				/* background-color: #f8f8f8 !important; */
				-webkit-transition: all 0.2s ease-in-out;
				transition: all 0.2s ease-in-out;
				cursor: pointer;
			}			
			.pub:hover, .pub-f:hover {
				background-color: #3e70c9 !important;
			}
			.pub:hover *, .pub-f:hover * {
				color: #fff !important;
			}
			.pub .avatar {
				max-height: 140px;
				height: 120px;
				width: 100%;
				max-width: 140px;
				margin: 0 auto;
			}
		</style>

		<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
		<script>
		  (adsbygoogle = window.adsbygoogle || []).push({
		    google_ad_client: "ca-pub-1968505410020323",
		    enable_page_level_ads: true
		  });
		</script>
	</head>
	<body class="large-sidebar fixed-sidebar fixed-header skin-5">
		<!-- <div class="wrapper"> -->
		<!-- Sidebar -->
		<?php if (isset($_SESSION['ctc'])): ?>
    		<?php if ($_SESSION['ctc']['type'] == 1):
			require_once ('includes/sidebar.php');
			?>
			<style>
				.site-content{
					margin-left:220px !important;
				}
				@media(max-width: 1024px){
					.site-content{
						margin-left: 0px !important;
					}
				}
			</style>
			<?php endif ?>
		<?php endif; ?>	

		<!-- Sidebar second -->
		<?php require_once('includes/sidebar-second.php'); ?>

		<!-- Header -->
		<?php require_once('includes/header.php'); ?>
			<div class="site-content bg-white" style="margin-left: 0px;">
				<!-- Content -->
				<div class="content-area p-y-1">
					<div class="container-fluid">
						<div class="col-md-6">				
							<?php if($filtroActivado): ?>
								<h4>Ofertas de empleo</h4>
								<ol class="breadcrumb no-bg m-b-1">
									<li class="breadcrumb-item"><a href="./">JOBBERS</a></li>
									<?php if($filtroArea && $filtroMomento): ?>
										<?php if($filtroSector): ?>
											<li class="breadcrumb-item"><a href="<?php echo "empleos.php?area=$filtroArea&pagina=1"; ?>"><?php echo $infoArea["nombre"]; ?></a></li>
											<li class="breadcrumb-item active"><a href="<?php echo "empleos.php?area=$filtroArea&sector=$filtroSector&pagina=1"; ?>"><?php echo $infoSector["nombre"]; ?></a></li>
											<li class="breadcrumb-item"><?php echo $infoMomento["nombre"]; ?></li>
										<?php else: ?>								
											<li class="breadcrumb-item"><a href="<?php echo "empleos.php?area=$filtroArea&pagina=1"; ?>"><?php echo $infoArea["nombre"]; ?></a></li>
											<li class="breadcrumb-item active"><?php echo $infoMomento["nombre"]; ?></li>
										<?php endif ?>
									<?php elseif($filtroArea && !$filtroMomento): ?>
										<?php if($filtroSector): ?>
											<li class="breadcrumb-item"><a href="<?php echo "empleos.php?area=$filtroArea&pagina=1"; ?>"><?php echo $infoArea["nombre"]; ?></a></li>
											<li class="breadcrumb-item active"><?php echo $infoSector["nombre"]; ?></li>
										<?php else: ?>
											<li class="breadcrumb-item active"><?php echo $infoArea["nombre"]; ?></li>
										<?php endif ?>
									<?php elseif(!$filtroArea && $filtroMomento): ?>
										<li class="breadcrumb-item active"><?php echo $infoMomento["nombre"]; ?></li>
									
									<?php elseif(!$filtroArea && !$filtroMomento && $filtroDisp): ?>

										<li class="breadcrumb-item active"><?php echo $disps["nombre"]; ?></li>
									<?php endif ?>
								</ol>
							<?php else: ?>
								<br>
							<?php endif ?>					
						</div>
						<?php if($cantidadRegistros > 0): ?>
							<?php if($filtroActivado): ?>
								<div class="col-md-6 text-xs-right">
									<h6 class="m-t-1">
										<?php 
											if ($filtroArea) {
												echo $infoArea["nombre"]; 
												if ($filtroSector) {
													echo " - " . $infoSector['nombre'];
												}
											}elseif ($filtroMomento) {
												echo $infoMomento["nombre"];
											} else {
												echo $disps["nombre"];
											}
										?>
									</h6>
									<h6>Ofertas: <?php echo ($inicial + 1); ?> - <?php echo ($final * $pagina) > $cantidadRegistros ? $cantidadRegistros : ($final * $pagina); ?> de <?php echo $cantidadRegistros; ?></h6>
								</div>
							<?php elseif($busqueda): ?>
								<div class="col-md-6 text-xs-right">
									<h6 class="m-t-1">Resultados de búsqueda para <strong><?php echo $busqueda; ?></strong></h6>
									<h6>Ofertas: <?php echo ($inicial + 1); ?> - <?php echo ($final * $pagina) > $cantidadRegistros ? $cantidadRegistros : ($final * $pagina); ?> de <?php echo $cantidadRegistros; ?></h6>
								</div>
							<?php endif ?>
						<?php endif ?>
					</div>

					<div class="container-fluid">

						<div class="col-md-3">
							<div class="box bg-white">
								<div class="box-block clearfix">
									<h5 class="pull-xs-left">Ofertas de empleo por área</h5>
								</div>
								<table class="table m-md-b-0">
									<tbody>
										<?php if($filtroArea): ?>
											<tr>
												<td>
													<a class="text-primary" href="empleos.php?area=<?php echo $filtroArea . ($filtroSector ? "&sector=$filtroSector" : "") . ($filtroMomento ? "&momento=$filtroMomento" : "") . ($filtroMomento ? "&pagina=1" : ""); ?>"><?php echo $infoArea["nombre"]; ?></a>
												</td>
												<td>
													<?php if(!$busquedaAvanzada || $palabrasClave == ""): ?>
														<span class="text-muted pull-xs-right" title="Remover filtro"><a href="empleos.php<?php echo ($filtroMomento ? "?momento=$filtroMomento" : "") . ($filtroMomento ? "&pagina=1" : ""); ?>"><i class="ion-close text-danger"></i></a></span>
													<?php endif ?>
												</td>
											</tr>
										<?php else: ?>
											<?php foreach($areas as $area): ?>
												<?php if($area["cantidad"] > 0): ?>
													<tr>
														<td>
															<a class="text-primary" href="empleos.php?area=<?php echo $area["amigable"] . ($filtroMomento ? "&momento=$filtroMomento" : ""); ?>&pagina=1"><span class="underline"><?php echo $area["nombre"]; ?></span></a>
														</td>
														<td>
															<span class="text-muted pull-xs-right"><?php echo $area["cantidad"]; ?></span>
														</td>
													</tr>
												<?php endif ?>
											<?php endforeach ?>
										<?php endif ?>
									</tbody>
								</table>
							</div>

							<?php if($filtroArea): ?>
								<div class="box bg-white">
									<div class="box-block clearfix">
										<h5 class="pull-xs-left"><i class="ion-ios-list m-sm-r-1"></i> Sectores</h5>
									</div>

									<?php if($filtroSector): ?>						
										<table class="table m-md-b-0">
											<tbody>
												<tr>
													<td>
														<a class="text-primary" href="empleos.php?area=<?php echo $filtroArea . "&sector=$filtroSector" . ($filtroMomento ? "&momento=$filtroMomento" : ""); ?>&pagina=1"><?php echo $infoSector["nombre"]; ?><span class="underline"></span></a>
													</td>
													<td>
														<?php if(!$busquedaAvanzada || $palabrasClave == ""): ?>
															<span class="text-muted pull-xs-right" title="Remover filtro"><a href="empleos.php?area=<?php echo $filtroArea . ($filtroMomento ? "&momento=$filtroMomento" : ""); ?>&pagina=1"><i class="ion-close text-danger"></i></a></span>
														<?php endif ?>
													</td>
												</tr>
											</tbody>
										</table>
									<?php elseif($filtroArea): ?>
										<table class="table m-md-b-0">
											<tbody>
												<?php foreach($sectores as $sector): ?>
													<?php if($sector["cantidad"] > 0): ?>
														<tr>
															<td>
																<a class="text-primary" href="empleos.php?area=<?php echo $filtroArea . "&sector=$sector[amigable]" . ($filtroMomento ? "&momento=$filtroMomento" : ""); ?>&pagina=1"><?php echo $sector["nombre"]; ?><span class="underline"></span></a>
															</td>
															<td>
																<span class="text-muted pull-xs-right"><?php echo $sector["cantidad"]; ?></span>
															</td>
														</tr>	
													<?php endif ?>	
												<?php endforeach ?>
											</tbody>
										</table>
									<?php endif ?>
								</div>
							<?php endif ?>
							<?php if(!$filtroMomento): ?>
								<div class="box bg-white">
									<div class="box-block clearfix">
										<h5 class="pull-xs-left"><i class="ion-calendar m-sm-r-1"></i> Fecha de publicación</h5>
									</div>
									<table class="table m-md-b-0">
										<tbody>
											<?php
												$url = "empleos.php";
												if($filtroArea) {
													$url .= "?area=$filtroArea";
													if($filtroSector) {
														$url .= "&sector=$filtroSector";
													}
												}
											?>							
											<?php if($filtroMomento): ?>
												<tr>
													<td>
														<a class="text-primary" href="<?php echo ($url == 'empleos.php' ? "?momento=$filtroMomento" : "$url&momento=$filtroMomento&pagina=1"); ?>"><?php echo $infoMomento["nombre"]; ?><span class="underline"></span></a>
													</td>
													<td>
														<?php if(!$busquedaAvanzada || $palabrasClave == ""): ?>
															<span class="text-muted pull-xs-right" title="Remover filtro"><a href="<?php echo $url; ?>"><i class="ion-close text-danger"></i></a></span>
														<?php endif ?>
													</td>
												</tr>
											<?php else: ?>
												<?php foreach($momentos as $momento): ?>
													<?php if($momento["cantidad"] > 0): ?>
														<tr>
															<td>
																<a class="text-primary" href="<?php echo ($url == 'empleos.php' ? "?momento=$momento[amigable]" : "$url&momento=$momento[amigable]"); ?>&pagina=1"><?php echo $momento["nombre"]; ?></a>
															</td>
															<td>
																<span class="text-muted pull-xs-right"><?php echo $momento["cantidad"]; ?></span>
															</td>
														</tr>
													<?php endif ?>
												<?php endforeach ?>									
											<?php endif ?>							
										</tbody>
									</table>
								</div>
							<?php endif ?>
							<?php if(!$filtroDisp): ?>
								<div class="box bg-white">
									<div class="box-block clearfix">
										<h5 class="pull-xs-left"><i class="ion-calendar m-sm-r-1"></i> Disponibilidad</h5>
									</div>
									<table class="table m-md-b-0">
										<tbody>
											<?php
												$url = "empleos.php";
												if($filtroArea) {
													$url .= "?area=$filtroArea";
													if($filtroSector) {
														$url .= "&sector=$filtroSector";
													}
												}
											?>							
											<?php foreach($disps as $disp): ?>
												<?php if($disp["cantidad"] > 0): ?>
													<tr>
														<td>
															<a class="text-primary" href="<?php echo ($url == 'empleos.php' ? "?disp=$disp[nombre]" : "$url&disp=$disp[nombre]"); ?>&pagina=1"><?php echo $disp["nombre"]; ?></a>
														</td>
														<td>
															<span class="text-muted pull-xs-right"><?php echo $disp["cantidad"]; ?></span>
														</td>
													</tr>
												<?php endif ?>
											<?php endforeach ?>									
										</tbody>
									</table>
								</div>
							<?php endif ?>							
						</div>

						<div class="col-md-9">

							<?php if($filtroActivado || $busqueda): ?>
								<?php if($cantidadRegistros > 0): ?>
									<?php foreach($publicaciones as $publicacion): ?>
										<?php if($publicacion["logo_home"] == 3): ?>
											<div class="col-md-6">
												<a href="empleos-detalle.php?a=<?php echo $publicacion["area_amigable"]; ?>&s=<?php echo $publicacion["sector_amigable"]; ?>&p=<?php echo $publicacion["amigable"]; ?>">
													<div class="pub pub-f box box-block tile tile-1 gold" title="Ver detalles del empleo">
														<div class="t-icon right"><span class="bg-warning"></span><i class="ti-medall-alt" title="Publicación destacada" style="z-index: 50;"></i></div>
														<div class="t-content"  title="Ver detalles del empleo">
															<div class="row">
																<div class="col-md-4 col-sm-4 text-center">
																	<img class="img-fluid b-a-radius-circle avatar" src="empresa/img/<?php echo $publicacion["empresa_imagen"] ? $publicacion["empresa_imagen"] : 'avatars/user.png'; ?>" alt="">
																</div>
																<div class="col-md-8 col-sm-8">
																	<h5 style="color: #373a3c;"><?php echo $publicacion["empresa_nombre"]; ?> <small><?= formatDate(date("Y-m-d H:i:s"), $publicacion["fecha_actualizacion"]) ?></small></h5>
																	<h6 style="color: #373a3c; font-weight: 600;"><?php echo $publicacion["titulo"]; ?> <span class="text-muted pull-xs-right"><?php echo $publicacion["sector_nombre"]; ?></span></h6>
																	<?php if($publicacion["sitio_web"] != "" || $publicacion["facebook"] != "" || $publicacion["twitter"] != "" || $publicacion["instagram"] != "" || $publicacion["linkedin"] != ""): ?>
																		<?php
																			$sitio_web = "";
																			$facebook = "";
																			$twitter = "";
																			$instagram = "";
																			$linkedin = "";
																			if (strstr($publicacion["sitio_web"], 'http')) {
																				$sitio_web = $publicacion["sitio_web"];
																			}
																			else {
																				$sitio_web = "http://$publicacion[sitio_web]";
																			}
																			if (strstr($publicacion["facebook"], 'http')) {
																				$facebook = $publicacion["facebook"];
																			}
																			else {
																				$facebook = "http://$publicacion[facebook]";
																			}
																			if (strstr($publicacion["twitter"], 'http')) {
																				$twitter = $publicacion["twitter"];
																			}
																			else {
																				$twitter = "http://$publicacion[twitter]";
																			}
																			if (strstr($publicacion["instagram"], 'http')) {
																				$instagram = $publicacion["instagram"];
																			}
																			else {
																				$instagram = "http://$publicacion[instagram]";
																			}
																			if (strstr($publicacion["linkedin"], 'http')) {
																				$linkedin = $publicacion["linkedin"];
																			}
																			else {
																				$linkedin = "http://$publicacion[linkedin]";
																			}
																		?>
																		<div style="background-color: transparent;">
																			<div class="row no-gutter">
																				<!-- <div class="col-xs-3 s-item">
																					<a class="bg-white" href="" style="background-color:  transparent !important;"></a>
																				</div> -->
																				<div class="btn-group btn-group-lg" role="group" aria-label="Large b utton group">
																					<?php if($publicacion["facebook"] != ""): ?>
																						<!-- <div class="col-xs-3 s-item"> -->
																							<a class="bg-primary btn btn-default" href="<?php echo $sitio_web; ?>" title="Ir a la web de la empresa">
																								<i class="fa fa-globe text-white" aria-hidden="true"></i>
																							</a>
																						<!-- </div> -->
																						<!-- <div class="col-xs-3 s-item"> -->
																							<a class="bg-facebook btn btn-default" href="<?php echo $facebook; ?>"  title="Visitar Facebook de la empresa">
																								<i class="ti-facebook"></i>
																							</a>
																						<!-- </div> -->
																					<?php endif ?>
																					<?php if($publicacion["twitter"] != ""): ?>
																						<!-- <div class="col-xs-3 s-item"> -->
																							<a class="bg-twitter btn btn-default" href="<?php echo $twitter; ?>"  title="Visitar Twitter de la empresa">
																								<i class="ti-twitter"></i>
																							</a>
																						<!-- </div> -->
																					<?php endif ?>
																					<?php if($publicacion["instagram"] != ""): ?>
																						<!-- <div class="col-xs-3 s-item"> -->
																							<a class="bg-instagram btn btn-default" href="<?php echo $instagram; ?>"  title="Visitar Instagram de la empresa">
																								<i class="ti-instagram"></i>
																							</a>
																						<!-- </div> -->
																					<?php endif ?>
																					<?php if($publicacion["linkedin"] != ""): ?>
																						<!-- <div class="col-xs-3 s-item"> -->
																							<a class="bg-linkedin btn btn-default" href="<?php echo $linkedin; ?>"  title="Visitar Linkedin de la empresa">
																								<i class="ti-linkedin"></i>
																							</a>
																						<!-- </div> -->
																					<?php endif ?>
																				</div>
																			</div>
																		</div>
																	<?php endif ?>
																	<div class="col-xs-12" style="padding-left: 0px; margin-top: 5px;"> 
																		<button class="btn btn-postular btn-block">POSTULARME</button>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</a>
											</div>
												<?php else: ?>
												<?php if($publicacion["logo_home"] == 2): ?>
												<div class="col-md-6">
												<a href="empleos-detalle.php?a=<?php echo $publicacion["area_amigable"]; ?>&s=<?php echo $publicacion["sector_amigable"]; ?>&p=<?php echo $publicacion["amigable"]; ?>">
														<div class="pub pub-f box box-block tile tile-2 silver" title="Ver detalles del empleo">
															<div class="t-icon right"><i class="ti-receipt"></i></div>
																<div class="t-content">
																<div class="row">
																	<div class="col-md-4 col-sm-4 text-center">
																		<img class="img-fluid b-a-radius-circle avatar" src="empresa/img/<?php echo $publicacion["empresa_imagen"] ? $publicacion["empresa_imagen"] : 'avatars/user.png'; ?>" alt="">
																	</div>
																	<div class="col-md-8 col-sm-8">
																		<h5 style="color: #373a3c;"><?php echo $publicacion["empresa_nombre"]; ?> <small><?= formatDate(date("Y-m-d H:i:s"), $publicacion["fecha_actualizacion"]) ?></small></h5>
																		<h6 style="color: #373a3c; font-weight: 600;"><?php echo $publicacion["titulo"]; ?> <span class="text-muted pull-xs-right"><?php echo $publicacion["sector_nombre"]; ?></span></h6>
																		<?php if($publicacion["sitio_web"] != "" || $publicacion["facebook"] != "" || $publicacion["twitter"] != "" || $publicacion["instagram"] != "" || $publicacion["linkedin"] != ""): ?>
																			<?php
																				$sitio_web = "";
																				$facebook = "";
																				$twitter = "";
																				$instagram = "";
																				$linkedin = "";
																				if (strstr($publicacion["sitio_web"], 'http')) {
																					$sitio_web = $publicacion["sitio_web"];
																				}
																				else {
																					$sitio_web = "http://$publicacion[sitio_web]";
																				}
																				if (strstr($publicacion["facebook"], 'http')) {
																					$facebook = $publicacion["facebook"];
																				}
																				else {
																					$facebook = "http://$publicacion[facebook]";
																				}
																				if (strstr($publicacion["twitter"], 'http')) {
																					$twitter = $publicacion["twitter"];
																				}
																				else {
																					$twitter = "http://$publicacion[twitter]";
																				}
																				if (strstr($publicacion["instagram"], 'http')) {
																					$instagram = $publicacion["instagram"];
																				}
																				else {
																					$instagram = "http://$publicacion[instagram]";
																				}
																				if (strstr($publicacion["linkedin"], 'http')) {
																					$linkedin = $publicacion["linkedin"];
																				}
																				else {
																					$linkedin = "http://$publicacion[linkedin]";
																				}
																			?>
																			<div style="background-color: transparent;">
																				<div class="row no-gutter">
																					<!-- <div class="col-xs-3 s-item">
																						<a class="bg-white" href="" style="background-color:  transparent !important;"></a>
																					</div> -->
																					<div class="btn-group btn-group-lg" role="group" aria-label="Large b utton group">
																						<?php if($publicacion["facebook"] != ""): ?>
																							<!-- <div class="col-xs-3 s-item"> -->
																								<a class="bg-primary btn btn-default" href="<?php echo $sitio_web; ?>" title="Ir a la web de la empresa">
																									<i class="fa fa-globe text-white" aria-hidden="true"></i>
																								</a>
																							<!-- </div> -->
																							<!-- <div class="col-xs-3 s-item"> -->
																								<a class="bg-facebook btn btn-default" href="<?php echo $facebook; ?>"  title="Visitar Facebook de la empresa">
																									<i class="ti-facebook"></i>
																								</a>
																							<!-- </div> -->
																						<?php endif ?>
																						<?php if($publicacion["twitter"] != ""): ?>
																							<!-- <div class="col-xs-3 s-item"> -->
																								<a class="bg-twitter btn btn-default" href="<?php echo $twitter; ?>"  title="Visitar Twitter de la empresa">
																									<i class="ti-twitter"></i>
																								</a>
																							<!-- </div> -->
																						<?php endif ?>
																						<?php if($publicacion["instagram"] != ""): ?>
																							<!-- <div class="col-xs-3 s-item"> -->
																								<a class="bg-instagram btn btn-default" href="<?php echo $instagram; ?>"  title="Visitar Instagram de la empresa">
																									<i class="ti-instagram"></i>
																								</a>
																							<!-- </div> -->
																						<?php endif ?>
																						<?php if($publicacion["linkedin"] != ""): ?>
																							<!-- <div class="col-xs-3 s-item"> -->
																								<a class="bg-linkedin btn btn-default" href="<?php echo $linkedin; ?>"  title="Visitar Linkedin de la empresa">
																									<i class="ti-linkedin"></i>
																								</a>
																							<!-- </div> -->
																						<?php endif ?>
																					</div>
																				</div>
																			</div>
																		<?php endif ?>
																		<div class="col-xs-12" style="padding-left: 0px; margin-top: 5px;"> 
																			<button class="btn btn-postular btn-block">POSTULARME</button>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</a>
													</div>
													<?php else: ?>
													<div class="col-md-6">
													<a href="empleos-detalle.php?a=<?php echo $publicacion["area_amigable"]; ?>&s=<?php echo $publicacion["sector_amigable"]; ?>&p=<?php echo $publicacion["amigable"]; ?>">
														<div class="pub pub-f box box-block bronze" title="Ver detalles del empleo">
															<div class="row">
																<div class="col-md-4 col-sm-4 text-center">
																	<img class="img-fluid b-a-radius-circle avatar" src="empresa/img/<?php echo $publicacion["empresa_imagen"] ? $publicacion["empresa_imagen"] : 'avatars/user.png'; ?>" alt="">
																</div>
																<div class="col-md-8 col-sm-8">
																	<h5 style="color: #373a3c;"><?php echo $publicacion["empresa_nombre"]; ?> <small><?= formatDate(date("Y-m-d H:i:s"), $publicacion["fecha_actualizacion"]) ?></small></h5>
																	<h6 style="color: #373a3c;"><?php echo $publicacion["titulo"]; ?> <span class="text-muted pull-xs-right"><?php echo $publicacion["sector_nombre"]; ?></span></h6>
																	<?php if($publicacion["facebook"] != "" || $publicacion["twitter"] != "" || $publicacion["instagram"] != "" || $publicacion["linkedin"] != ""): ?>
																		<?php
																			$facebook = "";
																			$twitter = "";
																			$instagram = "";
																			$linkedin = "";
																			if (strstr($publicacion["facebook"], 'http')) {
																				$facebook = $publicacion["facebook"];
																			}
																			else {
																				$facebook = "http://$publicacion[facebook]";
																			}
																			if (strstr($publicacion["twitter"], 'http')) {
																				$twitter = $publicacion["twitter"];
																			}
																			else {
																				$twitter = "http://$publicacion[twitter]";
																			}
																			if (strstr($publicacion["instagram"], 'http')) {
																				$instagram = $publicacion["instagram"];
																			}
																			else {
																				$instagram = "http://$publicacion[instagram]";
																			}
																			if (strstr($publicacion["linkedin"], 'http')) {
																				$linkedin = $publicacion["linkedin"];
																			}
																			else {
																				$linkedin = "http://$publicacion[linkedin]";
																			}
																		?>
																		<div style="background-color: transparent;">
																			<div class="row no-gutter">
																				<!-- <div class="col-xs-3 s-item">
																					<a class="bg-white" href="" style="background-color:  transparent !important;"></a>
																				</div> -->
																				<div class="btn-group btn-group-lg" role="group" aria-label="Large b utton group">
																					<?php if($publicacion["facebook"] != ""): ?>
																						<!-- <div class="col-xs-3 s-item"> -->
																							<a class="bg-primary btn btn-default" href="<?php echo $sitio_web; ?>" title="Ir a la web de la empresa">
																								<i class="fa fa-globe text-white" aria-hidden="true"></i>
																							</a>
																						<!-- </div> -->
																						<!-- <div class="col-xs-3 s-item"> -->
																							<a class="bg-facebook btn btn-default" href="<?php echo $facebook; ?>"  title="Visitar Facebook de la empresa">
																								<i class="ti-facebook"></i>
																							</a>
																						<!-- </div> -->
																					<?php endif ?>
																					<?php if($publicacion["twitter"] != ""): ?>
																						<!-- <div class="col-xs-3 s-item"> -->
																							<a class="bg-twitter btn btn-default" href="<?php echo $twitter; ?>"  title="Visitar Twitter de la empresa">
																								<i class="ti-twitter"></i>
																							</a>
																						<!-- </div> -->
																					<?php endif ?>
																					<?php if($publicacion["instagram"] != ""): ?>
																						<!-- <div class="col-xs-3 s-item"> -->
																							<a class="bg-instagram btn btn-default" href="<?php echo $instagram; ?>"  title="Visitar Instagram de la empresa">
																								<i class="ti-instagram"></i>
																							</a>
																						<!-- </div> -->
																					<?php endif ?>
																					<?php if($publicacion["linkedin"] != ""): ?>
																						<!-- <div class="col-xs-3 s-item"> -->
																							<a class="bg-linkedin btn btn-default" href="<?php echo $linkedin; ?>"  title="Visitar Linkedin de la empresa">
																								<i class="ti-linkedin"></i>
																							</a>
																						<!-- </div> -->
																					<?php endif ?>
																				</div>
																			</div>
																		</div>
																	<?php endif ?>
																	<div class="col-xs-12" style="padding-left: 0px; margin-top: 5px;"> 
																		<button class="btn btn-postular btn-block">POSTULARME</button>
																	</div>
																</div>
															</div>
														</div>
													</a>
													</div>	
													<?php endif ?>
												<?php endif ?>

									<?php endforeach ?>
								<?php else: ?>	
								<div class="alert alert-danger fade in" role="alert">
									<i class="ion-android-alert"></i> No hemos obtenido ningún resultado que se ajuste a tus criterios de búsqueda.
								</div>
								<?php endif ?>
							<?php else: ?>

							<!-- FIXME: SECCION DE TODOS LOS CUADRITOS, VER QUE HACER CON ESTO ! -->
								<!-- <div class="row row-sm"> -->
									
									<?php foreach($publicacionesOro as $publicacion): ?>
										<div class="col-md-6">
											<a href="empleos-detalle.php?a=<?php echo $publicacion["area_amigable"]; ?>&s=<?php echo $publicacion["sector_amigable"]; ?>&p=<?php echo $publicacion["amigable"]; ?>">
												<div class="pub box box-block tile tile-1 m-b-2 gold">
													<div class="t-icon right"><span class="bg-warning"></span><i class="ti-medall-alt" title="Publicación destacada" style="z-index: 50;"></i></div>
													<div class="t-content"  title="Ver detalles del empleo">
														<div class="row">
															<div class="col-md-4 col-sm-4 text-center">
																<img class="img-fluid b-a-radius-circle avatar" src="empresa/img/<?php echo !$publicacion["imagen"] ? 'avatars/user.png' : $publicacion["imagen"]; ?>" alt="">
															</div>
															<div class="col-md-8 col-sm-8">
																<h5 style="color: #373a3c;"><?php echo $publicacion["empresa_nombre"]; ?> <small><?= formatDate(date("Y-m-d H:i:s"), $publicacion["fecha_actualizacion"]) ?></small></h5>
																<h6 style="color: #373a3c; width: 90%;"><?php echo $publicacion["titulo"]; ?></h6>
																<p style="color: #373a3c;"><?php echo $publicacion["area_nombre"]; ?></p>
																
																<?php if($publicacion["sitio_web"] != "" || $publicacion["facebook"] != "" || $publicacion["twitter"] != "" || $publicacion["instagram"] != "" || $publicacion["linkedin"] != ""): ?>
																	<?php
																		$sitio_web = "";
																		$facebook = "";
																		$twitter = "";
																		$instagram = "";
																		$linkedin = "";
																		if (strstr($publicacion["sitio_web"], 'http')) {
																			$sitio_web = $publicacion["sitio_web"];
																		}
																		else {
																			$sitio_web = "http://$publicacion[sitio_web]";
																		}
																		if (strstr($publicacion["facebook"], 'http')) {
																			$facebook = $publicacion["facebook"];
																		}
																		else {
																			$facebook = "http://$publicacion[facebook]";
																		}
																		if (strstr($publicacion["twitter"], 'http')) {
																			$twitter = $publicacion["twitter"];
																		}
																		else {
																			$twitter = "http://$publicacion[twitter]";
																		}
																		if (strstr($publicacion["instagram"], 'http')) {
																			$instagram = $publicacion["instagram"];
																		}
																		else {
																			$instagram = "http://$publicacion[instagram]";
																		}
																		if (strstr($publicacion["linkedin"], 'http')) {
																			$linkedin = $publicacion["linkedin"];
																		}
																		else {
																			$linkedin = "http://$publicacion[linkedin]";
																		}
																	?>
																	<div style="background-color: transparent;">
																	<div class="row no-gutter">
																		<!-- <div class="col-xs-3 s-item">
																			<a class="bg-white" href="" style="background-color:  transparent !important;"></a>
																		</div> -->
																		<div class="btn-group btn-group-lg" role="group" aria-label="Large b utton group">
																			<?php if($publicacion["facebook"] != ""): ?>
																				<!-- <div class="col-xs-3 s-item"> -->
																					<a class="bg-primary btn btn-default" href="<?php echo $sitio_web; ?>" title="Ir a la web de la empresa">
																						<i class="fa fa-globe text-white" aria-hidden="true"></i>
																					</a>
																				<!-- </div> -->
																				<!-- <div class="col-xs-3 s-item"> -->
																					<a class="bg-facebook btn btn-default" href="<?php echo $facebook; ?>"  title="Visitar Facebook de la empresa">
																						<i class="ti-facebook"></i>
																					</a>
																				<!-- </div> -->
																			<?php endif ?>
																			<?php if($publicacion["twitter"] != ""): ?>
																				<!-- <div class="col-xs-3 s-item"> -->
																					<a class="bg-twitter btn btn-default" href="<?php echo $twitter; ?>"  title="Visitar Twitter de la empresa">
																						<i class="ti-twitter"></i>
																					</a>
																				<!-- </div> -->
																			<?php endif ?>
																			<?php if($publicacion["instagram"] != ""): ?>
																				<!-- <div class="col-xs-3 s-item"> -->
																					<a class="bg-instagram btn btn-default" href="<?php echo $instagram; ?>"  title="Visitar Instagram de la empresa">
																						<i class="ti-instagram"></i>
																					</a>
																				<!-- </div> -->
																			<?php endif ?>
																			<?php if($publicacion["linkedin"] != ""): ?>
																				<!-- <div class="col-xs-3 s-item"> -->
																					<a class="bg-linkedin btn btn-default" href="<?php echo $linkedin; ?>"  title="Visitar Linkedin de la empresa">
																						<i class="ti-linkedin"></i>
																					</a>
																				<!-- </div> -->
																			<?php endif ?>
																		</div>
																	</div>
																</div>
																<?php endif ?>
																<div class="col-xs-12" style="padding-left: 0px; margin-top: 5px;"> 
																	<button class="btn btn-postular btn-block">POSTULARME</button>
																</div>
															</div>
														</div>
													</div>
												</div>
											</a>
										</div>

									<?php endforeach ?>
									<?php foreach($publicacionesPlata as $publicacion): ?>
										<div class="col-md-6">
											<a href="empleos-detalle.php?a=<?php echo $publicacion["area_amigable"]; ?>&s=<?php echo $publicacion["sector_amigable"]; ?>&p=<?php echo $publicacion["amigable"]; ?>">
												<div class="pub box box-block tile tile-2 m-b-2 silver" style="border: 1px solid rgba(0, 0, 0, 0.125) !important;">
													<div class="t-icon right"><i class="ti-receipt"></i></div>
													<div class="t-content">
														<div class="row">
															<div class="col-md-4 col-sm-4 text-center">
																<img class="img-fluid b-a-radius-circle avatar" src="empresa/img/<?php echo !$publicacion["imagen"] ? 'avatars/user.png' : $publicacion["imagen"]; ?>" alt="">
															</div>
															<div class="col-md-8 col-sm-8">
																<h5 style="color: #373a3c;"><?php echo $publicacion["empresa_nombre"]; ?> <small><?= formatDate(date("Y-m-d H:i:s"), $publicacion["fecha_actualizacion"]) ?></small></h5>
																<h6 style="color: #373a3c;"><?php echo $publicacion["titulo"]; ?></h6>
																<p style="color: #373a3c;"><?php echo $publicacion["area_nombre"]; ?></p>
																<?php if($publicacion["sitio_web"] != "" || $publicacion["facebook"] != "" || $publicacion["twitter"] != "" || $publicacion["instagram"] != "" || $publicacion["linkedin"] != ""): ?>
																	<?php
																		$sitio_web = "";
																		$facebook = "";
																		$twitter = "";
																		$instagram = "";
																		$linkedin = "";
																		if (strstr($publicacion["sitio_web"], 'http')) {
																			$sitio_web = $publicacion["sitio_web"];
																		}
																		else {
																			$sitio_web = "http://$publicacion[sitio_web]";
																		}
																		if (strstr($publicacion["facebook"], 'http')) {
																			$facebook = $publicacion["facebook"];
																		}
																		else {
																			$facebook = "http://$publicacion[facebook]";
																		}
																		if (strstr($publicacion["twitter"], 'http')) {
																			$twitter = $publicacion["twitter"];
																		}
																		else {
																			$twitter = "http://$publicacion[twitter]";
																		}
																		if (strstr($publicacion["instagram"], 'http')) {
																			$instagram = $publicacion["instagram"];
																		}
																		else {
																			$instagram = "http://$publicacion[instagram]";
																		}
																		if (strstr($publicacion["linkedin"], 'http')) {
																			$linkedin = $publicacion["linkedin"];
																		}
																		else {
																			$linkedin = "http://$publicacion[linkedin]";
																		}
																	?>
																<div style="background-color: transparent;">
																	<div class="row no-gutter">
																		<!-- <div class="col-xs-3 s-item">
																			<a class="bg-white" href="" style="background-color:  transparent !important;"></a>
																		</div> -->
																		<div class="btn-group btn-group-lg" role="group" aria-label="Large b utton group">
																			<?php if($publicacion["facebook"] != ""): ?>
																				<!-- <div class="col-xs-3 s-item"> -->
																					<a class="bg-primary btn btn-default" href="<?php echo $sitio_web; ?>" title="Ir a la web de la empresa">
																						<i class="fa fa-globe text-white" aria-hidden="true"></i>
																					</a>
																				<!-- </div> -->
																				<!-- <div class="col-xs-3 s-item"> -->
																					<a class="bg-facebook btn btn-default" href="<?php echo $facebook; ?>"  title="Visitar Facebook de la empresa">
																						<i class="ti-facebook"></i>
																					</a>
																				<!-- </div> -->
																			<?php endif ?>
																			<?php if($publicacion["twitter"] != ""): ?>
																				<!-- <div class="col-xs-3 s-item"> -->
																					<a class="bg-twitter btn btn-default" href="<?php echo $twitter; ?>"  title="Visitar Twitter de la empresa">
																						<i class="ti-twitter"></i>
																					</a>
																				<!-- </div> -->
																			<?php endif ?>
																			<?php if($publicacion["instagram"] != ""): ?>
																				<!-- <div class="col-xs-3 s-item"> -->
																					<a class="bg-instagram btn btn-default" href="<?php echo $instagram; ?>"  title="Visitar Instagram de la empresa">
																						<i class="ti-instagram"></i>
																					</a>
																				<!-- </div> -->
																			<?php endif ?>
																			<?php if($publicacion["linkedin"] != ""): ?>
																				<!-- <div class="col-xs-3 s-item"> -->
																					<a class="bg-linkedin btn btn-default" href="<?php echo $linkedin; ?>"  title="Visitar Linkedin de la empresa">
																						<i class="ti-linkedin"></i>
																					</a>
																				<!-- </div> -->
																			<?php endif ?>
																		</div>
																	</div>
																</div>
																<?php endif ?>
																<div class="col-xs-12" style="padding-left: 0px; margin-top: 5px;"> 
																	<button class="btn btn-postular btn-block">POSTULARME</button>
																</div>
															</div>
														</div>
													</div>
												</div>
											</a>
										</div>

									<?php endforeach ?>
									<?php foreach($publicaciones as $publicacion): ?>
										<div class="col-md-6">
											<a href="empleos-detalle.php?a=<?php echo $publicacion["area_amigable"]; ?>&s=<?php echo $publicacion["sector_amigable"]; ?>&p=<?php echo $publicacion["amigable"]; ?>">
												<div class="pub box box-block bronze" title="Ver detalles del empleo">
													<div class="row">
														<div class="col-md-4 col-sm-4 text-center">
															<img class="img-fluid b-a-radius-circle avatar" src="empresa/img/<?php echo $publicacion["empresa_imagen"] ? $publicacion["empresa_imagen"] : "avatars/user.png"; ?>" alt="">
														</div>
														<div class="col-md-8 col-sm-8">
															<h5 style="color: #373a3c;"><?php echo $publicacion["empresa_nombre"]; ?> <small><?= formatDate(date("Y-m-d H:i:s"), $publicacion["fecha_actualizacion"]) ?></small></h5>
															<h6 style="color: #373a3c;"><?php echo $publicacion["titulo"]; ?></h6>
															<p style="color: #373a3c;"><?php echo $publicacion["area_nombre"]; ?></p>
															<?php if($publicacion["facebook"] != "" || $publicacion["twitter"] != "" || $publicacion["instagram"] != "" || $publicacion["linkedin"] != ""): ?>
																<?php
																	$facebook = "";
																	$twitter = "";
																	$instagram = "";
																	$linkedin = "";
																	if (strstr($publicacion["facebook"], 'http')) {
																		$facebook = $publicacion["facebook"];
																	}
																	else {
																		$facebook = "http://$publicacion[facebook]";
																	}
																	if (strstr($publicacion["twitter"], 'http')) {
																		$twitter = $publicacion["twitter"];
																	}
																	else {
																		$twitter = "http://$publicacion[twitter]";
																	}
																	if (strstr($publicacion["instagram"], 'http')) {
																		$instagram = $publicacion["instagram"];
																	}
																	else {
																		$instagram = "http://$publicacion[instagram]";
																	}
																	if (strstr($publicacion["linkedin"], 'http')) {
																		$linkedin = $publicacion["linkedin"];
																	}
																	else {
																		$linkedin = "http://$publicacion[linkedin]";
																	}
																?>
																<div style="background-color: transparent;">
																	<div class="row no-gutter">
																		<!-- <div class="col-xs-3 s-item">
																			<a class="bg-white" href="" style="background-color:  transparent !important;"></a>
																		</div> -->
																		<div class="btn-group btn-group-lg" role="group" aria-label="Large b utton group">
																			<?php if($publicacion["facebook"] != ""): ?>
																				<!-- <div class="col-xs-3 s-item"> -->
																					<a class="bg-primary btn btn-default" href="<?php echo $sitio_web; ?>" title="Ir a la web de la empresa">
																						<i class="fa fa-globe text-white" aria-hidden="true"></i>
																					</a>
																				<!-- </div> -->
																				<!-- <div class="col-xs-3 s-item"> -->
																					<a class="bg-facebook btn btn-default" href="<?php echo $facebook; ?>"  title="Visitar Facebook de la empresa">
																						<i class="ti-facebook"></i>
																					</a>
																				<!-- </div> -->
																			<?php endif ?>
																			<?php if($publicacion["twitter"] != ""): ?>
																				<!-- <div class="col-xs-3 s-item"> -->
																					<a class="bg-twitter btn btn-default" href="<?php echo $twitter; ?>"  title="Visitar Twitter de la empresa">
																						<i class="ti-twitter"></i>
																					</a>
																				<!-- </div> -->
																			<?php endif ?>
																			<?php if($publicacion["instagram"] != ""): ?>
																				<!-- <div class="col-xs-3 s-item"> -->
																					<a class="bg-instagram btn btn-default" href="<?php echo $instagram; ?>"  title="Visitar Instagram de la empresa">
																						<i class="ti-instagram"></i>
																					</a>
																				<!-- </div> -->
																			<?php endif ?>
																			<?php if($publicacion["linkedin"] != ""): ?>
																				<!-- <div class="col-xs-3 s-item"> -->
																					<a class="bg-linkedin btn btn-default" href="<?php echo $linkedin; ?>"  title="Visitar Linkedin de la empresa">
																						<i class="ti-linkedin"></i>
																					</a>
																				<!-- </div> -->
																			<?php endif ?>
																			
																		</div>
																	</div>
																</div>
															<?php endif ?>
															<button class="btn btn-postular btn-block">POSTULARME</button>
														</div>
													</div>
												</div>
											</a>
										</div>
									<?php endforeach ?>
								<!-- </div> -->
							<?php endif ?>

							<?php if($cantidadRegistros > 0 && ($filtroActivado || $busqueda)): ?>
								<div class="col-md-12">
								<div class="btn-toolbar">
									<div class="btn-group pull-xs-right">
										<?php
											$urlParams = "empleos.php";
											if($filtroArea) {
												$urlParams .= "?area=$filtroArea";
												if($filtroSector) {
													$urlParams .= "&sector=$filtroSector";
												}
												if($filtroMomento) {
													$urlParams .= "&momento=$filtroMomento";
												}
											}
											else {
												if($busqueda) {
													$urlParams .= "?busqueda=$busqueda";
												}
												elseif($filtroMomento) {
													$urlParams .= "?momento=$filtroMomento";
												}elseif($filtroDisp){
													$urlParams .= "?disp=$filtroDisp";
												}
											}

										?>
										<a href="<?php echo $pagina > 1 ? ("$urlParams&pagina=" . ($pagina - 1)) : "javascript: void(0);"; ?>" class="btn btn-secondary waves-effect waves-light <?php if($pagina == 1) { echo "disabled"; } ?>">Anterior</a>
										<?php for($i = 1; $i <= $cantidadPaginas; $i++): ?>
											<a href="<?php echo "$urlParams&pagina=$i"; ?>" class="btn <?php echo $i == $pagina ? "btn-primary" : "btn-secondary"; ?> waves-effect waves-light"><?php echo $i; ?></a>
										<?php endfor ?>
										<a href="<?php echo $pagina < $cantidadPaginas ? ("$urlParams&pagina=" . ($pagina + 1)) : ""; ?>" class="btn btn-secondary waves-effect waves-light <?php if($pagina == $cantidadPaginas) { echo "disabled"; } ?>">Siguiente</a>
									</div>
								</div>
								</div>
							<?php endif ?>

						</div>
					</div>

				</div>
				<?php require_once('includes/footer.php'); ?>
			</div>
		<!-- </div> -->

		<?php require_once('includes/libs-js.php'); ?>
	</body>
</html>