<?php
	session_start();
	require_once('../classes/DatabasePDOInstance.function.php');
	require_once('../slug.function.php');

	$db = DatabasePDOInstance();

	$a = isset($_REQUEST["a"]) ? $_REQUEST["a"] : false;
	$s = isset($_REQUEST["s"]) ? $_REQUEST["s"] : false;
	$p = isset($_REQUEST["p"]) ? $_REQUEST["p"] : false;
	$t = isset($_REQUEST["t"]) ? $_REQUEST["t"] : false;

	$publicacion = $db->getRow("
		SELECT
			p.id,
			p.titulo,
			p.descripcion,
			p.fecha_creacion,
			p.amigable,
			e.nombre AS empresa_nombre,
			e.sitio_web,
			e.facebook,
			e.twitter,
			e.instagram,
			a.id AS area_id,
			a.nombre AS area_nombre,
			a.amigable AS area_amigable,
			ase.id AS sector_id,
			pl.link_empresa,
			ase.amigable AS sector_amigable,
			ase.nombre AS sector_nombre
		FROM
			publicaciones AS p
		INNER JOIN publicaciones_sectores AS ps ON p.id = ps.id_publicacion
		INNER JOIN areas_sectores AS ase ON ps.id_sector = ase.id
		INNER JOIN areas AS a ON ase.id_area = a.id
		INNER JOIN empresas AS e ON p.id_empresa = e.id
		INNER JOIN empresas_planes AS pl ON p.id_empresa = pl.id_empresa
		WHERE p.amigable = '$p' AND a.amigable = '$a' AND ase.amigable = '$s'
	");

	if($t) {
		$t = array_pop(explode("-", $t));
	}

	$trabajador = $db->getRow("
		SELECT
			tra.id,
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
			tra.sitio_web,
			tra.facebook,
			tra.twitter,
			tra.instagram,
			tra.snapchat
		FROM
			trabajadores AS tra
		LEFT JOIN imagenes AS img ON tra.id_imagen = img.id
		WHERE tra.id = $t
	");

	if(!$trabajador["imagen"]) {
		$trabajador["imagen"] = "avatars/user.png";
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
		<title>JOBBERS - Contratar a <?php echo "$trabajador[nombres] $trabajador[apellidos]"; ?></title>
		<?php require_once('../includes/libs-css.php'); ?>
		<link rel="stylesheet" href="../vendor/ionicons/css/ionicons.min.css">
		<link rel="stylesheet" href="../vendor/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
		<link rel="stylesheet" href="../vendor/bootstrap-daterangepicker/daterangepicker.css">

		<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
		<script>
		  (adsbygoogle = window.adsbygoogle || []).push({
		    google_ad_client: "ca-pub-1968505410020323",
		    enable_page_level_ads: true
		  });
		</script>
	</head>
	<body class="large-sidebar fixed-sidebar fixed-header skin-5">
		<div class="wrapper" style="background-color: white;">
			<!-- Sidebar -->
			<?php require_once('../includes/sidebar.php'); ?>

			<!-- Sidebar second -->
			<?php require_once('../includes/sidebar-second.php'); ?>

			<!-- Header -->
			<?php require_once('../includes/header.php'); ?>
			<div class="site-content bg-white">
				<!-- Content -->
				<div class="content-area p-b-1">
				
					<br>
				
					<div class="container-fluid">
						<div class="col-md-8">
							<div class="card profile-card" style="margin-top: 0px;">
								<div class="card-header text-uppercase"><b>Detalles de la contratación</b></div>
								<div class="box-block">
									<h5>Información del empleo</h5>
									<form class="m-b-1">
										<div class="form-group row m-b-0">
											<label class="col-sm-3 col-form-label">Título</label>
											<div class="col-sm-9">
												<p class="form-control-static"><a href="../empleos-detalle.php?a=<?php echo $publicacion["area_amigable"]; ?>&s=<?php echo $publicacion["sector_amigable"]; ?>&p=<?php echo $publicacion["amigable"]; ?>" target="_blank"><?php echo $publicacion["titulo"]; ?></a></p>
											</div>
										</div>
										<div class="form-group row m-b-0">
											<label class="col-sm-3 col-form-label">Área</label>
											<div class="col-sm-9">
												<p class="form-control-static"><?php echo $publicacion["area_nombre"]; ?></p>
											</div>
										</div>
										<div class="form-group row m-b-0">
											<label class="col-sm-3 col-form-label">Sector</label>
											<div class="col-sm-9">
												<p class="form-control-static"><?php echo $publicacion["sector_nombre"]; ?></p>
											</div>
										</div>
										<div class="form-group row m-b-0">
											<label class="col-sm-3 col-form-label">Fecha de publicación</label>
											<div class="col-sm-9">
												<p class="form-control-static"><?php echo date('d/m/Y h:i:s A', strtotime($publicacion["fecha_creacion"])); ?></p>
											</div>
										</div>
										<button type="button" class="btn btn-primary w-min-sm m-b-0-25 waves-effect waves-light" style="top: 10px;" id="continue">Continuar</button>
									</form>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="card profile-card" style="margin-top: 0px;">
								<div class="card-header text-uppercase"><b>Información del trabajador</b></div>
								<div class="profile-avatar" style="text-align: center;margin-top: 15px;">
										<a href="../trabajador-detalle.php?t=<?php echo slug("$trabajador[nombres] $trabajador[apellidos]") . "-$trabajador[id]"; ?>">
											<img src="../img/<?php echo $trabajador["imagen"]; ?>" alt="" style="width: 130px;">
										</a>
									</div>
									<div class="card-block" style="text-align: center;">
										<h5 style="margin-bottom: -5px;"><a href="../trabajador-detalle.php?t=<?php echo slug("$trabajador[nombres] $trabajador[apellidos]") . "-$trabajador[id]"; ?>"><?php echo "$trabajador[nombres] $trabajador[apellidos]"; ?></a></h5>
										<div style="font-size: 28px;margin-bottom: 5px;">
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
									
									<?php if($trabajador["sitio_web"] || $trabajador["facebook"] || $trabajador["twitter"] || $trabajador["instagram"] || $trabajador["snapchat"]): ?>									
										<?php if($trabajador["sitio_web"]): ?>
											<a class="list-group-item" href="#">
												<i class="ti-world m-r-0-5"></i> <?php echo $trabajador["sitio_web"]; ?>
											</a>
										<?php endif ?>
										
										<?php if($trabajador["facebook"]): ?>
											<a class="list-group-item" href="#">
												<i class="ti-facebook m-r-0-5"></i> <?php echo $trabajador["facebook"]; ?>
											</a>
										<?php endif ?>										
										
										<?php if($trabajador["twitter"]): ?>
											<a class="list-group-item" href="#">
												<i class="ti-twitter m-r-0-5"></i> <?php echo $trabajador["twitter"]; ?>
											</a>
										<?php endif ?>									
										
										<?php if($trabajador["instagram"]): ?>
											<a class="list-group-item" href="#">
												<i class="ti-instagram m-r-0-5"></i> <?php echo $trabajador["instagram"]; ?>
											</a>
										<?php endif ?>								
										
										<?php if($trabajador["snapchat"]): ?>
											<a class="list-group-item" href="#">
												<i class="ion-social-snapchat m-r-0-5"></i> <?php echo $trabajador["snapchat"]; ?>
											</a>
										<?php endif ?>
									<?php endif ?>
							</div>
						</div>
					</div>
				</div>
				<?php require_once('../includes/footer.php'); ?>
			</div>
		</div>

		<?php require_once('../includes/libs-js.php'); ?>
		<script type="text/javascript" src="../vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
		<script type="text/javascript" src="../vendor/moment/moment.js"></script>
		<script type="text/javascript" src="../vendor/bootstrap-daterangepicker/daterangepicker.js"></script>
		
		<script>
			var ip = <?php echo $publicacion["id"]; ?>;
			$(function() {				
				$("#continue").click(function() {
					$(this).attr("disabled", true);
					$.ajax({
						type: 'POST',
						url: 'ajax/empresas.php',
						data: 'op=10&ip=' + ip,
						dataType: 'json',
						success: function(data) {
							console.log(data);
							swal({
								title: 'Información!',
								text: 'Contrato realizado satisfactoriamente! sera redireccionado en unos segundos.',
								confirmButtonClass: 'btn btn-primary btn-lg',
								buttonsStyling: false
							});
							setTimeout(function() {
								window.location.assign("contrataciones.php");
							}, 2000);
						}
					});
				});
			});
		</script>
	</body>
</html>