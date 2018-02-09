<?php
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
	$planes = $db->getAll("SELECT * FROM planes");
	$servicios = $db->getAll("SELECT * FROM servicios");
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
		<title>JOBBERS - Empresas</title>
		<?php require_once('../includes/libs-css.php'); ?>

		<link rel="stylesheet" href="../vendor/DataTables/css/dataTables.bootstrap4.min.css">
		<link rel="stylesheet" href="../vendor/DataTables/Responsive/css/responsive.bootstrap4.min.css">
		<link rel="stylesheet" href="../vendor/DataTables/Buttons/css/buttons.dataTables.min.css">
		<link rel="stylesheet" href="../vendor/DataTables/Buttons/css/buttons.bootstrap4.min.css">
		
		<link rel="stylesheet" href="../vendor/select2/dist/css/select2.min.css">
		<link rel="stylesheet" href="../vendor/dropify/dist/css/dropify.min.css">
		<style>
			th.dt-center, td.dt-center { text-align: center; }
			
			.swal2-modal {
				border: 1px solid rgb(223, 223, 223);
			}
			
			#tablaPublicaciones {
				width: 100% !important;
			}
			.color-link{
				color: #fff !important;
			}
		</style>
	</head>

	<body class="large-sidebar fixed-sidebar fixed-header skin-5">
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
			<?php require_once('../includes/sidebar.php'); ?>
				<!-- Content -->
				<div class="col-md-9">
					<div class="content-area p-y-1">
						<div class="card card-block">
							<div class="box box-block bg-white">
								<h5 class="m-b-1">Empresas</h5>
								<div class="table-responsive">
									<table class="table table-striped table-bordered dt-responsive nowrap dataTable" id="tablaPublicaciones" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th>#</th>
												<th>Nombre</th>
												<th>Plan</th>
												<th>Plan</th>
												<th>Email</th>
												<th>Contraseña de Acceso</th>
												<th>Fecha de creación</th>
												<th>Acciones</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- Footer -->
				<?php require_once('../includes/footer.php'); ?>
			</div>
		</div>
		
		<div id="modal-modificar-publicacion" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h4 class="modal-title">Modificar plan de empresa</h4>
					</div>
					<div class="modal-body">
						<h6>Plan actual</h6>
						<p id="textplan"></p>
						<h6>Servicio actual</h6>
						<p id="textservice"></p>
						<form method="POST" id="upload2">
							<h6 class="m-t-2">Planes</h6>
							<?php foreach($planes as $p): ?>
								<label class="custom-control custom-radio">
									<input name="planes" class="custom-control-input" type="radio" value="<?php echo $p["id"]; ?>">
									<span class="custom-control-indicator"></span>
									<span class="custom-control-description"><?php echo $p["nombre"]; ?></span>
								</label>
							<?php endforeach ?>
							<h6 class="m-t-2">Servicios</h6>
							<?php foreach($servicios as $s): ?>
								<label class="custom-control custom-radio">
									<input name="servicios" class="custom-control-input" type="radio" value="<?php echo $s["id"]; ?>">
									<span class="custom-control-indicator"></span>
									<span class="custom-control-description"><?php echo $s["nombre"]; ?></span>
								</label>
							<?php endforeach ?>
						</form>
						<br>
						<p style="color:red;">Atencion: la activación de este plan solo tendrá la duración de un mes, luego de eso la empresa debe cancelar la mesualidad correspondiente a su plan, de lo contrario regresará al plan "Gratis".</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" id="modal-modificar-publicacion-enviar-form">Aceptar</button>
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
					</div>
				</div>
			</div>
		</div>

		<?php require_once('../includes/libs-js.php'); ?>

		<script type="text/javascript" src="../vendor/DataTables/js/jquery.dataTables.min.js"></script>
		<script type="text/javascript" src="../vendor/DataTables/js/dataTables.bootstrap4.min.js"></script>
		<script type="text/javascript" src="../vendor/DataTables/Responsive/js/dataTables.responsive.min.js"></script>
		<script type="text/javascript" src="../vendor/DataTables/Responsive/js/responsive.bootstrap4.min.js"></script>
		<script type="text/javascript" src="../vendor/DataTables/Buttons/js/dataTables.buttons.min.js"></script>
		<script type="text/javascript" src="../vendor/DataTables/Buttons/js/buttons.bootstrap4.min.js"></script>
		<script type="text/javascript" src="../vendor/DataTables/JSZip/jszip.min.js"></script>
		<script type="text/javascript" src="../vendor/DataTables/pdfmake/build/pdfmake.min.js"></script>
		<script type="text/javascript" src="../vendor/DataTables/pdfmake/build/vfs_fonts.js"></script>
		<script type="text/javascript" src="../vendor/DataTables/Buttons/js/buttons.html5.min.js"></script>
		<script type="text/javascript" src="../vendor/DataTables/Buttons/js/buttons.print.min.js"></script>
		<script type="text/javascript" src="../vendor/DataTables/Buttons/js/buttons.colVis.min.js"></script>
		
		<script type="text/javascript" src="../vendor/select2/dist/js/select2.min.js"></script>
		

		<script>
			var idNoticia = 0;
			var $tablaPublicaciones='';
			var tablaPublicaciones='';
			$(document).ready(function(){
				var idPub = 0;

				setTimeout(function() {
					$('.preloader').fadeOut();
				}, 500);
				setTimeout(function() {
					$('.content-loader').fadeOut();
				}, 500);
				
				$tablaPublicaciones = jQuery("#tablaPublicaciones");
				tablaPublicaciones = $tablaPublicaciones.DataTable( {
					"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
					"buttons": [
						'copyHtml5',
						'excelHtml5',
						'csvHtml5',
						'pdfHtml5'
					],
					"aoColumnDefs": [
						{ "width": "40px", "targets": 0 },
						{ "visible": false, "targets": 2 },
						{ "width": "150px", "targets": 3 },
						{ "width": "150px", "targets": 4 },
						{ "orderable": false, "targets": 4 },
						{ "className": "dt-center", "targets": [0, 2, 3, 4] }
					  ],
					"language": {
						"decimal":        "",
						"emptyTable":     "Sin registros",
						"info":           "Mostrando de _START_ a _END_ registros de _TOTAL_ en total",
						"infoEmpty":      "Mostrando 0 de 0 de 0 registros",
						"infoFiltered":   "(filtrado desde _MAX_ registros en total)",
						"infoPostFix":    "",
						"thousands":      ",",
						"lengthMenu":     "Mostrar _MENU_ registros",
						"loadingRecords": "Cargando...",
						"processing":     "Procesando...",
						"search":         "Buscar:",
						"zeroRecords":    "No se encontraron registros",
						"paginate": {
							"first":      "Primero",
							"last":       "Último",
							"next":       "Siguiente",
							"previous":   "Anterior"
						},
						"aria": {
							"sortAscending":  ": activar para ordenar la columna ascendente",
							"sortDescending": ": activar para ordenar la columna descendente"
						}
					},
					"ajax": 'ajax/empresas.php?op=1'
				} );
				
				$("#modal-modificar-publicacion-enviar-form").click(function() {
					var id = $("#modal-modificar-publicacion-enviar-form").attr("data-id");
					console.log(id);
					if($("input[type=radio][name=planes]:checked").length > 0 && $("input[type=radio][name=servicios]:checked").length > 0 ) {
						$.ajax({
							url: 'ajax/empresas.php',
							type: 'GET',
							data: 'op=3&plan=' + $("input[type=radio][name=planes]:checked").val() + '&servicio=' + $("input[type=radio][name=servicios]:checked").val() + '&i=' + id,
							dataType: 'json'
						}).done(function(data, textStatus, jqXHR) {						
							switch(jqXHR.status) {
								case 200:
									var json = JSON.parse(jqXHR.responseText);
									if(json.msg == 'OK') {
										$("#modal-modificar-publicacion").modal('hide');
										swal("Operación exitosa!", "Se agregó el plan y el servicio seleccionado.", "success");
									}
									break;
							}
						});
					}
					else {
						swal("Error!", "Faltan algunos campos.", "error");
					}
				});
			});
			
			function modificarEmpresa(btn) {
				var $btn = $(btn);
				var $parent = $btn.closest('.acciones-publicacion');
				idPub = $parent.attr('data-target');
				$("#modal-modificar-publicacion-enviar-form").attr("data-id", idPub);
				$.ajax({
					url: 'ajax/empresas.php',
					type: 'GET',
					data: 'op=2&i=' + idPub,
					dataType: 'json'
				}).done(function(data, textStatus, jqXHR) {						
					switch(jqXHR.status) {
						case 200:
							var json = JSON.parse(jqXHR.responseText);
							if(json.msg == 'OK') {
								var html = '';
								$("#textplan").html(json.data.nombre_plan);
								$("#textservice").html(json.data.nombre_servicio);
								console.log(json);
							}
							break;
					}
				});
				$("#modal-modificar-publicacion").modal('show');
			}
			
			function empresaVerificada(btn) {
				var $btn = $(btn);
				var $parent = $btn.closest('.acciones-publicacion');
				idPub = $parent.attr('data-target');
				
				swal({
				  title: "Advertencia",
				  text: "Está seguro que desea marcar esta empresa como verificada?",
				  type: "info",
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
							url: 'ajax/empresas.php',
							type: 'GET',
							dataType: 'json',
							data: 'op=5&i=' + idPub
						}).done(function(data, textStatus, jqXHR) {
							switch(jqXHR.status) {
								case 200:
									var json = JSON.parse(jqXHR.responseText);
									if(json.msg == 'OK') {
										swal("Operación exitosa!", "Empresa validada como verificada.", "success");
										tablaPublicaciones.ajax.reload();
									}
									break;
							}
						});
					}
				});
			}
			/*function modificarPublicacion(btn) {
				var $btn = $(btn);
				var $parent = $btn.closest('.acciones-publicacion');
				idPub = $parent.attr('data-target');
				$.ajax({
					url: 'ajax/empresas.php',
					type: 'GET',
					data: 'op=2&i=' + idPub,
					dataType: 'json'
				}).done(function(data, textStatus, jqXHR) {						
					switch(jqXHR.status) {
						case 200:
							var json = JSON.parse(jqXHR.responseText);
							if(json.msg == 'OK') {
								var html = '';
								$("#textplan").html(json.data.nombre_plan);
								$("#textservice").html(json.data.nombre_servicio);
								console.log(json);
							}
							break;
					}
				});
				$("#modal-modificar-publicacion").modal('show');
			}*/
			
			function suspenderEmpresa(btn) {
				var $btn = $(btn);
				var $parent = $btn.closest('.acciones-publicacion');
				idPub = $parent.attr('data-target');
				var valSusp = parseInt($btn.attr('data-susp'));
				var suspTexto = valSusp == 0 ? 'suspender' : 'desbloquear';
				
				swal({
				  title: "Advertencia",
				  text: "Está seguro que desea "+suspTexto+" esta empresa?",
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
							url: 'ajax/empresas.php',
							type: 'GET',
							dataType: 'json',
							data: 'op=4&i=' + idPub + '&susp=' + valSusp
						}).done(function(data, textStatus, jqXHR) {
							switch(jqXHR.status) {
								case 200:
									var json = JSON.parse(jqXHR.responseText);
									if(json.msg == 'OK') {
										swal("Operación exitosa!", "Se han aplicado los cambios satisfactoriamente.", "success");
										tablaPublicaciones.ajax.reload();
									}
									break;
							}
						});
					}
				});
			}

			function eliminarEmpresa(btn) {
				var $btn = $(btn);
				var $parent = $btn.closest('.acciones-publicacion');
				idPub = $parent.attr('data-target');
				
				swal({
				  title: "Advertencia",
				  text: "Está seguro que desea eliminar esta empresa?",
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
							url: 'ajax/empresas.php',
							type: 'GET',
							dataType: 'json',
							data: 'op=6&i=' + idPub 
						}).done(function(data, textStatus, jqXHR) {
							switch(jqXHR.status) {
								case 200:
									var json = JSON.parse(jqXHR.responseText);
									if(json.msg == 'OK') {
										swal("Operación exitosa!", "Se eliminó la empresa y sus datos.", "success");
										tablaPublicaciones.ajax.reload();
									}
									break;
							}
						});
					}
				});
			}
		</script>

	</body>

</html>