<?php
session_start();
if (!isset($_SESSION["ctc"]["id"])) {
    header("Location: ./");
}
require_once 'classes/DatabasePDOInstance.function.php';
$db        = DatabasePDOInstance();
$data      = $db->getRow("SELECT *, TIMESTAMPDIFF(YEAR,fecha_nacimiento,CURDATE()) AS edad FROM trabajadores WHERE id=" . $_SESSION["ctc"]["id"]);
$infoExtra = $db->getRow("SELECT * FROM trabajadores_infextra WHERE id_trabajador =" . $_SESSION['ctc']['id']);
$experiencias = $db->getAll("SELECT trabajadores_experiencia_laboral.*, paises.nombre as nombre_pais, actividades_empresa.nombre as actividad_empresa FROM trabajadores_experiencia_laboral INNER JOIN paises ON paises.id=trabajadores_experiencia_laboral.id_pais INNER JOIN actividades_empresa ON actividades_empresa.id=trabajadores_experiencia_laboral.id_actividad_empresa WHERE trabajadores_experiencia_laboral.id_trabajador = " . $_SESSION['ctc']['id']);
$educacion = $db->getAll("SELECT trabajadores_educacion.*, paises.nombre as nombre_pais, nivel_estudio.nombre as nivel, areas_estudio.nombre as nombre_estudio, estado_estudio.nombre as estado_estudio FROM trabajadores_educacion INNER JOIN paises ON paises.id=trabajadores_educacion.id_pais INNER JOIN nivel_estudio ON nivel_estudio.id=trabajadores_educacion.id_nivel_estudio INNER JOIN areas_estudio ON areas_estudio.id=trabajadores_educacion.id_area_estudio INNER JOIN estado_estudio ON estado_estudio.id=trabajadores_educacion.id_estado_estudio WHERE trabajadores_educacion.id_trabajador=".$_SESSION["ctc"]["id"]);
$idiomasT = $db->getAll("SELECT trabajadores_idiomas.*, idiomas.nombre as nombre_idioma FROM trabajadores_idiomas INNER JOIN idiomas ON idiomas.id=trabajadores_idiomas.id_idioma WHERE trabajadores_idiomas.id_trabajador=".$_SESSION["ctc"]["id"]);

