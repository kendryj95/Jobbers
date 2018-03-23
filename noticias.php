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

		<!-- Sidebar second -->
		<?php require_once('includes/sidebar-second.php'); ?>

		<!-- Header -->
		<?php require_once('includes/header.php'); ?>
		<div class="site-content bg-white" style="margin-left: 0px;padding-top: 80px;">
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
										<div>
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
										<div>
											<div class="box bg-white post post-1">
												<div class="p-img img-cover col-xs-12 col-md-5 news-img" style="background-image: url(img/<?php echo $noticia["imagen"]; ?>);">
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
												<div class="p-content text-justify" style="word-wrap: break-word">
													<h5 style="margin-top: 0px;"><a class="text-black" href="#"><?php echo $noticia["titulo"]; ?></a></h5>
													<p class="m-b-0"><?php echo $noticia["descripcion"]; ?></p>
												</div>
											</div>
										</div>
									<?php endif ?>
								<?php else: ?>
									<?php if($noticias): ?>
										<?php $i = 0; ?>
										<div>
										<?php foreach($noticias as $n): ?>
											<div class="col-md-4">
												<div class="box bg-white post post-3" style="border: 1px solid #333695;">
													<div class="p-img img-cover" style="background-image: url(img/<?php echo $n["imagen"]; ?>);">
													</div>
													<div class="p-content" style="min-height: 220px;">
														<a class="text-black" href="noticias.php?n=<?php echo "$n[amigable]-$n[id]"; ?>"><h5><?php echo $n["titulo"]; ?></h5></a>
														<div>
															<p class="m-b-0-5"><?php echo strlen($n["descripcion"]) > 100 ? (substr(strip_tags($n["descripcion"]), 0, 100)."...") : strip_tags($n["descripcion"]); ?></p> <!-- strip_tags: elimina las etiquetas html de un string -->
														</div>
														<p class="small text-uppercase text-muted"><?php echo date('d/m/Y', strtotime($n["fecha_actualizacion"])); ?></p>
														<a href="noticias.php?n=<?php echo "$n[amigable]-$n[id]"; ?>" class="btn btn-success btn-cookies label-right">Leer más <span class="btn-label"><i class="ti-angle-right"></i></span></a>
													</div>
													<div class="p-info clearfix">
														<div class="pull-xs-right">
															<a class="color-link" style="font-weight: bolder;" href="#"><i class=" ti-book"></i><?php echo $n["veces_leido"]; ?></a>
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
										</div>
									<?php endif ?>
								<?php endif ?>
						</div>
						<div class="col-md-3">
									<div class="card">
										<div class="card-header text-uppercase" style="margin-bottom: 10px;"><h3 class="text-center" style="background-color: #333695; padding-top: 10px; padding-bottom: 10px; border-bottom: 4px solid #00AEEF; color: #fff">Noticias Populares <i class="fa fa-newspaper-o"></i></h3></div>
										<div class="list-group">
											<?php if($noticiasPopulares): ?>
												<?php foreach($noticiasPopulares as $n): ?>
														<a class="list-group-item sidebar-index-hover item-news" style="text-decoration: none" href="noticias.php?n=<?php echo "$n[amigable]-$n[id]"; ?>">
															<div class="media">
																<div class="media-left">
																	<div class="avatar box-48">
																		<img class="b-a-radius-0-125" src="img/<?php echo $n["imagen"]; ?>" alt="">
																	</div>
																</div>
																<div class="media-body">
																	<h5 class="media-heading"><?php echo strlen($n["titulo"]) > 17 ? (substr($n["titulo"], 0, 14)."...") : $n["titulo"]; ?></h5>
																	<span class="text-muted sidebar-index-hover"><?php echo strlen($n["descripcion"]) > 20 ? (substr($n["descripcion"], 0, 18)."...") : $n["descripcion"]; ?></span>
																</div>
															</div>
															<i class="fa fa-plus-circle info-icon" style="display: none; bottom: 20px;"></i>
														</a>		
												<?php endforeach ?>
											<?php endif ?>
										</div>
										<div class="card-block">
											<a href="noticias.php?n=populares" class="btn btn-primary btn-cookies btn-block">Ver más <i class="fa fa-plus"></i></a>
										</div>
									</div>
									<div class="card">
										<div class="card-header text-uppercase" style="margin-top: 35px; margin-bottom:10px;"><h3 class="text-center" style="background-color: #333695; padding-top: 10px; padding-bottom: 10px; border-bottom: 4px solid #00AEEF; color: #fff">Categorias <i class="fa fa-th-list"></i></h3></div>
										<div class="list-group">
											<?php if($categorias): ?>
												<?php foreach($categorias as $c): ?>
													<!-- <div class="sidebar-index-hover"> -->
														<a class="list-group-item  sidebar-index-hover item-news" href="categorias.php?c=<?php echo "$c[nombre]-$c[id]"; ?>">
															<h6 style="font-size: 17px;"><?php echo $c["nombre"]; ?></h6>
														</a>
													<!-- </div> -->
								
												<?php endforeach ?>
											<?php endif ?>
										</div>
										<div class="card-block">
											<a class="btn btn-primary btn-cookies btn-block" href="categorias.php">Ver más <i class="fa fa-plus"></i></a>
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