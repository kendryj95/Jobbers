<?php
	session_start();

	require_once('classes/DatabasePDOInstance.function.php');

	$db = DatabasePDOInstance();

	$areas = $db->getAll("
		SELECT id, nombre FROM areas
	");

	if($areas === false) {
		$areas = array();
	}

	$sectores = $db->getAll("
		SELECT id, id_area, nombre FROM areas_sectores
	");

	if($sectores === false) {
		$sectores = array();
	}
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
		<title>JOBBERS - Publicaciones</title>
		<?php require_once('includes/libs-css.php'); ?>

		<link rel="stylesheet" href="vendor/DataTables/css/dataTables.bootstrap4.min.css">
		<link rel="stylesheet" href="vendor/DataTables/Responsive/css/responsive.bootstrap4.min.css">
		<link rel="stylesheet" href="vendor/DataTables/Buttons/css/buttons.dataTables.min.css">
		<link rel="stylesheet" href="vendor/DataTables/Buttons/css/buttons.bootstrap4.min.css">
		
		<link rel="stylesheet" href="vendor/select2/dist/css/select2.min.css">
		<style>
			th.dt-center, td.dt-center { text-align: center; }
			
			.swal2-modal {
				border: 1px solid rgb(223, 223, 223);
			}
			
			#tablaPostulados {
				width: 100% !important;
			}
		</style>
	</head>

	<body class="large-sidebar fixed-sidebar fixed-header skin-5">
		<div class="wrapper">

			<!-- Preloader 
			<div class="preloader"></div>-->

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
						<div class="box box-block bg-white">
							<h5 class="m-b-1">Mis servicios free lance</h5>
							<div class="m-b-1">
								<a href="#" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#modal-agregar-publicacion"><span class="ti-plus"></span> Agregar</a>
							</div>
							<table class="table table-striped table-bordered dataTable" id="tablaPublicaciones">
								<thead>
									<tr>
										<th>#</th>
										<th>Título</th>
										<th>Descripción</th>
										<th>Descripción</th>
										<th>Acciones</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<!-- Footer -->
				<?php require_once('includes/footer.php'); ?>
			</div>
		</div>
		
		<div id="modal-agregar-publicacion" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h4 class="modal-title">Agregar publicación</h4>
					</div>
					<div class="modal-body">
						<ul class="nav nav-tabs nav-tabs-2">
							<li class="nav-item">
								<a class="nav-link active" href="#modal-agregar-publicacion-info" data-toggle="tab"><i class="ti-info text-muted m-r-0-25"></i> Información</a>
							</li>
							<!--<li class="nav-item">
								<a class="nav-link" href="#modal-agregar-publicacion-imagenes" data-toggle="tab"><i class="ti-gallery text-muted m-r-0-25"></i> Imágenes</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="#modal-agregar-publicacion-videos" data-toggle="tab"><i class="ti-video-clapper text-muted m-r-0-25"></i> Videos</a>
							</li>-->
						</ul>
						<div class="tab-content" style="padding: 25px;">
						  <div id="modal-agregar-publicacion-info" class="tab-pane fade in active">
							<form>
								<div class="form-group">
									<label for="select2-demo-1" class="form-control-label">Área</label>
									<select id="select2-demo-1" class="form-control" data-plugin="select2">
										<?php foreach($areas as $area): ?>
											<option value="<?php echo $area["id"]; ?>"><?php echo $area["nombre"]; ?></option>
										<?php endforeach ?>
									</select>
								</div>
								<div class="form-group">
									<label for="select2-demo-2" class="form-control-label">Sector</label>
									<select id="select2-demo-2" class="form-control" data-plugin="select2">
										<?php
											if(count($areas) > 0) {
												$area = $areas[0];
											}
										?>
										<?php foreach($sectores as $sector): ?>
											<?php if($sector["id_area"] == $area["id"]): ?>
												<option value="<?php echo $sector["id"]; ?>"><?php echo $sector["nombre"]; ?></option>
											<?php endif ?>
										<?php endforeach ?>
									</select>
								</div>
								<div class="form-group">
									<label for="modal-agregar-publicacion-titulo">Título</label>
									<input type="text" class="form-control" id="modal-agregar-publicacion-titulo" placeholder="">
								</div>
								<div class="form-group">
									<label for="modal-agregar-publicacion-descripcion">Descripción</label>
									<texarea id="modal-agregar-publicacion-descripcion"></texarea>
								</div>
							</form>
						  </div>
						  <!--<div id="modal-agregar-publicacion-imagenes" class="tab-pane fade">
							<h3>Imágenes</h3>
						  </div>
						  <div id="modal-agregar-publicacion-videos" class="tab-pane fade">
							<h3>Videos</h3>
						  </div>-->
						</div>
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
						<h4 class="modal-title">Modificar publicación</h4>
					</div>
					<div class="modal-body">
						<ul class="nav nav-tabs nav-tabs-2">
							<li class="nav-item">
								<a class="nav-link active" href="#modal-modificar-publicacion-info" data-toggle="tab"><i class="ti-info text-muted m-r-0-25"></i> Información</a>
							</li>
							<!--<li class="nav-item">
								<a class="nav-link" href="#modal-modificar-publicacion-imagenes" data-toggle="tab"><i class="ti-gallery text-muted m-r-0-25"></i> Imágenes</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="#modal-modificar-publicacion-videos" data-toggle="tab"><i class="ti-video-clapper text-muted m-r-0-25"></i> Videos</a>
							</li>-->
						</ul>
						<div class="tab-content" style="padding: 25px;">
						  <div id="modal-modificar-publicacion-info" class="tab-pane fade in active">
							<form>
								<div class="form-group">
									<label for="select2-demo-12" class="form-control-label">Área</label>
									<select id="select2-demo-12" class="form-control" data-plugin="select2">
										<?php foreach($areas as $area): ?>
											<option value="<?php echo $area["id"]; ?>"><?php echo $area["nombre"]; ?></option>
										<?php endforeach ?>
									</select>
								</div>
								<div class="form-group">
									<label for="select2-demo-22" class="form-control-label">Sector</label>
									<select id="select2-demo-22" class="form-control" data-plugin="select2">
										<?php
											if(count($areas) > 0) {
												$area = $areas[0];
											}
										?>
										<?php foreach($sectores as $sector): ?>
											<?php if($sector["id_area"] == $area["id"]): ?>
												<option value="<?php echo $sector["id"]; ?>"><?php echo $sector["nombre"]; ?></option>
											<?php endif ?>
										<?php endforeach ?>
									</select>
								</div>
								<div class="form-group">
									<label for="modal-modificar-publicacion-titulo">Título</label>
									<input type="text" class="form-control" id="modal-modificar-publicacion-titulo" placeholder="">
								</div>
								<div class="form-group">
									<label for="modal-modificar-publicacion-descripcion">Descripción</label>
									<texarea id="modal-modificar-publicacion-descripcion"></texarea>
								</div>
							</form>
						  </div>
						  <div id="modal-modificar-publicacion-imagenes" class="tab-pane fade">
							<h3>Imágenes</h3>
						  </div>
						  <div id="modal-modificar-publicacion-videos" class="tab-pane fade">
							<h3>Videos</h3>
						  </div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" id="modal-modificar-publicacion-enviar-form">Aceptar</button>
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
					</div>
				</div>
			</div>
		</div>
		
		<div id="modal-postulados" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h4 class="modal-title">Trabajadores postulados a este empleo</h4>
					</div>
					<div class="modal-body">
						<table id="tablaPostulados" class="table table-striped table-bordered dataTable">
							<thead>
								<tr>
									<th>#</th>
									<th>Trabajador</th>
									<th>Fecha y hora</th>
									<th>Acciones</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
					</div>
				</div>
			</div>
		</div>

		<?php require_once('includes/libs-js.php'); ?>

		<script type="text/javascript" src="vendor/DataTables/js/jquery.dataTables.min.js"></script>
		<script type="text/javascript" src="vendor/DataTables/js/dataTables.bootstrap4.min.js"></script>
		<script type="text/javascript" src="vendor/DataTables/Responsive/js/dataTables.responsive.min.js"></script>
		<script type="text/javascript" src="vendor/DataTables/Responsive/js/responsive.bootstrap4.min.js"></script>
		<script type="text/javascript" src="vendor/DataTables/Buttons/js/dataTables.buttons.min.js"></script>
		<script type="text/javascript" src="vendor/DataTables/Buttons/js/buttons.bootstrap4.min.js"></script>
		<script type="text/javascript" src="vendor/DataTables/JSZip/jszip.min.js"></script>
		<script type="text/javascript" src="vendor/DataTables/pdfmake/build/pdfmake.min.js"></script>
		<script type="text/javascript" src="vendor/DataTables/pdfmake/build/vfs_fonts.js"></script>
		<script type="text/javascript" src="vendor/DataTables/Buttons/js/buttons.html5.min.js"></script>
		<script type="text/javascript" src="vendor/DataTables/Buttons/js/buttons.print.min.js"></script>
		<script type="text/javascript" src="vendor/DataTables/Buttons/js/buttons.colVis.min.js"></script>
		
		<script type="text/javascript" src="vendor/select2/dist/js/select2.min.js"></script>
		
		<!-- TinyMCE -->
		<script type="text/javascript" src="vendor/tinymce/tinymce.min.js"></script>
		<script type="text/javascript" src="vendor/tinymce/skins/custom/jquery.tinymce.min.js"></script>

		<script>
			var idPub = 0;
			var sectores = <?php echo json_encode($sectores); ?>;
			
			function modificarPublicacion(btn) {
				var $btn = $(btn);
				var $parent = $btn.closest('.acciones-publicacion');
				idPub = $parent.attr('data-target');
				$.ajax({
					url: 'ajax/publicaciones.php',
					type: 'GET',
					dataType: 'json',
					data: {
						op: 2,
						i: idPub
					}
				}).done(function(data, textStatus, jqXHR) {						
					switch(jqXHR.status) {
						case 200:
							var json = JSON.parse(jqXHR.responseText);
							if(json.msg == 'OK') {
								var html = '';
								var publicacion = json.data.publicacion;
								$("#select2-demo-12").val(publicacion.area_id).trigger('change');
								sectores.forEach(function(sector) {
									if(sector.id_area == publicacion.area_id) {
										html += '<option value="' + sector.id + '">' + sector.nombre + '</option>';
									}
								});
								$('#select2-demo-22').html(html).trigger('change');
								$('#select2-demo-22').val(publicacion.sector_id).trigger('change');
								$("#modal-modificar-publicacion-titulo").val(publicacion.titulo);
								tinyMCE.get('modal-modificar-publicacion-descripcion').setContent(publicacion.descripcion);
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
				  text: "Está seguro que desea eliminar esta publicación?",
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
							url: 'ajax/publicaciones.php',
							type: 'GET',
							dataType: 'json',
							data: {
								op: 4,
								i: idPub
							}
						}).done(function(data, textStatus, jqXHR) {
							switch(jqXHR.status) {
								case 200:
									var json = JSON.parse(jqXHR.responseText);
									if(json.msg == 'OK') {
										swal("Operación exitosa!", "Se eliminó la publicación y sus datos.", "success");
										tablaPublicaciones.ajax.reload();
									}
									break;
							}
						});
					}
				});
			}
			
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
				"ajax": 'ajax/publicaciones.php?op=5'
			} );
			
			
			$("#enviarFormRubro").click(function() {
				var nombre = $("#rubroNombre").val();
				if(nombre == '') {
					alert("Debe ingresar algún nombre para el rubro.");
				}
				else {
					$("#formRubro").submit();
				}
			});
			
			tinymce.init({
				selector: '#modal-modificar-publicacion-descripcion',
				height: 150,
				plugins: [
					'advlist lists charmap print preview anchor',
					'searchreplace visualblocks code fullscreen',
					'insertdatetime table contextmenu paste code'
				],
				toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
				language: 'es'
			});
			
			tinymce.init({
				selector: '#modal-agregar-publicacion-descripcion',
				height: 150,
				plugins: [
					'advlist lists charmap print preview anchor',
					'searchreplace visualblocks code fullscreen',
					'insertdatetime table contextmenu paste code'
				],
				toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
				language: 'es'
			});
			
			$('#select2-demo-1').select2({
				width: '100%'
			}).on("select2:select", function (e) {
				var idArea = $(this).val();
				var html = '';
				sectores.forEach(function(sector) {
					if(sector.id_area == idArea) {
						html += '<option value="' + sector.id + '">' + sector.nombre + '</option>';
					}
				});
				$('#select2-demo-2').html(html).trigger('change');
			});
			$('#select2-demo-2').select2({
				width: '100%'
			});
			
			$('#select2-demo-12').select2({
				width: '100%'
			}).on("select2:select", function (e) {
				var idArea = $(this).val();
				var html = '';
				sectores.forEach(function(sector) {
					if(sector.id_area == idArea) {
						html += '<option value="' + sector.id + '">' + sector.nombre + '</option>';
					}
				});
				$('#select2-demo-22').html(html).trigger('change');
			});
			$('#select2-demo-22').select2({
				width: '100%'
			});
			
			window.onload = function() {
				//$("#modal-agregar-publicacion").modal('show');
				//$("#modal-modificar-publicacion").modal('show');
			};
			
			$("#modal-agregar-publicacion-enviar-form").click(function() {
				var idArea = $("#select2-demo-1").val();
				var idSector = $("#select2-demo-2").val();
				var titulo = $("#modal-agregar-publicacion-titulo").val();
				var descripcion = tinyMCE.get('modal-agregar-publicacion-descripcion').getContent();
				if(titulo == '' || descripcion == '') {
					swal("Error!", "Faltan algunos campos.", "error");
				}
				else {
					$.ajax({
						url: 'ajax/publicaciones.php',
						type: 'GET',
						dataType: 'json',
						data: {
							op: 1,
							info: JSON.stringify({
								area: idArea,
								sector: idSector,
								titulo: titulo,
								descripcion: descripcion
							})
						}
					}).done(function(data, textStatus, jqXHR) {				
						switch(jqXHR.status) {
							case 200:
								var json = JSON.parse(jqXHR.responseText);
								if(json.msg == 'OK') {
									var publicacion = json.data.publicacion;
									$("#modal-agregar-publicacion").modal('hide');
									swal("Operación exitosa!", "Se agregó la publicación y sus datos.", "success");
									tablaPublicaciones.ajax.reload();
								}
								break;
						}
					});
				}
			});
			
			$("#modal-modificar-publicacion-enviar-form").click(function() {
				var idArea = $("#select2-demo-12").val();
				var idSector = $("#select2-demo-22").val();
				var titulo = $("#modal-modificar-publicacion-titulo").val();
				var descripcion = tinyMCE.get('modal-modificar-publicacion-descripcion').getContent();
				if(titulo == '' || descripcion == '') {
					alert("Faltan algunos campos");
				}
				else {
					$.ajax({
						url: 'ajax/publicaciones.php',
						type: 'GET',
						dataType: 'json',
						data: {
							op: 3,
							i: idPub,
							info: JSON.stringify({
								area: idArea,
								sector: idSector,
								titulo: titulo,
								descripcion: descripcion
							})
						}
					}).done(function(data, textStatus, jqXHR) {						
						switch(jqXHR.status) {
							case 200:
								var json = JSON.parse(jqXHR.responseText);
								if(json.msg == 'OK') {
									var publicacion = json.data.publicacion;
									$("#modal-modificar-publicacion").modal('hide');
									swal("Operación exitosa!", "Se han modificado los datos de la publicación seleccionada.", "success");
									tablaPublicaciones.ajax.reload();
								}
								break;
						}
					});
				}
			});
			
			$('#modal-agregar-publicacion').on('show.bs.modal', function (e) {
				$("#select2-demo-1").val($("#select2-demo-1 option:first").val()).trigger('change');
				var idArea = $("#select2-demo-1").val();
				var html = '';
				sectores.forEach(function(sector) {
					if(sector.id_area == idArea) {
						html += '<option value="' + sector.id + '">' + sector.nombre + '</option>';
					}
				});
				$('#select2-demo-2').html(html).trigger('change');
				$("#modal-agregar-publicacion-titulo").val('');
				tinyMCE.get('modal-agregar-publicacion-descripcion').setContent('');
			});
		</script>

	</body>

</html>