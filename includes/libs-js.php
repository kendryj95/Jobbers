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
	<script type="text/javascript" src="../vendor/bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../vendor/detectmobilebrowser/detectmobilebrowser.js"></script>
	<script type="text/javascript" src="../vendor/jscrollpane/jquery.mousewheel.js"></script>
	<script type="text/javascript" src="../vendor/jscrollpane/mwheelIntent.js"></script>
	<script type="text/javascript" src="../vendor/jscrollpane/jquery.jscrollpane.min.js"></script>
	<script type="text/javascript" src="../vendor/waves/waves.min.js"></script>
	<script type="text/javascript" src="../vendor/switchery/dist/switchery.min.js"></script>
	<script type="text/javascript" src="../vendor/TinyColor/tinycolor.js"></script>
	<script type="text/javascript" src="../vendor/sparkline/jquery.sparkline.min.js"></script>
	<script type="text/javascript" src="../vendor/sweetalert2/sweetalert2.min.js"></script>
	<script type="text/javascript" src="../js/chat.js"></script>

	<!-- Neptune JS -->
	<script type="text/javascript" src="../js/app.js"></script>
	<script type="text/javascript" src="../js/demo.js"></script>
<?php else: ?>
	<!-- Vendor JS -->
	<script type="text/javascript" src="vendor/jquery/jquery-1.12.3.min.js"></script>
	<script type="text/javascript" src="vendor/tether/js/tether.min.js"></script>
	<script type="text/javascript" src="vendor/bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="vendor/detectmobilebrowser/detectmobilebrowser.js"></script>
	<script type="text/javascript" src="vendor/jscrollpane/jquery.mousewheel.js"></script>
	<script type="text/javascript" src="vendor/jscrollpane/mwheelIntent.js"></script>
	<script type="text/javascript" src="vendor/jscrollpane/jquery.jscrollpane.min.js"></script>
	<script type="text/javascript" src="vendor/waves/waves.min.js"></script>
	<script type="text/javascript" src="vendor/switchery/dist/switchery.min.js"></script>
	<script type="text/javascript" src="vendor/TinyColor/tinycolor.js"></script>
	<script type="text/javascript" src="vendor/sparkline/jquery.sparkline.min.js"></script>
	<script type="text/javascript" src="vendor/sweetalert2/sweetalert2.min.js"></script>
	<script type="text/javascript" src="js/chat.js"></script>
	<script type="text/javascript" src="js/app.js"></script>
	<script type="text/javascript" src="js/demo.js"></script>
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