<script>
	<?php if(isset($_SESSION["ctc"]["type"])): ?>
		var u_t = <?php echo $_SESSION["ctc"]["type"]; ?>;
	<?php else: ?>
		var u_t = null;
	<?php endif ?>
	var audioNotif = new Audio('notification.mp3');
</script>


<?php if(strstr($_SERVER["REQUEST_URI"], "empresa/") || strstr($_SERVER["REQUEST_URI"], "admin/")): ?>
	<!-- Vendor JS -->
	<script type="text/javascript" src="../vendor/jquery/jquery-1.12.3.min.js"></script>
	<script type="text/javascript" src="../vendor/tether/js/tether.min.js"></script>
	<!-- <script type="text/javascript" src="../vendor/bootstrap/js/bootstrap.min.js"></script> -->
	<script type="text/javascript" src="../js/bootstrap.js"></script>
	<script type="text/javascript" src="../vendor/detectmobilebrowser/detectmobilebrowser.js"></script>
	<script type="text/javascript" src="../vendor/jscrollpane/jquery.mousewheel.js"></script>
	<script type="text/javascript" src="../vendor/jscrollpane/mwheelIntent.js"></script>
	<script type="text/javascript" src="../vendor/jscrollpane/jquery.jscrollpane.min.js"></script>
	<script type="text/javascript" src="../vendor/waves/waves.min.js"></script>
	<script type="text/javascript" src="../vendor/switchery/dist/switchery.min.js"></script>
	<script type="text/javascript" src="../vendor/TinyColor/tinycolor.js"></script>
	<script type="text/javascript" src="../vendor/sparkline/jquery.sparkline.min.js"></script>
	<script type="text/javascript" src="../vendor/sweetalert2/sweetalert2.min.js"></script>
	<script type="text/javascript" src="../js/validar.js"></script>
	
	<?php if (!strstr($_SERVER["REQUEST_URI"], "admin/")) { ?>
		<?php if(isset($_SESSION["ctc"])): ?>
		<script type="text/javascript" src="../js/app.js"></script>
		<script type="text/javascript" src="../vendor/moment/moment.js"></script>
			<?php if ($_SESSION['ctc']['plan']['id_plan'] != 1): ?>
			<script type="text/javascript" src="../js/chat.js"></script>
			<?php endif ?>
		<?php endif; ?>
	<?php } ?>

	<!-- Neptune JS -->
	<script type="text/javascript" src="../js/demo.js"></script>
<?php else: ?>
	<!-- Vendor JS -->
	<script type="text/javascript" src="vendor/jquery/jquery-1.12.3.min.js"></script>
	<script type="text/javascript" src="vendor/tether/js/tether.min.js"></script>
	<!-- <script type="text/javascript" src="vendor/bootstrap/js/bootstrap.min.js"></script> -->
	<script type="text/javascript" src="js/bootstrap.js"></script>
	<script type="text/javascript" src="vendor/detectmobilebrowser/detectmobilebrowser.js"></script>
	<script type="text/javascript" src="vendor/jscrollpane/jquery.mousewheel.js"></script>
	<script type="text/javascript" src="vendor/jscrollpane/mwheelIntent.js"></script>
	<script type="text/javascript" src="vendor/jscrollpane/jquery.jscrollpane.min.js"></script>
	<script type="text/javascript" src="vendor/waves/waves.min.js"></script>
	<script type="text/javascript" src="vendor/switchery/dist/switchery.min.js"></script>
	<script type="text/javascript" src="vendor/TinyColor/tinycolor.js"></script>
	<script type="text/javascript" src="vendor/sparkline/jquery.sparkline.min.js"></script>
	<script type="text/javascript" src="vendor/sweetalert2/sweetalert2.min.js"></script>
	<?php if(isset($_SESSION["ctc"])): ?>
	<script type="text/javascript" src="vendor/moment/moment.js"></script>
	<script type="text/javascript" src="js/chat.js"></script>
	<?php endif ?>
	<script type="text/javascript" src="js/app.js"></script>
	<script type="text/javascript" src="js/demo.js"></script>
	<script type="text/javascript" src="js/validar.js"></script>
<?php endif ?>


