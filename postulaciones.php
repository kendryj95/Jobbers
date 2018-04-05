<?php
	session_start();
	if(isset($_SESSION['FBID'])) {
		$_SESSION['FBID'] = $fbid;           
		$_SESSION['FULLNAME'] = $fbfullname;
		$_SESSION['EMAIL'] =  $femail;
	}

	require_once('classes/DatabasePDOInstance.function.php');
	require_once('slug.function.php');

	$infoT = $_SESSION["ctc"];

	$db = DatabasePDOInstance();

	$areas = $db->getAll("
		SELECT
			id,
			nombre,
			amigable
		FROM
			areas
		ORDER BY
			nombre
	");

	/*$sectoresPrimeraArea = $db->getAll("
		SELECT
			nombre,
			amigable
		FROM
			areas_sectores
		WHERE
			id_area = " . $areas[0]["id"] . "
	");*/

	$momentos = array(
		array(
			"nombre" => "Últimas 24 horas",
			"amigable" => "ultimas-24-horas"
		),
		array(
			"nombre" => "Durante los últimos 3 días",
			"amigable" => "durante-los-ultimos-3-dias"
		),
		array(
			"nombre" => "Durante la última semana",
			"amigable" => "durante-la-ultima-semana"
		),
		array(
			"nombre" => "Durante las ultimas 2 semanas",
			"amigable" => "durante-las-ultimas-2-semanas"
		),
		array(
			"nombre" => "Hace un mes o menos",
			"amigable" => "hace-un-mes-o-menos"
		)
	);
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
		<title>JOBBERS - Postulaciones realizadas</title>

		<?php require_once('includes/libs-css.php'); ?>
		<link rel="stylesheet" href="vendor/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">
		<link rel="stylesheet" href="vendor/select2/dist/css/select2.min.css">
		<link rel="stylesheet" href="vendor/waves/waves.min.css">
		<link rel="stylesheet" href="vendor/ionicons/css/ionicons.min.css">
		<link href="https://fonts.googleapis.com/css?family=Exo+2" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Quattrocento:400,700" rel="stylesheet">
		
		<!-- DataTables modificadas -->
		<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/jszip-2.5.0/dt-1.10.16/b-1.4.2/b-colvis-1.4.2/b-flash-1.4.2/b-html5-1.4.2/b-print-1.4.2/datatables.min.css"/> -->
		
		<!-- DataTables Sencillas -->
		<!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css"> -->
		
		<link rel="stylesheet" href="vendor/DataTables/css/dataTables.bootstrap4.min.css">
		<link rel="stylesheet" href="vendor/DataTables/Responsive/css/responsive.bootstrap4.min.css">
		<link rel="stylesheet" href="vendor/DataTables/Buttons/css/buttons.dataTables.min.css">
		<link rel="stylesheet" href="vendor/DataTables/Buttons/css/buttons.bootstrap4.min.css">

		<style>
			th.dt-center, td.dt-center { text-align: center; }
			table.dataTable thead .sorting:before, table.dataTable thead .sorting_asc:before, table.dataTable thead .sorting_desc:before, table.dataTable thead .sorting_asc_disabled:before, table.dataTable thead .sorting_desc_disabled:before{
				content: "";
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
	<body class="large-sidebar fixed-sidebar fixed-header bg-white">
		<!-- <div class="wrapper bg-white"> -->

			<!-- Sidebar second -->
			<?php require_once('includes/sidebar-second.php'); ?>
			
			<!-- Header -->
			<?php require_once 'includes/header.php'; ?>
					
			
			<div style="padding: 0px 25px; margin-top: 85px;">
				<div class="col-md-3" >
					<div id="caja-flotante" >
						<h3 class="text-center title-rightbar" style="margin-top: 10px; font-family: 'Quattrocento', serif;">Top 4 Ofertas publicadas <i class="fa fa-newspaper-o"></i></h3>
						<div class="list-group">
							<a href="#" class="list-group-item sidebar-index-hover" style="border: 1px solid #333695">
								<div class="media-left">
									<div class="avatar box-48">
										<img class="b-a-radius-0-125" src="empresa/img/profile/1784.jpg" alt="">
									</div>
								</div>
								<div class="media-body">
									<p class="title-offer" style="padding-right: 35px;" title="<?= str_replace("\"","",$noticia["titulo"]) ?>">RH Master Selecciona COORDINADOR DE OPERACIONES</p>
									<p style="font-size: 12px; margin-bottom: 5px;"><i class="fa fa-map-marker"></i> &nbsp Cordoba - Cordoba Capital</p>
									<p style="font-size: 12px;"><i class="fa fa-calendar"></i> &nbsp Hoy</p>
								</div>
							</a>
							<a href="#" class="list-group-item sidebar-index-hover" style="border: 1px solid #333695">
								<div class="media-left">
									<div class="avatar box-48">
										<img class="b-a-radius-0-125" src="empresa/img/profile/1784.jpg" alt="">
									</div>
								</div>
								<div class="media-body">
									<p class="title-offer" style="padding-right: 35px;" title="<?= str_replace("\"","",$noticia["titulo"]) ?>">Editores de diarios /Revistas de barrio</p>
									<p style="font-size: 12px; margin-bottom: 5px;"><i class="fa fa-map-marker"></i> &nbsp Cordoba - Cordoba Capital</p>
									<p style="font-size: 12px;"><i class="fa fa-calendar"></i> &nbsp Hoy</p>
								</div>
							</a>
							<a href="#" class="list-group-item sidebar-index-hover" style="border: 1px solid #333695">
								<div class="media-left">
									<div class="avatar box-48">
										<img class="b-a-radius-0-125" src="empresa/img/profile/1784.jpg" alt="">
									</div>
								</div>
								<div class="media-body">
									<p class="title-offer" style="padding-right: 35px;" title="<?= str_replace("\"","",$noticia["titulo"]) ?>">RH Master Selecciona Supervisor General/Jefe de Operaciones/ Gerente</p>
									<p style="font-size: 12px; margin-bottom: 5px;"><i class="fa fa-map-marker"></i> &nbsp Cordoba - Cordoba Capital</p>
									<p style="font-size: 12px;"><i class="fa fa-calendar"></i> &nbsp Hoy</p>
								</div>
							</a>
							<a href="#" class="list-group-item sidebar-index-hover" style="border: 1px solid #333695">
								<div class="media-left">
									<div class="avatar box-48">
										<img class="b-a-radius-0-125" src="empresa/img/profile/1784.jpg" alt="">
									</div>
								</div>
								<div class="media-body">
									<p class="title-offer" style="padding-right: 35px;" title="<?= str_replace("\"","",$noticia["titulo"]) ?>">Operador de venta telefonica - Pila o Por mi en Córdoba - Telenik SA</p>
									<p style="font-size: 12px; margin-bottom: 5px;"><i class="fa fa-map-marker"></i> &nbsp Cordoba - Cordoba Capital</p>
									<p style="font-size: 12px;"><i class="fa fa-calendar"></i> &nbsp Hoy</p>
								</div>
							</a>
						</div>
					</div>
				</div>
				<div class="col-md-9" style="margin-bottom: 35px;">
					<div class="card">
						<h4 class="card-header text-uppercase text-center title-rightbar" style="font-size: 24px; margin-bottom: 30px; font-family: 'Quattrocento', serif;">Postulaciones realizadas</h4>

						<div class="card-block table-responsive">
							<table id="tablaPostulaciones" class="table table-striped table-bordered" cellspacing="0" width="100%">
								<thead>
									<tr class="info">
										<th><i class="fa fa-hashtag"></i></th>
										<th>Estado <i class="fa fa-question-circle"></i></th>
										<th>Empresa <i class="fa fa-industry"></i></th>
										<th>Anuncio <i class="fa fa-exclamation-circle"></i></th>
										<th>Fecha-Hora <i class="fa fa-clock-o"></i></th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>

					</div>
				</div>
			</div>

			<div class="col-md-12">
				<?php require_once('includes/footer.php'); ?>
			</div>

			<br>
		
			

		<!-- </div> -->

		<!-- Vendor JS -->
		<script type="text/javascript" src="vendor/jquery/jquery-1.12.3.min.js"></script>
		<script type="text/javascript" src="vendor/tether/js/tether.min.js"></script>
		<script type="text/javascript" src="vendor/bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="vendor/detectmobilebrowser/detectmobilebrowser.js"></script>
		<script type="text/javascript" src="vendor/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
		<script type="text/javascript" src="vendor/select2/dist/js/select2.min.js"></script>
		<script type="text/javascript" src="vendor/waves/waves.min.js"></script>
		<script type="text/javascript" src="vendor/waypoints/lib/jquery.waypoints.min.js"></script>
		<script type="text/javascript" src="vendor/owl.carousel/owl.carousel.min.js"></script>
		
		<script type="text/javascript" src="vendor/DataTables/js/jquery.dataTables.min.js"></script>
		<script type="text/javascript" src="vendor/DataTables/js/dataTables.bootstrap4.min.js"></script>
		<script type="text/javascript" src="vendor/DataTables/Responsive/js/dataTables.responsive.min.js"></script>
		<script type="text/javascript" src="vendor/DataTables/Responsive/js/responsive.bootstrap4.min.js"></script>
		
		<!-- DataTable modificada con botones -->
		<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
		<script type="text/javascript" src="https://cdn.datatables.net/v/bs/jszip-2.5.0/dt-1.10.16/b-1.4.2/b-colvis-1.4.2/b-flash-1.4.2/b-html5-1.4.2/b-print-1.4.2/datatables.min.js"></script> -->
		<!-- DataTable sencilla -->
		<!-- <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script> -->
		
		<!-- Neptune JS -->
		<script type="text/javascript" src="js/frontend2.js"></script>
		<script>
			$(document).ready(function() {
				var $tablaPostulaciones = jQuery("#tablaPostulaciones");

				var tablaPostulaciones = $tablaPostulaciones.DataTable( {
					"responsive": true,
					"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
					"aoColumnDefs": [
						{ "width": "80px", "targets": 0 },
						{ "width": "120px", "targets": 1 },
						{ "width": "200px", "targets": 2 },
						{ "width": "150px", "targets": 4 },
						{"className": "dt-center", "targets": [0, 1, 2, 3, 4]}
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
					"ajax": 'ajax/misc.php?op=3&idt=' + <?php echo $infoT["id"]; ?>
				} );
				
			});
		</script>
	</body>
</html>