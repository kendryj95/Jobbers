<?php
	session_start();

	if(isset($_SESSION["ctc"])) {
		if ($_SESSION["ctc"]["type"] == 3) {
			header("Location: mis-noticias.php");
		}
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
		<title>JOBBERS - Iniciar sesión como admin</title>

		<!-- Vendor CSS -->
		<link rel="stylesheet" href="../vendor/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="../vendor/themify-icons/themify-icons.css">
		<link rel="stylesheet" href="../vendor/font-awesome/css/font-awesome.min.css">
		
		<link rel="stylesheet" href="../vendor/sweetalert2/sweetalert2.min.css">

		<!-- Neptune CSS -->
		<link rel="stylesheet" href="../css/core.css">

		<!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body class="img-cover img-fix-sm" style="background-image: url(235-min.jpg); height: 100vh !important;">
		<div class="auth">
			<div class="auth-header text-center">
				<a href=".././" style="z-index:999"><img src="../img/logo_d.png" alt="" style="width: 300px;"></a>
				<h6 style="color: #000;">Bienvenido! Inicie sesión para acceder a su panel</h6>
			</div>
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-4 offset-md-4">
						<div style="max-width: 350px;margin: 0 auto;">
							<div class="form-group">
								<div class="input-group" style="border: 1px solid #e5e5e5">
									<input type="text" class="form-control" id="exampleInputEmail" placeholder="Email" onkeypress="return runScript(event)">
									<div class="input-group-addon"><i class="ti-email"></i></div>
								</div>
							</div>
							<div class="form-group">
								<div class="input-group" style="border: 1px solid #e5e5e5">
								<input type="password" class="form-control" id="exampleInputPassword" placeholder="Password" onkeypress="return runScript(event)">
									<div class="input-group-addon"><i class="ti-key"></i></div>
								</div>
							</div>							
							<div class="form-group">
								<button class="btn btn-danger btn-block" onclick="acceder();">Acceder</button>
							</div>
							<div class="form-group clearfix">
								<!--<div class="pull-xs-left">
									<a class="text-white font-90" href="javascript:void(0)" id="resetPass" data-toggle="modal" data-target="#forgotPass">Olvidó su contraseña?</a>
								</div>
								<div class="pull-xs-right">
									<a class="text-white font-90" href="registro.php">Registrar empresa</a>
								</div>-->
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="modal fade" id="forgotPass" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title" id="exampleModalLabel">Recuperación de contraseña</h4>
					</div>
					<div class="modal-body">
						<form id="contentEmail">
							<div class="form-group">
								<label for="f-email" class="form-control-label">Correo electrónico:</label>
								<input type="text" class="form-control" id="f-email">
							</div>
						</form>
						<div id="contentCode" style="display: none;">
							<div class="alert alert-success alert-dismissible fade in" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">×</span>
								</button>
								Le hemos enviado un código a su correo electónico, por favor busque en su bandeja de entrada o la carpeta spam e ingrese el codigo en el campo de abajo.
							</div>
							<div class="form-group">
								<label for="code" class="form-control-label">Ingrese el código:</label>
								<input type="text" class="form-control" id="code">
							</div>
						</div>
						<div id="contentPass" style="display: none;">
							<div class="alert alert-success alert-dismissible fade in" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">×</span>
								</button>
								Código validado correctamente, por favor ingrese nu nueva contraseña.
							</div>
							<div class="form-group">
								<label for="p1" class="form-control-label">Nueva contraseña:</label>
								<input type="text" class="form-control" id="p1">
							</div>
							<div class="form-group">
								<label for="p2" class="form-control-label">Repita su nueva contraseña:</label>
								<input type="text" class="form-control" id="p2">
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
						<button type="button" class="btn btn-primary" id="sendF" data-value="1">Enviar</button>
					</div>
				</div>
			</div>
		</div>

		<!-- Vendor JS -->
		<script type="text/javascript" src="../vendor/jquery/jquery-1.12.3.min.js"></script>
		<script type="text/javascript" src="../vendor/tether/js/tether.min.js"></script>
		<script type="text/javascript" src="../vendor/bootstrap/js/bootstrap.min.js"></script>
		
		<script type="text/javascript" src="../vendor/sweetalert2/sweetalert2.min.js"></script>
		
		<script>
			
			function runScript(e) {
           		if (e.keyCode == 13) {
					acceder();
               		return false;
           		}
			}
			
			function isEmail(email) {
			  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			  return regex.test(email);
			}
			
			$('#forgotPass').on('hidden.bs.modal', function (event) {
				$("#sendF").attr("data-value", 1);
				$("#contentEmail").css("display", "block");
				$("#contentCode").css("display", "none");
				$("#contentPass").css("display", "none");
				$("#f-email").val("");
				$("#code").val("");
				$("#p1").val("");
				$("#p2").val("");
			});
			
			$("#sendF").click(function() {
				if(parseInt($("#sendF").attr("data-value")) == 1) {
					if($("#f-email").val() != "") {
						if(isEmail($("#f-email").val())) {
							$.ajax({
								type: 'POST',
								url: 'ajax/empresas.php',
								data: 'op=4&email=' + $("#f-email").val(),
								dataType: 'json',
								success: function(data) {
									if(data.status == 1) {
										$("#sendF").attr("data-value", 2);
										$("#contentEmail").css("display", "none");
										$("#contentCode").css("display", "block");
									}
									else {
										swal({
											title: 'Información!',
											text: 'Correo electrónico no registrado, por favor intente con otro, de lo contrario puede registrarse haciendo click <a href="registro.php">aquí</a>.',
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
								text: 'Correo electrónico inválido.',
								timer: 2000,
								confirmButtonClass: 'btn btn-primary btn-lg',
								buttonsStyling: false
							});
						}
					}
					else {
						swal({
							title: 'Información!',
							text: 'Debe ingresar su correo electrónico.',
							timer: 2000,
							confirmButtonClass: 'btn btn-primary btn-lg',
							buttonsStyling: false
						});
					}
				}
				else {
					if(parseInt($("#sendF").attr("data-value")) == 2) {
						if($("#code").val() != "") {
							$.ajax({
								type: 'POST',
								url: 'ajax/empresas.php',
								data: 'op=5&email=' + $("#f-email").val() + '&code=' + $("#code").val(),
								dataType: 'json',
								success: function(data) {
									if(data.status == 1) {
										$("#sendF").attr("data-value", 3);
										$("#contentCode").css("display", "none");
										$("#contentPass").css("display", "block");
									}
									else {
										swal({
											title: 'Información!',
											text: 'Código incorrecto.',
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
								text: 'Debe escribir el código que recibió en su correo.',
								timer: 2000,
								confirmButtonClass: 'btn btn-primary btn-lg',
								buttonsStyling: false
							});
						}
					}
					else {
						if($("#p1").val() != "" && $("#p2").val() != "") {
							if($("#p1").val() == $("#p2").val()) {
								$.ajax({
									type: 'POST',
									url: 'ajax/empresas.php',
									data: 'op=6&email=' + $("#f-email").val() + '&p=' + $("#p1").val(),
									dataType: 'json',
									success: function(data) {
										swal({
											title: 'Información!',
											text: 'Contraseña modificada satisfactoriamente, iniciando sesión.',
											timer: 2000,
											confirmButtonClass: 'btn btn-primary btn-lg',
											buttonsStyling: false
										});
										setTimeout(function() {
											window.location.assign("./");
										}, 2000);
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
								text: 'Las contraseñas son obligatorias.',
								timer: 2000,
								confirmButtonClass: 'btn btn-primary btn-lg',
								buttonsStyling: false
							});
						}
					}
				}
			});
			
			function acceder() {
				var usuarioCorreo = $("#exampleInputEmail").val();
				var clave = $("#exampleInputPassword").val();
				if(usuarioCorreo == '' || clave == '') {
					swal("Error", "Faltan algunos campos.", "error");
				}
				else {
					$.ajax({
						type: 'POST',
						url: '../ajax/user.php',
						data: {
							op: 11,
							usuario: usuarioCorreo,
							clave: clave
						},
						dataType: 'json',
						success: function(json) {
							if(json.msg == 'OK') {
								swal("Operación exitosa!", "Será redireccionado en breve...", "success");
								setTimeout(function() {
									window.location.assign('mis-noticias.php');
								}, 2500);
							}
							else if(json.msg == "ERROR") {
								swal("Error", "Usuario o clave incorrectos", "error");
							}
						}
					});
				}
			}
		</script>
	</body>
</html>