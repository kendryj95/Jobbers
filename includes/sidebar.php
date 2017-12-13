<?php
	$scriptActual = basename($_SERVER['PHP_SELF'], '.php');
?>
<?php if(strstr($_SERVER["REQUEST_URI"], "index") || (strstr($_SERVER["PHP_SELF"], "index") && !strstr($_SERVER["REQUEST_URI"], "empresa"))): ?>
	<!-- <a style="width: 220px; height: 78px;position: fixed;z-index: 99;" class="logo" href="./">
		<div style="background-color: white;height: 71px;">
			<img style="width: 220px; height: 110px; padding: 22px;padding-top: 2px;" src="img/logo_d.png" alt="">
		</div>
	</a> -->
<?php else: ?>
	<div class="site-sidebar-overlay"></div>
	<div class="site-sidebar">
		<!-- <a class="logo" href="<?php echo ( strstr($_SERVER["REQUEST_URI"], "admin/") || strstr($_SERVER["REQUEST_URI"], "empresa/") ) ? ".././" : "./"; ?>">
			<img src="<?php echo ( strstr($_SERVER["REQUEST_URI"], "admin/") || strstr($_SERVER["REQUEST_URI"], "empresa/") ) ? ".././" : "./"; ?>img/logo_d.png" alt="" style="width: 100%;">
		</a> -->

			<div class="custom-scroll custom-scroll-dark">
				<ul class="sidebar-menu">
					<?php if(isset($_SESSION["ctc"])): ?>
						<?php if($_SESSION["ctc"]["type"] == 1): ?>
							<li class="menu-title m-t-0-5">Principal</li>
							<li class="<?php echo strstr($_SERVER["REQUEST_URI"], "empresas=true") ? "active" : ""; ?>">
								<a href="<?php echo strstr($_SERVER["REQUEST_URI"], "empresa/") ? ".././?empresas=true" : "./?empresas=true"; ?>" class="waves-effect  waves-light">
									<span class="s-icon"><i class="ti-folder"></i></span>
									<span class="s-text">Home</span>
								</a>
							</li>
							<li class="<?php echo $scriptActual == 'index' ? "active" : ""; ?>">
								<a href="<?php echo strstr($_SERVER["REQUEST_URI"], "empresa/") ? "./" : "empresa/./"; ?>" class="waves-effect  waves-light">
									<span class="s-icon"><i class="ti-folder"></i></span>
									<span class="s-text">Panel</span>
								</a>
							</li>
							<li class="<?php echo $scriptActual == 'publicaciones' ? 'active' : ''; ?>">
								<a href="<?php echo strstr($_SERVER["REQUEST_URI"], "empresa/") ? "" : "empresa/"; ?>publicaciones.php" class="waves-effect  waves-light">
									<span class="s-icon"><i class="ti-folder"></i></span>
									<span class="s-text">Mis publicaciones</span>
								</a>
							</li>
							<?php if($_SESSION['ctc']['plan']['id_plan'] != 1): ?>
							<li class="<?php echo $scriptActual == 'trabajadores' ? 'active' : ''; ?>">
								<a href="<?php echo strstr($_SERVER["REQUEST_URI"], "empresa/") ? "../" : ""; ?>trabajadores.php" class="waves-effect  waves-light">
									<span class="s-icon"><i class="ti-folder"></i></span>
									<span class="s-text">Ver jobbers</span>
								</a>
							</li>
							<?php else: ?>
								<li>
									<a href="javascript:void(0)" class="actualiza_plan" title="Actualiza tu plan para disfrutar de este servicio" style="cursor: no-drop;">
										<span class="s-icon" style="color: gray;"><i class="ti-folder"></i></span>
										<span class="s-text" style="color: gray;">Ver jobbers</span>
									</a>
								</li>
							<?php endif; ?>
							<li class="<?php echo $scriptActual == 'serviciosfree' ? 'active' : ''; ?>">
								<a href="<?php echo strstr($_SERVER["REQUEST_URI"], "empresa/") ? "../" : ""; ?>serviciosfree.php" class="waves-effect  waves-light">
									<span class="s-icon"><i class="ti-folder"></i></span>
									<span class="s-text">Ver servicios freelance</span>
								</a>
							</li>
							<!--
							<li class="< ?php echo $scriptActual == 'contrataciones' ? 'active' : ''; ?>">
								<a href="< ?php echo strstr($_SERVER["REQUEST_URI"], "empresa/") ? "" : "empresa/"; ?>contrataciones.php" class="waves-effect  waves-light">
									<span class="s-icon"><i class="ti-folder"></i></span>
									<span class="s-text">Jobbers seleccionados</span>
								</a>
							</li>
							<li class="< ?php echo $scriptActual == 'mensajes' ? 'active' : ''; ?>">
								<a href="< ?php echo strstr($_SERVER["REQUEST_URI"], "empresa/") ? "" : "empresa/"; ?>mensajes.php" class="waves-effect  waves-light">
									<span class="s-icon"><i class="ti-folder"></i></span>
									<span class="s-text">Mensajes</span>
								</a>
							</li>-->
						<?php endif ?>
					<?php endif ?>
				</ul>
			</div>
	</div>
<?php endif ?>
