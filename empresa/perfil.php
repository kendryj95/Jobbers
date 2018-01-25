<?php
	session_start();
	if(!isset($_SESSION["ctc"]["empresa"]) && !isset($_REQUEST["e"])) {
		header('Location: acceder.php');
	}

	require_once('../classes/DatabasePDOInstance.function.php');

	$db = DatabasePDOInstance();
	
	//echo json_encode($_SESSION);

	$activities = $db->getAll("SELECT * FROM actividades_empresa");
	$id_empresa = isset($_SESSION["ctc"]["id"]) ? $_SESSION["ctc"]["id"] : 0;
	$e = isset($_REQUEST["e"]) ? $_REQUEST["e"] : false;
	$empresa = 1;
	if(isset($_SESSION["ctc"]["empresa"])) {
		$foto = $_SESSION["ctc"]["pic"];
	}
	if($e) {
		if(!isset($_SESSION["ctc"]["empresa"])) {
			$e = array_pop(explode("-", $e));
			$id_empresa = $e;
			$empresa = 0;
			$pic = $db->getOne("SELECT id_imagen FROM empresas WHERE id=$id_empresa");
			if($pic == 0) {
				$foto = "avatars/user.png";
			}
			else {
				$foto = $db->getOne("SELECT CONCAT(directorio, '/', nombre, '.', extension ) FROM imagenes WHERE id=$pic");
			}
		}
	}
	$infoEmpresa = $db->getRow("SELECT empresas.*, actividades_empresa.nombre AS actividad FROM empresas LEFT JOIN actividades_empresa ON actividades_empresa.id=empresas.id_actividad WHERE empresas.id=$id_empresa");

	$cantidadPublicaciones = $db->getOne("
		SELECT
			COUNT(*)
		FROM
			publicaciones
		WHERE
			id_empresa = $infoEmpresa[id]");

	$publicaciones = $db->getAll("
		SELECT
			p.titulo,
			p.descripcion,
			p.fecha_actualizacion,
			a.amigable AS area_amigable,
			a.nombre AS area_nombre,
			ase.amigable AS sector_amigable,
			ase.nombre AS sector_nombre,
			p.amigable
		FROM
			publicaciones AS p
		INNER JOIN publicaciones_sectores AS ps ON p.id = ps.id_publicacion
		INNER JOIN areas_sectores AS ase ON ps.id_sector = ase.id
		INNER JOIN areas AS a ON ase.id_area = a.id
		WHERE p.id_empresa = $id_empresa ORDER BY p.fecha_actualizacion DESC
	");
	$link_empresa = $db->getOne("SELECT link_empresa FROM empresas_planes WHERE id_empresa=$id_empresa");
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
		<title>JOBBERS - Perfil</title>
		<?php require_once('../includes/libs-css.php'); ?>
		<link rel="stylesheet" href="../vendor/dropify/dist/css/dropify.min.css">
		<link rel="stylesheet" href="../vendor/x-editable/bootstrap3-editable/css/bootstrap-editable.css">

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

			<!-- Sidebar second -->
			<?php require_once('../includes/sidebar-second.php'); ?>

			<!-- Header -->
			<?php require_once('../includes/header.php'); ?>

			<div class="site-content" style="margin-left: 0px;">
				<!-- Content -->
				<?php if (isset($_SESSION['ctc']) && $_SESSION['ctc']['type'] == 1):
					$grid = "col-md-9";
					require_once('../includes/sidebar.php');
					else:
					$grid = "container";
				?>
				<?php endif ?>
				<div class="<?php echo $grid?>">
					<div class="profile-header m-b-1">
						<div class="profile-header-cover img-cover" style="background-image: url(img/photos-1/2.jpg);"></div>
						<div class="profile-header-counters clearfix">
							<div class="container-fluid">
								<div class="pull-right">
									<a href="<?php echo $empresa == 1 ? 'publicaciones.php' : 'javascript:void(0)'; ?>" class="text-black block-pub">
										<h5 class="font-weight-bold"><?php echo $cantidadPublicaciones; ?></h5>
										<span class="text-muted">Publicaciones</span>
									</a>
								</div>
							</div>
						</div>
					</div>
					<div class="container-fluid"> 
						<div class="row">
							<div class="col-sm-5 col-md-5">
								<div class="card profile-card">
									<div class="profile-avatar" style="text-align: center; margin-top: 66px;">
										<img src="img/<?php echo $foto; ?>" alt="" style="max-width: 150px;">
										<br>
										<?php if($empresa == 1): ?>
											<a href="javascript:void(0)" data-toggle="modal" data-target="#pic" title="cambiar foto de perfil">Cambiar foto</a>
										<?php endif ?>
									</div>
									<div class="card-block" style="text-align: center;">
										<h4 class="m-b-0-25"><?php echo $infoEmpresa["nombre"]; ?></h4>
										<!--<div class="text-muted m-b-1">Software Engineer</div>-->
									</div>
									<ul class="list-group" style="margin-bottom: 10px;">
										<br>
										<?php if(isset($_SESSION['ctc']['empresa'])){ ?>
										<h5 style="margin-left: 10px;">Datos de la empresa</h5>
										<hr>
										<form action="">
											<div class="row" style="margin-left: 10px">
												<div class="col-md-12">
													<div class="form-group">
														<label for="empresa"><b>Nombre de la empresa <span style="color: red">*</span></b> </label>
														<input type="text" class="form-control" id="emp" placeholder="Nombre de la empresa" value="<?= $infoEmpresa["nombre"] ?>">
													
													</div>
												</div>
												
												<div class="col-md-12">
													<div class="form-group">
														<label for="responsable"><b>Nombre del responsable <span style="color: red">*</span></b> </label>
														<input type="text" class="form-control" id="nom_responsable" placeholder="Nombre del responsable" value="<?= $infoEmpresa['nombre_responsable'] ?>">
													</div>
												</div> 

												<div class="col-md-12">
													<div class="form-group">
														<label for="responsable"><b>Apellido del responsable <span style="color: red">*</span></b> </label>
														<input type="text" class="form-control" id="ape_responsable" placeholder="Nombre del responsable" value="<?= $infoEmpresa['apellido_responsable'] ?>">
													</div>
												</div> 

												<div class="col-md-12">
													<div class="form-group">
														<label for="email"><b>Correo Electronico <span style="color: red">*</span></b> </label>
														<input type="email" class="form-control" id="email" placeholder="Correo Electronico" value="<?= $infoEmpresa['correo_electronico'] ?>">
													</div>
												</div>

												<div class="col-md-12">
													<div class="form-group">
														<label for="razon_soc"><b>Razon Social <span style="color: red">*</span></b> </label>
														<input type="text" class="form-control" id="razon_soc" placeholder="Razon Social" value="<?= $infoEmpresa['razon_social'] ?>">
													</div>
												</div>

												<div class="col-md-12">
													<div class="form-group">
														<label for="cuit"><b>CUIT:</b> </label>
														<input type="text" class="form-control" id="cuit" placeholder="CUIT (Opcional)" value="<?= $infoEmpresa['cuit'] ?>" onchange="validar(this.id,'num')">
													</div>
												</div>

												<div class="col-md-12">
													<div class="form-group">
														<label for="tlf"><b>Telefono <span style="color: red">*</span></b> </label>
														<input type="number" class="form-control" id="tlf" placeholder="Telefono" value="<?= $infoEmpresa['telefono'] ?>">
													</div>
												</div>
												<div class="clearfix"></div>
												<div class="col-md-4">
													<button id="update_profile" class="btn btn-primary">Actualizar</button>
												</div>
											</div>
										</form>
										<br>
										<hr>
										<h5 style="margin-left: 10px;">Cambiar Contraseña</h5>
										<br>
										<div class="row" style="margin-left: 10px">
											<div class="col-md-12">
												<div class="form-group">
													<label for="currentPass"><b>Contraseña Actual <span style="color: red">*</span></b> </label>
													<input type="password" class="form-control" id="currentPass" placeholder="Contraseña Actual" value="">
												</div>
											</div>
											<div class="col-md-12">
												<div class="form-group">
													<label for="newPass"><b>Contraseña Nueva <span style="color: red">*</span></b> </label>
													<input type="password" class="form-control" id="newPass" placeholder="Contraseña Nueva" value="">
												</div>
											</div>
											<div class="col-md-12">
												<div class="form-group">
													<label for="repeatPass"><b>Repetir Contraseña <span style="color: red">*</span></b> </label>
													<input type="password" class="form-control" id="repeatPass" placeholder="Repetir Contraseña" value="">
												</div>
											</div>
											<div class="clearfix"></div>
											<div class="col-md-4">
												<button id="updatePass" class="btn btn-primary">Actualizar</button>
											</div>
										</div>
										<hr>
										<?php } ?>	
										<div class="row" style="margin-left: 10px;">			
											<?php if($empresa == 1): ?>
											<?php if($infoEmpresa["actividad"]): ?>
												<div class="col-md-12">
													<a href="#" id="inline-activity" data-type="select" data-pk="1" data-value="" data-title="Actividad empresa" class="list-group-item editable editable-click" style="color: rgb(152, 166, 173);"><?php echo $infoEmpresa["actividad"]; ?></a>
												</div>
											<?php else: ?>
												<div class="col-md-12" style="margin-top: 20px;" id="containerActivity">
													<div class="col-md-12">
														<select class="custom-select" id="activity">
															<option value="0">Actividad de la empresa</option>
															<?php foreach($activities as $a): ?>
																<option value="<?php echo $a["id"]; ?>"><?php echo $a["nombre"]; ?></option>
															<?php endforeach ?>
														</select>
													</div>
													<div class="col-md-4">
														<a class="btn btn-primary action" href="javascript:void(0)" data-target="activity">+</a>
													</div>
												</div>
											<?php endif ?>
											<br><br>
											<?php if($infoEmpresa["sitio_web"]): ?>
												<div class="col-md-12" style="margin-top: 20px;">
													<a class="list-group-item editable editable-click" href="#" id="inline-site" data-type="text" data-pk="1" data-title="Sitio web"><i class="ti-world m-r-0-5"></i> <?php echo $infoEmpresa["sitio_web"]; ?></a>
												</div>
											<?php else: ?>
												<div class="col-md-12" style="margin-top: 20px; padding-left: 0px;" id="containerWeb">
													<div class="col-md-10">
														<input class="form-control" id="web" placeholder="Sitio Web" type="text">
													</div>
													<div class="col-md-2">
														<a class="btn btn-primary action" href="javascript:void(0)" data-target="web">+</a>
													</div>
												</div>
											<?php endif ?>
											<br><br>
											<?php if($infoEmpresa["facebook"]): ?>
												<div class="col-md-12" style="margin-top: 20px;">
													<a class="list-group-item editable editable-click" href="#" id="inline-facebook" data-type="text" data-pk="1" data-title="Facebook"><i class="ti-facebook m-r-0-5"></i> <?php echo $infoEmpresa["facebook"]; ?></a>
												</div>
											<?php else: ?>
												<div class="col-md-12" style="margin-top: 20px; padding-left: 0px;" id="containerFB">
													<div class="col-md-8 col-xs-9">
														<input class="form-control" id="fb" placeholder="Facebook" type="text">
													</div>
													<div class="col-md-4">
														<a class="btn btn-primary action" href="javascript:void(0)" data-target="fb">+</a>
													</div>
												</div>
											<?php endif ?>										
											<br><br>
											<?php if($infoEmpresa["twitter"]): ?>
												<div class="col-md-12" style="margin-top: 20px;">
													<a class="list-group-item" href="#" id="inline-twitter" data-type="text" data-pk="1" data-title="Twitter" class="editable editable-click"><i class="ti-twitter m-r-0-5"></i> <?php echo $infoEmpresa["twitter"]; ?></a>
												</div>
											<?php else: ?>
												<div class="col-md-12" style="margin-top: 20px; padding-left: 0px;" id="containerTW">
													<div class="col-md-10 col-xs-9">
														<input class="form-control" id="tw" placeholder="Twitter" type="text">
													</div>
													<div class="col-md-2">
														<a class="btn btn-primary action" href="javascript:void(0)" data-target="tw">+</a>
													</div>
												</div>
											<?php endif ?>									
											<br><br>
											<?php if($infoEmpresa["instagram"]): ?>
												<div class="col-md-12" style="margin-top: 20px;">
													<a class="list-group-item"  href="#" id="inline-instagram" data-type="text" data-pk="1" data-title="Instagram" class="editable editable-click"><i class="ti-instagram m-r-0-5"></i> <?php echo $infoEmpresa["instagram"]; ?></a>
												</div>
											<?php else: ?>
												<div class="col-md-12" style="margin-top: 20px; padding-left: 0px;" id="containerINS">
													<div class="col-md-10 col-xs-9">
														<input class="form-control" id="ins" placeholder="Instagram" type="text">
													</div>
													<div class="col-md-2">
														<a class="btn btn-primary action" href="javascript:void(0)" data-target="ins">+</a>
													</div>
												</div>
											<?php endif ?>									
											<br><br>
											<?php if($infoEmpresa["linkedin"]): ?>
												<div class="col-md-12" style="margin-top: 20px;">
													<a class="list-group-item"  href="#" id="inline-linkedin" data-type="text" data-pk="1" data-title="Linkedin" class="editable editable-click"><i class="ti-linkedin m-r-0-5"></i> <?php echo $infoEmpresa["linkedin"]; ?></a>
												</div>
											<?php else: ?>
												<div class="col-md-12" style="margin-top: 20px; padding-left: 0px;" id="containerLIN">
													<div class="col-md-10 col-xs-9">
														<input class="form-control" id="lin" placeholder="Linkedin" type="text">
													</div>
													<div class="col-md-2">
														<a class="btn btn-primary action" href="javascript:void(0)" data-target="lin">+</a>
													</div>
												</div>
											<?php endif ?>
										<?php else: ?>
											<?php if($infoEmpresa["actividad"]): ?>
												<a class="list-group-item" href="#">
													<?php echo $infoEmpresa["actividad"]; ?>
												</a>
											<?php endif ?>
											<?php if($infoEmpresa["sitio_web"] && $link_empresa == 1): ?>
												<a class="list-group-item" href="<?php echo $infoEmpresa["sitio_web"]; ?>">
													<i class="ti-world m-r-0-5"></i> <?php echo $infoEmpresa["sitio_web"]; ?>
												</a>
											<?php endif ?>
											<?php if($infoEmpresa["facebook"]): ?>
												<a class="list-group-item" href="<?php echo $infoEmpresa["facebook"]; ?>">
													<i class="ti-facebook m-r-0-5"></i> <?php echo $infoEmpresa["facebook"]; ?>
												</a>
											<?php endif ?>
											<?php if($infoEmpresa["twitter"]): ?>
												<a class="list-group-item" href="<?php echo $infoEmpresa["twitter"]; ?>">
													<i class="ti-twitter m-r-0-5"></i> <?php echo $infoEmpresa["twitter"]; ?>
												</a>
											<?php endif ?>
											<?php if($infoEmpresa["instagram"]): ?>
												<div class="col-md-12" style="margin-top: 20px;">
													<a class="list-group-item" href="<?php echo $infoEmpresa["instagram"]; ?>">
														<i class="ti-instagram m-r-0-5"></i> <?php echo $infoEmpresa["instagram"]; ?>
													</a>
												</div>
											<?php endif ?>
											<?php if($infoEmpresa["linkedin"]): ?>
												<a class="list-group-item" href="<?php echo $infoEmpresa["linkedin"]; ?>">
													<i class="ti-linkedin m-r-0-5"></i> <?php echo $infoEmpresa["linkedin"]; ?>
												</a>
											<?php endif ?>
										<?php endif ?>
										</div>
									</ul>
								</div>
								
								<div class="modal fade" id="pic" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
												<h4 class="modal-title" id="exampleModalLabel">Cambiar foto de perfil</h4>
											</div>
											<div class="modal-body">
												<form method="POST" id="upload">
													<input class="dropify" name="file" id="file" type="file">
												</form>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
												<button type="button" id="savePic" class="btn btn-primary">Guardar</button>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-7 col-md-7">
								<div class="card m-b-0">
									<ul class="nav nav-tabs nav-tabs-2 profile-tabs" role="tablist">
										<li class="nav-item" style="background-color: #fff">
											<a class="nav-link active" data-toggle="tab" href="#stream" role="tab">Publicaciones</a>
										</li>
									</ul>
									<div class="tab-content" style="background-color: #fff">
										<div class="tab-pane active" id="stream" role="tabpanel">
											<?php foreach($publicaciones as $p): ?>
												<div class="media stream-item">
													<div class="media-left">
														<div class="avatar box-64">
															<img class="b-a-radius-circle" src="img/<?php echo $foto; ?>" alt="">
														</div>
													</div>
													<div class="media-body">
														<h6 class="media-heading">
															<a class="text-black" href="../empleos-detalle.php?a=<?php echo "$p[area_amigable]&s=$p[sector_amigable]&p=$p[amigable]"; ?>"><?php echo $p["titulo"]; ?></a>
															<!--<span class="font-90 text-muted">posted an update</span>-->
														</h6>
														<span class="font-90 stream-meta">Publicado desde el <?php echo date('d/m/Y', strtotime($p["fecha_actualizacion"])); ?></span>
														<div class="stream-body">
															<p><?php echo $p["descripcion"]; ?></p>
															<a style="color: white; margin-top: 10px; float: right;" class="btn btn-primary w-min-sm m-b-0-25 waves-effect waves-light" href="../empleos-detalle.php?a=<?php echo "$p[area_amigable]&s=$p[sector_amigable]&p=$p[amigable]"; ?>">Ver más..</a>
														</div>
													</div>
												</div>
											<?php endforeach ?>
										</div>
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
		<?php require_once('../includes/libs-js.php'); ?>
		<script type="text/javascript" src="../vendor/dropify/dist/js/dropify.min.js"></script>
		<script type="text/javascript" src="../js/jquery.form.js"></script>
		<script type="text/javascript" src="../vendor/x-editable/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
		<script>
			var activities = JSON.parse('<?php echo json_encode($activities); ?>');
			var activity = "<?php echo $infoEmpresa["actividad"]; ?>";
			var act = [];
			activities.forEach(function(a) {
				act.push({value: a.id, text: a.nombre});
			});
			$(document).ready(function(){

				/* Preloader */
				setTimeout(function() {
					$('.preloader').fadeOut();
				}, 500);

							
				$.fn.editableform.buttons = 
				'<button type="submit" class="btn btn-primary editable-submit waves-effect waves-light"><i class="ti-check"></i></button>' +
				'<button type="button" class="btn editable-cancel btn-secondary waves-effect"><i class="ti-close"></i></button>';

				$('#update_profile').on('click', function () {
					
					var empresa = $('#emp').val();
					var nom_responsable = $('#nom_responsable').val();
					var ape_responsable = $('#ape_responsable').val();
					var email = $('#email').val();
					var razon_soc = $('#razon_soc').val();
					var cuit = $('#cuit').val();
					var tlf = $('#tlf').val();

					if (empresa != "" && nom_responsable != "" && ape_responsable != "" && email != "" && razon_soc != "" && tlf != "") {

						$.ajax({
							url: 'ajax/empresas.php',
							type: 'POST',
							data: {op: 11,empresa: empresa, nom_responsable: nom_responsable, ape_responsable: ape_responsable,email: email,razon_soc: razon_soc, cuit: cuit, tlf: tlf},
							success: function(response){
								swal({
									title: 'Información!',
									text: response,
									timer: 3000,
									confirmButtonClass: 'btn btn-primary btn-lg',
									buttonsStyling: false
								});
							},
							error: function (error) {
								console.log('Error en el ajax: '+error);
							}
						});

					} else {

						swal({
								title: 'Información!',
								text: 'No puede quedar en blanco los campos obligatorios, intentelo de nuevo.',
								timer: 3000,
								confirmButtonClass: 'btn btn-primary btn-lg',
								buttonsStyling: false
						});

					}

					return false;
				});

				$('#updatePass').on('click', function(){
					var currentPass = $('#currentPass').val();
					var newPass = $('#newPass').val();
					var repeatPass = $('#repeatPass').val();

					if (currentPass != "" && newPass != "" && repeatPass != "") {
						if (newPass == repeatPass) {
							$.ajax({
								url: 'ajax/empresas.php',
								type: 'POST',
								dataType: 'json',
								data: {op: 12, currentPass: currentPass, newPass: newPass},
								success: function(data){
									if (data.status == 2) {
										swal({
											title: 'Información!',
											text: 'La contraseña actual es incorrecta, por favor intente de nuevo.',
											confirmButtonClass: 'btn btn-primary btn-lg',
											buttonsStyling: false
										});
									} else {
										$("#currentPass").val("");
										$("#newPass").val("");
										$("#repeatPass").val("");
										swal({
											title: 'Información!',
											text: 'Contraseña modificada exitosamente.',
											timer: 2000,
											confirmButtonClass: 'btn btn-primary btn-lg',
											buttonsStyling: false
										});
									}
								},
								error: function(error){
									swal({
										title: 'Información!',
										text: 'Ha ocurrido un error de conexion. Intentelo de nuevo:',
										confirmButtonClass: 'btn btn-primary btn-lg',
										buttonsStyling: false
									});
								}
							});
							
						} else {
							swal({
									title: 'Información!',
									text: 'Las contraseñas no coinciden. Intentelo de nuevo.',
									timer: 3000,
									confirmButtonClass: 'btn btn-primary btn-lg',
									buttonsStyling: false
							});
						}

					} else {
						swal({
								title: 'Información!',
								text: 'No puede quedar en blanco los campos obligatorios, intentelo de nuevo.',
								timer: 3000,
								confirmButtonClass: 'btn btn-primary btn-lg',
								buttonsStyling: false
						});
					}
				});
				
				$('#inline-activity').editable({
					prepend: activity,
					mode: 'inline',
					source: act,
					display: function(value, sourceData) {
						var colors = {"": "#98a6ad", 1: "#5fbeaa", 2: "#5d9cec"},
						elem = $.grep(sourceData, function(o){return o.value == value;});

						if(elem.length) {
							$(this).text(elem[0].text).css("color", colors[value]);
						} else {
							$(this).empty();
						}
					},
					url: 'ajax/empresas.php?op=9&opt=fields&option=activity',
					success: function(response, newValue) {
						var data = JSON.parse(response);
						if(parseInt(data.info) == 1) {
							swal({
								title: 'Información!',
								text: 'Cambios realizados correctamente',
								timer: 3000,
								confirmButtonClass: 'btn btn-primary btn-lg',
								buttonsStyling: false
							});
						}
						else {
							swal({
								title: 'Información!',
								text: 'No puede quedar en blanco este campo, la información no se ha almacenado',
								timer: 3000,
								confirmButtonClass: 'btn btn-primary btn-lg',
								buttonsStyling: false
							});
						}
						//if(response.status == 'error') return response.msg; //msg will be shown in editable form
					}
				});

				$('#inline-site').editable({
					type: 'text',
					pk: 1,
					name: 'site',
					title: 'Sitio web',
					mode: 'inline',
					url: 'ajax/empresas.php?op=9&opt=fields&option=web',
					success: function(response, newValue) {
							var data = JSON.parse(response);
							swal({
								title: 'Información!',
								text: 'Cambios realizados correctamente',
								timer: 3000,
								confirmButtonClass: 'btn btn-primary btn-lg',
								buttonsStyling: false
							});

							if (data.value == "") {
								$('#containerWeb').html('<div class="col-md-8"><input class="form-control" id="web" placeholder="Sitio Web" type="text"></div><div class="col-md-4"><a class="btn btn-primary action" href="javascript:void(0)" data-target="web">+</a></div>');
							}

						
						//if(response.status == 'error') return response.msg; //msg will be shown in editable form
					}
				});
				$('#inline-facebook').editable({
					type: 'text',
					pk: 1,
					name: 'facebook',
					title: 'Facebok',
					mode: 'inline',
					url: 'ajax/empresas.php?op=9&opt=fields&option=fb',
					success: function(response, newValue) {
							var data = JSON.parse(response);
							swal({
								title: 'Información!',
								text: 'Cambios realizados correctamente',
								timer: 3000,
								confirmButtonClass: 'btn btn-primary btn-lg',
								buttonsStyling: false
							});

							if (data.value == "") {
								$('#containerFB').html('<div class="col-md-8"><input class="form-control" id="fb" placeholder="Facebook" type="text"></div><div class="col-md-4"><a class="btn btn-primary action" href="javascript:void(0)" data-target="fb">+</a></div>');
							}
						
						//if(response.status == 'error') return response.msg; //msg will be shown in editable form
					}
				});
				$('#inline-twitter').editable({
					type: 'text',
					pk: 1,
					name: 'twitter',
					title: 'Twitter',
					mode: 'inline',
					url: 'ajax/empresas.php?op=9&opt=fields&option=tw',
					success: function(response, newValue) {
							var data = JSON.parse(response);
							swal({
								title: 'Información!',
								text: 'Cambios realizados correctamente',
								timer: 3000,
								confirmButtonClass: 'btn btn-primary btn-lg',
								buttonsStyling: false
							});

							if (data.value == "") {
								$('#containerTW').html('<div class="col-md-8"><input class="form-control" id="ins" placeholder="Instagram" type="text"></div><div class="col-md-4"><a class="btn btn-primary action" href="javascript:void(0)" data-target="ins">+</a></div>');
							}
						
						//if(response.status == 'error') return response.msg; //msg will be shown in editable form
					}
				});
				$('#inline-instagram').editable({
					type: 'text',
					pk: 1,
					name: 'instagram',
					title: 'Instagram',
					mode: 'inline',
					url: 'ajax/empresas.php?op=9&opt=fields&option=ins',
					success: function(response, newValue) {
							var data = JSON.parse(response);
							swal({
								title: 'Información!',
								text: 'Cambios realizados correctamente',
								timer: 3000,
								confirmButtonClass: 'btn btn-primary btn-lg',
								buttonsStyling: false
							});

							if (data.value == "") {
								$('#containerINS').html('<div class="col-md-8"><input class="form-control" id="ins" placeholder="Instagram" type="text"></div><div class="col-md-4"><a class="btn btn-primary action" href="javascript:void(0)" data-target="ins">+</a></div>');
							}
						
						//if(response.status == 'error') return response.msg; //msg will be shown in editable form
					}
				});
				$('#inline-linkedin').editable({
					type: 'text',
					pk: 1,
					name: 'linkedin',
					title: 'Linkedin',
					mode: 'inline',
					url: 'ajax/empresas.php?op=9&opt=fields&option=lin',
					success: function(response, newValue) {
							console.log(response);
							var data = JSON.parse(response);
							swal({
								title: 'Información!',
								text: 'Cambios realizados correctamente',
								timer: 3000,
								confirmButtonClass: 'btn btn-primary btn-lg',
								buttonsStyling: false
							});

							
							if (data.value == "") {
								$('#containerLIN').html('<div class="col-md-8"><input class="form-control" id="lin" placeholder="Linkedin" type="text"></div><div class="col-md-4"><a class="btn btn-primary action" href="javascript:void(0)" data-target="lin">+</a></div>');
							}
						
						//if(response.status == 'error') return response.msg; //msg will be shown in editable form
					}
				});
				
				$(".action").click(function() {
					var op = $(this).attr("data-target");
					var band = false;
					var text = "";
					switch(op) {
						case 'activity':
							if($("#activity").val() != 0) {
								band = true;
								text = $("#activity").val();
							}
							else {
								swal({
									title: 'Información!',
									text: 'Debe seleccionar la actividad de su empresa',
									timer: 2000,
									confirmButtonClass: 'btn btn-primary btn-lg',
									buttonsStyling: false
								});
							}
							break;
						case 'web':
							if($("#web").val() != "") {
								band = true;
								text = $("#web").val();
							}
							else {
								swal({
									title: 'Información!',
									text: 'Debe escribir el enlace a su página web',
									timer: 2000,
									confirmButtonClass: 'btn btn-primary btn-lg',
									buttonsStyling: false
								});
							}
							break;
						case "fb":
							if($("#fb").val() != "") {
								band = true;
								text = $("#fb").val();
							}
							else {
								swal({
									title: 'Información!',
									text: 'Debe escribir el enlace a Facebook',
									timer: 2000,
									confirmButtonClass: 'btn btn-primary btn-lg',
									buttonsStyling: false
								});
							}
							break;	
						case "tw":
							if($("#tw").val() != "") {
								band = true;
								text = $("#tw").val();
							}
							else {
								swal({
									title: 'Información!',
									text: 'Debe escribir el enlace a Twitter',
									timer: 2000,
									confirmButtonClass: 'btn btn-primary btn-lg',
									buttonsStyling: false
								});
							}
							break;
						case "ins":
							if($("#ins").val() != "") {
								band = true;
								text = $("#ins").val();
							}
							else {
								swal({
									title: 'Información!',
									text: 'Debe escribir el enlace a Instagram',
									timer: 2000,
									confirmButtonClass: 'btn btn-primary btn-lg',
									buttonsStyling: false
								});
							}
							break;
						case "lin":
							if($("#lin").val() != "") {
								band = true;
								text = $("#lin").val();
							}
							else {
								swal({
									title: 'Información!',
									text: 'Debe escribir el enlace a Linkedin',
									timer: 2000,
									confirmButtonClass: 'btn btn-primary btn-lg',
									buttonsStyling: false
								});

								return false;
							}
							break;
					}
					if(band) {
						$.ajax({
							type: 'POST',
							url: 'ajax/empresas.php',
							data: 'op=9&opt=' + op + '&text=' + text,
							dataType: 'json',
							success: function(data) {
								console.log(data);
								switch(op) {
									case 'activity':
										window.location.assign("perfil.php");
										break;
									case 'web':
										$("#containerWeb").html('<a class="list-group-item" style="display: inline;" href="#" id="inline-site" data-type="text" data-pk="1" data-title="Sitio web" class="editable editable-click"><i class="ti-world m-r-0-5"></i>'+text+'</a>');
										swal({
											title: 'Información!',
											text: 'Cambios realizados correctamente',
											timer: 3000,
											confirmButtonClass: 'btn btn-primary btn-lg',
											buttonsStyling: false
										});
										$('#inline-site').editable({
											type: 'text',
											pk: 1,
											name: 'site',
											title: 'Sitio web',
											mode: 'inline',
											url: 'ajax/empresas.php?op=9&opt=fields&option=web',
											success: function(response, newValue) {
												
											}
										});
										break;
									case 'fb':
										$("#containerFB").html('<a class="list-group-item" style="display: inline;" href="#" id="inline-facebook" data-type="text" data-pk="1" data-title="Facebook" class="editable editable-click"><i class="ti-facebook m-r-0-5"></i>'+text+'</a>');
										swal({
											title: 'Información!',
											text: 'Cambios realizados correctamente',
											timer: 3000,
											confirmButtonClass: 'btn btn-primary btn-lg',
											buttonsStyling: false
										});
										$('#inline-facebook').editable({
											type: 'text',
											pk: 1,
											name: 'facebook',
											title: 'Facebok',
											mode: 'inline',
											url: 'ajax/empresas.php?op=9&opt=fields&option=fb',
											success: function(response, newValue) {
												
											}
										});
										break;
									case 'tw':
										$("#containerTW").html('<a class="list-group-item" style="display: inline;" href="#" id="inline-twitter" data-type="text" data-pk="1" data-title="Twitter" class="editable editable-click"><i class="ti-twitter m-r-0-5"></i>'+text+'</a>');
										swal({
											title: 'Información!',
											text: 'Cambios realizados correctamente',
											timer: 3000,
											confirmButtonClass: 'btn btn-primary btn-lg',
											buttonsStyling: false
										});
										$('#inline-twitter').editable({
											type: 'text',
											pk: 1,
											name: 'twitter',
											title: 'Twitter',
											mode: 'inline',
											url: 'ajax/empresas.php?op=9&opt=fields&option=tw',
											success: function(response, newValue) {
												
											}
										});
										break;
									case 'ins':
										$("#containerINS").html('<a class="list-group-item" style="display: inline;" href="#" id="inline-instagram" data-type="text" data-pk="1" data-title="Instagram" class="editable editable-click"><i class="ti-instagram m-r-0-5"></i>'+text+'</a>');
										swal({
											title: 'Información!',
											text: 'Cambios realizados correctamente',
											timer: 3000,
											confirmButtonClass: 'btn btn-primary btn-lg',
											buttonsStyling: false
										});
										$('#inline-instagram').editable({
											type: 'text',
											pk: 1,
											name: 'instagram',
											title: 'Instagram',
											mode: 'inline',
											url: 'ajax/empresas.php?op=9&opt=fields&option=ins',
											success: function(response, newValue) {
												
											}
										});
										break;
									case 'lin':
										$("#containerLIN").html('<a class="list-group-item editable editable-click" style="display: inline;" href="#" id="inline-linkedin" data-type="text" data-pk="1" data-title="Linkedin"><i class="ti-linkedin m-r-0-5"></i>'+text+'</a>');

										swal({
											title: 'Información!',
											text: 'Cambios realizados correctamente',
											timer: 3000,
											confirmButtonClass: 'btn btn-primary btn-lg',
											buttonsStyling: false
										});

										$('#inline-linkedin').editable({
											type: 'text',
											pk: 1,
											name: 'linkedin',
											title: 'Linkedin',
											mode: 'inline',
											url: 'ajax/empresas.php?op=9&opt=fields&option=lin',
											success: function(response, newValue) {
												
													
												
												//if(response.status == 'error') return response.msg; //msg will be shown in editable form
											}
										});
										break;
								}
								
							}
						});
					}
				});
				
				$('.dropify').dropify();
				$("#savePic").click(function() {
					if($("#file")[0].files.length > 0) {
						$("#savePic").attr("disabled", true);
						$("#savePic").html("Espere...");
						$("#upload").attr("action", "ajax/empresas.php?op=8");
						var options={
							url     : $("#upload").attr("action"),
							success : function(response,status) { 
								var data = JSON.parse(response);
								if(parseInt(data.status) == 2) {
									alert("si");
								}
								if(parseInt(data.status) == 1) {
									window.location.assign("perfil.php");
								}
								else {
									swal({
										title: 'Información!',
										text: 'Ocurrio un error al subir la foto.',
										timer: 2000,
										confirmButtonClass: 'btn btn-primary btn-lg',
										buttonsStyling: false
									});
								}
								$("#savePic").attr("disabled", false);
								$("#savePic").html("Guardar");
							}
						};
						$("#upload").ajaxSubmit(options);
						return false;	
					}
					else {
						swal({
							title: 'Información!',
							text: 'Debe añadir una foto',
							timer: 2000,
							confirmButtonClass: 'btn btn-primary btn-lg',
							buttonsStyling: false
						});
					}
				});
			});
		</script>
	</body>
</html>