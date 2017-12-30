<?php if ((!strstr($_SERVER["REQUEST_URI"], "admin/")) && (@$_SESSION['ctc']['plan']['nombre'] != 'Gratis')): ?>


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

						if (strstr($_SERVER["REQUEST_URI"], "empresa/")){
							require_once ("../classes/Chat.class.php");
							$chat = new Chat();
							$conversations = $chat->getMessages($_SESSION["ctc"]["uid"], null, $_SESSION["ctc"]["type"], 0);
						} else {
							require_once ("classes/Chat.class.php");
							$chat = new Chat();
							$conversations = $chat->getMessages($_SESSION["ctc"]["uid"], null, $_SESSION["ctc"]["type"], 0);
						}

					?>


					<div id="sidebar-chats">
						<?php foreach($conversations as $conv): ?>
							<a class="open-chat text-black" href="#" data-uniqueid="<?php echo $conv["info"]["uid"]; ?>">
								<span class="sc-name"><?php echo $conv["info"]["nombres"]; ?></span>
								<?php if($conv["messages_unreaded_count"] > 0): ?>
									<span class="tag tag-primary"><?php echo $conv["messages_unreaded_count"]; ?></span>
								<?php else: ?>
									<span class="tag"></span>
								<?php endif ?>
							</a>
						<?php endforeach ?>
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
						<!--<form>-->
							<input id="sidebar-chat-window-message" class="form-control" type="text" placeholder="Escribe tu mensaje">
							<button class="btn btn-secondary" type="button" id="sidebar-chat-window-send-message"><i class="ti-angle-right"></i></button>
						<!--</form>-->
					</div>
				</div>
			</div>

			<!-- FIN DEL IF -->
		</div>
	</div>
</div>


	<?php if(isset($_SESSION["ctc"])): ?>
		<!-- Template options -->
		<div class="template-options custom-scroll custom-scroll-dark">
			<div class="to-toggle">
				<i class="fa fa-envelope"></i> 
				CHAT
				<div style="bottom: -36px; right: -15px; position: absolute;"><i class="flaticon-mouse" style="color: #f9c890; font-size: 42px"></i></div>
				<!-- <span class="badge" style="background-color: #d61717; position: absolute; top: -16px; font-size: 16px">22</span> -->
			</div>
			
		</div>
	<?php endif ?>

<?php endif; ?>