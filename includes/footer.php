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
									<a class="footer-hover" href="<?php echo (strstr($_SERVER["REQUEST_URI"], "empresa") ? "../" : ""); ?>ingresar.php"><li class="footer-hover">Jobbers</li></a>
									<a class="footer-hover" href="<?php echo (strstr($_SERVER["REQUEST_URI"], "empresa") ? "" : "empresa/"); ?>acceder.php"><li class="footer-hover">Empresas</li></a>
								</ul>
							</div>
							<div class="col-xs-4">
								<div class="f-title">Noticias</div>
								<ul class="list-unstyled">
									<a class="footer-hover" href="<?php echo (strstr($_SERVER["REQUEST_URI"], "empresa") ? "../" : ""); ?>noticias.php"><li class="footer-hover">Noticias</li></a>
									<a class="footer-hover" href="<?php echo (strstr($_SERVER["REQUEST_URI"], "empresa") ? "../" : ""); ?>categorias.php"><li class="footer-hover">Categorías</li></a>
								</ul>
							</div>
							<div class="col-xs-4">
								<div class="f-title">Empresa</div>
								<ul class="list-unstyled">
									<a href="<?php echo (strstr($_SERVER["REQUEST_URI"], "empresa") ? "../" : ""); ?>nosotros.php"><li class="footer-hover">Nosotros</li></a>
									<a href="<?php echo (strstr($_SERVER["REQUEST_URI"], "empresa") ? "../" : ""); ?>contacto.php"><li class="footer-hover">Contacto</li></a>
									<a href="<?php echo (strstr($_SERVER["REQUEST_URI"], "empresa") ? "../" : ""); ?>soporte.php"><li class="footer-hover">Soporte Técnico</li></a>
									<a href="<?php echo (strstr($_SERVER["REQUEST_URI"], "empresa") ? "../" : ""); ?>politicas.php"><li class="footer-hover">Políticas de privacidad</li></a>
									<a href="<?php echo (strstr($_SERVER["REQUEST_URI"], "empresa") ? "../" : ""); ?>terminos.php"><li class="footer-hover">Términos y condiciones</li></a>
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
				<a <?php echo $facebook; ?>>
					<i class="fa fa-facebook fa-stack-1x social-fb"></i>
				</a>
				<a <?php echo $twitter; ?>>
					<i class="fa fa-twitter fa-stack-1x social-tw"></i>
				</a>
				<a <?php echo $instagram; ?>>
					<i class="fa fa-instagram fa-stack-1x social-ig"></i>
				</a>
				<a <?php echo $youtube; ?>>
					<i class="fa fa-youtube fa-stack-1x social-yt"></i>
				</a>
				<a <?php echo $linkedin; ?>>
					<i class="fa fa-linkedin fa-stack-1x social-in"></i>
				</a>
			</div>
		</div>
	</div>
	<div class="box-block text-center">
		&copy; <?= date('Y') ?> JOBBERS, Todos los derechos reservados
	</div>
</footer>