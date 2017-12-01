<?php
	session_start();
	
	if(!isset($_SESSION["ctc"]["empresa"])) {
		header('Location: acceder.php');
	}

	require_once('../classes/DatabasePDOInstance.function.php');

	$db = DatabasePDOInstance();

	$infoEmpresa = $_SESSION["ctc"]["empresa"];

    $publicaciones = array();
    $publicaciones["data"] = array();

    $plan = $db->getRow("SELECT ep.id_plan, p.nombre FROM empresas_planes ep INNER JOIN planes p ON ep.id_plan = p.id WHERE ep.id_empresa=".$_SESSION['ctc']['empresa']['id']);

    if ($_SESSION['ctc']['type'] == 1) {
        $_SESSION['ctc']['plan']['id_plan'] = $plan['id_plan'];
        $_SESSION["ctc"]["plan"]["nombre"] = $plan['nombre'];
    }

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

				if($datos) {
					$datos = array_reverse($datos);
					foreach($datos as $k => $pub) {
						$pub["link_postulados"] = $pub["postulados"] > 0 ? ('<a class="text-primary" href="javascript: void(0);" data-toggle="modal" data-target="#modal-postulados" data-id="' . $pub["id"] . '"><span class="underline">' . $pub["postulados"] . ' trabajador(es)</span></a>') : "";

						$fecha_creac_pub = date('d/m/Y', strtotime($pub["fecha_creacion"]));
						$fecha_final_pub = '&#x221e;';

						switch ($_SESSION['ctc']['plan']['id_plan']){ // Planes
							case 1: // Plan Gratis
								$timestamp_final = strtotime("+15 day", strtotime($pub["fecha_creacion"]));
								$fecha_final_pub = date('d/m/Y', $timestamp_final);

								$timestamp_today = strtotime(date('Y-m-d'));

								if ($timestamp_today <= $timestamp_final) {
									$publicaciones["data"][] = array(
										$k + 1,
										$pub["titulo"],
										$pub["descripcion"],
										$pub["link_postulados"],
										$fecha_creac_pub,
										$fecha_final_pub,
										'<div class="acciones-publicacion" data-target="' . $pub["id"] . '"> <a class="accion-publicacion btn btn-success waves-effect waves-light" title="Previsualizar publicación" href="../empleos-detalle.php?a=' . $pub["area_amigable"] . '&s=' . $pub["sector_amigable"] . '&p=' . $pub["amigable"] . '" target="_blank"><span class="ti-eye"></span></a> <button type="button" class="accion-publicacion btn btn-primary waves-effect waves-light" onclick="modificarPublicacion(this);" title="Modificar publicación"><span class="ti-pencil"></span></button> <button type="button" class="accion-publicacion btn btn-danger waves-effect waves-light" title="Eliminar publicación" onclick="eliminarPublicacion(this);"><span class="ti-close"></span></button> </div>',
									);
								}
								break;
							case 2: // Plan Bronce
								$timestamp_final = strtotime("+30 day", strtotime($pub["fecha_creacion"]));
								$fecha_final_pub = date('d/m/Y', $timestamp_final);

								$timestamp_today = strtotime(date('Y-m-d'));

								if ($timestamp_today <= $timestamp_final) {
									$publicaciones["data"][] = array(
										$k + 1,
										$pub["titulo"],
										$pub["descripcion"],
										$pub["link_postulados"],
										$fecha_creac_pub,
										$fecha_final_pub,
										'<div class="acciones-publicacion" data-target="' . $pub["id"] . '"> <a class="accion-publicacion btn btn-success waves-effect waves-light" title="Previsualizar publicación" href="../empleos-detalle.php?a=' . $pub["area_amigable"] . '&s=' . $pub["sector_amigable"] . '&p=' . $pub["amigable"] . '" target="_blank"><span class="ti-eye"></span></a> <button type="button" class="accion-publicacion btn btn-primary waves-effect waves-light" onclick="modificarPublicacion(this);" title="Modificar publicación"><span class="ti-pencil"></span></button> <button type="button" class="accion-publicacion btn btn-danger waves-effect waves-light" title="Eliminar publicación" onclick="eliminarPublicacion(this);"><span class="ti-close"></span></button> </div>',
									);
								}
								break;
							case 3:
								$timestamp_final = strtotime("+30 day", strtotime($pub["fecha_creacion"]));
								$fecha_final_pub = date('d/m/Y', $timestamp_final);

								$timestamp_today = strtotime(date('Y-m-d'));

								if ($timestamp_today <= $timestamp_final) {
									$publicaciones["data"][] = array(
										$k + 1,
										$pub["titulo"],
										$pub["descripcion"],
										$pub["link_postulados"],
										$fecha_creac_pub,
										$fecha_final_pub,
										'<div class="acciones-publicacion" data-target="' . $pub["id"] . '"> <a class="accion-publicacion btn btn-success waves-effect waves-light" title="Previsualizar publicación" href="../empleos-detalle.php?a=' . $pub["area_amigable"] . '&s=' . $pub["sector_amigable"] . '&p=' . $pub["amigable"] . '" target="_blank"><span class="ti-eye"></span></a> <button type="button" class="accion-publicacion btn btn-primary waves-effect waves-light" onclick="modificarPublicacion(this);" title="Modificar publicación"><span class="ti-pencil"></span></button> <button type="button" class="accion-publicacion btn btn-danger waves-effect waves-light" title="Eliminar publicación" onclick="eliminarPublicacion(this);"><span class="ti-close"></span></button> </div>',
									);
								}
								break;	
							default: // Plan Oro
								$publicaciones["data"][] = array(
									$k + 1,
									$pub["titulo"],
									$pub["descripcion"],
									$pub["link_postulados"],
									$fecha_creac_pub,
									$fecha_final_pub,
									'<div class="acciones-publicacion" data-target="' . $pub["id"] . '"> <a class="accion-publicacion btn btn-success waves-effect waves-light" title="Previsualizar publicación" href="../empleos-detalle.php?a=' . $pub["area_amigable"] . '&s=' . $pub["sector_amigable"] . '&p=' . $pub["amigable"] . '" target="_blank"><span class="ti-eye"></span></a> <button type="button" class="accion-publicacion btn btn-primary waves-effect waves-light" onclick="modificarPublicacion(this);" title="Modificar publicación"><span class="ti-pencil"></span></button> <button type="button" class="accion-publicacion btn btn-danger waves-effect waves-light" title="Eliminar publicación" onclick="eliminarPublicacion(this);"><span class="ti-close"></span></button> </div>',
								);
								break;
						}


					}
				}

    $cantidadPublicaciones = count($publicaciones['data']) == 0 ? 0 : count($publicaciones['data']);

	/*$cantidadPublicaciones = $db->getOne("
		SELECT
			COUNT(*)
		FROM
			publicaciones
		WHERE
			id_empresa = $infoEmpresa[id]
	");*/
	$cantidadContrataciones = $db->getOne("
		SELECT
			COUNT(*)
		FROM
			empresas_contrataciones
		WHERE
			id_empresa = $infoEmpresa[id]
	");
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
	<title>JOBBERS - Panel</title>
	<?php require_once("../includes/libs-css.php"); ?>
</head>

<body class="large-sidebar fixed-sidebar fixed-header skin-5">
	<div class="wrapper">

		<!-- Preloader -->
		<div class="preloader"></div>

		<!-- Sidebar -->
		<?php require_once('../includes/sidebar.php'); ?>

		<!-- Sidebar second -->
		<?php require_once('../includes/sidebar-second.php'); ?>

		<!-- Header -->
		<?php require_once('../includes/header.php'); ?>

		<div class="site-content">
			<!-- Content -->
			<div class="content-area" style="padding-top: 30px;">
				<div class="container-fluid">
					<div class="row row-md">
						<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
							<a href="publicaciones.php">
								<div class="box box-block tile tile-2 bg-success m-b-2">
									<div class="t-icon right"><span class="bg-success"></span><i class="ti-folder"></i></div>
									<div class="t-content">
										<h6 class="text-uppercase m-b-1">Publicaciones</h6>
										<h1 class="m-b-1"><?php echo $cantidadPublicaciones; ?></h1>
									</div>
								</div>
							</a>
						</div>
						<!--<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
							<a href="contrataciones.php">
								<div class="box box-block tile tile-2 bg-success m-b-2">
									<div class="t-icon right"><span class="bg-success"></span><i class="ti-folder"></i></div>
									<div class="t-content">
										<h6 class="text-uppercase m-b-1">Jobbers seleccionados</h6>
										<h1 class="m-b-1">< ?php echo $cantidadContrataciones; ?></h1>
									</div>
								</div>
							</a>
						</div>-->
						<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
							<a href="perfil.php">
								<div class="box box-block tile tile-2 bg-success m-b-2">
									<div class="t-icon right"><span class="bg-success"></span><i class="ti-folder"></i></div>
									<div class="t-content">
										<h6 class="text-uppercase m-b-1">Ver mi perfil</h6>
										<h1 class="m-b-1" style="color: #43b968;">0</h1>
									</div>
								</div>
							</a>
						</div>
						<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
							<a href="../trabajadores.php">
								<div class="box box-block tile tile-2 bg-success m-b-2">
									<div class="t-icon right"><span class="bg-success"></span><i class="ti-folder"></i></div>
									<div class="t-content">
										<h6 class="text-uppercase m-b-1">Ver jobbers</h6>
										<h1 class="m-b-1" style="color: #43b968;">0</h1>
									</div>
								</div>
							</a>
						</div>
						<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
							<a href="../serviciosfree.php">
								<div class="box box-block tile tile-2 bg-success m-b-2">
									<div class="t-icon right"><span class="bg-success"></span><i class="ti-folder"></i></div>
									<div class="t-content">
										<h6 class="text-uppercase m-b-1">Ver servicios freelance</h6>
										<h1 class="m-b-1" style="color: #43b968;">0</h1>
									</div>
								</div>
							</a>
						</div>
						<!--
						<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
							<div class="box box-block tile tile-2 bg-warning m-b-2">
								<div class="t-icon right"><span class="bg-primary"></span><i class="ti-user"></i></div>
								<div class="t-content">
									<h6 class="text-uppercase m-b-1">Postulados</h6>
									<h1 class="m-b-1">9</h1>
								</div>
							</div>
						</div>
						-->
					</div>
				</div>
			</div>
			<!-- Footer -->
			<?php require_once('../includes/footer.php'); ?>
		</div>
	</div>

	<?php require_once("../includes/libs-js.php"); ?>

	<script>
		<?php if($_SESSION["ctc"]["type"] == 1):
				if(!isset($_SESSION["ctc"]["msg"])) {
					if($_SESSION["ctc"]["plan"]["id_plan"] != 4) {
						?>
							swal({
								title: 'Actualiza tu plan a ORO',
								text: "Y disfurta de los beneficios de estar en la pantalla principal con todas las opciones además de la funcionalidad de promocionar un producto de venta o video. Qué desea hacer?",
								type: 'warning',
								showCancelButton: true,
								confirmButtonColor: '#3085d6',
								cancelButtonColor: '#d33',
								confirmButtonText: 'Ir a mis planes',
								cancelButtonText: 'Decidir después',
								confirmButtonClass: 'btn btn-primary btn-lg m-r-1',
								cancelButtonClass: 'btn btn-danger btn-lg',
								buttonsStyling: false
								}).then(function(isConfirm) {
								if (isConfirm === true) {
									window.location.assign("planes.php?pay=true");
								}
							});
						<?php
						$_SESSION["ctc"]["msg"] = 1;
					}
				}
			if($_SESSION["ctc"]["plan"]["id_plan"] > 1):
				$_SESSION["ctc"]["venc"] = 0;
				$fecha = strtotime(date('Y-m-d'));
				$fecha2 = strtotime($_SESSION["ctc"]["plan"]["fecha_plan"]);
				$min = 60;
				$hora = 60*$min;
				$dia = 24*$hora;
				$dias = floor($fecha2/$dia) - floor($fecha/$dia);
				if($dias <= 7 && $dias >= 0):
				?>
				var plan_time_f = JSON.parse('<?php echo json_encode(date('d/m/Y', strtotime($_SESSION["ctc"]["plan"]["fecha_plan"]))); ?>');
				swal({
					title: 'Su plan esta proximo a vencer!',
					text: "Fecha de vencimiento: <strong>"+plan_time_f+"</strong><br>Le recomendamos que realice el pago de su plan a tiempo, de lo contrario regresara al plan gratis perdiendo todos los beneficios. Qué desea hacer?",
					type: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Ir a pagos',
					cancelButtonText: 'Decidir después',
					confirmButtonClass: 'btn btn-primary btn-lg m-r-1',
					cancelButtonClass: 'btn btn-danger btn-lg',
					buttonsStyling: false
					}).then(function(isConfirm) {
					if (isConfirm === true) {
						window.location.assign("planes.php?pay=true");
					}
				});
				<?php else: ?>
					<?php if($dias < 0): ?>
						$.ajax({
							type: 'POST',
							url: 'ajax/empresas.php',
							data: 'op=7',
							dataType: 'json',
							success: function(data) {
								if(data.status == 1) {
									window.location.assign("./");
								}
							}
						});
					<?php endif ?>
				<?php endif ?>
			<?php endif ?>
		<?php endif ?>
	</script>

</body>

</html>