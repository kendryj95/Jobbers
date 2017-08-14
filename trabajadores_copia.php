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

	$busqueda = isset($_REQUEST["busqueda"]) ? $_REQUEST["busqueda"] : false;

	$filtroActivado = $filtroArea || $filtroMomento;

	$cantidadRegistros = 0;

	if($filtroActivado || ($busqueda || $busquedaAvanzada)) {
		$pagina = isset($_REQUEST["pagina"]) ? $_REQUEST["pagina"] : 1;
		$final = 5;
		$inicial = $final * ($pagina - 1);
	}

	function crearURL($parametros = array()) {
		$url = "trabajadores.php";
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

	$momentos = array(
		array(
			"nombre" => "De 18 a 23 años",
			"amigable" => "de-18-a-23",
			"cantidad" => 0,
            "rango_a" => 18,
            "rango_b" => 23
		),
		array(
			"nombre" => "De 24 a 30 años",
			"amigable" => "de-24-a-30",
			"cantidad" => 0,
            "rango_a" => 24,
            "rango_b" => 30
		),
		array(
			"nombre" => "De 31 a 36 años",
			"amigable" => "de-31-a-36",
			"cantidad" => 0,
            "rango_a" => 31,
            "rango_b" => 36
		),
		array(
			"nombre" => "De 37 a 45 años",
			"amigable" => "de-37-a-45",
			"cantidad" => 0,
            "rango_a" => 37,
            "rango_b" => 45
		)
	);

	foreach($momentos as $m) {
		if($m["amigable"] == $filtroMomento) {
			$infoMomento = $m;
		}
	}

	if($filtroArea) {
		$infoArea = $db->getRow("
			SELECT
				id,
				nombre
			FROM
				areas_estudio
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
		}
		else {
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
	}
	else {		
		$areas = $db->getAll("
			SELECT
				id,
				nombre,
				amigable
			FROM
				areas_estudio
			ORDER BY
				nombre
		");

		if($filtroMomento) {
			foreach($areas as $i => $area) {
				$areas[$i]["cantidad"] = $db->getOne("
					SELECT
						COUNT(te.id_area_estudio)
					FROM
						trabajadores AS tra
					INNER JOIN trabajadores_educacion AS te ON tra.id = te.id_trabajador
					INNER JOIN areas_estudio AS ae ON te.id_area_estudio = ae.id
					WHERE
						te.id_area_estudio = $area[id]
					AND (TIMESTAMPDIFF(YEAR, tra.fecha_nacimiento, CURDATE()) >= $infoMomento[rango_a] AND TIMESTAMPDIFF(YEAR, tra.fecha_nacimiento, CURDATE()) <= $infoMomento[rango_b])
				");
			}
		}
		else {
			foreach($areas as $i => $area) {
				$areas[$i]["cantidad"] = $db->getOne("
					SELECT
						COUNT(te.id_area_estudio)
					FROM
						trabajadores AS tra
					INNER JOIN trabajadores_educacion AS te ON tra.id = te.id_trabajador
					INNER JOIN areas_estudio AS ae ON te.id_area_estudio = ae.id
					WHERE
						te.id_area_estudio = $area[id]
				");
			}
		}
	}

	if($busquedaAvanzada) {
		$query = "
			SELECT
				tra.id,
				tra.fecha_nacimiento,
                TIMESTAMPDIFF(YEAR,  tra.fecha_nacimiento, CURDATE()) AS edad,
                tra.nombres,
				tra.apellidos,
				CONCAT(
					img.directorio,
					'/',
					img.nombre,
					'.',
					img.extension
				) AS imagen,
				tra.calificacion_general
			FROM
				trabajadores AS tra
			LEFT JOIN imagenes AS img ON tra.id_imagen = img.id
			WHERE 1
		";
		$query2 = "
			SELECT
				COUNT(*)
			FROM
				trabajadores AS tra
			LEFT JOIN imagenes AS img ON tra.id_imagen = img.id
			WHERE 1
		";
		
		if($palabrasClave != "") {
			$tokens = explode(",", $palabrasClave);
			$l = count($tokens);
			if($l > 1) {
				$query .= " AND ((tra.nombres LIKE '%$tokens[0]%' OR tra.apellidos LIKE '%$tokens[0]%')";
				$query2 .= " AND ((tra.nombres LIKE '%$tokens[0]%' OR tra.apellidos LIKE '%$tokens[0]%')";
				for($i = 1; $i < $l; $i++) {
					$query .= " OR (tra.nombres LIKE '%$tokens[$i]%' OR tra.apellidos LIKE '%$tokens[$i]%')";
					$query2 .= " OR (tra.nombres LIKE '%$tokens[$i]%' OR tra.apellidos LIKE '%$tokens[$i]%')";
				}
				$query .= ")";
				$query2 .= ")";
			}
			else {
				$query .= " AND (tra.nombres LIKE '%$tokens[0]%' OR tra.apellidos LIKE '%$tokens[0]%')";
				$query2 .= " AND (tra.nombres LIKE '%$tokens[0]%' OR tra.apellidos LIKE '%$tokens[0]%')";
			}
		}
				
		if($filtroArea) {            
            if($filtroMomento) {	
				$query .= "
                    AND (TIMESTAMPDIFF(YEAR, tra.fecha_nacimiento, CURDATE()) >= $infoMomento[rango_a] AND TIMESTAMPDIFF(YEAR, tra.fecha_nacimiento, CURDATE()) <= $infoMomento[rango_b])
				";			
				$query2 .= "
					AND (TIMESTAMPDIFF(YEAR, tra.fecha_nacimiento, CURDATE()) >= $infoMomento[rango_a] AND TIMESTAMPDIFF(YEAR, tra.fecha_nacimiento, CURDATE()) <= $infoMomento[rango_b])
				";
			}
		}
		else {
            if($filtroMomento) {
				$query .= "
                    AND (TIMESTAMPDIFF(YEAR, tra.fecha_nacimiento, CURDATE()) >= $infoMomento[rango_a] AND TIMESTAMPDIFF(YEAR, tra.fecha_nacimiento, CURDATE()) <= $infoMomento[rango_b])
				";			
				$query2 .= "
					AND (TIMESTAMPDIFF(YEAR, tra.fecha_nacimiento, CURDATE()) >= $infoMomento[rango_a] AND TIMESTAMPDIFF(YEAR, tra.fecha_nacimiento, CURDATE()) <= $infoMomento[rango_b])
				";
			}
        }
		
		$cantidadRegistros = $db->getOne($query2);
		
		$cantidadPaginas = ceil($cantidadRegistros / $final);
		
		$query .= "GROUP BY tra.id LIMIT $inicial, $final";
        
		$trabajadores = $db->getAll($query);	
		
		if($trabajadores) {
			foreach($trabajadores as $k => $t) {
				if(!$t["imagen"]) {
					$trabajadores[$k]["imagen"] = "avatars/user.png";
				}
			}
		}
	}
	elseif($filtroActivado) {
		$query = "
			SELECT
                tra.id,
                tra.fecha_nacimiento,
                TIMESTAMPDIFF(
                    YEAR,
                    tra.fecha_nacimiento,
                    CURDATE()
                ) AS edad,
                tra.nombres,
                tra.apellidos,
                CONCAT(
                    img.directorio,
                    '/',
                    img.nombre,
                    '.',
                    img.extension
                ) AS imagen,
                tra.calificacion_general
            FROM
                trabajadores AS tra
            LEFT JOIN imagenes AS img ON tra.id_imagen = img.id
            LEFT JOIN trabajadores_educacion AS te ON tra.id = te.id_trabajador
		";
		$query2 = "
			SELECT
                COUNT(*)
            FROM
                trabajadores AS tra
            LEFT JOIN imagenes AS img ON tra.id_imagen = img.id
            LEFT JOIN trabajadores_educacion AS te ON tra.id = te.id_trabajador
		";
		
		if($filtroArea) {            
            $query .= "
                WHERE
                    te.id_area_estudio = $infoArea[id]
            ";            
            $query2 .= "
                WHERE
                    te.id_area_estudio = $infoArea[id]
            ";
            
            if($filtroMomento) {
				$query .= "
                    AND (TIMESTAMPDIFF(YEAR, tra.fecha_nacimiento, CURDATE()) >= $infoMomento[rango_a] AND TIMESTAMPDIFF(YEAR, tra.fecha_nacimiento, CURDATE()) <= $infoMomento[rango_b])
				";			
				$query2 .= "
					AND (TIMESTAMPDIFF(YEAR, tra.fecha_nacimiento, CURDATE()) >= $infoMomento[rango_a] AND TIMESTAMPDIFF(YEAR, tra.fecha_nacimiento, CURDATE()) <= $infoMomento[rango_b])
				";
			}
		}
		else {            
            if($filtroMomento) {
				$query .= "
                    WHERE (TIMESTAMPDIFF(YEAR, tra.fecha_nacimiento, CURDATE()) >= $infoMomento[rango_a] AND TIMESTAMPDIFF(YEAR, tra.fecha_nacimiento, CURDATE()) <= $infoMomento[rango_b])
				";			
				$query2 .= "
					WHERE (TIMESTAMPDIFF(YEAR, tra.fecha_nacimiento, CURDATE()) >= $infoMomento[rango_a] AND TIMESTAMPDIFF(YEAR, tra.fecha_nacimiento, CURDATE()) <= $infoMomento[rango_b])
				";
			}
        }
		
		$cantidadRegistros = $db->getOne($query2);
		
		$cantidadPaginas = ceil($cantidadRegistros / $final);
		
		$query .= "GROUP BY tra.id LIMIT $inicial, $final";
		
		$trabajadores = $db->getAll($query);	
		
		if($trabajadores) {
			foreach($trabajadores as $k => $t) {
				if(!$t["imagen"]) {
					$trabajadores[$k]["imagen"] = "avatars/user.png";
				}
			}
		}
	}
	else if($busqueda) {
		$trabajadores = $db->getAll("
			SELECT
				tra.id,
				tra.fecha_nacimiento,
                TIMESTAMPDIFF(YEAR,  tra.fecha_nacimiento, CURDATE()) AS edad,
                tra.nombres,
				tra.apellidos,
				CONCAT(
					img.directorio,
					'/',
					img.nombre,
					'.',
					img.extension
				) AS imagen,
				tra.calificacion_general
			FROM
				trabajadores AS tra
			LEFT JOIN imagenes AS img ON tra.id_imagen = img.id
			WHERE tra.nombres LIKE '%$busqueda%' OR tra.apellidos LIKE '%$busqueda%'
			LIMIT $inicial, $final
		");

		foreach($trabajadores as $k => $t) {
			if(!$t["imagen"]) {
				$trabajadores[$k]["imagen"] = "avatars/user.png";
			}
		}
		
		$cantidadRegistros = $db->getOne("
			SELECT
				COUNT(*)
			FROM
				trabajadores AS tra
			LEFT JOIN imagenes AS img ON tra.id_imagen = img.id
			WHERE tra.nombres LIKE '%$busqueda%' OR tra.apellidos LIKE '%$busqueda%'
		");
		
		$cantidadPaginas = ceil($cantidadRegistros / $final);
	}
	else {
		$trabajadores = $db->getAll("
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
				tra.calificacion_general
			FROM
				trabajadores AS tra
			LEFT JOIN imagenes AS img ON tra.id_imagen = img.id
			ORDER BY RAND()
			LIMIT 12
		");

		foreach($trabajadores as $k => $t) {
			if(!$t["imagen"]) {
				$trabajadores[$k]["imagen"] = "avatars/user.png";
			}
		}
	}

    if(!$filtroMomento) {
		$band = false;
		foreach($momentos as $i => $momento) {
			if($filtroActivado) {
                $query = "
                    SELECT
						COUNT(*)
					FROM
					(
						SELECT
							tra.id
						FROM
							trabajadores AS tra
						LEFT JOIN imagenes AS img ON tra.id_imagen = img.id
						LEFT JOIN trabajadores_educacion AS te ON tra.id = te.id_trabajador
						WHERE
							(
								TIMESTAMPDIFF(
									YEAR,
									tra.fecha_nacimiento,
									CURDATE()
								) >= $momento[rango_a]
								AND TIMESTAMPDIFF(
									YEAR,
									tra.fecha_nacimiento,
									CURDATE()
								) <= $momento[rango_b]
							) AND te.id_area_estudio = $infoArea[id]
						GROUP BY
							tra.id
					) AS t
                ";
			}
			else {
				$query = "
                    SELECT
                        COUNT(*)
                    FROM
                        trabajadores AS tra
                    LEFT JOIN imagenes AS img ON tra.id_imagen = img.id
                    WHERE TIMESTAMPDIFF(YEAR,  tra.fecha_nacimiento, CURDATE()) >= $momento[rango_a] AND TIMESTAMPDIFF(YEAR,  tra.fecha_nacimiento, CURDATE()) <= $momento[rango_b]
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
		<title>JOBBERS - Trabajadores</title>
		<?php require_once('includes/libs-css.php'); ?>
		<link rel="stylesheet" href="vendor/ionicons/css/ionicons.min.css">
		<style>
			.tra {
				min-height: 150px;
				margin-bottom: 30px;
			}
			.tra-f {
				min-height: 110px;
			}
			.tra, .tra-f {
				background-color: #f8f8f8 !important;
				-webkit-transition: all 0.2s ease-in-out;
				transition: all 0.2s ease-in-out;
				cursor: pointer;
			}			
			.tra:hover, .tra-f:hover {
				background-color: #3e70c9 !important;
			}
			.tra:hover *, .tra-f:hover * {
				color: #fff !important;
			}
		</style>
	</head>
	<body class="large-sidebar fixed-sidebar fixed-header skin-5">
		<div class="wrapper">
		<!-- Sidebar -->
		<?php require_once('includes/sidebar.php'); ?>

		<!-- Sidebar second -->
		<?php require_once('includes/sidebar-second.php'); ?>

		<!-- Header -->
		<?php require_once('includes/header.php'); ?>
			<div class="site-content bg-white">
				<!-- Content -->
				<div class="content-area p-y-1">
					<div class="container-fluid">
						<div class="col-md-6">				
							<?php if($filtroActivado): ?>
								<h4>Trabajadores</h4>
								<ol class="breadcrumb no-bg m-b-1">
									<li class="breadcrumb-item"><a href="./">JOBBERS</a></li>
									<?php if($filtroArea && $filtroMomento): ?>
										<?php if($filtroSector): ?>
											<li class="breadcrumb-item"><a href="<?php echo "trabajadores.php?area=$filtroArea&pagina=1"; ?>"><?php echo $infoArea["nombre"]; ?></a></li>
											<li class="breadcrumb-item active"><a href="<?php echo "trabajadores.php?area=$filtroArea&sector=$filtroSector&pagina=1"; ?>"><?php echo $infoSector["nombre"]; ?></a></li>
											<li class="breadcrumb-item"><?php echo $infoMomento["nombre"]; ?></li>
										<?php else: ?>								
											<li class="breadcrumb-item"><a href="<?php echo "trabajadores.php?area=$filtroArea&pagina=1"; ?>"><?php echo $infoArea["nombre"]; ?></a></li>
											<li class="breadcrumb-item active"><?php echo $infoMomento["nombre"]; ?></li>
										<?php endif ?>
									<?php elseif($filtroArea && !$filtroMomento): ?>
										<?php if($filtroSector): ?>
											<li class="breadcrumb-item"><a href="<?php echo "trabajadores.php?area=$filtroArea&pagina=1"; ?>"><?php echo $infoArea["nombre"]; ?></a></li>
											<li class="breadcrumb-item active"><?php echo $infoSector["nombre"]; ?></li>
										<?php else: ?>
											<li class="breadcrumb-item active"><?php echo $infoArea["nombre"]; ?></li>
										<?php endif ?>
									<?php elseif(!$filtroArea && $filtroMomento): ?>
										<li class="breadcrumb-item active"><?php echo $infoMomento["nombre"]; ?></li>
									<?php endif ?>
								</ol>
							<?php else: ?>
								<br>
							<?php endif ?>					
						</div>
						<?php if($cantidadRegistros > 0): ?>
							<?php if($filtroActivado): ?>
								<div class="col-md-6 text-xs-right">
									<h6 class="m-t-1"><?php echo $filtroArea ? ($infoArea["nombre"] . ($filtroSector ? " ($infoSector[nombre])" : "")) : (empty($infoMomento) ? "" : "$infoMomento[nombre]"); ?></h6>
									<h6>Trabajadores: <?php echo ($inicial + 1); ?> - <?php echo ($final * $pagina) > $cantidadRegistros ? $cantidadRegistros : ($final * $pagina); ?> de <?php echo $cantidadRegistros; ?></h6>
								</div>
							<?php elseif($busqueda): ?>
								<div class="col-md-6 text-xs-right">
									<h6 class="m-t-1">Resultados de búsqueda para <strong><?php echo $busqueda; ?></strong></h6>
									<h6>Trabajadores: <?php echo ($inicial + 1); ?> - <?php echo ($final * $pagina) > $cantidadRegistros ? $cantidadRegistros : ($final * $pagina); ?> de <?php echo $cantidadRegistros; ?></h6>
								</div>
							<?php endif ?>
						<?php endif ?>
					</div>

					<div class="container-fluid">

						<div class="col-md-3">
							<div class="box bg-white">
								<div class="box-block clearfix">
									<h5 class="pull-xs-left"><i class="ion-ios-list m-sm-r-1"></i> Área de estudio</h5>
								</div>
								<table class="table m-md-b-0">
									<tbody>
										<?php if($filtroArea): ?>
											<tr>
												<td>
													<a style="margin-left: 7px;" class="text-primary" href="trabajadores.php?area=<?php echo $filtroArea . ($filtroSector ? "&sector=$filtroSector" : "") . ($filtroMomento ? "&momento=$filtroMomento&pagina=1" : "") . ($filtroMomento ? "&pagina=1" : ""); ?>"><?php echo $infoArea["nombre"]; ?></a>
												</td>
												<td>
													<?php if(!$busquedaAvanzada || $palabrasClave == ""): ?>
														<span class="text-muted pull-xs-right" title="Remover filtro"><a href="trabajadores.php<?php echo ($filtroMomento ? "?momento=$filtroMomento&pagina=1" : "") . ($filtroMomento ? "&pagina=1" : ""); ?>"><i class="ion-close text-danger"></i></a></span>
													<?php endif ?>
												</td>
											</tr>
										<?php else: ?>
											<?php foreach($areas as $area): ?>
												<?php if($area["cantidad"] > 0): ?>
													<tr>
														<td>
															<a style="margin-left: 7px;" class="text-primary" href="trabajadores.php?area=<?php echo $area["amigable"] . ($filtroMomento ? "&momento=$filtroMomento&pagina=1" : ""); ?>&pagina=1"><span class="underline"><?php echo $area["nombre"]; ?></span></a>
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
							
							<div class="box bg-white">
								<div class="box-block clearfix">
									<h5 class="pull-xs-left"><i class="m-sm-r-1"></i> Edad</h5>
								</div>
								<table class="table m-md-b-0">
									<tbody>
										<?php
											$url = "trabajadores.php";
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
													<a class="text-primary" href="<?php echo ($url == 'trabajadores.php' ? "?momento=$filtroMomento" : "$url&momento=$filtroMomento&pagina=1"); ?>"><?php echo $infoMomento["nombre"]; ?><span class="underline"></span></a>
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
															<a class="text-primary" href="<?php echo ($url == 'trabajadores.php' ? "?momento=$momento[amigable]" : "$url&momento=$momento[amigable]"); ?>&pagina=1"><?php echo $momento["nombre"]; ?></a>
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
                            
						</div>
						
						<div class="col-md-9">

							<?php if($filtroActivado || $busqueda || $busquedaAvanzada): ?>
								<?php if($cantidadRegistros > 0): ?>
									<div class="row row-sm">
										<?php foreach($trabajadores as $trabajador): ?>										
												<div class="col-md-12">
													<a href="trabajador-detalle.php?t=<?php echo slug("$trabajador[nombres] $trabajador[apellidos]") . "-$trabajador[id]"; ?>">
														<div class="tra-f box box-block bg-white user-5">
															<div class="u-content" style="text-align: left;display: flex;">
																<div style="" class="avatar box-96">
																	<img class="b-a-radius-circle" src="img/<?php echo $trabajador["imagen"]; ?>" alt="" style="max-height: 90px;">
																</div>
																<div style="display: inline-block;padding-top: 25px;">
																	<h5 style="margin-bottom: -7px;margin-left: 7px;"><span class="text-black"><?php echo "$trabajador[nombres] $trabajador[apellidos]"; ?></span></h5>
																	<div style="font-size: 28px;display: flex;">
																		<?php if(is_numeric( $trabajador["calificacion_general"] ) && floor( $trabajador["calificacion_general"] ) != $trabajador["calificacion_general"]): ?>
																			<?php for($i = 0; $i < intval($trabajador["calificacion_general"]) - 1; $i++): ?>
																				<i class="ion-ios-star" style="padding-left: 3px;padding-right: 3px;padding-left: 3px;padding-right: 3px;color: #ffa200;"></i>
																			<?php endfor ?>
																			<i class="ion-ios-star-half" style="padding-left: 3px;padding-right: 3px;padding-left: 3px;padding-right: 3px;color: #ffa200;"></i>
																			<?php for($i = intval($trabajador["calificacion_general"]); $i < 5; $i++): ?>
																				<i class="ion-ios-star-outline" style="padding-left: 3px;padding-right: 3px;padding-left: 3px;padding-right: 3px;color: #ffa200;"></i>
																			<?php endfor ?>
																		<?php else: ?>
																			<?php for($i = 0; $i < intval($trabajador["calificacion_general"]); $i++): ?>
																				<i class="ion-ios-star" style="padding-left: 3px;padding-right: 3px;padding-left: 3px;padding-right: 3px;color: #ffa200;"></i>
																			<?php endfor ?>
																			<?php for($i = intval($trabajador["calificacion_general"]); $i < 5; $i++): ?>
																				<i class="ion-ios-star-outline" style="padding-left: 3px;padding-right: 3px;padding-left: 3px;padding-right: 3px;color: #ffa200;"></i>
																			<?php endfor ?>
																		<?php endif ?>
																	</div>
																</div>

															</div>
														</div>
													</a>
												</div>
										<?php endforeach ?>	
										</div>
								<?php else: ?>	
								<div class="alert alert-danger fade in" role="alert">
									<i class="ion-android-alert"></i> No hemos obtenido ningún resultado que se ajuste a tus criterios de búsqueda.
								</div>
								<?php endif ?>
							<?php else: ?>
								<div class="row row-sm">
									<?php foreach($trabajadores as $trabajador): ?>
										<div class="col-md-4">
											<a href="trabajador-detalle.php?t=<?php echo slug("$trabajador[nombres] $trabajador[apellidos]") . "-$trabajador[id]"; ?>">
												<div class="tra box box-block bg-white user-5">
													<div class="u-content">
														<div class="avatar box-96 m-b-2">
															<img class="b-a-radius-circle" src="img/<?php echo $trabajador["imagen"]; ?>" alt="" style="max-height: 90px;">
														</div>
														<h5><span class="text-black"><?php echo "$trabajador[nombres] $trabajador[apellidos]"; ?></span></h5>
														<div style="font-size: 28px;">
															<?php if(is_numeric( $trabajador["calificacion_general"] ) && floor( $trabajador["calificacion_general"] ) != $trabajador["calificacion_general"]): ?>
																<?php for($i = 0; $i < intval($trabajador["calificacion_general"]) - 1; $i++): ?>
																	<i class="ion-ios-star" style="padding-left: 3px;padding-right: 3px;padding-left: 3px;padding-right: 3px;color: #ffa200;"></i>
																<?php endfor ?>
																<i class="ion-ios-star-half" style="padding-left: 3px;padding-right: 3px;padding-left: 3px;padding-right: 3px;color: #ffa200;"></i>
																<?php for($i = intval($trabajador["calificacion_general"]); $i < 5; $i++): ?>
																	<i class="ion-ios-star-outline" style="padding-left: 3px;padding-right: 3px;padding-left: 3px;padding-right: 3px;color: #ffa200;"></i>
																<?php endfor ?>
															<?php else: ?>
																<?php for($i = 0; $i < intval($trabajador["calificacion_general"]); $i++): ?>
																	<i class="ion-ios-star" style="padding-left: 3px;padding-right: 3px;padding-left: 3px;padding-right: 3px;color: #ffa200;"></i>
																<?php endfor ?>
																<?php for($i = intval($trabajador["calificacion_general"]); $i < 5; $i++): ?>
																	<i class="ion-ios-star-outline" style="padding-left: 3px;padding-right: 3px;padding-left: 3px;padding-right: 3px;color: #ffa200;"></i>
																<?php endfor ?>
															<?php endif ?>
														</div>
													</div>
												</div>
											</a>
										</div>
									<?php endforeach ?>	
								</div>
							<?php endif ?>

							<?php if($cantidadRegistros > 0 && ($filtroActivado || $busqueda)): ?>
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
							<?php endif ?>

						</div>
					</div>

				</div>
				<?php require_once('includes/footer.php'); ?>
			</div>
		</div>

		<?php require_once('includes/libs-js.php'); ?>
		<script>
            
		</script>
	</body>
</html>