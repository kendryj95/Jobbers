<?php
	session_start();
	if (isset($_SESSION["ctc"])) {
		if (!isset($_SESSION["ctc"]["empresa"])) {
			header("Location: ../");
		}
	} else {
		header("Location: acceder.php");
	}

	require_once('../classes/DatabasePDOInstance.function.php');

	$db = DatabasePDOInstance();

    $empresa_nueva = $db->getRow("SELECT id_imagen FROM empresas WHERE id=".$_SESSION['ctc']['empresa']['id']);
    $plan = $db->getRow("SELECT ep.id_plan, p.nombre FROM empresas_planes ep INNER JOIN planes p ON ep.id_plan = p.id WHERE ep.id_empresa=".$_SESSION['ctc']['empresa']['id']);

    if ($_SESSION['ctc']['type'] == 1) {
        $_SESSION['ctc']['plan']['id_plan'] = $plan['id_plan'];
        $_SESSION["ctc"]["plan"]["nombre"] = $plan['nombre'];
    }

	$areas = $db->getAll("
		SELECT id, nombre FROM areas
	");

	if($areas === false) {
		$areas = array();
	}

	$sectores = $db->getAll("
		SELECT id, id_area, nombre FROM areas_sectores
	");

	if($sectores === false) {
		$sectores = array();
	}
		$disps = $db->getAll("SELECT id, nombre, nombre FROM disponibilidad");

	if($disps === false) {
		$disps = array();
	}
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
		<title>JOBBERS - Publicaciones</title>
		<?php require_once('../includes/libs-css.php'); ?>

		<link rel="stylesheet" href="../vendor/DataTables/css/dataTables.bootstrap4.min.css">
		<link rel="stylesheet" href="../vendor/DataTables/Responsive/css/responsive.bootstrap4.min.css">
		<link rel="stylesheet" href="../vendor/DataTables/Buttons/css/buttons.dataTables.min.css">
		<link rel="stylesheet" href="../vendor/DataTables/Buttons/css/buttons.bootstrap4.min.css">
		
		<link rel="stylesheet" href="../vendor/select2/dist/css/select2.min.css">
		<link rel="stylesheet" href="../vendor/dropify/dist/css/dropify.min.css">
		<style>
			th.dt-center, td.dt-center { text-align: center; }
			
			.swal2-modal {
				border: 1px solid rgb(223, 223, 223);
			}
			
			#tablaPostulados {
				width: 100% !important;
			}
		</style>
	</head>

	<body class="large-sidebar fixed-sidebar fixed-header skin-5">
		<div class="wrapper">

			<!-- Preloader 
			<div class="preloader"></div>-->

			<!-- Sidebar -->
			<?php require_once('../includes/sidebar.php'); ?>

			<!-- Sidebar second -->
			<?php require_once('../includes/sidebar-second.php'); ?>

			<!-- Header -->
			<?php require_once('../includes/header.php'); ?>

			<div class="site-content">
				<!-- Content -->
				<div class="content-area p-y-1">
					<div class="container-fluid">
						<div class="box box-block bg-white">
							<h5 class="m-b-1">Mis publicaciones</h5>
							<div class="m-b-1">
								<a href="#" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#modal-agregar-publicacion" id="agregar-publicacion"><span class="ti-plus"></span> Agregar</a>
								
								<?php if($_SESSION["ctc"]["plan"]["id_plan"] == 4): ?>
									<a href="#" class="btn btn-warning waves-effect waves-light" data-toggle="modal" data-target="#modal-agregar-publicacion-especial"> Agregar/modificar publicación especial</a>
								<?php endif ?>
							</div>
							<table class="table table-striped table-bordered dataTable" id="tablaPublicaciones">
								<thead>
									<tr>
										<th>#</th>
										<th>Título</th>
										<th>Descripción</th>
										<th>Postulados</th>
										<th>Creación Pub.</th>
										<th>Final Pub.</th>
										<th>Acciones</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<!-- Footer -->
				<?php require_once('../includes/footer.php'); ?>
			</div>
		</div>
		
		<style>
			.controls {
			  margin-top: 10px;
			  border: 1px solid transparent;
			  border-radius: 2px 0 0 2px;
			  box-sizing: border-box;
			  -moz-box-sizing: border-box;
			  height: 32px;
			  outline: none;
			  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
			}
			
			.pac-container {
				/*display: block !important;*/
				z-index: 9999;
			}
		</style>
		
		<div class="modal fade" id="contactM" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title">Contacta al jobber</h4>
					</div>
					<div class="modal-body">
						<form>
							<div class="form-group">
								<label for="messageText" class="form-control-label">Escribe tu mensaje:</label>
								<textarea class="form-control" id="messageText"></textarea>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
						<button type="button" class="btn btn-primary" id="sendMesage">Enviar</button>
					</div>
				</div>
			</div>
		</div>
		
		<div id="modal-agregar-publicacion" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h4 class="modal-title">Agregar publicación</h4>
					</div>
					<div class="modal-body">
						<ul class="nav nav-tabs nav-tabs-2">
							<li class="nav-item">
								<a class="nav-link active" href="#modal-agregar-publicacion-info" data-toggle="tab"><i class="ti-info text-muted m-r-0-25"></i> Información</a>
							</li>
							<!--<li class="nav-item">
								<a class="nav-link" href="#modal-agregar-publicacion-imagenes" data-toggle="tab"><i class="ti-gallery text-muted m-r-0-25"></i> Imágenes</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="#modal-agregar-publicacion-videos" data-toggle="tab"><i class="ti-video-clapper text-muted m-r-0-25"></i> Videos</a>
							</li>-->
						</ul>
						<div class="tab-content" style="padding: 25px;">
						  <div id="modal-agregar-publicacion-info" class="tab-pane fade in active">
							<form>
								<div class="form-group">
									<label for="select2-demo-1" class="form-control-label">Área</label>
									<select id="select2-demo-1" class="form-control" data-plugin="select2">
										<?php foreach($areas as $area): ?>
											<option value="<?php echo $area["id"]; ?>"><?php echo $area["nombre"]; ?></option>
										<?php endforeach ?>
									</select>
								</div>
								<div class="form-group">
									<label for="select2-demo-2" class="form-control-label">Sector</label>
									<select id="select2-demo-2" class="form-control" data-plugin="select2">
										<?php
											if(count($areas) > 0) {
												$area = $areas[0];
											}
										?>
										<?php foreach($sectores as $sector): ?>
											<?php if($sector["id_area"] == $area["id"]): ?>
												<option value="<?php echo $sector["id"]; ?>"><?php echo $sector["nombre"]; ?></option>
											<?php endif ?>
										<?php endforeach ?>
									</select>
								</div>
								<div class="form-group">
									<label for="select2-demo-3" class="form-control-label">Disponibilidad</label>
									<select id="select2-demo-3" class="form-control" data-plugin="select2">
										<?php foreach($disps as $disp): ?>
											<option value="<?php echo $disp["id"]; ?>"><?php echo $disp["nombre"]; ?></option>
										<?php endforeach ?>
									</select>
								</div>
								<div class="form-group">
									<label for="modal-agregar-publicacion-titulo">Título</label>
									<input type="text" class="form-control" id="modal-agregar-publicacion-titulo" placeholder="">
								</div>
								<div class="form-group">
									<label for="modal-agregar-publicacion-descripcion">Descripción</label>
									<texarea id="modal-agregar-publicacion-descripcion"></texarea>
								</div>
								<h6>Agregar ubicación del empleo</h6>
								<div class="form-group">
									<label for="modal-agregar-publicacion-ubicacion">Escribe la ubicación</label>
									<input type="text" class="form-control controls" id="modal-agregar-publicacion-ubicacion" placeholder="">
								</div>
								<div id="map" style="height: 250px;width: 100%;"></div>
							</form>
						  </div>
						  <!--<div id="modal-agregar-publicacion-imagenes" class="tab-pane fade">
							<h3>Imágenes</h3>
						  </div>
						  <div id="modal-agregar-publicacion-videos" class="tab-pane fade">
							<h3>Videos</h3>
						  </div>-->
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" id="modal-agregar-publicacion-enviar-form">Aceptar</button>
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
					</div>
				</div>
			</div>
		</div>
		
		<div id="modal-agregar-publicacion-especial" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h4 class="modal-title">Agregar/Modificar publicación especial</h4>
					</div>
					<div class="modal-body">
						<h6 class="m-t-2">Qué desea agregar?</h6>
						<label class="custom-control custom-radio">
							<input id="radio1" name="opcion" class="custom-control-input" type="radio" value="1">
							<span class="custom-control-indicator"></span>
							<span class="custom-control-description">Un producto de venta</span>
						</label>
						<label class="custom-control custom-radio">
							<input id="radio2" name="opcion" class="custom-control-input" type="radio" value="2">
							<span class="custom-control-indicator"></span>
							<span class="custom-control-description">Un video</span>
						</label>
						<div id="venta" style="display: none;">
							<form method="POST" id="upload">
								<div class="form-group">
									<label for="producto">Nombre del producto</label>
									<input class="form-control" id="producto" name="titulo" placeholder="Nombre" type="text">
								</div>
								<div class="form-group">
									<label for="descripcionProducto">Descripción</label>
									<textarea class="form-control" id="descripcionProducto" name="descripcion" rows="3"></textarea>
								</div>
								<h6 class="m-t-2">Agrega una foto</h6>
								<input class="dropify" name="file" id="file" type="file">
							</form>
						</div>
						<div id="video" style="display: none;">
							<div class="form-group">
								<label for="tituloVideo">Título</label>
								<input class="form-control" id="tituloVideo" placeholder="Título" type="text">
							</div>
							<div class="form-group">
								<label for="urlVideo">Enlace del video</label>
								<input class="form-control" id="urlVideo" placeholder="Ejemplo: https://www.ejemplo.com" type="url">
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" id="agregar-publicacion-especial" data-target="1">Aceptar</button>
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
					</div>
				</div>
			</div>
		</div>
		
		<div id="modal-modificar-publicacion" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h4 class="modal-title">Modificar publicación</h4>
					</div>
					<div class="modal-body">
						<ul class="nav nav-tabs nav-tabs-2">
							<li class="nav-item">
								<a class="nav-link active" href="#modal-modificar-publicacion-info" data-toggle="tab"><i class="ti-info text-muted m-r-0-25"></i> Información</a>
							</li>
							<!--<li class="nav-item">
								<a class="nav-link" href="#modal-modificar-publicacion-imagenes" data-toggle="tab"><i class="ti-gallery text-muted m-r-0-25"></i> Imágenes</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="#modal-modificar-publicacion-videos" data-toggle="tab"><i class="ti-video-clapper text-muted m-r-0-25"></i> Videos</a>
							</li>-->
						</ul>
						<div class="tab-content" style="padding: 25px;">
						  <div id="modal-modificar-publicacion-info" class="tab-pane fade in active">
							<form>
								<div class="form-group">
									<label for="select2-demo-12" class="form-control-label">Área</label>
									<select id="select2-demo-12" class="form-control" data-plugin="select2">
										<?php foreach($areas as $area): ?>
											<option value="<?php echo $area["id"]; ?>"><?php echo $area["nombre"]; ?></option>
										<?php endforeach ?>
									</select>
								</div>
								<div class="form-group">
									<label for="select2-demo-22" class="form-control-label">Sector</label>
									<select id="select2-demo-22" class="form-control" data-plugin="select2">
										<?php
											if(count($areas) > 0) {
												$area = $areas[0];
											}
										?>
										<?php foreach($sectores as $sector): ?>
											<?php if($sector["id_area"] == $area["id"]): ?>
												<option value="<?php echo $sector["id"]; ?>"><?php echo $sector["nombre"]; ?></option>
											<?php endif ?>
										<?php endforeach ?>
									</select>
								</div>
								<div class="form-group">
									<label for="select2-demo-23" class="form-control-label">Disponibilidad</label>
									<select id="select2-demo-23" class="form-control" data-plugin="select2">
										<?php foreach($disps as $disp): ?>
											<option value="<?php echo $disp["id"]; ?>"><?php echo $disp["nombre"]; ?></option>
										<?php endforeach ?>
									</select>
								</div>
								<div class="form-group">
									<label for="modal-modificar-publicacion-titulo">Título</label>
									<input type="text" class="form-control" id="modal-modificar-publicacion-titulo" placeholder="">
								</div>
								<div class="form-group">
									<label for="modal-modificar-publicacion-descripcion">Descripción</label>
									<texarea id="modal-modificar-publicacion-descripcion"></texarea>
								</div>
								<h6>Agregar ubicación del empleo</h6>
								<div class="form-group">
									<label for="modal-modificar-publicacion-ubicacion">Escribe la ubicación</label>
									<input type="text" class="form-control" id="modal-modificar-publicacion-ubicacion" placeholder="">
								</div>
								<div id="map2" style="height: 250px;width: 100%;"></div>
							</form>
						  </div>
						  <div id="modal-modificar-publicacion-imagenes" class="tab-pane fade">
							<h3>Imágenes</h3>
						  </div>
						  <div id="modal-modificar-publicacion-videos" class="tab-pane fade">
							<h3>Videos</h3>
						  </div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" id="modal-modificar-publicacion-enviar-form">Aceptar</button>
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
					</div>
				</div>
			</div>
		</div>
		
		<div id="modal-postulados" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h4 class="modal-title">Trabajadores postulados a este empleo</h4>
					</div>
					<div class="modal-body">
                        <?php switch($plan['id_plan']):
                            case 1: ?>
                                <div class="alert alert-warning">
                                    <p><b>OJO!</b> Solo podrás visualizar maximo <b>10</b> postulantes para esta publicación. Para evitar esto te invitamos a mejor tu plan de servicios <a href="planes.php">Aquí</a>.</p>
                                </div>
                        <?php break; ?>

                        <?php case 2: // Plan Bronce?>
                                <div class="alert alert-warning">
                                    <p><b>OJO!</b> Solo podrás visualizar maximo <b>40</b> postulantes para esta publicación. Para evitar esto te invitamos a mejor tu plan de servicios <a href="planes.php">Aquí</a>.</p>
                                </div>
                        <?php break; ?>
                        <?php case 3: // Plan Plata?>
                                <div class="alert alert-warning">
                                    <p><b>OJO!</b> Solo podrás visualizar maximo <b>100</b> postulantes para esta publicación. Para evitar esto te invitamos a mejor tu plan de servicios <a href="planes.php">Aquí</a>.</p>
                                </div>
                        <?php break; ?>
                        <?php endswitch; ?>
						<table id="tablaPostulados" class="table table-striped table-bordered dataTable">
							<thead>
								<tr>
									<th>#</th>
									<th>Trabajador</th>
									<th>Fecha y hora</th>
									<th>Acciones</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
					</div>
				</div>
			</div>
		</div>

		<?php require_once('../includes/libs-js.php'); ?>

		<script type="text/javascript" src="../vendor/DataTables/js/jquery.dataTables.min.js"></script>
		<script type="text/javascript" src="../vendor/DataTables/js/dataTables.bootstrap4.min.js"></script>
		<script type="text/javascript" src="../vendor/DataTables/Responsive/js/dataTables.responsive.min.js"></script>
		<script type="text/javascript" src="../vendor/DataTables/Responsive/js/responsive.bootstrap4.min.js"></script>
		<script type="text/javascript" src="../vendor/DataTables/Buttons/js/dataTables.buttons.min.js"></script>
		<script type="text/javascript" src="../vendor/DataTables/Buttons/js/buttons.bootstrap4.min.js"></script>
		<script type="text/javascript" src="../vendor/DataTables/JSZip/jszip.min.js"></script>
		<script type="text/javascript" src="../vendor/DataTables/pdfmake/build/pdfmake.min.js"></script>
		<script type="text/javascript" src="../vendor/DataTables/pdfmake/build/vfs_fonts.js"></script>
		<script type="text/javascript" src="../vendor/DataTables/Buttons/js/buttons.html5.min.js"></script>
		<script type="text/javascript" src="../vendor/DataTables/Buttons/js/buttons.print.min.js"></script>
		<script type="text/javascript" src="../vendor/DataTables/Buttons/js/buttons.colVis.min.js"></script>
		
		<script type="text/javascript" src="../vendor/select2/dist/js/select2.min.js"></script>
		<script type="text/javascript" src="../vendor/dropify/dist/js/dropify.min.js"></script>
		<script type="text/javascript" src="../js/jquery.form.js"></script>
		
		<!-- TinyMCE -->
		<script type="text/javascript" src="../vendor/tinymce/tinymce.min.js"></script>
		<script type="text/javascript" src="../vendor/tinymce/skins/custom/jquery.tinymce.min.js"></script>
		
		<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCw69wIi6XSBIldqmZdoMnihzi-9pWvjeo&libraries=places"></script>

		<script>
			var map = null;
			var map2 = null;
			var marker = null;
			var marker2 = null;
			var latSelected = null;
			var lngSelected = null;
			var searchBox = null;
			var searchBox2 = null;
			var input = null;
			var input2 = null;
			var empresa_nueva = "<?= $empresa_nueva['id_imagen'] ?>";
			empresa_nueva = parseInt(empresa_nueva);
			function handleLocationError(browserHasGeolocation, infoWindow, pos) {
				marker = new google.maps.Marker({
					position: pos,
					map: map,
					title: 'Mi ubicación',
					  draggable: true
				});
			}
			function handleLocationError2(browserHasGeolocation, infoWindow, pos) {
				marker2 = new google.maps.Marker({
					position: pos,
					map: map,
					title: 'Mi ubicación',
					  draggable: true
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
				if(map == null) {
					map = new google.maps.Map(document.getElementById('map'), {
						center: {lat: -34.397, lng: 150.644},
						zoom: 6
					  });
					
					geocoder = new google.maps.Geocoder;
					
					input = (document.getElementById('modal-agregar-publicacion-ubicacion'));
					searchBox = new google.maps.places.SearchBox(input);

					  map.addListener('bounds_changed', function() {
						searchBox.setBounds(map.getBounds());
					  });
					
				  searchBox.addListener('places_changed', function() {
					var places = searchBox.getPlaces();

					if (places.length == 0) {
					  return;
					}

					var bounds = new google.maps.LatLngBounds();
					places.forEach(function(place) {
					  if (place.geometry.viewport) {
						// Only geocodes have viewport.
						bounds.union(place.geometry.viewport);
					  } 
					  marker.setPosition(place.geometry.location);
						latSelected = place.geometry.location.lat();
						lngSelected = place.geometry.location.lng();
					   map.setCenter(place.geometry.location);
					});
				});

				
			  // Try HTML5 geolocation.
			  if (navigator.geolocation) {
				navigator.geolocation.getCurrentPosition(function(position) {
				  var pos = {
					lat: position.coords.latitude,
					lng: position.coords.longitude
				  };
				  
				  marker = new google.maps.Marker({
					position: pos,
					map: map,
					title: 'Mi ubicación',
					  draggable: true
				  });
					
				  map.setCenter(pos);
					geocodeLatLng(geocoder, map, marker);
				  
					marker.addListener('dragend', function () {
						map.panTo(marker.getPosition());
						geocodeLatLng(geocoder, map, marker);
						var position = marker.getPosition();
						latSelected = position.lat();
						lngSelected = position.lng();
					});
				  map.addListener('click', function (e) {
					marker.setPosition(e.latLng);
					var position = marker.getPosition();
					latSelected = position.lat();
					lngSelected = position.lng();
					map.panTo(marker.getPosition());
					marker.setAnimation(google.maps.Animation.BOUNCE);
					geocodeLatLng(geocoder, map, marker);
					setTimeout(function () {
						marker.setAnimation(null);
					}, 1500);
				});
					
				}, function() {
				  handleLocationError(true, marker, map.getCenter());
				});
			  } else {
				// Browser doesn't support Geolocation
				handleLocationError(false, marker, map.getCenter());
			  }
				}
				else {
					google.maps.event.trigger(map, "resize");
				}
			  setTimeout(function () {
					google.maps.event.trigger(map, "resize");
				}, 2500);
			}
			
			function initMap2(coordenadas) {
				if(map2 == null) {
					map2 = new google.maps.Map(document.getElementById('map2'), {
						center: {lat: -34.397, lng: 150.644},
						zoom: 6
					  });
					
					geocoder = new google.maps.Geocoder;
					
					input2 = (document.getElementById('modal-modificar-publicacion-ubicacion'));
					searchBox2 = new google.maps.places.SearchBox(input2);

					  map2.addListener('bounds_changed', function() {
						searchBox2.setBounds(map2.getBounds());
					  });
					
					  searchBox2.addListener('places_changed', function() {
						var places = searchBox2.getPlaces();

						if (places.length == 0) {
						  return;
						}
						  
						  

						var bounds = new google.maps.LatLngBounds();
						places.forEach(function(place) {
						  if (place.geometry.viewport) {
							// Only geocodes have viewport.
							bounds.union(place.geometry.viewport);
						  } 
						  	//marker2.setPosition(place.geometry.location);
							latSelected = place.geometry.location.lat();
							lngSelected = place.geometry.location.lng();
						   map2.setCenter(place.geometry.location);
							});
						});

					if(coordenadas != "") {
						var coord = coordenadas.split(",");
						var pos = {
							lat: parseFloat(coord[0]),
							lng: parseFloat(coord[1])
						  };

						  marker2 = new google.maps.Marker({
							position: pos,
							map: map2,
							title: 'Mi ubicación',
							  draggable: true
						  });

						  map2.setCenter(pos);
							geocodeLatLng(geocoder, map2, marker2);

							marker2.addListener('dragend', function () {
								map2.panTo(marker2.getPosition());
								geocodeLatLng(geocoder, map2, marker2);
								var position = marker2.getPosition();
								latSelected = position.lat();
								lngSelected = position.lng();
							});
						  map2.addListener('click', function (e) {
							marker2.setPosition(e.latLng);
							var position = marker2.getPosition();
							latSelected = position.lat();
							lngSelected = position.lng();
							map2.panTo(marker2.getPosition());
							marker2.setAnimation(google.maps.Animation.BOUNCE);
							geocodeLatLng(geocoder, map2, marker2);
							setTimeout(function () {
								marker2.setAnimation(null);
							}, 1500);
						});
					}
					else {
						if (navigator.geolocation) {
							navigator.geolocation.getCurrentPosition(function(position) {
							  var pos = {
								lat: position.coords.latitude,
								lng: position.coords.longitude
							  };

							  marker2 = new google.maps.Marker({
								position: pos,
								map: map2,
								title: 'Mi ubicación',
								  draggable: true
							  });

							  map2.setCenter(pos);
								geocodeLatLng(geocoder, map2, marker2);

								marker2.addListener('dragend', function () {
									map2.panTo(marker2.getPosition());
									geocodeLatLng(geocoder, map);
									var position = marker2.getPosition();
									latSelected = position.lat();
									lngSelected = position.lng();
								});
							  map2.addListener('click', function (e) {
								marker2.setPosition(e.latLng);
								var position = marker2.getPosition();
								latSelected = position.lat();
								lngSelected = position.lng();
								map2.panTo(marker2.getPosition());
								marker2.setAnimation(google.maps.Animation.BOUNCE);
								geocodeLatLng(geocoder, map2, marker2);
								setTimeout(function () {
									marker2.setAnimation(null);
								}, 1500);
							});

							}, function() {
							  handleLocationError(true, marker2, map2.getCenter());
							});
						  } else {
							// Browser doesn't support Geolocation
							  							  
							handleLocationError(false, marker2, map2.getCenter());
						  }
					}
				
				}
				else {
					google.maps.event.trigger(map2, "resize");
				}
			  setTimeout(function () {
					google.maps.event.trigger(map2, "resize");
				}, 2500);
			}
			
			var idPub = 0;
			var sectores = <?php echo json_encode($sectores); ?>;
			$('.dropify').dropify();
			$("input[type=radio][name=opcion]").click(function() {
				if(this.value == 1) {
					$("#venta").css("display", "block");
					$("#video").css("display", "none");
				}
				else {
					$("#video").css("display", "block");
					$("#venta").css("display", "none");
				}
			});

			$("#agregar-publicacion").click(function(){
				if(empresa_nueva == 0){
					swal("Error!", "Lo sentimos! Debes colocar una nueva imagen de perfil que represente tu empresa para empezar a publicar.", "error");

					return false;
				}
			});
			
			$("#agregar-publicacion-especial").click(function() {
				if(parseInt($(this).attr("data-target")) == 1) {
					if($("input[type=radio][name=opcion]:checked").val() == 1) {
						if($("#producto").val() != "" && $("#descripcionProducto").val() != "" && $("#file")[0].files.length > 0) {
							$("#upload").attr("action", "ajax/publicaciones.php?op=7");
							var options={
								url     : $("#upload").attr("action"),
								success : function(response,status) {
									var data = JSON.parse(response);
									if(parseInt(data.status) == 1) {
										$('#modal-agregar-publicacion-especial').modal("hide");
									}
									else {
										swal({
											title: 'Información!',
											text: 'Ocurrio un error al subir la foto.',
											timer: 2000,
											confirmButtonClass: 'btn btn-primary btn-lg',
											buttonsStyling: false
										});
									}
								}
							};
							$("#upload").ajaxSubmit(options);
						}
						else {
							swal({
								title: 'Información!',
								text: 'Todos los campos son obligatorios.',
								confirmButtonClass: 'btn btn-primary btn-lg',
								buttonsStyling: false
							});
						}
					}
					else {
						if($("#tituloVideo").val() != "" && $("#urlVideo").val()) {
							$.ajax({
								type: 'POST',
								url: 'ajax/publicaciones.php',
								data: 'op=7&video=1&titulo=' + $("#tituloVideo").val() + '&url=' + $("#urlVideo").val(),
								dataType: 'json',
								success: function(data) {
									if(parseInt(data.status) == 1) {
										swal({
											title: 'Información!',
											text: 'Publicación agregrada exitosamente.',
											confirmButtonClass: 'btn btn-primary btn-lg',
											buttonsStyling: false
										});
									}
									else {
										swal({
											title: 'Información!',
											text: 'Error al guardar la publicacion',
											confirmButtonClass: 'btn btn-primary btn-lg',
											buttonsStyling: false
										});
									}
								}
							});
						}
						else {
							swal({
								title: 'Información!',
								text: 'Todos los campos son obligatorios.',
								confirmButtonClass: 'btn btn-primary btn-lg',
								buttonsStyling: false
							});
						}
					}
				}
				else {
					if($("input[type=radio][name=opcion]:checked").val() == 1) {
						if($("#producto").val() != "" && $("#descripcionProducto").val() != "" && $("#file")[0].files.length > 0) {
							$("#upload").attr("action", "ajax/publicaciones.php?op=7&edit=1");
							var options={
								url     : $("#upload").attr("action"),
								success : function(response,status) {
									var data = JSON.parse(response);
									if(parseInt(data.status) == 1) {
										$('#modal-agregar-publicacion-especial').modal("hide");
									}
									else {
										swal({
											title: 'Información!',
											text: 'Ocurrio un error al subir la foto.',
											timer: 2000,
											confirmButtonClass: 'btn btn-primary btn-lg',
											buttonsStyling: false
										});
									}
								}
							};
							$("#upload").ajaxSubmit(options);
						}
						else {
							swal({
								title: 'Información!',
								text: 'Todos los campos son obligatorios.',
								confirmButtonClass: 'btn btn-primary btn-lg',
								buttonsStyling: false
							});
						}
					}
					else {
						if($("#tituloVideo").val() != "" && $("#urlVideo").val()) {
							$.ajax({
								type: 'POST',
								url: 'ajax/publicaciones.php',
								data: 'op=7&video=1&edit=1&titulo=' + $("#tituloVideo").val() + '&url=' + $("#urlVideo").val(),
								dataType: 'json',
								success: function(data) {
									if(parseInt(data.status) == 1) {
										swal({
											title: 'Información!',
											text: 'Publicación agregrada exitosamente.',
											confirmButtonClass: 'btn btn-primary btn-lg',
											buttonsStyling: false
										});
									}
									else {
										swal({
											title: 'Información!',
											text: 'Error al guardar la publicacion',
											confirmButtonClass: 'btn btn-primary btn-lg',
											buttonsStyling: false
										});
									}
								}
							});
						}
						else {
							swal({
								title: 'Información!',
								text: 'Todos los campos son obligatorios.',
								confirmButtonClass: 'btn btn-primary btn-lg',
								buttonsStyling: false
							});
						}
					}
				}
			});
			
			$('#modal-agregar-publicacion-especial').on('show.bs.modal', function (e) {
				$.ajax({
					type: 'POST',
					url: 'ajax/publicaciones.php',
					data: 'op=8',
					dataType: 'json',
					success: function(data) {
						if(data.msg == "OK") {
							if(parseInt(data.info.tipo) == 1) {
								$("#radio1").click();
								$("#producto").val(data.info.titulo);
								$("#descripcionProducto").val(data.info.descripcion);
							}
							else {
								$("#radio2").click();
								$("#titulolVideo").val(data.info.titulo);
								$("#urlVideo").val(data.info.enlace);
							}
							$("#agregar-publicacion-especial").attr("data-target", 2);
						}
					}
				});
			});
			
			$('#modal-agregar-publicacion-especial').on('hide.bs.modal', function (e) {
				$("#producto").val("");
				$("#descripcionProducto").val("");
				$("#titulolVideo").val("");
				$("#urlVideo").val("");
				$("#agregar-publicacion-especial").attr("data-target", 1);
				$("#video").css("display", "none");
				$("#venta").css("display", "none");
			});
			
			function modificarPublicacion(btn) {
				var $btn = $(btn);
				var $parent = $btn.closest('.acciones-publicacion');
				idPub = $parent.attr('data-target');
				$.ajax({
					url: 'ajax/publicaciones.php',
					type: 'GET',
					dataType: 'json',
					data: {
						op: 2,
						i: idPub
					}
				}).done(function(data, textStatus, jqXHR) {						
					switch(jqXHR.status) {
						case 200:
							var json = JSON.parse(jqXHR.responseText);
							if(json.msg == 'OK') {
								var html = '';
								var publicacion = json.data.publicacion;
								$("#select2-demo-12").val(publicacion.area_id).trigger('change');
								sectores.forEach(function(sector) {
									if(sector.id_area == publicacion.area_id) {
										html += '<option value="' + sector.id + '">' + sector.nombre + '</option>';
									}
								});
								$('#select2-demo-22').html(html).trigger('change');
								$('#select2-demo-22').val(publicacion.sector_id).trigger('change');
								$('#select2-demo-23').val(publicacion.disponibilidad).trigger('change');
								$("#modal-modificar-publicacion-titulo").val(publicacion.titulo);
								$("#modal-modificar-publicacion-ubicacion").val(publicacion.ubicacion);
								tinyMCE.get('modal-modificar-publicacion-descripcion').setContent(publicacion.descripcion);
								var coordenadas = "";
								if(publicacion.coordenadas != "" && publicacion.coordenadas != null) {
									coordenadas = publicacion.coordenadas;
								}
								initMap2(coordenadas);
							}
							break;
					}
				});
				$("#modal-modificar-publicacion").modal('show');
			}
			
			function eliminarPublicacion(btn) {
				var $btn = $(btn);
				var $parent = $btn.closest('.acciones-publicacion');
				idPub = $parent.attr('data-target');
				
				swal({
				  title: "Advertencia",
				  text: "Está seguro que desea eliminar esta publicación?",
				  type: "warning",
				  showCancelButton: true,
				  confirmButtonColor: "#DD6B55",
				  confirmButtonText: "Aceptar",
				  cancelButtonText: "Cancelar",
				  closeOnConfirm: false
				});
				$(".show-swal2.visible .swal2-confirm").attr('data-action', 'remove');
				$(".show-swal2.visible .swal2-confirm").click(function() {
					if($(this).attr('data-action') == 'remove') {
						$(this).attr('data-action', '');
						$.ajax({
							url: 'ajax/publicaciones.php',
							type: 'GET',
							dataType: 'json',
							data: {
								op: 4,
								i: idPub
							}
						}).done(function(data, textStatus, jqXHR) {
							switch(jqXHR.status) {
								case 200:
									var json = JSON.parse(jqXHR.responseText);
									if(json.msg == 'OK') {
										swal("Operación exitosa!", "Se eliminó la publicación y sus datos.", "success");
										tablaPublicaciones.ajax.reload();
									}
									break;
							}
						});
					}
				});
			}
			
			var $tablaPublicaciones = jQuery("#tablaPublicaciones");

			var tablaPublicaciones = $tablaPublicaciones.DataTable( {
				"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
				"buttons": [
					'copyHtml5',
					'excelHtml5',
					'csvHtml5',
					'pdfHtml5'
				],
				"aoColumnDefs": [
					{ "width": "40px", "targets": 0 },
					{ "visible": false, "targets": 2 },
					{ "width": "150px", "targets": 3 },
					{ "width": "150px", "targets": 4 },
					{ "orderable": false, "targets": 4 },
					{ "className": "dt-center", "targets": [0, 2, 3, 4] }
				  ],
				"language": {
					"decimal":        "",
					"emptyTable":     "Sin registros",
					"info":           "Mostrando de _START_ a _END_ registros de _TOTAL_ en total",
					"infoEmpty":      "Mostrando 0 de 0 de 0 registros",
					"infoFiltered":   "(filtrado desde _MAX_ registros en total)",
					"infoPostFix":    "",
					"thousands":      ",",
					"lengthMenu":     "Mostrar _MENU_ registros",
					"loadingRecords": "Cargando...",
					"processing":     "Procesando...",
					"search":         "Buscar:",
					"zeroRecords":    "No se encontraron registros",
					"paginate": {
						"first":      "Primero",
						"last":       "Último",
						"next":       "Siguiente",
						"previous":   "Anterior"
					},
					"aria": {
						"sortAscending":  ": activar para ordenar la columna ascendente",
						"sortDescending": ": activar para ordenar la columna descendente"
					}
				},
				"ajax": 'ajax/publicaciones.php?op=5'
			} );
			
			var $tablaPostulados = jQuery("#tablaPostulados");

			var tablaPostulados = $tablaPostulados.DataTable( {
				"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
				"aoColumnDefs": [
					{ "width": "50px", "targets": 0 },
					{ "width": "150px", "targets": 2 },
					{ "width": "80px", "targets": 3 },
					{"className": "dt-center", "targets": [0, 2, 3]}
				  ],
				"language": {
					"decimal":        "",
					"emptyTable":     "Sin registros",
					"info":           "Mostrando de _START_ a _END_ registros de _TOTAL_ en total",
					"infoEmpty":      "Mostrando 0 de 0 de 0 registros",
					"infoFiltered":   "(filtrado desde _MAX_ registros en total)",
					"infoPostFix":    "",
					"thousands":      ",",
					"lengthMenu":     "Mostrar _MENU_ registros",
					"loadingRecords": "Cargando...",
					"processing":     "Procesando...",
					"search":         "Buscar:",
					"zeroRecords":    "No se encontraron registros",
					"paginate": {
						"first":      "Primero",
						"last":       "Último",
						"next":       "Siguiente",
						"previous":   "Anterior"
					},
					"aria": {
						"sortAscending":  ": activar para ordenar la columna ascendente",
						"sortDescending": ": activar para ordenar la columna descendente"
					}
				},
				"ajax": 'ajax/publicaciones.php?op=6&i=0'
		} );
		
			$("#sendMesage").click(function() {
					var message = $("#messageText").val();
					var id = $(this).attr("data-id");
					if(message != '') {
						$.ajax({
							type: 'GET',
							url: 'ajax/chat.php',
							dataType: 'json',
							data: {
								op: 5,
								idc: <?php echo $_SESSION["ctc"]["uid"]; ?>,
								idc2: id,
								msg: message,
								t: 1
							},
							success: function (response) {
								$("#messageText").val("");
								$("#contactM").modal("hide");
								if(response.msg == "OK") {
									swal({
										title: 'Operación exitosa!',
										text: 'Tu mensaje ha sido enviado satisfactoriamente.',
										confirmButtonClass: 'btn btn-primary btn-lg',
										buttonsStyling: false
									});
								}
							}
						});
					}
					else {
						swal({
							title: 'Información',
							text: 'Debe escribir el contenido de su mensaje.',
							confirmButtonClass: 'btn btn-primary btn-lg',
							buttonsStyling: false
						});
					}
				});
			
			$('#modal-postulados').on('show.bs.modal', function (e) {
				tablaPostulados.clear().draw();
			});
			$('#modal-postulados').on('show.bs.modal', function (e) {
				tablaPostulados.ajax.url('ajax/publicaciones.php?op=6&i=' + $(e.relatedTarget).attr('data-id'));
				tablaPostulados.ajax.reload();
				/*setTimeout(function() {
					$(".contactJobber").off().click(function() {
						$("#modal-postulados").modal("hide");
						$("#sendMesage").attr("data-id", $(this).attr("data-id"));
					});
				}, 2000);*/
			});
			
			function callEvent(element) {
				console.log(element);
				$("#modal-postulados").modal("hide");
				$("#sendMesage").attr("data-id", $(element).attr("data-id"));
			}
			
			$("#enviarFormRubro").click(function() {
				var nombre = $("#rubroNombre").val();
				if(nombre == '') {
					alert("Debe ingresar algún nombre para el rubro.");
				}
				else {
					$("#formRubro").submit();
				}
			});
			
			tinymce.init({
				selector: '#modal-modificar-publicacion-descripcion',
				height: 150,
				plugins: [
					'advlist lists charmap print preview anchor',
					'searchreplace visualblocks code fullscreen',
					'insertdatetime  table contextmenu paste code'
				], //3 media 1 link image autolink
				toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
				language: 'es'
			});
			
			tinymce.init({
				selector: '#modal-agregar-publicacion-descripcion',
				height: 150,
				plugins: [
					'advlist lists charmap print preview anchor',
					'searchreplace visualblocks code fullscreen',
					'insertdatetime table contextmenu paste code'
				],
				toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
				language: 'es'
			});
			
			$('#select2-demo-1').select2({
				width: '100%'
			}).on("select2:select", function (e) {
				var idArea = $(this).val();
				var html = '';
				sectores.forEach(function(sector) {
					if(sector.id_area == idArea) {
						html += '<option value="' + sector.id + '">' + sector.nombre + '</option>';
					}
				});
				$('#select2-demo-2').html(html).trigger('change');
			});
			$('#select2-demo-2').select2({
				width: '100%'
			});
			
			$('#select2-demo-3').select2({
				width: '100%'
			});

			$('#select2-demo-12').select2({
				width: '100%'
			}).on("select2:select", function (e) {
				var idArea = $(this).val();
				var html = '';
				sectores.forEach(function(sector) {
					if(sector.id_area == idArea) {
						html += '<option value="' + sector.id + '">' + sector.nombre + '</option>';
					}
				});
				$('#select2-demo-22').html(html).trigger('change');
			});
			$('#select2-demo-22').select2({
				width: '100%'
			});
			
			$('#select2-demo-23').select2({
				width: '100%'
			});
			
			window.onload = function() {
				//$("#modal-agregar-publicacion").modal('show');
				//$("#modal-modificar-publicacion").modal('show');
			};
			
			$("#modal-agregar-publicacion-enviar-form").click(function() {
				var idArea = $("#select2-demo-1").val();
				var idSector = $("#select2-demo-2").val();
				var idDisp = $("#select2-demo-3").val();
				var titulo = $("#modal-agregar-publicacion-titulo").val();
				var ubicacion = $("#modal-agregar-publicacion-ubicacion").val();
				var descripcion = tinyMCE.get('modal-agregar-publicacion-descripcion').getContent();
				if(titulo == '' || descripcion == '') {
					swal("Error!", "Faltan algunos campos.", "error");
				} else {

					$.ajax({
						url: 'ajax/publicaciones.php',
						type: 'GET',
						dataType: 'json',
						data: {op:9},
						success: function(response){
							if (response){
								if(response.msg == 'OK'){

									$.ajax({
										url: 'ajax/publicaciones.php',
										type: 'GET',
										dataType: 'json',
										data: {
											op: 1,
											info: JSON.stringify({
												area: idArea,
												sector: idSector,
												disponibilidad:idDisp,
												titulo: titulo,
												descripcion: descripcion,
												latitud: latSelected,
												longitud: lngSelected,
												ubicacion: ubicacion
											})
										}
									}).done(function(data, textStatus, jqXHR) {
										switch(jqXHR.status) {
											case 200:
												var json = JSON.parse(jqXHR.responseText);
												if(json.msg == 'OK') {
													var publicacion = json.data.publicacion;
													$("#modal-agregar-publicacion").modal('hide');
													swal("Operación exitosa!", "Se agregó la publicación y sus datos.", "success");
													tablaPublicaciones.ajax.reload();
													latSelected = null;
													lngSelected = null;
												}
												break;
										}
									});

								} else {
									swal("INFORMACIÓN!", "Lo sentimos, pero ha sobrepasado el limites de publicaciones para este plan gratis (2 MAX.). Para seguir gozando de nuestros servicios le invitamos a suscribirse a un plan con mayores beneficios.", "info");
								}
							} else {
								swal("ERROR!", "Ha ocurrido un error. Por favor, vuelve a intentarlo", "error");
							}
						},
						error: function(error){
							swal("ERROR!", "Ha ocurrido un error. Por favor, vuelve a intentarlo", "error");
						}
					});

				}
			});
			
			$("#modal-modificar-publicacion-enviar-form").click(function() {
				var idArea = $("#select2-demo-12").val();
				var idSector = $("#select2-demo-22").val();
				var idDisp = $("#select2-demo-23").val();
				var titulo = $("#modal-modificar-publicacion-titulo").val();
				var ubicacion = $("#modal-modificar-publicacion-ubicacion").val();
				var descripcion = tinyMCE.get('modal-modificar-publicacion-descripcion').getContent();
				if(titulo == '' || descripcion == '') {
					alert("Faltan algunos campos");
				}
				else {

					$.ajax({
						url: 'ajax/publicaciones.php',
						type: 'GET',
						dataType: 'json',
						data: {
							op: 3,
							i: idPub,
							info: JSON.stringify({
								area: idArea,
								sector: idSector,
								disponibilidad: idDisp,
								titulo: titulo,
								descripcion: descripcion,
								latitud: latSelected,
								longitud: lngSelected,
								ubicacion: ubicacion
							})
						}
					}).done(function(data, textStatus, jqXHR) {
						switch(jqXHR.status) {
							case 200:
								var json = JSON.parse(jqXHR.responseText);
								if(json.msg == 'OK') {
									var publicacion = json.data.publicacion;
									$("#modal-modificar-publicacion").modal('hide');
									swal("Operación exitosa!", "Se han modificado los datos de la publicación seleccionada.", "success");
									tablaPublicaciones.ajax.reload();
									latSelected = null;
									lngSelected = null;
								}
								break;
						}
					});

				}
			});
			
			$('#modal-agregar-publicacion').on('show.bs.modal', function (e) {
				initMap();
				$("#select2-demo-1").val($("#select2-demo-1 option:first").val()).trigger('change');
				var idArea = $("#select2-demo-1").val();
				var html = '';
				sectores.forEach(function(sector) {
					if(sector.id_area == idArea) {
						html += '<option value="' + sector.id + '">' + sector.nombre + '</option>';
					}
				});
				$('#select2-demo-2').html(html).trigger('change');
				$("#modal-agregar-publicacion-titulo").val('');
				tinyMCE.get('modal-agregar-publicacion-descripcion').setContent('');
			});
		</script>

	</body>

</html>