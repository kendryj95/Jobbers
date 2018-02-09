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
		<title>JOBBERS - Publicidad</title>
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
								<h5 class="m-b-1">Publicidad</h5>
								<div class="m-b-1">
									<a href="#" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#modal-agregar-publicacion"><span class="ti-plus"></span> Agregar</a>
								</div>
								<table class="table table-striped table-bordered dataTable" id="tablaPublicaciones">
									<thead>
										<tr>
											<th>#</th>
											<th>Título</th>
											<th>Fecha de creación</th>
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
				<!-- Footer -->
				<?php require_once('../includes/footer.php'); ?>
			</div>
		</div>
		
		<div id="modal-agregar-publicacion" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h4 class="modal-title">Agregar publicidad</h4>
					</div>
					<div class="modal-body">
						<form method="POST" id="upload">
							<label class="custom-control custom-checkbox">
								<input class="custom-control-input" type="checkbox" id="mipublicidad">
								<span class="custom-control-indicator"></span>
								<span class="custom-control-description">Agregar a mi publicidad</span>
							</label>
							<div class="form-group">
								<label for="modal-agregar-publicacion-titulo">Título</label>
								<input type="text" class="form-control" name="titulo" id="modal-agregar-publicacion-titulo" placeholder="">
							</div>
							<h6 class="m-t-2">Qué desea agregar</h6>
							<label class="custom-control custom-radio">
								<input name="radioOpcion" class="custom-control-input" type="radio" value="1">
								<span class="custom-control-indicator"></span>
								<span class="custom-control-description">Un video</span>
							</label>
							<label class="custom-control custom-radio">
								<input name="radioOpcion" class="custom-control-input" type="radio" value="2">
								<span class="custom-control-indicator"></span>
								<span class="custom-control-description">Una imagen</span>
							</label>
							<div id="containerVideo" style="display:none;">
								<div class="form-group">
									<label for="linkVideo">Enlace del video (URL)</label>
									<input type="text" class="form-control" id="linkVideo" placeholder="">
								</div>
							</div>
							<div id="containerImagen" style="display:none;">
								<div class="form-group">
									<label for="link">Enlace de la publicidad (URL)</label>
									<input type="text" class="form-control" id="link" placeholder="">
								</div>
								<h6>Imagen</h6>
								<input class="dropify" name="file" id="file" type="file">
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" id="modal-agregar-publicacion-enviar-form">Aceptar</button>
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
					</div>
				</div>
			</div>
		</div>
		
		<div id="modal-modificar-publicacion" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h4 class="modal-title">Modificar publicidad</h4>
					</div>
					<div class="modal-body">
						<form method="POST" id="upload2">
							<label class="custom-control custom-checkbox">
								<input class="custom-control-input" type="checkbox" id="mipublicidad2">
								<span class="custom-control-indicator"></span>
								<span class="custom-control-description">Agregar a mi publicidad</span>
							</label>
							<div class="form-group">
								<label for="modal-modificar-publicacion-titulo">Título</label>
								<input type="text" class="form-control" name="titulo" id="modal-modificar-publicacion-titulo" placeholder="">
							</div>
							<h6 class="m-t-2">Qué desea agregar</h6>
							<label class="custom-control custom-radio">
								<input name="radioOpcion2" class="custom-control-input" type="radio" value="1">
								<span class="custom-control-indicator"></span>
								<span class="custom-control-description">Un video</span>
							</label>
							<label class="custom-control custom-radio">
								<input name="radioOpcion2" class="custom-control-input" type="radio" value="2">
								<span class="custom-control-indicator"></span>
								<span class="custom-control-description">Una imagen</span>
							</label>
							<div id="containerVideo2" style="display:none;">
								<div class="form-group">
									<label for="linkVideo2">Enlace del video (URL)</label>
									<input type="text" class="form-control" id="linkVideo2" placeholder="">
								</div>
							</div>
							<div id="containerImagen2" style="display:none;">
								<div class="form-group">
									<label for="modificarLink">Enlace (URL)</label>
									<input type="text" class="form-control" id="modificarLink" placeholder="">
								</div>
								<div class="row">
									<div class="col-md-4"></div>
									<div class="col-md-4" style="text-align: center;">
										<h6>Imagen actual</h6>
										<img id="imgCurrent" style="width: 100%;margin-bottom: 10px;">
									</div>
								</div>
								<input class="dropify" name="file" id="file2" type="file">
							</div>
						</form>
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
				
				$("input[type=radio][name=radioOpcion]").change(function() {
					$("#containerVideo").hide();
					$("#containerImagen").hide();
					if(this.value == 1) {
						$("#containerVideo").show();
					}
					else {
						$("#containerImagen").show();
					}
				});
				
				$('.dropify').dropify();
				var $tablaPublicaciones = jQuery("#tablaPublicaciones");
				var tablaPublicaciones = $tablaPublicaciones.DataTable( {
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
					"ajax": 'ajax/publicidad.php?op=1'
				} );
				
				$("#modal-agregar-publicacion-enviar-form").click(function() {
					var titulo = $("#modal-agregar-publicacion-titulo").val();
					var link = $("#link").val();
					var mipublicidad = $("#mipublicidad:checked").length > 0 ? 1 : 0;
					if(titulo == '' || $("input[type=radio][name=radioOpcion]:checked").length == 0) {
						swal("Error!", "Faltan algunos campos.", "error");
					}
					else {
						if($("input[type=radio][name=radioOpcion]:checked").val() == 1) {
							if($("#linkVideo").val() == '') {
								swal("Error!", "Faltan algunos campos.", "error");
							}
							else {
								$.ajax({
									url: 'ajax/publicidad.php',
									type: 'GET',
									data: 'op=2&option=1&titulo=' + titulo + '&linkVideo=' + $("#linkVideo").val() + '&p=' + mipublicidad,
									dataType: 'json'
								}).done(function(data, textStatus, jqXHR) {						
									switch(jqXHR.status) {
										case 200:
											var json = JSON.parse(jqXHR.responseText);
											if(json.msg == 'OK') {
												$("#modal-agregar-publicacion-titulo").val("");
												$("#linkVideo").val("");
												$("#containerVideo").hide();
												$("#modal-agregar-publicacion").modal('hide');
												swal("Operación exitosa!", "Se agregó la publicidad.", "success");
												tablaPublicaciones.ajax.reload();
											}
											break;
									}
								});
							}
						}
						else {
							if(link == '' || $("#file")[0].files.length == 0) {
								swal("Error!", "Faltan algunos campos.", "error");
							}
							else {
								$("#upload").attr("action", "ajax/publicidad.php?op=2&titulo=" + titulo + '&link=' +link  + '&p=' + mipublicidad);
								var options={
									url     : $("#upload").attr("action"),
									success : function(response,status) {
										var data = JSON.parse(response);
										if(data.msg == "OK") {
											$("#modal-agregar-publicacion-titulo").val("");
											$("#link").val("");
											$("#containerImagen").hide();
											$(".dropify-clear").click();
											$("#modal-agregar-publicacion").modal('hide');
											swal("Operación exitosa!", "Se agregó la publicidad.", "success");
											tablaPublicaciones.ajax.reload();
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
									}
								};
								$("#upload").ajaxSubmit(options);
								return false;
							}
						}
					}
				});
				
				$("#modal-modificar-publicacion-enviar-form").click(function() {
					var titulo = $("#modal-modificar-publicacion-titulo").val();
					var link = $("#modificarLink").val();
					var mipublicidad = $("#mipublicidad:checked").length > 0 ? 1 : 0;
					if(titulo == '') {
						alert("Faltan algunos campos");
					}
					else {
						if($("input[type=radio][name=radioOpcion2]:checked").val() == 1) {
							if($("#linkVideo2").val() == '') {
								swal("Error!", "Faltan algunos campos.", "error");
							}
							else {
								$.ajax({
									url: 'ajax/publicidad.php',
									type: 'GET',
									data: 'op=4&option=1&titulo=' + titulo + '&linkVideo2=' + $("#linkVideo2").val() + '&p=' + mipublicidad + '&i=' + idPub,
									dataType: 'json'
								}).done(function(data, textStatus, jqXHR) {						
									switch(jqXHR.status) {
										case 200:
											var json = JSON.parse(jqXHR.responseText);
											if(json.msg == 'OK') {
												 $("#modal-modificar-publicacion").modal('hide');
												swal("Operación exitosa!", "Se han modificado los datos de la publicidad seleccionada. " +text, "success");
												tablaPublicaciones.ajax.reload();
											}
											break;
									}
								});
							}
						}
						else {
							$("#upload2").attr("action", "ajax/publicidad.php?op=4&i=" + idPub + '&titulo=' + titulo + '&link=' + link + '&p=' + mipublicidad);
							var options={
								url     : $("#upload2").attr("action"),
								success : function(response,status) {
									var data = JSON.parse(response);
									if(data.msg == "OK") {
										var text = "";
										if(data.foto != "") {
											if(data.foto != "OK") {
												text = "Ocurrio un error al subir la foto.";
											}
										}
										$("#modal-modificar-publicacion").modal('hide');
										swal("Operación exitosa!", "Se han modificado los datos de la publicidad seleccionada. " +text, "success");
										tablaPublicaciones.ajax.reload();
									}
								}
							};
							$("#upload2").ajaxSubmit(options);
							return false;
						}
					}
				});
			});
			
			function modificarPublicacion(btn) {
				var $btn = $(btn);
				var $parent = $btn.closest('.acciones-publicacion');
				idPub = $parent.attr('data-target');
				$.ajax({
					url: 'ajax/publicidad.php',
					type: 'GET',
					data: 'op=3&i=' + idPub,
					dataType: 'json'
				}).done(function(data, textStatus, jqXHR) {						
					switch(jqXHR.status) {
						case 200:
							var json = JSON.parse(jqXHR.responseText);
							if(json.msg == 'OK') {
								var html = '';
								
								$("input[type=radio][name=radioOpcion2]").each(function(index, value) {
									if(value.value == json.data.tipo_publicidad) {
										this.checked = true;
									}
								});
								
								if(json.data.mipublicidad == 1) {
									$("#mipublicidad2").click();
								}
								$("#modal-modificar-publicacion-titulo").val(json.data.titulo);
								if(json.data.tipo_publicidad == 1) {
									$("#containerVideo2").show();
									$("#linkVideo2").val(json.data.url);
								}
								else {
									$("#containerImagen2").show();
									$("#modificarLink").val(json.data.url);
									$("#imgCurrent").attr("src", "../img/"+json.data.imagen);
								}
							}
							break;
					}
				});
				$("#modal-modificar-publicacion").modal('show');
			}
			
			function eliminarPublicacion(btn) {
				var $btn = $(btn);
				var $parent = $btn.closest('.acciones-publicacion');
				idPub = $parent.attr('data-target');
				
				swal({
				  title: "Advertencia",
				  text: "Está seguro que desea eliminar esta publicidad?",
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
							url: 'ajax/publicidad.php',
							type: 'GET',
							data: 'op=5&i=' + idPub,
							dataType: 'json'
						}).done(function(data, textStatus, jqXHR) {
							switch(jqXHR.status) {
								case 200:
									var json = JSON.parse(jqXHR.responseText);
									if(json.msg == 'OK') {
										swal("Operación exitosa!", "Se eliminó la publicidad y sus datos.", "success");
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