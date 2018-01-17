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
	<div class="col-md-3" style="margin-top: 12px;">
		<div class="list-group">
			<div class="list-group-item active text-center item-panel" style="background-color: #3e70c9">Panel de Empresa</div>
			<div class="list-group-item text-center">
				<img src="<?php echo (strstr($_SERVER["REQUEST_URI"], "empresa/") ? "" : "empresa/")."img/".$_SESSION["ctc"]["pic"]; ?>" style="max-width: 80%; height: auto" alt="Logo Empresa">
			</div>
			<a href="publicaciones.php" class="list-group-item item-panel"><i class="fa fa-check-square"></i>&nbsp Publicaciones</a>
			<a href="perfil.php" class="list-group-item item-panel"><i class="fa fa-user"></i>&nbsp Mi perfil</a>
			<a href="../trabajadores.php" class="list-group-item item-panel"><i class="fa fa-id-badge"></i>&nbsp Jobbers</a>
			<a href="#" class="list-group-item item-panel"><i class="fa fa-cogs"></i>&nbsp Servicios Freelance</a>
		</div>
	</div>
<?php endif ?>
