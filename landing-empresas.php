<?php
	session_start();
	require_once('classes/DatabasePDOInstance.function.php');
	$db = DatabasePDOInstance();
	$plataforma = $db->getRow("SELECT * FROM plataforma WHERE id=1");

	$planes = $db->getAll("SELECT * FROM planes WHERE id != 1");

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
		<title>JOBBERS - Empresas</title>
		<?php require_once('includes/libs-css.php'); ?>

		<!-- <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
		<script>
		  (adsbygoogle = window.adsbygoogle || []).push({
		    google_ad_client: "ca-pub-1968505410020323",
		    enable_page_level_ads: true
		  });
		</script> -->
	</head>
	<body class="large-sidebar fixed-sidebar fixed-header skin-5">
		<!-- <div class="wrapper"> -->

		<!-- Sidebar second -->
		<?php require_once('includes/sidebar-second.php'); ?>

		<!-- Header -->
		<?php require_once('includes/header.php'); ?>
			<div class="site-content bg-white" style="margin-left: 0px;">
				<!-- Content -->
				<!-- Portada -->
				<div class="content-area col-md-12" style="padding-right: 0px; padding-left:0px;background-image: url('img/back-min.jpg');background-size: cover; background-position: center; height: 91vh">
				<div class="overlay"></div>
					<div class="container animated fadeIn" id="title-landing">
					<div>
						<!-- <h1 class="main-title-landing">Bienvenidos a Jobbers!</h1> -->
						<h1 class="main-title-landing">Bienvenidos a Jobbers!</h1>
						  <h3 class="second-title-landing">¿Eres empresa?</h3>
						  <h3 class="second-title-landing">Entonces esta es tu zona, enterate de todo lo que te ofrecemos.</h3>
					</div>
					</div>
				</div>
				<!-- Planes -->
				<div class="content-area col-md-12 padding-content bg-white">
					<div class="container">
						<div class="margin-title-landing" style="margin-top: 0px;">
							<h2>Amplía tus beneficios!</h2>
							<h4>Dale mas notoriedad a tu empresa y contrata a los mejores Jobbers contratando alguno de nuestros planes hechos para ti.</h4>
						</div>
						<div class="col-md-6">
							<div id="carousel-example-generic" class="carousel slide round-borders" data-ride="carousel" style="border-radius: 16px">

								<!-- Wrapper for slides -->
								<div class="carousel-inner" style="border-radius: 16px" role="listbox">
									<!-- Item 1 -->
									<div class="item active">
										<div class="card price-card">
											<div class="card-header price-card-header bg-primary text-xs-center header-gold" style="width: 100%;height: 99px;">
												<h4 class="text-uppercase h4-price">Oro</h4>
												<h3 class="m-b-0 h3-price">
													<sup>$</sup>
													<span class="text-big" ><?php echo $planes[2]["precio"]; ?></span>
													<span class="text-small">/ mes</span>
												</h3>
											</div>
											<ul class="price-card-list p-l-0 m-b-0 price-list-gold" style="margin-bottom: 0px;">
												<li>
													<i class="fa fa-check text-success m-r-0-25"></i> <span class="text-price">35 días de publicación.</span>
												</li>
												<li>
													<i class="fa fa-check text-success m-r-0-25"></i> <span class="text-price">No tendras limites de descarga para CVs</span>
												</li>
												<li>
													<i class="fa fa-check text-success m-r-0-25"></i> <span class="text-price">Máxima visibilidad , volumen e imagen en todos tus avisos</span>
												</li>
												
												<li>
													<i class="fa fa-check text-success m-r-0-25"></i> <span class="text-price">Incluye logo corporativo tamaño grande en lugar preferencial.</span>
												</li>
												<li>
													<i class="fa fa-check text-success m-r-0-25"></i> <span class="text-price">Exposición en principal home.</span>
												</li>
												<li>
													<i class="fa fa-check text-success m-r-0-25"></i> <span class="text-price">Link de acceso a pagina de la empresa.</span>
												</li>
												
												<li>
													<i class="fa fa-check text-success m-r-0-25"></i> <span class="text-price">Ideal para reclutadoras o búsquedas de varios perfiles.</span>
												</li>
												<li>
													<i class="fa fa-check text-success m-r-0-25"></i> <span class="text-price">Filtros Personalizados.</span>
												</li>
												<li>
													<i class="fa fa-check text-success m-r-0-25"></i> <span class="text-price">Opcion de publicar un producto de venta o video institucional.</span>
												</li>
												
												<li>
													<i class="fa fa-check text-success m-r-0-25"></i> <span class="text-price">CHAT INTERNO CON CANDIDATOS.</span>
												</li>
											</ul>
										</div>
									</div>

									<!-- Item 2 -->
									<div class="item">
										<div class="card price-card">
											<div class="card-header price-card-header bg-primary text-xs-center header-silver" style="width: 100%;height: 99px;">
												<h4 class="text-uppercase h4-price">Plata</h4>
												<h3 class="m-b-0 h3-price">
													<sup>$</sup>
													<span class="text-big" ><?php echo $planes[1]["precio"]; ?></span>
													<span class="text-small">/ mes</span>
												</h3>
											</div>
											<ul class="price-card-list p-l-0 m-b-0 price-list-silver" style="margin-bottom: 0px;">
												<li>
													<i class="fa fa-check text-success m-r-0-25"></i> <span class="text-price">30 días de publicación.</span>
												</li>
												<li>
													<i class="fa fa-check text-success m-r-0-25"></i> <span class="text-price">100 CVs disponibles para descargar en un mes.</span>
												</li>
												<li>
													<i class="fa fa-check text-success m-r-0-25"></i> <span class="text-price">Opta por  mayor visibilidad en los avisos.</span>
												</li>
												<li>
													<i class="fa fa-check text-success m-r-0-25"></i> <span class="text-price">Incluye logo corporativo tamaño mediano en lugar privilegiado.</span>
												</li>
												<li>
													<i class="fa fa-check text-success m-r-0-25"></i> <span class="text-price">Buena Visibilidad en la home.</span>
												</li>
												<li>
													<i class="fa fa-check text-success m-r-0-25"></i> <span class="text-price">Link de acceso a pagina de la empresa.</span>
												</li>
												<li>
													<i class="fa fa-check text-success m-r-0-25"></i> <span class="text-price">Ideal para busqueda de perfiles habituales y específicos.</span>
												</li>
												<li>
													<i class="fa fa-remove text-danger m-r-0-25"></i> <span class="text-price">Filtros Personalizados.</span>
												</li>
						
												<li>
													<i class="fa fa-remove text-danger m-r-0-25"></i> <span class="text-price">Opcion de publicar un producto de venta o video institucional.</span>
												</li>
												<li>
													<i class="fa fa-remove text-danger m-r-0-25"></i> <span class="text-price">CHAT INTERNO CON CANDIDATOS.</span>
												</li>
											</ul>
										</div>
									</div>

									<!-- Item 3 -->
									<div class="item">
										<div class="card price-card">
											<div class="card-header price-card-header bg-primary text-xs-center header-bronce" style="width: 100%;height: 99px;">
												<h4 class="text-uppercase h4-price">Bronce</h4>
												<h3 class="m-b-0 h3-price">
													<sup>$</sup>
													<span class="text-big" ><?php echo $planes[0]["precio"]; ?></span>
													<span class="text-small">/ mes</span>
												</h3>
											</div>
											<ul class="price-card-list p-l-0 m-b-0 price-list-bronce" style="margin-bottom: 0px;">
												<li>
													<i class="fa fa-check text-success m-r-0-25"></i> <span class="text-price">30 días de publicación.</span>
												</li>
												<li>
													<i class="fa fa-check text-success m-r-0-25"></i> <span class="text-price">40 CVs disponibles para descargar en un mes.</span>
												</li>
												<li>
													<i class="fa fa-check text-success m-r-0-25"></i> <span class="text-price">Cubrí las vacantes de forma más economica.</span>
												</li>
												
												<li>
													<i class="fa fa-check text-success m-r-0-25"></i> <span class="text-price">Incluye logo corporativo tamaño pequeño en pantalla principal.</span>
												</li>
												<li>
													<i class="fa fa-check text-success m-r-0-25"></i> <span class="text-price">Visibilidad en la home</span>
												</li>
												<li>
													<i class="fa fa-remove text-danger m-r-0-25"></i> <span class="text-price">Link de acceso a pagina de la empresa.</span>
												</li>
												<li>
													<i class="fa fa-remove text-danger m-r-0-25"></i> <span class="text-price">Ideal para búsquedas de perfiles habituales.</span>
												</li>
												<li>
													<i class="fa fa-remove text-danger m-r-0-25"></i> <span class="text-price">Filtros Personalizados.</span>
												</li>
												<li>
													<i class="fa fa-remove text-danger m-r-0-25"></i> <span class="text-price">Opcion de publicar un producto de venta o video institucional.</span>
												</li>
												<li>
													<i class="fa fa-remove text-danger m-r-0-25"></i> <span class="text-price">CHAT INTERNO CON CANDIDATOS.</span>
												</li>
											</ul>
										</div>
									</div>

									<!-- Item 4 -->
									<div class="item">
										<div class="card price-card">
											<div class="card-header price-card-header  bg-primary text-xs-center header-free" style="width: 100%;height: 99px;">
												<h4 class="text-uppercase h4-price">Gratis</h4>
												<h3 class="m-b-0 h3-price">
													<sup>$</sup>
													<span class="text-big">0</span>
													<span class="text-small">/ 1 mes</span>
												</h3>
											</div>
											<ul class="price-card-list p-l-0 m-b-0 price-list-free" style="margin-bottom: 0px;">
												<li>
													<i class="fa fa-check text-success m-r-0-25"></i> <span class="text-price">15 días de publicacion</span>
												</li>
												<li>
													<i class="fa fa-check text-success m-r-0-25"></i> <span class="text-price">10 CVs disponibles para descargar en un mes.</span>
												</li>
												<li>
													<i class="fa fa-remove text-danger m-r-0-25"></i> <span class="text-price">Cubrí las vacantes de forma más economica.</span>
												</li>
												
												<li>
													<i class="fa fa-remove text-danger m-r-0-25"></i> <span class="text-price">Incluye logo corporativo tamaño pequeño en pantalla principal.</span>
												</li>
												<li>
													<i class="fa fa-remove text-danger m-r-0-25"></i> <span class="text-price">Visibilidad en la home</span>
												</li>
												<li>
													<i class="fa fa-remove text-danger m-r-0-25"></i> <span class="text-price"> Link de acceso a pagina de la empresa.</span>
												</li>
												<li>
													<i class="fa fa-remove text-danger m-r-0-25"></i> <span class="text-price">Ideal para búsquedas de perfiles habituales.</span>
												</li>
												<li>
													<i class="fa fa-remove text-danger m-r-0-25"></i> <span class="text-price">Filtros Personalizados.</span>
												</li>
												
												<li>
													<i class="fa fa-remove text-danger m-r-0-25"></i> <span class="text-price"> Opcion de publicar un producto de venta o video institucional.</span>
												</li>
												<li>
													<i class="fa fa-remove text-danger m-r-0-25"></i> <span class="text-price">CHAT INTERNO CON CANDIDATOS.</span>
												</li>
											</ul>
										</div>
									</div>
								</div>

		  						<!-- Controles -->
								<a class="left carousel-control" style="border-top-left-radius: 16px; border-bottom-left-radius: 16px;" href="#carousel-example-generic" role="button" data-slide="prev">
									<span class="fa fa-chevron-left" aria-hidden="true" style="position: absolute; top: 50%"></span>
									<span class="sr-only">Previous</span>
								</a>
								<a class="right carousel-control" style="border-top-right-radius: 16px; border-bottom-right-radius: 16px;" href="#carousel-example-generic" role="button" data-slide="next">
									<span class="fa fa-chevron-right" aria-hidden="true" style="position: absolute; top: 50%"></span>
									<span class="sr-only">Next</span>
								</a>
							</div>
						</div>	

						<div class="col-md-6">
		  					<div style="margin-top: 6vh">
								<h3 class="text-center">Si quieres saber mas acerca de nuestros planes y de como contratarlos.</h3>
								<h3 class="text-center" style="margin-bottom: 40px;">No dudes en comunicarte con nosotros a traves de nuestros distintos medios de comunicación:</h3>
								<ul style="list-style: none">
									<li><h4 style="margin-bottom: 20px;"><i class="fa fa-envelope-o" style="margin-right: 5px;"></i> <?= $plataforma["correo_contacto"] ?></h4></li>
									<li><h4 style="margin-bottom: 20px;"><i class="fa fa-phone" style="margin-right: 5px;"></i> <?= $plataforma["telefono_contacto"] ?></h4></li>
									<li><h4 style="margin-bottom: 40px;"><i class="fa fa-home" style="margin-right: 5px;"></i> <?= $plataforma["direccion_contacto"] ?></h4></li>
								</ul>
								<h3 class="text-center">O puedes abrir una consulta ingresando en nuestra página de contacto haciendo click <a href="https://www.jobbersargentina.com/contacto.php">Aquí</a></h3>
							</div>
						</div>
					</div>	
				</div>
				<!-- Por que elegirnos -->
				<div class="content-area col-md-12 padding-content" style="background-color: rgba(216, 216, 216, 0.6);">
					<div class="container text-center">
						<h2 class="margin-title-landing" style="margin-top: 0px;">¿Por qué somos tu mejor opción?</h2>

						<div class="col-md-4 fadeInUp" style="margin-bottom: 30px;">
							<i class="fa fa-globe" style="font-size: 75px; margin-bottom: 30px; color: #2E3192"></i>
							<p style="color: #03A7E9; font-weight: bolder"><?= $plataforma["section1_landing"] ?> </p>
						</div>
						<div class="col-md-4 fadeInUp">
							<i class="fa fa-group" style="font-size: 75px; margin-bottom: 30px; color: #2E3192"></i>
							<p style="color: #03A7E9; font-weight: bolder"><?= $plataforma["section2_landing"] ?> </p>
						</div>
						<div class="col-md-4 fadeInUp">
							<i class="fa fa-mortar-board" style="font-size: 75px; margin-bottom: 30px; color: #2E3192"></i>
							<?php 
								$caracteristicas = explode(",", $plataforma["section3_landing"]);
							?>
							<ul style="list-style: none; padding-left: 0px; color: #03A7E9; font-weight: bolder">
							<?php foreach($caracteristicas as $caracteristica): ?>
								<li><?= trim($caracteristica) ?></li>
							<?php endforeach; ?>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-12 bg-white" style="padding-top: 40px;">
				<?php require_once('includes/footer.php'); ?>
			</div>
		<!-- </div> -->
		<?php require_once('includes/libs-js.php'); ?>
	</body>
</html>