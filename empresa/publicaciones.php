<?php
	session_start();
	if (isset($_SESSION["ctc"])) {
		if (!isset($_SESSION["ctc"]["empresa"])) {
			header("Location: ../");
		}
	} else {
		header("Location: acceder.php");
	}

	require_once('../classes/DatabasePDOInstance.function.php');

	$db = DatabasePDOInstance();

    $empresa_nueva = $db->getRow("SELECT id_imagen FROM empresas WHERE id=".$_SESSION['ctc']['empresa']['id']);
    $plan = $db->getRow("SELECT ep.id_plan, p.nombre FROM empresas_planes ep INNER JOIN planes p ON ep.id_plan = p.id WHERE ep.id_empresa=".$_SESSION['ctc']['empresa']['id']);

    if ($_SESSION['ctc']['type'] == 1) {
        $_SESSION['ctc']['plan']['id_plan'] = $plan['id_plan'];
        $_SESSION["ctc"]["plan"]["nombre"] = $plan['nombre'];
    }

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
		$disps = $db->getAll("SELECT id, nombre, nombre FROM disponibilidad");

	if($disps === false) {
		$disps = array();
	}

	//victor queries
	require('queries/queries.php');
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
			
			#tablaPostulados {
				width: 100% !important;
			} 

			.select_filtros
			{
				margin-bottom: 7px;padding-top: 0px;padding-bottom: 0px;
			}
			.color-link{
				color: #fff !important;
			}
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

	<body class="large-sidebar fixed-sidebar fixed-header skin-5">

