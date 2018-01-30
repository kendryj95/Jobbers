<?php if (@$_SESSION['ctc']['type'] == 1): ?>
<footer class="container-fluid text-center">
<?php else: ?>
<footer class="container text-center">
<?php endif?>
	<div class="box-block">
		<div class="row">
			<div class="col-sm-8">
				<div class="f-menu">

					<?php if(@$_SESSION["ctc"]["type"] > 2): ?>
						<div class="row">
							<div class="col-xs-4">
								<div class="f-title">Menu</div>
								<ul class="list-unstyled">
									<li><a href="<?php echo (strstr($_SERVER["REQUEST_URI"], "admin") ? "../" : ""); ?>ingresar.php">Jobbers</a></li>
									<li><a href="<?php echo (strstr($_SERVER["REQUEST_URI"], "admin") ? "../empresas/" : ""); ?>acceder.php">Empresas</a></li>
								</ul>
							</div>
							<div class="col-xs-4">
								<div class="f-title">Noticias</div>
								<ul class="list-unstyled">
									<li><a href="<?php echo (strstr($_SERVER["REQUEST_URI"], "admin") ? "../" : ""); ?>noticias.php">Noticias</a></li>
									<li><a href="<?php echo (strstr($_SERVER["REQUEST_URI"], "admin") ? "../" : ""); ?>categorias.php">Categorías</a></li>
								</ul>
							</div>
							<div class="col-xs-4">
								<div class="f-title">Empresa</div>
								<ul class="list-unstyled">
									<li><a href="<?php echo (strstr($_SERVER["REQUEST_URI"], "admin") ? "../" : ""); ?>nosotros.php">Nosotros</a></li>
									<li><a href="<?php echo (strstr($_SERVER["REQUEST_URI"], "admin") ? "../" : ""); ?>contacto.php">Contacto</a></li>
									<li><a href="<?php echo (strstr($_SERVER["REQUEST_URI"], "admin") ? "../" : ""); ?>soporte.php">Soporte Técnico</a></li>
									<li><a href="<?php echo (strstr($_SERVER["REQUEST_URI"], "admin") ? "../" : ""); ?>politicas.php">Políticas de privacidad</a></li>
									<li><a href="<?php echo (strstr($_SERVER["REQUEST_URI"], "admin") ? "../" : ""); ?>terminos.php">Términos y condiciones</a></li>
								</ul>
							</div>
						</div>
					<?php else: ?>
						<div class="row">
							<div class="col-xs-4">
								<div class="f-title">Menu</div>
								<ul class="list-unstyled">
									<li><a href="<?php echo (strstr($_SERVER["REQUEST_URI"], "empresa") ? "../" : ""); ?>ingresar.php">Jobbers</a></li>
									<li><a href="<?php echo (strstr($_SERVER["REQUEST_URI"], "empresa") ? "" : "empresa/"); ?>acceder.php">Empresas</a></li>
								</ul>
							</div>
							<div class="col-xs-4">
								<div class="f-title">Noticias</div>
								<ul class="list-unstyled">
									<li><a href="<?php echo (strstr($_SERVER["REQUEST_URI"], "empresa") ? "../" : ""); ?>noticias.php">Noticias</a></li>
									<li><a href="<?php echo (strstr($_SERVER["REQUEST_URI"], "empresa") ? "../" : ""); ?>categorias.php">Categorías</a></li>
								</ul>
							</div>
							<div class="col-xs-4">
								<div class="f-title">Empresa</div>
								<ul class="list-unstyled">
									<li><a href="<?php echo (strstr($_SERVER["REQUEST_URI"], "empresa") ? "../" : ""); ?>nosotros.php">Nosotros</a></li>
									<li><a href="<?php echo (strstr($_SERVER["REQUEST_URI"], "empresa") ? "../" : ""); ?>contacto.php">Contacto</a></li>
									<li><a href="<?php echo (strstr($_SERVER["REQUEST_URI"], "empresa") ? "../" : ""); ?>soporte.php">Soporte Técnico</a></li>
									<li><a href="<?php echo (strstr($_SERVER["REQUEST_URI"], "empresa") ? "../" : ""); ?>politicas.php">Políticas de privacidad</a></li>
									<li><a href="<?php echo (strstr($_SERVER["REQUEST_URI"], "empresa") ? "../" : ""); ?>terminos.php">Términos y condiciones</a></li>
								</ul>
							</div>
						</div>
					<?php endif ?>
				</div>
			</div>
			<?php
				if(isset($db)) {
					$redes = $db->getRow("SELECT facebook, instagram, twitter, youtube, linkedin FROM plataforma WHERE id=1");
				}
				else {
					require_once(strstr($_SERVER["REQUEST_URI"], "empresa/") || strstr($_SERVER["REQUEST_URI"], "admin/") ? "../" : "".'classes/DatabasePDOInstance.function.php');
					$db = DatabasePDOInstance();
					$redes = $db->getRow("SELECT facebook, instagram, twitter, youtube, linkedin FROM plataforma WHERE id=1");
				}
				$facebook = $redes["facebook"] ? (strstr($redes["facebook"], "http") ? "href='". $redes["facebook"] . "'" : ("href='http://".$redes["facebook"]."'")) : "style='display:none'";
				$instagram = $redes["instagram"] ? (strstr($redes["instagram"], "http") ? "href='". $redes["instagram"] . "'" : ("href='http://".$redes["instagram"]."'")) : "style='display:none'";
				$twitter = $redes["twitter"] ? (strstr($redes["twitter"], "http") ? "href='". $redes["twitter"] . "'" : ("href='http://".$redes["twitter"]."'")) : "style='display:none'";
				$youtube = $redes["youtube"] ? (strstr($redes["youtube"], "http") ? "href='". $redes["youtube"] . "'" : ("href='http://".$redes["youtube"]."'")) : "style='display:none'";
				$linkedin = $redes["linkedin"] ? (strstr($redes["linkedin"], "http") ? "href='". $redes["linkedin"] . "'" : ("href='http://".$redes["linkedin"]."'")) : "style='display:none'";
			?>
			<div class="col-sm-4">
				<div class="m-b-0-25"><a class="f-logo text-black" href="<?php echo (strstr($_SERVER["REQUEST_URI"], "empresa/") || strstr($_SERVER["REQUEST_URI"], "admin/") ? ".././" : "./"); ?>">Jobbers</a></div>
				<a <?php echo $facebook; ?> class="btn bg-facebook btn-sm btn-circle m-r-0-5">
					<i class="fa fa-facebook"></i>
				</a>
				<a <?php echo $twitter; ?> class="btn bg-twitter btn-sm btn-circle m-r-0-5">
					<i class="fa fa-twitter"></i>
				</a>
				<a <?php echo $instagram; ?> class="btn bg-instagram btn-sm btn-circle m-r-0-5">
					<i class="fa fa-instagram"></i>
				</a>
				<a <?php echo $youtube; ?> class="btn bg-youtube btn-sm btn-circle m-r-0-5">
					<i class="fa fa-youtube"></i>
				</a>
				<a <?php echo $linkedin; ?> class="btn bg-linkedin btn-sm btn-circle m-r-0-5">
					<i class="fa fa-linkedin"></i>
				</a>
			</div>
		</div>
	</div>
	<div class="box-block text-center">
		&copy; 2017 JOBBERS, Todos los derechos reservados
	</div>
</footer>