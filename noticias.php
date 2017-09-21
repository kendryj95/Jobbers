<?php
session_start();
require_once('classes/DatabasePDOInstance.function.php');
require_once('slug.function.php');

$db = DatabasePDOInstance();
if(isset($_REQUEST["n"])) {
	if($_REQUEST["n"] == "populares") {
		$noticias = $db->getAll("
			SELECT
			noticias.*,
			categorias.nombre,
			CONCAT(imagenes.directorio,'/',imagenes.nombre,'.', imagenes.extension) AS imagen
			FROM
			noticias
			LEFT JOIN
			categorias
			ON
			categorias.id = noticias.id_categoria
			INNER JOIN
			imagenes
			ON
			imagenes.id = noticias.id_imagen
			ORDER BY
			veces_leido
			DESC
			");
	}
	else {
		$n = array_pop(explode("-", $_REQUEST["n"]));
		$noticia = $db->getRow("
			SELECT
			noticias.*,
			categorias.id AS id_cat,
			categorias.nombre,
			CONCAT(imagenes.directorio,'/',imagenes.nombre,'.', imagenes.extension) AS imagen
			FROM
			noticias
			LEFT JOIN
			categorias
			ON
			categorias.id = noticias.id_categoria
			INNER JOIN
			imagenes
			ON
			imagenes.id = noticias.id_imagen
			WHERE
			noticias.id = $n
			");
		$db->query("UPDATE noticias SET veces_leido='".($noticia["veces_leido"] + 1)."' WHERE id=$n");
	}
}
else {
	$noticias = $db->getAll("
		SELECT
		noticias.*,
		categorias.nombre,
		CONCAT(imagenes.directorio,'/',imagenes.nombre,'.', imagenes.extension) AS imagen
		FROM
		noticias
		LEFT JOIN
		categorias
		ON
		categorias.id = noticias.id_categoria
		INNER JOIN
		imagenes
		ON
		imagenes.id = noticias.id_imagen
		ORDER BY noticias.fecha_creacion DESC
		");
}

$noticiasPopulares = $db->getAll("
	SELECT
	noticias.*,
	categorias.nombre,
	CONCAT(imagenes.directorio,'/',imagenes.nombre,'.', imagenes.extension) AS imagen
	FROM
	noticias
	LEFT JOIN
	categorias
	ON
	categorias.id = noticias.id_categoria
	INNER JOIN
	imagenes
	ON
	imagenes.id = noticias.id_imagen
	ORDER BY
	veces_leido
	DESC
	LIMIT 5
	");

$categorias = $db->getAll("SELECT * FROM categorias ORDER BY RAND() LIMIT 5");
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
	<title>JOBBERS - Noticias <?php echo isset($_REQUEST["n"]) ? "- $noticia[titulo]" : ""; ?></title>
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
		<div class="site-content bg-white">
			<!-- Content -->
			<div class="content-area p-y-1">
				<div class="container-fluid">
					<h4>Noticias</h4>
					<ol class="breadcrumb no-bg m-b-1">
						<li class="breadcrumb-item"><a href="./">inicio</a></li>
						<?php if(isset($_REQUEST["n"])): ?>
							<?php if($_REQUEST["n"] == "populares"): ?>
								<li class="breadcrumb-item"><a href="noticias.php">Noticias</a></li>
								<li class="breadcrumb-item active">Populares</li>
							<?php else: ?>
								<li class="breadcrumb-item"><a href="noticias.php">Noticias</a></li>
								<li class="breadcrumb-item"><a href="categorias.php?c=<?php echo $noticia["nombre"] == "" ? "Sin-categoria-0" : "$noticia[nombre]-$noticia[id_cat]"; ?>"><?php echo ($noticia["nombre"] == "" ? "Sin categoría" : $noticia["nombre"]); ?></a></li>
								<li class="breadcrumb-item active"><?php echo $noticia["titulo"]; ?></li>
							<?php endif ?>
						<?php else: ?>
							<li class="breadcrumb-item active">Noticias</li>
						<?php endif ?>
					</ol>
					<div class="row m-b-0 m-md-b-1">
						<div class="col-md-9">
							<div class="row m-b-0 m-md-b-1">
								<?php if(isset($_REQUEST["n"])): ?>
									<?php if($_REQUEST["n"] == "populares"): ?>
										<div class="card">
											<div class="card-header text-uppercase"><b>Noticias populares</b></div>
											<div class="posts-list posts-list-1">
												<?php foreach($noticias as $n): ?>
													<div class="pl-item">
														<div class="media">
															<div class="media-left">
																<a href="noticias.php?n=<?php echo "$n[amigable]-$n[id]"; ?>">
																	<div class="pli-img">
																		<img class="img-fluid" src="img/<?php echo $n["imagen"]; ?>">
																		<!--<div class="tag tag-warning">Lifestyle</div>-->
																	</div>
																</a>
															</div>
															<div class="media-body">
																<div class="pli-content">
																	<h5><a class="text-black" href="noticias.php?n=<?php echo "$n[amigable]-$n[id]"; ?>"><?php echo $n["titulo"]; ?></a></h5>
																	<p class="m-b-0-5"><?php echo strlen($n["descripcion"]) > 100 ? (substr(0, 100, $n["descripcion"])."...") : $n["descripcion"]; ?></p>
																	<div class="clearfix">
																		<div class="pull-xs-left">
																			<a class="text-grey" href="#"><i class=" ti-book"></i><?php echo $n["veces_leido"]; ?></a>
																		</div>
																		<div class="pull-xs-right">
																			<p class="small text-uppercase text-muted"><?php echo date('d/m/Y', strtotime($n["fecha_actualizacion"])); ?></p>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												<?php endforeach ?>
											</div>
										</div>
									<?php else: ?>
										
										<div id="socialLinks">
											<h5>Compartir publicación</h5>
											<div id="fb-root"></div>
											<script>(function(d, s, id) {
												var js, fjs = d.getElementsByTagName(s)[0];
												if (d.getElementById(id)) return;
												js = d.createElement(s); js.id = id;
												js.src = "//connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v2.9&appId=335054620211948";
												fjs.parentNode.insertBefore(js, fjs);
											}(document, 'script', 'facebook-jssdk'));</script>
											<div class="fb-share-button" data-href="http://www.jobbersargentina.com/noticias.php?<?php echo $_SERVER["QUERY_STRING"]; ?>" data-layout="button" data-size="large" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse">Compartir</a></div>

											<style>
												.IN-widget {
													margin-left: 100px;
													position: absolute;
													z-index: 999;
													margin-top: -8px;
													width: 90px;
													line-height: 1;
													vertical-align: baseline;
													display: inline-block;
													text-align: center;
												}

												.IN-widget span {
													height: 26px !important;
												}

												.IN-widget [id$=link] {
													height: 26px !important;
												}

												.IN-widget [id$=logo] {
													height: 28px !important;
													width: 26px !important;
													background-position: 3px -591px !important;
												}
											</style>
											<script src="//platform.linkedin.com/in.js" type="text/javascript"> lang: es_ES</script>
											<script type="IN/Share" data-url="http://www.jobbersargentina.com/noticias.php?<?php echo $_SERVER["QUERY_STRING"]; ?>"></script>
										</div>
										<div class="box bg-white post post-1">
											<div class="p-img img-cover" style="background-image: url(img/<?php echo $noticia["imagen"]; ?>);">
												<!--<span class="tag tag-danger">Lifestyle</span>-->
												<div class="p-info clearfix">
													<div class="pull-xs-left">
														<span class="small text-uppercase"><?php echo date('d/m/Y', strtotime($noticia["fecha_actualizacion"])); ?></span>
													</div>
													<div class="pull-xs-right">
														<span><i class="ti-book"></i><?php echo $noticia["veces_leido"]; ?></span>
													</div>
												</div>
											</div>
											<div class="p-content">
												<h5><a class="text-black" href="#"><?php echo $noticia["titulo"]; ?></a></h5>
												<p class="m-b-0"><?php echo $noticia["descripcion"]; ?></p>
											</div>
										</div>
									<?php endif ?>
								<?php else: ?>
									<?php if($noticias): ?>
										<?php $i = 0; ?>
										<?php foreach($noticias as $n): ?>
											<div class="col-md-4">
												<div class="box bg-white post post-3">
													<div class="p-img img-cover" style="background-image: url(img/<?php echo $n["imagen"]; ?>);"></div>
													<div class="p-content">
														<h5><a class="text-black" href="noticias.php?n=<?php echo "$n[amigable]-$n[id]"; ?>"><?php echo $n["titulo"]; ?></a></h5>
														<p class="m-b-0-5"><?php echo strlen($n["descripcion"]) > 100 ? (substr($n["descripcion"], 0, 100)."...") : $n["descripcion"]; ?></p>
														<p class="small text-uppercase text-muted"><?php echo date('d/m/Y', strtotime($n["fecha_actualizacion"])); ?></p>
														<a href="noticias.php?n=<?php echo "$n[amigable]-$n[id]"; ?>" class="btn btn-success label-right">leer más <span class="btn-label"><i class="ti-angle-right"></i></span></a>
													</div>
													<div class="p-info clearfix">
														<div class="pull-xs-right">
															<a class="text-success" href="#"><i class=" ti-book"></i><?php echo $n["veces_leido"]; ?></a>
														</div>
													</div>
												</div>
											</div>
											<?php 
												$i++;
												if ($i == 3) {
													echo "<div class='clearfix'></div>";
													$i = 0;
												}
											?>
										<?php endforeach ?>
									<?php endif ?>
								<?php endif ?>
							</div>
						</div>
						<!-- <div class="container-fluid">
							<div class="clearfix"></div>
							<div class="row"> -->
								<div class="col-md-3">
									<div class="card">
										<div class="card-header text-uppercase"><b>NOTICIAS POPULARES</b></div>
										<div class="items-list">
											<?php if($noticiasPopulares): ?>
												<?php foreach($noticiasPopulares as $n): ?>
													<div class="il-item">
														<a class="text-black" href="noticias.php?n=<?php echo "$n[amigable]-$n[id]"; ?>">
															<div class="media">
																<div class="media-left">
																	<div class="avatar box-48">
																		<img class="b-a-radius-0-125" src="img/<?php echo $n["imagen"]; ?>" alt="">
																	</div>
																</div>
																<div class="media-body">
																	<h6 class="media-heading"><?php echo strlen($n["titulo"]) > 17 ? (substr($n["titulo"], 0, 14)."...") : $n["titulo"]; ?></h6>
																	<span class="text-muted"><?php echo strlen($n["descripcion"]) > 20 ? (substr($n["descripcion"], 0, 18)."...") : $n["descripcion"]; ?></span>
																</div>
															</div>
															<div class="il-icon"><i class="fa fa-angle-right"></i></div>
														</a>
													</div>
												<?php endforeach ?>
											<?php endif ?>
										</div>
										<div class="card-block">
											<a href="noticias.php?n=populares" class="btn btn-primary btn-block">Ver más</a>
										</div>
									</div>
									<div class="card">
										<div class="card-header text-uppercase"><b>CATEGORÍAS</b></div>
										<div class="items-list">
											<?php if($categorias): ?>
												<?php foreach($categorias as $c): ?>
													<div class="il-item">
														<a class="text-black" href="categorias.php?c=<?php echo "$c[nombre]-$c[id]"; ?>">
															<div class="media">
																<div class="media-body">
																	<h6 class="media-heading"><?php echo $c["nombre"]; ?></h6>
																</div>
															</div>
															<div class="il-icon" style="top: 10px;"><i class="fa fa-angle-right"></i></div>
														</a>
													</div>
								
												<?php endforeach ?>
											<?php endif ?>
										</div>
										<div class="card-block">
											<a class="btn btn-primary btn-block" href="categorias.php">Ver más</a>
										</div>
									</div>
								</div>
							<!-- </div>
													</div> -->
					</div>
				</div>
			</div>
			<?php require_once('includes/footer.php'); ?>
		</div>
	</div>

	<?php require_once('includes/libs-js.php'); ?>
</body>
</html>