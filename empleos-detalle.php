<?php
	session_start();
	require_once('classes/DatabasePDOInstance.function.php');
	require_once('slug.function.php');

	function formatDate($dateMayor, $dateMenor){
		$menor = new DateTime($dateMenor);
		$mayor = new DateTime(date($dateMayor));
		$intervalo = $mayor->diff($menor);

		if ($intervalo->format("%m") != 0) {
			$m = $intervalo->format("%m") == 1 ? "mes" : "meses";
			return $intervalo->format("Hace %m $m");
		} elseif ($intervalo->format("%a") != 0){
			$d = $intervalo->format("%a") == 1 ? "día" : "días";
			return $intervalo->format("Hace %a $d");
		} elseif ($intervalo->format("%h") != 0){
			$h = $intervalo->format("%h") == 1 ? "hora" : "horas";
			return $intervalo->format("Hace %h $h");
		} elseif ($intervalo->format("%i") != 0){
			return $intervalo->format("Hace %i min");
		} else {
			return $intervalo->format("Hace %s seg");
		}
	}

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
			p.fecha_actualizacion,
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
		WHERE (a.id = $publicacion[area_id] AND ase.id = $publicacion[sector_id]) AND p.id != $publicacion[id] AND (e.suspendido IS NULL OR e.suspendido = 0) AND p.estatus=1
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
		<!-- <div class="wrapper" style="background-color: white;"> -->
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
				<div class="container container-resp">
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

							<div class="box bg-white product-view col-md-12 no-padding">
								<div class="box-block">
									<div style="margin-bottom: 0px;">
										<!-- <a href="empresa/perfil.php?e=<?php echo strtolower(str_replace(" ", "-", $publicacion["empresa_nombre"]))."-$publicacion[empresa_id]"; ?>"><?php echo $publicacion["empresa_nombre"]; ?></a> -->
										
										<div class="pv-title col-md-12">
											<a style="font-size: 20px;" href="empresa/perfil.php?e=<?php echo strtolower(str_replace(" ", "-", $publicacion["empresa_nombre"]))."-$publicacion[empresa_id]"; ?>"><?php echo $publicacion["empresa_nombre"]; ?></a>
											<?php echo $publicacion["titulo"]; ?>
											<span class="pull-right text-muted"><small><?= formatDate(date("Y-m-d H:i:s"), $publicacion["fecha_actualizacion"]) ?></small></span>	
											<div style="font-size: 13px;color: #999;text-transform: none;"><?php echo $publicacion["area_nombre"]; ?> / <?php echo $publicacion["sector_nombre"]; ?></div>
											<?php if($publicacion["logo_home"] == 3): ?>
												<div class="icon-medal"><span class="bg-warning"></span><i class="ti-medall-alt" title="Publicación destacada" style="z-index: 50;"></i></div>
											<?php else: ?>
												<?php if($publicacion["logo_home"] == 2): ?>
												
												<?php endif ?>
											<?php endif ?>

											<?php 
												$permalink = urlencode("http://www.jobbersargentina.com/empleos-detalle.php?".$_SERVER["QUERY_STRING"]);
											?>
											<div class="socialLinks"> 
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

													<!-- Instagram -->
													<!-- <a href="http://www.facebook.com/sharer/sharer.php?u=<URL>" target="_blank" class="share-btn instagram">
														<i class="fa fa-instagram"></i>
													</a> -->

													<!-- Email -->
													<!-- <a href="mailto:?subject=<SUBJECT&body=<BODY>" target="_blank" class="share-btn email">
														<i class="fa fa-envelope"></i>
													</a> -->
												<!-- <a target="_blank" href="http://facebook.com/sharer.php?u=<?php echo $permalink;?>" class="btn btn-primary btn-social-fb">Compartir <i class="fa fa-facebook"></i></a>
												<a target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $permalink;?>" class="btn btn-primary btn-social-link">Compartir <i class="fa fa-linkedin"></i></a>
												<a href="#" class="btn btn-primary btn-social-tw">Compartir <i class="fa fa-twitter"></i></a>
												<a href="#" class="btn btn-primary btn-social-ig">Compartir <i class="fa fa-instagram"></i></a> -->
											</div>
											
											<?php if($contratado): ?>
												<?php echo $contratado["finalizado"] == 0 &&  $contratado["cancelado"] != 1 ? '<span style="position: absolute; top: 5px; right: 5px; font-size: 18px;" class="tag tag-success"><i class="ti ti-reload"></i> Trabajando</span>': '<span style="position: absolute; top: 5px; right: 5px; font-size: 18px;" class="tag tag-success"><i class="ti ti-check"></i> Finalizado</span>';?>
											<?php else: ?>
												<?php if($postulado): ?>
													<span style="position: absolute; top: 5px; right: 5px; font-size: 18px; cursor: auto" class="btn btn-primary btn-postular waves-effect waves-light">Postulado</span>
												<?php endif ?>	
											<?php endif ?>
										</div>
										<div class="col-md-12">
											<b>Disponibilidad: <?php echo $publicacion["disponibilidad"]; ?></b>

											<?php echo $publicacion["descripcion"]; ?>
											
											<?php if($publicacion["coordenadas"] != ""): ?>
												<h6>Ubicación del empleo</h6>
												<div id="map" style="height: 450px;width: 100%; margin-bottom: 30px;"></div>
											<?php endif ?>
											
											<?php if(!$postulado && $esTrabajador): ?>
												<?php if(!$contratado): ?>
													<div class="col-md-12 content-btn-postulate text-center">
														<button id="postulate" type="button" class="col-md-6 col-md-offset-3 btn btn-primary btn-postular waves-effect waves-light" style="font-size:20px">Postularme</button>
													</div>
												<?php endif ?>
											<?php endif ?>
										</div>

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
		<!-- </div> -->

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
						
						$(this).addClass('disabled'); // Desactivar el botón al presionarlo.

						if(postulate == 1) {
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
											$(".pv-title").prepend('<span style="position: absolute; top: 5px; right: 5px; font-size: 18px; cursor: auto" class="btn btn-primary btn-postular waves-effect waves-light">Postulado</span>');
											$("#postulate").closest('div').remove();
											swal("Operación exitosa!", "Se ha enviado la solicitud para el empleo seleccionado.<br>La empresa se pondrá en contacto contigo si está interesada.", "success");
										} else {
											console.log("Error:", json.console);
											swal("Error", json.msg, "error");
										}
									break;
								}
							});
						}
						else {
							$(this).removeClass('disabled');
							swal("Información", 'Su perfil no esta completo para poder postularse a un empleo, los requisitos minimos son:<br> (1) Tener foto de perfil.<br> (2) Completar todos los datos del paso 1 en el Currículum. <br> para ir a completar mis datos haga click <a href="cuenta.php">aquí</a>', "info");
						}
					});
				<?php else: ?>
					$("#postulate").click(function() {
						window.location.assign('ingresar.php?returnUri=' + '<?php echo urlencode("empleos-detalle.php?$_SERVER[QUERY_STRING]"); ?>');
					});
				<?php endif ?>
			});
		</script>
	</body>
</html>