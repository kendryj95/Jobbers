var c_uid1 = 0;
var c_uid2 = 0;
var lastMessagesReceivedAll = null;

var lastMessagesReceived = null;

var intervalCheckNewMessages = null;
var intervalRefreshCurrentChat = null;

$(document).ready(function() {
	$("#sidebar-chat-window-message").on('keypress', function(e) {
		if (e.keyCode == 13) {
			$("#sidebar-chat-window-send-message").click();
		}
	});

	$("#sidebar-chat-window-send-message").click(function () {
		var uid1 = $('.sidebar-chat').data('uid');
		var uid2 = $("#sidebar-chat-window-user-name").data('uid');
		var message = $("#sidebar-chat-window-message").val();
		var time = new Date().getTime();
		$("#sidebar-chat-window-message").val("");
		$("#sidebar-chat-window-messages").append('<div id="' + time + '" class="scw-item self light"> <span>' + message + '</span> </div>');		
		if (message != '') {
			$.ajax({
				type: 'GET',
				url: urlCurrent+'ajax/chat.php',
				dataType: 'json',
				data: {
					op: 2,
					idc1: uid1,
					idc2: uid2,
					msg: message
				},
				success: function (response) {
					if (response.msg == "OK") {
						$("#" + time).removeClass('light');
					} else {

					}
				}
			});
		}
	});
	
	bindOpenChat();

	intervalCheckNewMessagessss();

	intervalRefreshCurrentChatttt();
	
	if(typeof u_t == "number") {
		checkNewMessages();
	}
	
	$(".to-toggle").click(function () {
		checkNewMessagesCount();
	});
});

function spawnNotification(theBody, theIcon, theTitle) {
	var options = {
		body: theBody,
		icon: theIcon
	}
	var n = new Notification(theTitle, options);
	audioNotif.play();
	if($(".to-toggle").is(":visible")) {
		$(".to-toggle").click();
	}
}

function bindOpenChat() {
	$(".sidebar-chat .open-chat").off().click(function () {
		var $btn = $(this);
		c_uid1 = $('.sidebar-chat').data('uid');
		c_uid2 = $btn.data('uniqueid');
		$("#sidebar-chat-window-content").hide();
		$.ajax({
			type: 'GET',
			url: urlCurrent+'ajax/chat.php',
			dataType: 'json',
			data: {
				op: 1,
				idc: c_uid1,
				idc2: c_uid2,
				mr: 1,
				t: u_t
			},
			success: function (response) {
				var conversations = response[0];
				$("#sidebar-chat-window-user-name").text(conversations.info.nombre);
				if(parseInt(typeUser) == 1) {
					$("#sidebar-chat-window-user-picture").attr('src', (((urlCurrent == "empresa/" || urlCurrent == "") ? '../' : "" )+'img/') + (conversations.info.image_path != null ? conversations.info.image_path : 'avatars/user.png'));
				}
				else {
					$("#sidebar-chat-window-user-picture").attr('src', 'empresa/img/' + (conversations.info.image_path != null ? conversations.info.image_path : 'avatars/user.png'));
				}
				$("#sidebar-chat-window-messages").html("");
				lastMessagesReceived = [];
				conversations.messages.forEach(function (info) {
					if (info.uid_usuario1 == c_uid1) {
						$("#sidebar-chat-window-messages").append('<div class="scw-item self"> <span>' + info.mensaje + '</span> </div>');
					} else {
						$("#sidebar-chat-window-messages").append('<div class="scw-item"> <span>' + info.mensaje + '</span> </div>');
						lastMessagesReceived.push(info.mensaje);
					}
				});
				
				$("#sidebar-chat-window-content").show();
				$("#sidebar-chat-window-user-name").data('uid', conversations.info.uid);
				$('.sidebar-chat').toggle();
				$('.sidebar-chat-window').toggle();
			}
		});
	});
}

