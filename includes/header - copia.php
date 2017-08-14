<div class="site-header">
	<nav class="navbar navbar-dark">
		<ul class="nav navbar-nav pull-xs-right">
			<?php if(isset($_SESSION["ctc"]["id"])): ?>
				<?php if($_SESSION["ctc"]["type"] == 1): 
					$color = "";
					switch($_SESSION["ctc"]["plan"]["id_plan"]) {
						case 2:
							$color = "background-color: #cd7f32;";
							break;
						case 3:
							$color = "background-color: #8a9597;";
							break;
						case 4:
							$color = "background-color: #FFD700;";
							break;
					}
				?>
					<li class="nav-item dropdown" style="margin-top: 3px;">
						<a class="nav-link btn btn-primary w-min-sm m-b-0-25 waves-effect waves-light" href="<?php echo (strstr($_SERVER["REQUEST_URI"], "empresa") ? "../" : ""); ?>trabajadores.php" style="margin-top: -3px;">
							Ver jobbers
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="<?php echo strstr($_SERVER["REQUEST_URI"], "empresa") ? "planes" : "empresa/planes"; ?>.php">
							<span>Plan:</span>
							<span class="tag tag-success top" style="top: 0; <?php echo $color; ?>"><?php echo $_SESSION["ctc"]["plan"]["nombre"]; ?></span>
						</a>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link" href="#" data-toggle="dropdown" aria-expanded="false">
							<div class="avatar box-32">
								<img src="<?php echo (strstr($_SERVER["REQUEST_URI"], "empresa") ? "" : "empresa/")."img/".$_SESSION["ctc"]["pic"]; ?>" alt="">
							</div>
						</a>
						<div class="dropdown-menu dropdown-menu-right animated flipInY">
							<a class="dropdown-item" href="<?php echo strstr($_SERVER["REQUEST_URI"], "empresa") ? "./" : "empresa/"; ?>">
								<i class="ti-user m-r-0-5"></i> Panel
							</a>
							<a class="dropdown-item" href="<?php echo strstr($_SERVER["REQUEST_URI"], "empresa") ? "perfil" : "empresa/perfil"; ?>.php">
								<i class="ti-user m-r-0-5"></i> Perfil
							</a>
							<a class="dropdown-item" href="#">
								<i class="ti-settings m-r-0-5"></i> Ajustes
							</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="<?php echo strstr($_SERVER["REQUEST_URI"], "empresa") ? "salir" : "empresa/salir"; ?>.php"><i class="ti-power-off m-r-0-5"></i> Cerrar sesión</a>
						</div>
					</li>
				<?php else: ?>
					<li class="nav-item dropdown" style="margin-top: 3px;">
						<a class="nav-link btn btn-primary w-min-sm m-b-0-25 waves-effect waves-light" href="empleos.php">
							Ver ofertas de empleos
						</a>
					</li>
					<!--<li class="nav-item dropdown">
						<a class="nav-link" href="#" data-toggle="dropdown" aria-expanded="false">
							<i class="ti-bell"></i>
							<span class="tag tag-danger top">12</span>
						</a>
						<div class="dropdown-messages dropdown-tasks dropdown-menu dropdown-menu-right animated slideInUp">
							<div class="m-item">
								<div class="mi-icon bg-info"><i class="ti-comment"></i></div>
								<div class="mi-text"><a class="text-black" href="#">John Doe</a> <span class="text-muted">commented post</span> <a class="text-black" href="#">Lorem ipsum dolor</a></div>
								<div class="mi-time">5 min ago</div>
							</div>
							<a class="t-item text-black text-xs-center" href="#">
								<strong>View all notifications</strong>
							</a>
						</div>
					</li>-->
					<li class="nav-item dropdown">
						<a class="nav-link" href="#" data-toggle="dropdown" aria-expanded="false" style="margin-top: 3px;">
							<div class="row" style="margin-left: 0;margin-right: 0;">
								<div class="col-md-9 col-xs-9"><?php echo $_SESSION["ctc"]["name"]." ".$_SESSION["ctc"]["lastName"]; ?></div>
								<div style="" class="col-md-3 col-xs-3">
									<div class="avatar box-32">
										<img src="<?php echo strstr($_SERVER["REQUEST_URI"], "empresa") ? '../': ''; ?>img/<?php echo $_SESSION["ctc"]["pic"]; ?>" alt="" style="height: 30px;">
									</div>
								</div>
							</div>
						</a>
						<div class="dropdown-menu dropdown-menu-right animated slideInUp">
							<a class="dropdown-item" href="trabajador-detalle.php?t=<?php echo $_SESSION["ctc"]["name"]."-".$_SESSION["ctc"]["lastName"]."-".$_SESSION["ctc"]["id"]; ?>">
								<i class="ti-user m-r-0-5"></i> Perfil
							</a>
							<a class="dropdown-item" href="cuenta.php">
								<i class="ti-pencil-alt m-r-0-5"></i> Mi cuenta
							</a>
							<a class="dropdown-item" href="curriculum.php">
								<i class="ti-book m-r-0-5"></i> Modificar curriculo
							</a>
							<a class="dropdown-item" href="postulaciones.php">
								<i class="ti-check-box m-r-0-5"></i> Ver postulaciones realizadas
							</a>
							<a class="dropdown-item" href="publicaciones.php">
								<i class="ti-clipboard  m-r-0-5"></i> Mis publicaciones
							</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item 1logout" href="salir.php"><i class="ti-power-off m-r-0-5"></i> Cerrar sesión</a>
						</div>
					</li>
				<?php endif ?>
				<li class="nav-item hidden-md-up">
					<a class="nav-link" href="#" data-toggle="collapse" data-target="#collapse-1">
						<i class="ti-more"></i>
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link site-sidebar-second-toggle" href="#" data-toggle="collapse">
						<i class="ti-arrow-left"></i>
					</a>
				</li>
			<?php else: ?>
				<li class="nav-item" style="margin-top: 3px;">
					<a class="nav-link btn btn-primary w-min-sm m-b-0-25 waves-effect waves-light" href="empleos.php">
						Ver ofertas de empleos
					</a>
				</li>
				<li class="nav-item dropdown" style="top: 3px;">
					<a class="nav-link btn btn-primary w-min-sm m-b-0-25 waves-effect waves-light" href="ingresar.php">
						Ingresar
					</a>
				</li>
				<li class="nav-item dropdown" style="top: 3px;">
					<a class="nav-link btn btn-primary w-min-sm m-b-0-25 waves-effect waves-light" href="registro.php">
						Registrarse
					</a>
				</li>
				<li class="nav-item dropdown" style="top: 3px;">
					<a class="nav-link btn btn-primary w-min-sm m-b-0-25 waves-effect waves-light" href="empresa/acceder.php">
						Acceso a empresas
					</a>
				</li>
			<?php endif ?>
			
		</ul>
		
		<?php if(isset($_SESSION["ctc"])): ?>
			<?php if($_SESSION["ctc"]["type"] == 2): ?>
				<div class="navbar-toggleable-sm collapse" id="collapse-1">
					<div class="header-form pull-md-left m-md-r-1">
						<form>
							<input type="text" id="search-input" class="form-control b-a" placeholder="Búsqueda">
							<a href="javascript:void(0)" id="search" class="btn bg-white b-a-0">
								<i class="ti-search"></i>
							</a>
						</form>
					</div>
					<?php if(isset($_SESSION["ctc"]["plan"])): ?>
						<?php if($_SESSION["ctc"]["servicio"]["filtros_personalizados"] == 1): ?>
						<ul class="nav navbar-nav">
							<li class="nav-item dropdown">
								<a class="nav-link" href="<?php echo strstr($_SERVER["REQUEST_URI"], "empresa") ? "../" : ""; ?>buscador.php">
									Búsqueda avanzada
								</a>
							</li>
						</ul>
						<?php endif ?>
					<?php endif ?>
				</div>
			<?php else: ?>
				<div class="navbar-toggleable-sm collapse" id="collapse-1">
					<div class="header-form pull-md-left m-md-r-1">
						<form>
							<input type="text" id="search-input" class="form-control b-a" placeholder="Búsqueda">
							<a href="javascript:void(0)" id="search" class="btn bg-white b-a-0">
								<i class="ti-search"></i>
							</a>
						</form>
					</div>
					<ul class="nav navbar-nav">
						<li class="nav-item dropdown">
							<a class="nav-link" href="<?php echo strstr($_SERVER["REQUEST_URI"], "empresa") ? "../" : ""; ?>buscador.php?tipo=trabajadores">
								Búsqueda avanzada
							</a>
						</li>
					</ul>
				</div>
			<?php endif ?>
		<?php else: ?>
			<div class="navbar-toggleable-sm collapse" id="collapse-1">
					<div class="header-form pull-md-left m-md-r-1">
						<form>
							<input type="text" id="search-input" class="form-control b-a" placeholder="Búsqueda">
							<a href="javascript:void(0)" id="search" class="btn bg-white b-a-0">
								<i class="ti-search"></i>
							</a>
						</form>
					</div>
					<ul class="nav navbar-nav">
						<li class="nav-item dropdown">
							<a class="nav-link" href="<?php echo strstr($_SERVER["REQUEST_URI"], "empresa") ? "../" : ""; ?>buscador.php?tipo=empleos">
								Búsqueda avanzada
							</a>
						</li>
					</ul>
				</div>
		<?php endif ?>	
	</nav>
</div>