<div id="modal-postulados" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
			<div class="modal-dialog modal-lg" style="width: 80%;">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h4 class="modal-title" id="titulo_postulados">
						
						</h4>

					</div>
					<div class="modal-body" id="cuerpo_de_modal">
                        <?php switch($plan['id_plan']):
                            case 1: ?>
                                <div class="alert alert-warning">
                                    <p><b>OJO!</b> Solo podrás visualizar maximo <b>10</b> postulantes para esta publicación. Para evitar esto te invitamos a mejor tu plan de servicios <a href="planes.php">Aquí</a>.</p>
                                </div>
                        <?php break; ?>

                        <?php case 2: // Plan Bronce?>
                                <div class="alert alert-warning">
                                    <p><b>OJO!</b> Solo podrás visualizar maximo <b>40</b> postulantes para esta publicación. Para evitar esto te invitamos a mejor tu plan de servicios <a href="planes.php">Aquí</a>.</p>
                                </div>
                        <?php break; ?>
                        <?php case 3: // Plan Plata?>
                                <div class="alert alert-warning">
                                    <p><b>OJO!</b> Solo podrás visualizar maximo <b>100</b> postulantes para esta publicación. Para evitar esto te invitamos a mejor tu plan de servicios <a href="planes.php">Aquí</a>.</p>
                                </div>
                        <?php break; ?>
                        <?php endswitch; ?>
 
						 
                       <div class="row" style="padding: 10px;padding-top: 0px;">
                       	<!--contenedor filtros-->
                       		<span style=" padding-bottom: 3px; float: right;font-size: 12px;padding-right: 10px;cursor: pointer;"  onClick="limpiarFiltros()"><strong><img src="img/eraser.png"> Limpiar filtros</strong></span>
                       	<div class="col-xs-12" style="border: 1px dashed #dbdbdb;padding: 0px;margin-bottom: 15px;">

                       		<div class="col-sm-12" style="padding: 0px;"><p style="background-color: #3e70c9;padding: 4px;text-align: center;color: #fff;"><strong>Busqueda avanzada</strong>                       
                       </p></div>
                       	 <div class="col-sm-12" style="padding: 0px;margin-bottom: 20px;">
                       	 	<div class="col-sm-2">
                       	 		<label>Sexo</label><br/>
                        	<select  onChange="filtrar(this.value,5)" class="_filtro form-control select_filtros" >
                        		<option value="">Ambos</option>
                        		<option value="1">Masculino</option>
                        		<option value="2">Femenino</option>
                        	</select>
                       	 	                      	
                        	<label>Calificación</label><br/>
                        	<select  onChange="filtrar(this.value,7)" class="_filtro form-control select_filtros" style="">
                        		<option value="">Todas</option>
								<option value="1" style="color: #ffde00;">★</option>
								<option value="2" style="color: #ffde00;">★★</option>
								<option value="3" style="color: #ffde00;">★★★</option>
								<option value="4" style="color: #ffde00;">★★★★</option>
								<option value="5" style="color: #ffde00;">★★★★★</option>


                        	</select>
								  
                        	</div> 

                        	<div class="col-sm-2">
                        	<label>Idioma</label><br/>
                        	<select onChange="filtrar(this.value,8)" name="select_idiomas" class="_filtro form-control select_filtros" >
                        	<option value="">Todos</option>
                        		<?php
                        			foreach ($datos_idiomas as $datos) {
                        				echo "<option value='".$datos["id"]."'>".$datos["nombre"]."</option>";
                        			}
                        		?>
                        	</select> 

                        	</div>
                        	<div class="col-sm-2">
                        	<label>Edad</label><br/>
                        	<select onChange="test(this.value)" id="edad" name="edad" class="_filtro form-control select_filtros" >
                        		<option value="">Todas</option>
                        		<option value="1823">De 18 a 23 años</option>
                        		<option value="2430">De 24 a 30 años</option>
                        		<option value="3136">De 31 a 36 años</option>
                        		<option value="3745">De 37 a 45 años</option>
                        	</select> 
                        </div>
                        <div class="col-sm-2">
                        		
                        	<label>Area de estudio</label><br/>
                        	<select onChange="filtrar(this.value,3)" id="area_estudio" class="_filtro form-control select_filtros" >
                        		<option value="">Todas</option>
                        		<?php
                        			foreach ($areas_estudio as $datos) {
                        				if($datos["nombre"]!=""){echo "<option value='".$datos["id_area"]."'>".$datos["nombre"]."</option>";} 
                        			}
                        		?>
                        	</select>
                        	
                        	
                        	</div>
                        	 
                        	<div class="col-sm-2">
                        	<label>Provincia</label><br/>
                        	<select onChange="filtrar(this.value,4)" id="select_provincias" name="provincias" class="_filtro form-control select_filtros" >
                        		<option value="">Todas</option>
                        		<?php
                        			foreach ($datos_provincias as $datos) {

                        				if($datos["provincia"]!=""){echo "<option value='".$datos["id"]."'>".$datos["provincia"]."</option>";} 
                        			}
                        		?>
                        	</select>                         
                        	</div>
                        	<div class="col-sm-2">
                        		<label>Remuneracion</label><br/>
                        	<select id="remuneracion" name="remuneracion" class="_filtro form-control select_filtros" >
                        		<option value="0">Todas</option>
                        		<option value="02000">$0 - $2000 </option>
                        		<option value="20015000">$2001 - $5000 </option>                           		
                        		<option value="500110000">$5001 - $10000 </option>   
                        		<option value="1000115000">$10001 - $15000 </option>   
                        		<option value="1500120000">$15001 - $20000 </option>   
                        		<option value="20001">$20000 o más</option>  
                        	</select>                         		
                        	</div> 
                        	<div class="col-sm-2"></div>
                        	<div class="col-sm-4" style="padding-left: 0px;padding-right: 0px; background-color: #f2f2f2;padding-bottom: 5px;">
                        		<p class="text-center"><strong>Experiencia laboral</strong></p>
                        		<div class="col-sm-12">
                        			<select onChange="filtrar(this.value,9)" id="actividad_empresa" name="actividad_empresa" class="_filtro form-control select_filtros" >
	                        		<option value="0">Actividad</option> 
                        		<?php
                        			foreach ($actividad_empresa as $datos) {
                        				if($datos["nombre"]!=""){echo "<option value='".$id["nombre"]."'>".$datos["nombre"]."</option>";}  
                        			}
                        		?>	                        		 
	                        	</select>  
                        		</div> 
                        	</div> 
                        	
                        	<div class="col-sm-2"></div>
                        	<div class="col-sm-2">                       	 
                        	   <label>Marcadores</label><br/>
	                        	<select onChange="filtrar(this.value,10)" class="_filtro form-control select_filtros" style="">
	                        		<option value="">Todos</option>
	                        		<option value="0">Descartados</option>
	                        		<option value="1">Contactado</option>
	                        		<option value="2">En proceso</option>
	                        		<option value="3">Evaluando</option>
	                        		<option value="4">Finalistas</option>
	                        		<option value="5">Contratados</option>									 
	                        	</select>   	 	              		
                        	</div>

                       	 </div>
                       	</div>
                       	<!-- fin contenedor filtros-->
						<div class="col-sm-12 table-responsive">
							<table id="tablaPostulados" class="table table-striped table-bordered dataTable">
							<thead>
								<tr>
									<th>#</th>
									<th style="padding: 0px;">Trabajador</th>
									 <th>Edad</th>
									  <th>aestudio</th>
									   <th>provincia</th>
									    <th>sexo</th>
									 <th>remuneracion</th>
									<th>calificacion</th>
									<th>idioma</th>
									<th>actividad</th>
									<th>Estado</th>
									<th>Fecha y hora</th>
									<th>Contactar</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
						</div>
                       </div> 
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
					</div>
				</div>
			</div>
		</div>
		<div class="wrapper">

			<!-- Preloader -->
			<div class="content-loader">
				<div class="preloader"></div>
			</div>

			<!-- Sidebar -->
			<?php //require_once('../includes/sidebar.php'); ?>

			<!-- Sidebar second -->
			<?php require_once('../includes/sidebar-second.php'); ?>

			<!-- Header -->
			<?php require_once('../includes/header.php'); ?>

			<div class="site-content" style="margin-left: 0px;">
				<!-- Content -->
				<div class="container-fluid">
				<?php if ($_SESSION['ctc']['type'] == 1):
					$grid = "col-md-9";
					require_once('../includes/sidebar.php');
					else:
					$grid = "container";
				?>
				<?php endif ?>
					<div class="<?php echo $grid?>">
						<div class="box box-block bg-white">
							<h5 class="m-b-1">Mis publicaciones</h5>
							<div class="mb-10">
	 <a href="#" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#modal-agregar-publicacion" id="agregar-publicacion"><span class="ti-plus"></span> Agregar</a>
								
							</div>
							<div class="table-responsive">
								<table class="table table-striped table-bordered dt-responsive responsive nowrap dataTable" id="tablaPublicaciones" style="width: 100%">
									<thead>
										<tr>
											<th>#</th>
											<th>Título</th>
											<th>Descripción</th>
											<th>Postulados</th>
											<th>Creación Pub.</th>
											<th>Final Pub.</th>
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
		
		<style>
			.controls {
			  margin-top: 10px;
			  border: 1px solid transparent;
			  border-radius: 2px 0 0 2px;
			  box-sizing: border-box;
			  -moz-box-sizing: border-box;
			  height: 32px;
			  outline: none;
			  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
			}
			
			.pac-container {
				/*display: block !important;*/
				z-index: 9999;
			}
		</style>
		
		<div class="modal fade" id="contactM" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title">Contacta al jobber</h4>
					</div>
					<div class="modal-body">
						<form>
							<div class="form-group">
								<label for="messageText" class="form-control-label">Escribe tu mensaje:</label>
								<textarea class="form-control" id="messageText"></textarea>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
						<button type="button" class="btn btn-primary" id="sendMesage">Enviar</button>
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
						<h4 class="modal-title">Agregar publicación</h4>
					</div>
					<div class="modal-body">
						<ul class="nav nav-tabs nav-tabs-2">
							<li class="nav-item">
								<a class="nav-link active" href="#modal-agregar-publicacion-info" data-toggle="tab"><i class="ti-info text-muted m-r-0-25"></i> Información</a>
							</li> 
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
									<div class="col-sm-4" style="padding-left: 0px;">
										<label for="select2-demo-3" class="form-control-label">Disponibilidad</label>
										<select id="select2-demo-3" class="form-control" data-plugin="select2">
											<?php foreach($disps as $disp): ?>
												<option value="<?php echo $disp["id"]; ?>"><?php echo $disp["nombre"]; ?></option>
											<?php endforeach ?>
										</select>
									</div>

									<div class="col-sm-4">
										<label for="select2-demo-3" class="form-control-label">Provincia</label>
										<select onChange="localidad(this.value)" id="provincias_select" class="form-control" data-plugin="select2">
										<option  value="0">Seleccionar</option>
											<?php foreach($provincias as $p): ?>
												<option value="<?php echo $p["id"]; ?>"><?php echo $p["provincia"]; ?></option>
											<?php endforeach ?>
										</select>
									</div>

									<div class="col-sm-4" style="padding-right: 0px;">
										<label for="select2-demo-3" class="form-control-label">Localidad</label>
										 <?php include('../select_localidades.php');?>
									</div>
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
									<label for="select2-demo-23" class="form-control-label">Disponibilidad</label>
									<select id="select2-demo-23" class="form-control" data-plugin="select2">
										<?php foreach($disps as $disp): ?>
											<option value="<?php echo $disp["id"]; ?>"><?php echo $disp["nombre"]; ?></option>
										<?php endforeach ?>
									</select>
								</div>
								<div class="form-group">
									<div class="col-sm-4" style="padding-left: 0px;">
										<label for="select2-demo-3" class="form-control-label">Disponibilidad</label>
										<select id="select2-demo-3" class="form-control" data-plugin="select2">
											<?php foreach($disps as $disp): ?>
												<option value="<?php echo $disp["id"]; ?>"><?php echo $disp["nombre"]; ?></option>
											<?php endforeach ?>
										</select>
									</div>

									<div class="col-sm-4">
										<label for="select2-demo-3" class="form-control-label">Provincia</label>
										<select onChange="modificar_localidad(this.value)" id="m_provincias_select" class="form-control" data-plugin="select2">
										<option  value="0">Seleccionar</option>
											<?php foreach($provincias as $p): ?>
												<option value="<?php echo $p["id"]; ?>"><?php echo $p["provincia"]; ?></option>
											<?php endforeach ?>
										</select>
									</div>

									<div class="col-sm-4" style="padding-right: 0px;">
										<label for="select2-demo-3" class="form-control-label">Localidad</label>
										 <?php include('../select_localidades_modificar.php');?>
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
						<!--
							  <div id="modal-modificar-publicacion-imagenes" class="tab-pane fade">
							<h3>Imágenes</h3>
						  </div>
						  <div id="modal-modificar-publicacion-videos" class="tab-pane fade">
							<h3>Videos</h3>
						  </div>
						-->
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" id="modal-modificar-publicacion-enviar-form">Aceptar</button>
						<button type="button" class="btn btn-primary" onClick="renovarPublicacion(this,'2')">Renovar Pub.</button>
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
		<script type="text/javascript" src="../vendor/dropify/dist/js/dropify.min.js"></script>
		<script type="text/javascript" src="../js/jquery.form.js"></script>		
		<!-- TinyMCE -->
		<script type="text/javascript" src="../vendor/tinymce/tinymce.min.js"></script>
		<script type="text/javascript" src="../vendor/tinymce/skins/custom/jquery.tinymce.min.js"></script>		
		<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCw69wIi6XSBIldqmZdoMnihzi-9pWvjeo&libraries=places"></script>

		<script>
			var map = null;
			var map2 = null;
			var marker = null;
			var marker2 = null;
			var latSelected = null;
			var lngSelected = null;
			var searchBox = null;
			var searchBox2 = null;
			var input = null;
			var input2 = null;
			var empresa_nueva = "<?= $empresa_nueva['id_imagen'] ?>";
			empresa_nueva = parseInt(empresa_nueva);
			/*function handleLocationError(browserHasGeolocation, infoWindow, pos) {
				marker = new google.maps.Marker({
					position: pos,
					map: map,
					title: 'Mi ubicación',
					  draggable: true
				});
			}
			function handleLocationError2(browserHasGeolocation, infoWindow, pos) {
				marker2 = new google.maps.Marker({
					position: pos,
					map: map,
					title: 'Mi ubicación',
					  draggable: true
				});
			}
			*/
			function geocodeLatLng(geocoder, map, marker) {
				var latlng = marker.getPosition();
				geocoder.geocode({
					'location': latlng
				}, function (results, status) {
					if (status === google.maps.GeocoderStatus.OK) {
						if (results[1]) {
							console.log(results[1].formatted_address);
						} else {
							console.log(latlng.lat() + ', ' + latlng.lng());
						}
					} else {
						console.log(latlng.lat() + ', ' + latlng.lng());
					}
				});
			}
			
			/*function initMap() {
				if(map == null) {
					map = new google.maps.Map(document.getElementById('map'), {
						center: {lat: -34.397, lng: 150.644},
						zoom: 6
					  });
					
					geocoder = new google.maps.Geocoder;
					
					input = (document.getElementById('modal-agregar-publicacion-ubicacion'));
					searchBox = new google.maps.places.SearchBox(input);

					  map.addListener('bounds_changed', function() {
						searchBox.setBounds(map.getBounds());
					  });
					
				  searchBox.addListener('places_changed', function() {
					var places = searchBox.getPlaces();

					if (places.length == 0) {
					  return;
					}

					var bounds = new google.maps.LatLngBounds();
					places.forEach(function(place) {
					  if (place.geometry.viewport) {
						// Only geocodes have viewport.
						bounds.union(place.geometry.viewport);
					  } 
					  marker.setPosition(place.geometry.location);
						latSelected = place.geometry.location.lat();
						lngSelected = place.geometry.location.lng();
					   map.setCenter(place.geometry.location);
					});
				});

				
			  // Try HTML5 geolocation.
			  if (navigator.geolocation) {
				navigator.geolocation.getCurrentPosition(function(position) {
				  var pos = {
					lat: position.coords.latitude,
					lng: position.coords.longitude
				  };
				  
				  marker = new google.maps.Marker({
					position: pos,
					map: map,
					title: 'Mi ubicación',
					  draggable: true
				  });
					
				  map.setCenter(pos);
					geocodeLatLng(geocoder, map, marker);
				  
					marker.addListener('dragend', function () {
						map.panTo(marker.getPosition());
						geocodeLatLng(geocoder, map, marker);
						var position = marker.getPosition();
						latSelected = position.lat();
						lngSelected = position.lng();
					});
				  map.addListener('click', function (e) {
					marker.setPosition(e.latLng);
					var position = marker.getPosition();
					latSelected = position.lat();
					lngSelected = position.lng();
					map.panTo(marker.getPosition());
					marker.setAnimation(google.maps.Animation.BOUNCE);
					geocodeLatLng(geocoder, map, marker);
					setTimeout(function () {
						marker.setAnimation(null);
					}, 1500);
				});
					
				}, function() {
				  handleLocationError(true, marker, map.getCenter());
				});
			  } else {
				// Browser doesn't support Geolocation
				handleLocationError(false, marker, map.getCenter());
			  }
				}
				else {
					google.maps.event.trigger(map, "resize");
				}
			  setTimeout(function () {
					google.maps.event.trigger(map, "resize");
				}, 2500);
			}*/
			
			function initMap2(coordenadas) {
				if(map2 == null) {
					map2 = new google.maps.Map(document.getElementById('map2'), {
						center: {lat: -34.397, lng: 150.644},
						zoom: 6
					  });
					
					geocoder = new google.maps.Geocoder;
					
					input2 = (document.getElementById('modal-modificar-publicacion-ubicacion'));
					searchBox2 = new google.maps.places.SearchBox(input2);

					  map2.addListener('bounds_changed', function() {
						searchBox2.setBounds(map2.getBounds());
					  });
					
					  searchBox2.addListener('places_changed', function() {
						var places = searchBox2.getPlaces();

						if (places.length == 0) {
						  return;
						}
						  
						  

						var bounds = new google.maps.LatLngBounds();
						places.forEach(function(place) {
						  if (place.geometry.viewport) {
							// Only geocodes have viewport.
							bounds.union(place.geometry.viewport);
						  } 
						  	//marker2.setPosition(place.geometry.location);
							latSelected = place.geometry.location.lat();
							lngSelected = place.geometry.location.lng();
						   map2.setCenter(place.geometry.location);
							});
						});

					if(coordenadas != "") {
						var coord = coordenadas.split(",");
						var pos = {
							lat: parseFloat(coord[0]),
							lng: parseFloat(coord[1])
						  };

						  marker2 = new google.maps.Marker({
							position: pos,
							map: map2,
							title: 'Mi ubicación',
							  draggable: true
						  });

						  map2.setCenter(pos);
							geocodeLatLng(geocoder, map2, marker2);

							marker2.addListener('dragend', function () {
								map2.panTo(marker2.getPosition());
								geocodeLatLng(geocoder, map2, marker2);
								var position = marker2.getPosition();
								latSelected = position.lat();
								lngSelected = position.lng();
							});
						  map2.addListener('click', function (e) {
							marker2.setPosition(e.latLng);
							var position = marker2.getPosition();
							latSelected = position.lat();
							lngSelected = position.lng();
							map2.panTo(marker2.getPosition());
							marker2.setAnimation(google.maps.Animation.BOUNCE);
							geocodeLatLng(geocoder, map2, marker2);
							setTimeout(function () {
								marker2.setAnimation(null);
							}, 1500);
						});
					}
					else {
						if (navigator.geolocation) {
							navigator.geolocation.getCurrentPosition(function(position) {
							  var pos = {
								lat: position.coords.latitude,
								lng: position.coords.longitude
							  };

							  marker2 = new google.maps.Marker({
								position: pos,
								map: map2,
								title: 'Mi ubicación',
								  draggable: true
							  });

							  map2.setCenter(pos);
								geocodeLatLng(geocoder, map2, marker2);

								marker2.addListener('dragend', function () {
									map2.panTo(marker2.getPosition());
									geocodeLatLng(geocoder, map);
									var position = marker2.getPosition();
									latSelected = position.lat();
									lngSelected = position.lng();
								});
							  map2.addListener('click', function (e) {
								marker2.setPosition(e.latLng);
								var position = marker2.getPosition();
								latSelected = position.lat();
								lngSelected = position.lng();
								map2.panTo(marker2.getPosition());
								marker2.setAnimation(google.maps.Animation.BOUNCE);
								geocodeLatLng(geocoder, map2, marker2);
								setTimeout(function () {
									marker2.setAnimation(null);
								}, 1500);
							});

							}, function() {
							  handleLocationError(true, marker2, map2.getCenter());
							});
						  } else {
							// Browser doesn't support Geolocation
							  							  
							handleLocationError(false, marker2, map2.getCenter());
						  }
					}
				
				}
				else {
					google.maps.event.trigger(map2, "resize");
				}
			  setTimeout(function () {
					google.maps.event.trigger(map2, "resize");
				}, 2500);
			}
			
			var idPub = 0;
			var sectores = <?php echo json_encode($sectores); ?>;
			$('.dropify').dropify();
			$("input[type=radio][name=opcion]").click(function() {
				if(this.value == 1) {
					$("#venta").css("display", "block");
					$("#video").css("display", "none");
				}
				else {
					$("#video").css("display", "block");
					$("#venta").css("display", "none");
				}
			});

			$("#agregar-publicacion").click(function(){
				if(empresa_nueva == 0){
					swal("Error!", "Lo sentimos! Debes colocar una nueva imagen de perfil que represente tu empresa para empezar a publicar.", "error");

					return false;
				}
			});
			
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
								$('#select2-demo-23').val(publicacion.disponibilidad).trigger('change');
								$("#modal-modificar-publicacion-titulo").val(publicacion.titulo);
								$("#modal-modificar-publicacion-ubicacion").val(publicacion.ubicacion);
								$("#m_provincias_select").val(publicacion.provincia);
								//$("#m_localidad_"+publicacion.provincia).show();
								m_id_campo_localidades=publicacion.provincia;
								modificar_localidad(publicacion.provincia);
								$("#m_localidad_"+publicacion.provincia).val(publicacion.localidad);

								tinyMCE.get('modal-modificar-publicacion-descripcion').setContent(publicacion.descripcion);
								var coordenadas = "";
								if(publicacion.coordenadas != "" && publicacion.coordenadas != null) {
									coordenadas = publicacion.coordenadas;
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
									} else {
										swal("ERROR!",json.msg, "error");
									}
									break;
							}
						}).fail(function(error){
							swal("ERROR!","Error al eliminar la publicación", "error");
						});
					}
				});
			}

			function renovarPublicacion(btn, band='1') {
				var $btn = $(btn);
				var $parent = $btn.closest('.acciones-publicacion');

				switch(band){
					case '1':
						idPub = $parent.attr('data-target');
						break;
				}
				
				swal({
				  title: "Renovar Publicación",
				  text: "Está seguro que desea renovar esta publicación?",
				  type: "info",
				  showCancelButton: true,
				  confirmButtonColor: "#3FC3EE",
				  confirmButtonText: "Aceptar",
				  cancelButtonText: "Cancelar",
				  closeOnConfirm: false
				});
				$(".show-swal2.visible .swal2-confirm").attr('data-action', 'renew');
				$(".show-swal2.visible .swal2-confirm").click(function() {
					if($(this).attr('data-action') == 'renew') {
						$(this).attr('data-action', '');
						$.ajax({
							url: 'ajax/publicaciones.php',
							type: 'GET',
							dataType: 'json',
							data: {
								op: 10,
								i: idPub
							}
						}).done(function(data, textStatus, jqXHR) {
							switch(jqXHR.status) {
								case 200:
									var json = JSON.parse(jqXHR.responseText);
									if(json.msg == 'OK') {
										swal("Operación exitosa!", "Se renovó la publicación y sus datos.", "success");
										tablaPublicaciones.ajax.reload();
										$("#modal-modificar-publicacion").modal('hide');
									} else {
										swal("ERROR!",json.msg, "error");
									}
									break;
							}
						}).fail(function(error){
							swal("ERROR!","Error al renovar la publicación", "error");
						});
					}
				});
			}

			function stopStartPub(btn, dataValue){
				var $btn = $(btn);
				var $parent = $btn.closest('.acciones-publicacion');
				idPub = $parent.attr('data-target');

				let mensaje = dataValue == 0 ? "¿Está seguro que desea detener la publicación en Jobbers?" : "¿Está seguro que desea volver a renaudar la publicación en Jobbers?";

				swal({
				  title: "Aplicar cambio",
				  text: mensaje,
				  type: "question",
				  showCancelButton: true,
				  confirmButtonColor: "#3FC3EE",
				  confirmButtonText: "Aceptar",
				  cancelButtonText: "Cancelar",
				  closeOnConfirm: false
				});

				$(".show-swal2.visible .swal2-confirm").attr({'data-action': 'update', 'data-value': dataValue});
				$(".show-swal2.visible .swal2-confirm").on("click",function() {
					if($(this).attr('data-action') == 'update') {
						let dataValue = $(this).attr('data-value');
						$(this).attr('data-action', '');
						$(this).attr('data-value', '');
						
						$.ajax({
							url: 'ajax/publicaciones.php',
							type: 'GET',
							dataType: 'json',
							data: {
								op: 11, 
								i: idPub, 
								valor: dataValue
							},
							success: function(response){
								if (response.msg == "OK") {
									swal("EXITO!", "Su actualización se ha aplicado correctamente.", "success");
									tablaPublicaciones.ajax.reload();
								} else {
									swal("ERROR!", response.msg, "error");
								}
							},
							error: function(error){
								console.log(error);
								swal("ERROR!", "Ha ocurrido un error en el proceso. Intentalo de nuevo por favor", "error");
							}
						});
					}
				});
			}

				
			var $tablaPublicaciones = jQuery("#tablaPublicaciones");

			var tablaPublicaciones = $tablaPublicaciones.DataTable( {
				"responsive": true,
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
					{ "width": "100px", "targets": 3 },
					{ "width": "100px", "targets": 4 },
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
			
			var $tablaPostulados = jQuery("#tablaPostulados");

			var tablaPostulados = $tablaPostulados.DataTable( {
				 "responsive": true,
				 "aoColumnDefs": [ 
					{ "visible": false, "targets": 2 },
					{ "visible": false, "targets": 3 }, 	
					{ "visible": false, "targets": 4 }, 	
					{ "visible": false, "targets": 5 }, 	
					{ "visible": false, "targets": 6 }, 	
					{ "visible": false, "targets": 7 }, 	
					{ "visible": false, "targets": 8 },
					{ "visible": false, "targets": 9 },
					{ "visible": false, "targets": 10 }, 	 	
 	

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
				"ajax": 'ajax/publicaciones.php?op=6&i=0'
		} );
		
			$("#sendMesage").click(function() {
					var message = $("#messageText").val();
					var id = $(this).attr("data-id");
					if(message != '') {
						$.ajax({
							type: 'GET',
							url: 'ajax/chat.php',
							dataType: 'json',
							data: {
								op: 5,
								idc: <?php echo $_SESSION["ctc"]["uid"]; ?>,
								idc2: id,
								msg: message,
								t: 1
							},
							success: function (response) {
								$("#messageText").val("");
								$("#contactM").modal("hide");
								if(response.msg == "OK") {
									swal({
										title: 'Operación exitosa!',
										text: 'Tu mensaje ha sido enviado satisfactoriamente.',
										confirmButtonClass: 'btn btn-primary btn-lg',
										buttonsStyling: false
									});
								}
							}
						});
					}
					else {
						swal({
							title: 'Información',
							text: 'Debe escribir el contenido de su mensaje.',
							confirmButtonClass: 'btn btn-primary btn-lg',
							buttonsStyling: false
						});
					}
				});
			
			$('#modal-postulados').on('show.bs.modal', function (e) {

				tablaPostulados.clear().draw();
			});
			$('#modal-postulados').on('show.bs.modal', function (e) {
				 
				$("#titulo_postulados").html($(e.relatedTarget).attr('value').toUpperCase());
				tablaPostulados.ajax.url('ajax/publicaciones.php?op=6&i=' + $(e.relatedTarget).attr('data-id'));
				tablaPostulados.ajax.reload(); 
			});
			
			function callEvent(element) {
				//console.log(element);
				$("#modal-postulados").modal("hide");
				$("#sendMesage").attr("data-id", $(element).attr("data-id"));
			}
			
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
					'insertdatetime  table contextmenu paste code'
				], //3 media 1 link image autolink
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

			$(document).on('focusin', function(e) { /* Para que funcione los modales de tinymce dentro de otro modal, en este caso, dentro de los modales de bootstrap*/
			    if ($(event.target).closest(".mce-window").length) {
			        e.stopImmediatePropagation();
			    }
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
			
			$('#select2-demo-3').select2({
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
			
			$('#select2-demo-23').select2({
				width: '100%'
			});
			var id_campo_localidades=0;
			var m_id_campo_localidades=0;
			$("#modal-agregar-publicacion-enviar-form").click(function() {
				 
				var idArea = $("#select2-demo-1").val();
				var idSector = $("#select2-demo-2").val();
				var idDisp = $("#select2-demo-3").val();
				var titulo = $("#modal-agregar-publicacion-titulo").val();
				var ubicacion = $("#modal-agregar-publicacion-ubicacion").val();
				var descripcion = tinyMCE.get('modal-agregar-publicacion-descripcion').getContent();
				if(titulo == '')
				{
					swal("Error!", "Debe agregar un titulo a la publicaición.", "error");
				}
				else if(descripcion == '') {
					swal("Error!", "Debe agregar un descripción a la publicaición.", "error");
				}
			 
				else if($("#provincias_select").val() == 0)
				{
					swal("Error!", "Debe seleccionar una provincia.", "error");
				}
				else if($("#localidad_"+id_campo_localidades).val()==0) {
					swal("Error!", "Debe seleccionar una localidad.", "error");
				} 

				else {

					$.ajax({
						url: 'ajax/publicaciones.php',
						type: 'GET',
						dataType: 'json',
						data: {op:9},
						success: function(response){
							if (response){
								if(response.msg == 'OK'){

									$.ajax({
										url: 'ajax/publicaciones.php',
										type: 'GET',
										dataType: 'json',
										data: {
											op: 1,
											info: JSON.stringify({
												area: idArea,
												sector: idSector,
												disponibilidad:idDisp,
												titulo: titulo,
												descripcion: descripcion,
												latitud: latSelected,
												longitud: lngSelected, 
												provincia:$("#provincias_select").val(),
												localidad:$("#localidad_"+id_campo_localidades).val()
											})
										},
										success: function(data){
										 
											if(data.msg == 'OK') {
													var publicacion = data.data.publicacion;
													$("#modal-agregar-publicacion").modal('hide');
													swal("Operación exitosa!", "Se agregó la publicación y sus datos.", "success");
													tablaPublicaciones.ajax.reload();
													latSelected = null;
													lngSelected = null;
											} else {
												swal("ERROR!", data.msg, "error");
											}
										},
										error: function(error){
											//console.log(error);
											swal("ERROR!", "Ha ocurrido un error. Por favor, vuelve a intentarlo", "error");
										}
									})

								} else {
									swal("INFORMACIÓN!", "Lo sentimos, pero ha sobrepasado el limites de publicaciones para este plan gratis (2 MAX.). Para seguir gozando de nuestros servicios le invitamos a suscribirse a un plan con mayores beneficios.", "info");
								}
							} else {
								swal("ERROR!", "Ha ocurrido un error. Por favor, vuelve a intentarlo", "error");
							}
						},
						error: function(error){
							swal("ERROR!", "Ha ocurrido un error. Por favor, vuelve a intentarlo", "error");
						}
					});

				}
			});
			
			$("#modal-modificar-publicacion-enviar-form").click(function() {
				 
				var idArea = $("#select2-demo-12").val();
				var idSector = $("#select2-demo-22").val();
				var idDisp = $("#select2-demo-23").val();
				var titulo = $("#modal-modificar-publicacion-titulo").val();
				var ubicacion = $("#modal-modificar-publicacion-ubicacion").val();


				var descripcion = tinyMCE.get('modal-modificar-publicacion-descripcion').getContent();
				
				if(titulo == '')
				{
					swal("Error!", "Debe agregar un titulo a la publicaición.", "error");
				}
				else if(descripcion == '') {
					swal("Error!", "Debe agregar un descripción a la publicaición.", "error");
				}
			 
				else if($("#m_provincias_select").val() == 0)
				{
					swal("Error!", "Debe seleccionar una provincia.", "error");
				}
				//
				else if($("#m_localidad_"+m_id_campo_localidades).val()==0) {
					swal("Error!", "Debe seleccionar una localidad.", "error");
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
								disponibilidad: idDisp,
								titulo: titulo,
								descripcion: descripcion,
								latitud: latSelected,
								longitud: lngSelected, 
								provincia:$("#m_provincias_select").val(),
								localidad:$("#m_localidad_"+m_id_campo_localidades).val()
							})
						},
						success: function(data){
							if(data.msg == 'OK') {
								var publicacion = data.data.publicacion;
								$("#modal-modificar-publicacion").modal('hide');
								swal("Operación exitosa!", "Se han modificado los datos de la publicación seleccionada.", "success");
								tablaPublicaciones.ajax.reload();
								latSelected = null;
								lngSelected = null;
							} else {
								swal("ERROR!", data.msg, "error");
								console.log(data.console);
							}
						},
						error: function(error){
							console.log(error);
							//swal("ERROR!", "Ha ocurrido un error. Por favor, vuelve a intentarlo", "error");
						}
					})
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

 	
 		function filtrar(valor,columna)
 		{	   tablaPostulados.ajax.reload();
 			   var table = $('#tablaPostulados').DataTable();
			   table.columns(columna).search(valor).draw(); 			 
 		}

 	
 		 
 		$(document).ready(function() {

 			//Filtrar salario
 			 tablaPostulados.ajax.reload();
 			$('#remuneracion').change( function() {        		 

 				$.fn.dataTable.ext.search.push(
		    	function( settings, data, dataIndex ) {
		    	var min = 0;
		        var max = 0;
		        var valor=$("#remuneracion").val();
		        var age = parseFloat( data[6] ) || 0; // use data for the age column
		    	if(valor=="02000")
		    	{
		    		var min = 0;
		       		var max =2000;
		    	}
		    	else if(valor=="20015000")
		    	{
					var min = 2001;
		       		var max =5000;
		    	}
		    	else if(valor=="500110000")
		    	{
					var min = 5001;
		       		var max =10000;
		    	}
		    	else if(valor=="1000115000")
		    	{
					var min = 10001;
		       		var max =15000;
		    	}
		    	else if(valor=="1500120000")
		    	{
					var min = 15001;
		       		var max =20000;
		    	}
		    	else if(valor=="20001")
		    	{
					var min = 20001;
		       		var max =100000;
		    	}
		    	else if(valor=="0")
		    	{
					return true;
		    	}		 
		        if ( ( isNaN( min ) && isNaN( max ) ) ||
		             ( isNaN( min ) && age <= max ) ||
		             ( min <= age   && isNaN( max ) ) ||
		             ( min <= age   && age <= max ) )
		        {
		            return true;
		        }
		        return false;
		    }
		);
 			var table = $('#tablaPostulados').DataTable();
		    table.draw();
		} );

 			//Filtrar la edad
 			$('#edad').change( function() { 
 			 tablaPostulados.ajax.reload();				
 				$.fn.dataTable.ext.search.push(
		    	function( settings, data, dataIndex ) {
		    	var min = 0;
		        var max = 0;
		        var valor=$("#edad").val();
		        var age = parseFloat( data[2] ) || 0; // use data for the age column
		    	if(valor=="1823")
		    	{
		    		var min = 18;
		       		var max =23;
		    	}
		    	else if(valor=="2430")
		    	{
					var min = 24;
		       		var max =30;
		    	}
		    	else if(valor=="3136")
		    	{
					var min = 31;
		       		var max =36;
		    	}
		    	else if(valor=="3745")
		    	{
					var min = 37;
		       		var max =45;
		    	}
		    	else if(valor=="")
		    	{
					var min = 0;
		       		var max =999;
		    	}		 
		        if ( ( isNaN( min ) && isNaN( max ) ) ||
		             ( isNaN( min ) && age <= max ) ||
		             ( min <= age   && isNaN( max ) ) ||
		             ( min <= age   && age <= max ) )
		        {
		            return true;
		        }
		        return false;
		    }
		);
 			var table = $('#tablaPostulados').DataTable();
		    table.draw();
		} );
		} ); 
		 		

 		function limpiarFiltros()
 		{   tablaPostulados.ajax.reload();
 			$("._filtro").prop('selectedIndex', 0);
 			 
 			 var table = $('#tablaPostulados').DataTable();
					table
					 .search( '' )
					 .columns().search( '' )
					 .draw();	
 		}
		</script>


		<script>
		contador=0;
		$( "#modal-postulados" ).mouseenter(  function (e) {
		 if(contador==0)
		 {  
		 	 tablaPostulados.ajax.reload();		  	 
		  	 contador=1;		  
		  	}
		}); 
		$( "#modal-postulados" ).mouseleave(function() {
		  contador=0;
		}); 
		</script>

		<script type="text/javascript">
			function localidad(par)
			{
				//alert("#localidad_"+par);
				id_campo_localidades=par;
				$(".select_localidad").hide();
				$("#localidad_"+par).show();
			}
			
			function modificar_localidad(par)
			{
				//alert("#localidad_"+par);
				m_id_campo_localidades=par;
				$(".m_select_localidad").hide();
				$("#m_localidad_"+par).show();
			}
		</script>
	</body>

</html>