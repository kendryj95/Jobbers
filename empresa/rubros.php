<?php
	require_once('../classes/DatabasePDOInstance.function.php');

	$db = DatabasePDOInstance();

	$op = isset($_REQUEST["op"]) ? $_REQUEST["op"] : false;

	$rubroAgregado = false;
	$rubroModificado = false;

	if(!$op) {
		$rubros = $db->getAll("
			SELECT
				*
			FROM
				rubros
		");

		if($rubros === false) {
			$rubros = array();
		}
	}
	else {
		switch($op) {
			case 'agregar':
				if(isset($_REQUEST["agregar"])) {
					$nombre = isset($_REQUEST["rubroNombre"]) ? $_REQUEST["rubroNombre"] : false;
					if($nombre) {
						$db->query("
							INSERT INTO rubros (
								nombre,
								amigable,
								fecha_creacion,
								fecha_actualizacion
							)
							VALUES
							(
								'$nombre',
								'$nombre',
								'" . date('Y-m-d H:i:s') . "',
								'" . date('Y-m-d H:i:s') . "'
							)
						");
						$rubroAgregado = true;
					}
				}
				break;
			case 'modificar':
				$rubroAmigable = isset($_REQUEST["r"]) ? $_REQUEST["r"] : false;
				if($rubroAmigable) {
					$infoRubro = $db->getRow("
						SELECT
							*
						FROM
							rubros
						WHERE
							amigable = '$rubroAmigable'
					");
				}
				if(isset($_REQUEST["modificar"])) {
					$nombre = isset($_REQUEST["rubroNombre"]) ? $_REQUEST["rubroNombre"] : false;
					if($nombre) {
						$db->query("
							UPDATE rubros
								 SET nombre = '$nombre',
								 amigable = '$nombre',
								 fecha_actualizacion = '" . date('Y-m-d H:i:s') . "'
							WHERE
								amigable = '$rubroAmigable'
						");
						$infoRubro["nombre"] = $nombre;
						$infoRubro["amigable"] = $nombre;
						$rubroModificado = true;
					}
				}
				break;
		}
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
		<title>JOBBERS - Panel</title>
		<?php require_once('../includes/libs-css.php'); ?>
		<style>
			.modal.in.modal-agregar-rubro .modal-dialog {
				max-width: 400px;
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

			<!-- Preloader -->
			<div class="preloader"></div>

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
						
						<?php if($rubroAgregado): ?>
							<div class="alert alert-success-fill alert-dismissible fade in" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
								</button>
								<strong>Operación exitosa!</strong> El rubro ha sido agregado con éxito.
							</div>
						<?php elseif($rubroModificado): ?>
							<div class="alert alert-success-fill alert-dismissible fade in" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
								</button>
								<strong>Operación exitosa!</strong> El rubro ha sido modificado con éxito.
							</div>
						<?php endif ?>
						
						<?php if(!$op): ?>
						
							<div class="box box-block bg-white">
								<h5 class="m-b-1">Todos los rubros</h5>
								<div class="m-b-1">
									<a href="rubros.php?op=agregar" class="btn btn-primary waves-effect waves-light" ><span class="ti-plus"></span> Agregar</a>
								</div>
								<table class="table table-striped table-bordered dataTable" id="table-3">
									<thead>
										<tr>
											<th>Nombre</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										<?php foreach($rubros as $r): ?>
											<tr>
												<td><?php echo $r["nombre"]; ?></td>
												<td>
													<div class="btn-group btn-group-sm">
														<a href="rubros.php?r=<?php echo $r["amigable"]; ?>&op=modificar" class="btn btn-primary waves-effect waves-light"><span class="ti-pencil"></span></a>
														<a href="rubros.php?r=<?php echo $r["amigable"]; ?>&op=eliminar" class="btn btn-danger waves-effect waves-light"><span class="ti-close"></span></a>
											</div>
												</td>
											</tr>
										<?php endforeach ?>
									</tbody>
									<tfoot>
										<tr>
											<th>Nombre</th>
											<th></th>
										</tr>
									</tfoot>
								</table>
							</div>
						<?php elseif($op == 'agregar'): ?>
							<div class="box box-block bg-white">
								<h5 class="m-b-1">Agregar rubro</h5>
								<form id="formRubro" action="" method="post">
									<div class="hidden">
										<input type="hidden" name="agregar" value="1">
									</div>
									<div class="form-group">
										<label for="rubroNombre">Nombre</label>
										<input type="text" class="form-control" id="rubroNombre" name="rubroNombre">
									</div>
								</form>
								<a href="rubros.php" class="btn btn-secondary waves-effect waves-light">Regresar al listado de rubros</a>
								<a href="#" id="enviarFormRubro" class="btn btn-primary waves-effect waves-light pull-right">Aceptar</a>
							</div>
						<?php elseif($op == 'modificar'): ?>
							<div class="box box-block bg-white">
								<h5 class="m-b-1">Modificar rubro</h5>
								<form id="formRubro" action="" method="post">
									<div class="hidden">
										<input type="hidden" name="modificar" value="1">
									</div>
									<div class="form-group">
										<label for="rubroNombre">Nombre</label>
										<input type="text" class="form-control" id="rubroNombre" name="rubroNombre" value="<?php echo $infoRubro["nombre"]; ?>">
									</div>
								</form>
								<a href="rubros.php" class="btn btn-secondary waves-effect waves-light">Regresar al listado de rubros</a>
								<a href="#" id="enviarFormRubro" class="btn btn-primary waves-effect waves-light pull-right">Aceptar</a>
							</div>
						<?php endif ?>
					</div>
				</div>
				<!-- Footer -->
				<?php require_once('../includes/footer.php'); ?>
			</div>
		</div>
		<?php require_once('../includes/libs-js.php'); ?>

		<script>
			var $table3 = jQuery("#table-3");

			var table3 = $table3.DataTable( {
				aLengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
				buttons: [
					'copyHtml5',
					'excelHtml5',
					'csvHtml5',
					'pdfHtml5'
				],
				columnDefs: [
					{ width: 40, targets: [1] }
				],
				"language": {
					"columnDefs": [
						{ "width": 40, "targets": [1] }
					],
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
				}
			} );

			// Setup - add a text input to each footer cell
			$( '#table-3 tfoot th' ).each( function () {
				var $th = $('#table-3 thead th').eq( $(this).index() );
				var title = $th.text();
				if(title != '') {
					$(this).html( '<input type="text" class="form-control" placeholder="Buscar por ' + title + '" />' );
				}
			} );

			// Apply the search
			table3.columns().every( function () {
				var that = this;
				$( 'input', this.footer() ).on( 'keyup change', function () {
					if ( that.search() !== this.value ) {
						that
							.search( this.value )
							.draw();
					}
				} );
			});
			
			$("#enviarFormRubro").click(function() {
				var nombre = $("#rubroNombre").val();
				if(nombre == '') {
					alert("Debe ingresar algún nombre para el rubro.");
				}
				else {
					$("#formRubro").submit();
				}
			});
		</script>


	</body>

</html>