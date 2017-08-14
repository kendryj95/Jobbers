<?php
	session_start();
	require_once('classes/DatabasePDOInstance.function.php');
	require_once('slug.function.php');

	$db = DatabasePDOInstance();

	$areas = $db->getAll("
		SELECT
			id,
			nombre,
			amigable
		FROM
			areas
		ORDER BY
			nombre
	");


	if(isset($_SESSION["ctc"]["empresa"]) && !isset($_REQUEST["empresas"])) {
		$trabajadores = $db->getAll("
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
				tra.calificacion_general
			FROM
				trabajadores AS tra
			LEFT JOIN imagenes AS img ON tra.id_imagen = img.id
			ORDER BY RAND()
			LIMIT 12
		");

		foreach($trabajadores as $k => $t) {
			if(!$t["imagen"]) {
				$trabajadores[$k]["imagen"] = "avatars/user.png";
			}
		}
	}
	else {
		foreach($areas as $i => $area) {
			$areas[$i]["cantidad"] = $db->getOne("
				SELECT
					COUNT(*)
				FROM
					publicaciones_sectores AS psec
				INNER JOIN areas_sectores AS asec ON psec.id_sector = asec.id
				WHERE
					asec.id_area = $area[id]
			");
		}
		
		$publicaciones = $db->getAll("
			SELECT
				p.titulo,
				p.descripcion,
				e.nombre AS empresa_nombre,
				e.facebook,
				e.twitter,
				e.instagram,
				e.linkedin,
				e.verificado,
				a.amigable AS area_amigable,
				a.nombre AS area_nombre,
				ase.amigable AS sector_amigable,
				ase.nombre AS sector_nombre,
				p.amigable,
				CONCAT(
					img.directorio,
					'/',
					img.nombre,
					'.',
					img.extension
				) AS imagen
			FROM
				publicaciones AS p
			INNER JOIN publicaciones_sectores AS ps ON p.id = ps.id_publicacion
			INNER JOIN areas_sectores AS ase ON ps.id_sector = ase.id
			INNER JOIN areas AS a ON ase.id_area = a.id
			INNER JOIN empresas AS e ON p.id_empresa = e.id
			INNER JOIN empresas_planes AS ep ON p.id_empresa = ep.id_empresa
			LEFT JOIN imagenes AS img ON img.id=e.id_imagen
			WHERE ep.logo_home=1 AND (e.suspendido IS NULL OR e.suspendido = 0)
			ORDER BY RAND()
			LIMIT 12
		");
		
		$publicacionesOro = $db->getAll("
			SELECT
				p.titulo,
				p.descripcion,
				e.nombre AS empresa_nombre,
				e.sitio_web,
				e.facebook,
				e.twitter,
				e.instagram,
				e.linkedin,
				e.verificado,
				a.amigable AS area_amigable,
				a.nombre AS area_nombre,
				ase.amigable AS sector_amigable,
				ase.nombre AS sector_nombre,
				p.amigable,
				CONCAT(
					img.directorio,
					'/',
					img.nombre,
					'.',
					img.extension
				) AS imagen
			FROM
				publicaciones AS p
			INNER JOIN publicaciones_sectores AS ps ON p.id = ps.id_publicacion
			INNER JOIN areas_sectores AS ase ON ps.id_sector = ase.id
			INNER JOIN areas AS a ON ase.id_area = a.id
			INNER JOIN empresas AS e ON p.id_empresa = e.id
			INNER JOIN empresas_planes AS ep ON p.id_empresa = ep.id_empresa
			LEFT JOIN imagenes AS img ON img.id=e.id_imagen
			WHERE ep.logo_home=3 AND (e.suspendido IS NULL OR e.suspendido = 0)
			ORDER BY RAND()
			LIMIT 6
		");
		
		$publicacionesPlata = $db->getAll("
			SELECT
				p.titulo,
				p.descripcion,
				e.nombre AS empresa_nombre,
				e.sitio_web,
				e.facebook,
				e.twitter,
				e.instagram,
				e.linkedin,
				e.verificado,
				a.amigable AS area_amigable,
				a.nombre AS area_nombre,
				ase.amigable AS sector_amigable,
				ase.nombre AS sector_nombre,
				p.amigable,
				CONCAT(
					img.directorio,
					'/',
					img.nombre,
					'.',
					img.extension
				) AS imagen
			FROM
				publicaciones AS p
			INNER JOIN publicaciones_sectores AS ps ON p.id = ps.id_publicacion
			INNER JOIN areas_sectores AS ase ON ps.id_sector = ase.id
			INNER JOIN areas AS a ON ase.id_area = a.id
			INNER JOIN empresas AS e ON p.id_empresa = e.id
			INNER JOIN empresas_planes AS ep ON p.id_empresa = ep.id_empresa
			LEFT JOIN imagenes AS img ON img.id=e.id_imagen
			WHERE ep.logo_home=2 AND (e.suspendido IS NULL OR e.suspendido = 0)
			ORDER BY RAND()
			LIMIT 6
		");

		$momentos = array(
			array(
				"nombre" => "Últimas 24 horas",
				"amigable" => "ultimas-24-horas",
				"cantidad" => 0,
				"diff_s" => 86400
			),
			array(
				"nombre" => "Durante los últimos 3 días",
				"amigable" => "durante-los-ultimos-3-dias",
				"cantidad" => 0,
				"diff_s" => 259200
			),
			array(
				"nombre" => "Durante la última semana",
				"amigable" => "durante-la-ultima-semana",
				"cantidad" => 0,
				"diff_s" => 604800
			),
			array(
				"nombre" => "Durante las ultimas 2 semanas",
				"amigable" => "durante-las-ultimas-2-semanas",
				"cantidad" => 0,
				"diff_s" => 1209600
			),
			array(
				"nombre" => "Hace un mes o menos",
				"amigable" => "hace-un-mes-o-menos",
				"cantidad" => 0,
				"diff_s" => 2592000
			)
		);

		foreach($momentos as $i => $momento) {
			$momentos[$i]["cantidad"] = $db->getOne("
				SELECT
					COUNT(*)
				FROM
					(
						SELECT
							TIMESTAMPDIFF(
								SECOND,
								fecha_creacion,
								NOW()
							) AS s
						FROM
							publicaciones AS p

					) AS r
				WHERE
					r.s <= $momento[diff_s]
			");
		}
	}

	$publicaciones_especiales = $db->getAll("
		SELECT empresas_publicaciones_especiales.*, CONCAT(imagenes.directorio,'/', imagenes.nombre,'.', imagenes.extension) AS imagen, empresas.nombre AS nombre_empresa FROM empresas_publicaciones_especiales INNER JOIN empresas ON empresas.id=empresas_publicaciones_especiales.id_empresa INNER JOIN empresas_planes ON empresas_planes.id_empresa=empresas.id LEFT JOIN imagenes ON imagenes.id=empresas_publicaciones_especiales.id_imagen WHERE empresas_planes.logo_home=3 ORDER BY RAND()
	");

	$publicidadPrincipal = $db->getAll("SELECT publicidad.*, CONCAT(imagenes.directorio,'/', imagenes.nombre,'.', imagenes.extension) AS imagen FROM publicidad LEFT JOIN imagenes ON imagenes.id=publicidad.id_imagen WHERE publicidad.mi_publicidad=1 ORDER BY RAND() LIMIT 4");
	$publicidadSection = $db->getAll("SELECT publicidad.titulo, publicidad.url, CONCAT(imagenes.directorio,'/', imagenes.nombre,'.', imagenes.extension) AS imagen FROM publicidad INNER JOIN imagenes ON imagenes.id=publicidad.id_imagen WHERE publicidad.mi_publicidad=0 ORDER BY RAND() LIMIT 4");
?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<!-- Meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<meta name="description" content="">
		<meta name="author" content="">

		<!-- Title -->
		<title>JOBBERS - BUSQUEDA DE TRABAJO INTELIGENTE</title>
		<?php require_once('includes/libs-css.php'); ?>
		<link rel="stylesheet" href="vendor/ionicons/css/ionicons.min.css">
		<style>
			.btn-outline-white
			.btn-outline-white, .btn-outline-white a:hover {
				color: black !important;
			}
			
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
				height: 140px;
				width: 100%;
				max-width: 140px;
				margin: 0 auto;
			}
			
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
            
            @import url('https://fonts.googleapis.com/css?family=Fira+Sans+Extra+Condensed:400,700');
            @import url(http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css);
            .snip1583 {
              font-family: 'Fira Sans Extra Condensed', Arial, sans-serif;
              position: relative;
              display: inline-block;
              overflow: hidden;
              margin: 8px;
              width: 100%;
              font-size: 16px;
              background-color: #fff;
              color: #111;
              line-height: 1.2em;
              text-align: left;
				padding: 0px !important;
            }

            .snip1583 *,
            .snip1583 *:before,
            .snip1583 *:after {
              -webkit-box-sizing: border-box;
              box-sizing: border-box;
              -webkit-transition: all 0.35s ease;
              transition: all 0.35s ease;
            }

            .snip1583 img {
              max-width: 100%;
              vertical-align: top;
				padding: 0px !important;
            }

            .snip1583 .content {
              padding: 30px;
            }

            .snip1583 h3 {
              font-size: 1.4rem;
              font-weight: 400;
              margin: 0 0 4px;
            }

            .snip1583 .price {
              margin: 8px 0;
              font-weight: 700;
              color: #4da3e2;
              font-size: 1.5rem;
            }

            .snip1583 .icons {
              position: absolute;
              top: 0;
              bottom: 0;
              left: 0;
              right: 0;
              padding: 10px;
              display: flex;
              flex-direction: column;
              justify-content: flex-start;
			  width: 64px;
			  height: 154px;
            }
            
            .snip1583 .icons2 {
              position: absolute;
              top: 0;
              bottom: 0;
              right: 0;
              padding: 10px;
              display: flex;
              flex-direction: column;
              justify-content: flex-start;
            }

            .snip1583 .icons a {
              margin: 2px;
              opacity: 0;
              -webkit-transform: translateY(50%);
              transform: translateY(50%);
            }

            .snip1583 .icons a i {
              display: block;
              font-size: 23.52941176px;
              line-height: 40px;
              width: 40px;
              background-color: #ffffff;
              text-align: center;
              color: #000000;
            }

            .snip1583 .icons a i:hover {
              background-color: #4da3e2;
              color: #ffffff;
              cursor: pointer;
            }

            .snip1583:hover a,
            .snip1583.hover a {
              opacity: 1;
              -webkit-transform: translateX(0);
              transform: translateX(0);
            }

            .snip1583:hover a:nth-child(2),
            .snip1583.hover a:nth-child(2) {
              -webkit-transition-delay: 0.1s;
              transition-delay: 0.1s;
            }

            .snip1583:hover a:nth-child(3),
            .snip1583.hover a:nth-child(3) {
              -webkit-transition-delay: 0.2s;
              transition-delay: 0.2s;
            }
			
			/*
            
            .logo div {
                background-color: #d6dae1 !important;
                border: 1px solid #c6cad1 !important;
                height: 73px;
            }
            
            .site-header .navbar {
                background-color: #d6dae1 !important;
                border: 1px solid #c6cad1 !important;
            }
            
            .site-header .navbar-nav .nav-link {
                height: 40px !important;
                line-height: 40px !important;
                background: #2e3192 !important;
                padding: 0 20px !important;
                border: 1px solid #2e3192 !important;
            }
            
            .navbar-nav .nav-item {
                padding: 15px !important;
            }
            
            .site-header .navbar-nav .nav-link:hover {
                color: #2e3192 !important;
                background: #fff !important;
                border: 1px solid #2e3192 !important;
            }
            
            @media (max-width: 600px) {
                .logo {
                    width: 100% !important;
                }
                
                .site-header .navbar {
                    margin-top: 10px;
                }
                
                .navbar-nav .nav-item {
                    padding: 0 !important;
                }
                
                .nav {
                    margin-bottom: 20px;
                    width: 100%;
                    margin-top: 25px;
                }
                
                .navbar-nav .nav-item + .nav-item {
                    margin-left: 0;
                    padding-top: 0px !important;
                }
                
                .site-header .header-form .btn {
                    bottom: 0;
                    position: relative;
                    right: 0;
                    margin-top: -60px;
                    margin-left: calc(100% - 50px);
                }
            }
			*/
            
		</style>
	</head>

	<body class="large-sidebar fixed-sidebar fixed-header skin-5">
		<div class="wrapper">

			<!-- Preloader -->
<!--			<div class="preloader"></div>-->

			<!-- Sidebar -->
			<?php  require_once('includes/sidebar.php'); ?>

			<!-- Sidebar second -->
			<?php // require_once('includes/sidebar-second.php'); ?>

			<!-- Header -->
			<?php  require_once('includes/header.php'); ?>

			<?php if($publicidadPrincipal): ?>
				<div class="row" style="padding: 25px; margin-top: 75px;" id="ad">
					<?php foreach($publicidadPrincipal as $p): ?>
						<?php
							$link = "";
							if (strstr($p["url"], 'http')) {
								$link = $p["url"];
							}
							else {
								$link = "http://$p[url]";
							}
						?>
						<?php if($p["tipo_publicidad"] == 1): ?>
							<div class="col-md-3">
								<?php
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
								</div>
							</div>
						<?php else: ?>
							<div class="col-md-3">
								<div class="box bg-white product product-1">
									<div class="p-img img-cover" style="background-image: url(img/<?php echo $p["imagen"]; ?>);">
										<div class="p-status bg-warning"><?php echo $p["titulo"]; ?></div>
										<div class="p-links">
											<a href="<?php echo $link; ?>"><i class="ti-link"></i></a>
											<!--<a href="#"><i class="fa fa-star"></i></a>-->
										</div>
									</div>
								</div>
							</div>
						<?php endif ?>
					<?php endforeach ?>
				</div>
			<?php endif ?>

			<?php if(isset($_SESSION["ctc"]["empresa"]) && !isset($_REQUEST["empresas"])): ?>

			<div class="row" style="padding: 25px;">
					<div class="col-md-3">
						<div class="box bg-white">
							<div class="box-block clearfix">
								<h5 class="pull-xs-left"><i class="ion-ios-list m-sm-r-1"></i> Área</h5>
							</div>
							<table class="table m-md-b-0">
								<tbody>
									<?php foreach($areas as $area): ?>
										<?php if(/*$area["cantidad"] > 0*/true): ?>
											<tr>
												<td>
													<a class="link-area" data-area="<?php echo $area["amigable"]; ?>" style="margin-left: 7px;" class="text-primary" href="trabajadores.php?area=<?php echo $area["amigable"]; ?>&pagina=1"><span class="underline"><?php echo $area["nombre"]; ?></span></a>
												</td>
												<td>
													<span class="text-muted pull-xs-right"><?php /*echo $area["cantidad"];*/ ?></span>
												</td>
											</tr>
										<?php endif ?>
									<?php endforeach ?>
								</tbody>
							</table>
						</div>
						
						<?php if($publicidadSection): ?>
							<div class="row" id="ad2">
								<?php foreach($publicidadSection as $p): ?>
									<?php
										$link = "";
										if (strstr($p["url"], 'http')) {
											$link = $p["url"];
										}
										else {
											$link = "http://$p[url]";
										}
									?>
									<?php if(isset($p["tipo_publicidad"])): ?>
										<?php if($p["tipo_publicidad"] == 1): ?>
											<div class="col-md-3">
												<?php
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
												</div>
											</div>
										<?php else: ?>
											<div class="col-md-3">
												<div class="box bg-white product product-1">
													<div class="p-img img-cover" style="background-image: url(img/<?php echo $p["imagen"]; ?>);">
														<div class="p-status bg-warning"><?php echo $p["titulo"]; ?></div>
														<div class="p-links">
															<a href="<?php echo $link; ?>"><i class="ti-link"></i></a>
															<!--<a href="#"><i class="fa fa-star"></i></a>-->
														</div>
													</div>
												</div>
											</div>
										<?php endif ?>
									<?php endif ?>
								<?php endforeach ?>
							</div>
						<?php endif ?>
					</div>

					<div class="col-md-9">

						<div class="row row-sm">
							<?php foreach($trabajadores as $trabajador): ?>
								<div class="col-md-4">
									<a href="trabajador-detalle.php?t=<?php echo slug("$trabajador[nombres] $trabajador[apellidos]") . "-$trabajador[id]"; ?>">
										<div class="tra box box-block bg-white user-5">
											<div class="u-content">
												<div class="avatar box-96 m-b-2">
													<img class="b-a-radius-circle" src="img/<?php echo $trabajador["imagen"]; ?>" alt="" style="max-height: 96px;">
												</div>
												<h5><span class="text-black"><?php echo "$trabajador[nombres] $trabajador[apellidos]"; ?></span></h5>
												<div style="font-size: 28px;"></div>
											</div>
										</div>
									</a>
								</div>
							<?php endforeach ?>	
						</div>

					</div>
				</div>

			<?php else: ?>
              
              <div class="row">
                  <div class="col-md-3">
                      <div class="row">
                          <div class="col-md-12">
                             <h3 style="margin-left: 45px;">Ofertas de empleo por área</h3>
                              <div class="box bg-white" style="margin: 11px 45px;margin-right: 0;">
                                <table class="table m-md-b-0">
                                    <tbody>
                                        <?php foreach($areas as $area): ?>
                                            <?php if($area["cantidad"] > 0): ?>
                                                <tr>
                                                    <td>
                                                        <a class="text-primary" href="empleos.php?area=<?php echo $area["amigable"]; ?>&pagina=1"><span class="underline"><?php echo $area["nombre"]; ?></span></a>
                                                    </td>
                                                    <td>
                                                        <span class="text-muted pull-xs-right"><?php echo $area["cantidad"]; ?></span>
                                                    </td>
                                                </tr>
                                            <?php endif ?>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                          </div>
                          <div class="col-md-12">
                              <?php if($publicidadSection): ?>
                                <div class="row" id="ad2" style="margin-left: 30px;">
                                    <?php foreach($publicidadSection as $p): ?>
                                        <?php
                                            $link = "";
                                            if (strstr($p["url"], 'http')) {
                                                $link = $p["url"];
                                            }
                                            else {
                                                $link = "http://$p[url]";
                                            }
                                        ?>
                                        <div class="col-md-12">
                                            <div class="box bg-white product product-1">
                                                <div class="p-img img-cover" style="background-image: url(img/<?php echo $p["imagen"]; ?>);">
                                                    <div class="p-status bg-warning"><?php echo $p["titulo"]; ?></div>
                                                    <div class="p-links">
                                                        <a href="<?php echo $link; ?>"><i class="ti-link"></i></a>
                                                        <!--<a href="#"><i class="fa fa-star"></i></a>-->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach ?>
                                </div>
                            <?php endif ?>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-9">
                      <h3 style="margin-left: 30px;">Principales ofertas de trabajo</h3>
               
                       <div class="row" style="padding: 25px;">
                           <?php foreach($publicacionesOro as $publicacion): 
                                if(strlen($publicacion["titulo"]) > 30) {
                                    $publicacion["titulo_corto"] = $publicacion["titulo"];
                                }
                                else {
                                    $publicacion["titulo_corto"] = substr($publicacion["titulo"], 0, 30);
                                }
                            ?>
                            <div class="col-lg-3 col-md-4 col-xs-12">
                                <div class="snip1583" style="padding-left: 20px;padding-bottom: 20px;border-top: 7px solid #e4af17;">
                                   <div class="content">
										<a href="empleos-detalle.php?a=<?php echo $publicacion["area_amigable"]; ?>&s=<?php echo $publicacion["sector_amigable"]; ?>&p=<?php echo $publicacion["amigable"]; ?>">
											<img src="empresa/img/<?php echo !$publicacion["imagen"] ? 'avatars/user.png' : $publicacion["imagen"]; ?>" alt="" style="padding: 40px;"/>
										</a>
										<?php if($publicacion["facebook"] != "" || $publicacion["twitter"] != "" || $publicacion["instagram"] != "" || $publicacion["linkedin"] != ""): ?>
										   <div class="icons">
											<?php
												$facebook = "";
												$twitter = "";
												$instagram = "";
												$linkedin = "";
												if (strstr($publicacion["facebook"], 'http')) {
													$facebook = $publicacion["facebook"];
												}
												else {
													$facebook = "http://$publicacion[facebook]";
												}
												if (strstr($publicacion["twitter"], 'http')) {
													$twitter = $publicacion["twitter"];
												}
												else {
													$twitter = "http://$publicacion[twitter]";
												}
												if (strstr($publicacion["instagram"], 'http')) {
													$instagram = $publicacion["instagram"];
												}
												else {
													$instagram = "http://$publicacion[instagram]";
												}
												if (strstr($publicacion["linkedin"], 'http')) {
													$linkedin = $publicacion["linkedin"];
												}
												else {
													$linkedin = "http://$publicacion[linkedin]";
												}
											?>

											<?php if($publicacion["facebook"] != ""): ?>
												<a href="<?php echo $facebook; ?>" title="Visitar Facebook de la empresa" style="width: 40px;"><i class="ti-facebook"></i></a>
											<?php endif ?>

											<?php if($publicacion["twitter"] != ""): ?>
												<a href="<?php echo $twitter; ?>" title="Visitar Twitter de la empresa" style="width: 40px;"><i class="ti-twitter"></i></a>
											<?php endif ?>

											<?php if($publicacion["instagram"] != ""): ?>
												<a href="<?php echo $instagram; ?>" title="Visitar Instagram de la empresa" style="width: 40px;"><i class="ti-instagram"></i></a>
											<?php endif ?>

											<?php if($publicacion["linkedin"] != ""): ?>
												<a href="<?php echo $linkedin; ?>" title="Visitar Linkedin de la empresa" style="width: 40px;"><i class="ti-linkedin"></i></a>
											<?php endif ?>
										 </div>
										<?php endif ?>

										<?php if($publicacion["verificado"] == 1): ?>
											<div class="icons2">
												<i title="Empresa verificada" style="font-size: 30px;color: #dd8037;" class="ti-medall-alt"></i>
											</div>
										<?php endif ?>

										<div style="padding-right: 15px;">
										   <div class="price"><a href="empleos-detalle.php?a=<?php echo $publicacion["area_amigable"]; ?>&s=<?php echo $publicacion["sector_amigable"]; ?>&p=<?php echo $publicacion["amigable"]; ?>"><?php echo $publicacion["empresa_nombre"]; ?></a></div>
											<h3><?php echo $publicacion["titulo_corto"]; ?></h3>
											<div class="price2"><?php echo $publicacion["area_nombre"]; ?></div>
										</div>
                                   </div>
                                </div>
                            </div>
                           <?php endforeach ?>
                        </div>

                        <div class="row" style="padding: 25px;">
                           <?php foreach($publicacionesPlata as $publicacion): 
                                if(strlen($publicacion["titulo"]) > 30) {
                                    $publicacion["titulo_corto"] = $publicacion["titulo"];
                                }
                                else {
                                    $publicacion["titulo_corto"] = substr($publicacion["titulo"], 0, 30);
                                }
                            ?>
                            <div class="col-lg-3 col-md-4 col-xs-12">
                                <div class="snip1583" style="padding-left: 20px;padding-bottom: 20px;border-top: 7px solid #8f8f8f;">
                                   <div class="content">
                                    <a href="empleos-detalle.php?a=<?php echo $publicacion["area_amigable"]; ?>&s=<?php echo $publicacion["sector_amigable"]; ?>&p=<?php echo $publicacion["amigable"]; ?>">
										<img src="empresa/img/<?php echo !$publicacion["imagen"] ? 'avatars/user.png' : $publicacion["imagen"]; ?>" alt="" style="padding: 40px;"/>
									</a>
                                    <?php if($publicacion["facebook"] != "" || $publicacion["twitter"] != "" || $publicacion["instagram"] != "" || $publicacion["linkedin"] != ""): ?>
                                       <div class="icons">
                                        <?php
                                            $facebook = "";
                                            $twitter = "";
                                            $instagram = "";
                                            $linkedin = "";
                                            if (strstr($publicacion["facebook"], 'http')) {
                                                $facebook = $publicacion["facebook"];
                                            }
                                            else {
                                                $facebook = "http://$publicacion[facebook]";
                                            }
                                            if (strstr($publicacion["twitter"], 'http')) {
                                                $twitter = $publicacion["twitter"];
                                            }
                                            else {
                                                $twitter = "http://$publicacion[twitter]";
                                            }
                                            if (strstr($publicacion["instagram"], 'http')) {
                                                $instagram = $publicacion["instagram"];
                                            }
                                            else {
                                                $instagram = "http://$publicacion[instagram]";
                                            }
                                            if (strstr($publicacion["linkedin"], 'http')) {
                                                $linkedin = $publicacion["linkedin"];
                                            }
                                            else {
                                                $linkedin = "http://$publicacion[linkedin]";
                                            }
                                        ?>

                                        <?php if($publicacion["facebook"] != ""): ?>
                                            <a href="<?php echo $facebook; ?>" title="Visitar Facebook de la empresa" style="width: 40px;"><i class="ti-facebook"></i></a>
                                        <?php endif ?>

                                        <?php if($publicacion["twitter"] != ""): ?>
                                            <a href="<?php echo $twitter; ?>" title="Visitar Twitter de la empresa" style="width: 40px;"><i class="ti-twitter"></i></a>
                                        <?php endif ?>

                                        <?php if($publicacion["instagram"] != ""): ?>
                                            <a href="<?php echo $instagram; ?>" title="Visitar Instagram de la empresa" style="width: 40px;"><i class="ti-instagram"></i></a>
                                        <?php endif ?>

                                        <?php if($publicacion["linkedin"] != ""): ?>
                                            <a href="<?php echo $linkedin; ?>" title="Visitar Linkedin de la empresa" style="width: 40px;"><i class="ti-linkedin"></i></a>
                                        <?php endif ?>
                                     </div>
                                    <?php endif ?>

                                    <?php if($publicacion["verificado"] == 1): ?>
                                        <div class="icons2">
                                            <i title="Empresa verificada" style="font-size: 30px;color: #dd8037;" class="ti-medall-alt"></i>
                                        </div>
                                    <?php endif ?>

                                    <div style="padding-right: 15px;">
                                       <div class="price"><a href="empleos-detalle.php?a=<?php echo $publicacion["area_amigable"]; ?>&s=<?php echo $publicacion["sector_amigable"]; ?>&p=<?php echo $publicacion["amigable"]; ?>"><?php echo $publicacion["empresa_nombre"]; ?></a></div>
                                        <h3><?php echo $publicacion["titulo_corto"]; ?></h3>
                                        <div class="price2"><?php echo $publicacion["area_nombre"]; ?></div>
                                    </div>
                                </div>
                                </div>
                            </div>
                           <?php endforeach ?>
                        </div>

                        <div class="row" style="padding: 25px;">
                           <?php foreach($publicaciones as $publicacion): 
                                if(strlen($publicacion["titulo"]) > 30) {
                                    $publicacion["titulo_corto"] = $publicacion["titulo"];
                                }
                                else {
                                    $publicacion["titulo_corto"] = substr($publicacion["titulo"], 0, 30);
                                }
                            ?>
                            <div class="col-lg-3 col-md-4 col-xs-12">
                                <div class="snip1583" style="padding-left: 20px;padding-bottom: 20px;height: 380px;">
                                   <div class="content">
									<a href="empleos-detalle.php?a=<?php echo $publicacion["area_amigable"]; ?>&s=<?php echo $publicacion["sector_amigable"]; ?>&p=<?php echo $publicacion["amigable"]; ?>">
										<img src="empresa/img/<?php echo !$publicacion["imagen"] ? 'avatars/user.png' : $publicacion["imagen"]; ?>" alt="" style="padding: 40px;"/>
									</a>
                                    <?php if($publicacion["facebook"] != "" || $publicacion["twitter"] != "" || $publicacion["instagram"] != "" || $publicacion["linkedin"] != ""): ?>
                                       <div class="icons">
                                        <?php
                                            $facebook = "";
                                            $twitter = "";
                                            $instagram = "";
                                            $linkedin = "";
                                            if (strstr($publicacion["facebook"], 'http')) {
                                                $facebook = $publicacion["facebook"];
                                            }
                                            else {
                                                $facebook = "http://$publicacion[facebook]";
                                            }
                                            if (strstr($publicacion["twitter"], 'http')) {
                                                $twitter = $publicacion["twitter"];
                                            }
                                            else {
                                                $twitter = "http://$publicacion[twitter]";
                                            }
                                            if (strstr($publicacion["instagram"], 'http')) {
                                                $instagram = $publicacion["instagram"];
                                            }
                                            else {
                                                $instagram = "http://$publicacion[instagram]";
                                            }
                                            if (strstr($publicacion["linkedin"], 'http')) {
                                                $linkedin = $publicacion["linkedin"];
                                            }
                                            else {
                                                $linkedin = "http://$publicacion[linkedin]";
                                            }
                                        ?>

                                        <?php if($publicacion["facebook"] != ""): ?>
                                            <a href="<?php echo $facebook; ?>" title="Visitar Facebook de la empresa" style="width: 40px;"><i class="ti-facebook"></i></a>
                                        <?php endif ?>

                                        <?php if($publicacion["twitter"] != ""): ?>
                                            <a href="<?php echo $twitter; ?>" title="Visitar Twitter de la empresa" style="width: 40px;"><i class="ti-twitter"></i></a>
                                        <?php endif ?>

                                        <?php if($publicacion["instagram"] != ""): ?>
                                            <a href="<?php echo $instagram; ?>" title="Visitar Instagram de la empresa" style="width: 40px;"><i class="ti-instagram"></i></a>
                                        <?php endif ?>

                                        <?php if($publicacion["linkedin"] != ""): ?>
                                            <a href="<?php echo $linkedin; ?>" title="Visitar Linkedin de la empresa" style="width: 40px;"><i class="ti-linkedin"></i></a>
                                        <?php endif ?>
                                     </div>
                                    <?php endif ?>

                                    <?php if($publicacion["verificado"] == 1): ?>
                                        <div class="icons2">
                                            <i title="Empresa verificada" style="font-size: 30px;color: #dd8037;" class="ti-medall-alt"></i>
                                        </div>
                                    <?php endif ?>

                                    <div style="padding-right: 15px;">
                                       <div class="price"><a href="empleos-detalle.php?a=<?php echo $publicacion["area_amigable"]; ?>&s=<?php echo $publicacion["sector_amigable"]; ?>&p=<?php echo $publicacion["amigable"]; ?>"><?php echo $publicacion["empresa_nombre"]; ?></a></div>
                                        <h3><?php echo $publicacion["titulo_corto"]; ?></h3>
                                        <div class="price2"><?php echo $publicacion["area_nombre"]; ?></div>
                                    </div>
                                </div>
                                </div>
                            </div>
                           <?php endforeach ?>
                        </div>
                  </div>
              </div>
               
               <br>
               <br>
               <br>
               <br>
               <br>

				<?php
					
					/*
					<div class="row" style="padding: 25px;">
					<div class="col-md-3">
						<div class="box bg-white">
							<div class="box-block clearfix">
								<h5 class="pull-xs-left"><i class="ion-ios-list m-sm-r-1"></i> Ofertas de empleo por área</h5>
							</div>
							<table class="table m-md-b-0">
								<tbody>
									<?php foreach($areas as $area): ?>
										<?php if($area["cantidad"] > 0): ?>
											<tr>
												<td>
													<a class="text-primary" href="empleos.php?area=<?php echo $area["amigable"]; ?>&pagina=1"><span class="underline"><?php echo $area["nombre"]; ?></span></a>
												</td>
												<td>
													<span class="text-muted pull-xs-right"><?php echo $area["cantidad"]; ?></span>
												</td>
											</tr>
										<?php endif ?>
									<?php endforeach ?>
								</tbody>
							</table>
						</div>

						<div class="box bg-white">
							<div class="box-block clearfix">
								<h5 class="pull-xs-left"><i class="ion-calendar m-sm-r-1"></i> Fecha de publicación</h5>
							</div>
							<table class="table m-md-b-0">
								<tbody>
									<?php foreach($momentos as $momento): ?>
										<?php if($momento["cantidad"] > 0): ?>
											<tr>
												<td>
													<a class="text-primary" href="<?php echo "empleos.php?momento=$momento[amigable]"; ?>&pagina=1"><?php echo $momento["nombre"]; ?></a>
												</td>
												<td>
													<span class="text-muted pull-xs-right"><?php echo $momento["cantidad"]; ?></span>
												</td>
											</tr>
										<?php endif ?>
									<?php endforeach ?>						
								</tbody>
							</table>
						</div>
						
						<?php if($publicidadSection): ?>
							<div class="row" id="ad2">
								<?php foreach($publicidadSection as $p): ?>
									<?php
										$link = "";
										if (strstr($p["url"], 'http')) {
											$link = $p["url"];
										}
										else {
											$link = "http://$p[url]";
										}
									?>
									<div class="col-md-12">
										<div class="box bg-white product product-1">
											<div class="p-img img-cover" style="background-image: url(img/<?php echo $p["imagen"]; ?>);">
												<div class="p-status bg-warning"><?php echo $p["titulo"]; ?></div>
												<div class="p-links">
													<a href="<?php echo $link; ?>"><i class="ti-link"></i></a>
													<!--<a href="#"><i class="fa fa-star"></i></a>-->
												</div>
											</div>
										</div>
									</div>
								<?php endforeach ?>
							</div>
						<?php endif ?>

					</div>

					<div class="col-md-9">
						<h4>Principales ofertas de trabajo</h4>
						<div class="row row-sm">
							<?php foreach($publicacionesOro as $publicacion): ?>
								<div class="col-md-4">
									<a href="empleos-detalle.php?a=<?php echo $publicacion["area_amigable"]; ?>&s=<?php echo $publicacion["sector_amigable"]; ?>&p=<?php echo $publicacion["amigable"]; ?>">
										<div class="box bg-white post post-5 img-cover" style="background-image: url(empresa/img/<?php echo !$publicacion["imagen"] ? 'avatars/user.png' : $publicacion["imagen"]; ?>);">
											<div class="p-content">
												<?php if($publicacion["verificado"] == 1): ?>
													<span class="tag tag-warning"><i class="ti-medall-alt" title="Empresa verificada" style="z-index: 50;"></i></span>
												<?php endif ?>
												<h5 class="m-b-1" style="color: #f59345;">Publicación destacada</h5>
												<h5 class="m-b-1"><a class="text-white" href="empleos-detalle.php?a=<?php echo $publicacion["area_amigable"]; ?>&s=<?php echo $publicacion["sector_amigable"]; ?>&p=<?php echo $publicacion["amigable"]; ?>"><?php echo $publicacion["empresa_nombre"]; ?></a></h5>
												<p class="m-b-1"><?php echo strlen($publicacion["titulo"]) > 40 ? (substr($publicacion["titulo"], 0, 40).' <a href="empleos-detalle.php?a='.$publicacion["area_amigable"].'&s='.$publicacion["sector_amigable"].'&p='.$publicacion["amigable"].'">...</a>') : $publicacion["titulo"]; ?></p>
												<p class="small text-uppercase"><?php echo $publicacion["area_nombre"]; ?></p>
												<div class="p-info clearfix">
													<?php if($publicacion["sitio_web"] != "" || $publicacion["facebook"] != "" || $publicacion["twitter"] != "" || $publicacion["instagram"] != ""): ?>
														<?php
															$sitio_web = "";
															$facebook = "";
															$twitter = "";
															$instagram = "";
															if (strstr($publicacion["sitio_web"], 'http')) {
																$sitio_web = $publicacion["sitio_web"];
															}
															else {
																$sitio_web = "http://$publicacion[sitio_web]";
															}
															if (strstr($publicacion["facebook"], 'http')) {
																$facebook = $publicacion["facebook"];
															}
															else {
																$facebook = "http://$publicacion[facebook]";
															}
															if (strstr($publicacion["twitter"], 'http')) {
																$twitter = $publicacion["twitter"];
															}
															else {
																$twitter = "http://$publicacion[twitter]";
															}
															if (strstr($publicacion["instagram"], 'http')) {
																$instagram = $publicacion["instagram"];
															}
															else {
																$instagram = "http://$publicacion[instagram]";
															}
														?>
														<div class="share share-1" style="background-color: transparent; margin-top: -5px;">
															<div class="row no-gutter">
																<?php if($publicacion["sitio_web"] != ""): ?>
																	<div class="col-xs-3 s-item">
																		<a class="bg-primary" href="<?php echo $sitio_web; ?>" title="Ir a la web de la empresa">
																			<i class="ti-unlink"></i>
																		</a>
																	</div>
																<?php endif ?>
																<?php if($publicacion["facebook"] != ""): ?>
																	<div class="col-xs-3 s-item">
																		<a class="bg-facebook" href="<?php echo $facebook; ?>" title="Visitar Instagram de la empresa">
																			<i class="ti-facebook"></i>
																		</a>
																	</div>
																<?php endif ?>
																<?php if($publicacion["twitter"] != ""): ?>
																	<div class="col-xs-3 s-item">
																		<a class="bg-twitter" href="<?php echo $twitter; ?>" title="Visitar Instagram de la empresa">
																			<i class="ti-twitter"></i>
																		</a>
																	</div>
																<?php endif ?>
																<?php if($publicacion["instagram"] != ""): ?>
																	<div class="col-xs-3 s-item">
																		<a class="bg-instagram" href="<?php echo $instagram; ?>" title="Visitar Instagram de la empresa">
																			<i class="ti-instagram"></i>
																		</a>
																	</div>
																<?php endif ?>
															</div>
														</div>
													<?php endif ?>
												</div>
											</div>
										</div>
									</a>
								</div>
							<?php endforeach ?>
						</div>
						<div class="row row-sm">
							<?php foreach($publicacionesPlata as $publicacion): ?>
								<div class="col-md-4">
									<a href="empleos-detalle.php?a=<?php echo $publicacion["area_amigable"]; ?>&s=<?php echo $publicacion["sector_amigable"]; ?>&p=<?php echo $publicacion["amigable"]; ?>">
										<div class="box bg-white post post-3">
											<div class="p-img img-cover" style="background-image: url(empresa/img/<?php echo !$publicacion["imagen"] ? 'avatars/user.png' : $publicacion["imagen"]; ?>);"></div>
											<div class="p-content">
												<?php if($publicacion["verificado"] == 1): ?>
													<span class="tag tag-warning"><i class="ti-medall-alt" title="Empresa verificada" style="z-index: 50;"></i></span>
												<?php endif ?>
												<h5><a class="text-black" href="#"><?php echo $publicacion["empresa_nombre"]; ?></a></h5>
												<p class="m-b-0-5"><?php echo strlen($publicacion["titulo"]) > 40 ? ( '<span style="color: #373a3c;">'.substr($publicacion["titulo"], 0, 40).'</span>'.' <a href="empleos-detalle.php?a='.$publicacion["area_amigable"].'&s='.$publicacion["sector_amigable"].'&p='.$publicacion["amigable"].'">...</a>') : $publicacion["titulo"]; ?></p>
												<p class="small text-uppercase text-muted"><?php echo $publicacion["area_nombre"]; ?></p>
												<?php if($publicacion["sitio_web"] != "" || $publicacion["facebook"] != "" || $publicacion["twitter"] != "" || $publicacion["instagram"] != ""): ?>
													<?php
														$sitio_web = "";
														$facebook = "";
														$twitter = "";
														$instagram = "";
														if (strstr($publicacion["sitio_web"], 'http')) {
															$sitio_web = $publicacion["sitio_web"];
														}
														else {
															$sitio_web = "http://$publicacion[sitio_web]";
														}
														if (strstr($publicacion["facebook"], 'http')) {
															$facebook = $publicacion["facebook"];
														}
														else {
															$facebook = "http://$publicacion[facebook]";
														}
														if (strstr($publicacion["twitter"], 'http')) {
															$twitter = $publicacion["twitter"];
														}
														else {
															$twitter = "http://$publicacion[twitter]";
														}
														if (strstr($publicacion["instagram"], 'http')) {
															$instagram = $publicacion["instagram"];
														}
														else {
															$instagram = "http://$publicacion[instagram]";
														}
													?>
													<div class="share share-1" style="background-color: transparent; margin-top: -5px;">
														<div class="row no-gutter">
															<?php if($publicacion["sitio_web"] != ""): ?>
																<div class="col-xs-3 s-item">
																	<a class="bg-primary" href="<?php echo $sitio_web; ?>" title="Ir a la web de la empresa">
																		<i class="ti-unlink"></i>
																	</a>
																</div>
															<?php endif ?>
															<?php if($publicacion["facebook"] != ""): ?>
																<div class="col-xs-3 s-item">
																	<a class="bg-facebook" href="<?php echo $facebook; ?>" title="Visitar Instagram de la empresa">
																		<i class="ti-facebook"></i>
																	</a>
																</div>
															<?php endif ?>
															<?php if($publicacion["twitter"] != ""): ?>
																<div class="col-xs-3 s-item">
																	<a class="bg-twitter" href="<?php echo $twitter; ?>" title="Visitar Instagram de la empresa">
																		<i class="ti-twitter"></i>
																	</a>
																</div>
															<?php endif ?>
															<?php if($publicacion["instagram"] != ""): ?>
																<div class="col-xs-3 s-item">
																	<a class="bg-instagram" href="<?php echo $instagram; ?>" title="Visitar Instagram de la empresa">
																		<i class="ti-instagram"></i>
																	</a>
																</div>
															<?php endif ?>
														</div>
													</div>
												<?php endif ?>
											</div>
										</div>
										
									</a>
								</div>
							<?php endforeach ?>
						</div>
						<div class="row row-sm">
							<?php foreach($publicaciones as $publicacion): ?>
								<div class="col-md-4">
									<a href="empleos-detalle.php?a=<?php echo $publicacion["area_amigable"]; ?>&s=<?php echo $publicacion["sector_amigable"]; ?>&p=<?php echo $publicacion["amigable"]; ?>">
										<div class="pub box box-block bg-white" title="Ver detalles del empleo">
											<div class="row">
												<div class="col-md-4 col-sm-4 text-center">
													<img class="img-fluid b-a-radius-circle avatar" src="empresa/img/<?php echo !$publicacion["imagen"] ? 'avatars/user.png' : $publicacion["imagen"]; ?>" alt="">
												</div>
												<div class="col-md-8 col-sm-8">
													<?php if($publicacion["verificado"] == 1): ?>
														<span class="tag tag-warning" style="float: right;"><i class="ti-medall-alt" title="Empresa verificada" style="z-index: 50;"></i></span>
													<?php endif ?>
													<h5 style="color: #373a3c;"><?php echo $publicacion["empresa_nombre"]; ?></h5>
													<h6 style="color: #373a3c; width: 90%;"><?php echo strlen($publicacion["titulo"]) > 30 ? ( '<span style="color: #373a3c;">'.substr($publicacion["titulo"], 0, 30).'</span>'.' <a href="empleos-detalle.php?a='.$publicacion["area_amigable"].'&s='.$publicacion["sector_amigable"].'&p='.$publicacion["amigable"].'">...</a>') : $publicacion["titulo"]; ?></h6>
													<p style="color: #373a3c;"><?php echo $publicacion["area_nombre"]; ?></p>
													
													<?php if($publicacion["facebook"] != "" || $publicacion["twitter"] != "" || $publicacion["instagram"] != ""): ?>
														<?php
															$facebook = "";
															$twitter = "";
															$instagram = "";
															if (strstr($publicacion["facebook"], 'http')) {
																$facebook = $publicacion["facebook"];
															}
															else {
																$facebook = "http://$publicacion[facebook]";
															}
															if (strstr($publicacion["twitter"], 'http')) {
																$twitter = $publicacion["twitter"];
															}
															else {
																$twitter = "http://$publicacion[twitter]";
															}
															if (strstr($publicacion["instagram"], 'http')) {
																$instagram = $publicacion["instagram"];
															}
															else {
																$instagram = "http://$publicacion[instagram]";
															}
														?>
														<div class="share share-1" style="background-color: transparent;">
															<div class="row no-gutter">
																<div class="col-xs-3 s-item">
																	<a class="bg-white" href="" style="background-color:  transparent !important;"></a>
																</div>
																<?php if($publicacion["facebook"] != ""): ?>
																	<div class="col-xs-3 s-item">
																		<a class="bg-facebook" href="<?php echo $facebook; ?>" title="Visitar Instagram de la empresa">
																			<i class="ti-facebook"></i>
																		</a>
																	</div>
																<?php endif ?>
																<?php if($publicacion["twitter"] != ""): ?>
																	<div class="col-xs-3 s-item">
																		<a class="bg-twitter" href="<?php echo $twitter; ?>" title="Visitar Instagram de la empresa">
																			<i class="ti-twitter"></i>
																		</a>
																	</div>
																<?php endif ?>
																<?php if($publicacion["instagram"] != ""): ?>
																	<div class="col-xs-3 s-item">
																		<a class="bg-instagram" href="<?php echo $instagram; ?>" title="Visitar Instagram de la empresa">
																			<i class="ti-instagram"></i>
																		</a>
																	</div>
																<?php endif ?>
															</div>
														</div>
													<?php endif ?>
												</div>
											</div>
										</div>
									</a>
								</div>
							<?php endforeach ?>
						</div>					
						<?php if($publicaciones_especiales): ?>
							<h4>Productos</h4>
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
					*/
					
				?>

			<?php endif ?>
			<br>
			<?php require_once('includes/footer.php'); ?>

		</div>

		<?php require_once('includes/libs-js.php'); ?>

		<script>
			var c = "";
			var ad = null;
			
			/*< ?php if($publicidad): ?>
				ad = setInterval(function() {
					$.ajax({
						type: 'POST',
						url: 'admin/ajax/publicidad.php',
						data: 'op=6',
						dataType: 'json',
						success: function(data) {
							$("#ad").html("");
							data.forEach(function(p) {
								$("#ad").append('<div class="col-md-3"> <div class="box bg-white product product-1"> <div class="p-img img-cover" style="background-image: url(img/'+p.imagen+');"> <div class="p-status bg-warning">'+p.titulo+'</div> <div class="p-links"> <a href="'+p.url+'"><i class="ti-link"></i></a> <!--<a href="#"><i class="fa fa-star"></i></a>--> </div> </div> </div> </div>');
							});
						}
					});
				}, 5000);
			< ?php endif ?>*/
			
			function applyFilter() {
				window.location.assign('trabajadores.php?calificacion=' + c);
			}
			
			$(document).ready(function(){
				$("#search").click(function() {
					var s = $("#search-input").val();
					if(s.trim() == "") {
						swal("Error!", "El campo de búsqueda esta vacío.", "error");
					}
					else {
						window.location.assign("empleos.php?busqueda=" + s + "&pagina=1");
					}
				});
				$("#search-w").click(function() {
					var s = $("#search-input-w").val();
					if(s.trim() == "") {
						swal("Error!", "El campo de búsqueda esta vacío.", "error");
					}
					else {
						window.location.assign("trabajadores.php?busqueda=" + s + "&pagina=1");
					}
				});
				
				$("input[type=checkbox][name=rating]").on('change', function() {
					var x = "";
					var arr = $("input[type=checkbox][name=rating]:checked");
					$(arr).each(function(indx, el) {
						x += el.value;
					});
					switch(x) {
						case "1":
							c = "cinco-estrellas";
							break;
						case "2":
							c = "cuatro-estrellas";
							break;
						case "3":
							c = "tres-estrellas";
							break;
						case "123":
							c = "de-cinco-a-tres-estrellas";
							break;
						case "12":
							c = "de-cinco-a-cuatro-estrellas";
							break;
						case "13":
							c = "de-cinco-a-tres-estrellas";
							break;
						case "23":
							c = "de-cuatro-a-tres-estrellas";
							break;
					}
					if(c == "") {
						$(".link-area").each(function(i, e) {
							$(e).attr('href', 'trabajadores.php?area=' + $(e).attr('data-area') + '&pagina=1');
						});
					}
					else {
						$(".link-area").each(function(i, e) {
							$(e).attr('href', 'trabajadores.php?area=' + $(e).attr('data-area') + '&calificacion=' + c + '&pagina=1');
						});
					}
				});
			});
		</script>
	</body>
</html>