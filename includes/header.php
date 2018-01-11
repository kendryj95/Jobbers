
<script>
	var urlCurrent = '<?php echo (strstr($_SERVER["REQUEST_URI"], "empresa/") ? "" : "empresa/"); ?>';
	var typeUser = '<?php echo isset($_SESSION["ctc"]) ? $_SESSION["ctc"]["type"] : 0; ?>';
</script>
<script type="text/javascript">
	window.fbAsyncInit = function() {
		FB.init({
			appId      : '1785394951770843',
			status	   : true,
			xfbml      : true,
			version    : 'v2.9'
		});
		FB.AppEvents.logPageView();
	};

	(function(d, s, id){
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) {return;}
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/en_US/sdk.js";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));

	function Logout(){
		FB.logout(function(){});
	}
</script>


<style>
	@media only screen and (max-width: 1050px) {
		.menuMovilTrabajador {
			display: block !important;
		}
		.menuPCTrabajador {
			display: none;
		}
		.menuMovilEmpresa {
			display: block !important;
		}
		.menuPCEmpresa {
			display: none;
		}
	}

	@media only screen and (max-width: 600px) {
		.movil{
			margin-top: 15px;
		}
	}
</style>

<div class="site-header" style="border-bottom:1px solid #DFDFDF;">
<nav class="navbar navbar-default" style=" margin-bottom: 0px;">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
	  </button>
	  
      <a style="width: 220px; height: 78px" class="logo" href="<?= strstr($_SERVER["REQUEST_URI"], "empresa") ? "../?empresas=true" : "./" ?>">
		<img style="width: 160px; height: 70px;" src="img/logo_d.png" alt="">
	  </a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	<ul class="nav navbar-nav pull-left">
		<li>
				<a class="nav-link color-link" href="<?php echo strstr($_SERVER["REQUEST_URI"], "empresa") ? "../" : ""; ?>buscador.php?tipo=empleos">
					Búsqueda avanzada
				</a>
			</li>
			<li>
				<div class="header-form m-md-r-1 padding-mobile">
					<form id='busqueda_form'>
						<input type="text" id="search-input" class="form-control b-a" style="box-shadow: none" placeholder="Búsqueda">
						<a href="javascript:void(0)" id="search" class="btn bg-white b-a-0">
							<i class="ti-search"></i>
						</a>
					</form>
				</div>
			</li>
		</ul>
		<ul class="nav navbar-nav pull-right">
			
				<!-- Seccion de empresas -->
				<?php if(isset($_SESSION["ctc"]["id"])): ?>
				<!-- $_SESSION["ctc"]["type"]==1 es empresa -->
				<?php if($_SESSION["ctc"]["type"] == 1): ?>
					<?php
						$color = "";
						switch($_SESSION["ctc"]["plan"]["id_plan"]) {
							case 2:
								$color = "color: #cd7f32;";
								break;
							case 3:
								$color = "color: #8a9597;";
								break;
							case 4:
								$color = "color: #FFD700;";
								break;
						}
					?>

						<li class="menuPCEmpresa">
							<a class="nav-link color-link" href="<?php echo (strstr($_SERVER["REQUEST_URI"], "empresa/") ? "../" : ""); ?>promociones.php">
								Promociones
							</a>
						</li>
						<li class="menuPCEmpresa">
							<?php if($_SESSION['ctc']['plan']['id_plan'] != 1): ?>
							<a class="nav-link color-link" href="<?php echo (strstr($_SERVER["REQUEST_URI"], "empresa/") ? "../" : ""); ?>trabajadores.php">
								Ver jobbers
							</a>
							<?php else: ?>
							<a class="nav-link color-link actualiza_plan" href="javascript:void(0)" style="cursor: no-drop;">
								Ver jobbers
							</a>
							<?php endif; ?>
						</li>
						<li>
							<a class="nav-link color-link" href="<?php echo strstr($_SERVER["REQUEST_URI"], "empresa/") ? "planes" : "empresa/planes"; ?>.php">
								<span>Plan:</span>
								<span class="tag top" style="top: 0;"><i class="fa fa-trophy icon-free" style="<?php echo $color; ?>; font-size: 26px" aria-hidden="true"></i></span>
							</a>
						</li>
						<li>
							<a class="nav-link color-link" href="#" data-toggle="dropdown" aria-expanded="false">
								<div class="avatar box-32">
									<img src="<?php echo (strstr($_SERVER["REQUEST_URI"], "empresa/") ? "" : "empresa/")."img/".$_SESSION["ctc"]["pic"]; ?>" alt="">
								</div>
							</a>
							<!-- Menu Desplegable -->
							<div class="dropdown-menu dropdown-menu-right animated flipInY" style="background-color:#E8EBF0;">
								<ul class="no-padding menu-desplegable">
									<li class="dropdown-item">
										<a class="dropdown-item" href="<?php echo strstr($_SERVER["REQUEST_URI"], "empresa/") ? "./" : "empresa/"; ?>">
											<i class="ti-folder m-r-0-5"></i> Panel
										</a>
									</li>
									<li class="dropdown-item">
										<a class="dropdown-item" href="<?php echo strstr($_SERVER["REQUEST_URI"], "empresa/") ? "perfil" : "empresa/perfil"; ?>.php">
											<i class="ti-user m-r-0-5"></i> Perfil
										</a>
									</li>
									<li class="divider" role="separator"></li>
									<li class="dropdown-item text-center">
										<a class="dropdown-item" href="<?php echo strstr($_SERVER["REQUEST_URI"], "empresa/") ? "salir" : "empresa/salir"; ?>.php"><i class="ti-power-off m-r-0-5"></i> Cerrar sesión</a>
									</li>
																	
									<!--
									<a class="dropdown-item" href="#">
										<i class="ti-settings m-r-0-5"></i> Ajustes
									</a>-->
									
								</ul>	
							</div>
						</li>

						<!-- <li>
							<a class="nav-link color-link site-sidebar-second-toggle" href="#" data-toggle="collapse">
								<i class="ti-arrow-left"></i>
							</a>
						</li> -->
					

			<?php else: ?>
				<!-- SECCION DE USUARIO -->
				<!-- $_SESSION["ctc"]["type"] ==  2 es usuario -->
				<?php if($_SESSION["ctc"]["type"] == 2): ?>

						<li class="menuPCTrabajador">
							<a class="nav-link color-link" href="curriculum.php">
								Modificar Curriculum
							</a>
						</li>
						<li class="menuPCTrabajador">
							<a class="nav-link color-link" href="empleos.php">
								Ver ofertas de empleo
							</a>
						</li>
						
						<li>
							<a class="nav-link color-link" href="#" data-toggle="dropdown" aria-expanded="false">
								<div class="row" style="margin-left: 0;margin-right: 0;">
									<div class="col-md-9 col-xs-9 no-padding-left name-margin"><?php echo $_SESSION["ctc"]["name"]." ".$_SESSION["ctc"]["lastName"]; ?></div>
									<div style="" class="col-md-3 col-xs-3">
										<div class="avatar box-32 avatar-float">
											<img src="<?php echo strstr($_SERVER["REQUEST_URI"], "empresa") ? '../': ''; ?>img/<?php echo $_SESSION["ctc"]["pic"]; ?>" alt="" style="height: 30px;">
										</div>
									</div>
								</div>
							</a>

							<!-- Menu Desplegable -->
							<div class="dropdown-menu dropdown-menu-right animated flipInY" style="background-color: #E8EBF0">
								<ul class="no-padding menu-desplegable">
									<li class="dropdown-item">
										<a href="trabajador-detalle.php?t=<?php echo $_SESSION["ctc"]["name"]."-".$_SESSION["ctc"]["lastName"]."-".$_SESSION["ctc"]["id"]; ?>">
											<i class="ti-user m-r-0-5"></i> Perfil
										</a>
									</li>

									<li class="dropdown-item">
										<a href="cuenta.php">
											<i class="ti-pencil-alt m-r-0-5"></i> Mi cuenta
										</a>
									</li>

									<li class="dropdown-item">
										<a href="promociones.php">
											<i class="ti-medall m-r-0-5"></i> Promociones
										</a>
									</li>

									<li class="dropdown-item">
										<a href="postulaciones.php">
											<i class="ti-check-box m-r-0-5"></i> Ver postulaciones realizadas
										</a>
									</li>

									<li class="dropdown-item">
										<a href="publicaciones.php">
											<i class="ti-clipboard  m-r-0-5"></i> Mis servicios free lance
										</a>
									</li>
									
									<li class="divider" role="separator"></li>

									<li class="dropdown-item text-center">
										<a class="1logout" href="salir.php" onclick="Logout();"><i class="ti-power-off m-r-0-5"></i> Cerrar sesión</a>
									</li>
								</ul>
							</div>
						</li>

						<!-- <li>
							<a class="nav-link site-sidebar-second-toggle color-link" href="#" data-toggle="collapse">
								<i class="ti-arrow-left" style="color: #b7b2b2;"></i>
							</a>
						</li> -->
				<?php else: ?>

						<li>
							<a class="nav-link color-link" href="#" data-toggle="dropdown" aria-expanded="false">
								<div class="row" style="margin-left: 0;margin-right: 0;">
									<div class="col-md-9 col-xs-9"><?php echo $_SESSION["ctc"]["name"]." ".$_SESSION["ctc"]["lastName"]; ?></div>
									<div style="" class="col-md-3 col-xs-3">
										<div class="avatar box-32">
											<img src="<?php echo strstr($_SERVER["REQUEST_URI"], "admin") ? '../': ''; ?>img/<?php echo $_SESSION["ctc"]["pic"]; ?>" alt="" style="height: 30px;">
										</div>
									</div>
								</div>
							</a>
							<div class="dropdown-menu dropdown-menu-right animated flipInY">
								<a class="dropdown-item" href="<?php echo strstr($_SERVER["REQUEST_URI"], "admin") ? '': 'admin/'; ?>mis-noticias.php">
									<i class="ti-notepad m-r-0-5"></i> Mis noticias
								</a>
								<?php if($_SESSION["ctc"]["rol"] == "A"): ?>
									<a class="dropdown-item" href="<?php echo strstr($_SERVER["REQUEST_URI"], "admin") ? '': 'admin/'; ?>empresas.php">
										<i class="ti-briefcase m-r-0-5"></i> Empresas
									</a>
									<a class="dropdown-item" href="<?php echo strstr($_SERVER["REQUEST_URI"], "admin") ? '': 'admin/'; ?>publicidad.php">
										<i class="ti-thumb-up m-r-0-5"></i> Publicidad
									</a>
									<a class="dropdown-item" href="<?php echo strstr($_SERVER["REQUEST_URI"], "admin") ? '': 'admin/'; ?>usuarios.php">
										<i class="ti-user m-r-0-5"></i> Usuarios
									</a>
									<a class="dropdown-item" href="<?php echo strstr($_SERVER["REQUEST_URI"], "admin") ? '': 'admin/'; ?>trabajadores.php">
										<i class="ti-id-badge m-r-0-5"></i> Trabajadores
									</a>
									<a class="dropdown-item" href="<?php echo strstr($_SERVER["REQUEST_URI"], "admin") ? '': 'admin/'; ?>configuraciones.php">
										<i class="ti-settings m-r-0-5"></i> Configuraciones
									</a>
								<?php endif ?>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item 1logout" href="<?php echo strstr($_SERVER["REQUEST_URI"], "admin") ? '../': ''; ?>salir.php"><i class="ti-power-off m-r-0-5"></i> Cerrar sesión</a>
							</div>
						</li>

				<?php endif ?>
			<?php endif ?>
		<?php else: ?>
		<!-- Seccion de Busqueda -->
		<li>
			<?php if(isset($_SESSION["ctc"])): ?>
					<!-- $_SESSION["ctc"]["type"] != 3 no es administrador -->
					<?php if($_SESSION["ctc"]["type"] != 3): ?>
					<!-- $_SESSION["ctc"]["type"] =2 es usuario -->
						<?php if($_SESSION["ctc"]["type"] == 2): ?>
							<div id="collapse-1">
							<!-- FIXME: Dejar un solo input que funcione en todas las pantallas -->

								<!-- <div class="header-form pull-md-left m-md-r-1">
									<form id='busqueda_form'>
										<input type="text" id="search-input" class="form-control b-a" placeholder="Búsqueda">
										<a href="javascript:void(0)" id="search" class="btn bg-white b-a-0">
											<i class="ti-search"></i>
										</a>
									</form>
								</div> -->
								<ul class="nav navbar-nav">
									<li class="nav-item dropdown menuMovilTrabajador" style="display:none;">
										<a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
											Menu
										</a>
										<div class="dropdown-menu animated flipInY">
											<a class="dropdown-item" href="promociones.php">
												Promociones
											</a>
											<a class="dropdown-item" href="empleos.php">Ver ofertas de empleo</a>
										</div>
									</li>
								</ul>

							</div>
						<?php elseif($_SESSION["ctc"]["type"] == 1): ?>
							<div id="collapse-1">
							<!-- FIXME: Dejar un solo input que funcione en todas las pantallas -->

								<!-- <div class="header-form pull-md-left m-md-r-1">
									<form id='busqueda_form'>
										<input type="text" id="search-input-w" class="form-control b-a" placeholder="Búsqueda">
										<a href="javascript:void(0)" id="search" class="btn bg-white b-a-0">
											<i class="ti-search"></i>
										</a>
									</form>
								</div> -->
								<?php if(isset($_SESSION["ctc"]["plan"])): ?>
									<?php if($_SESSION["ctc"]["servicio"]["filtros_personalizados"] == 1): ?>
										<ul class="nav navbar-nav">
											<li class="nav-item dropdown menuMovilEmpresa" style="display:none;">
												<a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
													Menu
												</a>
												<div class="dropdown-menu animated flipInY">
													<a class="dropdown-item" href="promociones.php">
														Promociones
													</a>
													<a class="dropdown-item" href="<?php echo (strstr($_SERVER["REQUEST_URI"], "empresa") ? "../" : ""); ?>trabajadores.php">Ver jobbers</a>
												</div>
											</li>
										</ul>
									<?php else: ?>
										
									<?php endif ?>
								<?php endif ?>
							</div>
						<?php endif ?>
					<?php endif ?>
				<?php else: ?>
					<div id="collapse-1">
					<!-- FIXME: Dejar un solo input que funcione en todas las pantallas -->

							<!-- <div class="header-form pull-md-left m-md-r-1">
								<form id='busqueda_form'>
									<input type="text" id="search-input" class="form-control b-a" placeholder="Búsqueda">
									<a href="javascript:void(0)" id="search" class="btn bg-white b-a-0">
										<i class="ti-search"></i>
									</a>
								</form>
							</div> -->
					</div>
			
		</li>

		</ul>

      <ul class="nav navbar-nav pull-right">

		<li>
			<a class="nav-link color-link" href="<?php echo strstr($_SERVER["REQUEST_URI"], "empresa/") ? '../': ''; ?>empleos.php">
				Bolsa de Empleos
			</a>
		</li>
		<?php $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>
        <li>
			<a class="nav-link color-link" href="<?php echo strstr($_SERVER["REQUEST_URI"], "empresa/") ? '../': ''; ?>ingresar.php?returnUri=<?= urlencode($actual_link) ?>">
				Ingresar
			</a>
		</li>

		<li>
			<a class="nav-link color-link" href="<?php echo strstr($_SERVER["REQUEST_URI"], "empresa/") ? '../': ''; ?>registro.php">
				Registrarse
			</a>
		</li>

		<li>
			<a class="nav-link color-link" href="<?php echo strstr($_SERVER["REQUEST_URI"], "empresa/") ? '': 'empresa/'; ?>acceder.php">
				Acceso Empresas
			</a>
		</li>
		<?php endif ?>
		<?php endif ?>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
</div>