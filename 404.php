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
		<title>JOBBERS - Pagina no Encontrada</title>
        <?php require_once('includes/libs-css.php'); ?>
        <link href="https://fonts.googleapis.com/css?family=Patua+One" rel="stylesheet">
		
		<style>
			.pub {
				min-height: 150px;
				margin-bottom: 30px;
				max-height: 490px;
			}
			.pub-f {
				min-height: 110px;
			}
			.pub, .pub-f {
				background-color: #f8f8f8 !important;
				-webkit-transition: all 0.2s ease-in-out;
				transition: all 0.2s ease-in-out;
				cursor: pointer;
			}			
			.pub:hover, .pub-f:hover {
				background-color: #3e70c9 !important;
			}
			.pub:hover *, .pub-f:hover * {
				color: #fff !important;
			}
			.pub .avatar {
				max-height: 140px;
				height: 120px;
				width: 100%;
				max-width: 140px;
				margin: 0 auto;
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
	<body class="large-sidebar fixed-sidebar fixed-header" style="background-color: #fff;">
        <div class="overlay" style="opacity: .4; background-color: #042A3B;"></div>
		<div class="bg" style="background: url(img/bg-grey.jpg) center fixed no-repeat; height: 100vh">
            <div class="container text-center">
                <!-- <div class="col-md-12">
                    <img src="img/logo.png" alt="Logo Jobbers" style="margin-top: 25vh; width: 20%">
                </div> -->
                <div class="col-md-12">
                    <img src="img/404_blue.png" alt="Error 404" style="width: 40%; margin-top: 25vh">
                </div>
                <div class="col-md-12">
                    <h2 style="color: #042A3B; font-family: 'Patua One', cursive;">Oops! La página que estas buscando no existe.</h2>
                </div>
                <div class="col-md-12">
                    <a href="<?= strstr($_SERVER["REQUEST_URI"], "empresa") ? "../?empresas=true" : "./" ?>" class="btn btn-primary" style="font-family: 'Patua One', cursive; border-radius: 5px; border-color: #042A3B; background-color: #042A3B;">Regresar a Home</a>
                </div>
            </div>
        </div>
		<?php //require_once('includes/libs-js.php'); ?>
	</body>
</html>