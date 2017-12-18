<?php
	session_start();
	if(!isset($_SESSION["ctc"]["id"])) {
		hearder("Location: ./");
	}
	require_once('classes/DatabasePDOInstance.function.php');
	$db = DatabasePDOInstance();
	$public = $db->getOne("SELECT publico FROM trabajadores WHERE id=" . $_SESSION["ctc"]["id"]);
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
		<title>JOBBERS - Mi cuenta</title>
		<?php require_once('includes/libs-css.php'); ?>
		<link rel="stylesheet" href="vendor/dropify/dist/css/dropify.min.css">

		<!-- Neptune CSS -->
		<link rel="stylesheet" href="css/core.css">

		<style>
			.modal.in.modal-agregar-rubro .modal-dialog {
				max-width: 400px;
			}
		</style>

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

			<!-- Preloader -->
			<div class="preloader"></div>

			<!-- Sidebar -->
			<!-- <?php require_once('includes/sidebar.php'); ?> -->

			<!-- Sidebar second -->
			<?php require_once('includes/sidebar-second.php'); ?>

			<!-- Header -->
			<?php require_once('includes/header.php'); ?>

			<div class="container bg-white">
				<!-- Content -->
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
									<h5>Perfil</h5>
									<div class="items-list">
										<div class="il-item">
											<a class="text-black" href="trabajador-detalle.php?t=<?php echo $_SESSION["ctc"]["name"]."-".$_SESSION["ctc"]["lastName"]."-".$_SESSION["ctc"]["id"]; ?>">
												Ir a mi perfil
											</a>
										</div>
										<div class="il-item">
											<a class="text-black" id="addPic" href="javascript:void(0)">
												Foto
											</a>
										</div>
										<div class="il-item">
											<a class="text-black" id="addPass" href="javascript:void(0)">
												Contraseña
											</a>
										</div>
									</div>
								</div>
								<div class="col-md-4" style="margin-bottom:20px;">
									<h5>Curriculum</h5>
									<div class="items-list">
										<div class="il-item">
											<a class="text-black" href="curriculum.php">
												Modificar
											</a>
										</div>
										<div class="il-item">
											<!--<a class="text-black" href="curriculum.php?o=view">-->
											<a class="text-black" href="vendor/tcpdf/pdf/curriculum.php?i=<?php echo $_SESSION["ctc"]["id"]; ?>">
												Vista previa
											</a>
										</div>
										<div class="il-item">
											<a class="text-black" href="javascript:void(0)" id="privacidad">
												Privacidad
											</a>
										</div>
									</div>
								</div>
								<div class="col-md-4" style="margin-bottom:20px;">
									<h5>Cuenta</h5>
									<div class="items-list">
										<div class="il-item">
											<a class="text-black" href="javascript:void(0)" id="deleteAccount">
												Eliminar
											</a>
										</div>
									</div>
								</div>
							</div>
							<div class="row" style="margin-top: 20px;padding: 10px;padding-top: 0; display:none;" id="containerPrivacy">
								<div class="col-md-8 col-xs-12">
									<a href="javascript:void(0)" class="btn btn-primary w-min-sm m-b-0-25 waves-effect waves-light back"><i class="ti-angle-left"></i> Regresar</a>
									<h6 class="m-t-2">Seleccione nivel de privacidad</h6>
									<p>
										<label class="custom-control custom-radio">
											<input id="radio1" class="custom-control-input" name="nivelP" type="radio" value="2" <?php if($public == 2): ?> checked="true" <?php endif ?> >
											<span class="custom-control-indicator"></span>
											<span class="custom-control-description">Privado (pueden visualizar tu currículum completo sólo las empresas que reciban tus postulaciones).</span>
										</label>
									</p>
									<p>
										<label class="custom-control custom-radio">
											<input id="radio2" name="nivelP" class="custom-control-input" type="radio" value="1" <?php if($public == 1): ?> checked="true" <?php endif ?>>
											<span class="custom-control-indicator"></span>
											<span class="custom-control-description">Público (tanto las empresas a las que te postules como las que accedan a nuestra base de datos pueden visualizar el contenido completo de tu currículum).</span>
										</label>
									</p>
									<a href="javascript:void(0)" style="margin-top: 5px;" id="saveNivelP" class="btn btn-primary w-min-sm m-b-0-25 waves-effect waves-light">Guardar</a>
								</div>
							</div>
							<div class="row" style="margin-top: 20px; display: none;" id="pic">
								<div class="col-md-2 col-xs-12" style="text-align: center; margin-bottom: 10px;">
									<h4>Foto de perfil</h4>
									<img src="img/<?php echo $_SESSION["ctc"]["pic"]; ?>" alt="" class="img-circle m-r-1" width="100" height="100">
								</div>
								<div class="col-md-4 col-xs-12">
									<a href="javascript:void(0)" class="btn btn-primary w-min-sm m-b-0-25 waves-effect waves-light back"><i class="ti-angle-left"></i> Regresar</a>
									<form method="POST" id="upload">
										<input class="dropify" name="file" id="file" type="file">
									</form>
									<a href="javascript:void(0)" style="margin-top: 5px;" id="savePic" class="btn btn-primary w-min-sm m-b-0-25 waves-effect waves-light">Guardar</a>
								</div>
							</div>
							<div class="row" style="margin-top: 20px; display: none;" id="pass">
								<div class="col-md-8 col-xs-12">
									<a href="javascript:void(0)" class="btn btn-primary w-min-sm m-b-0-25 waves-effect waves-light back"><i class="ti-angle-left"></i> Regresar</a>
									<div class="form-group row" style="margin-top: 20px;">
										<label for="currentPass" class="col-xs-4 col-form-label">Contraseña actual</label>
										<div class="col-xs-8">
											<input class="form-control" id="currentPass" type="password">
										</div>
									</div>
									<div class="form-group row">
										<label for="pass1" class="col-xs-4 col-form-label">Nueva contraseña </label>
										<div class="col-xs-8">
											<input class="form-control" id="pass1" type="password">
										</div>
									</div>
									<div class="form-group row" style="margin-bottom: 20px;">
										<label for="pass2" class="col-xs-4 col-form-label">Repita contraseña</label>
										<div class="col-xs-8">
											<input class="form-control" id="pass2" type="password">
										</div>
									</div>
									<a href="javascript:void(0)" style="margin-top: 5px;" id="savePass" class="btn btn-primary w-min-sm m-b-0-25 waves-effect waves-light">Guardar</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- Footer -->
				<?php require_once('includes/footer.php'); ?>
			</div>
			
			
		<!-- </div> -->
	</div>
	

		<?php require_once('includes/libs-js.php'); ?>
		<script type="text/javascript" src="vendor/dropify/dist/js/dropify.min.js"></script>
		<script type="text/javascript" src="js/jquery.form.js"></script>

		<script>
			$(document).ready(function(){
				
				$("#privacidad").click(function() {
					$("#optionsList").hide();
					$("#containerPrivacy").show();
				});
				
				$("#saveNivelP").click(function() {
					$.ajax({
						url: 'ajax/account.php',
						type: 'GET',
						dataType: 'json',
						data: 'op=9&public=' + $("input[type=radio][name=nivelP]:checked").val()
					}).done(function(data, textStatus, jqXHR) {
						switch(jqXHR.status) {
							case 200:
								var json = JSON.parse(jqXHR.responseText);
								if(json.msg == 'OK') {
									swal("Operación exitosa!", "Infromación actualizada.", "success");
									$("#optionsList").show();
									$("#containerPrivacy").hide();
								}
								break;
						}
					});
				});
				
				$("#deleteAccount").click(function() {
					swal({
					  title: "Advertencia",
					  text: "Está seguro que desea eliminar su cuenta?",
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
								url: 'ajax/account.php',
								type: 'GET',
								dataType: 'json',
								data: 'op=8'
							}).done(function(data, textStatus, jqXHR) {
								switch(jqXHR.status) {
									case 200:
										var json = JSON.parse(jqXHR.responseText);
										if(json.msg == 'OK') {
											swal("Operación exitosa!", "Gracias por su tiempo.", "success");
											setTimeout(function() {
												window.location.assign("./");
											});
										}
										break;
								}
							});
						}
					});
				});
				
				$('.dropify').dropify();
				
				$("#addPic").click(function() {
					$("#optionsList").css("display", "none");
					$("#pic").css("display", "block");
				});
				$("#addPass").click(function() {
					$("#optionsList").css("display", "none");
					$("#pass").css("display", "block");
				});
				$(".back").click(function() {
					$("#optionsList").css("display", "block");
					$("#pic").css("display", "none");
					$("#pass").css("display", "none");
					$("#containerPrivacy").hide();
				});
				
				$("#savePic").click(function() {
					if($("#file")[0].files.length > 0) {
						$("#savePic").attr("disabled", true);
						$("#savePic").html("Espere...");
						$("#upload").attr("action", "ajax/account.php?op=6");
						var options={
							url     : $("#upload").attr("action"),
							success : function(response,status) {
								var data = JSON.parse(response);
								if(parseInt(data.status) == 1) {
									window.location.assign("cuenta.php");
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
								$("#savePic").attr("disabled", false);
								$("#savePic").html("Guardar");
							}
						};
						$("#upload").ajaxSubmit(options);
						return false;	
					}
					else {
						swal({
							title: 'Información!',
							text: 'Debe añadir una foto',
							timer: 2000,
							confirmButtonClass: 'btn btn-primary btn-lg',
							buttonsStyling: false
						});
					}
				});
				
				$("#savePass").click(function() {
					if($("#currentPass").val() != "" && $("#pass1").val() != "" && $("#pass2").val() != "") {
						if($("#pass1").val() == $("#pass2").val()) {
							$.ajax({
								type: 'POST',
								url: 'ajax/user.php',
								data: 'op=4&current=' + $("#currentPass").val() + '&p=' + $("#pass1").val(),
								dataType: 'json',
								success: function(data) {
									if(parseInt(data.status) == 2) {
										swal({
											title: 'Información!',
											text: 'La contraseña actual es incorrecta, por favor intente de nuevo.',
											confirmButtonClass: 'btn btn-primary btn-lg',
											buttonsStyling: false
										});
									}
									else {
										$("#currentPass").val("");
										$("#pass1").val("");
										$("#pass2").val("");
										swal({
											title: 'Información!',
											text: 'Contraseña modificada exitosamente.',
											timer: 2000,
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
								text: 'Las contraseñas no coinciden.',
								timer: 2000,
								confirmButtonClass: 'btn btn-primary btn-lg',
								buttonsStyling: false
							});
						}
					}
					else {
						swal({
							title: 'Información!',
							text: 'Todos los campos son obligatorios.',
							timer: 2000,
							confirmButtonClass: 'btn btn-primary btn-lg',
							buttonsStyling: false
						});
					}
				});
			});
		</script>
	</body>

</html>