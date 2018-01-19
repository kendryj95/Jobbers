<?php
	session_start();
	if (isset($_SESSION["ctc"])) {
		header("Location: ./");
	}
	require_once('classes/DatabasePDOInstance.function.php');
	
	$db = DatabasePDOInstance();
	$info = $db->getRow("SELECT politicas, terminos FROM plataforma WHERE id=1");

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
		<title>JOBBERS - Registrarse</title>

		<!-- Vendor CSS -->
		<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="vendor/themify-icons/themify-icons.css">
		<link rel="stylesheet" href="vendor/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="vendor/sweetalert2/sweetalert2.min.css">

		<!-- Neptune CSS -->
		<link rel="stylesheet" href="css/core.css">

		<!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

		<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
		<script>
		  (adsbygoogle = window.adsbygoogle || []).push({
		    google_ad_client: "ca-pub-1968505410020323",
		    enable_page_level_ads: true
		  });
		</script>
	</head>

	<style>
		.has-error{
			box-shadow: -1px 1px 10px 0px rgba(255,51,51,.7);
		}
	</style>

	<body class="img-cover" style="background-image: url(img/OB82100.jpg);">


	<script>
		window.fbAsyncInit = function() {
			FB.init({
				appId      : '1785394951770843',
				status	   : true,
				xfbml      : true,
				version    : 'v2.9'
			});
			FB.AppEvents.logPageView();
		};

		(function(d, s, id){
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) {return;}
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/en_US/sdk.js";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));

	</script>

		<div class="container-fluid">
			<div class="sign-form">
				<div class="row">
					<div class="col-md-4 offset-md-4 p-x-3">
						<div class="box b-a-0">
							<div style="text-align: center;margin: ;">
								<a href="./"><img src="img/logo_d.png" style="height: 50px; margin-top: 20px;"></a>
							</div>
							<div class="p-a-2 text-xs-center">
								<h5>Únete a nosotros</h5>
							</div>
							<form class="form-material">
								<div class="form-group">
									<input type="text" class="form-control" id="name" placeholder="Nombres (*)" onchange="validar(this.id,'texto',this.title)" title='Nombre'>
								</div>
								<div class="form-group">
									<input type="text" class="form-control" id="lastName" placeholder="Apellidos (*)"  onchange="validar(this.id,'texto',this.title)" title='Apellido'>
								</div>
								<div class="form-group">
									<input type="email" class="form-control" id="email" placeholder="Correo electronico (*)"  onchange="validar(this.id,'email')">
								</div>
								<div class="form-group">
									<input type="email" class="form-control" id="confirmEmail" placeholder="Confimar correo electrónico (*)" onchange="validar(this.id,'email')">
								</div>
								<div class="form-group">
									<input type="password" class="form-control" id="passw1" placeholder="Contraseña (*)">
								</div>
								<div class="form-group">
									<input type="password" class="form-control" id="passw2" placeholder="Confirmar contraseña (*)">
								</div>
								<label class="custom-control custom-checkbox" style="margin-left: 20px;display: inline-flex;">
									<input class="custom-control-input" type="checkbox" id="aceptaCondiciones">
									<span class="custom-control-indicator"></span>
									<span class="custom-control-description">Acepto <a href="#" data-toggle="modal" data-target=".large-modal">Términos y condiciones</a> y <a href="#"  data-toggle="modal" data-target=".large-modal2">Políticas de Privacidad</a>. *</span>
								</label>
								<br>
								<label class="custom-control custom-checkbox" id="aceptaPublicidad" style="margin-left: 20px;display: inline-flex;">
									<input class="custom-control-input" type="checkbox">
									<span class="custom-control-indicator"></span>
									<span class="custom-control-description">Acepto recibir publicidad de terceros y sitios asociados.</span>
								</label>
								<br>
								<label class="custom-control custom-checkbox" style="margin-left: 20px;display: inline-flex;">
									<input class="custom-control-input" type="checkbox" id="aceptaNewsletter">
									<span class="custom-control-indicator"></span>
									<span class="custom-control-description">Acepto recibir newsletters con novedades, promociones y actualizaciones.</span>
								</label>
								<br>
								<div class="p-x-2 m-b-0" style="margin-top: 10px;">
									<a href="javascript:void(0)" class="btn btn-primary btn-block text-uppercase" id="register" style="color: white;">Registrarse</a>
								</div><br>
								<div class="p-x-2">
									<div class="row">
										<!-- <div class="col-xs-12">
											<a href="javascript:void(0)" onClick="Login()" class="btn bg-facebook btn-block label-left m-b-0-25">
												<span class="btn-label"><i class="ti-facebook"></i></span>
												Regístrate con Facebook
											</a>
										</div> -->
								
										<!-- <div class="col-xs-6">
											<button type="button" class="btn bg-googleplus btn-block label-left m-b-0-25">
												<span class="btn-label"><i class="ti-google"></i></span>
												Google+
											</button>
										</div> -->
									</div>
								</div>
							</form>
							<div class="p-a-2 text-xs-center text-muted">
								Ya tienes cuenta? <a class="text-black" href="ingresar.php"><span class="underline">Iniciar sesión</span></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="modal fade large-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h4 class="modal-title" id="mySmallModalLabel">Términos y condiciones</h4>
					</div>
					<div class="modal-body">
						<?php echo $info["terminos"]; ?>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
					</div>
				</div>
			</div>
		</div>
		
		<div class="modal fade large-modal2" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h4 class="modal-title" id="mySmallModalLabel">Políticas de privacidad</h4>
					</div>
					<div class="modal-body">
						<?php echo $info["politicas"]; ?>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
					</div>
				</div>
			</div>
		</div>

		<!-- Vendor JS -->
		<script type="text/javascript" src="vendor/jquery/jquery-1.12.3.min.js"></script>
		<script type="text/javascript" src="vendor/tether/js/tether.min.js"></script>
		<script type="text/javascript" src="vendor/bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="vendor/sweetalert2/sweetalert2.min.js"></script>
		<script type="text/javascript" src="js/validar.js"></script>
		<script>
			function isEmail(email) {
			  var regex = /^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/;
			  return regex.test(email);
			}
			
			var info = {};

			function Login() {

				FB.login(function(response) {
					if (response.authResponse) {
						access_token = response.authResponse.accessToken; //get access token
						getUserInfo();

					} else {}
				}, {
					scope: 'public_profile,email,user_about_me,user_birthday,user_location',
					return_scopes: true
				});

			}
		  	function getUserInfo() {
				FB.api('/me',{fields:'id,first_name,last_name,email,picture,gender,location,birthday'}, function(response) {
					gender = (response.gender === 'male')?'1':'2';
					$.ajax({
						type: 'POST',
						url: 'ajax/user.php',
						data: 'op=10&e=' + response.email + '&n=' + response.first_name +'&a=' + response.last_name + '&p=' + response.picture.data.url+ '&g=' + gender+ '&i=' + response.id,
						dataType: 'json',
						success: function(data) {
							if(data.status == 1) {
								//console.log('Muestra algo');
								swal({
									title: 'Excelente!',
									text: 'Registrado Satisfactoriamente.',
									timer: 3000,
									confirmButtonClass: 'btn btn-primary btn-lg',
									buttonsStyling: false
								});
								setTimeout(function(){
									window.location.href = "./";
								},2000);
								//window.location.assign("./");
							}else if(data.status == 2){
								//console.log('Muestra algo 2');
								swal({
									title: 'Información!',
									text: 'Usuario existente.',
									timer: 3000,
									confirmButtonClass: 'btn btn-primary btn-lg',
									buttonsStyling: false
								});
							}else if(data.status == 3){
								swal({
									title: 'Información!',
									text: 'Sin reespuesta de Facebook, REgistrese manualmente.',
									timer: 3000,
									confirmButtonClass: 'btn btn-primary btn-lg',
									buttonsStyling: false
								});
							}
						}
					});
				});
			}
			function getPhoto() {
			  	FB.api('/me/picture?type=normal', function(response) {
					info.pic = response.data.url;
				});
			}
			
			function Logout() {
				FB.logout(function(){});
			}

		  	/*// Load the SDK asynchronously
		  (function(d){
			 var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
			 if (d.getElementById(id)) {return;}
			 js = d.createElement('script'); js.id = id; js.async = true;
			 js.src = "//connect.facebook.net/en_US/all.js";
			 ref.parentNode.insertBefore(js, ref);
		   }(document));*/


			$("#register").click(function() {
				var $btn = $(this);
				if($("#email").val() != "" && $("#passw1").val() != "" && $("#passw2").val() != "" && $("#name").val() != "" && $("#lastName").val() != "" && $("#userName").val() != "") {
					if($("#aceptaCondiciones:checked").length > 0) {
						if(isEmail($("#email").val())) { // Confirma si es un email valido
							if ($('#email').val().toLowerCase().trim() == $('#confirmEmail').val().toLowerCase().trim()) { // Confirma si los emails coinciden
								if($("#passw1").val() == $("#passw2").val()) { // Confirma si las contraseñas coinciden
									if(($("#passw1").val().length >= 8 && $("#passw1").val().length <= 12)&&($("#passw2").val().length >= 8 && $("#passw2").val().length <= 12  )) { // Confirma si las contraseñas tienen la lomgitud

										$btn.addClass('disabled');

										$.ajax({
											type: 'POST',
											url: 'ajax/user.php',
											data: 'op=2&email=' + $("#email").val() + '&password=' + $("#passw1").val() + '&name=' + $("#name").val() + '&lastName=' + $("#lastName").val() + '&publicidad=' + $("#aceptaPublicidad:checked").length + '&newsletter=' + $("#aceptaNewsletter:checked").length,
											dataType: 'json',
											success: function(data) {

												$btn.removeClass('disabled');

												if(data.status == 1) {
													swal("EXITO!", "Registrado Satisfactoriamente", "success");
													$('.form-material')[0].reset();
													setTimeout(function(){
														window.location.assign("./");
													},3000);

													$('.form-group').each(function(index, el) {
															$(el).removeClass('has-error');
													});

												} else if(data.status == 2){
													swal({
														title: 'Información!',
														text: 'Correo electrónico en uso intente de nuevo',
														timer: 2500,
														confirmButtonClass: 'btn btn-primary btn-lg',
														buttonsStyling: false
													});
													
												} else {
													swal({
														title: 'ERROR!',
														text: 'Ha ocurrido un error al registrarse, por favor intentelo de nuevo.',
														timer: 2500,
														confirmButtonClass: 'btn btn-primary btn-lg',
														buttonsStyling: false
													});
												}
											}
										});
									}
								}
								else {
									swal({
										title: 'Información!',
										text: 'Las contraseñas no coinciden',
										timer: 2000,
										confirmButtonClass: 'btn btn-primary btn-lg',
										buttonsStyling: false
									});
								}
							} else {
								swal({
									title: 'Información!',
									text: 'Los correos electrónicos no coinciden',
									timer: 2000,
									confirmButtonClass: 'btn btn-primary btn-lg',
									buttonsStyling: false
								});
								
								$('#email, #confirmEmail').parent().addClass('has-error');
							}
						}else {
							swal({
								title: 'Información!',
								text: 'Correo electrónico inválido',
								timer: 2000,
								confirmButtonClass: 'btn btn-primary btn-lg',
								buttonsStyling: false
							});
							
							$('#email').parent().addClass('has-error');

						}
					}
					else {
						swal({
							title: 'Información!',
							text: 'Debe aceptar los Términos y condiciones y Políticas de Privacidad.',
							confirmButtonClass: 'btn btn-primary btn-lg',
							buttonsStyling: false
						});
					}
				}
				else {
					swal({
						title: 'Información!',
						text: 'Todos los campos con (*) son obligatorios',
						timer: 2000,
						confirmButtonClass: 'btn btn-primary btn-lg',
						buttonsStyling: false
					});

					$('.form-group').each(function(index, el) {
						if ($(el).children('input').val() == "") {
							$(el).addClass('has-error');
						} else {
							$(el).removeClass('has-error');
						}
					});
				}
			});
		</script>
	</body>
</html>