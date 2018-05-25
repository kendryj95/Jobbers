	<?php
	session_start();

	if(isset($_SESSION["ctc"])) {
		if (isset($_SESSION["ctc"]["empresa"])) {
			header('Location: ./');
		} else {
			header('Location: ../');
		}
	}
	require_once('../classes/DatabasePDOInstance.function.php');

	$db = DatabasePDOInstance();

	$planes = $db->getAll("SELECT * FROM planes WHERE id != 1");
	$beneficios_planes = $db->getAll("SELECT pb.alias_gratis, pb.alias_bronce, pb.alias_plata, pb.alias_oro, GROUP_CONCAT(id_plan ORDER BY id_plan ASC SEPARATOR ',') AS planes_asignados FROM planes_beneficios pb INNER JOIN beneficios_per_plan bpp ON pb.id=bpp.id_beneficio GROUP BY id_beneficio");
	$servicios = $db->getAll("SELECT * FROM servicios WHERE id != 4");
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
		<title>JOBBERS - Registra tu empresa</title>

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
		<style>
			.form-control {
				border: 1px solid rgba(0,0,0,.15) !important;
			}
			/* .card {
				border-radius: 0px;
			} */
			.has-error {
 				box-shadow: -1px 1px 10px 0px rgba(255,51,51,.7);
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
	<body class="auth-bg">
		
		<div class="auth">
			<div class="auth-header">
				<a href=".././"><img src="img/logo_d.png" alt="" style="width: 300px;"></a>
				<h6>Bienvenido! Registra tu empresa</h6>
			</div>
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-2"></div>
					<div class="col-md-8">
						<div class="box bg-white steps">
							<div class="box-block">
								<div class="s-numbers">
									<div class="row">
										<div class="col-xs-4">
											<div class="s-number active" id="stp1">
												<span class="sn-icon" id="st1">1</span>
												<div class="sn-text">Información</div>
											</div>
										</div>
										<div class="col-xs-4">
											<div class="s-number text-xs-center" id="stp2">
												<span class="sn-icon" id="st2">2</span>
												<div class="sn-text">Plan</div>
											</div>
										</div>
										<div class="col-xs-4">
											<div class="s-number text-xs-right" id="stp3">
												<span class="sn-icon" id="st3">3</span>
												<div class="sn-text">Finalizar</div>
											</div>
										</div>
									</div>
								</div>
								<div id="step1">
									<div class="row">
										<div class="col-md-2"></div>
										<div class="col-md-8">
											<div class="form-group">
												<div class="input-group">
													<input type="text" class="form-control" id="email" placeholder="Correo electrónico (*)" onchange="validar(this.id,'email')">
												</div>
											</div>
											<div class="form-group">
												<div class="input-group">
													<input type="text" class="form-control" id="email2" placeholder="Confirmar correo electrónico (*)" onchange="validar(this.id,'email')">
												</div>
											</div>
											<div class="form-group">
												<div class="input-group">
													<input type="password" class="form-control" id="passw" placeholder="Contraseña (*)">
												</div>
											</div>
											<div class="form-group">
												<div class="input-group">
													
													<input type="password" class="form-control" id="passw2" placeholder="Confirmar contraseña (*)">
												</div>
											</div>
											<div class="form-group">
												<div class="input-group">
												<input type="text" class="form-control" id="name" placeholder="Nombre responsable (*)"  onchange="validar(this.id,'texto',this.title)" title='Nombre'>
												</div>
											</div>	
											<div class="form-group">
												<div class="input-group">
												<input type="text" class="form-control" id="lastName" placeholder="Apellido responsable (*)"  onchange="validar(this.id,'texto',this.title)" title='Apellido'>
												</div>
											</div>	
											<div class="form-group">
												<div class="input-group">
												<input type="text" class="form-control" id="empresa" placeholder="Nombre de la empresa (*)">
												</div>
											</div>	
											<div class="form-group">
												<div class="input-group">
												<input type="text" class="form-control" id="razon" placeholder="Razón social (*)">
												</div>
											</div>	
											<div class="form-group">
												<div class="input-group">
												<input type="text" class="form-control" id="cuit" placeholder="CUIT (opcional)"   onchange="validar(this.id,'num',this.title)" title='CUIT'>
												</div>
											</div>		
											<div class="form-group">
												<div class="input-group">
												<input type="text" class="form-control" id="phone" placeholder="Teléfono (*)"   onchange="validar(this.id,'tel',this.title)" title='Numero Telefónico'>
												</div>
											</div>
											<label class="custom-control custom-checkbox text-muted">
												<input class="custom-control-input" type="checkbox" id="term">
												<span class="custom-control-indicator"></span>
												<span class="custom-control-description">Acepto <a href="#" data-toggle="modal" data-target=".large-modal">términos, condiciones</a> y <a href="#" data-toggle="modal" data-target=".large-modal2">políticas de privacidad.</a></span>
											</label>
										</div>
										<div class="col-md-2"></div>
									</div>
								</div>

								<div id="step2" style="display: none;">
									<h4 class="text-muted">Planes</h4>
									<div class="row">
										<div class="col-md-6" style="margin-bottom: 20px;">
											<div class="card price-card" style="border-radius: 0px; border: none;">
												<div class="card-header price-card-header  bg-primary text-xs-center header-free" style="width: 100%;height: 99px;">
													<h4 class="text-uppercase">Gratis</h4>
													<h3 class="m-b-0 h3-price">
														<sup>$</sup>
														<span class="text-big">0</span>
														<span class="text-small">/ 1 mes</span>
													</h3>
												</div>
												<ul class="price-card-list p-l-0 price-list-free">
													<?php foreach ($beneficios_planes as $ben): ?>
															<li>
																<?= strstr($ben['planes_asignados'], "1") ? '<i class="fa fa-check text-success m-r-0-25"></i>' : '<i class="fa fa-remove text-danger m-r-0-25"></i>' ?> <span class="text-price"><?= $ben['alias_gratis'] ?></span>
															</li>
													<?php endforeach ?>
												</ul>
												<div class="footer-free">
													<a href="javascript:void(0)" class="btn btn-block btn-lg addPlan" style="color:#fff; font-size: 30px;" data-target="1">Seleccionar</a>
												</div>
											</div>
										</div>
										<div class="col-md-6" style="margin-bottom: 20px;">
											<div class="card price-card" style="border-radius: 0px; border: none;">
												<div class="card-header price-card-header bg-primary text-xs-center header-bronce" style="width: 100%;height: 99px;">
													<h4 class="text-uppercase">Bronce</h4>
													<h3 class="m-b-0 h3-price">
														<sup>$</sup>
														<span class="text-big"><?= $planes[0]['precio'] ?></span>
														<span class="text-small">/ 1 mes</span>
													</h3>
												</div>
												<ul class="price-card-list p-l-0 price-list-bronce">
													<?php foreach ($beneficios_planes as $ben): ?>
															<li>
																<?= strstr($ben['planes_asignados'], "2") ? '<i class="fa fa-check text-success m-r-0-25"></i>' : '<i class="fa fa-remove text-danger m-r-0-25"></i>' ?> <span class="text-price"><?= $ben['alias_bronce'] ?></span>
															</li>
													<?php endforeach ?>
												</ul>
												<div class="footer-bronce">
													<a href="javascript:void(0)" class="btn btn-block btn-lg addPlan" style="color:#fff; font-size: 30px;" data-target="2">Seleccionar</a>
												</div>
											</div>
										</div>
										<div class="col-md-6" style="margin-bottom: 20px;">
											<div class="card price-card" style="border-radius: 0px; border: none;">
												<div class="card-header price-card-header bg-primary text-xs-center header-silver" style="width: 100%;height: 99px;">
													<h4 class="text-uppercase">Plata</h4>
													<h3 class="m-b-0 h3-price">
														<sup>$</sup>
														<span class="text-big"><?= $planes[1]['precio'] ?></span>
														<span class="text-small">/ 1 mes</span>
													</h3>
												</div>
												<ul class="price-card-list p-l-0 price-list-silver">
													<?php foreach ($beneficios_planes as $ben): ?>
															<li>
																<?= strstr($ben['planes_asignados'], "3") ? '<i class="fa fa-check text-success m-r-0-25"></i>' : '<i class="fa fa-remove text-danger m-r-0-25"></i>' ?> <span class="text-price"><?= $ben['alias_plata'] ?></span>
															</li>
													<?php endforeach ?>
												</ul>
												<div class="footer-silver">
													<a href="javascript:void(0)" class="btn btn-block btn-lg addPlan" style="color:#fff; font-size: 30px;" data-target="3">Seleccionar</a>
												</div>
											</div>
										</div>
										<div class="col-md-6" style="margin-bottom: 20px;">
											<div class="card price-card" style="border-radius: 0px; border: none;">
												<div class="card-header price-card-header bg-primary text-xs-center header-gold" style="width: 100%;height: 99px;">
													<h4 class="text-uppercase">Oro</h4>
													<h3 class="m-b-0 h3-price">
														<sup>$</sup>
														<span class="text-big"><?= $planes[2]['precio'] ?></span>
														<span class="text-small">/ 1 mes</span>
													</h3>
												</div>
												<ul class="price-card-list p-l-0 price-list-gold">
													<?php foreach ($beneficios_planes as $ben): ?>
															<li>
																<?= strstr($ben['planes_asignados'], "4") ? '<i class="fa fa-check text-success m-r-0-25"></i>' : '<i class="fa fa-remove text-danger m-r-0-25"></i>' ?> <span class="text-price"><?= $ben['alias_oro'] ?></span>
															</li>
													<?php endforeach ?>
												</ul>
												<div class="footer-gold">
													<a href="javascript:void(0)" class="btn btn-block btn-lg addPlan" style="color:#fff; font-size: 30px;" data-target="4">Seleccionar</a>
												</div>
											</div>
										</div>
									</div>
									
								</div>
								<div id="step3" style="display: none;">
									<div class="row" style="margin-top: 25px;">
										<div class="col-md-2"></div>
										<div class="col-md-8">
											
										<div class="content-loader">
											<div class="preloader"></div>
										</div>
											
											<div id="containerFree">
												<h4 class="text-muted">Datos del plan</h4>
												<ul class="list-group list-group-flush" style="border-left: 1px solid lightgrey; border-right: 1px solid lightgrey">
													<li class="list-group-item b-l-0 b-r-0 text-muted">Tipo: <strong>Gratis</strong></li>
													<li class="list-group-item b-l-0 b-r-0 text-muted">Precio: 0$</li>
													<li class="list-group-item b-l-0 b-r-0 text-muted">Valido por: 1 mes</li>
												</ul>
											</div>
											
											<div class="row m-b-2" id="containerPay" style="display: none;">
												<div class="col-sm-2"></div>
												<div class="col-sm-8">
													<div class="c-inputs-stacked">
														<div id="services" style="display: none;">
															<h4 class="text-muted">Datos del servicio</h4>
															<ul class="list-group list-group-flush" id="listServices"></ul>
														</div>
														<div style="text-align: center;"><a href="javascript:void(0)" id="payMP" name="MP-Checkout" class="btn btn-primary" style="margin-bottom: 15px;margin-top: 15px;"><i class="ti-money"></i> Realizar pago</a></div>
														<div style="text-align: center;"><img src="../img/mercadopago-formas-de-pago.png"></div>
													</div>
												</div>
												<div class="col-sm-2"></div>
											</div>
											
										</div>
										<div class="col-md-2"></div>
									</div>
								</div>

								<div class="clearfix" style="margin-top: 40px;">
									<button type="button" class="btn btn-outline-primary label-left pull-xs-left" id="back" data-value="1"><span class="btn-label-left"><i class="ti-angle-left"></i></span>Anterior</button>
									<button type="button" class="btn btn-outline-primary label-right pull-xs-right" id="next" data-value="1">Siguiente <span class="btn-label"><i class="ti-angle-right"></i></span></button>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-2"></div>
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
		<script type="text/javascript" src="../vendor/jquery/jquery-1.12.3.min.js"></script>
		<script type="text/javascript" src="../vendor/tether/js/tether.min.js"></script>
		<script type="text/javascript" src="../vendor/bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="../vendor/sweetalert2/sweetalert2.min.js"></script>
		<script type="text/javascript" src="../js/validar.js"></script>
		
		
		<!-- <script type="text/javascript" src="//resources.mlstatic.com/mptools/render.js"></script> -->

		<script type="text/javascript">
		(function(){function $MPC_load(){window.$MPC_loaded !== true && (function(){var s = document.createElement("script");s.type = "text/javascript";s.async = true;s.src = document.location.protocol+"//secure.mlstatic.com/mptools/render.js";var x = document.getElementsByTagName('script')[0];x.parentNode.insertBefore(s, x);window.$MPC_loaded = true;})();}window.$MPC_loaded !== true ? (window.attachEvent ?window.attachEvent('onload', $MPC_load) : window.addEventListener('load', $MPC_load, false)) : null;})();
		</script>
		
		<script>
			
			var plan = 0;
			var serv = 0;
			
			function execute_my_onreturn (json) {
				if (json.collection_status=='approved'){

					swal({
					  position: 'center',
					  type: 'success',
					  title: 'Pago Acreditado',
					  showConfirmButton: false,
					  timer: 1500
					});
					
					setTimeout(function(){
						registrarEmpresa(JSON.stringify(json));
					}, 3000);

					
					
				} else if(json.collection_status=='pending'){
					swal("No completado", "El usuario no completó el proceso de pago, no se ha generado ningún pago", "warning");
					$("#next").attr("disabled", false);
					plan = 1;
				} else if(json.collection_status=='in_process'){    
					swal("En revisión", "El pago está siendo revisado. Se le notificará cuando la transacción se complete.", "info");
					$("#next").attr("disabled", false);
					plan = 1;
				} else if(json.collection_status=='rejected'){
					swal("Rechazado", "El pago fué rechazado, el usuario puede intentar nuevamente el pago", "error");
					$("#next").attr("disabled", false);
					plan = 1;
				} else if(json.collection_status==null){
					swal("No completado", "El usuario no completó el proceso de pago, no se ha generado ningún pago", "warning");
					$("#next").attr("disabled", false);
					plan = 1;
				}
			}
			
			$(".addPlan").click(function() {
				$(".addPlan").html('Seleccionar');
				$(this).addClass("active").html('<i class="fa fa-check"></i> Seleccionado');
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
			
			$("#back").click(function() {
				if(parseInt($(this).attr("data-value")) == 2) {
					$("#back").attr("data-value", 1);
					$("#back").css("display", "none");
					
					$("#step1").css("display", "block");
					$("#step2").css("display", "none");
					$("#stp1").addClass("active").removeClass("complete").removeClass("text-xs-center");
					$("#stp2").removeClass("active").removeClass("complete").removeClass("text-xs-center");
					$("#st1").html('1');
					$("#st2").html('2');
					$("#next").attr("data-value", 1);
				}
				else {
					$("#back").attr("data-value", 2);
					$("#step2").css("display", "block");
					$("#step3").css("display", "none");
					$("#stp2").addClass("active").removeClass("complete");
					$("#stp3").removeClass("active").removeClass("complete").removeClass("text-xs-center");
					$("#st2").html('2');
					$("#st3").html('3');
					$("#next").attr("data-value", 2);
					$("#next").html('Siguiente <span class="btn-label"><i class="ti-angle-right"></i></span>');
				}
			});
			
			$("#next").click(function() {
				switch(parseInt($(this).attr("data-value"))) {
					case 1:
						$('*').removeClass('has-error'); // Si hay elementos con la clase has-error, se los quita inicialmente.
						if (isEmail($("#email").val())) {
							if($("#email").val() != "" && $("#passw").val() != "" && $("#name").val() != "" && $("#lastName").val() != "" && $("#empresa").val() != "" && $("#razon").val() != "" && $("#phone").val() != "") {
								if ($('#email').val() == $('#email2').val()) { // confimar si los correos electronicos coinciden
									if($("#passw").val() == $("#passw2").val()) { // Confirma si las contraseñas coinciden
										if(($("#passw").val().length >= 8 && $("#passw").val().length <= 12)&&($("#passw2").val().length >= 8 && $("#passw2").val().length <= 12  )) { // Confirma si las contraseñas tienen la lomgitud
											if($("#term:checked").length > 0) {
												$.ajax({
													type: 'POST',
													url: 'ajax/empresas.php',
													data: 'op=2&email=' + $("#email").val(),
													dataType: 'json',
													success: function(data) {
														if(data.status == 1) {
															$("#step1").css("display", "none");
															$("#step2").css("display", "block");
															$("#stp1").removeClass("active").addClass("complete").addClass("text-xs-center");
															$("#st1").html('<i class="ti-check"></i>');
															$("#stp2").addClass("active");
															$("#next").attr("data-value", 2);
															$("#back").attr("data-value", 2);
															$("#back").css("display", "block");
														}else {
															swal({
																title: 'Información!',
																text: 'El correo electrónico ingresado ya se encuentra en uso.',
																timer: 3000,
																confirmButtonClass: 'btn btn-primary btn-lg',
																buttonsStyling: false
															});
														}
													}
												});
											}else {
												swal({
													title: 'Información!',
													text: 'Para continuar debe estar de acuerdo y aceptar los terminos, condiciones y políticas de privacidad.',
													timer: 3000,
													confirmButtonClass: 'btn btn-primary btn-lg',
													buttonsStyling: false
												});
											}
										}else{
											swal({
												title: 'Información!',
												text: 'La contraseña debe tener una logintud de 8 a 12 caracteres',
												timer: 4000,
												confirmButtonClass: 'btn btn-primary btn-lg',
												buttonsStyling: false
											});
											$('#passw, #passw2').parent().addClass('has-error');
										}
									}else{
										swal({
												title: 'Información!',
												text: 'Las contraseñas no coinciden',
												timer: 2000,
												confirmButtonClass: 'btn btn-primary btn-lg',
												buttonsStyling: false
										});
										$('#passw, #passw2').parent().addClass('has-error');	
									}
								} else {
									swal({
											title: 'Información!',
											text: 'Los correos electronicos no coinciden',
											timer: 2000,
											confirmButtonClass: 'btn btn-primary btn-lg',
											buttonsStyling: false
									});
									$('#email, #email2').parent().addClass('has-error');
								}
							}else {
								swal({
									title: 'Información!',
									text: 'Los campos con (*) son obligatorios.',
									timer: 2000,
									confirmButtonClass: 'btn btn-primary btn-lg',
									buttonsStyling: false
								});
							}
						} else {
							swal({
								title: 'Información!',
								text: 'Correo electrónico inválido',
								timer: 2000,
								confirmButtonClass: 'btn btn-primary btn-lg',
								buttonsStyling: false
							});
						}
						
						break;
					case 2:
						var band = false;
						$(".addPlan").each(function(index, value) {
							if($(this).hasClass("active")) {
								band = true;
								plan = $(this).attr("data-target");
							}
						});
						$(".addService").each(function(index, value) {
							if($(this).hasClass("active")) {
								serv = $(this).attr("data-target");
							}
						});
						if(band) {
							$("#step2").css("display", "none");
							$("#step3").css("display", "block");
							$("#stp2").removeClass("active").addClass("complete").addClass("text-xs-center");
							$("#st2").html('<i class="ti-check"></i>');
							$("#stp3").addClass("active");
							$("#next").attr("data-value", 3);
							$("#next").html('Finalizar <span class="btn-label"><i class="ti-angle-right"></i></span>');
							$("#back").attr("data-value", 3);
							
							if(parseInt(plan) != 1) {
								$("#containerFree").css("display", "none");
								$("#containerPay").css("display", "block");
								
								$("#next").attr("disabled", true);
								
								$.ajax({
									type: 'POST',
									url: 'ajax/pay.php',
									data: 'op=1&email=' + $("#email").val() + '&plan=' + plan + '&serv=' + serv,
									dataType: 'json',
									success: function(data) {
										console.log(data);
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
													
													//$("#next").attr("disabled", false);
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
								text: 'Debe escoger algún plan para continuar.',
								timer: 2000,
								confirmButtonClass: 'btn btn-primary btn-lg',
								buttonsStyling: false
							});
						}
						break;
					case 3:
						registrarEmpresa();
						break;
				}
			});

	function isEmail(email) {
	  var regex = /^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/;
	  return regex.test(email);
	}

	function registrarEmpresa(transaction=null){
		$.ajax({
			type: 'POST',
			url: 'ajax/empresas.php',
			data: 'op=3&email=' + $("#email").val() + '&password=' + $("#passw").val() + '&name=' + $("#name").val() + '&lastName=' + $("#lastName").val() + '&company=' + $("#empresa").val() + '&razon=' + $("#razon").val() + '&phone=' + $('#phone').val() + '&term=1&plan=' + plan + '&serv=' + serv + '&transaction='+transaction+'&cuit=' + $('#cuit').val(),
			dataType: 'json',
			success: function(data) {
				if(data.msg == "OK") {
					swal("EXITO!", "Registrado Satisfactoriamente...", "success");
					setTimeout(function(){
						window.location.assign("./");
					},3000);
				} else {
					swal({
								title: 'Información!',
								text: 'El correo electrónico ingresado ya se encuentra en uso.',
								timer: 3000,
								confirmButtonClass: 'btn btn-primary btn-lg',
								buttonsStyling: false
					});
				}
			}
		});
	}


		</script>
	</body>
</html>