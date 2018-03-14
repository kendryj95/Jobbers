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

	$planes = $db->getAll("SELECT * FROM planes WHERE id != 1");
	$beneficios_planes = $db->getAll("SELECT pb.alias_gratis, pb.alias_bronce, pb.alias_plata, pb.alias_oro, GROUP_CONCAT(id_plan ORDER BY id_plan ASC SEPARATOR ',') AS planes_asignados FROM planes_beneficios pb INNER JOIN beneficios_per_plan bpp ON pb.id=bpp.id_beneficio GROUP BY id_beneficio");
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

	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	<script>
	  (adsbygoogle = window.adsbygoogle || []).push({
	    google_ad_client: "ca-pub-1968505410020323",
	    enable_page_level_ads: true
	  });
	</script>
</head>

<body class="large-sidebar fixed-sidebar fixed-header">
	<div class="wrapper">

		<!-- Preloader -->
		<div class="content-loader">
			<div class="preloader"></div>
		</div>

		<!-- Sidebar second -->
		<?php require_once('../includes/sidebar-second.php'); ?>

		<!-- Header -->
		<?php require_once('../includes/header.php'); ?>

		<div class="site-content" style="margin-left: 0px;">
			<!-- Content -->
			<div class="container-fluid">
			<?php if ($_SESSION['ctc']['type'] == 1):
					$grid = "col-md-9";
					require_once('../includes/sidebar.php');
					else:
					$grid = "container";
				?>
				<?php endif ?>
				<div class="<?php echo $grid ?>">
					<div id="step1">
						<h2>Planes</h2>
						<div class="row row-md">
							<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12" style="margin-bottom: 20px;">
								<div class="card price-card">
									<div class="card-header price-card-header  bg-primary text-xs-center header-free" style="width: 100%;height: 99px;">
										<h4 class="text-uppercase h4-price">Gratis</h4>
										<h3 class="m-b-0 h3-price">
											<sup>$</sup>
											<span class="text-big">0</span>
											<span class="text-small">/ 1 mes</span>
										</h3>
									</div>
									<ul class="price-card-list p-l-0 m-b-0 price-list-free">
										<?php foreach ($beneficios_planes as $ben): ?>
												<li>
													<?= strstr($ben['planes_asignados'], "1") ? '<i class="fa fa-check text-success m-r-0-25"></i>' : '<i class="fa fa-remove text-danger m-r-0-25"></i>' ?> <span class="text-price"><?= $ben['alias_gratis'] ?></span>
												</li>
										<?php endforeach ?>
									</ul>
									<div class="card-footer footer-free">
										<a href="javascript:void(0)" class="btn btn-block btn-lg addPlan btn-selection" data-target="1">Seleccionar</a>
									</div>
								</div>
							</div>
							<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12" style="margin-bottom: 20px;">
								<div class="card price-card">
									<div class="card-header price-card-header bg-primary text-xs-center header-bronce" style="width: 100%;height: 99px;">
										<h4 class="text-uppercase h4-price">Bronce</h4>
										<h3 class="m-b-0 h3-price">
											<sup>$</sup>
											<span class="text-big" ><?php echo $planes[0]["precio"]; ?></span>
											<span class="text-small">/ mes</span>
										</h3>
									</div>
									<ul class="price-card-list p-l-0 m-b-0 price-list-bronce">
										<?php foreach ($beneficios_planes as $ben): ?>
												<li>
													<?= strstr($ben['planes_asignados'], "2") ? '<i class="fa fa-check text-success m-r-0-25"></i>' : '<i class="fa fa-remove text-danger m-r-0-25"></i>' ?> <span class="text-price"><?= $ben['alias_bronce'] ?></span>
												</li>
										<?php endforeach ?>
									</ul>
									<div class="card-footer footer-bronce">
										<a href="javascript:void(0)" class="btn btn-block btn-lg addPlan btn-selection" data-target="2">Seleccionar</a>
									</div>
								</div>
							</div>
							<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12" style="margin-bottom: 20px;">
								<div class="card price-card">
									<div class="card-header price-card-header bg-primary text-xs-center header-silver" style="width: 100%;height: 99px;">
										<h4 class="text-uppercase h4-price">Plata</h4>
										<h3 class="m-b-0 h3-price">
											<sup>$</sup>
											<span class="text-big" ><?php echo $planes[1]["precio"]; ?></span>
											<span class="text-small">/ mes</span>
										</h3>
									</div>
									<ul class="price-card-list p-l-0 m-b-0 price-list-silver">
										
										<?php foreach ($beneficios_planes as $ben): ?>
												<li>
													<?= strstr($ben['planes_asignados'], "3") ? '<i class="fa fa-check text-success m-r-0-25"></i>' : '<i class="fa fa-remove text-danger m-r-0-25"></i>' ?> <span class="text-price"><?= $ben['alias_plata'] ?></span>
												</li>
										<?php endforeach ?>
									</ul>
									<div class="card-footer footer-silver">
										<a href="javascript:void(0)" class="btn btn-block btn-lg addPlan btn-selection" data-target="3">Seleccionar</a>
									</div>
								</div>
							</div>
							<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12" style="margin-bottom: 20px;">
								<div class="card price-card">
									<div class="card-header price-card-header bg-primary text-xs-center header-gold" style="width: 100%;height: 99px;">
										<h4 class="text-uppercase h4-price">Oro</h4>
										<h3 class="m-b-0 h3-price">
											<sup>$</sup>
											<span class="text-big" ><?php echo $planes[2]["precio"]; ?></span>
											<span class="text-small">/ mes</span>
										</h3>
									</div>
									<ul class="price-card-list p-l-0 m-b-0 price-list-gold">
										<?php foreach ($beneficios_planes as $ben): ?>
												<li>
													<?= strstr($ben['planes_asignados'], "4") ? '<i class="fa fa-check text-success m-r-0-25"></i>' : '<i class="fa fa-remove text-danger m-r-0-25"></i>' ?> <span class="text-price"><?= $ben['alias_oro'] ?></span>
												</li>
										<?php endforeach ?>
									</ul>
									<div class="card-footer footer-gold">
										<a href="javascript:void(0)" class="btn btn-block btn-lg addPlan btn-selection" data-target="4">Seleccionar</a>
									</div>
								</div>
							</div>
						</div>
							<div class="col-md-3 col-md-offset-5">
								<div class="card price-card btn-actualizar" style="margin-top: 50px; margin-bottom: 50px;">
									<a href="javascript:void(0)" id="updatePlan" class="btn btn-block btn-lg" style="color: #fff; font-size:26px;">Actualizar</a>
								</div>
							</div>
						</div>
					</div>
					<div class="row" id="step2" style="display: none;">
						<div class="col-md-8">
						<div class="content-loader">
							<div class="preloader"></div>
						</div>
							<div class="card card-block">
								<h3 class="col-md-8 col-md-offset-2" style="padding-left: 0px;">Información para el pago</h3>
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
									<div class="col-md-8 col-md-offset-2">
										<div class="c-inputs-stacked">
											<div id="services" style="display: none;">
												<h4 class="text-muted">Datos del servicio</h4>
												<ul class="list-group list-group-flush" id="listServices"></ul>
											</div>
											<div style="text-align: center;"><a href="" id="payMP" name="MP-Checkout" class="btn btn-primary" style="margin-bottom: 15px;margin-top: 15px;"><i class="ti-money"></i> Realizar pago</a></div>
											<div style="text-align: center;"><img src="../img/mercadopago-formas-de-pago.png"></div>
										</div>
									</div>
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

				$(".content-loader").css("display", "none");
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
							$("#payMP").attr("data-v", data.data.response.init_point);
							//$("#payMP").attr("data-v", data.data.response.sandbox_init_point);
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

							$(".content-loader").css("display", "none");
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
					$(".content-loader").css("display", "none");
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