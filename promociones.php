<?php
	session_start();
	require_once('classes/DatabasePDOInstance.function.php');
	require_once('slug.function.php');

	$db = DatabasePDOInstance();

	$publicaciones_especiales = $db->getAll("
		SELECT empresas_publicaciones_especiales.*, CONCAT(imagenes.directorio,'/', imagenes.nombre,'.', imagenes.extension) AS imagen, empresas.nombre AS nombre_empresa FROM empresas_publicaciones_especiales INNER JOIN empresas ON empresas.id=empresas_publicaciones_especiales.id_empresa INNER JOIN empresas_planes ON empresas_planes.id_empresa=empresas.id LEFT JOIN imagenes ON imagenes.id=empresas_publicaciones_especiales.id_imagen WHERE empresas_planes.logo_home=3 ORDER BY RAND()
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
		<title>JOBBERS - promociones</title>
		<?php require_once('includes/libs-css.php'); ?>
		
		<style>
			.pub {
				min-height: 150px;
				margin-bottom: 30px;
				max-height: 490px;
			}
			.pub-f {
				min-height: 110px;
			}
			.pub, .pub-f {
				background-color: #f8f8f8 !important;
				-webkit-transition: all 0.2s ease-in-out;
				transition: all 0.2s ease-in-out;
				cursor: pointer;
			}			
			.pub:hover, .pub-f:hover {
				background-color: #3e70c9 !important;
			}
			.pub:hover *, .pub-f:hover * {
				color: #fff !important;
			}
			.pub .avatar {
				max-height: 140px;
				height: 120px;
				width: 100%;
				max-width: 140px;
				margin: 0 auto;
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
					<div class="container-fluid">
						<?php if($publicaciones_especiales): ?>
							<div class="row">
								<?php foreach($publicaciones_especiales as $pub): ?>
									<?php if($pub["tipo"] == 1): $i=0;  ?>
										<div class="col-md-4">
											<div class="box bg-white post post-1">
												<div class="p-img img-cover" style="background-image: url(empresa/img/<?php echo $pub["imagen"]; ?>);">
													<span class="tag tag-danger">Destacado</span>
													<div class="p-info clearfix">
														<div class="pull-xs-left">
															<span class="small text-uppercase">Publicado el <?php echo date('d/m/Y', strtotime($pub["fecha_creacion"])); ?></span>
														</div>
														<!--<div class="pull-xs-right">
															<span class="m-r-1"><i class="fa fa-heart"></i>57</span>
															<span><i class="fa fa-comment"></i>14</span>
														</div>-->
													</div>
												</div>
												<div class="p-content" style="padding-bottom: 3px;">
													<h5><a class="text-black" href="#"><?php echo $pub["titulo"]; ?></a></h5>
													<p class="m-b-0"><?php echo strlen($pub["descripcion"]) > 55 ? (substr($pub["descripcion"], 0, 55).'... <div id="collapse'.$i.'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading'.$i.'" aria-expanded="false" style="height: 0px;"> '.(substr($pub["descripcion"], 55,  strlen($pub["descripcion"]) -1)).' </div> <a data-toggle="collapse" data-parent="#accordion" href="#collapse'.$i.'" aria-expanded="false" aria-controls="collapse'.$i.'" class="collapsed"><span class="underline">Ver más</span></a>'): $pub["descripcion"]; ?></p>
												</div>
											</div>
										</div>
									<?php $i++; else: ?>
										<div class="col-md-4">
											<?php
												$link = "";
												if (strstr($pub["enlace"], 'http')) {
													$link = $pub["enlace"];
												}
												else {
													$link = "http://$pub[enlace]";
												}
												
												if (strstr($link, 'youtu.be')) {
													$link = str_replace('youtu.be/', 'youtube.com/watch?v=', $link);
												}
												else {
													if (strstr($link, 'vimeo')) {
														$link = "http://".str_replace('vimeo.com/', 'player.vimeo.com/video/', $link);
													}
												}
												$link = str_replace('watch?v=', 'embed/', $link);
											?>
											<div class="box bg-white post post-3">
												<div class="p-img img-cover youtube-video">
													<iframe class="youtube-player" type="text/html" width="100%" height="100%" src="<?php echo $link; ?>" frameborder="0"> </iframe>
												</div>
												<div class="p-content">
													<h5><a class="text-black" href="#"><?php echo $pub["titulo"]; ?></a></h5>
													<span class="small text-uppercase"><strong>Empresa</strong>: <a href="empresa/perfil.php?e=<?php echo "$pub[nombre_empresa]-$pub[id_empresa]"; ?>"><?php echo $pub["nombre_empresa"]; ?></a></span>
													<br>
													<span class="small text-uppercase">Publicado el <?php echo date('d/m/Y', strtotime($pub["fecha_creacion"])); ?></span>
												</div>
											</div>
										</div>
									<?php endif ?>
								<?php endforeach ?>
							</div>
						<?php endif ?>
					</div>
				</div>
				<?php require_once('includes/footer.php'); ?>
			</div>
		</div>

		<?php require_once('includes/libs-js.php'); ?>
	</body>
</html>