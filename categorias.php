<?php
	session_start();
	require_once('classes/DatabasePDOInstance.function.php');
	require_once('slug.function.php');

	$db = DatabasePDOInstance();

	if(isset($_REQUEST["c"])) {
		$c = array_pop(explode("-", $_REQUEST["c"]));
		$trozos = explode("-", $_REQUEST["c"]);
		$cat = $trozos[0];
		if($c == 0) {
			$cat = "SIN CATEGORÍA";
			$noticias = $db->getAll("
				SELECT
					noticias.*,
					CONCAT(imagenes.directorio,'/',imagenes.nombre,'.', imagenes.extension) AS imagen
				FROM
					noticias
				INNER JOIN
					imagenes
				ON
					imagenes.id = noticias.id_imagen
				WHERE
					noticias.id_categoria = $c
			");
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
				WHERE
					categorias.id = $c
			");
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
		");
	}

	$categorias = $db->getAll("SELECT * FROM categorias");

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
		<title>JOBBERS - Noticias</title>
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
			<div class="site-content bg-white" style="margin-left: 0px;">
				<!-- Content -->
				<div class="container-fluid">
				<?php if ($_SESSION['ctc']['type'] == 1):
					$grid = "col-md-9";
					require_once('includes/sidebar.php');
					else:
					$grid = "container";
				?>
				<?php endif ?>
					<div class="<?php echo $grid ?>">
						<div class="row">
							<div class="col-md-9">
									<h4>Noticias</h4>
									<ol class="breadcrumb no-bg m-b-1">
										<li class="breadcrumb-item"><a href="./">inicio</a></li>
										<li class="breadcrumb-item"><a href="noticias.php">Noticias</a></li>
										<li class="breadcrumb-item active">Categorías</li>
									</ol>
									<div class="card">
										<div class="card-header text-uppercase"><b><?php echo isset($_REQUEST["c"]) ? ("Noticias de la categoría: $cat") : "Noticias de todas las categorias"; ?></b></div>
										<div class="posts-list posts-list-1">
											<?php if($noticias): ?>
												<?php foreach($noticias as $n): ?>
													<div class="pl-item">
														<div class="media">
															<div class="media-left col-md-5">
																<a href="noticias.php?n=<?php echo "$n[amigable]-$n[id]"; ?>">
																	<div class="pli-img">
																		<img class="img-fluid" style="height: 100%; width: 100%" src="img/<?php echo $n["imagen"]; ?>">
																		<!--<div class="tag tag-warning">Lifestyle</div>-->
																	</div>
																</a>
															</div>
															<div class="col-md-7">
																<div class="pli-content">
																	<h5><a class="text-black" href="noticias.php?n=<?php echo "$n[amigable]-$n[id]"; ?>"><?php echo $n["titulo"]; ?></a></h5>
																	<p class="m-b-0-5"><?php echo strlen($n["descripcion"]) > 100 ? (substr( $n["descripcion"],0, 100)."...") : $n["descripcion"]; ?></p>
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
											<?php endif ?>
										</div>
									</div>
							</div>
							<div class="col-md-3">
								<div class="card">
									<div class="card-header text-uppercase"><h5>CATEGORÍAS</h5></div>
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
										<a href="categorias.php" class="btn btn-primary btn-block">Ver más</a>
									</div>
								</div>
								<div class="card" style="margin-top: 35px;">
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