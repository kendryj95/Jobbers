<?php
	session_start();
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
		<title>JOBBERS - Soport Tecnico</title>
		<?php require_once('includes/libs-css.php'); ?>

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

		<!-- Sidebar second -->
		<?php require_once('includes/sidebar-second.php'); ?>

		<!-- Header -->
		<?php require_once('includes/header.php'); ?>
			<div class="site-content bg-white" style="margin-left: 0px; height: 100%">
				<!-- Content -->
				<div class="content-area p-y-1">
					<div class="container">
						<h4>Soporte Técnico</h4>
						<ol class="breadcrumb no-bg m-b-1">
							<li class="breadcrumb-item"><a href="./">Inicio</a></li>
							<li class="breadcrumb-item active">Soporte Técnico</li>
						</ol>
						<div class="box bg-white">
							<div class="row m-b-0 m-md-b-1">
								<div class="col-md-12">
									<div class="box-block b-b">
										<h5 class="m-b-1">Soporte Técnico</h5>
										<?php if (isset($_SESSION["ctc"])): ?>
												<div class="well">
													<b id="name"><?= $_SESSION['ctc']['name'] . " " . $_SESSION['ctc']['lastName'] ?></b>
												</div>
												<div class="well">
													<b id="email"><?= $_SESSION['ctc']['email'] ?></b>
												</div>
										<?php else: ?>
												<div class="form-group">
													<input class="form-control" id="name" placeholder="Nombre y Apellido (*)" type="text">
												</div>
												<div class="form-group">
													<input class="form-control" id="email" placeholder="Correo electrónico (*)" type="email">
												</div>
									 	<?php endif; ?>
										
										<div class="form-group">
											<select name="" id="" class="custom-select form-control" onChange="select_soporte(this.value)">
												<option value="0">Asunto (*)</option>
												<option value="1">No pude registrame</option>
												<option value="2">No pude cargar mis datos de CV</option>
												<option value="3">Problema de diseño en la pagina</option>
												<option value="4">No puedo cargar mi foto de perfil</option>
											</select>
										</div>

										<?php include('select_soporte.html') ?>

										<div class="form-group">
											<textarea class="form-control" id="message" placeholder="Mensaje (*)" rows="5"></textarea>
										</div>
										<div class="form-group">
											<button type="submit" class="btn btn-primary btn-rounded" id="sent">Enviar</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php require_once('includes/footer.php'); ?>
			</div>
		<!-- </div> -->
		<?php require_once('includes/libs-js.php'); ?>
		<script>
			function isEmail(email) {
			  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			  return regex.test(email);
			}

			function select_soporte(val){

				var value = '';

				switch(val){
					case '1':
						$('#soporte_1').show();
						$('#soporte_2').hide();
						$('#soporte_3').hide();
						$('#soporte_4').hide();
						value = 'No pude registrame';
						break;
					case '2':
						$('#soporte_1').hide();
						$('#soporte_2').show();
						$('#soporte_3').hide();
						$('#soporte_4').hide();
						value = 'No pude cargar mis datos de CV';
						break;
					case '3':
						$('#soporte_1').hide();
						$('#soporte_2').hide();
						$('#soporte_3').show();
						$('#soporte_4').hide();
						value = 'Problema de diseño en la pagina';
						break;
					case '4':
						$('#soporte_1').hide();
						$('#soporte_2').hide();
						$('#soporte_3').hide();
						$('#soporte_4').show();
						value = 'No puedo cargar mi foto de perfil';
						break;
					default:
						$('#soporte_1').hide();
						$('#soporte_2').hide();
						$('#soporte_3').hide();
						$('#soporte_4').hide();
						value = '';
						break;
				}

				console.log("idValue ===> ", val, "Value ===>", value);

				return new Array(value, $('#select_soporte_'+val).val()); // position 0 = Asunto principal, position 1 = asunto secundario
			}
			
			$("#sent").click(function() {
				if($("#subject").val() != "" && $("#email").val() != "" && $("#message").val() != "") {
					if(isEmail($("#email").val())) {
						$.ajax({
							type: 'POST',
							url: 'ajax/user.php',
							data: 'op=12&email=' + $("#email").val() + '&subject=' + $("#subject").val() + '&message=' + $("#message").val(),
							dataType: 'json',
							success: function(data) {
								if(data.msg == "OK") {
									swal({
										title: 'Información!',
										text: 'Su mensaje se ha enviado exitosamente, gracias por contactarnos, le responderemos a la brevedad posible.',
										confirmButtonClass: 'btn btn-primary btn-lg',
										buttonsStyling: false
									});
									$("#email").val("");
									$("#subject").val("");
									$("#message").val("");
								}
								else {
									swal({
										title: 'Información!',
										text: 'No se pudo enviar su mensaje, intente de nuevo más tarde.',
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
							confirmButtonClass: 'btn btn-primary btn-lg',
							buttonsStyling: false
						});
					}
				}
				else {
					swal({
						title: 'Información!',
						text: 'Todos los campos son obligatorios.',
						confirmButtonClass: 'btn btn-primary btn-lg',
						buttonsStyling: false
					});
				}
			});
		</script>
	</body>
</html>