<?php
	session_start();
	require_once('classes/DatabasePDOInstance.function.php');
	$db = DatabasePDOInstance();
	$contenido = $db->getOne("SELECT terminos FROM plataforma WHERE id=1");
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
		<title>JOBBERS - Políticas de privacidad</title>
		<?php require_once('includes/libs-css.php'); ?>
	</head>
	<body class="large-sidebar fixed-sidebar fixed-header skin-5">
		<div class="wrapper">
		<!-- Sidebar -->
		<?php require_once('includes/sidebar.php'); ?>

		<!-- Sidebar second -->
		<?php require_once('includes/sidebar-second.php'); ?>

		<!-- Header -->
		<?php require_once('includes/header.php'); ?>
			<div class="site-content">
				<!-- Content -->
				<div class="content-area p-y-1">
					<div class="container-fluid">
						<h4>Políticas de privacidad</h4>
						<ol class="breadcrumb no-bg m-b-1">
							<li class="breadcrumb-item"><a href="./">Inicio</a></li>
							<li class="breadcrumb-item active">Términos y condiciones</li>
						</ol>
						<div class="box bg-white">
							<div class="row m-b-0 m-md-b-1">
								<div class="col-md-9">
									<div class="box-block">
										<h5 class="m-b-1">Términos y condiciones</h5>
										<?php echo $contenido; ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php require_once('includes/footer.php'); ?>
			</div>
		</div>
		<?php require_once('includes/libs-js.php'); ?>
	</body>
</html>