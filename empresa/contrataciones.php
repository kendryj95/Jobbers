<?php
	session_start();

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
		<title>JOBBERS - Contrataciones</title>
		<link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.css" rel="stylesheet">
		<?php require_once('../includes/libs-css.php'); ?>

		<link rel="stylesheet" href="../vendor/DataTables/css/dataTables.bootstrap4.min.css">
		<link rel="stylesheet" href="../vendor/DataTables/Responsive/css/responsive.bootstrap4.min.css">
		<link rel="stylesheet" href="../vendor/DataTables/Buttons/css/buttons.dataTables.min.css">
		<link rel="stylesheet" href="../vendor/DataTables/Buttons/css/buttons.bootstrap4.min.css">
		
		<link rel="stylesheet" href="../vendor/star-rating/star-rating.min.css">
		<style>
			th.dt-center, td.dt-center { text-align: center; }
			
			.swal2-modal {
				border: 1px solid rgb(223, 223, 223);
			}
			
			#tablaPostulados {
				width: 100% !important;
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

	<body class="large-sidebar fixed-sidebar fixed-header skin-5">
		<div class="wrapper">

			<!-- Preloader 
			<div class="preloader"></div>-->

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
						<div class="box box-block bg-white">
							<h5 class="m-b-1">Jobbers seleccionados</h5>
							<table class="table table-striped table-bordered dataTable" id="tablaPublicaciones">
								<thead>
									<tr>
										<th>#</th>
										<th>Título</th>
										<th>Descripción</th>
										<th>Jobber</th>
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
				<?php require_once('../includes/footer.php'); ?>
			</div>
		</div>
		
		<div id="modal-publicacion" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h4 class="modal-title">Detalles de la publicación</h4>
					</div>
					<div class="modal-body">
						
					</div>
					<div class="modal-footer">
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
		
		<script type="text/javascript" src="../vendor/star-rating/star-rating.min.js"></script>
	

		<script>
			var idPub = 0;
		
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
				"ajax": 'ajax/contrataciones.php?op=1'
			} );

			function verPublicacion(e) {
				var i = $(e).attr("data-target");
				$.ajax({
					url: 'ajax/contrataciones.php?op=2&i=' + i,
					type: 'GET',
					dataType: 'json',
				}).done(function(data, textStatus, jqXHR) {						
					switch(jqXHR.status) {
						case 200:
							console.log(data);
							var band = false;
							var html = '<div class="card card-block"> <h3 class="card-title">'+data.titulo+'</h3> <p class="card-text">'+data.descripcion+'</p> <p class="card-text"> <span class="text-muted">Nombre del trabajador contratado:</span> <a href="../trabajador-detalle.php?t='+data.link+'">'+data.trabajador+'</a></p> <div id="rating" style="display:none;"><label for="calification" class="control-label">Califica al trabajador</label><input id="calification" name="calification" class="rating rating-loading" data-show-clear="false" data-show-caption="true"><div class="form-group"> <label for="comment">Escribe tu comentario con respecto al trabajo realizado del trabajador</label> <textarea class="form-control" id="comment" rows="3"></textarea> </div></div>';
							
							if(parseInt(data.finalizado) == 0 && parseInt(data.cancelado) != 1) {
								html += '<p class="card-text"><h4>Acciones</h4></p><button type="button" id="finishC" data-i="'+data.id+'" class="btn btn-danger">Finalizar contrato</button>';
							}
							else {
								html += '<p class="card-text"><h4>Contrato finalizado</h4></p><p class="card-text">Fecha: <strong>'+data.fecha_finalizado+'</strong></p>';
							}
							
							html += '</div>';
							$("#modal-publicacion .modal-body").html(html);
							
							$('#calification').rating({clearCaption: 'Sin calificar '});
							
							$("#finishC").click(function() {
								var i = $(this).attr("data-i");
								if(band) {
									$.ajax({
										type: 'POST',
										url: 'ajax/contrataciones.php',
										data: 'op=3&i=' + i + '&r=' + $('#calification').val() + '&c=' + $("#comment").val(),
										dataType: 'json',
										success: function(data) {
											console.log(data);
											swal("Operación exitosa!", "Contrato finalizado", "success");
											$("#modal-publicacion").modal('hide');
										}
									});
								}
								else {
									swal({
										title: 'Información!',
										text: "Esta seguro que quiere realizar este proceso?",
										type: 'warning',
										showCancelButton: true,
										confirmButtonColor: '#3085d6',
										cancelButtonColor: '#d33',
										confirmButtonText: 'Si',
										cancelButtonText: 'No',
										confirmButtonClass: 'btn btn-primary btn-lg m-r-1',
										cancelButtonClass: 'btn btn-danger btn-lg',
										buttonsStyling: false
										}).then(function(isConfirm) {
										if (isConfirm === true) {
											swal({
												title: 'Información!',
												text: "Desea calificar al trabajador? De no calificar el contrato queda cancelado sin calificación de ninguna de las partes",
												type: 'warning',
												showCancelButton: true,
												confirmButtonColor: '#3085d6',
												cancelButtonColor: '#d33',
												confirmButtonText: 'Si',
												cancelButtonText: 'No',
												confirmButtonClass: 'btn btn-primary btn-lg m-r-1',
												cancelButtonClass: 'btn btn-danger btn-lg',
												buttonsStyling: false
												}).then(function(isConfirm) {
												if (isConfirm === true) {
													$("#rating").css("display", "block");
													band = true;
												}
												else {
													$.ajax({
														type: 'POST',
														url: 'ajax/contrataciones.php',
														data: 'op=3&i=' + i,
														dataType: 'json',
														success: function(data) {
															console.log(data);
															swal("Operación exitosa!", "Contrato finalizado", "success");
															$("#modal-publicacion").modal('hide');
														}
													});
												}
											});
										}
									});
								}
							});
							break;
					}
				});
				$("#modal-publicacion").modal('show');
			}
			
		</script>

	</body>

</html>