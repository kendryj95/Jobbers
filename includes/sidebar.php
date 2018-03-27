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
	<div class="col-md-3" style="margin-top: 20px;">
		<div class="list-group">
		<?php if ($_SESSION['ctc']['type'] != 3):?>

			<div class="list-group-item active text-center item-panel" style="background-color: #333695">Panel de Empresa</div>
			<div class="list-group-item text-center">
				<img src="<?php echo (strstr($_SERVER["REQUEST_URI"], "empresa/") ? "" : "empresa/")."img/".$_SESSION["ctc"]["pic"]; ?>" alt="Logo Empresa" style="width: 60%; height: auto">
			</div>
			<a href="<?php echo (strstr($_SERVER["REQUEST_URI"], "empresa/") ? "publicaciones.php" : "empresa/publicaciones.php") ?>" class="list-group-item item-panel sidebar-index-hover"><i class="fa fa-check-square"></i>&nbsp Publicaciones</a>
			<a href="<?php echo (strstr($_SERVER["REQUEST_URI"], "empresa/") ? "perfil.php" : "empresa/perfil.php") ?>" class="list-group-item item-panel sidebar-index-hover"><i class="fa fa-user"></i>&nbsp Mi perfil</a>
			<?php if($_SESSION['ctc']['plan']['id_plan'] != 1): ?>
				<a href="<?php echo (strstr($_SERVER["REQUEST_URI"], "empresa/") ? "../trabajadores.php" : "trabajadores.php") ?>" class="list-group-item item-panel sidebar-index-hover"><i class="fa fa-id-badge"></i>&nbsp Ver Jobbers</a>
				<a href="../index.php" class="list-group-item item-panel sidebar-index-hover"><i class="fa fa-file"></i>&nbsp Página principal</a>
			<?php else: ?>
				<a href="javascript:void(0)" class="list-group-item item-panel sidebar-index-hover actualiza_plan" style="cursor: no-drop;"><i class="fa fa-id-badge"></i>&nbsp Ver Jobbers</a>
			<?php endif; ?>
		<?php else: ?>

			<div class="list-group-item active text-center item-panel" style="background-color: #3e70c9">Panel de Administrador</div>
			<a href="mis-noticias.php" class="list-group-item item-panel sidebar-index-hover"><i class="fa fa-newspaper-o"></i>&nbsp Noticias</a>
			<?php if ($_SESSION["ctc"]["rol"] == "A"): ?>
			<a href="configuraciones.php" class="list-group-item item-panel sidebar-index-hover"><i class="fa fa-cog"></i>&nbsp Configuraciones</a>
			<a href="publicidad.php" class="list-group-item item-panel sidebar-index-hover"><i class="fa fa-certificate"></i>&nbsp Publicidad</a>
			<a href="empresas.php" class="list-group-item item-panel sidebar-index-hover"><i class="fa fa-industry"></i>&nbsp Empresas</a>
			<a href="trabajadores.php" class="list-group-item item-panel sidebar-index-hover"><i class="fa fa-briefcase"></i>&nbsp Trabajadores</a>
			<a href="trabajadores_search.php" class="list-group-item item-panel sidebar-index-hover"><i class="fa fa-search"></i>&nbsp Trabajadores por Busqueda</a>
			<a href="usuarios.php" class="list-group-item item-panel sidebar-index-hover"><i class="fa fa-users"></i>&nbsp Usuarios</a>
			<?php endif; ?>

		<?php endif ?>

		</div>
	</div>
<?php endif ?>
