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
			<div class="content-area p-y-1">
				<div class="container-fluid">
					<div class="row m-b-0 m-md-b-1">
						<div class="col-md-9">
								<div class="col-md-12">
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
								</div>
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
										<div class="container">
										<?php 
											$permalink = urlencode("http://www.jobbersargentina.com/noticias.php?".$_SERVER["QUERY_STRING"]);
										?>
											<h4>Compartir Publicación</h4>
											<div id="socialLinks">
												<!-- Twitter -->
												<a href="http://twitter.com/share?url=<?php echo $permalink;?>" target="_blank" class="share-btn twitter">
													<i class="fa fa-twitter"></i>&nbsp Tweet
												</a>

												<!-- Google Plus -->
												<a href="https://plus.google.com/share?url=<?php echo $permalink;?>" target="_blank" class="share-btn google-plus">
													<i class="fa fa-google-plus"></i>&nbsp Compartir
												</a>

												<!-- Facebook -->
												<a href="http://www.facebook.com/sharer/sharer.php?u=<?php echo $permalink;?>" target="_blank" class="share-btn facebook">
													<i class="fa fa-facebook"></i>&nbsp Compartir
												</a>

												<!-- LinkedIn -->
												<a href="http://www.linkedin.com/shareArticle?url=<?php echo $permalink;?>" target="_blank" class="share-btn linkedin">
													<i class="fa fa-linkedin"></i>&nbsp Compartir
												</a>
											</div>
										</div>
										<div class="container">
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
										</div>
									<?php endif ?>
								<?php else: ?>
									<?php if($noticias): ?>
										<?php $i = 0; ?>
										<?php foreach($noticias as $n): ?>
											<div class="col-md-4">
												<div class="box bg-white post post-3">
													<div class="p-img img-cover" style="background-image: url(img/<?php echo $n["imagen"]; ?>);"></div>
													<div class="p-content" style="min-height: 190px;">
														<h5><a class="text-black" href="noticias.php?n=<?php echo "$n[amigable]-$n[id]"; ?>"><?php echo $n["titulo"]; ?></a></h5>
														<p class="m-b-0-5"><?php echo strlen($n["descripcion"]) > 100 ? (substr($n["descripcion"], 0, 100)."...") : $n["descripcion"]; ?></p>
														<p class="small text-uppercase text-muted"><?php echo date('d/m/Y', strtotime($n["fecha_actualizacion"])); ?></p>
														<a href="noticias.php?n=<?php echo "$n[amigable]-$n[id]"; ?>" class="btn btn-success label-right">Leer más <span class="btn-label"><i class="ti-angle-right"></i></span></a>
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
										<div class="card-header text-uppercase" style="margin-top: 35px;"><b>CATEGORÍAS</b></div>
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
					</div>
				</div>
			</div>
			<?php require_once('includes/footer.php'); ?>
		</div>
	<!-- </div> -->

	<?php require_once('includes/libs-js.php'); ?>
</body>
</html>