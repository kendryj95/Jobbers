<?php
	$scriptActual = basename($_SERVER['PHP_SELF'], '.php');
?>
<?php if(strstr($_SERVER["REQUEST_URI"], "index") || (strstr($_SERVER["PHP_SELF"], "index") && !strstr($_SERVER["REQUEST_URI"], "empresa"))): ?>
	<a style="width: 220px; height: 78px;position: fixed;z-index: 99;" class="logo" href="./">
		<div style="background-color: white;height: 71px;">
			<img style="width: 220px; height: 110px; padding: 22px;padding-top: 2px;" src="img/logo_d.png" alt="">
		</div>
	</a>
<?php else: ?>
	<div class="site-sidebar-overlay"></div>
	<div class="site-sidebar">
		<a class="logo" href="<?php echo ( strstr($_SERVER["REQUEST_URI"], "admin/") || strstr($_SERVER["REQUEST_URI"], "empresa/") ) ? ".././" : "./"; ?>">
			<img src="<?php echo ( strstr($_SERVER["REQUEST_URI"], "admin/") || strstr($_SERVER["REQUEST_URI"], "empresa/") ) ? ".././" : "./"; ?>img/logo_d.png" alt="" style="width: 100%;">
		</a>

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
							<li class="<?php echo strstr($_SERVER["REQUEST_URI"], "empresa/") ? "active" : ""; ?>">
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
							<li class="<?php echo $scriptActual == 'trabajadores' ? 'active' : ''; ?>">
								<a href="<?php echo strstr($_SERVER["REQUEST_URI"], "empresa/") ? "../" : ""; ?>trabajadores.php" class="waves-effect  waves-light">
									<span class="s-icon"><i class="ti-folder"></i></span>
									<span class="s-text">Ver jobbers</span>
								</a>
							</li>
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

<div class="site-sidebar-second custom-scroll custom-scroll-dark">
	<ul class="nav nav-tabs" role="tablist">
		<li class="nav-item">
			<a class="nav-link active" data-toggle="tab" href="#tab-1" role="tab">Chat</a>
		</li>
	</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="tab-1" role="tabpanel">
				<div class="sidebar-chat animated fadeIn" data-uid="<?php echo $_SESSION["ctc"]["type"] == 1 ? $_SESSION["ctc"]["empresa"]["uid"] : $_SESSION["ctc"]["uid"]; ?>">
					<div class="sidebar-group">

						<h6>Conversaciones</h6>
						<?php
						//require_once("$_SERVER[DOCUMENT_ROOT]/ctc/ctc/classes/Chat.class.php");
						//require_once("$_SERVER[DOCUMENT_ROOT]/classes/Chat.class.php");
						//require_once((strstr($_SERVER["REQUEST_URI"], "empresa/") ? "../" : "")."classes/Chat.class.php");
						if (strstr($_SERVER["REQUEST_URI"], "empresa/")){
							require_once ("../classes/Chat.class.php");
						} elseif (strstr($_SERVER["REQUEST_URI"], "admin/")){
							require_once ("../classes/Chat.class.php");
						} else {
							require_once ("classes/Chat.class.php");
						}
						//require_once((strstr($_SERVER["REQUEST_URI"], "empresa") ? "../" : "")."classes/Chat.class.php");
						//require_once ("../classes/Chat.class.php");
						$chat = new Chat();
						$conversations = $chat->getMessages($_SESSION["ctc"]["uid"], null, $_SESSION["ctc"]["type"], 0);
						?>

						<div id="sidebar-chats">
							<?php foreach($conversations as $conv): ?>
								<a class="open-chat text-black" href="#" data-uniqueid="<?php echo $conv["info"]["uid"]; ?>">
									<span class="sc-name"><?php echo $conv["info"]["nombre"]; ?></span>
									<?php if($conv["messages_unreaded_count"] > 0): ?>
										<span class="tag tag-primary"><?php echo $conv["messages_unreaded_count"]; ?></span>
									<?php else: ?>
										<span class="tag"></span>
									<?php endif ?>
								</a>
							<?php endforeach ?>
						</div> <!-- CIERRE: sidebar-chats -->


					</div> <!-- CIERRE: sidebar-group -->


				</div> <!-- CIERRE: sidebar-chat animated fadeIn  -->


			</div> <!-- CIERRE: tab-pane active -->


		</div> <!-- CIERRE: tab-content -->

</div> <!-- CIERRE: site-sidebar-second custom-scroll custom-scroll-dark  -->


<!-- COMENTAR DESDE AQUÍ -->

<!--<div class="site-sidebar-second custom-scroll custom-scroll-dark">
	<ul class="nav nav-tabs" role="tablist">
		<li class="nav-item">
			<a class="nav-link active" data-toggle="tab" href="#tab-1" role="tab">Chat</a>
		</li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab-1" role="tabpanel">
			<div class="sidebar-chat animated fadeIn" data-uid="<?php /*echo $_SESSION["ctc"]["type"] == 1 ? $_SESSION["ctc"]["empresa"]["uid"] : $_SESSION["ctc"]["uid"]; */?>">
				<div class="sidebar-group">
					<h6>Conversaciones</h6>
					
					<?php
/*						//require_once("$_SERVER[DOCUMENT_ROOT]/ctc/ctc/classes/Chat.class.php");
						//require_once("$_SERVER[DOCUMENT_ROOT]/classes/Chat.class.php");
						require_once((strstr($_SERVER["REQUEST_URI"], "empresa/") ? "../" : "")."classes/Chat.class.php");
						//require_once((strstr($_SERVER["REQUEST_URI"], "empresa") ? "../" : "")."classes/Chat.class.php");
						$chat = new Chat();
						$conversations = $chat->getMessages($_SESSION["ctc"]["uid"], null, $_SESSION["ctc"]["type"], 0);
					*/?>
					
					<div id="sidebar-chats">
						<?php /*foreach($conversations as $conv): */?>
							<a class="open-chat text-black" href="#" data-uniqueid="<?php /*echo $conv["info"]["uid"]; */?>">
								<span class="sc-name"><?php /*echo $conv["info"]["nombre"]; */?></span>
								<?php /*if($conv["messages_unreaded_count"] > 0): */?>
									<span class="tag tag-primary"><?php /*echo $conv["messages_unreaded_count"]; */?></span>
								<?php /*else: */?>
									<span class="tag"></span>
								<?php /*endif */?>
							</a>
						<?php /*endforeach */?>
					</div>
				</div>
			</div>
			<div class="sidebar-chat-window animated fadeIn">
				<div id="sidebar-chat-window-content">
					<div class="scw-header clearfix">
						<a class="text-grey pull-xs-left" href="#"><i class="ti-angle-left"></i> Atrás</a>
						<div class="pull-xs-right">
							<strong><span id="sidebar-chat-window-user-name"></span></strong>
							<div class="avatar box-32">
								<img id="sidebar-chat-window-user-picture" src="" alt="">
							</div>
						</div>
					</div>
					<div id="sidebar-chat-window-messages">					
					</div>
					<div class="scw-form">
							<input id="sidebar-chat-window-message" class="form-control" type="text" placeholder="Escribe tu mensaje">
							<button class="btn btn-secondary" type="button" id="sidebar-chat-window-send-message"><i class="ti-angle-right"></i></button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php /*if(isset($_SESSION["ctc"])): */?>
	<!-- Template options
	<div class="template-options custom-scroll custom-scroll-dark">
		<div class="to-toggle"><i class="ti-comments"></i> Chat</div>
	</div>-->
<?php /*endif */?>