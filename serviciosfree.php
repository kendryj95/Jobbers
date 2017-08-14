<?php
	session_start();
	require_once('classes/DatabasePDOInstance.function.php');
	require_once('slug.function.php');

	$db = DatabasePDOInstance();

	$servicios = $db->getAll("SELECT trabajadores_publicaciones.*, trabajadores.*, CONCAT(imagenes.directorio,'/', imagenes.id,'.', imagenes.extension) AS imagen FROM trabajadores_publicaciones INNER JOIN trabajadores ON trabajadores.id = trabajadores_publicaciones.id_trabajador LEFT JOIN imagenes ON imagenes.id = trabajadores.id_imagen");
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
				
					<div class="container-fluid" style="margin-top: 35px;">
						<div class="col-md-2"></div>
						<div class="col-md-8 col-xs-12">
							<h5 class="m-b-1">Servicios freelance</h5>
							<div class="row row-sm">
								<?php foreach($servicios as $trabajador): ?>										
										<div class="col-md-12">
											<a href="trabajador-detalle.php?t=<?php echo slug("$trabajador[nombres] $trabajador[apellidos]") . "-$trabajador[id]"; ?>">
												<div class="tra-f box box-block bg-white user-5">
													<div class="u-content" style="text-align: left;display: flex;">
														<div style="margin-right: 11px;" class="avatar box-96">
															<img class="b-a-radius-circle" src="img/<?php echo $trabajador["imagen"]; ?>" alt="" style="max-height: 90px;height: 100%;">
														</div>
														<div style="display: inline-block;padding-top: 25px;">
															<h5 style="margin-bottom: 0px;margin-left: 7px;"><span class="text-black"><?php echo "$trabajador[nombres] $trabajador[apellidos] - $trabajador[titulo]"; ?></span></h5>
															<div style="font-size: 28px;display: flex;">
																<?php echo strlen($trabajador["descripcion"]) > 30 ? (substr($trabajador["descripcion"], 0 , 29)."...") : $trabajador["descripcion"]; ?>
															</div>
														</div>

													</div>
												</div>
											</a>
										</div>
								<?php endforeach ?>	
							</div>
							<div class="col-md-2"></div>
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