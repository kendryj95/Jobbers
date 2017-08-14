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
		<title>JOBBERS - Contacto</title>
		<?php require_once('includes/libs-css.php'); ?>
	</head>
	<body class="large-sidebar fixed-sidebar fixed-header skin-5">
		<div class="wrapper">
		<!-- Sidebar -->
		<?php require_once('includes/sidebar.php'); ?>

		<!-- Sidebar second -->
		<?php require_once('includes/sidebar-second.php'); ?>

		<!-- Header -->
		<?php require_once('includes/header.php'); ?>
			<div class="site-content">
				<!-- Content -->
				<div class="content-area p-y-1">
					<div class="container-fluid">
						<h4>Contacto</h4>
						<ol class="breadcrumb no-bg m-b-1">
							<li class="breadcrumb-item"><a href="./">inicio</a></li>
							<li class="breadcrumb-item active">Contacto</li>
						</ol>
						<div class="box bg-white">
							<div class="row m-b-0 m-md-b-1">
								<div class="col-md-9">
									<!--<div class="box-block b-b">
										<h5 class="m-b-1">Connect</h5>
										<span class="m-r-0-5">
											<a class="btn bg-facebook" href="#"><i class="ti-facebook"></i></a>
										</span>
										<span class="m-r-0-5">
											<a class="btn bg-twitter" href="#"><i class="ti-twitter"></i></a>
										</span>
										<span class="m-r-0-5">
											<a class="btn bg-googleplus" href="#"><i class="ti-google"></i></a>
										</span>
										<span class="m-r-0-5">
											<a class="btn bg-instagram" href="#"><i class="ti-instagram"></i></a>
										</span>
									</div>-->
									<div class="box-block b-b">
										<h5 class="m-b-1">Contáctanos</h5>
										<div class="form-group">
											<input class="form-control" id="subject" placeholder="Asunto (*)" type="name">
										</div>
										<div class="form-group">
											<input class="form-control" id="email" placeholder="Correo electrónico (*)" type="email">
										</div>
										<div class="form-group">
											<textarea class="form-control" id="message" placeholder="Mensaje (*)" rows="5"></textarea>
										</div>
										<div class="form-group">
											<button type="submit" class="btn btn-danger btn-rounded" id="sent">Enviar</button>
										</div>
									</div>
									<!--<div class="box-block">
										<address class="text-muted">
											1355 Market Street, Suite 900<br>
											San Francisco, CA 94103<br>
											<abbr title="Phone">P:</abbr> (123) 456-7890
										</address>
									</div>-->
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php require_once('includes/footer.php'); ?>
			</div>
		</div>
		<?php require_once('includes/libs-js.php'); ?>
		<script>
			function isEmail(email) {
			  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			  return regex.test(email);
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