<?php
	session_start();

	require_once('../classes/DatabasePDOInstance.function.php');

	$db = DatabasePDOInstance();

	$infoEmpresa = $_SESSION["ctc"]["empresa"];
	$idEmpresa = $infoEmpresa["id"];
	$idTrabajador = 2;
	$idMensaje = 2;

	$infoEmpresa["ruta_imagen"] = $infoEmpresa["id_imagen"] ? $infoEmpresa["id_imagen"] : "img/avatars/user.png";

	$infoTrabajador = $db->getRow("
		SELECT
			trabajadores.nombres,
			trabajadores.apellidos,
			IF (
				imagenes.id IS NULL,
				'img/avatars/user.png',
				CONCAT(
					imagenes.directorio,
					'/',
					imagenes.id,
					'.',
					imagenes.extension
				)
			) AS ruta_imagen
		FROM
			trabajadores
		LEFT JOIN imagenes ON trabajadores.id_imagen = imagenes.id
		WHERE
			trabajadores.id = $idTrabajador
	");

	$ultimosMensajes = $db->getAll("
		SELECT
			mensajes.id,
			mensajes.id_usuario1,
			mensajes.id_usuario2,
			mensajes_respuestas.id_usuario AS usuario_id,
			mensajes_respuestas.tipo_usuario AS usuario_tipo,
			mensajes_respuestas.mensaje,
			mensajes_respuestas.fecha_hora
		FROM
			mensajes
		LEFT JOIN mensajes_respuestas ON mensajes.id = mensajes_respuestas.id_mensaje
		WHERE
			mensajes.id_usuario2 = $idEmpresa
		AND mensajes_respuestas.id IN (
			SELECT
				MAX(id)
			FROM
				mensajes_respuestas
			GROUP BY
				id_usuario
		)
		GROUP BY
			mensajes_respuestas.id_usuario
	");

	if($ultimosMensajes === false) {
		$ultimosMensajes = array();
	}

	foreach($ultimosMensajes as $i => $mensaje) {
		switch($mensaje["usuario_tipo"]) {
			case 1:
				$info = $db->getRow("
					SELECT
						trabajadores.id,
						trabajadores.nombres,
						trabajadores.apellidos,
						IF (
							imagenes.id IS NULL,
							'img/avatars/user.png',
							CONCAT(
								imagenes.directorio,
								'/',
								imagenes.id,
								'.',
								imagenes.extension
							)
						) AS ruta_imagen
					FROM
						trabajadores
					LEFT JOIN imagenes ON trabajadores.id_imagen = imagenes.id
					WHERE
						trabajadores.id = $mensaje[usuario_id]
				");
				$ultimosMensajes[$i]["trabajador_id"] = "$info[id]";
				$ultimosMensajes[$i]["usuario_nombre"] = "$info[nombres] $info[apellidos]";
				$ultimosMensajes[$i]["usuario_avatar"] = "$info[ruta_imagen]";
				break;
			case 2:
				$info = $db->getRow("
					SELECT
						empresas.nombre,
						IF (
							imagenes.id IS NULL,
							'img/avatars/user.png',
							CONCAT(
								imagenes.directorio,
								'/',
								imagenes.id,
								'.',
								imagenes.extension
							)
						) AS ruta_imagen
					FROM
						empresas
					LEFT JOIN imagenes ON empresas.id_imagen = imagenes.id
					WHERE
						empresas.id = $mensaje[usuario_id]
				");
				$ultimosMensajes[$i]["usuario_nombre"] = "$info[nombre]";
				$ultimosMensajes[$i]["usuario_avatar"] = "$info[ruta_imagen]";
				break;
		}
	}

	$mensajes = $db->getAll("
		SELECT
			mensajes_respuestas.*
		FROM
			mensajes
		INNER JOIN mensajes_respuestas ON mensajes.id = mensajes_respuestas.id_mensaje
		WHERE
			mensajes.id = $idMensaje AND (mensajes.id_usuario1 = $idTrabajador AND mensajes.id_usuario2 = $idEmpresa)
	");

	if($mensajes === false) {
		$mensajes = array();
	}
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
		<title>CTC - Chat</title>

		<!-- Vendor CSS -->
		<link rel="stylesheet" href="../vendor/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="../vendor/themify-icons/themify-icons.css">
		<link rel="stylesheet" href="../vendor/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="../vendor/animate.css/animate.min.css">
		<link rel="stylesheet" href="../vendor/jscrollpane/jquery.jscrollpane.css">
		<link rel="stylesheet" href="../vendor/waves/waves.min.css">
		<link rel="stylesheet" href="../vendor/switchery/dist/switchery.min.css">
		<link rel="stylesheet" href="../vendor/morris/morris.css">
		<link rel="stylesheet" href="../vendor/jvectormap/jquery-jvectormap-2.0.3.css">
		
		<link rel="stylesheet" href="../vendor/sweetalert2/sweetalert2.min.css">

		<link rel="stylesheet" href="../vendor/DataTables/css/dataTables.bootstrap4.min.css">
		<link rel="stylesheet" href="../vendor/DataTables/Responsive/css/responsive.bootstrap4.min.css">
		<link rel="stylesheet" href="../vendor/DataTables/Buttons/css/buttons.dataTables.min.css">
		<link rel="stylesheet" href="../vendor/DataTables/Buttons/css/buttons.bootstrap4.min.css">
		
		<link rel="stylesheet" href="../vendor/select2/dist/css/select2.min.css">

		<!-- Neptune CSS -->
		<link rel="stylesheet" href="css/core.css">

		<!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

		<style>
			th.dt-center, td.dt-center { text-align: center; }
			
			.swal2-modal {
				border: 1px solid rgb(223, 223, 223);
			}
		</style>
	</head>

	<body class="large-sidebar fixed-sidebar fixed-header skin-5">
		<div class="wrapper">

			<!-- Preloader 
			<div class="preloader"></div>-->

			<!-- Sidebar -->
			<?php require_once('includes/sidebar.php'); ?>

			<!-- Sidebar second -->
			<?php require_once('includes/sidebar-second.php'); ?>

			<!-- Header -->
			<?php require_once('includes/header.php'); ?>
			
			<div class="site-content">
				<!-- Content -->
				<div class="content-area p-y-1">
					<div class="container-fluid">
						<!--<h4>Chat</h4>
						<ol class="breadcrumb no-bg m-b-1">
							<li class="breadcrumb-item"><a href="#">Home</a></li>
							<li class="breadcrumb-item"><a href="#">Apps</a></li>
							<li class="breadcrumb-item active">Chat</li>
						</ol>-->
						<div class="box bg-white messenger">
							<div class="row no-gutter">
								<div class="col-xs-4">
									<div class="m-contacts">
										<div class="m-title">Chat <span id="status" style="float: right;"></span></div>
										<div class="m-form">
											<form class="mf-search">
												<input id="search_contact" class="form-control" type="text" placeholder="Buscar">
												<button class="btn btn-secondary btn-rounded" type="button"><i class="ti-search"></i></button>
											</form>
										</div>
										<?php foreach($ultimosMensajes as $mensaje): ?>
											<div class="mc-item <?php echo $mensaje["id"] == $idMensaje ? "active" : ""; ?>">
												<a class="text-black link-load-messages" href="javascript: void(0);" data-m="<?php echo $mensaje["id"]; ?>" data-u1="<?php echo $mensaje["usuario_tipo"] == 2 ? $mensaje["id_usuario1"] : $mensaje["id_usuario2"]; ?>">
													<div class="media">
														<div class="media-left">
															<div class="avatar box-48">
																<img class="b-a-radius-circle" src="<?php echo $mensaje["usuario_avatar"]; ?>" alt="">
																<span class="status bg-secondary top right" style="display: none;"></span>
															</div>
														</div>
														<div class="media-body">
															<div class="clearfix">
																<h6 class="media-heading pull-xs-left msg-sender"><?php echo $mensaje["usuario_nombre"]; ?></h6>
																<span class="font-90 text-muted pull-xs-right msg-date"><?php echo date('d/m/Y h:i:s A', strtotime($mensaje["fecha_hora"])); ?></span>
															</div>
															<span class="text-muted msg-content"><?php echo strlen($mensaje["mensaje"]) > 96 ? (substr($mensaje["mensaje"], 0, 96) . "...") : $mensaje["mensaje"]; ?></span>
														</div>
													</div>
												</a>
											</div>
										<?php endforeach ?>
										<!--
										<div class="mc-item">
											<a class="text-black" href="#">
												<div class="media">
													<div class="media-left">
														<div class="avatar box-48">
															<img class="b-a-radius-circle" src="img/avatars/1.jpg" alt="">
															<span class="status bg-success top right"></span>
														</div>
													</div>
													<div class="media-body">
														<div class="clearfix">
															<h6 class="media-heading pull-xs-left">Anna Doe <span class="tag tag-danger">2</span></h6>
															<span class="font-90 text-muted pull-xs-right">17:14</span>
														</div>
														<span class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod...</span>
													</div>
												</div>
											</a>
										</div>
										<div class="mc-item active">
											<a class="text-black" href="#">
												<div class="media">
													<div class="media-left">
														<div class="avatar box-48">
															<img class="b-a-radius-circle" src="img/avatars/2.jpg" alt="">
															<span class="status bg-secondary top right"></span>
														</div>
													</div>
													<div class="media-body">
														<div class="clearfix">
															<h6 class="media-heading pull-xs-left">John Doe</h6>
															<span class="font-90 text-muted pull-xs-right">17 july</span>
														</div>
														<span class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod...</span>
													</div>
												</div>
											</a>
										</div>
										<div class="mc-item">
											<a class="text-black" href="#">
												<div class="media">
													<div class="media-left">
														<div class="avatar box-48">
															<img class="b-a-radius-circle" src="img/avatars/3.jpg" alt="">
															<span class="status bg-success top right"></span>
														</div>
													</div>
													<div class="media-body">
														<div class="clearfix">
															<h6 class="media-heading pull-xs-left">Kate Doe <span class="tag tag-danger">14</span></h6>
															<span class="font-90 text-muted pull-xs-right">08:37</span>
														</div>
														<span class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod...</span>
													</div>
												</div>
											</a>
										</div>
										-->
									</div>
								</div>
								<div class="col-xs-8">
									<div class="m-chat">
										<div class="m-header">
											<div class="media">
												<div class="media-body">
													<h6 class="media-heading m-b-0 m-t-1"><?php echo "$infoTrabajador[nombres] $infoTrabajador[apellidos]"; ?></h6>
													<!--<span class="font-90 text-muted">Last seen 2 hours ago</span>-->
												</div>
												<!--<div class="media-right">
													<div class="mh-links">
														<a class="text-grey" href="#"><i class="fa fa-phone"></i></a>
														<a class="text-grey" href="#"><i class="fa fa-video-camera"></i></a>
													</div>
												</div>-->
											</div>
										</div>
										<div class="m-form">
											<div class="row">
												<div class="p-x-1">
													<div class="mf-compose">
														<input id="text_message" class="form-control" type="text" placeholder="">
														<button id="chat_button" class="btn btn-success btn-rounded" type="button">Enviar</button>
													</div>
												</div>
											</div>
										</div>
										<div id="chat_text_list" style="height: 450px;overflow: auto;">
											<?php foreach($mensajes as $mensaje): ?>
												<?php if($mensaje["tipo_usuario"] == 1): ?>
													<div class="mc-item left clearfix">
														<div class="avatar box-48">
															<img class="b-a-radius-circle" src="<?php echo $infoTrabajador["ruta_imagen"]; ?>" alt="">
														</div>
														<div class="mc-content">
															<?php echo $mensaje["mensaje"]; ?>
															<div class="font-90 text-xs-right text-muted"><?php echo date('h:i:s A', strtotime($mensaje["fecha_hora"])); ?></div>
														</div>
													</div>
												<?php else: ?>
													<div class="mc-item right clearfix">
														<div class="avatar box-48">
															<img class="b-a-radius-circle" src="<?php echo $infoEmpresa["ruta_imagen"]; ?>" alt="">
														</div>
														<div class="mc-content">
															<?php echo $mensaje["mensaje"]; ?>
															<div class="font-90 text-xs-right text-muted"><?php echo date('h:i:s A', strtotime($mensaje["fecha_hora"])); ?></div>
														</div>
													</div>
												<?php endif ?>
											<?php endforeach ?>
										</div>
										<!--<div class="mc-item left clearfix">
											<div class="avatar box-48">
												<img class="b-a-radius-circle" src="img/avatars/2.jpg" alt="">
											</div>
											<div class="mc-content">
												Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi.
												<div class="font-90 text-xs-right text-muted">14:20</div>
											</div>
										</div>
										<div class="mc-item right clearfix">
											<div class="avatar box-48">
												<img class="b-a-radius-circle" src="img/avatars/5.jpg" alt="">
											</div>
											<div class="mc-content">
												Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor.
												<div class="font-90 text-xs-right text-muted">14:23</div>
											</div>
										</div>
										<div class="mc-item left clearfix">
											<div class="avatar box-48">
												<img class="b-a-radius-circle" src="img/avatars/2.jpg" alt="">
											</div>
											<div class="mc-content">
												Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
												<div class="font-90 text-xs-right text-muted">14:28</div>
											</div>
										</div>-->
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- Footer -->
				<?php require_once('includes/footer.php'); ?>
			</div>
		</div>

		<!-- Vendor JS -->
		<script type="text/javascript" src="../vendor/jquery/jquery-1.12.3.min.js"></script>
		<script type="text/javascript" src="../vendor/tether/js/tether.min.js"></script>
		<script type="text/javascript" src="../vendor/bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="../vendor/detectmobilebrowser/detectmobilebrowser.js"></script>
		<script type="text/javascript" src="../vendor/jscrollpane/jquery.mousewheel.js"></script>
		<script type="text/javascript" src="../vendor/jscrollpane/mwheelIntent.js"></script>
		<script type="text/javascript" src="../vendor/jscrollpane/jquery.jscrollpane.min.js"></script>
		<script type="text/javascript" src="../vendor/waves/waves.min.js"></script>
		<script type="text/javascript" src="../vendor/switchery/dist/switchery.min.js"></script>
		<script type="text/javascript" src="../vendor/flot/jquery.flot.min.js"></script>
		<script type="text/javascript" src="../vendor/flot/jquery.flot.pie.js"></script>
		<script type="text/javascript" src="../vendor/flot/jquery.flot.stack.js"></script>
		<script type="text/javascript" src="../vendor/flot/jquery.flot.resize.min.js"></script>
		<script type="text/javascript" src="../vendor/flot.tooltip/js/jquery.flot.tooltip.min.js"></script>
		<script type="text/javascript" src="../vendor/CurvedLines/curvedLines.js"></script>
		<script type="text/javascript" src="../vendor/TinyColor/tinycolor.js"></script>
		<script type="text/javascript" src="../vendor/sparkline/jquery.sparkline.min.js"></script>
		<script type="text/javascript" src="../vendor/jvectormap/jquery-jvectormap-2.0.3.min.js"></script>
		<script type="text/javascript" src="../vendor/jvectormap/jquery-jvectormap-world-mill.js"></script>
		
		<script type="text/javascript" src="../vendor/sweetalert2/sweetalert2.min.js"></script>

		<script type="text/javascript" src="../vendor/DataTables/js/jquery.dataTables.min.js"></script>
		<script type="text/javascript" src="../vendor/DataTables/js/dataTables.bootstrap4.min.js"></script>
		<script type="text/javascript" src="../vendor/DataTables/Responsive/js/dataTables.responsive.min.js"></script>
		<script type="text/javascript" src="../vendor/DataTables/Responsive/js/responsive.bootstrap4.min.js"></script>
		<script type="text/javascript" src="../vendor/DataTables/Buttons/js/dataTables.buttons.min.js"></script>
		<script type="text/javascript" src="../vendor/DataTables/Buttons/js/buttons.bootstrap4.min.js"></script>
		<script type="text/javascript" src="../vendor/DataTables/JSZip/jszip.min.js"></script>
		<script type="text/javascript" src="../vendor/DataTables/pdfmake/build/pdfmake.min.js"></script>
		<script type="text/javascript" src="../vendor/DataTables/pdfmake/build/vfs_fonts.js"></script>
		<script type="text/javascript" src="../vendor/DataTables/Buttons/js/buttons.html5.min.js"></script>
		<script type="text/javascript" src="../vendor/DataTables/Buttons/js/buttons.print.min.js"></script>
		<script type="text/javascript" src="../vendor/DataTables/Buttons/js/buttons.colVis.min.js"></script>
		
		<script type="text/javascript" src="../vendor/select2/dist/js/select2.min.js"></script>
		
		<!-- TinyMCE -->
		<script type="text/javascript" src="../vendor/tinymce/tinymce.min.js"></script>
		<script type="text/javascript" src="../vendor/tinymce/skins/custom/jquery.tinymce.min.js"></script>

		<!-- Neptune JS -->
		<script type="text/javascript" src="js/app.js"></script>

		<script>
			var infoEmpresa = <?php echo json_encode($infoEmpresa); ?>;
			var infoTrabajador = <?php echo json_encode($infoTrabajador); ?>;
			var id_usuario1 = <?php echo $idTrabajador; ?>;
            var user_id = 0;
            
            $(document).ready(function() {
		
                serverUrl = 'ws://www.techzonemind.com:8000/demo';
                if (window.MozWebSocket) {
                    socket = new MozWebSocket(serverUrl);
                } else if (window.WebSocket) {
                    socket = new WebSocket(serverUrl);
                }
                socket.binaryType = 'blob';
                socket.onopen = function(msg) {
                    $('#status').html('<span class="tag tag-info">Registrando</span>');
                    register_user();
                    return true;
                };
                
                socket.onmessage = function(msg) {
                    var response;
                    response = JSON.parse(msg.data);
                    checkJson(response);
                    return true;
                };
                socket.onclose = function(msg) {
                    $('#status').html('<span class="tag tag-danger">Desconectado</span>');
                    setTimeout(function(){
                            $('#status').html('<span class="tag tag-warning">Reconectando</span>');
                        }
                    ,5000);
                    setTimeout(function(){
                            //location.reload();
                        }
                    ,10000);
                    return true;
                };
                
                function checkJson(res) {
                    
                    if(res.action=='registred'){
                        $('#status').html('<span class="tag tag-success">En línea</span>');
                        $('#chat_button').removeAttr('disabled');
                        $('#text_message').removeAttr('disabled');
                        //$('#chat-head').html('<b>User-'+res.user_id+'</b> ('+res.users_online+' Users Online)');
                        user_id = res.user_id;                        
                    } else if(res.action=='chat_text'){
						console.log(res);
						
						$.ajax({
							type: 'GET',
							url: 'ajax/mensajes.php',
							data: {
								op: 1,
								info: JSON.stringify({
									mensaje: res.chat_text,
									id_usuario1: id_usuario1
								})
							},
							success: function(response) {
								var json = JSON.parse(response);
								if(json.msg == "OK") {
									if(res.user_id==user_id){
										$('#text_message').val('');
									}
									var new_entry = '<div class="mc-item ' + (res.user_id==user_id ? 'right' : 'left') + ' clearfix"> <div class="avatar box-48"> <img class="b-a-radius-circle" src="' + infoEmpresa.ruta_imagen + '" alt=""> </div> <div class="mc-content">' + res.chat_text + '<div class="font-90 text-xs-right text-muted">' + json.data.horaFormateada + '</div> </div> </div>';

									//var new_entry = '<li><b>User-'+res.user_id+'&nbsp;&nbsp;</b>&nbsp;&nbsp;<span style="color: #DDD;width: 300px">'+res.date_time+' &nbsp;:&nbsp;</span>'+res.chat_text+'</li>'


									$("#chat_text_list").append(new_entry);
									$("#chat_text_list").animate({ scrollTop: 50000 }, "slow");
									
									$(".m-contacts .mc-item.active .msg-date").text(json.data.fechaHoraFormateada);
									$(".m-contacts .mc-item.active .msg-content").text(res.chat_text.length > 96 ? (res.chat_text.substring(0, 96) + "...") : res.chat_text);
								}
							}
						});
                    }
                    
                }
                
                function register_user(){
                    payload = new Object();
                    payload.action 		= 'register';
                    socket.send(JSON.stringify(payload));
                }
                
                
                $("#chat_button").click(function(){
                    console.log('Triggred');
                    payload = new Object();
                    payload.action 		= 'chat_text';
                    payload.user_id 	= user_id;
                    payload.chat_text   = $('#text_message').val();
                    socket.send(JSON.stringify(payload));
                });
                
                $("#text_message").on("keypress", function(e) {
                    if (e.keyCode == 13){
                        $("#chat_button").click();
                    }
                });
				
				$("#search_contact").keyup(function() {
					var value = $(this).val();
					if(value == "") {
						$('.m-contacts .mc-item').fadeIn();
					}
					else {
						$('.m-contacts .mc-item .msg-sender').each(function(){
							 var $this = $(this);
							 if($this.text().toLowerCase().indexOf(value) === -1)
								 $this.closest('.mc-item').fadeOut();
							else $this.closest('.mc-item').fadeIn();
						});
					}
				});
                
            });
			
			var myDiv = document.getElementById("chat_text_list");
			myDiv.scrollTop = myDiv.scrollHeight;
			
			$(".link-load-messages").click(function() {
				var $mItem = $(this).closest('.mc-item');
				var m = $(this).attr('data-m');
				var u1 = $(this).attr('data-u1');
				$.ajax({
					type: 'GET',
					url: 'ajax/mensajes.php',
					data: {
						op: 2,
						m: m,
						u1: u1,
						u2: <?php echo $idEmpresa; ?>
					},
					success: function(response) {
						var json = JSON.parse(response);
						var messages = json.messages;
						var t = json.t;
						id_usuario1 = parseInt(t.i);
						$(".m-contacts .mc-item").removeClass("active");
						$mItem.addClass("active");
						$("#chat_text_list").empty();
						var html = '';
						messages.forEach(function(message) {
							if(message.tipo_usuario == 1) {
								html += '<div class="mc-item left clearfix"> <div class="avatar box-48"> <img class="b-a-radius-circle" src="' + t.ruta_imagen + '" alt=""> </div> <div class="mc-content">' + message.mensaje + '<div class="font-90 text-xs-right text-muted">' + message.horaFormateada + '</div> </div> </div>';
							}
							else {
								html += '<div class="mc-item right clearfix"> <div class="avatar box-48"> <img class="b-a-radius-circle" src="<?php echo $infoEmpresa["ruta_imagen"]; ?>" alt=""> </div> <div class="mc-content">' + message.mensaje + '<div class="font-90 text-xs-right text-muted">' + message.horaFormateada + '</div> </div> </div>';
							}
						});
						$("#chat_text_list").html(html);
						document.getElementById("chat_text_list").scrollTop = document.getElementById("chat_text_list").scrollHeight;
					}
				});
			});
        </script>

	</body>

</html>