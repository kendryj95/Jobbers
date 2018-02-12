<?php
	session_start();
	require_once 'classes/DatabasePDOInstance.function.php';
	require_once 'slug.function.php';

	function formatDate($dateMayor, $dateMenor){
		$menor = new DateTime($dateMenor);
		$mayor = new DateTime(date($dateMayor));
		$intervalo = $mayor->diff($menor);

		if ($intervalo->format("%m") != 0) {
			$m = $intervalo->format("%m") == 1 ? "mes" : "meses";
			return $intervalo->format("Hace %m $m");
		} elseif ($intervalo->format("%a") != 0){
			$d = $intervalo->format("%a") == 1 ? "día" : "días";
			return $intervalo->format("Hace %a $d");
		} elseif ($intervalo->format("%h") != 0){
			$h = $intervalo->format("%h") == 1 ? "hora" : "horas";
			return $intervalo->format("Hace %h $h");
		} elseif ($intervalo->format("%i") != 0){
			return $intervalo->format("Hace %i min");
		} else {
			return $intervalo->format("Hace %s seg");
		}
	}

	$db = DatabasePDOInstance();

	$areas = $db->getAll("
		SELECT
		id,
		nombre,
		amigable
		FROM
		areas
		ORDER BY
		nombre
	");

 
	foreach ($areas as $i => $area) {
		$areas[$i]["cantidad"] = $db->getOne("
			SELECT
			COUNT(*)
			FROM
			publicaciones_sectores AS psec
			INNER JOIN areas_sectores AS asec ON psec.id_sector = asec.id
			WHERE
			asec.id_area = $area[id]
			");
	}

/**
 *    filtro de disponibilidad para empleos
 */

	$disps = $db->getAll("
		SELECT
		id,
		nombre
		FROM
		disponibilidad
	");

	foreach ($disps as $key => $disp) {
		$disps[$key]["cantidad"] = $db->getOne("
			SELECT
			COUNT(*)
			FROM
			publicaciones AS p
			WHERE
			p.disponibilidad = $disp[id] AND p.estatus=1
		");
	}

	 
	$momentos = array(
		array(
			"nombre"   => "Últimas 24 horas",
			"amigable" => "ultimas-24-horas",
			"cantidad" => 0,
			"diff_s"   => 86400,
			),
		array(
			"nombre"   => "Durante los últimos 3 días",
			"amigable" => "durante-los-ultimos-3-dias",
			"cantidad" => 0,
			"diff_s"   => 259200,
			),
		array(
			"nombre"   => "Durante la última semana",
			"amigable" => "durante-la-ultima-semana",
			"cantidad" => 0,
			"diff_s"   => 604800,
			),
		array(
			"nombre"   => "Durante las ultimas 2 semanas",
			"amigable" => "durante-las-ultimas-2-semanas",
			"cantidad" => 0,
			"diff_s"   => 1209600,
			),
		array(
			"nombre"   => "Hace un mes o menos",
			"amigable" => "hace-un-mes-o-menos",
			"cantidad" => 0,
			"diff_s"   => 2592000,
			),
		);

	foreach ($momentos as $i => $momento) {
		$momentos[$i]["cantidad"] = $db->getOne("
			SELECT
			COUNT(*)
			FROM (
			SELECT  TIMESTAMPDIFF(SECOND,fecha_creacion,NOW()) AS s
			FROM publicaciones AS p WHERE p.estatus=1 ) AS r 
			WHERE
			r.s <= $momento[diff_s]
		");
	}
//}

	$publicaciones_especiales = $db->getAll("
		SELECT empresas_publicaciones_especiales.*, CONCAT(imagenes.directorio,'/', imagenes.nombre,'.', imagenes.extension) AS imagen, empresas.nombre AS nombre_empresa FROM empresas_publicaciones_especiales INNER JOIN empresas ON empresas.id=empresas_publicaciones_especiales.id_empresa INNER JOIN empresas_planes ON empresas_planes.id_empresa=empresas.id LEFT JOIN imagenes ON imagenes.id=empresas_publicaciones_especiales.id_imagen WHERE empresas_planes.logo_home=3 ORDER BY RAND()
		");

	$publicidadPrincipal = $db->getAll("SELECT publicidad.*, CONCAT(imagenes.directorio,'/', imagenes.nombre,'.', imagenes.extension) AS imagen FROM publicidad LEFT JOIN imagenes ON imagenes.id=publicidad.id_imagen ORDER BY RAND() LIMIT 4");
	?>


	<?php include('includes/filtros_home.php');?>

	<!DOCTYPE html>
	<html lang="es">
	<head>
		<!-- Meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<meta name="description" content="">
		<meta name="author" content="">

		<!-- Title -->
		<title>JOBBERS - BUSQUEDA DE TRABAJO INTELIGENTE</title>
		<?php require_once 'includes/libs-css.php';?>
		<link rel="stylesheet" href="vendor/ionicons/css/ionicons.min.css">
		<style>
			.btn-outline-white
			.btn-outline-white, .btn-outline-white a:hover {
				color: black !important;
			}

			.pub {
				min-height: 150px;
				margin-bottom: 30px;
				height: 225px;
			}
			.pub-f {
				min-height: 110px;
			}
			.pub, .pub-f {
				/* background-color: #f8f8f8 !important; */
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

			.tra {
				min-height: 150px;
				margin-bottom: 30px;
			}
			.tra-f {
				min-height: 110px;
			}
			.tra, .tra-f {
				background-color: #f8f8f8 !important;
				-webkit-transition: all 0.2s ease-in-out;
				transition: all 0.2s ease-in-out;
				cursor: pointer;
			}
			.tra:hover, .tra-f:hover {
				background-color: #3e70c9 !important;
			}
			.tra:hover *, .tra-f:hover * {
				color: #fff !important;
			}

			@import url('https://fonts.googleapis.com/css?family=Fira+Sans+Extra+Condensed:400,700');
			@import url(http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css);
			.snip1583 {
				font-family: 'Fira Sans Extra Condensed', Arial, sans-serif;
				position: relative;
				display: inline-block;
				overflow: hidden;
				margin: 8px;
				width: 100%;
				font-size: 16px;
				background-color: #fff;
				color: #111;
				line-height: 1.2em;
				text-align: left;
				padding: 0px !important;
			}

			.snip1583 *,
			.snip1583 *:before,
			.snip1583 *:after {
				-webkit-box-sizing: border-box;
				box-sizing: border-box;
				-webkit-transition: all 0.35s ease;
				transition: all 0.35s ease;
			}

			.snip1583 img {
				max-width: 100%;
				vertical-align: top;
				padding: 0px !important;
			}

			.snip1583 .content {
				padding: 30px;
			}

			.snip1583 h3 {
				font-size: 1.4rem;
				font-weight: 400;
				margin: 0 0 4px;
			}

			.snip1583 .price {
				margin: 8px 0;
				font-weight: 700;
				color: #4da3e2;
				font-size: 1.5rem;
			}

			.snip1583 .icons {
				position: absolute;
				top: 0;
				bottom: 0;
				left: 0;
				right: 0;
				padding: 10px;
				display: flex;
				flex-direction: column;
				justify-content: flex-start;
				width: 64px;
				height: 154px;
			}

			.snip1583 .icons2 {
				position: absolute;
				top: 0;
				bottom: 0;
				right: 0;
				padding: 10px;
				display: flex;
				flex-direction: column;
				justify-content: flex-start;
			}

			.snip1583 .icons a {
				margin: 2px;
				opacity: 0;
				-webkit-transform: translateY(50%);
				transform: translateY(50%);
			}

			.snip1583 .icons a i {
				display: block;
				font-size: 23.52941176px;
				line-height: 40px;
				width: 40px;
				background-color: #ffffff;
				text-align: center;
				color: #000000;
			}

			.snip1583 .icons a i:hover {
				background-color: #4da3e2;
				color: #ffffff;
				cursor: pointer;
			}

			.snip1583:hover a,
			.snip1583.hover a {
				opacity: 1;
				-webkit-transform: translateX(0);
				transform: translateX(0);
			}

			.snip1583:hover a:nth-child(2),
			.snip1583.hover a:nth-child(2) {
				-webkit-transition-delay: 0.1s;
				transition-delay: 0.1s;
			}

			.snip1583:hover a:nth-child(3),
			.snip1583.hover a:nth-child(3) {
				-webkit-transition-delay: 0.2s;
				transition-delay: 0.2s;
			}

			.hideit{
				display:none;
			}
			 
			 .victor_publicacion:hover
			 {
			 	cursor: pointer;
background: -moz-linear-gradient(top, rgba(247,247,247,1) 0%, rgba(255,255,255,0) 100%); /* FF3.6-15 */
background: -webkit-linear-gradient(top, rgba(247,247,247,1) 0%,rgba(255,255,255,0) 100%); /* Chrome10-25,Safari5.1-6 */
background: linear-gradient(to bottom, rgba(247,247,247,1) 0%,rgba(255,255,255,0) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f7f7f7', endColorstr='#00ffffff',GradientType=0 ); /* IE6-9 */
			 }
        </style>
 

    </head>

    <body class="large-sidebar fixed-sidebar fixed-header skin-5">
    	<div class="wrapper">

			<!-- Preloader -->
			<div class="content-loader">
				<div class="preloader"></div>
			</div>

    		<!-- Sidebar second -->
    		<?php require_once('includes/sidebar-second.php'); ?>

    		<!-- Header -->
    		<?php require_once 'includes/header.php';?>
			<div class="site-content bg-white" style="margin-left: 0px; padding-top: 15px; margin-top: 70px;">

    		<?php if ($publicidadPrincipal): ?>
    			<div class="container-fluid" id="ad">
    				<?php foreach ($publicidadPrincipal as $p): ?>
    					<?php
    					$link = "";
    					if (strstr($p["url"], 'http')) {
    						$link = $p["url"];
    					} else {
    						$link = "http://$p[url]";
    					}
    					?>
    					<?php if ($p["tipo_publicidad"] == 1): ?>
    						<div class="col-md-3">
    							<?php
    							if (strstr($link, 'youtu.be')) {
    								$link = str_replace('youtu.be/', 'youtube.com/watch?v=', $link);
    							} else {
    								if (strstr($link, 'vimeo')) {
    									$link = "http://" . str_replace('vimeo.com/', 'player.vimeo.com/video/', $link);
    								}
    							}
    							$link = str_replace('watch?v=', 'embed/', $link);
    							?>
    							<div class="box bg-white post post-3">
    								<div class="p-img img-cover youtube-video">
    									<iframe class="youtube-player" type="text/html" width="100%" height="100%" src="<?php echo $link; ?>" frameborder="0"> </iframe>
    								</div>
    							</div>
    						</div>
    					<?php else: ?>
    						<div class="col-md-3">
    							<div class="box bg-white product product-1">
    								<div class="p-img img-cover" style="background-image: url(img/<?php echo $p["imagen"]; ?>);">
    									<div class="p-status bg-warning"><?php echo $p["titulo"]; ?></div>
    									<div class="p-links">
    										<a href="<?php echo $link; ?>"><i class="ti-link"></i></a>
    										<!--<a href="#"><i class="fa fa-star"></i></a>-->
    									</div>
    								</div>
    							</div>
    						</div>
    					<?php endif?>
    				<?php endforeach?>
    			</div>
    		<?php endif?>

				<div class="container-fluid">
					
					<div class="col-xs-12 col-md-3" style="z-index: 1;">
						<div class="row">
							<div class="col-md-12">
								<h3>Ofertas de empleo por área</h3>
								<div class="box bg-white">
									 <select onChange="listar_publicaciones(0)" id="area_estudio" name="area_estudio" class="form-control">
									 	<option value="">Seleccionar</option>
									 	<?php
									 		foreach ($datos_area as $key) {
									 			if($key["nombre"]!="")
									 			{
									 				echo '<option value=" '.$key["id_sector"].'">'.$key["nombre"].'</option>';
									 			}
									 		}
									 	?>
									 </select>
								</div>
							</div>
						</div>
						<!--<div class="row">
							<div class="col-md-12">
								<h3>Ofertas de empleo por provincia</h3>
								<div class="box bg-white">
									 <select name="area_estudio" class="form-control">
									 	<option value="">Seleccionar</option>
									 	 
									 </select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<h3>Ofertas de empleo por localidad</h3>
								<div class="box bg-white">
									 <select name="area_estudio" class="form-control">
									 	<option value="">Seleccionar</option>
									 	 
									 </select>
								</div>
							</div>
						</div>-->
						<div class="row">
							<div class="col-md-12">

								<h3>Por Fecha de Publicación</h3> 
								<div class="box bg-white">
									 <select  onChange="listar_publicaciones(0)" id="area_fecha" name="area_fecha" class="form-control">
									 	<option value="">Seleccionar</option>
									 	<option value="24">Últimas 24 horas</option>
									 	<option value="3">Durante los últimos 3 días</option>
									 	<option value="1">Durante la última semana</option>
									 	<option value="2">Durante las ultimas 2 semanas</option>
									 	<option value="4">Hace un mes o menos</option> 
									 	 
									 </select>
								</div>  
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">

								<h3>Por Disponibilidad</h3>

								<div class="box bg-white">
									 <select  onChange="listar_publicaciones(0)" id="area_disponibilidad" name="area_disponibilidad" class="form-control">
									 	<option value="">Seleccionar</option>
									 	<?php
									 		foreach ($datos_disponibilidad as $key) {
									 			if($key["nombre"]!="")
									 			{
									 				echo '<option value="'.$key["id"].'">'.$key["nombre"].'</option>';
									 			}
									 		}
									 	?>
									 </select>
								</div> 
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">

								<h3>Por Provincias</h3>

								<div class="box bg-white">
									 <select  onChange="listar_publicaciones(0)" id="por_provincia" name="area_disponibilidad" class="form-control">
									 	<option value="0">Seleccionar</option>
									 	<?php
									 		foreach ($datos_provincias as $key) {
									 			if($key["provincia"]!="")
									 			{
									 				echo '<option value="'.$key["id"].'">'.$key["provincia"].'</option>';
									 			}
									 		}
									 	?>
									 </select>
								</div> 
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">

								<h3>Por Localidades</h3>

								<div class="box bg-white">
									 <?php include('select_localidades.php');?>
								</div>

								<button class="btn btn-primary form-control" onClick="limpiarfiltros(0)">Limpiar filtros</button>
							</div>
						</div>

						<div class="row" style="margin-top: 20px;">
							<div class="col-md-12">
								<div class="list-group">
									<a href="noticias.php" class="list-group-item sidebar-index-hover">
										<h4>Noticias</h4>
										<p class="list-group-item-text">Enterate de las ultimas noticias ! En Jobbers te queremos informado...</p>
									</a>

									<li class="list-group-item sidebar-index-hover">
										<h4>Redes Sociales</h4>
										<p class="list-group-item-text" style="margin-bottom: 10px;">Siguenos para enterarte de nuestras ultimas novedades y compartir con nosotros.</p>
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
									</li>

									<a href="soporte.php" class="list-group-item sidebar-index-hover">
										<h4>Soporte Técnico</h4>
										<p class="list-group-item-text">Tienes dudas o alguna consulta? Pues preguntale a nuestros expertos !</p>
									</a>
								</div>
							</div>
						</div>						
					</div> <!-- Pegar aqui el codigo cuando esté listo -->


					<div class="col-md-9">
						<h3>Principales ofertas de trabajo</h3>
 						
 						<div class=" col-sm-12 " style="padding: 0px;" id="listado_publicaciones"></div>	
 					 
					</div>
					
				</div>

	<br>
	<br>
	<br>
	<br>
	<br>
 
<?php// endif ?>
<br>
<?php require_once 'includes/footer.php';?>

</div>
</div>

<?php require_once 'includes/libs-js.php';?>


<script type="text/javascript">
		var filtro_localidad=0;
		var parametro_localidad=0;
			//ajax para laspublicaiones
			var paginador=0;
			
			$( document ).ready(function() {
			 		  
			   listar_publicaciones(paginador); 
			   const MARGEN = 500;

				$(function(){
				 $(window).on("scroll",endPage)
				})
				function endPage(){
				 if(MARGEN > $(document).height() - $(window).scrollTop() - $(window).height()) {
				   paginador=paginador+10
				  listar_publicaciones(paginador);				 
				 }
				}


			});

			function limpiarfiltros()
			{
					
					 
					$("#area_estudio").val("");
		          	$("#area_fecha").val("");
		          	$("#area_disponibilidad").val("");
		          	$("#por_provincia").val(0);
		          	localidad(0);
		          	filtro_localidad=0;
		          	$("#listado_publicaciones").text("");
		          	listar_publicaciones(0);
		          
		          	
			}

				function localidad(par)
				{

					//parametro_localidad=par;
					$(".select_localidad").hide();
					$("#localidad_"+par).show();
					//alert(parametro_localidad);
				}

				$( "#por_provincia" ).change(function() {
				   	localidad($( "#por_provincia" ).val());
				});

				$(".select_localidad").change(function() {
					 //alert( $(this).find(":selected").val() );					 
					filtro_localidad=$("#"+$(this).attr('id')).val();
					//alert(filtro_localidad);
				    listar_publicaciones(0);
				});


			function listar_publicaciones(pagina)
			{

			 
				if(pagina==0)
				{
					//filtro_localidad=0;
				} 
				paginador=pagina;
				 if(paginador==0)
				 { 
				 	$("#listado_publicaciones").text("");
				 }
			 	
			  $.ajax({
		          method: "POST", 
		          url: "ajax/publicaciones_home.php",
		          dataType:"json", 
		          data:{
		          	pag:pagina,
		          	area:$("#area_estudio").val(),
		          	fecha:$("#area_fecha").val(),
		          	disponibilidad:$("#area_disponibilidad").val(),
		          	provincia:$("#por_provincia").val(),
		          	localidad:filtro_localidad
		          }
		       				 
				}).done(function(datos) {						
				
			
					$.each( datos, function( key, value ) {
						
						facebook="";
						twitter="";
						link=""
						instagram=""
						medalla=""; 
						urlEmpresa=datos[key]["nombre_empresa"];
						urlEmp=urlEmpresa.replace(" ", "-")+"-"+datos[key]["id_empresa"];

						url="empleos-detalle.php?a="+datos[key]["area"]+"&s="+datos[key]["sector"]+"&p="+datos[key]["publicacion"]+"";

						if(datos[key]["plan"]==4){medalla='<img src="img/gold-medal.png" style="float: right;margin-top: -10px;">';}
					 	if(datos[key]["plan"]==3){medalla='<img src="img/silver-medal.png" style="float: right;margin-top: -10px;">';}
					 	if(datos[key]["plan"]==2){medalla='<img src="img/bronze-medal.png" style="float: right;margin-top: -10px;">';}

						// if(datos[key]["plan"]==4){borde='gold';}
					 	// if(datos[key]["plan"]==3){borde='silver';}
					 	// if(datos[key]["plan"]==2){borde='bronze';}
						// if(datos[key]["plan"]==1){borde='free';}


						if(datos[key]["facebook"]!="" && datos[key]["instagram"]!=null){facebook='<a href="'+datos[key]["facebook"]+'"><img src="img/redes/facebook.png" style="margin-right: 5px;width: 16px;height: 16px;"></a>';}
						if(datos[key]["twitter"]!="" && datos[key]["instagram"]!=null){twitter='<a href="'+datos[key]["twitter"]+'"><img src="img/redes/twitter.png" style="margin-right: 5px;width: 16px;height: 16px;"></a>';}
						if(datos[key]["instagram"]!="" && datos[key]["instagram"]!=null){instagram='<a href="'+datos[key]["instagram"]+'"> <img src="img/redes/instagram.png" style="margin-right: 5px;width: 16px;height: 16px;"></a>' ;}
						if(datos[key]["linkedin"]!="" && datos[key]["linkedin"]!=null){link='<a href="'+datos[key]["link"]+'"><img src="img/redes/linkedin.png" style="margin-right: 5px;width: 16px;height: 16px;"></a>';}


					dias="";

					if(datos[key]["dias"]>31)
					{

						if(datos[key]["meses"]>12)
						{
							dias="Hace "+datos[key]["anos"]+" Años";
						}
						else
						{
							dias="Hace "+datos[key]["meses"]+" meses";
						}
					}
					else
					{
						if(datos[key]["dias"]==0)
						{
							dias="Hoy";
						}
						else
						{
							dias="Hace "+datos[key]["dias"]+" dias";
						} 
					}
					
					publicacion='<div class="col-sm-6" style="padding-right: 10px; padding-left: 10px;"><div class="victor_publicacion" style="height: 220px; margin-bottom: 10px; padding-right: 10px; padding-left: 10px; border: 1px solid #e5e5e5"> <div class="col-sm-12 text-center logo-medal" style="padding: 20px 0 0 0;"> '+medalla+'  <img src="'+datos[key]["imagen_empresa"]+'" class="img-circle" style="width: 50px;height: 50px;margin-right: -25px;margin-top: -10px;"></br> <a href="empresa/perfil.php?e='+urlEmp+'"><strong>'+urlEmpresa+'</strong></a> <p class="text-justify"> <span style="font-size: 11px;"><strong>'+dias+'</strong></span><br> <a href="'+url+'">'+datos[key]["titulo_publicacion"]+'</a> </p> <p style="font-size: 12px;" class="text-justify"> </p> </div><div class="col-sm-12 text-center" style="padding: 0px;padding-top: 10px;padding-bottom: 8px;"><div class="col-md-12" style="margin-bottom: 10px;"> '+facebook+link+twitter+instagram+'</div> <a target="_blank" href="'+url+'" class="btn btn-primary btn-sm" style="width: 100px;">Ver</a> </div> <div class="col-sm-8"></div> </div></div>'; 
						 
						$("#listado_publicaciones").append(publicacion);
		           		
		            });
						  
				});
			}

		</script>


<script>
	var c = "";
	var ad = null;

		 

				function applyFilter() {
					window.location.assign('trabajadores.php?calificacion=' + c);
				}

				$(document).ready(function(){
					$("#search").click(function() {
						var s = $("#search-input").val();
						if(s.trim() == "") {
							swal("Error!", "El campo de búsqueda esta vacío.", "error");
						}
						else {
							window.location.assign("empleos.php?busqueda=" + s + "&pagina=1");
						}
					});
					$("#search-w").click(function() {
						var s = $("#search-input-w").val();
						if(s.trim() == "") {
							swal("Error!", "El campo de búsqueda esta vacío.", "error");
						}
						else {
							window.location.assign("trabajadores.php?busqueda=" + s + "&pagina=1");
						}
					});

					$("input[type=checkbox][name=rating]").on('change', function() {
						var x = "";
						var arr = $("input[type=checkbox][name=rating]:checked");
						$(arr).each(function(indx, el) {
							x += el.value;
						});
						switch(x) {
							case "1":
							c = "cinco-estrellas";
							break;
							case "2":
							c = "cuatro-estrellas";
							break;
							case "3":
							c = "tres-estrellas";
							break;
							case "123":
							c = "de-cinco-a-tres-estrellas";
							break;
							case "12":
							c = "de-cinco-a-cuatro-estrellas";
							break;
							case "13":
							c = "de-cinco-a-tres-estrellas";
							break;
							case "23":
							c = "de-cuatro-a-tres-estrellas";
							break;
						}
						if(c == "") {
							$(".link-area").each(function(i, e) {
								$(e).attr('href', 'trabajadores.php?area=' + $(e).attr('data-area') + '&pagina=1');
							});
						}
						else {
							$(".link-area").each(function(i, e) {
								$(e).attr('href', 'trabajadores.php?area=' + $(e).attr('data-area') + '&calificacion=' + c + '&pagina=1');
							});
						}
					});
				});

				$(function() {
				
				<?php if($publicacion["coordenadas"] != ""): ?>
					initMap();
				<?php endif ?>
				
				$("#socialLinks .btn").click(function(){
					window.location.assign($(this).attr("data-url"));
				});
				var postulate = parseInt('<?php echo isset($_SESSION["ctc"]) ? (isset($_SESSION["ctc"]["postulate"]) ? $_SESSION["ctc"]["postulate"] : 0) : 2; ?>');
				
				<?php if(!$postulado && $infoT && isset($_SESSION["ctc"])): ?>
					$("#postulate").click(function() {
						
						$(this).addClass('disabled'); // Desactivar el botón al presionarlo.

						if(postulate == 1) {
							$.ajax({
								url: 'ajax/misc.php',
								type: 'GET',
								data: {
									op: 2,
									idp: <?php echo $publicacion["id"]; ?>,
									idt: <?php echo $infoT["id"]; ?>
								}
							}).done(function(data, textStatus, jqXHR) {						
								switch(jqXHR.status) {
									case 200:
										var json = JSON.parse(jqXHR.responseText);
										if(json.msg == "OK") {
											$(".pv-title").prepend('<span style="position: absolute; top: 5px; right: 5px; font-size: 18px;" class="tag tag-primary">Postulado</span>');
											$("#postulate").closest('div').remove();
											swal("Operación exitosa!", "Se ha enviado la solicitud para el empleo seleccionado.<br>La empresa se pondrá en contacto contigo si está interesada.", "success");
										}
									break;
								}
							});
						}
						else {
							$(this).removeClass('disabled');
							swal("Información", 'Su perfil no esta completo para poder postularse a un empleo, los requisitos minimos son:<br> (1) Tener foto de perfil.<br> (2) Completar todos los datos del paso 1 en el Currículum. <br> para ir a completar mis datos haga click <a href="cuenta.php">aquí</a>', "info");
						}
					});
				<?php else: ?>
					$("#postulate").click(function() {
						window.location.assign('registro.php?redirect=' + '<?php echo urlencode("empleos-detalle.php?$_SERVER[QUERY_STRING]"); ?>');
					});
				<?php endif ?>
			});
			</script>

		 
		</body>


		</html>