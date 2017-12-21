<?php
	session_start();
	require_once('classes/DatabasePDOInstance.function.php');
	$db = DatabasePDOInstance();
	$contenido = $db->getOne("SELECT nosotros FROM plataforma WHERE id=1");
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
		<title>JOBBER - Nosotros</title>
		<?php require_once('includes/libs-css.php'); ?>

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

		<!-- Sidebar second -->
		<?php require_once('includes/sidebar-second.php'); ?>

		<!-- Header -->
		<?php require_once('includes/header.php'); ?>
			<div class="site-content bg-white" style="margin-left: 0px;">
				<!-- Content -->
				<div class="content-area">
					<div class="container">
						<h4>Nosotros</h4>
						<ol class="breadcrumb no-bg m-b-1">
							<li class="breadcrumb-item"><a href="./">Inicio</a></li>
							<li class="breadcrumb-item active">Nosotros</li>
						</ol>
						<div class="box bg-white">
							<div class="row m-b-0 m-md-b-1">
								<div class="col-md-12">
									<div class="p-30">
										<h4 class="m-b-1">Nuestra empresa</h4>
										<?php echo $contenido; ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php require_once('includes/footer.php'); ?>
			</div>
		<!-- </div> -->
		<?php require_once('includes/libs-js.php'); ?>
	</body>
</html>