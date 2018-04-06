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

	$sql="
	SELECT t1.id as id_publicacion,
	t2.verificado as verificado,  
	t2.nombre as nombre_empresa,
	concat('empresa/img/',t7.directorio,'/',t2.id_imagen,'.',t7.extension) as imagen_empresa,
	t1.descripcion as descripcion_publicacion,
	t1.titulo as titulo_publicacion, 
	t3.id_plan as plan,
	timestampdiff(month,t1.fecha_actualizacion,curdate()) as meses,
	timestampdiff(day,t1.fecha_actualizacion,curdate()) as dias,
	timestampdiff(year,t1.fecha_actualizacion,curdate()) as anos,
	t2.facebook,
	t2.instagram,
	t2.twitter,
	t2.linkedin,
	t8.provincia,
	t9.localidad,
	t1.fecha_actualizacion,
	t5.amigable as sector,
	t6.amigable as area,
	t1.amigable as publicacion,
	t4.id_sector,
	t2.id  as id_empresa
	from publicaciones t1 
	LEFT JOIN empresas t2 ON t1.id_empresa = t2.id
	LEFT JOIN empresas_planes t3 ON t1.id_empresa = t3.id_empresa

	LEFT JOIN provincias t8 ON t8.id = t1.provincia
	LEFT JOIN localidades t9 ON t9.id = t1.localidad

	LEFT JOIN publicaciones_sectores t4 ON t1.id=t4.id_publicacion
	LEFT JOIN areas_sectores t5 ON t4.id_sector=t5.id 
	LEFT JOIN areas t6 ON t5.id_area=t6.id 
	LEFT JOIN imagenes t7 ON t2.id_imagen=t7.id
	GROUP BY t1.id ORDER BY t3.id_plan DESC,t1.fecha_actualizacion DESC limit 0,4"

	;

	$datos_publicaciones = $db->getAll($sql);

	function formatDate($dateMayor, $dateMenor){
		$menor = new DateTime($dateMenor);
		$mayor = new DateTime(date($dateMayor));
		$intervalo = $mayor->diff($menor);

		if ($intervalo->format("%m") != 0) {
			$m = $intervalo->format("%m") == 1 ? "mes" : "meses";
			return $intervalo->format("Hace %m $m");
		} elseif ($intervalo->format("%a") != 0){
			$d = $intervalo->format("%a") == 1 ? "día" : "días";
			return $intervalo->format("Hace %a $d");
		} elseif ($intervalo->format("%h") != 0){
			$h = $intervalo->format("%h") == 1 ? "hora" : "horas";
			return $intervalo->format("Hace %h $h");
		} elseif ($intervalo->format("%i") != 0){
			return $intervalo->format("Hace %i min");
		} else {
			return $intervalo->format("Hace %s seg");
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
							<?php foreach ($datos_publicaciones as $pub): ?>
							<a href="empleos-detalle.php?a=<?= $pub["area"] ?>&s=<?= $pub["sector"] ?>&p=<?= $pub["publicacion"] ?>" class="list-group-item sidebar-index-hover" style="border: 1px solid #333695">
								<div class="media-left">
									<div class="avatar box-48">
										<img class="b-a-radius-0-125" src="<?= $pub["imagen_empresa"] ?>" alt="<?= $pub["nombre_empresa"] ?>">
									</div>
								</div>
								<div class="media-body">
									<p class="title-offer" style="padding-right: 35px;" title="<?= str_replace("\"","",$pub["titulo_publicacion"]) ?>"><?= $pub["titulo_publicacion"] ?></p>
									<p style="font-size: 12px; margin-bottom: 5px;"><i class="fa fa-map-marker"></i> &nbsp; <?= $pub["provincia"] ?> - <?= $pub["localidad"] ?></p>
									<p style="font-size: 12px;"><i class="fa fa-calendar"></i> &nbsp; <?= formatDate(date("Y-m-d H:i:s"), $pub["fecha_actualizacion"]) ?></p>
								</div>
							</a>
							<?php endforeach ?>
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