$attr      = '';
$attr2      = '';
$attr3     = '';
$attr4      = '';
$attr5      = '';
$attr6      = '';
if ($data["id_sexo"] == 0 || $data["id_estado_civil"] == 0 || $data["id_tipo_documento_identificacion"] == 0 || $data["id_pais"] == 0 || $data["provincia"] == "" || $data["localidad"] == "" || $data["calle"] == "" || $data["nombres"] == "" || $data["apellidos"] == "" || $data["numero_documento_identificacion"] == "" || $data["fecha_nacimiento"] == "" || $data["telefono"] == "" || $data["correo_electronico"] == "") {
    $attr = 'disabled';
} else {
	
	if (!$educacion) {
		$attr3 = 'disabled';
	}
	
	if (!$idiomasT) {
		$attr4 = 'disabled';
	}
	if (!$infoExtra) {
		$attr6 = 'disabled';
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
		<title>JOBBERS - Mi cuenta</title>
		<?php require_once 'includes/libs-css.php';?>
		<link rel="stylesheet" href="vendor/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
		<link rel="stylesheet" href="vendor/bootstrap-daterangepicker/daterangepicker.css">
		<!-- FIXME: Resolver lo del bootstra-slider que no esta entre los archivos. Lo puse como cdn -->
		<!-- <link rel="stylesheet" href="vendor/bootstrap-slider/dist/css/bootstrap-slider.min.css"> -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.0.0/css/bootstrap-slider.min.css">
		<link rel="stylesheet" href="vendor/bootstrap-switch-master/dist/css/bootstrap3/bootstrap-switch.min.css">

		<style>
			.modal.in.modal-agregar-rubro .modal-dialog {
				max-width: 400px;
			}
			.disabled {
				pointer-events: none;
			}
			#ex1Slider .slider-selection {
				background: #BABABA;
			}
			#mobileText {
				display: none;
			}
			@media screen and (max-width:769px) {
				.show {
					opacity: .9;
				}
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

	<body class="large-sidebar fixed-sidebar fixed-header">

		<!-- <div class="wrapper"> -->

			<!-- Preloader -->
			<div class="content-loader">
				<div class="preloader"></div>
			</div>

			<!-- Sidebar -->
			<?php //require_once 'includes/sidebar.php';?>

			<!-- Sidebar second -->
			<?php require_once 'includes/sidebar-second.php';?>

			<!-- Header -->
			<?php require_once 'includes/header.php';?>

			<div class="container bg-white">
				<!-- Content -->
				<div class="content-area p-y-1">
					<div class="container-fluid">
						<h4>Mi currículum</h4>
						<ol class="breadcrumb no-bg m-b-1">
							<li class="breadcrumb-item"><a href="./">Inicio</a></li>
							<li class="breadcrumb-item"><a href="cuenta.php">Mi cuenta</a></li>
							<li class="breadcrumb-item active">Mi currículum</li>
						</ol>
						<div class="card card-block">
							<div class="row">
							<ul class="nav nav-tabs nav-tabs-2" role="tablist">
								<li class="nav-item">
									<a class="nav-link active" data-toggle="tab" href="#tab1" role="tab">Datos personales</a>
								</li>
								<li class="nav-item">
									<a id="experiencia" class="nav-link <?php echo $attr." ".$attr2; ?>" data-toggle="tab" href="#tab2" role="tab">Experiencia laboral</a>
								</li>
								<li class="nav-item">
									<a class="nav-link <?php echo $attr." ".$attr3; ?>" data-toggle="tab" href="#tab3" role="tab">Estudios</a>
								</li>
								<li class="nav-item">
									<a class="nav-link <?php echo $attr." ".$attr4; ?>" data-toggle="tab" href="#tab4" role="tab">Idiomas</a>
								</li>
								<li class="nav-item">
									<a class="nav-link <?php echo $attr; ?>" data-toggle="tab" href="#tab5" role="tab">Otros conocimientos</a>
								</li>
								<li class="nav-item">
									<a class="nav-link <?php echo $attr." ".$attr6; ?>" data-toggle="tab" href="#tab6" role="tab">Información Extra</a>
								</li>
								<li class="nav-item">
									<a class="nav-link <?php echo $attr; ?>" data-toggle="tab" href="#tab7" role="tab">Vista previa</a>
								</li>
							</ul>
							<div class="tab-content">
								<div class="tab-pane active" id="tab1" role="tabpanel">
									<br><br>

									<!-- Paso 1 - Datos de contacto -->
									<h4 style="border-bottom: 1px solid #3e70c9;margin-left: 25px;margin-right: 25px;margin-bottom: 25px;padding-bottom: 5px;">Paso 1: Datos de contacto</h4>
									<p class="text-muted text-center" style="margin-left: 25px;margin-right: 25px; text-align: justify;">Completa los pasos para llenar tu currículum y podrás aparecer como candidato para la empresas. Recuerda que los campos marcados con (*) son obligatorios</p>
									<div class="row">
										<div class="col-md-8 col-md-offset-2">
											<div class="form-group row">
												<label for="name" class="col-xs-12 col-md-2 text-center">Nombre <span style="color: red;">*</span></label>
												<div class="col-xs-12 col-md-10">
													<input class="form-control" value="<?php echo $data["nombres"]; ?>" id="name" type="text">
												</div>
											</div>
											<div class="form-group row">
												<label for="lastName" class="col-xs-12 col-md-2 text-center">Apellido <span style="color: red;">*</span></label>
												<div class="col-xs-12 col-md-10">
													<input class="form-control" value="<?php echo $data["apellidos"]; ?>" id="lastName" type="text">
												</div>
											</div>
											<div class="form-group row">
												<label for="email" class="col-xs-12 col-md-2 text-center">Email <span style="color: red;">*</span></label>
												<div class="col-xs-12 col-md-10">
													<input class="form-control" value="<?php echo $data['correo_electronico'] ?>" id="email" type="email" onchange="validar(this.id,'email')">
												</div>
											</div>
		  									<div class="form-group row">
												<label class="custom-control custom-radio col-md-2 col-xs-12 text-center">
													<span class="custom-control-description">Sexo <span style="color: red;">*</span></span>
												</label>
												<label class="custom-control custom-radio col-md-5 col-xs-6">
													<input checked id="radio1" name="sex" class="custom-control-input" type="radio" value="2">
													<span class="custom-control-indicator"></span>
													<span class="custom-control-description">Femenino</span>
												</label>
												<label class="custom-control custom-radio col-md-5 col-xs-6">
													<input id="radio2" name="sex" class="custom-control-input" type="radio" value="1">
													<span class="custom-control-indicator"></span>
													<span class="custom-control-description">Masculino</span>
												</label>
											</div>
											<div class="form-group row">
												<div class="col-xs-12 col-md-2 text-center">
													<label for="" class="col-form-label">Fecha de nacimiento <span style="color: red;">*</span></label>
												</div>
												<div class="col-xs-12 col-md-10 no-padding">
													<div class="col-xs-4">
														<select name="" id="dia" class="custom-select form-control">
															<option value="0">Seleccionar</option>
															<?php for ($i = 1; $i <= 31; $i++): ?>
																<option value="<?=$i < 10 ? '0' . $i : $i?>"><?=$i?></option>
															<?php endfor;?>
														</select>
													</div>

		  											<div class="col-xs-4">
														<select name="" id="mes" class="custom-select form-control">
															<option value="0">Seleccionar</option>
															<option value="01">Ene</option>
															<option value="02">Feb</option>
															<option value="03">Mar</option>
															<option value="04">Abr</option>
															<option value="05">May</option>
															<option value="06">Jun</option>
															<option value="07">Jul</option>
															<option value="08">Ago</option>
															<option value="09">Sep</option>
															<option value="10">Oct</option>
															<option value="11">Nov</option>
															<option value="12">Dic</option>
														</select>
													</div>
		  											<div class="col-xs-4">
														<select name="" id="anio" class="custom-select form-control">
															<option value="0">Seleccionar</option>
															<?php for ($i = intval(date('Y')); $i >= 1950; $i--): ?>
															<option value="<?=$i?>"><?=$i?></option>
															<?php endfor;?>
														</select>
													</div>
												</div>
											</div>
											<div class="form-group row">
												<div class="col-md-2 col-xs-12 text-center">
													<label for="country" style="margin-top: 6px;">Lugar de nacimiento <span style="color: red;">*</span></label>
												</div>
												<div class="col-xs-12 col-md-10">
													<select class="custom-select form-control" id="country" style="width: 100%;">
														<option value="0">Seleccione</option>
														<?php $countries = $db->getAll("SELECT * FROM paises ORDER BY mas_frecuentes DESC, nombre");?>
														<?php foreach ($countries as $c): ?>
															<option value="<?php echo $c["id"]; ?>"><?php echo $c["nombre"]; ?></option>
														<?php endforeach?>
													</select>
												</div>
											</div>
											<div class="form-group row">
												<div class="col-xs-12 col-md-2 text-center">
													<label for="stateCivil" style="margin-top: 6px;">Estado civil</label>
												</div>
												<div class="col-xs-12 col-md-10">
													<select class="custom-select form-control" id="estadoCivil" style="width: 100%;">
														<option value="0">Seleccione</option>
														<?php $estado_civil = $db->getAll("SELECT * FROM estados_civiles");?>
														<?php foreach ($estado_civil as $e): ?>
															<option value="<?php echo $e["id"]; ?>"><?php echo $e["nombre"]; ?></option>
														<?php endforeach?>
													</select>
												</div>
											</div>
											<div class="form-group row">
												<div class="col-xs-12 col-md-2 text-center">
													<label for="dni" style="margin-top: 6px;">DNI <span style="color: red;">*</span></label>
												</div>
												<div class="col-xs-12 col-md-4">
													<select class="custom-select form-control" style="width: 100%;" id="dni">
														<option value="0">Seleccione</option>
														<?php $tipos_documento_identificacion = $db->getAll("SELECT * FROM tipos_documento_identificacion");?>
														<?php foreach ($tipos_documento_identificacion as $t): ?>
															<option value="<?php echo $t["id"]; ?>"><?php echo $t["nombre"]; ?></option>
														<?php endforeach?>
													</select>
												</div>
												<div class="col-xs-12 col-md-2 text-center"><label for="numberdni" style="margin-top: 6px;">Número <span style="color: red;">*</span></label></div>
												<div class="col-xs-12 col-md-4">
													<input class="form-control" value="<?php echo $data["numero_documento_identificacion"]; ?>" id="numberdni" type="number" onchange="validar(this.id,'num')" placeholder="Ejemplo: 40598746">
												</div>
											</div>
											<div class="form-group row">
												<div class="col-xs-12 col-md-2 text-center">
													<label for="cuil" style="margin-top: 6px;">Numero de CUIL <span style="color: red;">*</span></label>
												</div>
												<div class="col-xs-12 col-md-10">
                                                    <input type="text" class="form-control" id="cuil" value="<?= $data["cuil"] ?>" onchange="validar(this.id,'num')" placeholder="Ejemplo: 15975325864">
												</div>
											</div>
											 <?php //$provincias = $db->getAll("SELECT * FROM provincias")?>
											<div class="form-group row">
												<div class="col-xs-12 col-md-2 text-center">
													<label for="province" style="margin-top: 6px;">Provincia <span style="color: red;">*</span></label>
												</div>
												<div class="col-xs-12 col-md-10">
                                                    <select onChange="seleccionar_localidad(this.value)" name="province" id="vic_provincias"
                                                            class="custom-select form-control">
                                                        <option value="0">Seleccione</option>
                                                      	<option value="1">Buenos Aires</option>
														<option value="2">Buenos Aires-GBA</option>
														<option value="3">Capital Federal</option>
														<option value="4">Catamarca</option>
														<option value="5">Chaco</option>
														<option value="6">Chubut</option>
														<option value="7">Córdoba</option>
														<option value="8">Corrientes</option>
														<option value="9">Entre Ríos</option>
														<option value="10">Formosa</option>
														<option value="11">Jujuy</option>
														<option value="12">La Pampa</option>
														<option value="13">La Rioja</option>
														<option value="14">Mendoza</option>
														<option value="15">Misiones</option>
														<option value="16">Neuquén</option>
														<option value="17">Río Negro</option>
														<option value="18">Salta</option>
														<option value="19">San Juan</option>
														<option value="20">San Luis</option>
														<option value="21">Santa Cruz</option>
														<option value="22">Santa Fe</option>
														<option value="23">Santiago del Estero</option>
														<option value="24">Tierra del Fuego</option>
														<option value="25">Tucumán</option>
                                                    </select>
												</div>
											</div>
                                            <?php //$localidades = $db->getAll("SELECT * FROM localidades WHERE id_provincia=" . $data['provincia'])?>
											<div class="form-group row">
												<div class="col-xs-12 col-md-2 text-center">
													<label for="city" style="margin-top: 6px;">Localidad / Ciudad <span style="color: red;">*</span></label>
												</div>
												<div class="col-xs-12 col-md-10">
                                                    
                                                         <?php include('select_localidades.php');?>
                                                    
												</div>
											</div>
											<div class="form-group row">
												<label for="street" class="col-xs-12 col-md-2 text-center">Calle <span style="color: red;">*</span></label>
												<div class="col-xs-12 col-md-10">
													<input maxlength="45" class="form-control" value="<?php echo $data["calle"]; ?>" id="street" type="text">
												</div>
											</div>
											<div class="form-group row">
												<label for="phone" class="col-xs-12 col-md-2 text-center">Teléfono o móvil <span style="color: red;">*</span></label>
												<div class="col-xs-12 col-md-10">
													<input class="form-control" value="<?php echo $data["telefono"]; ?>" id="phone" type="text" onchange='validar(this.id,"tel")'>
												</div>
											</div>
											<div class="form-group row">
												<label for="phoneAlt" class="col-xs-12 col-md-2 text-center">Teléfono alternativo</label>
												<div class="col-xs-12 col-md-10">
													<input class="form-control" value="<?php echo $data["telefono_alternativo"]; ?>" id="phoneAlt" type="text" onchange='validar(this.id,"tel")'>
												</div>
											</div>
											
										</div>
									</div>

									<div class="row container" style="margin-top: 10px">
										<div class="col-xs-12 col-sm-2 col-sm-offset-5">
											<button onClick="guardar_datos()" class="btn btn-primary" style="width: 100%">Guardar&nbsp <i class="fa fa-floppy-o"></i></button>
										</div>
									</div>

									<div class="row container" style="margin-top: 10px">							 

										<?php if($data['numero_documento_identificacion'] != ""): ?>
											<div class="col-xs-4 col-md-3 pull-right"> <a id="testvic" href="javascript:void(0)" class="btn btn-primary col-xs-12 col-sm-4 pull-right w-min-sm m-b-0-25 waves-effect waves-light back-next <?php echo $attr; ?>" data-target="2">Siguiente <i class="ti-angle-right"></i></a> </div>
										<?php endif; ?>
 
									</div>
								</div>

								<!-- Paso 2 - Experiencia laboral -->
								<div class="tab-pane" id="tab2" role="tabpanel">
									<br><br>
									<h4 style="border-bottom: 1px solid #3e70c9;margin-left: 25px;margin-right: 25px;margin-bottom: 25px;padding-bottom: 5px;">Paso 2: Experiencia laboral</h4>
									<?php $experiencias = $db->getAll("SELECT trabajadores_experiencia_laboral.*, paises.nombre as nombre_pais, actividades_empresa.nombre as actividad_empresa FROM trabajadores_experiencia_laboral INNER JOIN paises ON paises.id=trabajadores_experiencia_laboral.id_pais INNER JOIN actividades_empresa ON actividades_empresa.id=trabajadores_experiencia_laboral.id_actividad_empresa WHERE trabajadores_experiencia_laboral.id_trabajador = " . $_SESSION['ctc']['id'] . " ORDER BY trabajadores_experiencia_laboral.ano_egreso DESC, trabajadores_experiencia_laboral.mes_egreso DESC")?>
									<div class="row">
										<div class="col-md-8 col-md-offset-2">
											<?php if(!$experiencias): ?>
												<div class="form-group row" id="containerSinExpLab">
													<label for="sinExpLab" class="col-xs-12 col-md-2 text-center">¿Tienes experiencia laboral? </label>
													<div class="col-xs-12 col-md-10">
														<input value="" id="sinExpLab" type="checkbox" checked>
													</div>
												</div>
											<?php endif; ?>
											<div class="form-group row">
												<label for="company" class="col-xs-12 col-md-2 text-center">Empresa <span style="color: red;">*</span></label>
												<div class="col-xs-12 col-md-10">
													<input class="form-control" value="" id="company" type="text">
												</div>
											</div>
											<div class="form-group row">
												<div class="col-xs-12 col-md-2 text-center">
													<label for="rCompany" style="margin-top: 6px;">Ubicación de la empresa <span style="color: red;">*</span></label>
												</div>
												<div class="col-xs-12 col-md-10">
													<select class="custom-select form-control" style="width: 100%;" id="rCompany">
														<option value="0">Seleccione</option>
														<?php foreach ($countries as $c): ?>
															<option value="<?php echo $c["id"]; ?>"><?php echo $c["nombre"]; ?></option>
														<?php endforeach?>
													</select>
												</div>
											</div>
											<div class="form-group row">
												<div class="col-xs-12 col-md-2 text-center">
													<label for="tCompany" style="margin-top: 6px;">Ramo o actividad <span style="color: red;">*</span></label>
												</div>
												<div class="col-xs-12 col-md-10">
													<select class="custom-select form-control" style="width: 100%;" id="tCompany">
														<option value="0">Seleccione</option>
														<?php $actividades = $db->getAll("SELECT * FROM actividades_empresa ORDER BY nombre");?>
														<?php foreach ($actividades as $a): ?>
															<option value="<?php echo $a["id"]; ?>"><?php echo $a["nombre"]; ?></option>
														<?php endforeach?>
													</select>
												</div>
											</div>
											<div class="form-group row" >
												<div class="col-xs-12 col-md-2 text-center">
													<label for="tEmployeer">Tipo de puesto o jerarquía <span style="color: red;">*</span></label>
												</div>
												<div class="col-xs-12 col-md-10">
													<select name="tEmployeer" id="tEmployeer" class="custom-select form-control">
														<option value="">Seleccionar</option>
														<option value="Pasante">Pasante</option>
														<option value="Empleado">Empleado</option>
														<option value="Analista">Analista</option>
														<option value="Técnico">Técnico</option>
														<option value="Líder de Proyecto">Líder de Proyecto</option>
														<option value="Supervisor / Encargado">Supervisor / Encargado</option>
														<option value="Jefe">Jefe</option>
														<option value="Gerente">Gerente</option>
														<option value="Director">Director</option>
														<option value="Gerente General / CEO">Gerente General / CEO</option>
														<option value="Otro">Otro</option>
													</select>
												</div>
											</div>
											<div class="form-group row">
												<div class="col-xs-12 col-md-2 col-xs-12 text-center"><label for="monthI" style="margin-top: 6px;">Mes de ingreso <span style="color: red;">*</span></label></div>
												<div class="col-xs-12 col-md-4">
													<select class="custom-select form-control" style="width: 100%;" id="monthI">
														<option selected value="1">Enero</option>
														<option value="2">Febrero</option>
														<option value="3">Marzo</option>
														<option value="4">Abril</option>
														<option value="5">Mayo</option>
														<option value="6">Junio</option>
														<option value="7">Julio</option>
														<option value="8">Agosto</option>
														<option value="9">Septiembre</option>
														<option value="10">Octubre</option>
														<option value="11">Noviembre</option>
														<option value="12">Diciembre</option>
													</select>
												</div>
												<div class="col-xs-12 col-md-2 text-center"><label for="yearI" style="margin-top: 6px;">Año <span style="color: red;">*</span></label></div>
												<div class="col-xs-12 col-md-4">
													<select class="custom-select form-control" style="width: 100%;" id="yearI">
														<?php for ($i = intval(date('Y')); $i >= 1950; $i--): ?>
															<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
														<?php endfor?>
													</select>
												</div>
											</div>
											
											<div class="form-group row">
												<div id="label_monthE" class="col-xs-12 col-md-2 text-center"><label for="monthE" style="margin-top: 6px;">Mes de egreso <span style="color: red;">*</span></label></div>
												<div class="col-xs-12 col-md-4">
													<select class="custom-select form-control" style="width: 100%;" id="monthE">
														<option selected value="1">Enero</option>
														<option value="2">Febrero</option>
														<option value="3">Marzo</option>
														<option value="4">Abril</option>
														<option value="5">Mayo</option>
														<option value="6">Junio</option>
														<option value="7">Julio</option>
														<option value="8">Agosto</option>
														<option value="9">Septiembre</option>
														<option value="10">Octubre</option>
														<option value="11">Noviembre</option>
														<option value="12">Diciembre</option>
													</select>
												</div>
												<div id="label_yearE" class="col-xs-12 col-md-2 text-center"><label for="yearE" style="margin-top: 6px;">Año <span style="color: red;">*</span></label></div>
												<div class="col-xs-12 col-md-4">
													<select class="custom-select form-control" style="width: 100%;" id="yearE">
														<?php for ($i = intval(date('Y')); $i >= 1950; $i--): ?>
															<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
														<?php endfor?>
													</select>
												</div>
											</div>

											<div class="form-group row">
												<div class="col-xs-12 col-md-2"></div>
												<div class="col-xs-12 col-md-10">
													<input type="checkbox" id="trab_actual"> Trabajando actualmente
												</div>
											</div>

											<div class="form-group row">
												<div class="col-xs-12 col-md-2 text-center"><label for="" style="margin-top: 6px;">Solicitar Referencias </label></div>
												<div class="col-xs-6 col-md-5">
													<input type="text" class="form-control" id="nom_enc" placeholder="Nombre del encargado">
												</div>
												<div class="col-xs-6 col-md-5">
													<input type="tel" class="form-control" id="tlf_enc" placeholder="Telefono del encargado" title="Incluya el codigo de area" pattern="[0-9]">
												</div>
											</div>
											<div class="form-group row">
												<label for="descriptionArea" class="col-xs-12 col-md-2 text-center">Descripcion de las tareas <span style="color: red;">*</span></label>
												<div class="col-xs-12 col-md-10">
													<textarea id="descriptionArea" class="form-control"></textarea>
												</div>
											</div>
											  
											<!-- Botones de Guardar y Borrar -->
											<div class="col-xs-12 col-sm-2 col-md-offset-4 col-sm-offset-4">
												<a href="javascript:void(0)" class="btn btn-primary col-xs-12 col-sm-4 w-min-sm m-b-0-25 waves-effect waves-light save" data-edit="1"  data-target="2">Guardar <i class="fa fa-floppy-o"></i></a> 
											</div>

											<div class="col-xs-12 col-sm-2">
												<a href="javascript:void(0)" class="btn btn-primary col-xs-12 col-sm-4 w-min-sm m-b-0-25 waves-effect waves-light reset" data-target="2">Borrar <i class="fa fa-trash"></i></a>
											</div>

										</div>
									</div>

									<?php if ($experiencias): ?>
										<div class="" id="contentEL">
											<h4 style="border-bottom: 1px solid #3e70c9;margin-left: 25px;margin-right: 25px;margin-bottom: 25px;padding-bottom: 5px;margin-top: 15px;">Mis empleos anteriores</h4>
											<div class="row" style="margin-bottom: 25px;">

												<div class="col-md-10 col-md-offset-1 table-responsive">
													<table class="table">
														<thead>
															<tr>
																<th>Nombre</th>
																<th>Pais</th>
																<th>Actividad</th>
																<th>Tipo puesto</th>
																<th>Acciones</th>
															</tr>
														</thead>
														<tbody id="t2">
															<?php foreach ($experiencias as $e): ?>
																<tr>
																	<td><?php echo $e["nombre_empresa"]; ?></td>
																	<td><?php echo $e["nombre_pais"]; ?></td>
																	<td><?php echo $e["actividad_empresa"]; ?></td>
																	<td><?php echo $e["tipo_puesto"]; ?></td>
																	<td>
																		<div class="pull-xs-left">
																			<a class="text-success modifyEL" style="font-size: 20px" href="javascript:void(0)" data-target="<?php echo $e["id"]; ?>" data-option="2"><i class="fa fa-pencil-square"></i></a>
																			<a class="text-danger deleteItem" style="font-size: 20px; margin-left: 5px;" href="javascript:void(0)" data-target="<?php echo $e["id"]; ?>" data-option="2"><i class="fa fa-ban"></i></a>
																		</div>
																	</td>
																</tr>
															<?php endforeach?>
														</tbody>
													</table>
												</div>
											</div>
										</div>
									<?php else: ?>
										<div class="" id="contentEL" style="display: none;">
											<h4 style="border-bottom: 1px solid #3e70c9;margin-left: 25px;margin-right: 25px;margin-bottom: 25px;padding-bottom: 5px;margin-top: 15px;">Mis empleos anteriores</h4>
											<div class="row" style="margin-bottom: 25px;">
												<div class="col-md-1"></div>
												<div class="col-md-10">
													<table class="table m-md-b-0">
														<thead>
															<tr>
																<th>Nombre</th>
																<th>Pais</th>
																<th>Actividad</th>
																<th>Tipo puesto</th>
																<th>Acciones</th>
															</tr>
														</thead>
														<tbody id="t2"></tbody>
													</table>
												</div>
												<div class="col-md-1"></div>
											</div>
										</div>
									<?php endif?>

									<div class="row container">
										<div class="col-xs-4 col-sm-3 pull-left">
											<a href="javascript:void(0)" class="btn btn-primary col-xs-4 col-sm-4 w-min-sm m-b-0-25 waves-effect waves-light back-next" data-target="1"><i class="ti-angle-left"></i> Anterior</a>
										</div>
										
										<div class="col-xs-4 col-sm-3 pull-right">
											<a href="javascript:void(0)" class="btn btn-primary col-xs-4 col-sm-4 pull-right w-min-sm m-b-0-25 waves-effect waves-light back-next" data-target="3">Siguiente <i class="ti-angle-right"></i></a>
										</div>
									</div>
								</div>

								<!-- Paso 3 - Estudios -->
								<div class="tab-pane" id="tab3" role="tabpanel">
									<br><br>									
									<h4 style="border-bottom: 1px solid #3e70c9;margin-left: 25px;margin-right: 25px;margin-bottom: 25px;padding-bottom: 5px;">Paso 3: Estudios</h4>
									<div class="row">
										<div class="col-md-8 col-md-offset-2">
											<div class="form-group">
												<div class="row" style="margin-top: 10px;">
													<label for="sNivel" class="col-xs-12 col-md-2 text-center">Nivel de estudio <span style="color: red;">*</span></label>
													<div class="col-xs-12 col-md-10">
														<select class="custom-select form-control" style="width: 100%;" id="sNivel">
															<option value="0">Seleccione</option>
															<?php $nivel_estudio = $db->getAll("SELECT * FROM nivel_estudio");?>
															<?php foreach ($nivel_estudio as $n): ?>
																<option value="<?php echo $n["id"]; ?>"><?php echo $n["nombre"]; ?></option>
															<?php endforeach?>
														</select>
													</div>
												</div>
											</div>
											<div class="form-group row">
												<label for="titleS" class="col-xs-12 col-md-2 text-center">Título o certificación <span style="color: red;">*</span></label>
												<div class="col-xs-12 col-md-10">
													<input class="form-control" value="" id="titleS" type="text">
												</div>
											</div>
											<div class="form-group row">
												<div class="col-xs-12 col-md-2 text-center">
													<label for="stateS" style="margin-top: 6px;">Estado <span style="color: red;">*</span></label>
												</div>
												<div class="col-xs-12 col-md-10">
													<select class="custom-select form-control" style="width: 100%;" id="stateS">
														<option value="0">Seleccione</option>
														<option value="1">En Curso</option>
														<option value="2">Graduado</option>
														<option value="3">Abandonado</option>
													</select>
												</div>
											</div>
											<div class="form-group row">
												<div class="col-xs-12 col-md-2 text-center">
													<label for="areaS">Área de estudio <span style="color: red;">*</span></label>
												</div>
												<div class="col-xs-12 col-md-10">
													<select class="custom-select form-control" style="width: 100%;" id="areaS">
														<option value="0">Seleccione</option>
														<?php $areas_estudio = $db->getAll("SELECT * FROM areas_estudio ORDER BY nombre");?>
														<?php foreach ($areas_estudio as $a): ?>
															<option value="<?php echo $a["id"]; ?>"><?php echo $a["nombre"]; ?></option>
														<?php endforeach?>
													</select>
												</div>
											</div>
											<div class="form-group row">
												<div class="col-xs-12 col-md-2 text-center">
													<label for="institute">Institución <span style="color: red;">*</span></label>
												</div>
												<div class="col-xs-12 col-md-10">
													<input class="form-control" value="" id="institute" type="text">
												</div>
											</div>
											<div class="form-group row">
												<div class="col-xs-12 col-md-2 text-center">
													<label for="countryS" style="margin-top: 6px;">País <span style="color: red;">*</span></label>
												</div>
												<div class="col-xs-12 col-md-10">
													<select class="custom-select form-control" style="width: 100%;" id="countryS">
														<option value="0">Seleccione</option>
														<?php foreach ($countries as $c): ?>
															<option value="<?php echo $c["id"]; ?>"><?php echo $c["nombre"]; ?></option>
														<?php endforeach?>
													</select>
												</div>
											</div>
											<div class=" form-group row">
												<div class="col-xs-12 col-md-2 text-center">
													<label for="monthIn" style="margin-top: 6px;">Mes de inicio <span style="color: red;">*</span></label>
												</div>
												<div class="col-xs-12 col-md-4">
													<select class="custom-select form-control" style="width: 100%;" id="monthIn">
														<option selected value="1">Enero</option>
														<option value="2">Febrero</option>
														<option value="3">Marzo</option>
														<option value="4">Abril</option>
														<option value="5">Mayo</option>
														<option value="6">Junio</option>
														<option value="7">Julio</option>
														<option value="8">Agosto</option>
														<option value="9">Septiembre</option>
														<option value="10">Octubre</option>
														<option value="11">Noviembre</option>
														<option value="12">Diciembre</option>
													</select>
												</div>
												<div class="col-xs-12 col-md-2 text-center">
													<label for="yearIn" style="margin-top: 6px;">Año <span style="color: red;">*</span></label>
												</div>
												<div class="col-xs-12 col-md-4">
													<select class="custom-select form-control" style="width: 100%;" id="yearIn">
														<?php for ($i = intval(date('Y')); $i >= 1950; $i--): ?>
															<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
														<?php endfor?>
													</select>
												</div>
											</div>
											<div class="form-group row" id='fechaFin'>
												<div class="col-xs-12 col-md-2 text-center">
													<label for="monthFi" style="margin-top: 6px;">Mes de finalización <span style="color: red;">*</span></label>
												</div>
												<div class="col-xs-12 col-md-4">
													<select class="custom-select form-control" style="width: 100%;" id="monthFi">
														<option selected value="1">Enero</option>
														<option value="2">Febrero</option>
														<option value="3">Marzo</option>
														<option value="4">Abril</option>
														<option value="5">Mayo</option>
														<option value="6">Junio</option>
														<option value="7">Julio</option>
														<option value="8">Agosto</option>
														<option value="9">Septiembre</option>
														<option value="10">Octubre</option>
														<option value="11">Noviembre</option>
														<option value="12">Diciembre</option>
													</select>
												</div>
												<div class="col-xs-12 col-md-2 text-center">
													<label for="yearFi" >Año <span style="color: red;">*</span></label>
												</div>
												<div class="col-xs-12 col-md-4">
													<select class="custom-select form-control" style="width: 100%;" id="yearFi">
														<?php for ($i = intval(date('Y')); $i >= 1950; $i--): ?>
															<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
														<?php endfor?>
													</select>
												</div>
											</div>
											<div class="form-group row" id="materias_aprobadas">
												<div class="col-xs-12 col-md-3 text-center">
													<label for="mat">Materias de la carrera <span style="color: red;">*</span></label>
												</div>
												<div class="col-xs-12 col-md-3">
													<input class="form-control" value="" id="mat" type="text"  onchange="validar(this.id,'num')">
												</div>
												<div class="col-xs-12 col-md-3 text-center">
													<label for="aprob">Materias aprobadas <span style="color: red;">*</span></label>
												</div>
												<div class="col-xs-12 col-md-3">
													<input class="form-control" value="" id="aprob" type="text"  onchange="validar(this.id,'num')">
												</div>
											</div>
											  
											<!-- Botones de Guardar y Borrar -->
											<div class="col-xs-12 col-sm-2 col-md-offset-4 col-sm-offset-4">
												<a href="javascript:void(0)" class="btn btn-primary col-xs-12 col-sm-4 w-min-sm m-b-0-25 waves-effect waves-light save" data-edit="1"  data-target="3">Guardar <i class="fa fa-floppy-o"></i></a>
											</div>
											<div class="col-xs-12 col-sm-2">
												<a href="javascript:void(0)" class="btn btn-primary col-xs-12 col-sm-4 w-min-sm m-b-0-25 waves-effect waves-light reset" data-target="3">Borrar <i class="fa fa-trash"></i></a>
											</div>

										</div>
									</div>

									<?php $educacion = $db->getAll("SELECT trabajadores_educacion.*, paises.nombre as nombre_pais, nivel_estudio.nombre as nivel, areas_estudio.nombre as nombre_estudio, estado_estudio.nombre as estado_estudio FROM trabajadores_educacion INNER JOIN paises ON paises.id=trabajadores_educacion.id_pais INNER JOIN nivel_estudio ON nivel_estudio.id=trabajadores_educacion.id_nivel_estudio INNER JOIN areas_estudio ON areas_estudio.id=trabajadores_educacion.id_area_estudio INNER JOIN estado_estudio ON estado_estudio.id=trabajadores_educacion.id_estado_estudio WHERE trabajadores_educacion.id_trabajador=" . $_SESSION["ctc"]["id"]);?>
									<?php if ($educacion): ?>
										<div class="" id="contentED">
											<h4 style="border-bottom: 1px solid #3e70c9;margin-left: 25px;margin-right: 25px;margin-bottom: 25px;padding-bottom: 5px;margin-top: 15px;">Mis estudios</h4>
											<div class="row" style="margin-bottom: 25px;">
												<div class="col-md-10 col-md-offset-1 table-responsive">
													<table class="table">
														<thead>
															<tr>
																<th>Nivel estudio</th>
																<th>Pais</th>
																<th>Estado estudio</th>
																<th>Área estudio</th>
																<th>Acciones</th>
															</tr>
														</thead>
														<tbody id="t3">
															<?php foreach ($educacion as $e): ?>
																<tr>
																	<td><?php echo $e["nivel"]; ?></td>
																	<td><?php echo $e["nombre_pais"]; ?></td>
																	<td><?php echo $e["estado_estudio"]; ?></td>
																	<td><?php echo $e["nombre_estudio"]; ?></td>
																	<td>
																		<div class="pull-xs-left">
																			<a class="text-success m-r-1 modifyES" href="javascript:void(0)" style="font-size: 20px" data-target="<?php echo $e["id"]; ?>" data-option="3"><i class="fa fa-pencil-square"></i></a>
																			<a class="text-danger deleteItem" href="javascript:void(0)" style="font-size: 20px; margin-left: 5px;" data-target="<?php echo $e["id"]; ?>" data-option="3"><i class="fa fa-ban"></i></a>
																		</div>
																	</td>
																</tr>
															<?php endforeach?>
														</tbody>
													</table>
												</div>
												<div class="col-md-1"></div>
											</div>
										</div>
									<?php else: ?>
										<div class="" id="contentED" style="display: none;">
											<h4 style="border-bottom: 1px solid #3e70c9;margin-left: 25px;margin-right: 25px;margin-bottom: 25px;padding-bottom: 5px;margin-top: 15px;">Mis estudios</h4>
											<div class="row" style="margin-bottom: 25px;">
												<div class="col-md-10 col-md-offset-1 table-responsive">
													<table class="table">
														<thead>
															<tr>
																<th>Nivel estudio</th>
																<th>Pais</th>
																<th>Estado estudio</th>
																<th>Área estudio</th>
																<th>Acciones</th>
															</tr>
														</thead>
														<tbody id="t3"></tbody>
													</table>
												</div>
											</div>
										</div>
									<?php endif?>

									<div class="row container">
										<div class="col-xs-4 col-sm-3 pull-left">
											<a href="javascript:void(0)" class="btn btn-primary col-xs-4 col-sm-4 w-min-sm m-b-0-25 waves-effect waves-light back-next" data-target="2"><i class="ti-angle-left"></i> Anterior</a>
										</div>

										<?php if($educacion || $idiomasT): ?>
											<div class="col-xs-4 col-sm-3 pull-right"> 
												<a href="javascript:void(0)" class="btn btn-primary col-xs-4 col-sm-4 pull-right w-min-sm m-b-0-25 waves-effect waves-light back-next" data-target="4">Siguiente <i class="ti-angle-right"></i></a> 
											</div>
										<?php endif; ?>
									</div>
								</div>

								  <!-- Paso 4 - Idiomas -->
								<div class="tab-pane" id="tab4" role="tabpanel">
									<br><br>
									<h4 style="border-bottom: 1px solid #3e70c9;margin-left: 25px;margin-right: 25px;margin-bottom: 25px;padding-bottom: 5px;">Paso 4: Idiomas</h4>
									<div class="col-md-8 col-md-offset-2">
										<div class="form-group row" style="margin-top: 10px;">
											<div class="col-xs-12 col-md-2 text-center">
												<label for="idioma">Idioma <span style="color: red;">*</span></label>
											</div>
											<div class="col-xs-12 col-md-10">
												<select class="custom-select form-control" style="width: 100%;" id="idioma">
													<option selected value="0">Seleccione</option>
													<?php $idiomas = $db->getAll("SELECT * FROM idiomas");?>
													<?php foreach ($idiomas as $i): ?>
														<option value="<?php echo $i["id"]; ?>"><?php echo $i["nombre"]; ?></option>
													<?php endforeach?>
												</select>
											</div>
										</div>

										<div class="form-group row">
											<div class="col-xs-12 col-md-2 text-center">
												<label>Nivel oral <span style="color: red;">*</span></label>
											</div>
											<div class="col-xs-12 col-md-10 text-center">

													<?php $nivel_idioma = $db->getAll("SELECT * FROM nivel_idioma");?>
													<?php foreach ($nivel_idioma as $i => $n): ?>
														<label class="custom-control custom-radio col-md-3">
															<input id="rad<?php echo $i; ?>" name="nivelO" class="custom-control-input" type="radio" value="<?php echo $n["id"]; ?>">
															<span class="custom-control-indicator"></span>
															<span class="custom-control-description"><?php echo $n["nombre"]; ?></span>
														</label>
													<?php endforeach?>

											</div>
										</div>

										<div class="form-group row">
											<div class="col-xs-12 col-md-2 text-center"><label>Nivel escrito <span style="color: red;">*</span></label></div>
											<div class="col-xs-12 col-md-10 text-center">

													<?php foreach ($nivel_idioma as $i => $n): ?>
														<label class="custom-control custom-radio col-md-3">
															<input id="rad<?php echo $i; ?>" name="nivelE" class="custom-control-input" type="radio" value="<?php echo $n["id"]; ?>">
															<span class="custom-control-indicator"></span>
															<span class="custom-control-description"><?php echo $n["nombre"]; ?></span>
														</label>
													<?php endforeach?>

											</div>
										</div>

										<!-- Botonos de Guardar y Borrar -->
										<div class="col-xs-12 col-sm-2 col-md-offset-4 col-sm-offset-4"><a href="javascript:void(0)" class="btn btn-primary col-xs-12 col-sm-4 w-min-sm m-b-0-25 waves-effect waves-light save" data-edit="1"  data-target="4">Guardar <i class="fa fa-floppy-o"></i></a></div>
										<div class="col-xs-12 col-sm-2"><a href="javascript:void(0)" class="btn btn-primary col-xs-12 col-sm-4 w-min-sm m-b-0-25 waves-effect waves-light reset" data-target="4">Borrar <i class="fa fa-trash"></i></a></div>	
									</div>

									<?php $idiomasT = $db->getAll("SELECT trabajadores_idiomas.*, idiomas.nombre as nombre_idioma FROM trabajadores_idiomas INNER JOIN idiomas ON idiomas.id=trabajadores_idiomas.id_idioma WHERE trabajadores_idiomas.id_trabajador=" . $_SESSION["ctc"]["id"]);?>
									<?php if ($idiomasT): ?>
										<div class="col-md-8 col-md-offset-2" id="contentID">
											<h4 style="border-bottom: 1px solid #3e70c9;margin-left: 25px;margin-right: 25px;margin-bottom: 25px;padding-bottom: 5px;margin-top: 15px;">Mis idiomas</h4>
											<div class="row" style="margin-bottom: 25px;">
												<div class="col-md-10 col-md-offset-1 table-responsive">
													<table class="table">
														<thead>
															<tr>
																<th>Idioma</th>
																<th>Nivel Oral</th>
																<th>Nivel escrito</th>
																<th>Acciones</th>
															</tr>
														</thead>
														<tbody id="t4">
															<?php foreach ($idiomasT as $i): ?>
																<?php $nivel_oral    = $db->getOne("SELECT nombre FROM nivel_idioma WHERE id=$i[nivel_oral]");?>
																<?php $nivel_escrito = $db->getOne("SELECT nombre FROM nivel_idioma WHERE id=$i[nivel_escrito]");?>
																<tr>
																	<td><?php echo $i["nombre_idioma"]; ?></td>
																	<td><?php echo $nivel_oral; ?></td>
																	<td><?php echo $nivel_escrito; ?></td>
																	<td>
																		<div class="pull-xs-left">
																			<a class="text-success m-r-1 modifyI" style="font-size: 20px;" href="javascript:void(0)" data-target="<?php echo $i["id"]; ?>" data-option="4"><i class="fa fa-pencil-square"></i></a>
																			<a class="text-danger deleteItem" style="font-size: 20px; margin-left: 5px;" href="javascript:void(0)" data-target="<?php echo $i["id"]; ?>" data-option="4"><i class="fa fa-ban"></i></a>
																		</div>
																	</td>
																</tr>
															<?php endforeach?>
														</tbody>
													</table>
												</div>
											</div>
										</div>
									<?php else: ?>
										<div class="col-md-8 col-md-offset-2" id="contentID" style="display: none;">
											<h4 style="border-bottom: 1px solid #3e70c9;margin-left: 25px;margin-right: 25px;margin-bottom: 25px;padding-bottom: 5px;margin-top: 15px;">Mis idiomas</h4>
											<div class="row" style="margin-bottom: 25px;">
												<div class="col-md-10 col-md-offset-1 table-responsive">
													<table class="table">
														<thead>
															<tr>
																<th>Idioma</th>
																<th>Nivel Oral</th>
																<th>Nivel escrito</th>
																<th>Acciones</th>
															</tr>
														</thead>
														<tbody id="t4"></tbody>
													</table>
												</div>
											</div>
										</div>
									<?php endif?>

									<div class="row container">
										<div class="col-xs-4 col-sm-3 pull-left"><a href="javascript:void(0)" class="btn btn-primary col-xs-4 col-sm-4 w-min-sm m-b-0-25 waves-effect waves-light back-next" data-target="3"><i class="ti-angle-left"></i> Anterior</a></div>
			
										<?php if($idiomasT): ?>
											<div class="col-xs-4 col-sm-3 pull-right"> <a href="javascript:void(0)" class="btn btn-primary pull-right col-xs-4 col-sm-4 w-min-sm m-b-0-25 waves-effect waves-light back-next" data-target="5">Siguiente <i class="ti-angle-right"></i></a> </div>
										<?php endif; ?>
									</div>
								</div>

								<!-- Paso 5 - Otros conocimientos -->
								<div class="tab-pane" id="tab5" role="tabpanel">
									<br><br>
									<h4 style="border-bottom: 1px solid #3e70c9;margin-left: 25px;margin-right: 25px;margin-bottom: 25px;padding-bottom: 5px;">Paso 5: Otros conocimientos</h4>
									<div class="row">
										<div class="col-md-8 col-md-offset-2">
											<div class="form-group row" id="containerSinOtrCon">
												<label for="sinOtrCon" class="col-xs-12 col-md-2 text-center">¿Tienes otros conocimientos? </label>
												<div class="col-xs-12 col-md-10">
													<input value="" id="sinOtrCon" type="checkbox" checked>
												</div>
											</div>
											<div class="form-group row">
												<label for="nameC" class="col-xs-12 col-md-2 text-center">Nombre <span style="color: red;">*</span></label>
												<div class="col-xs-12 col-md-10">
													<input class="form-control" value="" id="nameC" type="text">
												</div>
											</div>
											<div class="form-group row">
												<label for="descriptionC" class="col-xs-12 col-md-2 text-center">Descripción <span style="color: red;">*</span></label>
												<div class="col-xs-12 col-md-10">
													<textarea class="form-control" id="descriptionC"></textarea>
												</div>
											</div>

										<div class="col-xs-12 col-sm-2 col-md-offset-4 col-sm-offset-4"><a href="javascript:void(0)" class="btn btn-primary col-xs-12 col-sm-4 w-min-sm m-b-0-25 waves-effect waves-light save" data-edit="1"  data-target="5">Guardar <i class="fa fa-floppy-o"></i></a></div>
										<div class="col-xs-12 col-sm-2"><a href="javascript:void(0)" class="btn btn-primary col-xs-12 col-sm-4 w-min-sm m-b-0-25 waves-effect waves-light reset" data-target="5">Borrar <i class="fa fa-trash"></i></a></div>


										</div>
									</div>

									<?php $otros_conocimientos = $db->getAll("SELECT * FROM trabajadores_otros_conocimientos WHERE id_trabajador=" . $_SESSION["ctc"]["id"]);?>
									<?php if ($otros_conocimientos): ?>
										<div class="" id="contentOC">
											<h4 style="border-bottom: 1px solid #3e70c9;margin-left: 25px;margin-right: 25px;margin-bottom: 25px;padding-bottom: 5px;margin-top: 15px;">Mis otros conocimientos</h4>
											<div class="row" style="margin-bottom: 25px;">
												<div class="col-md-10 col-sm-offset-1 table-responsive">
													<table class="table">
														<thead>
															<tr>
																<th>Título</th>
																<th>Descripción</th>
																<th>Acciones</th>
															</tr>
														</thead>
														<tbody id="t5">
															<?php foreach ($otros_conocimientos as $o): ?>
																<tr>
																	<td><?php echo $o["nombre"]; ?></td>
																	<td><?php echo $o["descripcion"]; ?></td>
																	<td>
																		<div class="pull-xs-left">
																			<a class="text-success m-r-1 modifyOC" style="font-size: 20px;" href="javascript:void(0)" data-target="<?php echo $o["id"]; ?>" data-option="5"><i class="fa fa-pencil-square"></i></a>
																			<a class="text-danger deleteItem" style="font-size: 20px; margin-left: 5px;" href="javascript:void(0)" data-target="<?php echo $o["id"]; ?>" data-option="5"><i class="fa fa-ban"></i></a>
																		</div>
																	</td>
																</tr>
															<?php endforeach?>
														</tbody>
													</table>
												</div>
											</div>
										</div>
									<?php else: ?>
										<div class="" id="contentOC" style="display: none;">
											<h4 style="border-bottom: 1px solid #3e70c9;margin-left: 25px;margin-right: 25px;margin-bottom: 25px;padding-bottom: 5px;margin-top: 15px;">Mis otros conocimientos</h4>
											<div class="row" style="margin-bottom: 25px;">
												<div class="col-md-10 col-md-offset-1 table-responsive">
													<table class="table">
														<thead>
															<tr>
																<th>Título</th>
																<th>Descripción</th>
																<th>Acciones</th>
															</tr>
														</thead>
														<tbody id="t5"></tbody>
													</table>
												</div>
											</div>
										</div>
									<?php endif?>

									<div class="row container">
										<div class="col-xs-4 col-sm-3 pull-left"><a href="javascript:void(0)" class="btn btn-primary col-xs-4 col-sm-4 w-min-sm m-b-0-25 waves-effect waves-light back-next" data-target="4"><i class="ti-angle-left"></i> Anterior</a></div>

										<div class="col-xs-4 col-sm-3 pull-right"><a href="javascript:void(0)" class="btn btn-primary pull-right col-xs-4 col-sm-4 w-min-sm m-b-0-25 waves-effect waves-light back-next" data-target="6">Siguiente <i class="ti-angle-right"></i></a> </div>
									</div>
								</div>

								<!-- Paso 6 - Informacion extra -->
								<div class="tab-pane" id="tab6" role="tabpanel">
									<br><br>
									<h4 style="border-bottom: 1px solid #3e70c9;margin-left: 25px;margin-right: 25px;margin-bottom: 25px;padding-bottom: 5px;">Paso 6: Información Extra</h4>
									<div class="row">
										<div class="col-md-8 col-md-offset-2">
											<div class="form-group row">
												<label for="remuneracion" class="col-xs-12 col-md-2 ctext-center">Remuneración Pretendida <span style="color: red;">*</span></label>
												<div class="col-xs-12 col-md-10" style="padding-left:40px;">
													<input type="hidden" id="remuneracion">
													<b id="mobileText"><?=$infoExtra['remuneracion_pret']?> ARS</b><input id="ex1" data-slider-id='ex1Slider' type="text" data-slider-min="2000" data-slider-max="100000" data-slider-step="2000" data-slider-value="<?=$infoExtra['remuneracion_pret']?>"/> 
												</div>
											</div>
											<div class="form-group row" style="margin-top: 10px;">
												<label for="sobre_mi" class="col-xs-12 col-md-2 text-center">Disponibilidad <span style="color: red;">*</span></label>
												<div class="col-xs-12 col-md-10">
													<select name="" id="disp" class="custom-select form-control" style="width:100%">
														<option value="0">Seleccione</option>
														<?php $disps = $db->getAll("SELECT * FROM disponibilidad ORDER BY 1 ASC");?>
														<?php foreach ($disps as $d): ?>
															<option value="<?php echo $d["id"]; ?>"><?php echo $d["nombre"]; ?></option>
														<?php endforeach?>
													</select>
												</div>
											</div>
											<div class="form-group row" style="margin-top: 10px;">
												<label for="sobre_mi" class="col-xs-12 col-md-2 text-center">Sobre mí <span style="color: red;">*</span></label>
												<div class="col-xs-12 col-md-10 ">
													<textarea name="" id="sobre_mi" class="form-control" style="max-height: 300px"></textarea>
												</div>
											</div>
											<h5>Mis redes Sociales</h5>
												<span style="color: grey; font-size: 10px">Ojo: Las redes sociales que coloques en el formulario serán visibles por las empresas.</span>

											<hr>
											<div class="alert alert-danger" style="display: none;">
												<p><b>Error!</b> <span id="errorRS"></span></p>
											</div>
											<div class="form-group row">
												<label for="web" class="col-xs-12 col-md-2 text-center">Sitio Web</label>
												<div class="col-xs-12 col-md-10">
													<input class="form-control" value="<?php echo $data["sitio_web"] ?>" id="web" type="text" placeholder="Url de tu pagina web">
												</div>
											</div><div class="form-group row">
												<label for="fb" class="col-xs-12 col-md-2 text-center">Facebook</label>
												<div class="col-xs-12 col-md-10">
													<input class="form-control" value="<?php echo $data["facebook"] ?>" id="fb" type="text" placeholder="Link de tu perfil de Facebook">
												</div>
											</div>
											<div class="form-group row">
												<label for="tw" class="col-xs-12 col-md-2 text-center">Twitter</label>
												<div class="col-xs-12 col-md-10">
													<input class="form-control" value="<?php echo $data["twitter"] ?>" id="tw" type="text" placeholder="Link de tu perfil de Twitter">
												</div>
											</div>
											<div class="form-group row">
												<label for="ig" class="col-xs-12 col-md-2 text-center">Instagram</label>
												<div class="col-xs-12 col-md-10">
													<input class="form-control" value="<?php echo $data["instagram"] ?>" id="ig" type="text" placeholder="Link de tu perfil de Instagram">
												</div>
											</div>
											<div class="form-group row">
												<label for="snap" class="col-xs-12 col-md-2 text-center">Snapchat</label>
												<div class="col-xs-12 col-md-10">
													<input class="form-control" value="<?php echo $data["snapchat"] ?>" id="snap" type="text" placeholder="nombre de perfil de Snapchat">
												</div>
											</div>
											<div class="form-group row">
												<label for="lkd" class="col-xs-12 col-md-2 text-center">Linkedin</label>
												<div class="col-xs-12 col-md-10">
													<input class="form-control" value="<?php echo $data["linkedin"] ?>" id="lkd" type="text" placeholder="Link de tu perfil de Linkedin">
												</div>
											</div>

											<div class="col-xs-12 col-sm-2 col-md-offset-4 col-sm-offset-4">
												<a href="javascript:void(0)" class="btn btn-primary col-xs-12 col-sm-4 w-min-sm m-b-0-25 waves-effect waves-light save" data-edit="1"  data-target="6">Guardar <i class="fa fa-floppy-o"></i></a> 
											</div>
											<div class="col-xs-12 col-sm-2">
												<a href="javascript:void(0)" class="btn btn-primary col-xs-12 col-sm-4 w-min-sm m-b-0-25 waves-effect waves-light reset" data-target="6">Borrar <i class="fa fa-trash"></i></a>
											</div>
										</div>
									</div>
								</div>

								<!-- Paso 7 - vista previa -->
								<!-- SECCION FOTO -->
								<div class="tab-pane" id="tab7" role="tabpanel">
									<br><br>
									<h4 style="border-bottom: 1px solid #3e70c9;margin-left: 25px;margin-right: 25px;margin-bottom: 25px;padding-bottom: 5px;">Vista previa de mi currículum</h4>
									<div class="row">
										<div class="col-md-12">
										<div class="col-sm-4 col-md-4 no-padding-lat">
											<div class="content-perfil profile-card" style="margin-top: 0px; padding-bottom: 0px; padding-top: 0px;">

												<div class="profile-avatar" style="text-align: center; background-color: #E4E6E3; margin-top: 0px; padding-top: 40px; padding-bottom: 40px;">
													<img src="img/<?php echo $_SESSION["ctc"]["pic"]; ?>" alt="" style="width: 130px; margin-bottom: 10px;">
												</div>
												<div class="card-block" style="background-color: #E4E6E3;">
													<ul class="list-group" style="margin-bottom: 0px;">
													<li class="list-group-item item-profile" style="border-radius: 0px; background-color:#2E358D;">
														<span class="fa-stack fa-lg icon-item-profile">
														<i class="fa fa-square-o fa-stack-2x"></i>
														<i class="fa fa-user fa-stack-1x"></i>
														</span>
														<span class="info-item-profile" style="text-transform: uppercase" id="labelCalle"><?php echo "$data[nombres] $data[apellidos]"; ?></span>
													</li>

													<li class="list-group-item item-profile" style="border-radius: 0px; background-color:#2043a0;">
														<span class="fa-stack fa-lg icon-item-profile">
														<i class="fa fa-square-o fa-stack-2x"></i>
														<i class="fa fa-map-marker fa-stack-1x"></i>
														</span>
														<span class="info-item-profile" id="labelCalle"><?php echo $data["calle"]; ?></span>
													</li>

													<li class="list-group-item item-profile" style="background-color: #235AD1">
														<span class="fa-stack fa-lg icon-item-profile">
														<i class="fa fa-square-o fa-stack-2x"></i>
														<i class="fa fa-phone fa-stack-1x"></i>
														</span>
														<span class="info-item-profile labelTlf" id=""><?php echo $data["telefono"] . $data["telefono_alternativo"] != "" ? " / " . $data["telefono_alternativo"] : ''; ?></span>
													</li>

													<li class="list-group-item item-profile" style="background-color: #2393D2; border-radius: 0px;">
														<span class="fa-stack fa-lg icon-item-profile">
														<i class="fa fa-square-o fa-stack-2x"></i>
														<i class="fa fa-envelope fa-stack-1x" style="bottom: 2px;"></i>
														</span>
														<span class="info-item-profile" id="labelEmail"><?php echo $data["correo_electronico"]; ?></span>
													</li>

													</ul>
													<a class="btn btn-outline-primary btn-block btn-rounded waves-effect contact-btn" style="margin-top: 10px;" href="cv_jobbers/cv.php?id=<?php echo $data["id"]; ?>" target="_blank"><span class="fa fa-download" style="margin-right: 3px;"></span> Descargar currículum</a>
												</div>
											</div>	
										</div>
										<!-- SECCION INFORMACION -->
											<div class="col-sm-8 col-md-8 no-padding-lat">
											
											<!-- <div class="tab-content"> -->
												<div class="col-md-12 card-block active content-perfil" id="currículum" role="tabpanel" style="padding-right: 0px; padding-left:0px; padding-top: 0px;">
													<!-- <div class="row"> -->
													<div class="col-md-12" style="padding-right: 0px; padding-left: 0px;">
													<h4 class="title-cv" style="margin-top: 0px;">&nbsp; INFORMACION PERSONAL</h4>
														<p class="content-cv">
															<strong>DNI: </strong> <span id="labelDNI"><?php echo $data["numero_documento_identificacion"]; ?></span><br>
															<strong>Numero de CUIL: </strong> <span id="labelCuil"><?php echo $data["cuil"]; ?></span><br>
															<strong>Lugar de nacimiento: </strong> <span id="labelCountry"><?php echo $data["localidad"] . ", " . $data["provincia"] . ", " . $data["pais"] ?></span><br>
															<strong>Fecha de Nacimiento: </strong> <span id="fecha_nac"><?php echo $data["fecha_nacimiento"] !== null ? date('Y-m-d', strtotime($data["fecha_nacimiento"])) : ""; ?></span><br>
															<strong>Edad: </strong> <span id="edad"><?php echo $data["fecha_nacimiento"] !== null ? intval(date('Y')) - intval(date('Y', strtotime($data["fecha_nacimiento"]))) . "años" : ""; ?></span><br>
															<strong>Telefonos: </strong> <span class="labelTlf"><?php echo $data["telefono"] . $data["telefono_alternativo"] != "" ? " / " . $data["telefono_alternativo"] : ''; ?></span>
														</p>
														<h4 class="title-cv">&nbsp; EXPERIENCIA LABORAL</h4>
														<div id="experiencias">
															<?php $mes = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");?>
															<?php if ($experiencias): ?>
															<?php foreach ($experiencias as $e): ?>

															<p class="content-cv" style="margin-bottom: 20px;">
																<strong>Empresa: </strong>
																<?php echo $e["nombre_empresa"]; ?><br>
																<strong>País: </strong>
																<?php echo $e["nombre_pais"]; ?><br>
																<strong>Actividad: </strong>
																<?php echo $e["actividad_empresa"]; ?><br>
																<strong>Tipo puesto: </strong>
																<?php echo $e["tipo_puesto"]; ?><br>
																<strong>Tiempo: </strong>
																<?php echo $mes[$e["mes_ingreso"] - 1] . "/" . $e["ano_ingreso"] . " - " . $egreso ?><br>
																<strong>Descripción de tareas: </strong>
																
																	<span style="word-break: break-word;"><?php echo $e["descripcion_tareas"] ?></span>
																
															</p>
															<?php endforeach?>
															<?php else: ?>
															<p class="content-cv" style="margin-bottom: 20px;"><em><b>"Sin Experiencia Laboral, pero con muchas ganas de aprender"</b></em></p>
															<?php endif?>
														</div>


														<h4 class="title-cv">&nbsp; Estudios</h4>
														<div id="educacion">
															<?php if ($educacion): ?>
																<?php foreach ($educacion as $e): ?>
																	<p class="content-cv" style="margin-bottom: 20px;">
																		<strong>Nivel estudio: </strong>
																		<?php echo $e["nivel"]; ?><br>
																		<strong>País: </strong>
																		<?php echo $e["nombre_pais"]; ?><br>
																		<strong>Estado estudio: </strong>
																		<?php echo $e["estado_estudio"]; ?><br>
																		<strong>Área estudio: </strong>
																		<?php echo $e["nombre_estudio"]; ?><br>
																	</p>
																<?php endforeach?>
															<?php else: ?>
															<p class="content-cv" style="margin-bottom: 20px;">Sin registros</p>
															<?php endif?>
														</div>

														<h4 class="title-cv">&nbsp; Idiomas</h4>
														<div id="idiomas">
															<?php if ($idiomasT): ?>
																<?php foreach ($idiomasT as $i): ?>
																<?php $nivel_oral    = $db->getOne("SELECT nombre FROM nivel_idioma WHERE id=$i[nivel_oral]");?>
																<?php $nivel_escrito = $db->getOne("SELECT nombre FROM nivel_idioma WHERE id=$i[nivel_escrito]");?>
																	<p class="content-cv" style="margin-bottom: 20px;">
																		<strong>Idioma: </strong>
																		<?php echo $i["nombre_idioma"]; ?><br>
																		<strong>Nivel Oral: </strong>
																		<?php echo $nivel_oral; ?><br>
																		<strong>Nivel escrito: </strong>
																		<?php echo $nivel_escrito; ?><br>
																	</p>
																<?php endforeach?>
																<?php else: ?>
																	<p class="content-cv" style="margin-bottom: 20px;">Sin registros</p>
															<?php endif?>
														</div>

														<h4 class="title-cv">&nbsp; Otros conocimientos</h4>
														<div id="otros_conocimientos">
															<?php if ($otros_conocimientos): ?>
															<?php foreach ($otros_conocimientos as $o): ?>
															<p class="content-cv" style="margin-bottom: 20px;">
																<strong>Título: </strong>
																<?php echo $o["nombre"]; ?><br>
																<strong>Descripción: </strong>
															
																	<?php echo $o["descripcion"]; ?>
																<br>
															</p>
															<?php endforeach?>
															<?php else: ?>
															<p class="content-cv" style="margin-bottom: 20px;">Sin registros</p>
															<?php endif?>
														</div>

														<?php $infoExtra = $db->getRow("SELECT * FROM trabajadores_infextra WHERE id_trabajador=" . $_SESSION['ctc']['id']);?>

														<h4 class="title-cv">&nbsp; Información Extra</h4>
														<div id="infoExtra">
														<?php if ($infoExtra): ?>
															<p class= "content-cv" style="margin-bottom: 20px;">
																<strong>Remuneración pretendida: </strong> $<span id="labelRem"><?=$infoExtra['remuneracion_pret']?></span> <br>
																<strong>Sobre mí: </strong> <span id="labelSobreMi"><?=$infoExtra['sobre_mi']?></span> <br>
																<strong>Disponibilidad: </strong> 
																<span id="labelDisp"><?=$db->getOne("SELECT nombre FROM disponibilidad WHERE id=$infoExtra[disponibilidad]");?></span> <br>
															</p>
															<?php else: ?>
																<p class="content-cv" style="margin-bottom: 20px;">Sin registros</p>
															<?php endif?>
														</div>
													</div>
													<!-- </div> -->
												</div>
											<!-- </div> -->
										</div>
									</div>
									
									<div class="row" style="margin-top: 20px;">
										<div class="col-md-4" style="text-align: left;"><a href="javascript:void(0)" class="btn btn-primary w-min-sm m-b-0-25 waves-effect waves-light back-next" data-target="6" style="margin-left: 25px;"><i class="ti-angle-left"></i> Anterior</a></div>
										<div class="col-md-4" style="text-align: center;"></div>
										<div class="col-md-4" style="text-align: right;"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- Footer -->
				<?php require_once 'includes/footer.php';?>
			</div>
		<!-- </div> -->

		<?php require_once 'includes/libs-js.php';?>

		<script type="text/javascript" src="vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
		<script type="text/javascript" src="vendor/moment/moment.js"></script>
		<script type="text/javascript" src="vendor/bootstrap-daterangepicker/daterangepicker.js"></script>
		<!-- FIXME: Resolver lo del bootstra-slider que no esta entre los archivos. Lo puse como cdn -->
		<!-- <script type="text/javascript" src="vendor/bootstrap-slider/dist/bootstrap-slider.min.js"></script> -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.0.0/bootstrap-slider.min.js"></script>
		<script type="text/javascript" src="vendor/bootstrap-switch-master/dist/js/bootstrap-switch.min.js"></script>

			<script>

				$(document).ready(function(){

					$('#stateS').change(function(){
						if (parseInt($(this).val()) == 1 || parseInt($(this).val()) == 3){
							$('#fechaFin').css('display','none');
						}else{
							$('#fechaFin').css('display','block');
						}
					});

					<?php if(!$experiencias): ?>
						$('#sinExpLab').bootstrapSwitch({ // Switch de Experiencia Laboral
							onColor: 'primary',
							offColor: 'danger',
							state: false,
							onText: 'SÍ',
							offText: 'NO'
						});

						var txtEmpresa = $('#company'); // Todos los campos de Experiencia laboral
						var selectUbic = $('#rCompany');
						var selectActiv = $('#tCompany');
						var txtJerarquia = $('#tEmployeer');
						var selectMesIng = $('#monthI');
						var selectAnioIng = $('#yearI');
						var selectMesEgr = $('#monthE');
						var selectAnioEgr = $('#yearE');
						var checkTrabAct = $('#trab_actual');
						var txtNomEnc = $('#nom_enc');
						var txtTlfEnc = $('#tlf_enc');
						var txtDescription = $('#descriptionArea');

							txtEmpresa.prop('disabled', true);
							selectUbic.prop('disabled', true);
							selectActiv.prop('disabled', true);
							txtJerarquia.prop('disabled', true);
							selectMesIng.prop('disabled', true);
							selectAnioIng.prop('disabled', true);
							selectMesEgr.prop('disabled', true);
							selectAnioEgr.prop('disabled', true);
							checkTrabAct.prop({'disabled': true, 'checked': false});
							txtNomEnc.prop('disabled', true);
							txtTlfEnc.prop('disabled', true);
							txtDescription.prop('disabled', true);
							$('.save[data-target="2"], .reset[data-target="2"]').hide();

					<?php else: ?>
						$('#sinExpLab').bootstrapSwitch({ // Switch de Experiencia Laboral
							onColor: 'primary',
							offColor: 'danger',
							state: true,
							onText: 'SÍ',
							offText: 'NO'
						});
					<?php endif; ?>

					<?php if(!$otros_conocimientos): ?>

						$('#sinOtrCon').bootstrapSwitch({ // Switch de Experiencia Laboral
							onColor: 'primary',
							offColor: 'danger',
							state: false,
							onText: 'SÍ',
							offText: 'NO'
						});

						$('#nameC').prop('disabled', true);
						$('#descriptionC').prop('disabled', true);
						$('.save[data-target="5"], .reset[data-target="5"]').hide();

					<?php else: ?>
						$('#sinOtrCon').bootstrapSwitch({ // Switch de Experiencia Laboral
							onColor: 'primary',
							offColor: 'danger',
							state: true,
							onText: 'SÍ',
							offText: 'NO'
						});
					<?php endif; ?>

					$('#ex1').slider({
						formatter: function(value) {
							return value + ' ARS';
						}
					}); // Cargando plugin del slider!

					// Remuneración pretendida.!
					$('#ex1').on('change', function(){
						var valRange = $(this).val();

						$('#remuneracion').val(valRange);
						$('#mobileText').text(valRange + ' ARS');
					});

					$('#trab_actual').on('click', function() {
						var $this = $(this);
						if ($this.is(':checked')) {
							$('#monthE').prop('disabled', true);
							$('#yearE').prop('disabled', true);
							$('#monthE').hide();
							$('#yearE').hide();
							$('#label_yearE').hide();
							$('#label_monthE').hide();
						} else {
							$('#monthE').prop('disabled', false);
							$('#yearE').prop('disabled', false);
							$('#monthE').show();
							$('#yearE').show();
							$('#label_yearE').show();
							$('#label_monthE').show();
						}
					});

					$('#sinExpLab').on('switchChange.bootstrapSwitch', function(event, state){
						var txtEmpresa = $('#company'); // Todos los campos de Experiencia laboral
						var selectUbic = $('#rCompany');
						var selectActiv = $('#tCompany');
						var txtJerarquia = $('#tEmployeer');
						var selectMesIng = $('#monthI');
						var selectAnioIng = $('#yearI');
						var selectMesEgr = $('#monthE');
						var selectAnioEgr = $('#yearE');
						var checkTrabAct = $('#trab_actual');
						var txtNomEnc = $('#nom_enc');
						var txtTlfEnc = $('#tlf_enc');
						var txtDescription = $('#descriptionArea');

						if (state) { // if is :checked
							txtEmpresa.prop('disabled', false);
							selectUbic.prop('disabled', false);
							selectActiv.prop('disabled', false);
							txtJerarquia.prop('disabled', false);
							selectMesIng.prop('disabled', false);
							selectAnioIng.prop('disabled', false);
							selectMesEgr.prop('disabled', false);
							selectAnioEgr.prop('disabled', false);
							checkTrabAct.prop('disabled', false);
							txtNomEnc.prop('disabled', false);
							txtTlfEnc.prop('disabled', false);
							txtDescription.prop('disabled', false);
							$('.save[data-target="2"], .reset[data-target="2"]').show();
						} else {
							txtEmpresa.prop('disabled', true);
							selectUbic.prop('disabled', true);
							selectActiv.prop('disabled', true);
							txtJerarquia.prop('disabled', true);
							selectMesIng.prop('disabled', true);
							selectAnioIng.prop('disabled', true);
							selectMesEgr.prop('disabled', true);
							selectAnioEgr.prop('disabled', true);
							checkTrabAct.prop({'disabled': true, 'checked': false});
							txtNomEnc.prop('disabled', true);
							txtTlfEnc.prop('disabled', true);
							txtDescription.prop('disabled', true);
							$('.save[data-target="2"], .reset[data-target="2"]').hide();
							//Resetearlos
							txtEmpresa.val("");
							selectUbic.val("");
							selectActiv.val("");
							txtJerarquia.val("");
							selectMesIng.val("");
							selectAnioIng.val("");
							selectMesEgr.val("");
							selectAnioEgr.val("");
							txtNomEnc.val("");
							txtTlfEnc.val("");
							txtDescription.val("");
						}
					});

					$('#sinOtrCon').on('switchChange.bootstrapSwitch', function(event, state){

						if (state) {
							$('#nameC').prop('disabled', false);
							$('#descriptionC').prop('disabled', false);
							$('.save[data-target="5"], .reset[data-target="5"]').show();
						} else {
							$('#nameC').prop('disabled', true).val("");
							$('#descriptionC').prop('disabled', true).val("");
							$('.save[data-target="5"], .reset[data-target="5"]').hide();
						}
					});

					$('.tooltip-main').addClass('show');

					var view = <?php echo isset($_GET["o"]) ? 1 : 0; ?>;
					var postulate = <?php echo isset($_SESSION["ctc"]["postulate"]) ? $_SESSION["ctc"]["postulate"] : 0; ?>;
					if(view == 1 && postulate == 1) {
						$("li.nav-item:nth-child(7) > a:nth-child(1)").click();
					}

					<?php if (count($infoExtra) > 1): ?>

					<?php 
						$buscar=array(chr(13).chr(10), "\r\n", "\n", "\r");
						$reemplazar=array("", "", "", "");
						$cadena=str_ireplace($buscar,$reemplazar,$infoExtra['sobre_mi']);
					?>

					var remuneracion = "<?=$infoExtra['remuneracion_pret']?>";
					var sobre_mi = "<?=$cadena?>";
					var disponibilidad = "<?=$infoExtra['disponibilidad']?>";
					remuneracion = parseInt(remuneracion);
					disponibilidad = parseInt(disponibilidad);

					$('#remuneracion').val(remuneracion);

					$('#sobre_mi').val(sobre_mi);

					$('#disp').val(disponibilidad);

					$(".save[data-target=6]").attr('data-edit',2).attr('data-i',<?=$_SESSION['ctc']['id']?>);

					<?php endif;?>

					<?php if ($data['fecha_nacimiento'] != ""): ?>

					var f = "<?=$data['fecha_nacimiento']?>";
					var division = f.split("-");
					var dia = division[2], mes = division[1], anio = division[0];

					$("#dia").val(dia);
					$("#mes").val(mes);
					$("#anio").val(anio);

					<?php endif;?>


					$("#sNivel").change(function() {
						if(this.value == 1) {
							$("#materias_aprobadas").css("display", "none");
						}
						else {
							$("#materias_aprobadas").css("display", "block");
						}
					});

					$(".nav-link").click(function(e) {

							if($(this).attr("href") == "#tab7") { // Pestaña de vista previa

							$.ajax({
								type: 'POST',
								url: 'ajax/account.php',
								data: 'op=7',
								dataType: 'json',
								success: function(data) {

										$("#labelName").html(data.usuario.nombres);
										$("#labelLastName").html(data.usuario.apellidos);
										$("#labelDNI").html(data.usuario.dni);
										$("#labelCuil").html(data.usuario.cuil);
										$("#labelCountry").html(data.usuario.localidad+", "+data.usuario.provincia+", "+data.usuario.pais);
										$("#labelEmail").html(data.usuario.correo_electronico);
										$(".labelTlf").html(data.usuario.telefono + " / " + data.usuario.telefono_alternativo);
	                                    var fecha = formato(data.usuario.fecha_nacimiento);
										$("#fecha_nac").html(fecha);
	                                    var edad = data.usuario.edad;
	                                    $("#edad").html((edad)+" años");

	                                    if (Object.keys(data.info_extra).length > 0) {
	                                    	var html = "<p class='content-cv'><strong>Remuneración pretendida: </strong> $<span id='labelRem'>"+data.info_extra.remuneracion_pret+"</span> <br><strong>Sobre mí: </strong> <span id='labelSobreMi'>"+data.info_extra.sobre_mi+"</span> <br><strong>Disponibilidad: </strong> <span id='labelDisp'>"+data.info_extra.disponibilidad+"</span></p>";
	                                    	$('#infoExtra').html(html);

	                                    }

										var html = "";
										var mes = ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
										if(data.educacion.length > 0) {
											data.educacion.forEach(function(e) {
												html += '<p class="content-cv"><strong>Nivel estudio: </strong> '+e.nivel+'<br> <strong>Título o Certificación: </strong> '+e.titulo+' <br /> <strong>País: </strong> '+e.nombre_pais+'<br> <strong>Estado estudio: </strong> '+e.estado_estudio+'<br> <strong>Área estudio: </strong> '+e.nombre_estudio+'<br></p>';
											});
											$("#educacion").html(html);
										}
										if (data.experiencias.length > 0) {
											html = "";
											data.experiencias.forEach(function(ex){

												let nom_encargado = ex.nombre_encargado == null || ex.nombre_encargado == '' ? 'No Aplica' : ex.nombre_encargado;
												let tlf_encargado = ex.tlf_encargado == null || ex.tlf_encargado == '' ? 'No Aplica' : ex.tlf_encargado;
												let egreso = ex.trab_actualmt == 1 ? 'Actualmente' : mes[ex.mes_egreso-1] +'/'+ ex.ano_egreso;

												html += '<p class="content-cv"><strong>Empresa: </strong>'+ex.nombre_empresa+'<br> <strong>País: </strong>'+ex.nombre_pais+' <br> <strong>Actividad: </strong>'+ex.actividad_empresa+'<br> <strong>Tipo puesto: </strong>'+ex.tipo_puesto+'<br><strong>Tiempo: </strong>'+mes[ex.mes_ingreso-1]+'/'+ex.ano_ingreso + ' - ' + egreso + '<br> <strong>Encargado de Referencias: </strong>'+ nom_encargado + '<br> <strong>Telefono del Encargado: </strong>'+ tlf_encargado + '<br> <strong>Descripción de tareas: </strong><span style="word-wrap: break-word;"'+
													ex.descripcion_tareas + '</span></p>';
											});
											$('#experiencias').html(html);
										}
										if(data.idiomas.length > 0) {
											html = "";
											data.idiomas.forEach(function(i) {
												html += '<p class="content-cv"> <strong>Idioma: </strong> '+i.nombre_idioma+'<br> <strong>Nivel Oral: </strong> '+i.nivel_oral+'<br> <strong>Nivel escrito: </strong> '+i.nivel_escrito+'<br> </p>';
											});
											$("#idiomas").html(html);
										}
										if(data.otros_conocimientos.length > 0) {
											html = "";
											data.otros_conocimientos.forEach(function(oc) {
												html += '<p class="content-cv"> <strong>Título: </strong> '+oc.nombre+'<br> <strong>Descripción: </strong> '+oc.descripcion+'<br> </p>';
											});
											$("#otros_conocimientos").html(html);
										}
								}
							});
						}

					});

					var currentParent = null;
					var sex = parseInt(JSON.parse('<?php echo $data["id_sexo"] != "" ? $data["id_sexo"] : 0; ?>'));
					var pais = parseInt(JSON.parse('<?php echo $data["id_pais"] != "" ? $data["id_pais"] : 0; ?>'));
					var estadoCivil = parseInt(JSON.parse('<?php echo $data["id_estado_civil"] != "" ? $data["id_estado_civil"] : 0; ?>'));
					var dni = parseInt(JSON.parse('<?php echo $data["id_tipo_documento_identificacion"] != "" ? $data["id_tipo_documento_identificacion"] : 0; ?>'));
					var provincia = parseInt(JSON.parse('<?php echo $data["provincia"] != "" ? $data["provincia"] : 0; ?>'));
					var localidad = parseInt(JSON.parse('<?php echo $data["localidad"] != "" ? $data["localidad"] : 0; ?>'));
					if(sex > 0) {
						$("input[type=radio][name=sex]").each(function(index, value) {
							if(value.value == sex) {
								value.checked = true;
							}
						});
					}

					$("#country").val(pais);
					$("#estadoCivil").val(estadoCivil);
					$("#dni").val(dni);
					$("#vic_provincias").val(provincia);
					if (provincia != 0) {
						$('#localidad_0').hide();
					}
					$("#localidad_"+provincia).show().val(localidad);

					$('#birthday').datepicker({
						format: "mm/dd/yyyy",
						clearBtn: true
					});

					<?php if ($experiencias): ?>
					$(".modifyEL").click(function() {
						currentParent = $(this).closest("tr");
						var target = $(this).attr("data-target");
						var option = $(this).attr("data-option");
						$(".save").each(function(index, value) {
							if($(this).attr("data-target") == option) {
								$(this).attr("data-edit", 2);
								$(this).attr("data-i", target);
							}
						});

						$.ajax({
							type: 'POST',
							url: 'ajax/account.php',
							data: 'op=2&i=' + target + '&opt=' + option,
							dataType: 'json',
							success: function(data) {
								$("#company").val(data.nombre_empresa);
								$("#rCompany").val(data.id_pais);
								$("#tCompany").val(data.id_actividad_empresa);
								$("#tEmployeer").val(data.tipo_puesto);
								$("#monthI").val(data.mes_ingreso);
								$("#yearI").val(data.ano_ingreso);
								
								if (data.trab_actualmt == 1) {
									$('#trab_actual').prop('checked',true);
									$("#monthE").val('1');
									$("#yearE").val('1950');
									$("#monthE").prop('disabled', true);
									$("#yearE").prop('disabled', true);
								} else {
									$("#monthE").val(data.mes_egreso);
									$("#yearE").val(data.ano_egreso);
								}
								$("#nom_enc").val(data.nombre_encargado);
								$("#tlf_enc").val(data.tlf_encargado);
								$("#descriptionArea").val(data.descripcion_tareas);
							}
						});
					});
					<?php endif?>

					<?php if ($educacion): ?>
					$(".modifyES").click(function() {
						currentParent = $(this).closest("tr");
						var target = $(this).attr("data-target");
						var option = $(this).attr("data-option");
						$(".save").each(function(index, value) {
							if($(this).attr("data-target") == option) {
								$(this).attr("data-edit", 2);
								$(this).attr("data-i", target);
							}
						});

						$.ajax({
							type: 'POST',
							url: 'ajax/account.php',
							data: 'op=2&i=' + target + '&opt=' + option,
							dataType: 'json',
							success: function(data) {
								$("#sNivel").val(data.id_nivel_estudio);
								$("#titleS").val(data.titulo);
								$("#stateS").val(data.id_estado_estudio);
								$("#areaS").val(data.id_area_estudio);
								$("#institute").val(data.nombre_institucion);
								$("#countryS").val(data.id_pais);
								$("#monthIn").val(data.mes_inicio);
								$("#yearIn").val(data.ano_inicio);
								$("#monthFi").val(data.mes_finalizacion);
								$("#yearFi").val(data.ano_finalizacion);
								$("#mat").val(data.materias_carrera);
								$("#aprob").val(data.materias_aprobadas);
							}
						});
					});
					<?php endif?>

					<?php if ($idiomasT): ?>
					$(".modifyI").click(function() {
						currentParent = $(this).closest("tr");
						var target = $(this).attr("data-target");
						var option = $(this).attr("data-option");
						$(".save").each(function(index, value) {
							if($(this).attr("data-target") == option) {
								$(this).attr("data-edit", 2);
								$(this).attr("data-i", target);
							}
						});

						$.ajax({
							type: 'POST',
							url: 'ajax/account.php',
							data: 'op=2&i=' + target + '&opt=' + option,
							dataType: 'json',
							success: function(data) {
								$("#idioma").val(data.id_idioma);
								$("input[type=radio][name=nivelO]").each(function(index, value) {
									if(value.value == data.nivel_oral) {
										value.checked = true;
									}
								});
								$("input[type=radio][name=nivelE]").each(function(index, value) {
									if(value.value == data.nivel_escrito) {
										value.checked = true;
									}
								});
							}
						});
					});

					<?php endif?>

					<?php if ($otros_conocimientos): ?>
					$(".modifyOC").click(function() {
						currentParent = $(this).closest("tr");
						var target = $(this).attr("data-target");
						var option = $(this).attr("data-option");
						$(".save").each(function(index, value) {
							if($(this).attr("data-target") == option) {
								$(this).attr("data-edit", 2);
								$(this).attr("data-i", target);
							}
						});

						$.ajax({
							type: 'POST',
							url: 'ajax/account.php',
							data: 'op=2&i=' + target + '&opt=' + option,
							dataType: 'json',
							success: function(data) {
								$("#nameC").val(data.nombre);
								$("#descriptionC").val(data.descripcion);
							}
						});
					});
					<?php endif?>

					loadEvents();

					$(".back-next").click(function() {
						var i = $(this).attr("data-target");
						$(".nav-link").each(function() {
							if($(this).attr("href") == "#tab"+i) {
								$(this).click();
							}
						});
					});

					$(".reset").click(function() {
						currentParent = null;
						var i = parseInt($(this).attr("data-target"));
						$(".save").each(function(index, value) {
							if($(this).attr("data-target") == i) {
								if (i != 6) {
									$(this).attr("data-edit", 1);
									$(this).attr("data-i", 0);
								}
							}
						});
						switch(i) {
							case 2:
								$("#company").val("");
								$("#rCompany").val(0);
								$("#tCompany").val(0);
								$("#tEmployeer").val("");
								$("#monthI").val(1);
								$("#yearI").val(2016);
								$("#monthE").val(1);
								$("#yearE").val(2016);
								$("#nom_enc").val("");
								$("#tlf_enc").val("");
								$("#descriptionArea").val("");
								break;
							case 3:
								$("#sNivel").val(0);
								$("#titleS").val("");
								$("#stateS").val(0);
								$("#areaS").val(0);
								$("#institute").val("");
								$("#countryS").val(0);
								$("#monthIn").val(1);
								$("#yearIn").val(2015);
								$("#monthFi").val(1);
								$("#yearFi").val(2016);
								$("#mat").val("");
								$("#aprob").val("");
								break;
							case 4:
								$("#idioma").val(0);
								$("input[type=radio][name=nivelO]").each(function(index, value) {
									value.checked = false;
								});
								$("input[type=radio][name=nivelE]").each(function(index, value) {
									value.checked = false;
								});
								break;
							case 5:
								$("#nameC").val("");
								$("#descriptionC").val("");
								break;
							case 6:
								$('#remuneracion').val('');
								$('#objLab').val('');
								$('#cartaPres').val('');
								break;
						}
					});

					$(".save").click(function() {
						var band = false;
						var op = parseInt($(this).attr("data-target"));
						var str = "";
						var edit = parseInt($(this).attr("data-edit"));
						var elemento = $(this);

						switch(op) {
							case 1:
								if($("#name").val() != "" && $("#lastName").val() != "" && $('#email').val() != "" && $("input[type=radio][name=sex]:checked").length > 0 && parseInt($('#dia').val()) > 0 && parseInt($('#mes').val()) > 0 && parseInt($('#anio').val()) > 0 && parseInt($("#country").val()) > 0 && parseInt($("#dni").val()) > 0 && $("#numberdni").val() != "" && $("#cuil").val() != "" && parseInt($("#vic_provincias").val()) > 0 && parseInt($(".city:visible").val()) > 0 && $("#street").val() != "" && $("#phone").val() != "") {
									str = '&name='+$("#name").val() + '&lastName='+$("#lastName").val() + '&email='+ $('#email').val() + '&sex='+$("input[type=radio][name=sex]:checked").val() + '&birthday='+$("#anio").val()+'-'+$("#mes").val() +'-'+$("#dia").val() + '&country='+$("#country").val() + '&estadoCivil='+$("#estadoCivil").val() + '&dni='+$("#dni").val() + '&numberdni='+$("#numberdni").val() + '&cuil='+$("#cuil").val() + '&province='+$("#vic_provincias").val() + '&city='+$(".city:visible").val() + '&street='+$("#street").val() + '&phone='+$("#phone").val() + '&phoneAlt='+$("#phoneAlt").val();
									band = true;
								}
								break;
							case 2:
								
									if($("#company").val() != "" && parseInt($("#rCompany").val()) > 0 && parseInt($("#tCompany").val()) > 0 && $("#tEmployeer").val() != "" && $("#descriptionArea").val() != "") {

										if ($('#trab_actual').is(':checked')) {
											str = '&company='+$("#company").val() + '&rCompany='+$("#rCompany").val() + '&tCompany='+$("#tCompany").val() + '&tEmployeer='+$("#tEmployeer").val() + '&descriptionArea='+$("#descriptionArea").val() + '&monthI='+$("#monthI").val() + '&yearI='+$("#yearI").val() + '&monthE=0&yearE=9999&trab_actual=1&nom_enc='+$('#nom_enc').val()+'&tlf_enc='+$('#tlf_enc').val();
											band = true;
										} else {

											if(parseInt($("#yearE").val()) >= parseInt($("#yearI").val())) {
												str = '&company='+$("#company").val() + '&rCompany='+$("#rCompany").val() + '&tCompany='+$("#tCompany").val() + '&tEmployeer='+$("#tEmployeer").val() + '&descriptionArea='+$("#descriptionArea").val() + '&monthI='+$("#monthI").val() + '&yearI='+$("#yearI").val() + '&monthE='+$("#monthE").val() + '&yearE='+$("#yearE").val()+'&trab_actual=0&nom_enc='+$('#nom_enc').val()+'&tlf_enc='+$('#tlf_enc').val();
												band = true;
											} else {
												swal({
													title: 'Información!',
													text: 'El año de egreso debe ser mayor que el año de ingreso',
													timer: 2000,
													confirmButtonClass: 'btn btn-primary btn-lg',
													buttonsStyling: false
												});
												return false;

											}

										}
										
									}

									if ($('#nom_enc').val() != "" && $('#tlf_enc').val() == ""){

											band = false;

									} else if ($('#nom_enc').val() == "" && $('#tlf_enc').val() != ""){

											band = false;

									}
								break;
							case 3:
								if(parseInt($("#sNivel").val()) > 0 && $("#titleS").val() != "" && parseInt($("#stateS").val()) > 0 && parseInt($("#areaS").val()) > 0 && $("#institute").val() != "" && parseInt($("#countryS").val()) > 0) {
									if(parseInt($('#stateS').val()) != 1){
										if(parseInt($("#yearFi").val()) >= parseInt($("#yearIn").val())) {
											str = '&sNivel='+$("#sNivel").val() + '&titleS='+$("#titleS").val() + '&stateS='+$("#stateS").val() + '&areaS='+$("#areaS").val() + '&institute='+$("#institute").val() + '&countryS='+$("#countryS").val() + '&mat='+$("#mat").val() + '&aprob='+$("#aprob").val() + '&monthIn='+$("#monthIn").val() + '&yearIn='+$("#yearIn").val() + '&monthFi='+$("#monthFi").val() + '&yearFi='+$("#yearFi").val();
											band = true;
										}else {
											swal({
												title: 'Información!',
												text: 'El año de finalización debe ser mayor que el año de inicio',
												timer: 2000,
												confirmButtonClass: 'btn btn-primary btn-lg',
												buttonsStyling: false
											});
											return false;
										}			
									}else{
										
										if(edit!=2){
											$("#monthFi").val('')
											$("#yearFi").val('');
										}else{
											if(parseInt($("#yearFi").val()) < parseInt($("#yearIn").val())) {
												swal({
													title: 'Información!',
													text: 'El año de finalización debe ser mayor que el año de inicio',
													timer: 2000,
													confirmButtonClass: 'btn btn-primary btn-lg',
													buttonsStyling: false
												});
												return false;
											}
										}
										str = '&sNivel='+$("#sNivel").val() + '&titleS='+$("#titleS").val() + '&stateS='+$("#stateS").val() + '&areaS='+$("#areaS").val() + '&institute='+$("#institute").val() + '&countryS='+$("#countryS").val() + '&mat='+$("#mat").val() + '&aprob='+$("#aprob").val() + '&monthIn='+$("#monthIn").val() + '&yearIn='+$("#yearIn").val() + '&monthFi='+$("#monthFi").val() + '&yearFi='+$("#yearFi").val();
										band = true;
									}
									

									if(parseInt($("#sNivel").val()) != 1) {
										if($("#mat").val() != "" && $("#aprob").val() != "") {
											band = true;
										}
									}
								}/*else{
									swal({
										title: 'Información!',
										text: 'Por favor, Llenar todos los campos',
										timer: 5000,
										confirmButtonClass: 'btn btn-primary btn-lg',
										buttonsStyling: false
									});
									return false;
								}*/
								break;
							case 4:
								if(parseInt($("#idioma").val()) > 0 && $("input[type=radio][name=nivelO]").length > 0 && $("input[type=radio][name=nivelE]").length > 0 ) {
									str = '&idioma=' + $("#idioma").val() + '&nivelO=' + $("input[type=radio][name=nivelO]:checked").val() + '&nivelE=' + $("input[type=radio][name=nivelE]:checked").val();
									band = true;
								}
								break;
							case 5:

								if($("#nameC").val() != "" && $("#descriptionC").val() != "") {
									str = '&nameC=' + $("#nameC").val() + '&descriptionC=' + $("#descriptionC").val();
									band = true;
								}

								break;
							case 6:
								if($('#remuneracion').val() != '' && $('#sobre_mi').val() != '' && $('#disp').val() > 0){
									
									str = '&remuneracion=' + $('#remuneracion').val() + '&disp=' + $('#disp').val() + '&sobre_mi=' + $('#sobre_mi').val() + '&sitio_web='+$('#web').val()+'&fb='+$('#fb').val()+'&tw='+$('#tw').val()+'&ig='+$('#ig').val()+'&snap='+$('#snap').val()+'&lkd='+$('#lkd').val();
									band = true;

									if ($('#web').val() != "" || $('#fb').val() != "" || $('#tw').val() != "" || $('#ig').val() != "" || $('#snap').val() != "" || $('#lkd').val() != "") {

										// Validar link de facebook
										var fb = /^(https:\/\/((www.facebook)|(facebook)).com\/)[A-Za-z0-9.\-\_]+(\/)?$/;
										
										if ($('#fb').val()) {
											if (!fb.test($('#fb').val())) {

												$('.alert.alert-danger').show();

												$('.alert.alert-danger span#errorRS').text("El formato del link es invalido. Si no posees Facebook deja el campo en blanco.");
												band = false;
											}
										}

										//Validar link de twitter
										var tw = /^(https:\/\/((www.twitter)|(twitter)).com\/)[A-Za-z0-9.\-\_]+(\/)?$/;
										
										if ($('#tw').val()) {
											if (!tw.test($('#tw').val())) {
												$('.alert.alert-danger').show();

												$('.alert.alert-danger span#errorRS').text("El formato del link es invalido. Si no posees Twitter deja el campo en blanco.");
												band = false;
											}
										}

										//Validar link de Instagram
										var ig = /^(https:\/\/((www.instagram)|(instagram)).com\/)[A-Za-z0-9.\-\_]+(\/)?$/;
										
										if ($('#ig').val()) {
											if (!ig.test($('#ig').val())) {
												$('.alert.alert-danger').show();

												$('.alert.alert-danger span#errorRS').text("El formato del link es invalido. Si no posees Instagram deja el campo en blanco.");
												band = false;
											}
										}

										//Validar nombre de usuario de Snapchat
										var snap = /^[A-Za-z0-9.\-\_]+$/;
										
										if ($('#snap').val() != "") {
											if (!snap.test($('#snap').val())) {
												$('.alert.alert-danger').show();

												$('.alert.alert-danger span#errorRS').text("El formato del nombre de usuario es invalido. Si no posees Snapchat deja el campo en blanco.");
												band = false;
											}
										}

										//Validar URL de sitio web
										var web = /^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \?=.-]*)*\/?$/;
										
										if ($('#web').val() != "") {
											if (!web.test($('#web').val())) {
												$('.alert.alert-danger').show();

												$('.alert.alert-danger span#errorRS').text("La Url del sitio web es invalido. Si no posees pagina web deja el campo en blanco.");
												band = false;
											}
										}

										//Validar link de perfil de Linkedin
										var lkd = /^(https:\/\/((www.linkedin)|(linkedin)).com\/in\/)[A-Za-z0-9.\-\_\/]+(\/)?$/;
										
										if ($('#lkd').val() != "") {
											if (!lkd.test($('#lkd').val())) {
												$('.alert.alert-danger').show();

												$('.alert.alert-danger span#errorRS').text("El formato del link es invalido. Si no posees Linkedin deja el campo en blanco.");
												band = false;
											}
										}
									}
								}
								break;
						}
						if(band) {
							$(elemento).addClass('disabled').text('Guardando...');
							var e = '';
							var ele = $(this);
							if(edit == 2) {
								e = '&i=' + $(this).attr("data-i");
							}
							$.ajax({
								type: 'POST',
								url: 'ajax/account.php',
								data: 'op=1&opt=' + op + str + e,
								dataType: 'json',
								success: function(data) {
									$(elemento).removeClass('disabled').html('Guardar <i class="fa fa-floppy-o"></i>');
									$('.alert.alert-danger').hide();
									ele.attr("data-i");
									if (ele.attr("data-target") != 6) {
										ele.attr("data-edit", 1);
									} else {
										ele.attr("data-edit", 2);
									}

									/*swal({
										title: 'Información!',
										text: 'Información almacenada exitosamente.',
										timer: 2000,
										confirmButtonClass: 'btn btn-primary btn-lg',
										buttonsStyling: false
									});*/

									switch(op) {
										case 1:
											//$(".nav-link").removeClass("disabled");
											$(".back-next").removeClass("disabled");

											swal({
												  title: "Exito",
												  text: "Información almacenada exitosamente! Desea pasar a la siguiente fase?",
												  type: "success",
												  showCancelButton: true,
												  confirmButtonColor: "#DD6B55",
												  confirmButtonText: "Siguiente fase",
												  cancelButtonText: "Cancelar",
												  closeOnConfirm: false
												});

											$(".show-swal2.visible .swal2-confirm").attr('data-action', 'sig2');

											$(".show-swal2.visible .swal2-confirm").click(function() {
												if($(this).attr('data-action') == 'sig2') {
													$(this).attr('data-action', '');

													$('.nav .nav-item a[href="#tab2"]').click();
												}
											});

											break;
										case 2:
											$("#company").val("");
											$("#rCompany").val(0);
											$("#tCompany").val(0);
											$("#tEmployeer").val("");
											$("#monthI").val(1);
											$("#yearI").val(2016);
											$("#monthE").val(1);
											$("#yearE").val(2016);
											$("#descriptionArea").val("");

											if (Object.keys(data.data).length > 0) {
												$("#contentEL").css("display", "block");
												$("#containerSinExpLab").remove();
											}

											var text = '';
											if(edit == 2) {
												data.data.forEach(function(d) {
													currentParent.html('<td>'+d.nombre_empresa+'</td><td>'+d.nombre_pais+'</td><td>'+d.actividad_empresa+'</td><td>'+d.tipo_puesto+'</td><td><div class="pull-xs-left"><a class="text-success m-r-1 modifyEL" href="javascript:void(0)" data-target="'+d.id+'" data-option="2" style="font-size: 20px"><i class="fa fa-pencil-square"></i></a> <a class="text-danger deleteItem" href="javascript:void(0)" data-target="'+d.id+'" data-option="2" style="font-size: 20px; margin-left: 5px"><i class="fa fa-ban"></i></a></div></td>');
													text += '<p style="margin-left: 50px;"> <strong>Empresa: </strong> '+d.nombre_empresa+'<br> <strong>País: </strong> '+d.nombre_pais+'<br> <strong>Actividad: </strong> '+d.actividad_empresa+'<br> <strong>Tipo puesto: </strong> '+d.tipo_puesto+'<br> </p>';
												});
												$("#experiencias").append(text);
											}
											else {
												data.data.forEach(function(d) {
													$("#t2").append('<tr><td>'+d.nombre_empresa+'</td><td>'+d.nombre_pais+'</td><td>'+d.actividad_empresa+'</td><td>'+d.tipo_puesto+'</td><td><div class="pull-xs-left"><a class="text-success m-r-1 modifyEL" href="javascript:void(0)" data-target="'+d.id+'" data-option="2" style="font-size: 20px"><i class="fa fa-pencil-square"></i></a> <a class="text-danger deleteItem" href="javascript:void(0)" data-target="'+d.id+'" data-option="2" style="font-size: 20px; margin-left: 5px"><i class="fa fa-ban"></i></a></div></td></tr>');
													text += '<p style="margin-left: 50px;"> <strong>Empresa: </strong> '+d.nombre_empresa+'<br> <strong>País: </strong> '+d.nombre_pais+'<br> <strong>Actividad: </strong> '+d.actividad_empresa+'<br> <strong>Tipo puesto: </strong> '+d.tipo_puesto+'<br> </p>';
												});
												$("#experiencias").append(text);
											}

											$(".modifyEL").click(function() {
												currentParent = $(this).closest("tr");
												var target = $(this).attr("data-target");
												var option = $(this).attr("data-option");
												$(".save").each(function(index, value) {
													if($(this).attr("data-target") == option) {
														$(this).attr("data-edit", 2);
														$(this).attr("data-i", target);
													}
												});

												$.ajax({
													type: 'POST',
													url: 'ajax/account.php',
													data: 'op=2&i=' + target + '&opt=' + option,
													dataType: 'json',
													success: function(data) {
														$("#company").val(data.nombre_empresa);
														$("#rCompany").val(data.id_pais);
														$("#tCompany").val(data.id_actividad_empresa);
														$("#tEmployeer").val(data.tipo_puesto);
														$("#monthI").val(data.mes_ingreso);
														$("#yearI").val(data.ano_ingreso);
														$("#monthE").val(data.mes_egreso);
														$("#yearE").val(data.ano_egreso);
														$("#descriptionArea").val(data.descripcion_tareas);
													}
												});
											});

												swal({
												  title: "Exito",
												  text: "Información almacenada exitosamente! Desea agregar más experiencias laborales o pasar a la siguiente fase?",
												  type: "success",
												  showCancelButton: true,
												  confirmButtonColor: "#DD6B55",
												  confirmButtonText: "Siguiente fase",
												  cancelButtonText: "Agregar más",
												  closeOnConfirm: false
												});

											$(".show-swal2.visible .swal2-confirm").attr('data-action', 'sig3');

											$(".show-swal2.visible .swal2-confirm").click(function() {
												if($(this).attr('data-action') == 'sig3') {
													$(this).attr('data-action', '');

													$('.nav .nav-item a[href="#tab3"]').click();
												}
											});

											break;
										case 3:
											$("#sNivel").val(0);
											$("#titleS").val("");
											$("#stateS").val(0);
											$("#areaS").val(0);
											$("#institute").val("");
											$("#countryS").val(0);
											$("#monthIn").val(1);
											$("#yearIn").val(2015);
											$("#monthFi").val(1);
											$("#yearFi").val(2016);
											$("#mat").val("");
											$("#aprob").val("");

											$("#contentED").css("display", "block");
											var text = '';
											if(edit == 2) {
												data.data.forEach(function(d) {
													currentParent.html('<td>'+d.nivel+'</td><td>'+d.nombre_pais+'</td><td>'+d.estado_estudio+'</td><td>'+d.nombre_estudio+'</td><td><div class="pull-xs-left"><a class="text-success m-r-1 modifyES" href="javascript:void(0)" data-target="'+d.id+'" data-option="3" style="font-size: 20px"><i class="fa fa-pencil-square"></i></a> <a class="text-danger deleteItem" href="javascript:void(0)" data-target="'+d.id+'" data-option="3" style="font-size: 20px; margin-left: 5px"><i class="fa fa-ban"></i></a></div></td>');
													text += '<p style="margin-left: 50px;"> <strong>Idioma: </strong> '+d.nombre_pais+'<br> <strong>Nivel Oral: </strong> '+d.nivel+'<br> <strong>Nivel escrito: </strong> '+d.estado_estudio+'<br> </p>';
												});
												$("#idiomas").append(text);
											}else {
												data.data.forEach(function(d) {
													$("#t3").append('<tr><td>'+d.nivel+'</td><td>'+d.nombre_pais+'</td><td>'+d.estado_estudio+'</td><td>'+d.nombre_estudio+'</td><td><div class="pull-xs-left"><a class="text-success m-r-1 modifyES" href="javascript:void(0)" data-target="'+d.id+'" data-option="3" style="font-size: 20px"><i class="fa fa-pencil-square"></i></a> <a class="text-danger deleteItem" href="javascript:void(0)" data-target="'+d.id+'" data-option="3" style="font-size: 20px; margin-left: 5px"><i class="fa fa-ban"></i></a></div></td></tr>');
													text += '<p style="margin-left: 50px;"> <strong>Idioma: </strong> '+d.nombre_pais+'<br> <strong>Nivel Oral: </strong> '+d.nivel+'<br> <strong>Nivel escrito: </strong> '+d.estado_estudio+'<br> </p>';
												});
												$("#idiomas").html(text);
											}

											$(".modifyES").click(function() {
												currentParent = $(this).closest("tr");
												var target = $(this).attr("data-target");
												var option = $(this).attr("data-option");
												$(".save").each(function(index, value) {
													if($(this).attr("data-target") == option) {
														$(this).attr("data-edit", 2);
														$(this).attr("data-i", target);
													}
												});

												$.ajax({
													type: 'POST',
													url: 'ajax/account.php',
													data: 'op=2&i=' + target + '&opt=' + option,
													dataType: 'json',
													success: function(data) {
														$("#sNivel").val(data.id_nivel_estudio);
														$("#titleS").val(data.titulo);
														$("#stateS").val(data.id_estado_estudio);
														$("#areaS").val(data.id_area_estudio);
														$("#institute").val(data.nombre_institucion);
														$("#countryS").val(data.id_pais);
														$("#monthIn").val(data.mes_inicio);
														$("#yearIn").val(data.ano_inicio);
														$("#monthFi").val(data.mes_finalizacion);
														$("#yearFi").val(data.ano_finalizacion);
														$("#mat").val(data.materias_carrera);
														$("#aprob").val(data.materias_aprobadas);
													}
												});
											});

											swal({
												title: "Exito",
												text: "Información almacenada exitosamente! Desea agregar más estudios o pasar a la siguiente fase?",
												type: "success",
												showCancelButton: true,
												confirmButtonColor: "#DD6B55",
												confirmButtonText: "Siguiente fase",
												cancelButtonText: "Agregar más",
												closeOnConfirm: false
											});
											$(".show-swal2.visible .swal2-confirm").attr('data-action', 'sig4');

											$(".show-swal2.visible .swal2-confirm").click(function() {
												if($(this).attr('data-action') == 'sig4') {
													$(this).attr('data-action', '');

													$('.nav .nav-item a[href="#tab4"]').click();
													//$('.back-next[data-target="4"]').click();
												}
											});

											break;
										case 4:
											$("#idioma").val(0);
											$("input[type=radio][name=nivelO]").each(function(index, value) {
												value.checked = false;
											});
											$("input[type=radio][name=nivelE]").each(function(index, value) {
												value.checked = false;
											});

											$("#contentID").css("display", "block");
											if(edit == 2) {
												data.data.forEach(function(d) {
													currentParent.html('<td>'+d.nombre_idioma+'</td><td>'+d.nivel_oral+'</td><td>'+d.nivel_escrito+'</td><td><div class="pull-xs-left"><a class="text-success m-r-1 modifyI" href="javascript:void(0)" data-target="'+d.id+'" data-option="4" style="font-size: 20px"><i class="fa fa-pencil-square"></i></a> <a class="text-danger deleteItem" href="javascript:void(0)" data-target="'+d.id+'" data-option="4" style="font-size: 20px; margin-left: 5px"><i class="fa fa-ban"></i></a></div></td>');
													text += '<p style="margin-left: 50px;"> <strong>Idioma: </strong> '+d.nombre_idioma+'<br> <strong>Nivel Oral: </strong> '+d.nivel_oral+'<br> <strong>Nivel escrito: </strong> '+d.nivel_escrito+'<br> </p>';
												});
											}
											else {
												data.data.forEach(function(d) {
													$("#t4").append('<tr><td>'+d.nombre_idioma+'</td><td>'+d.nivel_oral+'</td><td>'+d.nivel_escrito+'</td><td><div class="pull-xs-left"><a class="text-success m-r-1 modifyI" href="javascript:void(0)" data-target="'+d.id+'" data-option="4" style="font-size: 20px"><i class="fa fa-pencil-square"></i></a> <a class="text-danger deleteItem" href="javascript:void(0)" data-target="'+d.id+'" data-option="4" style="font-size: 20px; margin-left: 5px"><i class="fa fa-ban"></i></a></div></td></tr>');
													text += '<p style="margin-left: 50px;"> <strong>Idioma: </strong> '+d.nombre_idioma+'<br> <strong>Nivel Oral: </strong> '+d.nivel_oral+'<br> <strong>Nivel escrito: </strong> '+d.nivel_escrito+'<br> </p>';
												});
											}
											$("#idiomas").html(text);
											$(".modifyI").click(function() {
												currentParent = $(this).closest("tr");
												var target = $(this).attr("data-target");
												var option = $(this).attr("data-option");
												$(".save").each(function(index, value) {
													if($(this).attr("data-target") == option) {
														$(this).attr("data-edit", 2);
														$(this).attr("data-i", target);
													}
												});

												$.ajax({
													type: 'POST',
													url: 'ajax/account.php',
													data: 'op=2&i=' + target + '&opt=' + option,
													dataType: 'json',
													success: function(data) {
														$("#idioma").val(data.id_idioma);
														$("input[type=radio][name=nivelO]").each(function(index, value) {
															if(value.value == data.nivel_oral) {
																value.checked = true;
															}
														});
														$("input[type=radio][name=nivelE]").each(function(index, value) {
															if(value.value == data.nivel_escrito) {
																value.checked = true;
															}
														});
													}
												});
											});


												swal({
												  title: "Exito",
												  text: "Información almacenada exitosamente! Desea agregar más idiomas o pasar a la siguiente fase?",
												  type: "success",
												  showCancelButton: true,
												  confirmButtonColor: "#DD6B55",
												  confirmButtonText: "Siguiente fase",
												  cancelButtonText: "Agregar más",
												  closeOnConfirm: false
												});
											$(".show-swal2.visible .swal2-confirm").attr('data-action', 'sig5');

											$(".show-swal2.visible .swal2-confirm").click(function() {
												if($(this).attr('data-action') == 'sig5') {
													$(this).attr('data-action', '');

													$('.nav .nav-item a[href="#tab5"]').click();
													//$('.back-next[data-target="5"]').click();
												}
											});

											break;
										case 5:
											$("#nameC").val("");
											$("#descriptionC").val("");
											
											if (Object.keys(data.data).length > 0) {
												$("#contentOC").css("display", "block");
												$("#containerSinOtrCon").remove();
											}

											if(edit == 2) {
												data.data.forEach(function(d) {
													currentParent.html('<td>'+d.nombre+'</td><td>'+d.descripcion+'</td><td><div class="pull-xs-left"><a class="text-success m-r-1 modifyOC" href="javascript:void(0)" data-target="'+d.id+'" data-option="5" style="font-size: 20px"><i class="fa fa-pencil-square"></i></a> <a class="text-danger deleteItem" href="javascript:void(0)" data-target="'+d.id+'" data-option="5" style="font-size: 20px; margin-left: 5px"><i class="fa fa-ban"></i></a></div></td>');
												});
											}
											else {
												data.data.forEach(function(d) {
													$("#t5").append('<tr><td>'+d.nombre+'</td><td>'+d.descripcion+'</td><td><div class="pull-xs-left"><a class="text-success m-r-1 modifyOC" href="javascript:void(0)" data-target="'+d.id+'" data-option="5" style="font-size: 20px"><i class="fa fa-pencil-square"></i></a> <a class="text-danger deleteItem" href="javascript:void(0)" data-target="'+d.id+'" data-option="5" style="font-size: 20px; margin-left: 5px"><i class="fa fa-ban"></i></a></div></td></tr>');
												});
											}

											$(".modifyOC").click(function() {
												currentParent = $(this).closest("tr");
												var target = $(this).attr("data-target");
												var option = $(this).attr("data-option");
												$(".save").each(function(index, value) {
													if($(this).attr("data-target") == option) {
														$(this).attr("data-edit", 2);
														$(this).attr("data-i", target);
													}
												});

												$.ajax({
													type: 'POST',
													url: 'ajax/account.php',
													data: 'op=2&i=' + target + '&opt=' + option,
													dataType: 'json',
													success: function(data) {
														$("#nameC").val(data.nombre);
														$("#descriptionC").val(data.descripcion);
													}
												});
											});


												swal({
												  title: "Exito",
												  text: "Información almacenada exitosamente! Desea añadir otros conocimientos o pasar a la siguiente fase?",
												  type: "success",
												  showCancelButton: true,
												  confirmButtonColor: "#DD6B55",
												  confirmButtonText: "Siguiente fase",
												  cancelButtonText: "Agregar más",
												  closeOnConfirm: false
												});

											$(".show-swal2.visible .swal2-confirm").attr('data-action', 'sig6');

											$(".show-swal2.visible .swal2-confirm").click(function() {
												if($(this).attr('data-action') == 'sig6') {
													$(this).attr('data-action', '');
													console.log('asbdasbdoasndas');
													$('.nav .nav-item a[href="#tab6"]').click();
													//$('.back-next[data-target="6"]').click();
												}
											});

											break;
										case 6:

												swal({
												  title: "Exito",
												  text: "Información almacenada exitosamente! Desea ver la vista previa de su CV?",
												  type: "success",
												  showCancelButton: true,
												  confirmButtonColor: "#DD6B55",
												  confirmButtonText: "Ver CV",
												  cancelButtonText: "Cancelar",
												  closeOnConfirm: false
												});
											$(".show-swal2.visible .swal2-confirm").attr('data-action', 'sig7');

											$(".show-swal2.visible .swal2-confirm").click(function() {
												if($(this).attr('data-action') == 'sig7') {
													$(this).attr('data-action', '');

													$('.nav .nav-item a[href="#tab7"]').click();
													//$('.back-next[data-target="7"]').click();
												}
											});

											break;
									}
									loadEvents();
									currentParent = null;
								}
							});
						}
						else {
							swal({
								title: 'Información!',
								text: 'Todos los campos con (*) son obligatorios.',
								timer: 2000,
								confirmButtonClass: 'btn btn-primary btn-lg',
								buttonsStyling: false
							});
						}
					});
				});

                function formato(fecha){
                    return fecha.replace(/^(\d{4})-(\d{2})-(\d{2})$/g,'$3/$2/$1');
                }

                function calcularEdad(fecha) {
                    var hoy = new Date();
                    var cumpleanos = new Date(fecha);
                    var edad = hoy.getFullYear() - cumpleanos.getFullYear();
                    var m = hoy.getMonth() - cumpleanos.getMonth();

                    if (m < 0 || (m === 0 && hoy.getDate() < cumpleanos.getDate())) {
                        edad--;
                    }

                    return edad;
                }

				function loadEvents() {
					$(".deleteItem").click(function() {
						var target = $(this).attr("data-target");
						var option = $(this).attr("data-option");
						var element = $(this);
						swal({
							title: 'Estas seguro?',
							text: "Este proceso es irreversible!",
							type: 'warning',
							showCancelButton: true,
							confirmButtonColor: '#3085d6',
							cancelButtonColor: '#d33',
							confirmButtonText: 'Si, eliminar!',
							cancelButtonText: 'No, cancelar!',
							confirmButtonClass: 'btn btn-primary btn-lg m-r-1',
							cancelButtonClass: 'btn btn-danger btn-lg',
							buttonsStyling: false
						}).then(function(isConfirm) {
							if (isConfirm === true) {
								$.ajax({
									type: 'POST',
									url: 'ajax/account.php',
									data: 'op=3&i=' + target + '&opt=' + option,
									dataType: 'json',
									success: function(data) {
										console.log(data);
										element.closest("tr").remove();
									}
								});
							}
						})
					});
				}

				function sleep(ms) {
				  return new Promise(resolve => setTimeout(resolve, ms));
				}

				async function demorar() {
				  await sleep(2000);
				}
			</script>


			<script type="text/javascript">

				function seleccionar_localidad(parametro)
				{ 
					$(".select_localidad").hide();
					$("#localidad_"+parametro).show();
				}

				function guardar_datos()
				{
					 
					var_sexo=1;
					localidad="localidad_" + $("#vic_provincias").val();

					if($('#radio1').is(':checked'))
					{
						var_sexo=2;
					}

					if($("#name").val()=="")
					{
					 
						$("#name").focus();
						$("#name").css({"border": "1px solid #870009"});
					}
					else if($("#lastName").val()=="")
					{
						 
						$("#lastName").focus();
						$("#lastName").css({"border": "1px solid #870009"});
					}
					else if($("#email").val()=="")
					{
						 $("#email").css({"border": "1px solid #870009"});
						$("#email").focus();
					}
					
					
					else if($("#dia").val()=="0")
					{
						 $("#dia").css({"border": "1px solid #870009"});
						$("#dia").focus();
					}
					else if($("#mes").val()=="0")
					{
						 $("#mes").css({"border": "1px solid #870009"});
						$("#mes").focus();
					}
					else if($("#anio").val()=="0")
					{
						 $("#anio").css({"border": "1px solid #870009"});
						$("#anio").focus();
					}
					else if($("#country").val()=="0")
					{
						 $("#country").css({"border": "1px solid #870009"});
								$("#country").focus();
					}
					else if($("#estadoCivil").val()=="0")
					{
						 $("#estadoCivil").css({"border": "1px solid #870009"});
					    $("#estadoCivil").focus();
					}
					else if($("#dni").val()=="0")
					{
					 $("#dni").css({"border": "1px solid #870009"});
					    $("#dni").focus();
					}
					else if($("#numberdni").val()=="")
					{
						 $("#numberdni").css({"border": "1px solid #870009"});
					    $("#numberdni").focus();
					}
					else if($("#cuil").val()=="")
					{
						 $("#cuil").css({"border": "1px solid #870009"});
					    $("#cuil").focus();
					}
					else if($("#vic_provincias").val()=="0")
					{
						 $("#vic_provincias").css({"border": "1px solid #870009"});
					    $("#vic_provincias").focus();
					}
					 else if(($("#"+localidad).val())=="0")
					{
						$("#"+localidad).css({"border": "1px solid #870009"});
					   $("#"+localidad).focus();
					}  
					 else if($("#street").val()=="")
					{
						 $("#street").css({"border": "1px solid #870009"});
					   $("#street").focus();
					} 
					else if($("#phone").val()=="")
					{$("#phone").css({"border": "1px solid #870009"});
						 
					    $("#phone").focus();
					}  

					else
					{
						var name =($("#name").val()).split(" ")[0],
							lastName = ($("#lastName").val()).split(" ")[0];
						var nombres = name + " " + lastName;

						$.ajax({
						  method: "POST",
						  url: "ajax/currículum.php",
						  data: {nombre:$("#name").val(),
								apellido:$("#lastName").val(),
								correo:$("#email").val(),
								dia:$("#dia").val(),
								mes:$("#mes").val(),
								 anio:$("#anio").val(),
								naciomiento:$("#country").val(),
								edo_civil:$("#estadoCivil").val(),
								dni:$("#dni").val(),
								numberdni:$("#numberdni").val(),
								cuil:$("#cuil").val(),
								provincia:$("#vic_provincias").val(),
								localidad:$("#"+localidad).val(),
								calle:$("#street").val(),
								telefono:$("#phone").val(),
								telefono_2:$("#phoneAlt").val(),

								sexo:var_sexo }
						})
						  .done(function( msg ) {
						    if(msg!=1)
						    {
						    	alert("Ops, algo salio mal. Intente de nuevo.");
						    }
						    else{
						    	swal("EXITO!", "Datos guardados con éxito", "success");
						    	 $("#experiencia").removeClass("disabled");
						    	$("#experiencia").trigger("click");
						    	$("#name_user").text(nombres);
							    }
						  }); 
					}
					
							
				}

			 
				 
			</script>
	</body>

</html>