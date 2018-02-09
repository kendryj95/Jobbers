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
	$categorias = $db->getAll("SELECT * FROM categorias");
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
		<title>JOBBERS - Mis noticias</title>
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
							<div class="row">
								<ul class="nav nav-tabs nav-tabs-2" role="tablist" style="padding-left: 15px;">
									<li class="nav-item">
										<a class="nav-link active" data-toggle="tab" href="#tab1" role="tab">Categorías</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" data-toggle="tab" href="#tab2" role="tab">Noticias</a>
									</li>
								</ul>
								<div class="tab-content">
									<div class="tab-pane active" id="tab1" role="tabpanel">
										<div class="container-fluid">
											<div class="box box-block bg-white">
												<h5 class="m-b-1">Mis categorías</h5>
												<div class="m-b-1">
													<a href="#" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#modal-agregar-categoria"><span class="ti-plus"></span> Agregar</a>
												</div>
												<table class="table table-striped table-bordered dataTable" id="tablaCategorias">
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
									<div class="tab-pane" id="tab2" role="tabpanel">
										<div class="container-fluid">
											<div class="box box-block bg-white">
												<h5 class="m-b-1">Mis noticias</h5>
												<div class="m-b-1">
													<a href="#" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#modal-agregar-publicacion"><span class="ti-plus"></span> Agregar</a>
												</div>
												<table class="table table-striped table-bordered dataTable" id="tablaPublicaciones">
													<thead>
														<tr>
															<th>#</th>
															<th>Título</th>
															<th>Categoría</th>
															<th>Categoría</th>
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
						<h4 class="modal-title">Agregar categoría</h4>
					</div>
					<div class="modal-body">
						<form>
							<div class="form-group">
								<label for="modal-agregar-categoria-titulo">Título</label>
								<input type="text" class="form-control" id="modal-agregar-categoria-titulo" placeholder="">
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
						<h4 class="modal-title">Agregar categoría</h4>
					</div>
					<div class="modal-body">
						<form>
							<div class="form-group">
								<label for="modal-modificar-categoria-titulo">Título</label>
								<input type="text" class="form-control" id="modal-modificar-categoria-titulo" placeholder="">
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
		
		<div id="modal-agregar-publicacion" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h4 class="modal-title">Agregar noticia</h4>
					</div>
					<div class="modal-body">
						<form method="POST" id="upload">
							<div class="form-group">
								<label for="select2-demo-1" class="form-control-label">Categoría</label>
								<select id="select2-demo-1" class="form-control" data-plugin="select2">
									<?php foreach($categorias as $c): ?>
										<option value="<?php echo $c["id"]; ?>"><?php echo $c["nombre"]; ?></option>
									<?php endforeach ?>
								</select>
							</div>
							<div class="form-group">
								<label for="modal-agregar-publicacion-titulo">Título</label>
								<input type="text" class="form-control" name="titulo" id="modal-agregar-publicacion-titulo" placeholder="">
							</div>
							<div class="form-group">
								<label for="modal-agregar-publicacion-descripcion">Descripción</label>
								<textarea id="modal-agregar-publicacion-descripcion"></textarea>
								<input type="hidden" id="textoDescripcionNoticiaAgregar" name="descripcion">
							</div>
							<input class="dropify" name="file" id="file" type="file">
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
						<h4 class="modal-title">Modificar noticia</h4>
					</div>
					<div class="modal-body">
						<form method="POST" id="upload2">
							<div class="form-group">
								<label for="select2-demo-12" class="form-control-label">Categoría</label>
								<select id="select2-demo-12" class="form-control" data-plugin="select2">
									<?php foreach($categorias as $c): ?>
										<option value="<?php echo $c["id"]; ?>"><?php echo $c["nombre"]; ?></option>
									<?php endforeach ?>
								</select>
							</div>
							<div class="form-group">
								<label for="modal-modificar-publicacion-titulo">Título</label>
								<input type="text" class="form-control" name="titulo" id="modal-modificar-publicacion-titulo" placeholder="">
							</div>
							<div class="form-group">
								<label for="modal-modificar-publicacion-descripcion">Descripción</label>
								<texarea id="modal-modificar-publicacion-descripcion"></texarea>
								<input type="hidden" id="textoDescripcionNoticiaModificar" name="descripcion">
							</div>
							<div class="row">
								<div class="col-md-4"></div>
								<div class="col-md-4" style="text-align: center;">
									<h6>Imagen actual</h6>
									<img id="imgCurrent" style="width: 100%;margin-bottom: 10px;">
								</div>
							</div>
							<input class="dropify" name="file" id="file2" type="file">
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
			var tablaPublicaciones = '';
			var tablaCategorias = '';
			$(document).ready(function(){
				var idPub = 0;

				setTimeout(function() {
					$('.preloader').fadeOut();
				}, 500);
				setTimeout(function() {
					$('.content-loader').fadeOut();
				}, 500);
				
				var $tablaCategorias = jQuery("#tablaCategorias");
					 tablaCategorias = $tablaCategorias.DataTable( {
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
					"ajax": '../ajax/noticias.php?op=1'
				} );
				
				$('.dropify').dropify();
				
				var $tablaPublicaciones = jQuery("#tablaPublicaciones");
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
					"ajax": '../ajax/noticias.php?op=7'
				} );
				
				tinymce.init({
					selector: '#modal-modificar-publicacion-descripcion',
					height: 150,
					plugins: [
						'advlist autolink lists link image charmap print preview anchor',
						'searchreplace visualblocks code fullscreen',
						'insertdatetime media table contextmenu paste code'
					],
					toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
					language: 'es'
				});

				tinymce.init({
					selector: '#modal-agregar-publicacion-descripcion',
					height: 150,
					plugins: [
						'advlist autolink lists link image charmap print preview anchor',
						'searchreplace visualblocks code fullscreen',
						'insertdatetime media table contextmenu paste code'
					],
					toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
					language: 'es'
				});

				$(document).on('focusin', function(e) { /* Para que funcione los modales de tinymce dentro de otro modal, en este caso, dentro de los modales de bootstrap*/
				    if ($(event.target).closest(".mce-window").length) {
				        e.stopImmediatePropagation();
				    }
				});

				$('#select2-demo-1').select2({
					width: '100%'
				});

				$('#select2-demo-12').select2({
					width: '100%'
				});
				
				$("#modal-agregar-publicacion-enviar-form").click(function() {
					var idCategoria = $("#select2-demo-1").val();
					var titulo = $("#modal-agregar-publicacion-titulo").val();
					var descripcion = tinyMCE.get('modal-agregar-publicacion-descripcion').getContent();
					if(titulo == '' || descripcion == '' || $("#file")[0].files.length == 0) {
						swal("Error!", "Faltan algunos campos.", "error");
					}
					else {
						$("#textoDescripcionNoticiaAgregar").val(descripcion);
						$("#upload").attr("action", "../ajax/noticias.php?op=8&id_categoria=" + idCategoria); // + '&descripcion=' + descripcion);
						var options={
							url     : $("#upload").attr("action"),
							success : function(response,status) {
								var data = JSON.parse(response);
								if(data.msg == "OK") {
									$("#modal-agregar-publicacion").modal('hide');
									swal("Operación exitosa!", "Se agregó la noticia.", "success");
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
				});
				
				$("#modal-modificar-publicacion-enviar-form").click(function() {
					var idCategoria = $("#select2-demo-12").val();
					var titulo = $("#modal-modificar-publicacion-titulo").val();
					var descripcion = tinyMCE.get('modal-modificar-publicacion-descripcion').getContent();
					if(titulo == '' || descripcion == '') {
						alert("Faltan algunos campos");
					}
					else {
						$("#textoDescripcionNoticiaModificar").val(descripcion);
						$("#upload2").attr("action", "../ajax/noticias.php?op=10&id_categoria=" + idCategoria + '&i=' + idNoticia); //  + '&descripcion=' + descripcion
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
									swal("Operación exitosa!", "Se han modificado los datos de la noticia seleccionada. " +text, "success");
									tablaPublicaciones.ajax.reload();
								}
							}
						};
						$("#upload2").ajaxSubmit(options);
						return false;
					}
				});
				
				$("#modal-agregar-categoria-enviar-form").click(function() {
					var titulo = $("#modal-agregar-categoria-titulo").val();
					if(titulo == '') {
						alert("Faltan algunos campos");
					}
					else {
						$.ajax({
							url: '../ajax/noticias.php',
							type: 'GET',
							data: 'op=2&titulo=' + titulo,
							dataType: 'json'
						}).done(function(data, textStatus, jqXHR) {						
							switch(jqXHR.status) {
								case 200:
									var json = JSON.parse(jqXHR.responseText);
									if(json.msg == 'OK') {
										//var publicacion = json.data.publicacion;
										$("#modal-agregar-categoria").modal('hide');
										swal("Operación exitosa!", "Se ha agregado la categoría.", "success");
										tablaCategorias.ajax.reload();
									}
									break;
							}
						});
					}
				});
				
				$("#modal-modificar-categoria-enviar-form").click(function() {
					var titulo = $("#modal-modificar-categoria-titulo").val();
					if(titulo == '') {
						alert("Faltan algunos campos");
					}
					else {
						$.ajax({
							url: '../ajax/noticias.php',
							type: 'GET',
							data: 'op=4&titulo=' + titulo + '&i=' + idPub,
							dataType: 'json'
						}).done(function(data, textStatus, jqXHR) {						
							switch(jqXHR.status) {
								case 200:
									var json = JSON.parse(jqXHR.responseText);
									if(json.msg == 'OK') {
										$("#modal-modificar-categoria").modal('hide');
										swal("Operación exitosa!", "Se ha modificado la categoría seleccionada.", "success");
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
				$.ajax({
					url: '../ajax/noticias.php',
					type: 'GET',
					data: 'op=3&i=' + idPub
				}).done(function(data, textStatus, jqXHR) {						
					switch(jqXHR.status) {
						case 200:
							var json = JSON.parse(jqXHR.responseText);
							if(json.msg == 'OK') {
								$("#modal-modificar-categoria-titulo").val(json.data.nombre);
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
				  text: "Está seguro que desea eliminar esta categoría?",
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
							url: '../ajax/noticias.php',
							type: 'GET',
							data: 'op=5&i=' + idPub,
							dataType: 'json'
						}).done(function(data, textStatus, jqXHR) {
							switch(jqXHR.status) {
								case 200:
									var json = JSON.parse(jqXHR.responseText);
									if(json.msg == 'OK') {
										swal("Operación exitosa!", "Se eliminó la categoría.", "success");
										tablaCategorias.ajax.reload();
									}
									break;
							}
						});
					}
				});
			}
			
			function modificarPublicacion(btn) {
				var $btn = $(btn);
				var $parent = $btn.closest('.acciones-publicacion');
				idNoticia = $parent.attr('data-target');
				$.ajax({
					url: '../ajax/noticias.php',
					type: 'GET',
					data: 'op=9&i=' + idNoticia,
					dataType: 'json'
				}).done(function(data, textStatus, jqXHR) {						
					switch(jqXHR.status) {
						case 200:
							var json = JSON.parse(jqXHR.responseText);
							if(json.msg == 'OK') {
								var html = '';
								$("#select2-demo-12").val(json.data.id_categoria).trigger('change');
								$("#modal-modificar-publicacion-titulo").val(json.data.titulo);
								tinyMCE.get('modal-modificar-publicacion-descripcion').setContent(json.data.descripcion);
								$("#imgCurrent").attr("src", "../img/"+json.data.imagen);
							}
							break;
					}
				});
				$("#modal-modificar-publicacion").modal('show');
			}
			
			function eliminarPublicacion(btn) {
				var $btn = $(btn);
				var $parent = $btn.closest('.acciones-publicacion');
				idNoticia = $parent.attr('data-target');
				
				swal({
				  title: "Advertencia",
				  text: "Está seguro que desea eliminar esta noticia?",
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
							url: '../ajax/noticias.php',
							type: 'GET',
							data: 'op=11&i=' + idNoticia,
							dataType: 'json'
						}).done(function(data, textStatus, jqXHR) {
							switch(jqXHR.status) {
								case 200:
									var json = JSON.parse(jqXHR.responseText);
									if(json.msg == 'OK') {
										swal("Operación exitosa!", "Se eliminó la noticia y sus datos.", "success");
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