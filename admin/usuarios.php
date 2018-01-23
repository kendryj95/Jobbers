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
		<title>JOBBERS - Usuarios</title>
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
						<div class="card card-block">
							<div class="container-fluid">
								<div class="box box-block bg-white">
									<h5 class="m-b-1">Mis usuarios</h5>
									<div class="m-b-1">
										<a href="#" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#modal-agregar-categoria"><span class="ti-plus"></span> Agregar</a>
									</div>
									<table class="table table-striped table-bordered dataTable" id="tablaCategorias">
										<thead>
											<tr>
												<th>#</th>
												<th>Nombre</th>
												<th>Correo electrónico</th>
												<th>Correo electrónico</th>
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
		
		<div id="modal-agregar-categoria" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h4 class="modal-title">Agregar usuario</h4>
					</div>
					<div class="modal-body">
						<form>
							<div class="form-group">
								<label for="modal-agregar-categoria-titulo">Nombre</label>
								<input type="text" class="form-control" id="modal-agregar-categoria-titulo" placeholder="">
							</div>
							<div class="form-group">
								<label for="apellido">Apellido</label>
								<input type="text" class="form-control" id="apellido" placeholder="">
							</div>
							<div class="form-group">
								<label for="email">Correo electronico</label>
								<input type="text" class="form-control" id="email" placeholder="">
							</div>
							<h6>Tipo de usuario</h6>
							<label class="custom-control custom-radio">
								<input id="radio1" name="rol" class="custom-control-input" type="radio" value="A">
								<span class="custom-control-indicator"></span>
								<span class="custom-control-description">Administrador</span>
							</label>
							<label class="custom-control custom-radio">
								<input id="radio2" name="rol" class="custom-control-input" type="radio" value="N">
								<span class="custom-control-indicator"></span>
								<span class="custom-control-description">Normal</span>
							</label>
							<div class="form-group">
								<label for="clave">Clave</label>
								<input type="text" class="form-control" id="clave" placeholder="">
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" id="modal-agregar-categoria-enviar-form">Aceptar</button>
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
					</div>
				</div>
			</div>
		</div>
		
		<div id="modal-modificar-categoria" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h4 class="modal-title">Modificar usuario</h4>
					</div>
					<div class="modal-body">
						<form>
							<div class="form-group">
								<label for="modal-modificar-categoria-titulo">Nombre</label>
								<input type="text" class="form-control" id="modal-modificar-categoria-titulo" placeholder="">
							</div>
							<div class="form-group">
								<label for="apellido2">Apellido</label>
								<input type="text" class="form-control" id="apellido2" placeholder="">
							</div>
							<div class="form-group">
								<label for="email2">Correo electrónico</label>
								<input type="email" class="form-control" id="email2" placeholder="">
							</div>
							<h6>Tipo de usuario</h6>
							<label class="custom-control custom-radio">
								<input id="radio12" name="rol2" class="custom-control-input" type="radio" value="A">
								<span class="custom-control-indicator"></span>
								<span class="custom-control-description">Administrador</span>
							</label>
							<label class="custom-control custom-radio">
								<input id="radio22" name="rol2" class="custom-control-input" type="radio" value="N">
								<span class="custom-control-indicator"></span>
								<span class="custom-control-description">Normal</span>
							</label>
							<div class="form-group">
								<label for="modal-agregar-categoria-titulo">Clave</label>
								<input type="text" class="form-control" id="clave2" placeholder="">
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" id="modal-modificar-categoria-enviar-form">Aceptar</button>
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
		
		<!-- TinyMCE -->
		<script type="text/javascript" src="../vendor/tinymce/tinymce.min.js"></script>
		<script type="text/javascript" src="../vendor/tinymce/skins/custom/jquery.tinymce.min.js"></script>
		<script type="text/javascript" src="../vendor/dropify/dist/js/dropify.min.js"></script>
		<script type="text/javascript" src="../js/jquery.form.js"></script>

		<script>
			var idNoticia = 0;
			$(document).ready(function(){
				var idPub = 0;

				setTimeout(function() {
					$('.preloader').fadeOut();
				}, 500);
				
				var $tablaCategorias = jQuery("#tablaCategorias");
				var tablaCategorias = $tablaCategorias.DataTable( {
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
					"ajax": 'ajax/usuarios.php?op=1'
				} );
				
				$("#modal-agregar-categoria-enviar-form").click(function() {
					var nombre = $("#modal-agregar-categoria-titulo").val();
					var apellido = $("#apellido").val();
					var email = $("#email").val();
					var clave = $("#clave").val();
					if(nombre == '' || apellido == '' || email == '' || clave == '' || $("input[type=radio][name=rol]:checked").length == 0 ) {
						alert("Faltan algunos campos");
					}
					else {
						$.ajax({
							url: 'ajax/usuarios.php',
							type: 'GET',
							data: 'op=2&nombre=' + nombre + '&apellido=' + apellido + '&email=' + email + '&clave=' + clave + '&rol=' + $("input[type=radio][name=rol]:checked").val(),
							dataType: 'json'
						}).done(function(data, textStatus, jqXHR) {						
							switch(jqXHR.status) {
								case 200:
									var json = JSON.parse(jqXHR.responseText);
									if(json.msg == 'OK') {
										$("#modal-agregar-categoria").modal('hide');
										swal("Operación exitosa!", "Se ha agregado el usuario.", "success");
										tablaCategorias.ajax.reload();
									}
									break;
							}
						});
					}
				});
				
				$("#modal-modificar-categoria-enviar-form").click(function() {
					var nombre = $("#modal-modificar-categoria-titulo").val();
					var apellido = $("#apellido2").val();
					var email = $("#email2").val();
					var clave = $("#clave2").val();
					var id = $("#modal-modificar-categoria-enviar-form").attr("data-id");
					if(nombre == '' || apellido == '' || email == '' || clave == '' || $("input[type=radio][name=rol2]:checked").length == 0 ) {
						alert("Faltan algunos campos");
					}
					else {
						$.ajax({
							url: 'ajax/usuarios.php',
							type: 'GET',
							data: 'op=4&nombre=' + nombre + '&i=' + id + '&apellido=' + apellido + '&email=' + email + '&clave=' + clave + '&rol=' + $("input[type=radio][name=rol2]:checked").val(),
							dataType: 'json'
						}).done(function(data, textStatus, jqXHR) {						
							switch(jqXHR.status) {
								case 200:
									var json = JSON.parse(jqXHR.responseText);
									if(json.msg == 'OK') {
										$("#modal-modificar-categoria").modal('hide');
										swal("Operación exitosa!", "Se ha modificado el usuaro seleccionado.", "success");
										tablaCategorias.ajax.reload();
									}
									break;
							}
						});
					}
				});
			});
			
			function modificarCategoria(btn) {
				var $btn = $(btn);
				var $parent = $btn.closest('.acciones-categoria');
				idPub = $parent.attr('data-target');
				$("#modal-modificar-categoria-enviar-form").attr("data-id", idPub);
				$.ajax({
					url: 'ajax/usuarios.php',
					type: 'GET',
					data: 'op=3&i=' + idPub
				}).done(function(data, textStatus, jqXHR) {						
					switch(jqXHR.status) {
						case 200:
							var json = JSON.parse(jqXHR.responseText);
							if(json.msg == 'OK') {
								$("#modal-modificar-categoria-titulo").val(json.data.nombre);
								$("#apellido2").val(json.data.apellido);
								$("#email2").val(json.data.correo_electronico);
								$("#clave2").val(json.data.clave);
								$("input[type=radio][name=rol2]").each(function(index, value) {
									if(value.value == json.data.rol) {
										this.checked = true;
									}
								});
							}
							break;
					}
				});
				$("#modal-modificar-categoria").modal('show');
			}
			
			function eliminarCategoria(btn) {
				var $btn = $(btn);
				var $parent = $btn.closest('.acciones-categoria');
				idPub = $parent.attr('data-target');
				
				swal({
				  title: "Advertencia",
				  text: "Está seguro que desea eliminar esta usuario?",
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
							url: 'ajax/usuarios.php',
							type: 'GET',
							data: 'op=5&i=' + idPub,
							dataType: 'json'
						}).done(function(data, textStatus, jqXHR) {
							switch(jqXHR.status) {
								case 200:
									var json = JSON.parse(jqXHR.responseText);
									if(json.msg == 'OK') {
										swal("Operación exitosa!", "Se eliminó el usuario.", "success");
										//tablaCategorias.ajax.reload();
										//$btn.closest('tr').remove();
										window.location.reload();
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