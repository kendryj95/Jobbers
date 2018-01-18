0<?php
	session_start();
	if(!isset($_SESSION["ctc"])) {
		header("Location: index.php");
	} else {
		if ($_SESSION["ctc"]["type"] != 3 || isset($_SESSION["ctc"]["empresa"])) {
			header("Location: ../");
		} 
	}
	require_once('../classes/DatabasePDOInstance.function.php');
	$db = DatabasePDOInstance();
	$iva = $db->getOne("SELECT iva FROM configuraciones WHERE id=1");
	$planes = $db->getAll("SELECT * FROM planes WHERE id != 1");
	$servicios = $db->getAll("SELECT * FROM servicios WHERE id != 4");
	$plataforma = $db->getRow("SELECT * FROM plataforma WHERE id=1");
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
		<title>JOBBERS - Configuraciones - Admin</title>
		<?php require_once('../includes/libs-css.php'); ?>
		<link rel="stylesheet" href="../vendor/dropify/dist/css/dropify.min.css">
		<link rel="stylesheet" href="../vendor/bootstrap-tagsinput/src/bootstrap-tagsinput.css">

		<!-- Neptune CSS -->
		<link rel="stylesheet" href="../css/core.css">

		<style>
			.modal.in.modal-agregar-rubro .modal-dialog {
				max-width: 400px;
			}
		</style>
	</head>

	<body class="large-sidebar fixed-sidebar fixed-header skin-5">
		<div class="wrapper">

			<!-- Preloader -->
			<div class="preloader"></div>

			<!-- Sidebar second -->
			<?php require_once('../includes/sidebar-second.php'); ?>

			<!-- Header -->
			<?php require_once('../includes/header.php'); ?>

			<div class="site-content" style="margin-left: 0px;">
			<?php require_once('../includes/sidebar.php'); ?>
				<!-- Content -->
				<div class="col-md-9">
					<div class="content-area p-y-1">
						<div class="container-fluid">
							<h4>Mi cuenta</h4>
							<ol class="breadcrumb no-bg m-b-1">
								<li class="breadcrumb-item"><a href="./">Inicio</a></li>
								<li class="breadcrumb-item active">Mi cuenta</li>
							</ol>
							<div class="card card-block">
								<div class="row" id="optionsList">
									<div class="col-md-4" style="margin-bottom:20px;">
										<h5>Planes y servicios</h5>
										<div class="items-list">
											<div class="il-item">
												<a class="text-black" id="iva" href="javascript:void(0)">
													IVA
												</a>
											</div>
											<div class="il-item">
												<a class="text-black" id="planes" href="javascript:void(0)">
													Planes
												</a>
											</div>
											<div class="il-item">
												<a class="text-black" id="servicios" href="javascript:void(0)">
													Servicios
												</a>
											</div>
										</div>
									</div>
									<div class="col-md-4" style="margin-bottom:20px;">
										<h5>Plataforma</h5>
										<div class="items-list">
											<div class="il-item">
												<a class="text-black" id="nosotros" href="javascript:void(0)">
													Nosotros
												</a>
											</div>
											<div class="il-item">
												<a class="text-black" id="contacto" href="javascript:void(0)">
													Contacto
												</a>
											</div>
											<div class="il-item">
												<a class="text-black" id="politicas" href="javascript:void(0)">
													Políticas de privacidad
												</a>
											</div>
											<div class="il-item">
												<a class="text-black" id="terminos" href="javascript:void(0)">
													Términos y condiciones
												</a>
											</div>
										</div>
									</div>
									<div class="col-md-4" style="margin-bottom:20px;">
										<h5>Redes plataforma y Landing-Empresa</h5>
										<div class="items-list">
											<div class="il-item">
												<a class="text-black" id="redes" href="javascript:void(0)">
													Administrar
												</a>
											</div>
											<div class="il-item">
												<a class="text-black" id="landing" href="javascript:void(0)">
													Administrar Landing-Empresa
												</a>
											</div>
										</div>
									</div>
								</div>
								<div class="row" style="margin-top: 20px; display: none;" id="containerRedes">
									<div class="col-md-8 col-xs-12">
										<a href="javascript:void(0)" class="btn btn-primary w-min-sm m-b-0-25 waves-effect waves-light back"><i class="ti-angle-left"></i> Regresar</a>
										<div class="form-group row" style="margin-top: 20px;">
											<label for="facebook" class="col-xs-4 col-form-label">Enlace Facebook</label>
											<div class="col-xs-8">
												<input class="form-control" id="facebook" type="text" value="<?php echo $plataforma["facebook"]; ?>">
											</div>
										</div>
										<div class="form-group row" style="margin-top: 20px;">
											<label for="instagram" class="col-xs-4 col-form-label">Enlace Instagram</label>
											<div class="col-xs-8">
												<input class="form-control" id="instagram" type="text" value="<?php echo $plataforma["instagram"]; ?>">
											</div>
										</div>
										<div class="form-group row" style="margin-top: 20px;">
											<label for="twitter" class="col-xs-4 col-form-label">Enlace Twitter</label>
											<div class="col-xs-8">
												<input class="form-control" id="twitter" type="text" value="<?php echo $plataforma["twitter"]; ?>">
											</div>
										</div>
										<div class="form-group row" style="margin-top: 20px;">
											<label for="youtube" class="col-xs-4 col-form-label">Enlace YouTube</label>
											<div class="col-xs-8">
												<input class="form-control" id="youtube" type="text" value="<?php echo $plataforma["youtube"]; ?>">
											</div>
										</div>
										<div class="form-group row" style="margin-top: 20px;">
											<label for="linkedin" class="col-xs-4 col-form-label">Enlace linkedin</label>
											<div class="col-xs-8">
												<input class="form-control" id="linkedin" type="text" value="<?php echo $plataforma["linkedin"]; ?>">
											</div>
										</div>
										<a href="javascript:void(0)" style="margin-top: 5px;" id="saveRedes" class="btn btn-primary w-min-sm m-b-0-25 waves-effect waves-light">Guardar</a>
									</div>
								</div>
								<div class="row" style="margin-top: 20px; display: none;" id="containerLanding">
									<div class="col-md-8 col-xs-12">
										<a href="javascript:void(0)" class="btn btn-primary w-min-sm m-b-0-25 waves-effect waves-light back"><i class="ti-angle-left"></i> Regresar</a>
										<div class="form-group row" style="margin-top: 20px;">
											<label for="section1" class="col-xs-4 col-form-label">¿Por qué somos tu mejor opción? - Section 1</label>
											<div class="col-xs-8">
												<textarea style="width: 450px; height: 173px" name="" id="section1" class="form-control"><?php echo $plataforma["section1_landing"]; ?></textarea>
											</div>
										</div>
										<div class="form-group row" style="margin-top: 20px;">
											<label for="section2" class="col-xs-4 col-form-label">¿Por qué somos tu mejor opción? - Section 2</label>
											<div class="col-xs-8">
												<textarea style="width: 450px; height: 173px" name="" id="section2" class="form-control"><?php echo $plataforma["section2_landing"]; ?></textarea>
											</div>
										</div>
										<div class="form-group row" style="margin-top: 20px;">
											<label for="section3" class="col-xs-4 col-form-label">¿Por qué somos tu mejor opción? - Section 3</label>
											<div class="col-xs-8">
												<input type="text" name="" id="section3" value="<?php echo $plataforma["section3_landing"]; ?>" data-role="tagsinput">
											</div>
										</div>
										
										<a href="javascript:void(0)" style="margin-top: 5px;" id="saveAdmLanding" class="btn btn-primary w-min-sm m-b-0-25 waves-effect waves-light">Guardar</a>
									</div>
								</div>
								<div class="row" style="margin-top: 20px; display: none;" id="containerNosotros">
									<div class="col-md-8 col-xs-12">
										<a href="javascript:void(0)" class="btn btn-primary w-min-sm m-b-0-25 waves-effect waves-light back"><i class="ti-angle-left"></i> Regresar</a>
										<div class="form-group row" style="margin-top: 20px;">
											<label for="contenidoNosotros" class="col-xs-12 col-form-label">Contenido</label>
											<div class="col-xs-12">
												<textarea id="contenidoNosotros"><?php echo $plataforma["nosotros"]; ?>"</textarea>
											</div>
										</div>
										<a href="javascript:void(0)" style="margin-top: 5px;" id="saveNosotros" class="btn btn-primary w-min-sm m-b-0-25 waves-effect waves-light">Guardar</a>
									</div>
								</div>
								<div class="row" style="margin-top: 20px; display: none;" id="containerPoliticas">
									<div class="col-md-8 col-xs-12">
										<a href="javascript:void(0)" class="btn btn-primary w-min-sm m-b-0-25 waves-effect waves-light back"><i class="ti-angle-left"></i> Regresar</a>
										<div class="form-group row" style="margin-top: 20px;">
											<label for="contenidoPoliticas" class="col-xs-12 col-form-label">Contenido</label>
											<div class="col-xs-12">
												<textarea id="contenidoPoliticas"><?php echo $plataforma["politicas"]; ?>"</textarea>
											</div>
										</div>
										<a href="javascript:void(0)" style="margin-top: 5px;" id="savePoliticas" class="btn btn-primary w-min-sm m-b-0-25 waves-effect waves-light">Guardar</a>
									</div>
								</div>
								<div class="row" style="margin-top: 20px; display: none;" id="containerContacto">
									<div class="col-md-8 col-xs-12">
										<a href="javascript:void(0)" class="btn btn-primary w-min-sm m-b-0-25 waves-effect waves-light back"><i class="ti-angle-left"></i> Regresar</a>
										<div class="form-group row" style="margin-top: 20px;">
											<label for="contenidoContacto" class="col-xs-4 col-form-label">Correo Corporativo</label>
											<div class="col-xs-8">
												<input class="form-control" id="contenidoContacto" type="text" value="<?php echo $plataforma["correo_contacto"]; ?>">
											</div>
										</div>

										<div class="form-group row" style="margin-top: 20px;">
											<label for="tlfPlat" class="col-xs-4 col-form-label">Telefono Corporativo</label>
											<div class="col-xs-8">
												<input class="form-control" id="tlfPlat" type="text" value="<?php echo $plataforma["telefono_contacto"]; ?>">
											</div>
										</div>
										<div class="form-group row" style="margin-top: 20px;">
											<label for="dirPlat" class="col-xs-4 col-form-label">Direccion</label>
											<div class="col-xs-8">
												<input class="form-control" id="dirPlat" type="text" value="<?php echo $plataforma["direccion_contacto"]; ?>">
											</div>
										</div>
										<a href="javascript:void(0)" style="margin-top: 5px;" id="saveContacto" class="btn btn-primary w-min-sm m-b-0-25 waves-effect waves-light">Guardar</a>
									</div>
								</div>
								<div class="row" style="margin-top: 20px; display: none;" id="containerTerminos">
									<div class="col-md-8 col-xs-12">
										<a href="javascript:void(0)" class="btn btn-primary w-min-sm m-b-0-25 waves-effect waves-light back"><i class="ti-angle-left"></i> Regresar</a>
										<div class="form-group row" style="margin-top: 20px;">
											<label for="contenidoTerminos" class="col-xs-12 col-form-label">Contenido</label>
											<div class="col-xs-12">
												<textarea id="contenidoTerminos"><?php echo $plataforma["terminos"]; ?>"</textarea>
											</div>
										</div>
										<a href="javascript:void(0)" style="margin-top: 5px;" id="saveTerminos" class="btn btn-primary w-min-sm m-b-0-25 waves-effect waves-light">Guardar</a>
									</div>
								</div>
								<div class="row" style="margin-top: 20px; display: none;" id="containerIVA">
									<div class="col-md-8 col-xs-12">
										<a href="javascript:void(0)" class="btn btn-primary w-min-sm m-b-0-25 waves-effect waves-light back"><i class="ti-angle-left"></i> Regresar</a>
										<div class="form-group row" style="margin-top: 20px;">
											<label for="ivaPlan" class="col-xs-4 col-form-label">IVA (Ejemplo: 19% => 0.19)</label>
											<div class="col-xs-8">
												<input class="form-control" id="ivaPlan" type="text" value="<?php echo $iva; ?>">
											</div>
										</div>
										<a href="javascript:void(0)" style="margin-top: 5px;" id="saveIVA" class="btn btn-primary w-min-sm m-b-0-25 waves-effect waves-light">Guardar</a>
									</div>
								</div>
								<div class="row" style="margin-top: 20px; display: none;" id="containerPlanes">
									<div class="col-md-8 col-xs-12">
										<a href="javascript:void(0)" class="btn btn-primary w-min-sm m-b-0-25 waves-effect waves-light back"><i class="ti-angle-left"></i> Regresar</a>
										<div class="form-group row" style="margin-top: 20px;">
											<label for="precioBronce" class="col-xs-4 col-form-label">Precio del plan bronce</label>
											<div class="col-xs-8">
												<input class="form-control" id="precioBronce" type="text" value="<?php echo $planes[0]["precio"]; ?>">
											</div>
										</div>
										<div class="form-group row" style="margin-top: 20px;">
											<label for="precioPlata" class="col-xs-4 col-form-label">Precio del plan plata</label>
											<div class="col-xs-8">
												<input class="form-control" id="precioPlata" type="text" value="<?php echo $planes[1]["precio"]; ?>">
											</div>
										</div>
										<div class="form-group row" style="margin-top: 20px;">
											<label for="precioOro" class="col-xs-4 col-form-label">Precio del plan oro</label>
											<div class="col-xs-8">
												<input class="form-control" id="precioOro" type="text" value="<?php echo $planes[2]["precio"]; ?>">
											</div>
										</div>
										<a href="javascript:void(0)" style="margin-top: 5px;" id="savePrices" class="btn btn-primary w-min-sm m-b-0-25 waves-effect waves-light">Guardar</a>
									</div>
								</div>
								<div class="row" style="margin-top: 20px; display: none;" id="containerServicios">
									<div class="col-md-8 col-xs-12">
										<a href="javascript:void(0)" class="btn btn-primary w-min-sm m-b-0-25 waves-effect waves-light back"><i class="ti-angle-left"></i> Regresar</a>
										<div class="form-group row" style="margin-top: 20px;">
											<label for="precioServ1" class="col-xs-4 col-form-label">Precio del servicio Busqueda en base x 40</label>
											<div class="col-xs-8">
												<input class="form-control" id="precioServ1" type="text" value="<?php echo $servicios[0]["precio"]; ?>">
											</div>
										</div>
										<div class="form-group row" style="margin-top: 20px;">
											<label for="precioServ2" class="col-xs-4 col-form-label">Precio del servicio Busqueda en base x 100</label>
											<div class="col-xs-8">
												<input class="form-control" id="precioServ2" type="text" value="<?php echo $servicios[1]["precio"]; ?>">
											</div>
										</div>
										<div class="form-group row" style="margin-top: 20px;">
											<label for="precioServ3" class="col-xs-4 col-form-label">Precio del servicio Busqueda en base x 150</label>
											<div class="col-xs-8">
												<input class="form-control" id="precioServ3" type="text" value="<?php echo $servicios[2]["precio"]; ?>">
											</div>
										</div>
										<a href="javascript:void(0)" style="margin-top: 5px;" id="saveServices" class="btn btn-primary w-min-sm m-b-0-25 waves-effect waves-light">Guardar</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- Footer -->
				<?php require_once('../includes/footer.php'); ?>
			</div>
		</div>

		<?php require_once('../includes/libs-js.php'); ?>
		<script type="text/javascript" src="../vendor/dropify/dist/js/dropify.min.js"></script>
		<script type="text/javascript" src="../js/jquery.form.js"></script>
		<script type="text/javascript" src="../vendor/tinymce/tinymce.min.js"></script>
		<script type="text/javascript" src="../vendor/tinymce/skins/custom/jquery.tinymce.min.js"></script>
		<script src="../vendor/bootstrap-tagsinput/src/bootstrap-tagsinput.js"></script>

		<script>
			$(document).ready(function(){
				$(".back").click(function() {
					$("#optionsList").show();
					$("#containerIVA").hide();
					$("#containerPlanes").hide();
					$("#containerServicios").hide();
					$("#containerNosotros").hide();
					$("#containerPoliticas").hide();
					$("#containerContacto").hide();
					$("#containerRedes").hide();
					$("#containerTerminos").hide();
					$("#containerLanding").hide();
				});
				
				$("#redes").click(function() {
					$("#optionsList").hide();
					$("#containerRedes").show();
				});
				$("#landing").click(function() {
					$("#optionsList").hide();
					$("#containerLanding").show();
				});
				$("#nosotros").click(function() {
					$("#optionsList").hide();
					$("#containerNosotros").show();
				});
				$("#politicas").click(function() {
					$("#optionsList").hide();
					$("#containerPoliticas").show();
				});
				$("#contacto").click(function() {
					$("#optionsList").hide();
					$("#containerContacto").show();
				});
				$("#terminos").click(function() {
					$("#optionsList").hide();
					$("#containerTerminos").show();
				});
				
				$("#saveRedes").click(function() {
					var $btn = $(this);
					$btn.addClass('disabled');
					$.ajax({
						type: 'POST',
						url: 'ajax/configuraciones.php',
						data: 'op=7&facebook=' + $("#facebook").val() + '&instagram=' + $("#instagram").val() + '&twitter=' + $("#twitter").val() + '&youtube=' + $("#youtube").val() + '&linkedin=' + $("#linkedin").val(),
						dataType: 'json',
						success: function(data) {
							swal({
								title: 'Información!',
								text: 'Contenido almacenado exitosamente.',
								timer: 2000,
								confirmButtonClass: 'btn btn-primary btn-lg',
								buttonsStyling: false
							});
							$btn.removeClass('disabled');
						}
					});
				});
				$("#saveNosotros").click(function() {
					var texto = tinyMCE.get('contenidoNosotros').getContent();
					var $btn = $(this);
					$btn.addClass('disabled');
					$.post({
						url: 'ajax/configuraciones.php',
						data: {
							op: 4,
							nosotros: texto.replace(/\"/g, '\"').replace("nbsp;", "<br>")
						},
						success: function(data) {
							swal({
								title: 'Información!',
								text: 'Contenido almacenado exitosamente.',
								timer: 2000,
								confirmButtonClass: 'btn btn-primary btn-lg',
								buttonsStyling: false
							});
							$btn.removeClass('disabled');
						}
					});
				});
				$("#savePoliticas").click(function() {
					var $btn = $(this);
					$btn.addClass('disabled');
					var texto = tinyMCE.get('contenidoPoliticas').getContent();
					$.post({
						url: 'ajax/configuraciones.php',
						data: {
							op: 5,
							politicas: texto.replace(/\"/g, '\"').replace("nbsp;", "<br>")
						},
						success: function(data) {
							swal({
								title: 'Información!',
								text: 'Contenido almacenado exitosamente.',
								timer: 2000,
								confirmButtonClass: 'btn btn-primary btn-lg',
								buttonsStyling: false
							});
							$btn.removeClass('disabled');
						}
					});
				});
				$("#saveContacto").click(function() {
					var $btn = $(this);
					$btn.addClass('disabled');
					$.ajax({
						type: 'POST',
						url: 'ajax/configuraciones.php',
						data: 'op=6&contacto=' + $("#contenidoContacto").val() + '&telefono=' + $('#tlfPlat').val() + '&direccion=' + $('#dirPlat').val(),
						dataType: 'json',
						success: function(data) {
							if (data.msg == 'OK') {
								swal({
									title: 'Información!',
									text: 'Contenido almacenado exitosamente.',
									timer: 2000,
									confirmButtonClass: 'btn btn-primary btn-lg',
									buttonsStyling: false
								});
								$btn.removeClass('disabled');
							} else {
								swal("ERROR!", data.msg, "error");
								$btn.removeClass('disabled');
							}
							
						},
						error: function(error){
							swal("ERROR!", "Lo sentimos, ha ocurrido un error. Intentelo de nuevo");
							$btn.removeClass('disabled');
						}
					});
				});
				$("#saveAdmLanding").click(function() {
					var $btn = $(this);
					$btn.addClass('disabled');
					$.ajax({
						type: 'POST',
						url: 'ajax/configuraciones.php',
						data: 'op=9&section1=' + $("#section1").val() + '&section2=' + $('#section2').val() + '&section3=' + $('#section3').val(),
						dataType: 'json',
						success: function(data) {
							if (data.msg == 'OK') {
								swal({
									title: 'Información!',
									text: 'Contenido almacenado exitosamente.',
									timer: 2000,
									confirmButtonClass: 'btn btn-primary btn-lg',
									buttonsStyling: false
								});
								$btn.removeClass('disabled');
							} else {
								swal("ERROR!", data.msg, "error");
								$btn.removeClass('disabled');
							}
							
						},
						error: function(error){
							swal("ERROR!", "Lo sentimos, ha ocurrido un error. Intentelo de nuevo");
							$btn.removeClass('disabled');
						}
					});
				});
				$("#saveTerminos").click(function() {
					var texto = tinyMCE.get('contenidoTerminos').getContent();
					var $btn = $(this);
					$btn.addClass('disabled');
					$.post({
						url: 'ajax/configuraciones.php',
						data: {
							op: 8,
							terminos: texto.replace(/\"/g, '\"').replace("nbsp;", "<br>")
						},
						success: function(data) {
							swal({
								title: 'Información!',
								text: 'Contenido almacenado exitosamente.',
								timer: 2000,
								confirmButtonClass: 'btn btn-primary btn-lg',
								buttonsStyling: false
							});
							$btn.removeClass('disabled');
						}
					});
				});
				
				tinymce.init({
					selector: '#contenidoTerminos',
					height: 150,
					plugins: [
						'advlist lists charmap print preview anchor',
						'searchreplace visualblocks code fullscreen',
						'insertdatetime media table contextmenu paste code'
					],
					toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
					language: 'es'
				});tinymce.init({
					selector: '#contenidoNosotros',
					height: 150,
					plugins: [
						'advlist lists charmap print preview anchor',
						'searchreplace visualblocks code fullscreen',
						'insertdatetime media table contextmenu paste code'
					],
					toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
					language: 'es'
				});
				tinymce.init({
					selector: '#contenidoPoliticas',
					height: 150,
					plugins: [
						'advlist lists charmap print preview anchor',
						'searchreplace visualblocks code fullscreen',
						'insertdatetime media table contextmenu paste code'
					],
					toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
					language: 'es'
				});
				
				$("#iva").click(function() {
					$("#optionsList").hide();
					$("#containerIVA").show();
				});
				$("#planes").click(function() {
					$("#optionsList").hide();
					$("#containerPlanes").show();
				});
				$("#servicios").click(function() {
					$("#optionsList").hide();
					$("#containerServicios").show();
				});
				
				$("#saveIVA").click(function() {
					if($("#ivaPlan").val() != "") {
						var $btn = $(this);
						$btn.addClass('disabled');
						$.ajax({
							type: 'POST',
							url: 'ajax/configuraciones.php',
							data: 'op=1&iva=' + $("#ivaPlan").val(),
							dataType: 'json',
							success: function(data) {
								swal({
									title: 'Información!',
									text: 'IVA almacenado exitosamente.',
									timer: 2000,
									confirmButtonClass: 'btn btn-primary btn-lg',
									buttonsStyling: false
								});
								$btn.removeClass('disabled');
							}
						});
					}
					else {
						swal({
							title: 'Información!',
							text: 'Debe escribir el porcentaje IVA para continuar.',
							timer: 2000,
							confirmButtonClass: 'btn btn-primary btn-lg',
							buttonsStyling: false
						});
					}
				});
				
				$("#savePrices").click(function() {
					if($("#precioBronce").val() != "" && $("#precioPlata").val() != "" && $("#precioOro").val() != "") {
						var $btn = $(this);
						$btn.addClass('disabled');
						$.ajax({
							type: 'POST',
							url: 'ajax/configuraciones.php',
							data: 'op=2&bronce=' + $("#precioBronce").val() + '&plata=' + $("#precioPlata").val() + '&oro=' + $("#precioOro").val(),
							dataType: 'json',
							success: function(data) {
								swal({
									title: 'Información!',
									text: 'Precios actualizados exitosamente.',
									confirmButtonClass: 'btn btn-primary btn-lg',
									buttonsStyling: false
								});
								$btn.removeClass('disabled');
							}
						});
					}
					else {
						swal({
							title: 'Información!',
							text: 'Debe llenar todos los campos de planes.',
							confirmButtonClass: 'btn btn-primary btn-lg',
							buttonsStyling: false
						});
					}
				});
				
				$("#saveServices").click(function() {
					if($("#precioServ1").val() != "" && $("#precioServ2").val() != "" && $("#precioServ3").val() != "") {
						var $btn = $(this);
						$btn.addClass('disabled');
						$.ajax({
							type: 'POST',
							url: 'ajax/configuraciones.php',
							data: 'op=3&serv1=' + $("#precioServ1").val() + '&serv2=' + $("#precioServ2").val() + '&serv3=' + $("#precioServ3").val(),
							dataType: 'json',
							success: function(data) {
								swal({
									title: 'Información!',
									text: 'Precios actualizados exitosamente.',
									confirmButtonClass: 'btn btn-primary btn-lg',
									buttonsStyling: false
								});
								$btn.removeClass('disabled');
							}
						});
					}
					else {
						swal({
							title: 'Información!',
							text: 'Debe llenar todos los campos de servicios.',
							confirmButtonClass: 'btn btn-primary btn-lg',
							buttonsStyling: false
						});
					}
				});
			});
		</script>


	</body>

</html>