<?php if(isset($_SESSION["ctc"])): ?>
	<?php if($_SESSION["ctc"]["type"] == 1): ?>
		<script type="text/javascript">
			$(function() {
				$("#search-w").click(function() {
					var s = $("#search-input-w").val();
					if(s.trim() == "") {
						swal("Error!", "El campo de búsqueda esta vacío.", "error");
					}
					else {
						window.location.assign("trabajadores.php?busqueda=" + s + "&pagina=1");
					}
				});
			});
		</script>
	<?php else: ?>
		<script type="text/javascript">
			$(function() {
				$("#search").click(function() {
					var s = $("#search-input").val();
					if(s.trim() == "") {
						swal("Error!", "El campo de búsqueda esta vacío.", "error");
					}
					else {
						window.location.assign("empleos.php?busqueda=" + s + "&pagina=1");
					}
				});
			});
		</script>
	<?php endif ?>
	<script type="text/javascript">
		 $('#busqueda_form').on('submit', function(evt){
	    	evt.preventDefault();
			<?php if($_SESSION["ctc"]["type"] == 2): ?>
				var s = $("#search-input").val();
				if(s.trim() == "") {
					swal("Error!", "El campo de búsqueda esta vacío.", "error");
				}else {
					window.location.assign("empleos.php?busqueda=" + s + "&pagina=1");
				}
			<?php elseif($_SESSION["ctc"]["type"] == 1): ?>
				var s = $("#search-input-w").val();
				if(s.trim() == "") {
					swal("Error!", "El campo de búsqueda esta vacía.", "error");
				}else {
					var ruta = "trabajadores.php?busqueda=" + s + "&pagina=1";
					<?php if(strstr($_SERVER["REQUEST_URI"], "empresa/")) :?>
					var ruta = "../trabajadores.php?busqueda=" + s + "&pagina=1";
					<?php endif?>
					window.location.assign(ruta);
				}
			<?php endif ?>
		 });	
	</script>
<?php else: ?>
	<script type="text/javascript">
		$(function() {
			$("#search").click(function() {
				var s = $("#search-input").val();
				if(s.trim() == "") {
					swal("Error!", "El campo de búsqueda esta vacío.", "error");
				}
				else {
					window.location.assign("empleos.php?busqueda=" + s + "&pagina=1");
				}
			});
		});
	</script>
<?php endif ?>
<script>
	$(document).ready(function() {
		$('.actualiza_plan').on('click', function(){
			swal({
				title: 'Actualiza tu plan a ORO',
				text: "Y disfruta de todos los beneficios de estar en la pantalla principal con todas las opciones además de la funcionalidad de promocionar un producto de venta o video. Qué desea hacer?",
				type: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Ir a mis planes',
				cancelButtonText: 'Decidir después',
				confirmButtonClass: 'btn btn-primary btn-lg m-r-1',
				cancelButtonClass: 'btn btn-danger btn-lg',
				buttonsStyling: false
				}).then(function(isConfirm) {
				if (isConfirm === true) {
					window.location.assign("planes.php?pay=true");
				}
			});
		});
	});
</script>

<script type="text/javascript">
	$(document).ready(function() {
		$(".vmMomento").click(function() {
			if($('.vmMomento span.underline').text() == 'ver menos'){
				$('html, body').animate({scrollTop:$('.tMomento').offset().top-150}, 300);
			}

			$('.tMomento .hideit').toggle(function(){
				if ($(this).is(':visible')) {
					$(".vmMomento span.underline").text('ver menos');
					$(".vmMomento span.text-muted").text('-');
				} else {
					$(".vmMomento span.underline").text('ver mas');
					$(".vmMomento span.text-muted").text('+');
				}
			});
		});

		$(".vmArea").click(function() {
			if($('.vmArea span.underline').text() == 'ver menos'){
				$('html, body').animate({scrollTop:$('.tArea').offset().top-150}, 300);
			}

			$('.tArea .hideit').toggle(function(){
				if ($(this).is(':visible')) {
					$(".vmArea span.underline").text('ver menos');
					$(".vmArea span.text-muted").text('-');
				} else {
					$(".vmArea span.underline").text('ver mas');
					$(".vmArea span.text-muted").text('+');
				}
			});
		});
	});
</script>