function refreshCurrentChat() {
	$.ajax({
		type: 'GET',
		url: urlCurrent+'ajax/chat.php',
		dataType: 'json',
		data: {
			op: 1,
			idc: c_uid1,
			idc2: c_uid2,
			mr: 1,
			t: u_t
		},
		success: function (response) {
			var html = '';
			var conversations = response[0];
			var arr = [];

			if (typeof conversations != 'undefined') {
				conversations.messages.forEach(function (info) {

					if (info.uid_usuario1 == c_uid1) {
						html += '<div class="scw-item self"> <span>' + info.mensaje + '</span> </div>';
					} else {
						html += '<div class="scw-item"> <span>' + info.mensaje + '</span> </div>';
						arr.push(info.mensaje);

						if (lastMessagesReceived !== null) {
							if(lastMessagesReceived.indexOf(info.mensaje) == -1) {
								//if(document.hidden) {
									let nombre = null;
									if (typeof conversations.info.nombre != 'undefined') {
										nombre = conversations.info.nombre;
									} else {
										nombre = conversations.info.nombres + " " + conversations.info.apellidos;
									}
									spawnNotification(info.mensaje, "", "Nuevo mensaje recibido de " + nombre);
								//}
							}
						}
						
					}
				});
				$("#sidebar-chat-window-messages").html(html);
				lastMessagesReceived = arr;
			}
			
		}
	});
}

function checkNewMessages() {
	var uid = $('.sidebar-chat').data('uid');
	$.ajax({
		type: 'GET',
		url: urlCurrent+'ajax/chat.php',
		dataType: 'json',
		data: {
			op: 4,
			idc: uid,
			t: u_t
		},
		success: function (messages) {
			if(lastMessagesReceivedAll == null) {
				lastMessagesReceivedAll = messages;
			}
			else {
				messages.forEach(function(m) {
					var band = true;
					lastMessagesReceivedAll.forEach(function(m2) {
						if(m.id == m2.id) {
							band = false;
						}
					});
					if(band) {
						//if(document.hidden) {
							spawnNotification(m.mensaje, "", "Nuevo mensaje recibido de " + m.usuario_nombre);
						//}
					}
				});
				lastMessagesReceivedAll = messages;
			}
		}
	});
}

function checkNewMessagesCount() {
	var uid = $('.sidebar-chat').data('uid');
	$.ajax({
		type: 'GET',
		url: urlCurrent+'ajax/chat.php',
		dataType: 'json',
		data: {
			op: 1,
			idc: uid,
			t: u_t
		},
		success: function (conversations) {
			
			$("#sidebar-chats").html("");
			conversations.forEach(function(row) {
				var nombre = null;
				
				if (typeof row.info.nombre != 'undefined') {
					nombre = row.info.nombre;
				} else {
					nombre = row.info.nombres + " " + row.info.apellidos;
				}

				var html = '<a class="open-chat text-black" href="#" data-uniqueid="' + row.info.uid + '"><span class="sc-name">' + nombre + '</span>';
				if(row.messages_unreaded_count > 0) {
					html += '<span class="tag tag-primary">' + row.messages_unreaded_count + '</span>';
					$('#noReadNotifications').show().text(row.messages_unreaded_count);
				}
				else {
					html += '<span class="tag"></span>';
					$('#noReadNotifications').text('').hide();
				}
				html += '</a>';
				$("#sidebar-chats").append(html);
			});
			bindOpenChat();
		}
	});
}

function intervalCheckNewMessagessss(){ 
	setInterval(function () {
		if(typeof u_t == "number") {
			if (!$(".to-toggle").is(':visible')) {
				checkNewMessagesCount();
			}
			//if(document.hidden) {
				checkNewMessages();
			//}
		}
	}, 15000);
}

function intervalRefreshCurrentChatttt(){
	setInterval(function() {
		//if($("#sidebar-chat-window-content").is(":visible")) {
			refreshCurrentChat();
		//}
	}, 5000);
}