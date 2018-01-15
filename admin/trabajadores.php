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
		<title>JOBBERS - Trabajadores</title>
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
					<div class="card card-block">
						<div class="container-fluid">
							<div class="box box-block bg-white">
								<br>
								<h5 class="m-b-1">Mis trabajadores</h5>
								<br>
								<table class="table table-striped table-bordered dataTable" id="tablaCategorias">
									<thead>
										<tr>
											<th>#</th>
											<th>Nombre</th>
											<th>Correo electrónico</th>
											<th>Correo electrónico</th>
											<th>Fecha de registro</th>
											<th>Eliminar</th>
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
		

		<div id="modal-status-cv" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h4 class="modal-title">Status CV</h4>
					</div>
					<div class="modal-body">
							<table class="table table-striped table-bordered" id="statusCV">
								<tr>
									<td align="center">
										<b>Datos Personales</b>
									</td>
									<td id="DP">
										No aplica
									</td>
								</tr>
								<tr>
									<td align="center">
										<b>Experiencia laboral</b>
									</td>
									<td id="EL">
										No aplica
									</td>
								</tr>
								<tr>
									<td align="center">
										<b>Estudios</b>
									</td>
									<td id="E">
										No aplica
									</td>
								</tr>
								<tr>
									<td align="center">
										<b>Idiomas</b>
									</td>
									<td id="I">
										No aplica
									</td>
								</tr>
								<tr>
									<td align="center">
										<b>Otros Conocimientos</b>
									</td>
									<td id="OC">
										No aplica
									</td>
								</tr>
								<tr>
									<td></td>
									<td id="totalStatus">
										<b></b>
									</td>
								</tr>
								<tr>
									<td align="center" colspan="2">
										<button type="button" id="enviarMail" class="btn btn-primary">
											Enviar recordatorio por mail
										</button>
									</td>
								</tr>
							</table>
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
					"ajax": 'ajax/usuarios.php?op=6'
				} );
				

				$('#enviarMail').on('click', function () {
					
					$(this).text('Enviando...').prop('disabled',true);
					idPub = $(this).attr('data-target');
					
					$.ajax({
						type: 'GET',
						data: {op: 9, i: idPub},
						dataType: 'json',
						url: 'ajax/usuarios.php',
						success: function(response){
							if (response.msg == 'OK') {
								swal("Operación exitosa!", "Correo Enviado Satisfactoriamente", "success");
							} else {
								swal("Error!", "Ha ocurrido un error al enviar el mail. Intentelo más tarde", "warning");
							}

							$('#enviarMail').text('Enviar recordatorio por mail').prop('disabled',false);

						},
						error: function(error){
							console.log('Error en el ajax');
						}

					});
				});

			});
			
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
							data: 'op=7&i=' + idPub,
							dataType: 'json'
						}).done(function(data, textStatus, jqXHR) {
							switch(jqXHR.status) {
								case 200:
									var json = JSON.parse(jqXHR.responseText);
									if(json.msg == 'OK') {
										swal("Operación exitosa!", "Se eliminó el usuario.", "success");
										window.location.reload();
									}
									break;
							}
						});
					}
				});
			}
			
			function statusCV(btn){
				var $btn = $(btn);
				var $parent = $btn.closest('.acciones-categoria');
				idPub = $parent.attr('data-target');
				
				$.ajax({
					type: 'GET',
					data: {op: 8, i: idPub},
					dataType: 'json',
					url: 'ajax/usuarios.php',
					success: function(response){
						$('#statusCV #DP').text(response.DP+"% / 20%");
						$('#statusCV #EL').text(response.EL+"% / 20%");
						$('#statusCV #E').text(response.E+"% / 20%");
						$('#statusCV #I').text(response.I+"% / 20%");
						$('#statusCV #OC').text(response.OC+"% / 20%");

						var totalStatus = response.DP + response.EL + response.E + response.I + response.OC;

						$('#statusCV #totalStatus>b').text("Total: "+totalStatus+"%");
						
						$('#enviarMail').attr('data-target',idPub);

					},
					error: function(error){
						console.log('Ha ocurrido un error en el ajax');
					}
				});
				
				
				$("#modal-status-cv").modal('show');


			}
		</script>

	</body>

</html>