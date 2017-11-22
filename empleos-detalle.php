<?php
	session_start();
	require_once('classes/DatabasePDOInstance.function.php');
	require_once('slug.function.php');

	$esTrabajador = (isset($_SESSION["ctc"]["type"]) && $_SESSION["ctc"]["type"] == 2) || !isset($_SESSION["ctc"]);
	$infoT = (isset($_SESSION["ctc"]) && $esTrabajador) ? $_SESSION["ctc"] : null;

	$db = DatabasePDOInstance();

	$a = isset($_REQUEST["a"]) ? $_REQUEST["a"] : false;
	$s = isset($_REQUEST["s"]) ? $_REQUEST["s"] : false;
	$p = isset($_REQUEST["p"]) ? $_REQUEST["p"] : false;

	$publicacion = $db->getRow("
		SELECT
			p.id,
			p.titulo,
			p.descripcion,
			p.coordenadas,
			e.nombre AS empresa_nombre,
			e.id AS empresa_id,
			e.sitio_web,
			e.facebook,
			e.twitter,
			e.instagram,
			a.id AS area_id,
			a.nombre AS area_nombre,
			a.amigable AS area_amigable,
			ase.id AS sector_id,
			pl.link_empresa,
			pl.logo_home,
			ase.amigable AS sector_amigable,
			ase.nombre AS sector_nombre,
			d.nombre as disponibilidad
		FROM
			publicaciones AS p
		INNER JOIN publicaciones_sectores AS ps ON p.id = ps.id_publicacion
		INNER JOIN areas_sectores AS ase ON ps.id_sector = ase.id
		INNER JOIN areas AS a ON ase.id_area = a.id
		INNER JOIN empresas AS e ON p.id_empresa = e.id
		INNER JOIN empresas_planes AS pl ON p.id_empresa = pl.id_empresa
		INNER JOIN disponibilidad AS d ON d.id = p.disponibilidad
		WHERE p.amigable = '$p' AND a.amigable = '$a' AND ase.amigable = '$s'
	");

	$publicacionesSimilares = $db->getAll("
		SELECT
			p.id,
			p.titulo,
			p.descripcion,
			p.amigable,
			CONCAT(img.directorio, '/', img.nombre,'.' ,img.extension) AS empresa_imagen,
			e.nombre AS empresa_nombre,
			a.id AS area_id,
			a.nombre AS area_nombre,
			a.amigable AS area_amigable,
			ase.id AS sector_id,
			ase.amigable AS sector_amigable,
			ase.nombre AS sector_nombre,
			d.nombre as disponibilidad

		FROM
			publicaciones AS p
		INNER JOIN publicaciones_sectores AS ps ON p.id = ps.id_publicacion
		INNER JOIN areas_sectores AS ase ON ps.id_sector = ase.id
		INNER JOIN areas AS a ON ase.id_area = a.id
		INNER JOIN empresas AS e ON p.id_empresa = e.id
		INNER JOIN disponibilidad AS d ON d.id = p.disponibilidad
		LEFT JOIN imagenes AS img ON e.id_imagen = img.id
		WHERE (a.id = $publicacion[area_id] AND ase.id = $publicacion[sector_id]) AND p.id != $publicacion[id]
		ORDER BY RAND()
		LIMIT 5
	");

	$postulado = $infoT ? $db->getOne("
		SELECT
			id
		FROM
			postulaciones
		WHERE id_publicacion = $publicacion[id] AND id_trabajador = $infoT[id]
	") : false;
	
	$contratado = $db->getRow("SELECT finalizado, cancelado FROM empresas_contrataciones WHERE id_publicacion=$publicacion[id]");

	$publicidadSection = $db->getAll("SELECT publicidad.titulo, publicidad.url, publicidad.tipo_publicidad, CONCAT(imagenes.directorio,'/', imagenes.nombre,'.', imagenes.extension) AS imagen FROM publicidad INNER JOIN imagenes ON imagenes.id=publicidad.id_imagen WHERE publicidad.mi_publicidad=0 ORDER BY RAND() LIMIT 4");
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
		<title>JOBBERS - <?php echo "$publicacion[area_nombre] - $publicacion[sector_nombre] - $publicacion[titulo]"; ?></title>
		<?php require_once('includes/libs-css.php'); ?>
		<link rel="stylesheet" href="vendor/ionicons/css/ionicons.min.css">
	</head>
	<body class="large-sidebar fixed-sidebar fixed-header skin-5">
		<div class="wrapper" style="background-color: white;">
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
						<div class="col-md-9">
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

							<div class="box bg-white product-view m-b-2">
								<div class="box-block">
									<div class="pv-content" style="margin-bottom: 0px;">
										<a href="empresa/perfil.php?e=<?php echo strtolower(str_replace(" ", "-", $publicacion["empresa_nombre"]))."-$publicacion[empresa_id]"; ?>"><?php echo $publicacion["empresa_nombre"]; ?></a>
										<div class="pv-title" style="padding-right: 130px;">
											<?php echo $publicacion["titulo"]; ?>	
											<div style="font-size: 13px;color: #999;text-transform: none;"><?php echo $publicacion["area_nombre"]; ?> / <?php echo $publicacion["sector_nombre"]; ?></div>
											<?php if($publicacion["logo_home"] == 3): ?>
												<div class="t-icon right" style="float: right;"><span class="bg-warning"></span><i class="ti-medall-alt" title="Publicación destacada" style="z-index: 50;"></i></div>
											<?php else: ?>
												<?php if($publicacion["logo_home"] == 2): ?>
												
												<?php endif ?>
											<?php endif ?>
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
												<div class="fb-share-button" data-href="http://www.jobbersargentina.com/empleos-detalle.php?<?php echo $_SERVER["QUERY_STRING"]; ?>" data-layout="button" data-size="small" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse"></a></div>
												
												<style>
													.fb_iframe_widget span {
														position: absolute;
														top: -37px;
														margin-bottom: 10px;
													}


													.IN-widget {
														margin-left: 120px;
														position: absolute;
														z-index: 999;
														margin-top: -8px;
														margin-bottom: 20px;
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
												<script type="IN/Share" data-url="http://www.jobbersargentina.com/empleos-detalle.php?<?php echo $_SERVER["QUERY_STRING"]; ?>"></script>
											</div>
											<?php if($contratado): ?>
												<?php echo $contratado["finalizado"] == 0 &&  $contratado["cancelado"] != 1 ? '<span style="position: absolute; top: 5px; right: 5px; font-size: 18px;" class="tag tag-success"><i class="ti ti-reload"></i> Trabajando</span>': '<span style="position: absolute; top: 5px; right: 5px; font-size: 18px;" class="tag tag-success"><i class="ti ti-check"></i> Finalizado</span>';?>
											<?php else: ?>
												<?php if($postulado): ?>
													<span style="position: absolute; top: 5px; right: 5px; font-size: 18px;" class="tag tag-primary">Postulado</span>
												<?php endif ?>	
											<?php endif ?>
										</div>
										Disponibilidad: <?php echo $publicacion["disponibilidad"]; ?>
										<?php echo $publicacion["descripcion"]; ?>
										
										<?php if($publicacion["coordenadas"] != ""): ?>
											<h6>Ubicación del empleo</h6>
											<div id="map" style="height: 450px;width: 100%;"></div>
										<?php endif ?>
										
										<?php if(!$postulado && $esTrabajador): ?>
											<?php if(!$contratado): ?>
												<div style="padding: 11px;">
													<button id="postulate" type="button" class="btn btn-primary w-min-sm m-b-0-25 waves-effect waves-light">Postularme</button>
												</div>
											<?php endif ?>
										<?php endif ?>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<?php if(count($publicacionesSimilares) > 0): ?>
							<div class="card">
								<div class="card-header text-uppercase"><b>Ofertas de empleo similares</b></div>
									<div class="items-list">
										<?php foreach($publicacionesSimilares as $pub): ?>
											<div class="il-item">
												<a class="text-black" href="empleos-detalle.php?a=<?php echo $pub["area_amigable"]; ?>&s=<?php echo $pub["sector_amigable"]; ?>&p=<?php echo $pub["amigable"]; ?>">
													<div class="media">
														<div class="media-left">
															<div class="avatar box-48">
																<img class="b-a-radius-0-125" src="empresa/img/<?php echo $pub["empresa_imagen"] ? $pub["empresa_imagen"] : "avatars/user.png"; ?>" alt="">
															</div>
														</div>
														<div class="media-body">
															<h6 class="media-heading"><?php echo $pub["empresa_nombre"]; ?></h6>
															<span class="text-muted"><?php echo $pub["titulo"]; ?></span>
														</div>
													</div>
													<div class="il-icon"><i class="fa fa-angle-right"></i></div>
												</a>
											</div>
										<?php endforeach ?>
									</div>
									<div class="card-block">
										<a class="btn btn-primary btn-block" href="empleos.php?area=<?php echo $publicacion["area_amigable"]; ?>&sector=<?php echo $publicacion["sector_amigable"]; ?>&pagina=1">Ver todas</a>
									</div>
								</div>
							<?php endif ?>
						</div>
					</div>
				</div>
				<?php require_once('includes/footer.php'); ?>
			</div>
		</div>

		<?php require_once('includes/libs-js.php'); ?>
		<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDCRpfonUZFqzxwKgXqDHuYCVZJloPBGfg"></script>
		
		<script>
			var map = null;
			var marker1 = null;
			var marker2 = null;
			
			function handleLocationError(browserHasGeolocation, pos) {
				marker1 = new google.maps.Marker({
					position: pos,
					map: map,
					title: 'Ubicación del empleo'
				});
			}
			
			function geocodeLatLng(geocoder, map, marker) {
				var latlng = marker.getPosition();
				geocoder.geocode({
					'location': latlng
				}, function (results, status) {
					if (status === google.maps.GeocoderStatus.OK) {
						if (results[1]) {
							console.log(results[1].formatted_address);
						} else {
							console.log(latlng.lat() + ', ' + latlng.lng());
						}
					} else {
						console.log(latlng.lat() + ', ' + latlng.lng());
					}
				});
			}
			
			function initMap() {
				
				var directionsService = new google.maps.DirectionsService();
				var directionsDisplay = new google.maps.DirectionsRenderer();
				
				var coord = "<?php echo $publicacion["coordenadas"]; ?>";
				coord = coord.split(",");
				map = new google.maps.Map(document.getElementById('map'), {
					center: {lat: parseFloat(coord[0]), lng: parseFloat(coord[1])},
					zoom: 6
				  });
				
				var bounds = new google.maps.LatLngBounds();
				
				bounds.extend(new google.maps.LatLng(parseFloat(coord[0]), parseFloat(coord[1])));
				
				geocoder = new google.maps.Geocoder;
				
				/* marker1 = new google.maps.Marker({
					position: {lat: parseFloat(coord[0]), lng: parseFloat(coord[1])},
					map: map,
					title: 'Ubicación del empleo'
				  });*/
				
				if (navigator.geolocation) {
					navigator.geolocation.getCurrentPosition(function(position) {
					  var pos = {
						lat: position.coords.latitude,
						lng: position.coords.longitude
					  };
						
					 bounds.extend(new google.maps.LatLng(position.coords.latitude, position.coords.longitude));

					  /*marker2 = new google.maps.Marker({
						position: pos,
						map: map,
						title: 'Mi ubicación'
					  });*/
						
						directionsService.route({
							origin: new google.maps.LatLng(parseFloat(coord[0]), parseFloat(coord[1])),
							destination: new google.maps.LatLng(position.coords.latitude, position.coords.longitude),
							travelMode: google.maps.TravelMode.DRIVING
						},
						function(result, status) {
							if (status == google.maps.DirectionsStatus.OK) {
								directionsDisplay.setDirections(result);
								directionsDisplay.setMap(map);
								console.log(result);
								/*var distance = result.rows[0].elements[0].distance.text;
            					var duration = result.rows[0].elements[0].duration.text;
								console.log(distance);
								console.log(duration);*/

							}
							else {
								alert("Directions Request failed:" +status);
							}
						});
						
					map.fitBounds(bounds);

					}, function() {
					  handleLocationError(true, map.getCenter());
					});
				  } else {
					// Browser doesn't support Geolocation
					handleLocationError(false, map.getCenter());
				  }
			}
			
			$(function() {
				
				<?php if($publicacion["coordenadas"] != ""): ?>
					initMap();
				<?php endif ?>
				
				$("#socialLinks .btn").click(function(){
					window.location.assign($(this).attr("data-url"));
				});
				var postulate = parseInt('<?php echo isset($_SESSION["ctc"]) ? (isset($_SESSION["ctc"]["postulate"]) ? $_SESSION["ctc"]["postulate"] : 0) : 2; ?>');
				
				<?php if(!$postulado && $infoT && isset($_SESSION["ctc"])): ?>
					$("#postulate").click(function() {
						if(postulate == 1) {
							$(this).addClass('disabled');
							$.ajax({
								url: 'ajax/misc.php',
								type: 'GET',
								data: {
									op: 2,
									idp: <?php echo $publicacion["id"]; ?>,
									idt: <?php echo $infoT["id"]; ?>
								}
							}).done(function(data, textStatus, jqXHR) {						
								switch(jqXHR.status) {
									case 200:
										var json = JSON.parse(jqXHR.responseText);
										if(json.msg == "OK") {
											$(".pv-title").prepend('<span style="position: absolute; top: 5px; right: 5px; font-size: 18px;" class="tag tag-primary">Postulado</span>');
											$("#postulate").closest('div').remove();
											swal("Operación exitosa!", "Se ha enviado la solicitud para el empleo seleccionado.<br>La empresa se pondrá en contacto contigo si está interesada.", "success");
										}
									break;
								}
							});
						}
						else {
							$(this).removeClass('disabled')
							swal("Información", 'Su perfil no esta completo para poder postularse a un empleo, los requisitos minimos son:<br> (1) Tener foto de perfil.<br> (2) Completar todos los datos del paso 1 en el Currículum. <br> para ir a completar mis datos haga click <a href="cuenta.php">aquí</a>', "info");
						}
					});
				<?php else: ?>
					$("#postulate").click(function() {
						window.location.assign('registro.php?redirect=' + '<?php echo urlencode("empleos-detalle.php?$_SERVER[QUERY_STRING]"); ?>');
					});
				<?php endif ?>
			});
		</script>
	</body>
</html>