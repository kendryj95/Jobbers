<?php
	session_start();
	if(isset($_SESSION['FBID'])) {
		$_SESSION['FBID'] = $fbid;           
		$_SESSION['FULLNAME'] = $fbfullname;
		$_SESSION['EMAIL'] =  $femail;
	}

	require_once('classes/DatabasePDOInstance.function.php');
	require_once('slug.function.php');

	$db = DatabasePDOInstance();

	$tipo = isset($_REQUEST["tipo"]) ? $_REQUEST["tipo"] : false;

	if($tipo != 'trabajadores' && $tipo != 'empleos') {
		$tipo = 'empleos';
	}

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

	if($tipo == "empleos") {
		$momentos = array(
			array(
				"nombre" => "Últimas 24 horas",
				"amigable" => "ultimas-24-horas"
			),
			array(
				"nombre" => "Durante los últimos 3 días",
				"amigable" => "durante-los-ultimos-3-dias"
			),
			array(
				"nombre" => "Durante la última semana",
				"amigable" => "durante-la-ultima-semana"
			),
			array(
				"nombre" => "Durante las ultimas 2 semanas",
				"amigable" => "durante-las-ultimas-2-semanas"
			),
			array(
				"nombre" => "Hace un mes o menos",
				"amigable" => "hace-un-mes-o-menos"
			)
		);
	}
	else {
		
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
		<title>JOBBERS - Buscador de empleos</title>
		<?php require_once('includes/libs-css.php'); ?>
		<link rel="stylesheet" href="vendor/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">
		<link rel="stylesheet" href="vendor/select2/dist/css/select2.min.css">
		<link rel="stylesheet" href="vendor/ionicons/css/ionicons.min.css">
	</head>
	<body class="skin-5">
		<div class=" bg-white">
			<div class="block-5 img-cover img-fixed" style="/*background-image: url(img/photos-1/<?php echo rand(1, 3); ?>.jpg);*/ margin-top: -30px;padding-bottom: 0;">
				<div class="row" style="background-color: white;position: inherit;margin-right: 0px;margin-left: 0;">
					<!-- <div class="col-md-2" style="text-align: center;">
						<a class="text-white" href="./" style=""><img src="img/logo_d.png" style="height: 50px;margin-top: 10px;"></a>
					</div> -->
					<div class="col-md-12" style="padding: 0;">
						<?php require_once('includes/header.php'); ?>
					</div>
				</div>
				
			</div>
			
			<div class="container">
				<div class="col-md-12">
					<?php if($tipo == "empleos"): ?>
						<div class="card">
							<h4 class="card-header">Encuentra el empleo que estás buscando!</h4>
							<div class="card-block">
								<h5>Utilizá el buscador para tener resultados mas precisos</h5>
								<form action="empleos.php" method="get">
									<input type="hidden" value="busqueda" name="accion">
									<div class="form-group">
										<label for="exampleInput1">Pálabras clave</label>
										<input type="text" class="form-control" id="exampleInput1" placeholder="" value="" data-role="tagsinput" name="busqueda">
										<small class="form-text text-muted">Ingresa palabras claves para tu búsqueda: técnico, cadete, full time, etc.</small>
									</div>
									<div class="form-group">
										<label for="exampleInput2">Área</label>
										<select id="exampleInput2" name="area" class="form-control" data-plugin="select2">
											<option value="">Sin especificar</option>
											<?php foreach($areas as $area): ?>
												<option value="<?php echo $area["amigable"]; ?>"><?php echo $area["nombre"]; ?></option>
											<?php endforeach ?>
										</select>
										<small class="form-text text-muted">Selecciona el área de tu interés para obtener resultados más precisos.</small>
									</div>
									<div class="form-group">
										<label for="exampleInput3">Sector</label>
										<select id="exampleInput3" name="sector" class="form-control" data-plugin="select2">
											<option value="">Sin especificar</option>
											<!--
											< ?php foreach($sectoresPrimeraArea as $sector): ?>
												<option value="< ?php echo $sector["amigable"]; ?>">< ?php echo $sector["nombre"]; ?></option>
											< ?php endforeach ?>
											-->
										</select>
										<small class="form-text text-muted">Selecciona el sector de tu interés para obtener resultados más precisos.</small>
									</div>
									<div class="form-group">
										<label for="exampleInput4">Fecha de publicación</label>
										<select id="exampleInput4" name="momento" class="form-control" data-plugin="select2">
											<option value="">Cualquier momento</option>
											<?php foreach($momentos as $momento): ?>
												<option value="<?php echo $momento["amigable"]; ?>"><?php echo $momento["nombre"]; ?></option>
											<?php endforeach ?>
										</select>
										<small class="form-text text-muted">Selecciona el rango de fechas de publicación del empleo.</small>
									</div>
									<button type="submit" class="btn btn-primary">Buscar</button>
								</form>
							</div>
						</div>
					<?php else: ?>
						<div class="card" style="margin-left: 204px;">
							<h4 class="card-header">Encuentra el trabajador ideal para tu oferta en empleo!</h4>
							<div class="card-block">
								<h5>Utilizá el buscador para tener resultados mas precisos</h5>
								<form id="form-buscador" action="<?php echo $tipo; ?>.php" method="get">
									<input type="hidden" value="busqueda" name="accion">
									<div class="form-group">
										<label for="exampleInput1">Pálabras clave</label>
										<input type="text" class="form-control" id="exampleInput1" placeholder="" value="" data-role="tagsinput" name="busqueda">
										<small class="form-text text-muted">Ingresa palabras claves para tu búsqueda: daniel, rodrigo, susan, etc.</small>
									</div>
									<div class="form-group">
										<label for="exampleInput2">Área</label>
										<select id="exampleInput2" name="area" class="form-control" data-plugin="select2">
											<option value="">Sin especificar</option>
											<?php foreach($areas as $area): ?>
												<option value="<?php echo $area["amigable"]; ?>"><?php echo $area["nombre"]; ?></option>
											<?php endforeach ?>
										</select>
										<small class="form-text text-muted">Selecciona el área donde el trabajador haya laborado.</small>
									</div>
									<div class="form-group">
										<label for="exampleInput3">Sector</label>
										<select id="exampleInput3" name="sector" class="form-control" data-plugin="select2">
											<option value="">Sin especificar</option>
											<!--
											< ?php foreach($sectoresPrimeraArea as $sector): ?>
												<option value="< ?php echo $sector["amigable"]; ?>">< ?php echo $sector["nombre"]; ?></option>
											< ?php endforeach ?>
											-->
										</select>
										<small class="form-text text-muted">Selecciona el sector donde el trabajador haya laborado, para obtener resultados más precisos.</small>
									</div>
									<div class="form-group">
										<label for="exampleInput4">Calificación</label>
										<div id="exampleInput4" style="margin-bottom: 5px;">
											<div class="checkbox" style="height: 26px;margin-left: 3px;">
												<label>
													<input name="calificacion" value="1" type="checkbox"> <div style="display: inline-block;font-size: 20px;"><i class="ion-ios-star" style="padding-left: 7px;padding-right: 3px;color: #ffa200;"></i><i class="ion-ios-star" style="padding-left: 3px;padding-right: 3px;color: #ffa200;"></i><i class="ion-ios-star" style="padding-left: 3px;padding-right: 3px;color: #ffa200;"></i><i class="ion-ios-star" style="padding-left: 3px;padding-right: 3px;color: #ffa200;"></i><i class="ion-ios-star" style="padding-left: 3px;padding-right: 3px;color: #ffa200;"></i></div>
												</label>
											</div>
											<div class="checkbox" style="height: 26px;margin-left: 3px;">
												<label>
													<input name="calificacion" value="2" type="checkbox"> <div style="display: inline-block;font-size: 20px;"><i class="ion-ios-star" style="padding-left: 7px;padding-right: 3px;color: #ffa200;"></i><i class="ion-ios-star" style="padding-left: 3px;padding-right: 3px;color: #ffa200;"></i><i class="ion-ios-star" style="padding-left: 3px;padding-right: 3px;color: #ffa200;"></i><i class="ion-ios-star" style="padding-left: 3px;padding-right: 3px;color: #ffa200;"></i><i class="ion-ios-star-outline" style="padding-left: 3px;padding-right: 3px;color: #ffa200;"></i></div>
												</label>
											</div>
											<div class="checkbox" style="height: 26px;margin-left: 3px;">
												<label>
													<input name="calificacion" value="3" type="checkbox"> <div style="display: inline-block;font-size: 20px;"><i class="ion-ios-star" style="padding-left: 7px;padding-right: 3px;color: #ffa200;"></i><i class="ion-ios-star" style="padding-left: 3px;padding-right: 3px;color: #ffa200;"></i><i class="ion-ios-star" style="padding-left: 3px;padding-right: 3px;color: #ffa200;"></i><i class="ion-ios-star-outline" style="padding-left: 3px;padding-right: 3px;color: #ffa200;"></i><i class="ion-ios-star-outline" style="padding-left: 3px;padding-right: 3px;color: #ffa200;"></i></div>
												</label>
											</div>
										</div>
										<small class="form-text text-muted">Selecciona la calificación del trabajador.</small>
									</div>
									<button type="submit" class="btn btn-primary">Buscar</button>
								</form>
							</div>
						</div>
					<?php endif ?>
					</div>
				</div>

			<br>
		
			<?php require_once('includes/footer.php'); ?>

		</div>

		<?php require_once('includes/libs-js.php'); ?>
		<script type="text/javascript" src="vendor/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
		<script type="text/javascript" src="vendor/select2/dist/js/select2.min.js"></script>
		<script>
			$(document).ready(function() {
				<?php if($tipo == 'empleos'): ?>
					$('[data-plugin="select2"]').select2($(this).attr('data-options'));
				<?php else: ?>
					$('[data-plugin="select2"]').select2($(this).attr('data-options'));
					$("#form-buscador").submit(function(e) {
						var x = "";
						var arr = $("input[type=checkbox][name=calificacion]:checked");
						var c = "";
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
						$("input[type=checkbox][name=calificacion]").val(c);
					});
				<?php endif ?>
				$("#exampleInput2").change(function() {
					var ida = this.value;
					$("#exampleInput3").empty().trigger('change');
					$.ajax({
						url: 'ajax/misc.php',
						type: 'GET',
						dataType: 'json',
						data: {
							op: 1,
							ida: ida
						}
					}).done(function(data, textStatus, jqXHR) {						
						switch(jqXHR.status) {
							case 200:
								var json = JSON.parse(jqXHR.responseText);
								var html = '';
								html += '<option value="">Sin especificar</option>';
								json.forEach(function(sector) {
									html += '<option value="' + sector.amigable + '">' + sector.nombre + '</option>';
								});
								$("#exampleInput3").html(html).trigger('change');
							break;
						}
					});
				});
			});
		</script>
	</body>
</html>