<?php
	session_start();

	if(!isset($_SESSION["ctc"]["empresa"])) {
		header('Location: acceder.php');
	}

	require_once('../classes/DatabasePDOInstance.function.php');

	$db = DatabasePDOInstance();

	$planes = $db->getAll("SELECT * FROM planes WHERE id != 1");
	$servicios = $db->getAll("SELECT * FROM servicios WHERE id != 4");

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
	<title>JOBBERS - Planes</title>
	<?php require_once('../includes/libs-css.php'); ?>
	<style>
		.card {
			border-radius: 6px;
		}
	</style>
</head>

<body class="large-sidebar fixed-sidebar fixed-header skin-5">
	<div class="wrapper">

		<!-- Preloader -->
		<div class="preloader"></div>

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
					<div id="step1">
						<h4>Planes</h4>
						<div class="row row-md">
							<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12" style="margin-bottom: 20px;">
								<div class="card price-card">
									<div class="card-header price-card-header  bg-primary text-xs-center">
										<h6 class="text-uppercase">Gratis</h6>
										<h3 class="m-b-0">
											<sup>$</sup>
											<span class="text-big">0</span>
											<span class="text-small">/ 1 mes</span>
										</h3>
									</div>
									<ul class="price-card-list p-l-0 m-b-0">
										<li>
											<i class="fa fa-remove text-muted m-r-0-25"></i> <span class="text-muted">Cubrí las vacantes de forma más economica.</span>
										</li>
										<li>
											<i class="fa fa-check text-success m-r-0-25"></i> <span class="text-muted">15 días de publicacion</span>
										</li>
										<li>
											<i class="fa fa-remove text-muted m-r-0-25"></i> <span class="text-muted">Incluye logo corporativo en home tamaño chico</span>
										</li>
										<li>
											<i class="fa fa-remove text-muted m-r-0-25"></i> <span class="text-muted">Visibilidad en la home</span>
										</li>
										<li>
											<i class="fa fa-check text-success m-r-0-25"></i> <span class="text-muted">10 CVs disponibles para descargar en un mes.</span>
										</li>
										<li>
											<i class="fa fa-remove text-muted m-r-0-25"></i> <span class="text-muted">Filtros Personalizados.</span>
										</li>
									</ul>
									<div class="card-footer">
										<a href="javascript:void(0)" class="btn btn-primary btn-block btn-lg addPlan" data-target="1">Seleccionar</a>
									</div>
								</div>
							</div>
							<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12" style="margin-bottom: 20px;">
								<div class="card price-card">
									<div class="card-header price-card-header bg-primary text-xs-center" style="width: 100%;height: 99px;">
										<h6 class="text-uppercase">Bronce</h6>
										<h3 class="m-b-0">
											<sup>$</sup>
											<span class="text-big" style="font-size: 28px;"><?php echo $planes[0]["precio"]; ?></span>
											<span class="text-small">/ mes</span>
										</h3>
									</div>
									<ul class="price-card-list p-l-0 m-b-0">
										<li>
											<i class="fa fa-check text-success m-r-0-25"></i> <span class="text-muted">Cubrí las vacantes de forma más economica.</span>
										</li>
										<li>
											<i class="fa fa-check text-success m-r-0-25"></i> <span class="text-muted">30 días de publicación.</span>
										</li>
										<li>
											<i class="fa fa-check text-success m-r-0-25"></i> <span class="text-muted">Incluye logo corporativo en la pantalla principal y en tamaño chico.</span>
										</li>
										<li>
											<i class="fa fa-check text-success m-r-0-25"></i> <span class="text-muted">Visibilidad en la home</span>
										</li>
										<li>
											<i class="fa fa-remove text-muted m-r-0-25"></i> <span class="text-muted">  Link de acceso a pagina de la empresa.</span>
										</li>
										<li>
											<i class="fa fa-remove text-muted m-r-0-25"></i> <span class="text-muted">   40 CVs disponibles para descargar en un mes.</span>
										</li>
										<li>
											<i class="fa fa-remove text-muted m-r-0-25"></i> <span class="text-muted">Filtros Personalizados.</span>
										</li>
										<li>
											<i class="fa fa-remove text-muted m-r-0-25"></i> <span class="text-muted">  Ideal para búsquedas de perfiles habituales.</span>
										</li>
										<li>
											<i class="fa fa-remove text-muted m-r-0-25"></i> <span class="text-muted"> CHAT INTERNO CON CANDIDATOS.</span>
										</li>
									</ul>
									<div class="card-footer">
										<a href="javascript:void(0)" class="btn btn-outline-primary btn-block btn-lg addPlan" data-target="2">Seleccionar</a>
									</div>
								</div>
							</div>
							<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12" style="margin-bottom: 20px;">
								<div class="card price-card">
									<div class="card-header price-card-header bg-primary text-xs-center" style="width: 100%;height: 99px;">
										<h6 class="text-uppercase">Plata</h6>
										<h3 class="m-b-0">
											<sup>$</sup>
											<span class="text-big" style="font-size: 28px;"><?php echo $planes[1]["precio"]; ?></span>
											<span class="text-small">/ mes</span>
										</h3>
									</div>
									<ul class="price-card-list p-l-0 m-b-0">
										<li>
											<i class="fa fa-check text-success m-r-0-25"></i> <span class="text-muted">Opta por  mayor visibilidad en los avisos.</span>
										</li>
										<li>
											<i class="fa fa-check text-success m-r-0-25"></i> <span class="text-muted"> Link de acceso a tu empresa.</span>
										</li>
										<li>
											<i class="fa fa-check text-success m-r-0-25"></i> <span class="text-muted"> 30 días de publicación.</span>
										</li>
										<li>
											<i class="fa fa-check text-success m-r-0-25"></i> <span class="text-muted"> Buena Visibilidad.<span style="color:white;">.</span></span>
										</li>
										<li>
											<i class="fa fa-check text-success m-r-0-25"></i> <span class="text-muted">Ideal para perfiles específicos.</span>
										</li>
										<li>
											<i class="fa fa-check text-success m-r-0-25"></i> <span class="text-muted"> Incluye logo corporativo tamaño mediano en lugar privilegiado.</span>
										</li>
										<li>
											<i class="fa fa-remove text-muted m-r-0-25"></i> <span class="text-muted"> Opcion de publicar un producto de venta o video institucional.</span>
										</li>
										<li>
											<i class="fa fa-remove text-muted m-r-0-25"></i> <span class="text-muted"> 100 CVs disponibles para descargar en un mes.</span>
										</li>
										<li>
											<i class="fa fa-remove text-muted m-r-0-25"></i> <span class="text-muted"> Filtros Personalizados.</span>
										</li>
										<li>
											<i class="fa fa-remove text-muted m-r-0-25"></i> <span class="text-muted"> CHAT INTERNO CON CANDIDATOS.</span>
										</li>
									</ul>
									<div class="card-footer">
										<a href="javascript:void(0)" class="btn btn-outline-primary btn-block btn-lg addPlan" data-target="3">Seleccionar</a>
									</div>
								</div>
							</div>
							<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12" style="margin-bottom: 20px;">
								<div class="card price-card">
									<div class="card-header price-card-header bg-primary text-xs-center" style="width: 100%;height: 99px;">
										<h6 class="text-uppercase">Oro</h6>
										<h3 class="m-b-0">
											<sup>$</sup>
											<span class="text-big" style="font-size: 28px;"><?php echo $planes[2]["precio"]; ?></span>
											<span class="text-small">/ mes</span>
										</h3>
									</div>
									<ul class="price-card-list p-l-0 m-b-0">
										<li>
											<i class="fa fa-check text-success m-r-0-25"></i> <span class="text-muted">Máxima visibilidad , volumen e imagen</span>
										</li>
										<li>
											<i class="fa fa-check text-success m-r-0-25"></i> <span class="text-muted"> 35 días de publicación.</span>
										</li>
										<li>
											<i class="fa fa-check text-success m-r-0-25"></i> <span class="text-muted"> Exposición en principal home.</span>
										</li>
										<li>
											<i class="fa fa-check text-success m-r-0-25"></i> <span class="text-muted"> Máximo destaque.</span>
										</li>
										<li>
											<i class="fa fa-check text-success m-r-0-25"></i> <span class="text-muted"> Incluye logo corporativo tamaño grande en lugar preferencial.</span>
										</li>
										<li>
											<i class="fa fa-check text-success m-r-0-25"></i> <span class="text-muted"> Link de acceso a pagina de la empresa.</span>
										</li>
										<li>
											<i class="fa fa-check text-success m-r-0-25"></i> <span class="text-muted"> Opcion de publicar un producto de venta o video institucional.</span>
										</li>
										<li>
											<i class="fa fa-check text-success m-r-0-25"></i> <span class="text-muted"> Sin limites para descargar CV'S</span>
										</li>
										<li>
											<i class="fa fa-check text-success m-r-0-25"></i> <span class="text-muted">Ideal para reclutadoras o búsquedas de varios perfiles.</span>
										</li>
										<li>
											<i class="fa fa-check text-success m-r-0-25"></i> <span class="text-muted">Filtros Personalizados.</span>
										</li>
										<li>
											<i class="fa fa-check text-success m-r-0-25"></i> <span class="text-muted">CHAT INTERNO CON CANDIDATOS.</span>
										</li>
									</ul>
									<div class="card-footer">
										<a href="javascript:void(0)" class="btn btn-outline-primary btn-block btn-lg addPlan" data-target="4">Seleccionar</a>
									</div>
								</div>
							</div>
						</div>
						
							<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12" style="margin-bottom: 20px; margin-left:40%;">
								<div class="card price-card" style="min-height: 150px;">
									<a href="javascript:void(0)" id="updatePlan" class="btn btn-primary btn-block btn-lg" style="margin-top: 50px;">Actualizar</a>
								</div>
							</div>
						</div>
					</div>
					<div class="row" id="step2" style="display: none;">
						<div class="col-md-12">
							<div class="preloader" style="position: absolute;"></div>
							<div class="card card-block">
								<h3 class="card-title">Información para el pago</h3>
								<div id="containerFree">
									<h4 class="text-muted">Datos del plan</h4>
									<ul class="list-group list-group-flush">
										<li class="list-group-item b-l-0 b-r-0 text-muted">Tipo: <strong>Gratis</strong></li>
										<li class="list-group-item b-l-0 b-r-0 text-muted">Precio: 0$</li>
										<li class="list-group-item b-l-0 b-r-0 text-muted">Valido por: 1 mes</li>
									</ul>
									<a href="javascript:void(0)" id="continue" class="btn btn-primary" style="margin-bottom: 15px;margin-top: 15px;">Continuar</a>
								</div>

								<div class="row m-b-2" id="containerPay" style="display: none;">
									<div class="col-sm-2"></div>
									<div class="col-sm-8">
										<div class="c-inputs-stacked">
											<div id="services" style="display: none;">
												<h4 class="text-muted">Datos del servicio</h4>
												<ul class="list-group list-group-flush" id="listServices"></ul>
											</div>
											<div style="text-align: center;"><a href="" id="payMP" name="MP-Checkout" class="btn btn-primary" style="margin-bottom: 15px;margin-top: 15px;"><i class="ti-money"></i> Realizar pago</a></div>
											<div style="text-align: center;"><img src="../img/mercadopago-formas-de-pago.png"></div>
										</div>
									</div>
									<div class="col-sm-2"></div>
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
	
	<!-- <script type="text/javascript" src="//resources.mlstatic.com/mptools/render.js"></script> -->

	<script type="text/javascript">
	(function(){function $MPC_load(){window.$MPC_loaded !== true && (function(){var s = document.createElement("script");s.type = "text/javascript";s.async = true;s.src = document.location.protocol+"//secure.mlstatic.com/mptools/render.js";var x = document.getElementsByTagName('script')[0];x.parentNode.insertBefore(s, x);window.$MPC_loaded = true;})();}window.$MPC_loaded !== true ? (window.attachEvent ?window.attachEvent('onload', $MPC_load) : window.addEventListener('load', $MPC_load, false)) : null;})();
	</script>
	
	<script>
		var info_plan = JSON.parse('<?php echo json_encode($_SESSION["ctc"]["plan"]); ?>');
		var info_serv = JSON.parse('<?php echo json_encode($_SESSION["ctc"]["servicio"]); ?>');
		$(".addPlan").each(function(index, value) {
			if(info_plan.id_plan == $(this).attr("data-target")) {
				$(this).addClass("active").html('<i class="fa fa-check"></i> Seleccionado');
			}
		});
		if(info_serv.id < 4) {
			$(".addService").each(function(index, value) {
				if(info_serv.id_servicio == $(this).attr("data-target")) {
					$(this).addClass("active").html('<i class="fa fa-check"></i> Seleccionado');
				}
			});
		}
		function execute_my_onreturn (json) {
			if (json.collection_status=='approved'){
				alert ('Pago acreditado');
				
				$.ajax({
					type: 'POST',
					url: 'ajax/pay.php',
					data: 'op=2&plan=' + plan + '&serv=' + serv + '&transaction=' + JSON.stringify(json),
					dataType: 'json',
					success: function(data) {
						console.log(data);
						window.location.assign("planes.php");
					}
				});
				
			} else if(json.collection_status=='pending'){
				alert ('El usuario no completó el pago');
			} else if(json.collection_status=='in_process'){    
				alert ('El pago está siendo revisado');    
			} else if(json.collection_status=='rejected'){
				alert ('El pago fué rechazado, el usuario puede intentar nuevamente el pago');
			} else if(json.collection_status==null){
				alert ('El usuario no completó el proceso de pago, no se ha generado ningún pago');
			}
		}

		var plan = info_plan.id_plan;
		var serv = info_serv.id_servicio;
		
		$(".addPlan").click(function() {
			$(".addPlan").html('Seleccionar');
			$(this).addClass("active").html('<i class="fa fa-check"></i> Seleccionado');
			plan = $(this).attr("data-target");
		});

		$(".addService").click(function() {
			$(".addService").html('Agregar');
			if($(this).hasClass("active")) {
				$(this).removeClass("active").html('Agregar');
				serv = 0;
			}
			else {
				$(this).addClass("active").html('<i class="fa fa-check"></i> Seleccionado');
				serv = $(this).attr("data-target");
			}
		});
		
		$("#continue").click(function() {
			swal({
				title: 'Información!',
				text: 'Su plan ya es gratis.',
				timer: 2000,
				confirmButtonClass: 'btn btn-primary btn-lg',
				buttonsStyling: false
			});
		});
		
		$("#updatePlan").click(function() {
			var band = false;
			if($(".addPlan").hasClass("active")) {
				band = true;
			}
			if(band) {
				$("#step1").css("display", "none");
				$("#step2").css("display", "block");
				
				$(".preloader").css("display", "block");
				
				if(parseInt(plan) != 1) {
					$("#containerFree").css("display", "none");
					$("#containerPay").css("display", "block");
					
					$.ajax({
						type: 'POST',
						url: 'ajax/pay.php',
						data: 'op=1&email=' + $("#email").val() + '&plan=' + plan,
						dataType: 'json',
						success: function(data) {
							console.log(data);
							// $("#payMP").attr("data-v", data.data.response.init_point);
							$("#payMP").attr("data-v", data.data.response.sandbox_init_point);
							var html = '';
							var total = 0;
							html += '<li class="list-group-item b-l-0 b-r-0 text-muted">Tipo: <strong>'+data.servicios.nombre+'</strong></li><li class="list-group-item b-l-0 b-r-0 text-muted">Precio: <strong>'+data.servicios.precio+'</strong></li>';
							total += parseFloat(data.servicios.precio);
							if(parseInt(data.servicios.wserv) == 1) {
								html += '<li class="list-group-item b-l-0 b-r-0 text-muted">Servicio: <strong>'+data.servicios.serv.nombre+'</strong></li><li class="list-group-item b-l-0 b-r-0 text-muted">Precio: <strong>'+data.servicios.serv.precio+'</strong></li>';
								total += parseFloat(data.servicios.serv.precio);
							}
							var impuesto = parseFloat(data.iva);
							html += '<li class="list-group-item b-l-0 b-r-0 text-muted">Impuesto: '+(impuesto * 100)+'% <strong>'+(total * impuesto)+'</strong></li>';
							html += '<li class="list-group-item b-l-0 b-r-0 text-muted">Total: <strong>'+(total + (total * impuesto))+'</strong></li>';
							//html += '<li class="list-group-item b-l-0 b-r-0 text-muted">Total: <strong>'+total+'</strong></li>';
							$("#listServices").html(html);

							$("#services").css("display", "block");

							$(".preloader").css("display", "none");

							$("#payMP").click(function() {
								$MPC.openCheckout ({
									url: $("#payMP").attr("data-v"),
									mode: "modal",
									onreturn: function(data) {
										console.log(data);
										execute_my_onreturn(data);
									}
								});
							});
						}
					});
				}
				else {
					$("#containerFree").css("display", "block");
					$("#containerPay").css("display", "none");
					$(".preloader").css("display", "none");
				}
			}
			else {
				swal({
					title: 'Información!',
					text: 'Debe seleccionar un plan para continuar.',
					timer: 2000,
					confirmButtonClass: 'btn btn-primary btn-lg',
					buttonsStyling: false
				});
			}
		});
		
	</script>
</body>

</html>