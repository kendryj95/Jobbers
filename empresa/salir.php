<?php
	session_start();
	session_destroy();
	unset($_SESSION["ctc"]["empresa"]);
	unset($_SESSION["ctc"]);
	header('Location: acceder.php');
?>