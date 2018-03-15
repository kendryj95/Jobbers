<?php
	session_start();
	if(!isset($_SESSION["ctc"])) {
		header("Location: index.php");
	} else {
		if ($_SESSION["ctc"]["type"] != 3 || isset($_SESSION["ctc"]["empresa"])) {
			header("Location: ../");
		} elseif ($_SESSION["ctc"]["rol"] == "N") {
			header("Location: mis-noticias.php");
		} 
	}
	require_once('../classes/DatabasePDOInstance.function.php');
	$db = DatabasePDOInstance();

	function statusCV($db, $id){
		# STATUS DE DATOS PERSONALES

		$contadorDatosP = 0;
		$datos_personales = $db->getRow("SELECT * FROM trabajadores WHERE id=".$id);
		$totalDatosP = 14;
		$contadorDatosP += $datos_personales['telefono'] != '' ? 13 : 0;
		$contadorDatosP += $datos_personales['id_imagen'] != 0 ? 1 : 0;

		$statusDP = ($contadorDatosP * 33.33) / $totalDatosP;
		$valDP = ceil($statusDP);

		# STATUS NIVEL DE ESTUDIOS

		$cantidades = $db->getRow("SELECT
		(SELECT COUNT(*) FROM trabajadores_educacion INNER JOIN paises ON paises.id=trabajadores_educacion.id_pais INNER JOIN nivel_estudio ON nivel_estudio.id=trabajadores_educacion.id_nivel_estudio INNER JOIN areas_estudio ON areas_estudio.id=trabajadores_educacion.id_area_estudio INNER JOIN estado_estudio ON estado_estudio.id=trabajadores_educacion.id_estado_estudio WHERE trabajadores_educacion.id_trabajador=$id) AS cant_estudio,
	    (SELECT COUNT(*) FROM trabajadores_idiomas INNER JOIN idiomas ON idiomas.id=trabajadores_idiomas.id_idioma WHERE trabajadores_idiomas.id_trabajador=$id) AS cant_idiomas");

		$contadorEduc = $cantidades['cant_estudio'] != 0 ? 1 : 0;
		$totalEduc = 1;

		$statusEduc = ($contadorEduc * 33.33) / $totalEduc;
		$valEduc = ceil($statusEduc);
		
		# STATUS IDIOMAS
		
		$contadorIdioma = $cantidades['cant_idiomas'] != 0 ? 1 : 0;
		$totalIdioma = 1;

		$statusIdioma = ($contadorIdioma * 33.33) / $totalIdioma;
		$valIdioma = ceil($statusIdioma);

		$total = $valDP + $valEduc + $valIdioma;


		return ($total > 100 ? 100 : $total);
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
		<title>JOBBERS - Trabajadores por Busqueda</title>
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
							<div class="container-fluid">
								<div class="box box-block bg-white">
									<br>
									<h5 class="m-b-1">Buscar trabajador</h5>
									<br>


									<div class="input-group">
									  <input type="text" class="form-control" placeholder="Por correo electronico (*)" id="email_trab">
									  <div class="input-group-btn">
										<button class="btn btn-primary" id="search_trab"><i class="fa fa-search"></i> Buscar</button>
									  </div>
									</div>

									<div id="containerDatos" style="margin-top: 20px">
										
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
										<b>Experiencia laboral <span class="text-muted">(Opcional)</span></b>
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
										<b>Otros Conocimientos <span class="text-muted">(Opcional)</span></b>
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
		<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
		<script type="text/javascript" src="../vendor/DataTables/Buttons/js/buttons.bootstrap4.min.js"></script>
		<script type="text/javascript" src="../vendor/DataTables/JSZip/jszip.min.js"></script>
		<script type="text/javascript" src="../vendor/DataTables/pdfmake/build/pdfmake.min.js"></script>
		<script type="text/javascript" src="../vendor/DataTables/pdfmake/build/vfs_fonts.js"></script>
		<script type="text/javascript" src="../vendor/DataTables/Buttons/js/buttons.html5.min.js"></script>
		<script type="text/javascript" src="../vendor/DataTables/Buttons/js/buttons.print.min.js"></script>
		<script type="text/javascript" src="../vendor/DataTables/Buttons/js/buttons.colVis.min.js"></script>		
		<script type="text/javascript" src="../vendor/select2/dist/js/select2.min.js"></script>
		<script type="text/javascript" src="../vendor/dropify/dist/js/dropify.min.js"></script>
		<script type="text/javascript" src="../js/jquery.form.js"></script>

		<script>
			var idNoticia = 0;
			$(document).ready(function(){
				var idPub = 0;
				var idRow = '';

				setTimeout(function() {
					$('.preloader').fadeOut();
				}, 500);
				setTimeout(function() {
					$('.content-loader').fadeOut();
				}, 500);

				$('#search_trab').on('click', function(){

					var html = '';

					if ($('#email_trab').val() != "") {
						if (isEmail($('#email_trab').val())) {

							$.ajax({
								url: 'ajax/usuarios.php',
								type: 'GET',
								dataType: 'json',
								data: {
									op: 10,
									email: $('#email_trab').val()
								},
								beforeSend: function(){
									$('.preloader').show();
									$('.content-loader').show();
								},
								success: function(response){
									if (response.status == 200) {
										if (response.t != 1) {
											html += '<table class="table table-striped table-bordered">'+
											'<tr>'+
											'<th>#</th><th>Nombre</th><th>Correo Electronico</th><th>Contacto</th><th>Fecha de registro</th><th>% CV</th><th>Acciones</th>'+
											'<tr>'+
											'<td>1</td><td>'+response.data.trabajador.nombres+'</td><td>'+response.data.trabajador.correo+'</td><td>'+response.data.trabajador.telefono+'</td><td>'+response.data.trabajador.fecha_creacion+'</td><td>'+response.data.statusCV+'</td><td><div class="acciones-categoria" data-target="'+response.data.trabajador.id+'"><button type="button" class="accion-categoria btn btn-success waves-effect waves-light" title="Ver status CV" onclick="statusCV(this);"><span class="ti-file	"></span></button> <button type="button" class="accion-categoria btn btn-danger waves-effect waves-light" title="Eliminar Trabajador" onclick="eliminarCategoria(this);"><span class="ti-close"></span></button> </div></td>'
											+'</tr>'
											+'</tr>'
											+'</table>';
											$('#containerDatos').html(html);
										} else {
											swal("No encontrado!", "Lo sentimos, el trabajador que ud ha buscado no existe.", "info");
										}
									} else {
										swal("ERROR!", "Lo sentimos, ha ocurrido un error. Por favor verifica su conexión a internet e intenlo de nuevo", "error");
									}
								},
								error: function(error){
									swal("ERROR!", "Lo sentimos, ha ocurrido un error. Por favor verifica su conexión a internet e intenlo de nuevo", "error");
								},
								complete: function(){
									$('.preloader').fadeOut();
									$('.content-loader').fadeOut();
								}
							});
							
						} else {
							swal("ERROR!", "El correo electronico no es valido.", "error");
						}
					} else {
						swal("Vacío!", "No puedes dejar vacío el campo.", "warning");
					}

				});


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
										setTimeout(function(){

											window.location.reload();
										}, 1000);
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

			function isEmail(email) {
			  var regex = /^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/;
			  let correo = email.toLowerCase().trim();
			  return regex.test(correo);
			}
		</script>

	</body>

</html>