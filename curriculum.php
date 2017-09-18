<?php
session_start();
if (!isset($_SESSION["ctc"]["id"])) {
    header("Location: ./");
}
require_once 'classes/DatabasePDOInstance.function.php';
$db        = DatabasePDOInstance();
$data      = $db->getRow("SELECT * FROM trabajadores WHERE id=" . $_SESSION["ctc"]["id"]);
$infoExtra = $db->getRow("SELECT * FROM trabajadores_infextra WHERE id_trabajador =" . $_SESSION['ctc']['id']);
$attr      = '';
if ($data["id_sexo"] == 0 || $data["id_estado_civil"] == 0 || $data["id_tipo_documento_identificacion"] == 0 || $data["id_pais"] == 0 || $data["provincia"] == "" || $data["localidad"] == "" || $data["calle"] == "" || $data["nombres"] == "" || $data["apellidos"] == "" || $data["numero_documento_identificacion"] == "" || $data["fecha_nacimiento"] == "" || $data["telefono"] == "" || $data["correo_electronico"] == "") {
    $attr = 'disabled';
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

		<style>
			.modal.in.modal-agregar-rubro .modal-dialog {
				max-width: 400px;
			}
			.disabled {
				pointer-events: none;
			}
		</style>
	</head>

	<body class="large-sidebar fixed-sidebar fixed-header skin-5">

		<div class="wrapper">

			<!-- Preloader -->
			<div class="preloader"></div>

			<!-- Sidebar -->
			<?php require_once 'includes/sidebar.php';?>

			<!-- Sidebar second -->
			<?php require_once 'includes/sidebar-second.php';?>

			<!-- Header -->
			<?php require_once 'includes/header.php';?>

			<div class="site-content">
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
									<a class="nav-link <?php echo $attr; ?>" data-toggle="tab" href="#tab2" role="tab">Experiencia laboral</a>
								</li>
								<li class="nav-item">
									<a class="nav-link <?php echo $attr; ?>" data-toggle="tab" href="#tab3" role="tab">Estudios</a>
								</li>
								<li class="nav-item">
									<a class="nav-link <?php echo $attr; ?>" data-toggle="tab" href="#tab4" role="tab">Idiomas</a>
								</li>
								<li class="nav-item">
									<a class="nav-link <?php echo $attr; ?>" data-toggle="tab" href="#tab5" role="tab">Otros conocimientos</a>
								</li>
								<li class="nav-item">
									<a class="nav-link <?php echo $attr; ?>" data-toggle="tab" href="#tab6" role="tab">Información Extra</a>
								</li>
								<li class="nav-item">
									<a class="nav-link <?php echo $attr; ?>" data-toggle="tab" href="#tab7" role="tab">Vista previa</a>
								</li>
							</ul>
							<div class="tab-content">
								<div class="tab-pane active" id="tab1" role="tabpanel">
									<br><br>
									<div class="row">
										<div class="col-md-4"></div>
										<div class="col-md-4"></div>
										<div class="col-md-4" style="text-align: right;"><!-- <a href="javascript:void(0)" class="btn btn-primary w-min-sm m-b-0-25 waves-effect waves-light back-next <?php echo $attr; ?>" data-target="2" style="margin-right: 25px;">Siguiente <i class="ti-angle-right"></i></a> --></div>
									</div>
									<h4 style="border-bottom: 1px solid #3e70c9;margin-left: 25px;margin-right: 25px;margin-bottom: 25px;padding-bottom: 5px;">Paso 1: Datos de contacto</h4>
									<p class="text-muted" style="margin-left: 25px;margin-right: 25px; text-align: justify;">Completa los pasos para llenar tu curriculum y podrás aparecer como candidato para la empresas. Recuerda que los campos marcados con (*) son obligatorios</p>
									<div class="row">
										<div class="col-md-2"></div>
										<div class="col-md-8">
											<div class="form-group row">
												<label for="name" class="col-xs-4 col-form-label" style="text-align: right;">Nombre <span style="color: red;">*</span></label>
												<div class="col-xs-8">
													<input class="form-control" value="<?php echo $data["nombres"]; ?>" id="name" type="text">
												</div>
											</div>
											<div class="form-group row">
												<label for="lastName" class="col-xs-4 col-form-label"  style="text-align: right;">Apellido <span style="color: red;">*</span></label>
												<div class="col-xs-8">
													<input class="form-control" value="<?php echo $data["apellidos"]; ?>" id="lastName" type="text">
												</div>
											</div>
											<div class="form-group row">
												<label for="email" class="col-xs-4 col-form-label"  style="text-align: right;">Email <span style="color: red;">*</span></label>
												<div class="col-xs-8">
													<input class="form-control" value="<?php echo $_SESSION["ctc"]["email"]; ?>" id="email" type="email">
												</div>
											</div>
											<label class="custom-control custom-radio col-md-4" style=" text-align: right;">
												<span class="custom-control-description">Sexo <span style="color: red;">*</span></span>
											</label>
											<label class="custom-control custom-radio col-md-3">
												<input id="radio1" name="sex" class="custom-control-input" type="radio" value="2">
												<span class="custom-control-indicator"></span>
												<span class="custom-control-description">Femenino</span>
											</label>
											<label class="custom-control custom-radio col-md-3">
												<input id="radio2" name="sex" class="custom-control-input" type="radio" value="1">
												<span class="custom-control-indicator"></span>
												<span class="custom-control-description">Masculino</span>
											</label>
											<div class="row">
												<div class="col-xs-4" style="text-align: right;">
													<label for="" class="col-form-label">Fecha de nacimiento <span style="color: red;">*</span></label>
												</div>
												<div class="col-xs-6">
													<select name="" id="dia" class="custom-select">
														<option value="0">Sel</option>
														<?php for ($i = 1; $i <= 31; $i++): ?>
															<option value="<?=$i < 10 ? '0' . $i : $i?>"><?=$i?></option>
														<?php endfor;?>
													</select>


													<select name="" id="mes" class="custom-select">
														<option value="0">Sel</option>
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

													<select name="" id="anio" class="custom-select">
														<option value="0">Sel</option>
														<?php for ($i = 1950; $i <= intval(date('Y')); $i++): ?>
														<option value="<?=$i?>"><?=$i?></option>
														<?php endfor;?>
													</select>
												</div>
											</div>
											<div class="row" style="margin-top: 10px;">
												<div class="col-md-4" style="text-align: right;">
													<label for="country" style="margin-top: 6px;">Lugar de nacimiento <span style="color: red;">*</span></label>
												</div>
												<div class="col-md-8">
													<select class="custom-select" id="country" style="width: 100%;">
														<option value="0">Seleccione</option>
														<?php $countries = $db->getAll("SELECT * FROM paises ORDER BY nombre ASC");?>
														<?php foreach ($countries as $c): ?>
															<option value="<?php echo $c["id"]; ?>"><?php echo $c["nombre"]; ?></option>
														<?php endforeach?>
													</select>
												</div>
											</div>
											<div class="row" style="margin-top: 10px;">
												<div class="col-md-4" style="text-align: right;">
													<label for="stateCivil" style="margin-top: 6px;">Estado civil</label>
												</div>
												<div class="col-md-8">
													<select class="custom-select" id="estadoCivil" style="width: 100%;">
														<option value="0">Seleccione</option>
														<?php $estado_civil = $db->getAll("SELECT * FROM estados_civiles");?>
														<?php foreach ($estado_civil as $e): ?>
															<option value="<?php echo $e["id"]; ?>"><?php echo $e["nombre"]; ?></option>
														<?php endforeach?>
													</select>
												</div>
											</div>
											<div class="row" style="margin-top: 10px;">
												<div class="col-md-4" style="text-align: right;"><label for="dni" style="margin-top: 6px;">DNI <span style="color: red;">*</span></label></div>
												<div class="col-md-4">
													<select class="custom-select" style="width: 100%;" id="dni">
														<option value="0">Seleccione</option>
														<?php $tipos_documento_identificacion = $db->getAll("SELECT * FROM tipos_documento_identificacion");?>
														<?php foreach ($tipos_documento_identificacion as $t): ?>
															<option value="<?php echo $t["id"]; ?>"><?php echo $t["nombre"]; ?></option>
														<?php endforeach?>
													</select>
												</div>
												<div class="col-md-2" style="text-align: right;"><label for="numberdni" style="margin-top: 6px;">Número <span style="color: red;">*</span></label></div>
												<div class="col-md-2">
													<input class="form-control" value="<?php echo $data["numero_documento_identificacion"]; ?>" id="numberdni" type="text">
												</div>
											</div>
											<?php $provincias = $db->getAll("SELECT * FROM provincias")?>
											<div class="row" style="margin-top: 10px;">
												<div class="col-md-4" style="text-align: right;">
													<label for="province" style="margin-top: 6px;">Provincia <span style="color: red;">*</span></label>
												</div>
												<div class="col-md-8">
                                                    <select name="province" id="province"
                                                            class="custom-select">
                                                        <option value="0">Seleccione</option>
                                                        <?php foreach ($provincias as $val): ?>
                                                            <option
                                                                value="<?=$val['id']?>"><?=$val['provincia']?></option>
                                                        <?php endforeach;?>
                                                    </select>
												</div>
											</div>
                                            <?php $localidades = $db->getAll("SELECT * FROM localidades WHERE id_provincia=" . $data['provincia'])?>
											<div class="row" style="margin-top: 10px;">
												<div class="col-md-4" style="text-align: right;">
													<label for="city" style="margin-top: 6px;">Localidad / Ciudad <span style="color: red;">*</span></label>
												</div>
												<div class="col-md-8">
                                                    <select name="city" id="city" class="custom-select">
                                                        <option value="0">Seleccione</option>
                                                        <?php foreach ($localidades as $val): ?>
                                                            <option value="<?=$val['id']?>"><?=$val['localidad']?></option>
                                                        <?php endforeach;?>
                                                    </select>
												</div>
											</div>
											<div class="form-group row" style="margin-top: 10px">
												<label for="street" class="col-xs-4 col-form-label" style="text-align: right;">Calle <span style="color: red;">*</span></label>
												<div class="col-xs-8">
													<input class="form-control" value="<?php echo $data["calle"]; ?>" id="street" type="text">
												</div>
											</div>
											<div class="form-group row">
												<label for="phone" class="col-xs-4 col-form-label" style="text-align: right;">Teléfono o móvil <span style="color: red;">*</span></label>
												<div class="col-xs-8">
													<input class="form-control" value="<?php echo $data["telefono"]; ?>" id="phone" type="text">
												</div>
											</div>
											<div class="form-group row">
												<label for="phoneAlt" class="col-xs-4 col-form-label" style="text-align: right;">Teléfono alternativo</label>
												<div class="col-xs-8">
													<input class="form-control" value="<?php echo $data["telefono_alternativo"]; ?>" id="phoneAlt" type="text">
												</div>
											</div>
											<h5>Mis redes Sociales</h5>
												<span style="color: grey; font-size: 10px">Ojo: Las redes sociales que coloques en el formulario serán visibles por las empresas.</span>

											<hr>
											<div class="form-group row">
												<label for="web" class="col-xs-4 col-form-label" style="text-align: right;">Sitio Web</label>
												<div class="col-xs-8">
													<input class="form-control" value="<?php echo $data["sitio_web"] ?>" id="web" type="text">
												</div>
											</div><div class="form-group row">
												<label for="fb" class="col-xs-4 col-form-label" style="text-align: right;">Facebook</label>
												<div class="col-xs-8">
													<input class="form-control" value="<?php echo $data["facebook"] ?>" id="fb" type="text">
												</div>
											</div>
											<div class="form-group row">
												<label for="tw" class="col-xs-4 col-form-label" style="text-align: right;">Twitter</label>
												<div class="col-xs-8">
													<input class="form-control" value="<?php echo $data["twitter"] ?>" id="tw" type="text">
												</div>
											</div>
											<div class="form-group row">
												<label for="ig" class="col-xs-4 col-form-label" style="text-align: right;">Instagram</label>
												<div class="col-xs-8">
													<input class="form-control" value="<?php echo $data["instagram"] ?>" id="ig" type="text">
												</div>
											</div>
											<div class="form-group row">
												<label for="snap" class="col-xs-4 col-form-label" style="text-align: right;">Snapchat</label>
												<div class="col-xs-8">
													<input class="form-control" value="<?php echo $data["snapchat"] ?>" id="snap" type="text">
												</div>
											</div>
											<div class="form-group row">
												<label for="lkd" class="col-xs-4 col-form-label" style="text-align: right;">Linkedin</label>
												<div class="col-xs-8">
													<input class="form-control" value="<?php echo $data["linkedin"] ?>" id="lkd" type="text">
												</div>
											</div>
										</div>
										<div class="col-md-2"></div>
									</div>
									<div class="row" style="margin-top: 10px">
										<div class="col-md-4"></div>
										<div class="col-md-4" style="text-align: center;"><a href="javascript:void(0)" class="btn btn-primary w-min-sm m-b-0-25 waves-effect waves-light save" data-edit="1"  data-target="1">Guardar</a></div>
										<div class="col-md-4" style="text-align: right;"><!-- <a href="javascript:void(0)" class="btn btn-primary w-min-sm m-b-0-25 waves-effect waves-light back-next <?php echo $attr; ?>" data-target="2" style="margin-right: 25px;">Siguiente <i class="ti-angle-right"></i></a> --></div>
									</div>
								</div>
								<div class="tab-pane" id="tab2" role="tabpanel">
									<br><br>
									<div class="row" style="margin-bottom: 20px;">
										<div class="col-md-4" style="text-align: left;"><a href="javascript:void(0)" class="btn btn-primary w-min-sm m-b-0-25 waves-effect waves-light back-next" data-target="1" style="margin-left: 25px;"><i class="ti-angle-left"></i> Anterior</a></div>
										<div class="col-md-4"></div>
										<div class="col-md-4" style="text-align: right;"><!-- <a href="javascript:void(0)" class="btn btn-primary w-min-sm m-b-0-25 waves-effect waves-light back-next" data-target="3" style="margin-right: 25px;">Siguiente <i class="ti-angle-right"></i></a> --></div>
									</div>
									<h4 style="border-bottom: 1px solid #3e70c9;margin-left: 25px;margin-right: 25px;margin-bottom: 25px;padding-bottom: 5px;">Paso 2: Experiencia laboral</h4>
									<div class="row">
										<div class="col-md-2"></div>
										<div class="col-md-8">
											<div class="form-group row">
												<label for="company" class="col-xs-4 col-form-label" style="text-align: right;">Empresa <span style="color: red;">*</span></label>
												<div class="col-xs-8">
													<input class="form-control" value="" id="company" type="text">
												</div>
											</div>
											<div class="row" style="margin-top: 10px;">
												<div class="col-md-4" style="text-align: right;">
													<label for="rCompany" style="margin-top: 6px;">Ubicación de la empresa <span style="color: red;">*</span></label>
												</div>
												<div class="col-md-8">
													<select class="custom-select" style="width: 100%;" id="rCompany">
														<option value="0">Seleccione</option>
														<?php foreach ($countries as $c): ?>
															<option value="<?php echo $c["id"]; ?>"><?php echo $c["nombre"]; ?></option>
														<?php endforeach?>
													</select>
												</div>
											</div>
											<div class="row" style="margin-top: 10px;">
												<div class="col-md-4" style="text-align: right;">
													<label for="tCompany" style="margin-top: 6px;">Ramo o actividad <span style="color: red;">*</span></label>
												</div>
												<div class="col-md-8">
													<select class="custom-select" style="width: 100%;" id="tCompany">
														<option value="0">Seleccione</option>
														<?php $actividades = $db->getAll("SELECT * FROM actividades_empresa");?>
														<?php foreach ($actividades as $a): ?>
															<option value="<?php echo $a["id"]; ?>"><?php echo $a["nombre"]; ?></option>
														<?php endforeach?>
													</select>
												</div>
											</div>
											<div class="row" style="margin-top: 10px;">
												<div class="col-md-4" style="text-align: right;">
													<label for="tEmployeer">Tipo de puesto o jerarquía <span style="color: red;">*</span></label>
												</div>
												<div class="col-md-8">
													<input class="form-control" value="" id="tEmployeer" type="text">
												</div>
											</div>
											<div class="row" style="margin-top: 10px;">
												<div class="col-md-4" style="text-align: right;"><label for="monthI" style="margin-top: 6px;">Mes de ingreso <span style="color: red;">*</span></label></div>
												<div class="col-md-3">
													<select class="custom-select" style="width: 100%;" id="monthI">
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
												<div class="col-md-2" style="text-align: right;"><label for="yearI" style="margin-top: 6px;">Año <span style="color: red;">*</span></label></div>
												<div class="col-md-3">
													<select class="custom-select" style="width: 100%;" id="yearI">
														<?php for ($i = 1950; $i < intval(date('Y')) + 1; $i++): ?>
															<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
														<?php endfor?>
													</select>
												</div>
											</div>
											<div class="row" style="margin-top: 10px;">
												<div class="col-md-4" style="text-align: right;"><label for="monthE" style="margin-top: 6px;">Mes de egreso <span style="color: red;">*</span></label></div>
												<div class="col-md-3">
													<select class="custom-select" style="width: 100%;" id="monthE">
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
												<div class="col-md-2" style="text-align: right;"><label for="yearE" style="margin-top: 6px;">Año <span style="color: red;">*</span></label></div>
												<div class="col-md-3">
													<select class="custom-select" style="width: 100%;" id="yearE">
														<?php for ($i = 1950; $i < intval(date('Y')) + 1; $i++): ?>
															<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
														<?php endfor?>
													</select>
												</div>
											</div>

											<div class="row" style="margin-top: 10px;">
												<div class="col-md-4" style="text-align: right;"><label for="" style="margin-top: 6px;">Datos del encargado </label></div>
												<div class="col-md-4">
													<input type="text" class="form-control" id="nom_enc" placeholder="Nombre del encargado">
												</div>
												<div class="col-md-4">
													<input type="tel" class="form-control" id="tlf_enc" placeholder="Telefono del encargado" title="Incluya el codigo de area" pattern="[0-9]">
												</div>
											</div>
											<div class="form-group row" style="margin-top: 10px;">
												<label for="descriptionArea" class="col-xs-4 col-form-label" style="text-align: right;">Descripcion de las tareas <span style="color: red;">*</span></label>
												<div class="col-xs-8">
													<textarea id="descriptionArea" class="form-control"></textarea>
												</div>
											</div>

										</div>
										<div class="col-md-2"></div>
									</div>

									<?php $experiencias = $db->getAll("SELECT trabajadores_experiencia_laboral.*, paises.nombre as nombre_pais, actividades_empresa.nombre as actividad_empresa FROM trabajadores_experiencia_laboral INNER JOIN paises ON paises.id=trabajadores_experiencia_laboral.id_pais INNER JOIN actividades_empresa ON actividades_empresa.id=trabajadores_experiencia_laboral.id_actividad_empresa WHERE trabajadores_experiencia_laboral.id_trabajador = " . $_SESSION['ctc']['id'] . " ORDER BY trabajadores_experiencia_laboral.ano_egreso DESC, trabajadores_experiencia_laboral.mes_egreso DESC")?>
									<?php if ($experiencias): ?>
										<div class="" id="contentEL">
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
														<tbody id="t2">
															<?php foreach ($experiencias as $e): ?>
																<tr>
																	<td><?php echo $e["nombre_empresa"]; ?></td>
																	<td><?php echo $e["nombre_pais"]; ?></td>
																	<td><?php echo $e["actividad_empresa"]; ?></td>
																	<td><?php echo $e["tipo_puesto"]; ?></td>
																	<td>
																		<div class="pull-xs-left">
																			<a class="text-grey m-r-1 modifyEL" href="javascript:void(0)" data-target="<?php echo $e["id"]; ?>" data-option="2"><i class="ti-pencil-alt"></i></a>
																			<a class="text-grey deleteItem" href="javascript:void(0)" data-target="<?php echo $e["id"]; ?>" data-option="2"><i class="ti-close"></i></a>
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

									<div class="row">
										<div class="col-md-4" style="text-align: left;"><a href="javascript:void(0)" class="btn btn-primary w-min-sm m-b-0-25 waves-effect waves-light back-next" data-target="1" style="margin-left: 25px;"><i class="ti-angle-left"></i> Anterior</a></div>
										<div class="col-md-4" style="text-align: center;"><a href="javascript:void(0)" class="btn btn-primary w-min-sm m-b-0-25 waves-effect waves-light save" data-edit="1"  data-target="2">Guardar</a> <a href="javascript:void(0)" class="btn btn-primary w-min-sm m-b-0-25 waves-effect waves-light reset" data-target="2">Borrar</a></div>
										<div class="col-md-4" style="text-align: right;"><!-- <a href="javascript:void(0)" class="btn btn-primary w-min-sm m-b-0-25 waves-effect waves-light back-next" data-target="3" style="margin-right: 25px;">Siguiente <i class="ti-angle-right"></i></a> --></div>
									</div>
								</div>
								<div class="tab-pane" id="tab3" role="tabpanel">
									<br><br>
									<div class="row" style="margin-bottom: 20px;">
										<div class="col-md-4" style="text-align: left;"><a href="javascript:void(0)" class="btn btn-primary w-min-sm m-b-0-25 waves-effect waves-light back-next" data-target="2" style="margin-left: 25px;"><i class="ti-angle-left"></i> Anterior</a></div>
										<div class="col-md-4"></div>
										<div class="col-md-4" style="text-align: right;"><!-- <a href="javascript:void(0)" class="btn btn-primary w-min-sm m-b-0-25 waves-effect waves-light back-next" data-target="4" style="margin-right: 25px;">Siguiente <i class="ti-angle-right"></i></a> --></div>
									</div>
									<h4 style="border-bottom: 1px solid #3e70c9;margin-left: 25px;margin-right: 25px;margin-bottom: 25px;padding-bottom: 5px;">Paso 3: Estudios</h4>
									<div class="row">
										<div class="col-md-2"></div>
										<div class="col-md-8">
											<div class="row" style="margin-top: 10px;">
												<div class="col-md-4" style="text-align: right;">
													<label for="sNivel" style="margin-top: 6px;">Nivel de estudio <span style="color: red;">*</span></label>
												</div>
												<div class="col-md-8">
													<select class="custom-select" style="width: 100%;" id="sNivel">
														<option value="0">Seleccione</option>
														<?php $nivel_estudio = $db->getAll("SELECT * FROM nivel_estudio");?>
														<?php foreach ($nivel_estudio as $n): ?>
															<option value="<?php echo $n["id"]; ?>"><?php echo $n["nombre"]; ?></option>
														<?php endforeach?>
													</select>
												</div>
											</div>
											<div class="form-group row" style="margin-top: 10px;">
												<label for="titleS" class="col-xs-4 col-form-label" style="text-align: right;">Título o certificación <span style="color: red;">*</span></label>
												<div class="col-xs-8">
													<input class="form-control" value="" id="titleS" type="text">
												</div>
											</div>
											<div class="row" style="margin-top: 10px;">
												<div class="col-md-4" style="text-align: right;">
													<label for="stateS" style="margin-top: 6px;">Estado <span style="color: red;">*</span></label>
												</div>
												<div class="col-md-8">
													<select class="custom-select" style="width: 100%;" id="stateS">
														<option value="0">Seleccione</option>
														<option value="1">En Curso</option>
														<option value="2">Graduado</option>
														<option value="3">Abandonado</option>
													</select>
												</div>
											</div>
											<div class="row" style="margin-top: 10px;">
												<div class="col-md-4" style="text-align: right;">
													<label for="areaS" style="margin-top: 6px;">Área de estudio <span style="color: red;">*</span></label>
												</div>
												<div class="col-md-8">
													<select class="custom-select" style="width: 100%;" id="areaS">
														<option value="0">Seleccione</option>
														<?php $areas_estudio = $db->getAll("SELECT * FROM areas_estudio");?>
														<?php foreach ($areas_estudio as $a): ?>
															<option value="<?php echo $a["id"]; ?>"><?php echo $a["nombre"]; ?></option>
														<?php endforeach?>
													</select>
												</div>
											</div>
											<div class="row" style="margin-top: 10px;">
												<div class="col-md-4" style="text-align: right;">
													<label for="institute" style="margin-top: 6px;">Institución <span style="color: red;">*</span></label>
												</div>
												<div class="col-md-8">
													<input class="form-control" value="" id="institute" type="text">
												</div>
											</div>
											<div class="row" style="margin-top: 10px;">
												<div class="col-md-4" style="text-align: right;">
													<label for="countryS" style="margin-top: 6px;">País <span style="color: red;">*</span></label>
												</div>
												<div class="col-md-8">
													<select class="custom-select" style="width: 100%;" id="countryS">
														<option value="0">Seleccione</option>
														<?php foreach ($countries as $c): ?>
															<option value="<?php echo $c["id"]; ?>"><?php echo $c["nombre"]; ?></option>
														<?php endforeach?>
													</select>
												</div>
											</div>
											<div class="row" style="margin-top: 10px;">
												<div class="col-md-4" style="text-align: right;"><label for="monthIn" style="margin-top: 6px;">Mes de inicio <span style="color: red;">*</span></label></div>
												<div class="col-md-3">
													<select class="custom-select" style="width: 100%;" id="monthIn">
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
												<div class="col-md-2" style="text-align: right;"><label for="yearIn" style="margin-top: 6px;">Año <span style="color: red;">*</span></label></div>
												<div class="col-md-3">
													<select class="custom-select" style="width: 100%;" id="yearIn">
														<?php for ($i = 1950; $i < intval(date('Y')) + 1; $i++): ?>
															<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
														<?php endfor?>
													</select>
												</div>
											</div>
											<div class="row" style="margin-top: 10px;">
												<div class="col-md-4" style="text-align: right;"><label for="monthFi" style="margin-top: 6px;">Mes de finalización <span style="color: red;">*</span></label></div>
												<div class="col-md-3">
													<select class="custom-select" style="width: 100%;" id="monthFi">
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
												<div class="col-md-2" style="text-align: right;"><label for="yearFi" style="margin-top: 6px;">Año <span style="color: red;">*</span></label></div>
												<div class="col-md-3">
													<select class="custom-select" style="width: 100%;" id="yearFi">
														<?php for ($i = 1950; $i < intval(date('Y')) + 1; $i++): ?>
															<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
														<?php endfor?>
													</select>
												</div>
											</div>
											<div class="row" style="margin-top: 10px;" id="materias_aprobadas">
												<div class="col-md-4" style="text-align: right;"><label for="mat">Materias de la carrera <span style="color: red;">*</span></label></div>
												<div class="col-md-2">
													<input class="form-control" value="" id="mat" type="text">
												</div>
												<div class="col-md-4" style="text-align: right;"><label for="aprob">Materias aprobadas <span style="color: red;">*</span></label></div>
												<div class="col-md-2">
													<input class="form-control" value="" id="aprob" type="text">
												</div>
											</div>

										</div>
										<div class="col-md-2"></div>
									</div>

									<?php $educacion = $db->getAll("SELECT trabajadores_educacion.*, paises.nombre as nombre_pais, nivel_estudio.nombre as nivel, areas_estudio.nombre as nombre_estudio, estado_estudio.nombre as estado_estudio FROM trabajadores_educacion INNER JOIN paises ON paises.id=trabajadores_educacion.id_pais INNER JOIN nivel_estudio ON nivel_estudio.id=trabajadores_educacion.id_nivel_estudio INNER JOIN areas_estudio ON areas_estudio.id=trabajadores_educacion.id_area_estudio INNER JOIN estado_estudio ON estado_estudio.id=trabajadores_educacion.id_estado_estudio WHERE trabajadores_educacion.id_trabajador=" . $_SESSION["ctc"]["id"]);?>
									<?php if ($educacion): ?>
										<div class="" id="contentED">
											<h4 style="border-bottom: 1px solid #3e70c9;margin-left: 25px;margin-right: 25px;margin-bottom: 25px;padding-bottom: 5px;margin-top: 15px;">Mis estudios</h4>
											<div class="row" style="margin-bottom: 25px;">
												<div class="col-md-1"></div>
												<div class="col-md-10">
													<table class="table m-md-b-0">
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
																			<a class="text-grey m-r-1 modifyES" href="javascript:void(0)" data-target="<?php echo $e["id"]; ?>" data-option="3"><i class="ti-pencil-alt"></i></a>
																			<a class="text-grey deleteItem" href="javascript:void(0)" data-target="<?php echo $e["id"]; ?>" data-option="3"><i class="ti-close"></i></a>
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
												<div class="col-md-1"></div>
												<div class="col-md-10">
													<table class="table m-md-b-0">
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
												<div class="col-md-1"></div>
											</div>
										</div>
									<?php endif?>

									<div class="row" style="margin-top: 20px;">
										<div class="col-md-4" style="text-align: left;"><a href="javascript:void(0)" class="btn btn-primary w-min-sm m-b-0-25 waves-effect waves-light back-next" data-target="2" style="margin-left: 25px;"><i class="ti-angle-left"></i> Anterior</a></div>
										<div class="col-md-4" style="text-align: center;"><a href="javascript:void(0)" class="btn btn-primary w-min-sm m-b-0-25 waves-effect waves-light save" data-edit="1"  data-target="3">Guardar</a> <a href="javascript:void(0)" class="btn btn-primary w-min-sm m-b-0-25 waves-effect waves-light reset" data-target="3">Borrar</a></div>
										<div class="col-md-4" style="text-align: right;"><!-- <a href="javascript:void(0)" class="btn btn-primary w-min-sm m-b-0-25 waves-effect waves-light back-next" data-target="4" style="margin-right: 25px;">Siguiente <i class="ti-angle-right"></i></a> --></div>
									</div>
								</div>
								<div class="tab-pane" id="tab4" role="tabpanel">
									<br><br>
									<div class="row" style="margin-bottom: 20px;">
										<div class="col-md-4" style="text-align: left;"><a href="javascript:void(0)" class="btn btn-primary w-min-sm m-b-0-25 waves-effect waves-light back-next" data-target="3" style="margin-left: 25px;"><i class="ti-angle-left"></i> Anterior</a></div>
										<div class="col-md-4"></div>
										<div class="col-md-4" style="text-align: right;"><!-- <a href="javascript:void(0)" class="btn btn-primary w-min-sm m-b-0-25 waves-effect waves-light back-next" data-target="5" style="margin-right: 25px;">Siguiente <i class="ti-angle-right"></i></a> --></div>
									</div>
									<h4 style="border-bottom: 1px solid #3e70c9;margin-left: 25px;margin-right: 25px;margin-bottom: 25px;padding-bottom: 5px;">Paso 4: Idiomas</h4>
									<div class="row" style="margin-top: 10px;">
										<div class="col-md-4" style="text-align: right;"><label for="idioma" style="margin-top: 6px;">Idioma <span style="color: red;">*</span></label></div>
										<div class="col-md-6">
											<select class="custom-select" style="width: 100%;" id="idioma">
												<option selected value="0">Seleccione</option>
												<?php $idiomas = $db->getAll("SELECT * FROM idiomas");?>
												<?php foreach ($idiomas as $i): ?>
													<option value="<?php echo $i["id"]; ?>"><?php echo $i["nombre"]; ?></option>
												<?php endforeach?>
											</select>
										</div>
									</div>

									<div class="row" style="margin-top: 10px;">
										<div class="col-md-4" style="text-align: right;"><label>Nivel oral <span style="color: red;">*</span></label></div>
										<div class="col-md-8">
											<div class="row">
												<div class="col-md-1"></div>
												<?php $nivel_idioma = $db->getAll("SELECT * FROM nivel_idioma");?>
												<?php foreach ($nivel_idioma as $i => $n): ?>
													<label class="custom-control custom-radio col-md-2">
														<input id="rad<?php echo $i; ?>" name="nivelO" class="custom-control-input" type="radio" value="<?php echo $n["id"]; ?>">
														<span class="custom-control-indicator"></span>
														<span class="custom-control-description"><?php echo $n["nombre"]; ?></span>
													</label>
												<?php endforeach?>
											</div>
										</div>
									</div>
									<div class="row" style="margin-top: 10px;">
										<div class="col-md-4" style="text-align: right;"><label>Nivel escrito <span style="color: red;">*</span></label></div>
										<div class="col-md-8">
											<div class="row">
												<div class="col-md-1"></div>
												<?php foreach ($nivel_idioma as $i => $n): ?>
													<label class="custom-control custom-radio col-md-2">
														<input id="rad<?php echo $i; ?>" name="nivelE" class="custom-control-input" type="radio" value="<?php echo $n["id"]; ?>">
														<span class="custom-control-indicator"></span>
														<span class="custom-control-description"><?php echo $n["nombre"]; ?></span>
													</label>
												<?php endforeach?>
											</div>
										</div>

									</div>

									<?php $idiomasT = $db->getAll("SELECT trabajadores_idiomas.*, idiomas.nombre as nombre_idioma FROM trabajadores_idiomas INNER JOIN idiomas ON idiomas.id=trabajadores_idiomas.id_idioma WHERE trabajadores_idiomas.id_trabajador=" . $_SESSION["ctc"]["id"]);?>
									<?php if ($idiomasT): ?>
										<div class="" id="contentID">
											<h4 style="border-bottom: 1px solid #3e70c9;margin-left: 25px;margin-right: 25px;margin-bottom: 25px;padding-bottom: 5px;margin-top: 15px;">Mis idiomas</h4>
											<div class="row" style="margin-bottom: 25px;">
												<div class="col-md-1"></div>
												<div class="col-md-10">
													<table class="table m-md-b-0">
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
																			<a class="text-grey m-r-1 modifyI" href="javascript:void(0)" data-target="<?php echo $i["id"]; ?>" data-option="4"><i class="ti-pencil-alt"></i></a>
																			<a class="text-grey deleteItem" href="javascript:void(0)" data-target="<?php echo $i["id"]; ?>" data-option="4"><i class="ti-close"></i></a>
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
										<div class="" id="contentID" style="display: none;">
											<h4 style="border-bottom: 1px solid #3e70c9;margin-left: 25px;margin-right: 25px;margin-bottom: 25px;padding-bottom: 5px;margin-top: 15px;">Mis idiomas</h4>
											<div class="row" style="margin-bottom: 25px;">
												<div class="col-md-1"></div>
												<div class="col-md-10">
													<table class="table m-md-b-0">
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
												<div class="col-md-1"></div>
											</div>
										</div>
									<?php endif?>

									<div class="row" style="margin-top: 20px;">
										<div class="col-md-4" style="text-align: left;"><a href="javascript:void(0)" class="btn btn-primary w-min-sm m-b-0-25 waves-effect waves-light back-next" data-target="3" style="margin-left: 25px;"><i class="ti-angle-left"></i> Anterior</a></div>
										<div class="col-md-4" style="text-align: center;"><a href="javascript:void(0)" class="btn btn-primary w-min-sm m-b-0-25 waves-effect waves-light save" data-edit="1"  data-target="4">Guardar</a> <a href="javascript:void(0)" class="btn btn-primary w-min-sm m-b-0-25 waves-effect waves-light reset" data-target="4">Borrar</a></div>
										<div class="col-md-4" style="text-align: right;"><!-- <a href="javascript:void(0)" class="btn btn-primary w-min-sm m-b-0-25 waves-effect waves-light back-next" data-target="5" style="margin-right: 25px;">Siguiente <i class="ti-angle-right"></i></a> --></div>
									</div>
								</div>
								<div class="tab-pane" id="tab5" role="tabpanel">
									<br><br>
									<div class="row" style="margin-bottom: 20px;">
										<div class="col-md-4" style="text-align: left;"><a href="javascript:void(0)" class="btn btn-primary w-min-sm m-b-0-25 waves-effect waves-light back-next" data-target="4" style="margin-left: 25px;"><i class="ti-angle-left"></i> Anterior</a></div>
										<div class="col-md-4"></div>
										<div class="col-md-4" style="text-align: right;"><!-- <a href="javascript:void(0)" class="btn btn-primary w-min-sm m-b-0-25 waves-effect waves-light back-next" data-target="6" style="margin-right: 25px;">Siguiente <i class="ti-angle-right"></i></a> --></div>
									</div>
									<h4 style="border-bottom: 1px solid #3e70c9;margin-left: 25px;margin-right: 25px;margin-bottom: 25px;padding-bottom: 5px;">Paso 5: Otros conocimientos</h4>
									<div class="row">
										<div class="col-md-2"></div>
										<div class="col-md-8">
											<div class="form-group row" style="margin-top: 10px;">
												<label for="nameC" class="col-xs-4 col-form-label" style="text-align: right;">Nombre <span style="color: red;">*</span></label>
												<div class="col-xs-8">
													<input class="form-control" value="" id="nameC" type="text">
												</div>
											</div>
											<div class="form-group row" style="margin-top: 10px;">
												<label for="descriptionC" class="col-xs-4 col-form-label" style="text-align: right;">Descripción <span style="color: red;">*</span></label>
												<div class="col-xs-8">
													<textarea class="form-control" id="descriptionC"></textarea>
												</div>
											</div>

										</div>
										<div class="col-md-2"></div>
									</div>

									<?php $otros_conocimientos = $db->getAll("SELECT * FROM trabajadores_otros_conocimientos WHERE id_trabajador=" . $_SESSION["ctc"]["id"]);?>
									<?php if ($otros_conocimientos): ?>
										<div class="" id="contentOC">
											<h4 style="border-bottom: 1px solid #3e70c9;margin-left: 25px;margin-right: 25px;margin-bottom: 25px;padding-bottom: 5px;margin-top: 15px;">Mis otros conocimientos</h4>
											<div class="row" style="margin-bottom: 25px;">
												<div class="col-md-1"></div>
												<div class="col-md-10">
													<table class="table m-md-b-0">
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
																			<a class="text-grey m-r-1 modifyOC" href="javascript:void(0)" data-target="<?php echo $o["id"]; ?>" data-option="5"><i class="ti-pencil-alt"></i></a>
																			<a class="text-grey deleteItem" href="javascript:void(0)" data-target="<?php echo $o["id"]; ?>" data-option="5"><i class="ti-close"></i></a>
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
										<div class="" id="contentOC" style="display: none;">
											<h4 style="border-bottom: 1px solid #3e70c9;margin-left: 25px;margin-right: 25px;margin-bottom: 25px;padding-bottom: 5px;margin-top: 15px;">Mis otros conocimientos</h4>
											<div class="row" style="margin-bottom: 25px;">
												<div class="col-md-1"></div>
												<div class="col-md-10">
													<table class="table m-md-b-0">
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
												<div class="col-md-1"></div>
											</div>
										</div>
									<?php endif?>

									<div class="row" style="margin-top: 20px;">
										<div class="col-md-4" style="text-align: left;"><a href="javascript:void(0)" class="btn btn-primary w-min-sm m-b-0-25 waves-effect waves-light back-next" data-target="4" style="margin-left: 25px;"><i class="ti-angle-left"></i> Anterior</a></div>
										<div class="col-md-4" style="text-align: center;"><a href="javascript:void(0)" class="btn btn-primary w-min-sm m-b-0-25 waves-effect waves-light save" data-edit="1"  data-target="5">Guardar</a> <a href="javascript:void(0)" class="btn btn-primary w-min-sm m-b-0-25 waves-effect waves-light reset" data-target="5">Borrar</a></div>
										<div class="col-md-4" style="text-align: right;"><!-- <a href="javascript:void(0)" class="btn btn-primary w-min-sm m-b-0-25 waves-effect waves-light back-next" data-target="6" style="margin-right: 25px;">Siguiente <i class="ti-angle-right"></i></a> --></div>
									</div>
								</div>
								<div class="tab-pane" id="tab6" role="tabpanel">
									<br><br>
									<div class="row" style="margin-bottom: 20px;">
										<div class="col-md-4" style="text-align: left;"><a href="javascript:void(0)" class="btn btn-primary w-min-sm m-b-0-25 waves-effect waves-light back-next" data-target="5" style="margin-left: 25px;"><i class="ti-angle-left"></i> Anterior</a></div>
										<div class="col-md-4"></div>
										<div class="col-md-4" style="text-align: right;"><!-- <a href="javascript:void(0)" class="btn btn-primary w-min-sm m-b-0-25 waves-effect waves-light back-next" data-target="7" style="margin-right: 25px;">Siguiente <i class="ti-angle-right"></i></a> --></div>
									</div>
									<h4 style="border-bottom: 1px solid #3e70c9;margin-left: 25px;margin-right: 25px;margin-bottom: 25px;padding-bottom: 5px;">Paso 6: Información Extra</h4>
									<div class="row">
										<div class="col-md-2"></div>
										<div class="col-md-8">
											<div class="form-group row" style="margin-top: 10px;">
												<label for="remuneracion" class="col-xs-4 col-form-label" style="text-align: right;">Remuneración Pretendida <span style="color: red;">*</span></label>
												<div class="col-xs-8">
													<input class="form-control" value="" id="remuneracion" type="number" min="2000" step="2000" max="100000">
												</div>
											</div>
											<div class="form-group row" style="margin-top: 10px;">
												<label for="sobre_mi" class="col-xs-4 col-form-label" style="text-align: right;">Sobre mí <span style="color: red;">*</span></label>
												<div class="col-xs-8">
													<textarea name="" id="sobre_mi" class="form-control" style="max-height: 300px"></textarea>
												</div>
											</div>
											<div class="col-md-12" style="text-align: center;margin-top: 25px;">
												<a href="javascript:void(0)" class="btn btn-primary w-min-sm m-b-0-25 waves-effect waves-light save" data-edit="1"  data-target="6">Guardar</a> <a href="javascript:void(0)" class="btn btn-primary w-min-sm m-b-0-25 waves-effect waves-light reset" data-target="6">Borrar</a>
											</div>
										</div>
										<div class="col-md-2"></div>
									</div>
								</div>
								<div class="tab-pane" id="tab7" role="tabpanel">
									<br><br>
									<div class="row" style="margin-bottom: 20px;">
										<div class="col-md-4" style="text-align: left;"><a href="javascript:void(0)" class="btn btn-primary w-min-sm m-b-0-25 waves-effect waves-light back-next" data-target="6" style="margin-left: 25px;"><i class="ti-angle-left"></i> Anterior</a></div>
										<div class="col-md-4"></div>
										<div class="col-md-4" style="text-align: right;"></div>
									</div>
									<h4 style="border-bottom: 1px solid #3e70c9;margin-left: 25px;margin-right: 25px;margin-bottom: 25px;padding-bottom: 5px;">Vista previa de mi curriculum</h4>
									<p></p>
									<h4 style="border-bottom: 1px solid #3e70c9;margin-left: 25px;margin-right: 25px;margin-bottom: 25px;padding-bottom: 5px; width: 220px;">Datos de contacto</h4>
									<div class="row">
										<div class="col-md-8">
											<div class="row">
												<div class="col-md-1"></div>
												<div class="col-md-3">
													<img src="img/<?php echo $_SESSION["ctc"]["pic"]; ?>" alt="" class="img-circle m-r-1" width="100" height="100">
												</div>
												<div class="col-md-6">
													<p>
														<strong>Nombres: </strong> <span id="labelName"><?php echo $data["nombres"]; ?></span><br>
														<strong>Apellidos: </strong> <span id="labelLastName"><?php echo $data["apellidos"]; ?></span><br>
														<strong>Lugar de nacimiento: </strong> <span id="labelCountry"><?php echo $data["id_pais"] != "" ? $db->getOne("SELECT nombre FROM paises WHERE id=$data[id_pais]") : "Sin especificar"; ?></span><br>
														<strong>Fecha de Nacimiento: </strong> <span id="fecha_nac"><?php echo date('d/m/y', strtotime($data["fecha_nacimiento"])); ?></span><br>
														<strong>Edad: </strong> <span id="edad"><?php echo intval(date('Y')) - intval(date('Y', strtotime($data["fecha_nacimiento"]))) . "años"; ?></span><br>
														<strong>Correo electrónico: </strong> <span id="labelEmail"><?php echo $data["correo_electronico"]; ?></span><br>
														<strong>Telefonos: </strong> <span id="labelTlf"><?php echo $data["telefono"] . $data["telefono_alternativo"] = !"" ? " / " . $data["telefono_alternativo"] : ''; ?></span><br>
													</p>
												</div>
											</div>
										</div>
										<div class="col-md-6"></div>
									</div>
									<h4 style="border-bottom: 1px solid #3e70c9;margin-left: 25px;margin-right: 25px;margin-bottom: 25px;padding-bottom: 5px; width: 220px;">Experiencia laboral</h4>
									<div id="experiencias">
									<?php $mes = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");?>
										<?php if ($experiencias): ?>
											<?php foreach ($experiencias as $e): ?>
												<p style="margin-left: 50px;">
													<strong>Empresa: </strong> <?php echo $e["nombre_empresa"]; ?><br>
													<strong>País: </strong> <?php echo $e["nombre_pais"]; ?><br>
													<strong>Actividad: </strong> <?php echo $e["actividad_empresa"]; ?><br>
													<strong>Tipo puesto: </strong> <?php echo $e["tipo_puesto"]; ?><br>
													<strong>Tiempo: </strong> <?php echo $mes[$e["mes_ingreso"] - 1] . "/" . $e["ano_ingreso"] . " a " . $mes[$e["mes_egreso"] - 1] . "/" . $e["ano_egreso"] ?><br>
												</p>
											<?php endforeach?>
										<?php else: ?>
											<p style="margin-left: 50px;">Sin registros</p>
										<?php endif?>
									</div>

									<h4 style="border-bottom: 1px solid #3e70c9;margin-left: 25px;margin-right: 25px;margin-bottom: 25px;padding-bottom: 5px; width: 220px;">Estudios</h4>
									<div id="educacion">
										<?php if ($educacion): ?>
											<?php foreach ($educacion as $e): ?>
												<p style="margin-left: 50px;">
													<strong>Nivel estudio: </strong> <?php echo $e["nivel"]; ?><br>
													<strong>País: </strong> <?php echo $e["nombre_pais"]; ?><br>
													<strong>Estado estudio: </strong> <?php echo $e["estado_estudio"]; ?><br>
													<strong>Área estudio: </strong> <?php echo $e["nombre_estudio"]; ?><br>
												</p>
											<?php endforeach?>
										<?php else: ?>
											<p style="margin-left: 50px;">Sin registros</p>
										<?php endif?>
									</div>

									<h4 style="border-bottom: 1px solid #3e70c9;margin-left: 25px;margin-right: 25px;margin-bottom: 25px;padding-bottom: 5px; width: 220px;">Idiomas</h4>
									<div id="idiomas">
										<?php if ($idiomasT): ?>
											<?php foreach ($idiomasT as $i): ?>
												<?php $nivel_oral    = $db->getOne("SELECT nombre FROM nivel_idioma WHERE id=$i[nivel_oral]");?>
												<?php $nivel_escrito = $db->getOne("SELECT nombre FROM nivel_idioma WHERE id=$i[nivel_escrito]");?>
												<p style="margin-left: 50px;">
													<strong>Idioma: </strong> <?php echo $i["nombre_idioma"]; ?><br>
													<strong>Nivel Oral: </strong> <?php echo $nivel_oral; ?><br>
													<strong>Nivel escrito: </strong> <?php echo $nivel_escrito; ?><br>
												</p>
											<?php endforeach?>
										<?php else: ?>
											<p style="margin-left: 50px;">Sin registros</p>
										<?php endif?>
									</div>

									<h4 style="border-bottom: 1px solid #3e70c9;margin-left: 25px;margin-right: 25px;margin-bottom: 25px;padding-bottom: 5px; width: 220px;">Otros conocimientos</h4>
									<div id="otros_conocimientos">
										<?php if ($otros_conocimientos): ?>
											<?php foreach ($otros_conocimientos as $o): ?>
												<p style="margin-left: 50px;">
													<strong>Título: </strong> <?php echo $o["nombre"]; ?><br>
													<strong>Descripción: </strong> <?php echo $o["descripcion"]; ?><br>
												</p>
											<?php endforeach?>
										<?php else: ?>
											<p style="margin-left: 50px;">Sin registros</p>
										<?php endif?>
									</div>

									<?php $infoExtra = $db->getRow("SELECT * FROM trabajadores_infextra WHERE id_trabajador=" . $_SESSION['ctc']['id']);?>
									<?php if ($infoExtra): ?>

									<h4 style="border-bottom: 1px solid #3e70c9;margin-left: 25px;margin-right: 25px;margin-bottom: 25px;padding-bottom: 5px; width: 220px;">Información Extra</h4>
									<div id="infoExtra">
												<p style="margin-left: 50px;">
													<strong>Remuneración pretendida: </strong> $<span
														id="labelRem"><?=$infoExtra['remuneracion_pret']?></span> <br>
													<strong>Sobre mí: </strong> <span
														id="labelSobreMi"><?=$infoExtra['sobre_mi']?></span> <br>
												</p>
									</div>
									<?php endif?>

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
		</div>

		<?php require_once 'includes/libs-js.php';?>

		<script type="text/javascript" src="vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
		<script type="text/javascript" src="vendor/moment/moment.js"></script>
		<script type="text/javascript" src="vendor/bootstrap-daterangepicker/daterangepicker.js"></script>

			<script>
				$(document).ready(function(){

					var view = <?php echo isset($_GET["o"]) ? 1 : 0; ?>;
					var postulate = <?php echo $_SESSION["ctc"]["postulate"]; ?>;
					if(view == 1 && postulate == 1) {
						$("li.nav-item:nth-child(6) > a:nth-child(1)").click();
					}

					<?php if (count($infoExtra) > 1): ?>

					var remuneracion = "<?=$infoExtra['remuneracion_pret']?>";
					var sobre_mi = "<?=$infoExtra['sobre_mi']?>";
					remuneracion = parseInt(remuneracion);

					$('#remuneracion').val(remuneracion);
					$('#sobre_mi').val(sobre_mi);

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

                    $('#province').change(function(){

                        $('#city').prop('disabled',true);
                        var province = $(this).val();

                        $.ajax({
                            type: 'POST',
                            data: {op: '10', provincia: province},
                            dataType: 'json',
                            url: 'ajax/account.php',
                            success: function(data){
                                $('#city').prop('disabled',false)
                                    .html("<option value='0'>Seleccione</option>");

                                data.localidades.forEach(function(l){

                                    $('#city').append("<option value='"+l.id+"'>"+l.localidad+"</option>")

                                });
                            },
                            error: function(error){
                                swal("Error!", "Ha ocurrido un error al cargar las localidades. Por favor, recarga la pagina", "error");
                            }
                        });

                    });

					$("#sNivel").change(function() {
						if(this.value == 1) {
							$("#materias_aprobadas").css("display", "none");
						}
						else {
							$("#materias_aprobadas").css("display", "block");
						}
					});

					$(".nav-link").click(function() {
						if($(this).attr("href") == "#tab7") {
							$.ajax({
								type: 'POST',
								url: 'ajax/account.php',
								data: 'op=7',
								dataType: 'json',
								success: function(data) {
									$("#labelName").html(data.usuario.nombres);
									$("#labelLastName").html(data.usuario.apellidos);
									$("#labelCountry").html(data.usuario.pais);
									$("#labelEmail").html(data.usuario.correo_electronico);
									$("#labelTlf").html(data.usuario.telefono + " / " + data.usuario.telefono_alternativo);
                                    var fecha = formato(data.usuario.fecha_nacimiento);
									$("#fecha_nac").html(fecha);
                                    var edad = calcularEdad(data.usuario.fecha_nacimiento);
                                    $("#edad").html((edad)+"años");
                                    $("#labelRem").html(data.info_extra.remuneracion_pret);
                                    $("#labelSobreMi").html(data.info_extra.sobre_mi);
									var html = "";
									var mes = ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
									if(data.educacion.length > 0) {
										data.educacion.forEach(function(e) {
											html += '<p style="margin-left: 50px;"><strong>Nivel estudio: </strong> '+e.nivel+'<br> <strong>País: </strong> '+e.nombre_pais+'<br> <strong>Estado estudio: </strong> '+e.estado_estudio+'<br> <strong>Área estudio: </strong> '+e.nombre_estudio+'<br></p>';
										});
										$("#educacion").html(html);
									}
									if (data.experiencias.length > 0) {
										html = "";
										data.experiencias.forEach(function(ex){

											let nom_encargado = ex.nombre_encargado == null ? 'No Aplica' : ex.nombre_encargado;
											let tlf_encargado = ex.tlf_encargado == null ? 'No Aplica' : ex.tlf_encargado;

											html += '<p style="margin-left: 50px"><strong>Empresa: </strong>'+ex.nombre_empresa+'<br> <strong>País: </strong>'+ex.nombre_pais+' <br> <strong>Actividad: </strong>'+ex.actividad_empresa+'<br> <strong>Tipo puesto: </strong>'+ex.tipo_puesto+'<br><strong>Tiempo: </strong>'+mes[ex.mes_ingreso-1]+'/'+ex.ano_ingreso + ' a ' + mes[ex.mes_egreso-1] +'/'+ ex.ano_egreso + '<br> <strong>Nombre del Encargado: </strong>'+ nom_encargado + '<br> <strong>Telefono del Encargado: </strong>'+ tlf_encargado + '</p>';
										});
										$('#experiencias').html(html);
									}
									if(data.idiomas.length > 0) {
										html = "";
										data.idiomas.forEach(function(i) {
											html += '<p style="margin-left: 50px;"> <strong>Idioma: </strong> '+i.nombre_idioma+'<br> <strong>Nivel Oral: </strong> '+i.nivel_oral+'<br> <strong>Nivel escrito: </strong> '+i.nivel_escrito+'<br> </p>';
										});
										$("#idiomas").html(html);
									}
									if(data.otros_conocimientos.length > 0) {
										html = "";
										data.otros_conocimientos.forEach(function(oc) {
											html += '<p style="margin-left: 50px;"> <strong>Título: </strong> '+oc.nombre+'<br> <strong>Descripción: </strong> '+oc.descripcion+'<br> </p>';
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
					$("#province").val(provincia);
					$("#city").val(localidad);

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
								$("#monthE").val(data.mes_egreso);
								$("#yearE").val(data.ano_egreso);
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
								if($("#name").val() != "" && $("#lastName").val() != "" && $("input[type=radio][name=sex]:checked").length > 0 && parseInt($('#dia').val()) > 0 && parseInt($('#mes').val()) > 0 && parseInt($('#anio').val()) > 0 && parseInt($("#country").val()) > 0 && parseInt($("#dni").val()) > 0 && $("#numberdni").val() != "" && parseInt($("#province").val()) > 0 && parseInt($("#city").val()) > 0 && $("#street").val() != "" && $("#phone").val() != "") {
									str = '&name='+$("#name").val() + '&lastName='+$("#lastName").val() + '&sex='+$("input[type=radio][name=sex]:checked").val() + '&birthday='+$("#anio").val()+'-'+$("#mes").val() +'-'+$("#dia").val() + '&country='+$("#country").val() + '&estadoCivil='+$("#estadoCivil").val() + '&dni='+$("#dni").val() + '&numberdni='+$("#numberdni").val() + '&province='+$("#province").val() + '&city='+$("#city").val() + '&street='+$("#street").val() + '&phone='+$("#phone").val() + '&phoneAlt='+$("#phoneAlt").val() + '&sitio_web='+$('#web').val()+'&fb='+$('#fb').val()+'&tw='+$('#tw').val()+'&ig='+$('#ig').val()+'&snap='+$('#snap').val()+'&lkd='+$('#lkd').val();
									band = true;
								}
								break;
							case 2:
								if($("#company").val() != "" && parseInt($("#rCompany").val()) > 0 && parseInt($("#tCompany").val()) > 0 && $("#tEmployeer").val() != "" && $("#descriptionArea").val() != "") {
									if(parseInt($("#yearE").val()) >= parseInt($("#yearI").val())) {
										str = '&company='+$("#company").val() + '&rCompany='+$("#rCompany").val() + '&tCompany='+$("#tCompany").val() + '&tEmployeer='+$("#tEmployeer").val() + '&descriptionArea='+$("#descriptionArea").val() + '&monthI='+$("#monthI").val() + '&yearI='+$("#yearI").val() + '&monthE='+$("#monthE").val() + '&yearE='+$("#yearE").val()+'&nom_enc='+$('#nom_enc').val()+'&tlf_enc='+$('#tlf_enc').val();
										band = true;
									} else {
										swal({
											title: 'Información!',
											text: 'El año de egreso debe ser mayor que el año de ingreso',
											timer: 2000,
											confirmButtonClass: 'btn btn-primary btn-lg',
											buttonsStyling: false
										});
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
									if(parseInt($("#yearFi").val()) > parseInt($("#yearIn").val())) {
										str = '&sNivel='+$("#sNivel").val() + '&titleS='+$("#titleS").val() + '&stateS='+$("#stateS").val() + '&areaS='+$("#areaS").val() + '&institute='+$("#institute").val() + '&countryS='+$("#countryS").val() + '&mat='+$("#mat").val() + '&aprob='+$("#aprob").val() + '&monthIn='+$("#monthIn").val() + '&yearIn='+$("#yearIn").val() + '&monthFi='+$("#monthFi").val() + '&yearFi='+$("#yearFi").val();
										band = true;
									}
									else {
										swal({
											title: 'Información!',
											text: 'El año de finalización debe ser mayor que el año de inicio',
											timer: 2000,
											confirmButtonClass: 'btn btn-primary btn-lg',
											buttonsStyling: false
										});
									}
									if(parseInt($("#sNivel").val()) != 1) {
										if($("#mat").val() != "" && $("#aprob").val() != "") {
											band = true;
										}
									}
								}
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
								if($('#remuneracion').val() != '' && $('#sobre_mi').val() != ''){
									str = '&remuneracion=' + $('#remuneracion').val() + '&sobre_mi=' + $('#sobre_mi').val();
									band = true;
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
									$(elemento).removeClass('disabled').text('Guardar');
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
											$(".nav-link").removeClass("disabled");
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

											$("#contentEL").css("display", "block");
											var text = '';
											if(edit == 2) {
												data.data.forEach(function(d) {
													currentParent.html('<td>'+d.nombre_empresa+'</td><td>'+d.nombre_pais+'</td><td>'+d.actividad_empresa+'</td><td>'+d.tipo_puesto+'</td><td><div class="pull-xs-left"><a class="text-grey m-r-1 modifyEL" href="javascript:void(0)" data-target="'+d.id+'" data-option="2"><i class="ti-pencil-alt"></i></a><a class="text-grey deleteItem" href="javascript:void(0)" data-target="'+d.id+'" data-option="2"><i class="ti-close"></i></a></div></td>');
													text += '<p style="margin-left: 50px;"> <strong>Empresa: </strong> '+d.nombre_empresa+'<br> <strong>País: </strong> '+d.nombre_pais+'<br> <strong>Actividad: </strong> '+d.actividad_empresa+'<br> <strong>Tipo puesto: </strong> '+d.tipo_puesto+'<br> </p>';
												});
												$("#experiencias").append(text);
											}
											else {
												data.data.forEach(function(d) {
													$("#t2").append('<tr><td>'+d.nombre_empresa+'</td><td>'+d.nombre_pais+'</td><td>'+d.actividad_empresa+'</td><td>'+d.tipo_puesto+'</td><td><div class="pull-xs-left"><a class="text-grey m-r-1 modifyEL" href="javascript:void(0)" data-target="'+d.id+'" data-option="2"><i class="ti-pencil-alt"></i></a><a class="text-grey deleteItem" href="javascript:void(0)" data-target="'+d.id+'" data-option="2"><i class="ti-close"></i></a></div></td></tr>');
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
													currentParent.html('<tr><td>'+d.nivel+'</td><td>'+d.nombre_pais+'</td><td>'+d.estado_estudio+'</td><td>'+d.nombre_estudio+'</td><td><div class="pull-xs-left"><a class="text-grey m-r-1 modifyES" href="javascript:void(0)" data-target="'+d.id+'" data-option="3"><i class="ti-pencil-alt"></i></a><a class="text-grey deleteItem" href="javascript:void(0)" data-target="'+d.id+'" data-option="3"><i class="ti-close"></i></a></div></td></tr>');
													text += '<p style="margin-left: 50px;"> <strong>Idioma: </strong> '+d.nombre_pais+'<br> <strong>Nivel Oral: </strong> '+d.nivel+'<br> <strong>Nivel escrito: </strong> '+d.estado_estudio+'<br> </p>';
												});
												$("#idiomas").append(text);
											}
											else {
												data.data.forEach(function(d) {
													$("#t3").append('<tr><td>'+d.nivel+'</td><td>'+d.nombre_pais+'</td><td>'+d.estado_estudio+'</td><td>'+d.nombre_estudio+'</td><td><div class="pull-xs-left"><a class="text-grey m-r-1 modifyES" href="javascript:void(0)" data-target="'+d.id+'" data-option="3"><i class="ti-pencil-alt"></i></a><a class="text-grey deleteItem" href="javascript:void(0)" data-target="'+d.id+'" data-option="3"><i class="ti-close"></i></a></div></td></tr>');
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
													currentParent.html('<td>'+d.nombre_idioma+'</td><td>'+d.nivel_oral+'</td><td>'+d.nivel_escrito+'</td><td><div class="pull-xs-left"><a class="text-grey m-r-1 modifyI" href="javascript:void(0)" data-target="'+d.id+'" data-option="4"><i class="ti-pencil-alt"></i></a><a class="text-grey deleteItem" href="javascript:void(0)" data-target="'+d.id+'" data-option="4"><i class="ti-close"></i></a></div></td>');
													text += '<p style="margin-left: 50px;"> <strong>Idioma: </strong> '+d.nombre_idioma+'<br> <strong>Nivel Oral: </strong> '+d.nivel_oral+'<br> <strong>Nivel escrito: </strong> '+d.nivel_escrito+'<br> </p>';
												});
											}
											else {
												data.data.forEach(function(d) {
													$("#t4").append('<tr><td>'+d.nombre_idioma+'</td><td>'+d.nivel_oral+'</td><td>'+d.nivel_escrito+'</td><td><div class="pull-xs-left"><a class="text-grey m-r-1 modifyI" href="javascript:void(0)" data-target="'+d.id+'" data-option="4"><i class="ti-pencil-alt"></i></a><a class="text-grey deleteItem" href="javascript:void(0)" data-target="'+d.id+'" data-option="4"><i class="ti-close"></i></a></div></td></tr>');
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
											$("#contentOC").css("display", "block");
											if(edit == 2) {
												data.data.forEach(function(d) {
													currentParent.html('<td>'+d.nombre+'</td><td>'+d.descripcion+'</td><td><div class="pull-xs-left"><a class="text-grey m-r-1 modifyOC" href="javascript:void(0)" data-target="'+d.id+'" data-option="5"><i class="ti-pencil-alt"></i></a><a class="text-grey deleteItem" href="javascript:void(0)" data-target="'+d.id+'" data-option="5"><i class="ti-close"></i></a></div></td>');
												});
											}
											else {
												data.data.forEach(function(d) {
													$("#t5").append('<tr><td>'+d.nombre+'</td><td>'+d.descripcion+'</td><td><div class="pull-xs-left"><a class="text-grey m-r-1 modifyOC" href="javascript:void(0)" data-target="'+d.id+'" data-option="5"><i class="ti-pencil-alt"></i></a><a class="text-grey deleteItem" href="javascript:void(0)" data-target="'+d.id+'" data-option="5"><i class="ti-close"></i></a></div></td></tr>');
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
			</script>
	</body>

</html>