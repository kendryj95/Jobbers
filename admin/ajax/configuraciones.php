<?php
	session_start();

	define('IVA', 1);
	define('PLANES', 2);
	define('SERVICIOS', 3);
	define('CAMBIAR_NOSOTROS', 4);
	define('CAMBIAR_POLITICAS', 5);
	define('CAMBIAR_CONTACTO', 6);
	define('CAMBIAR_REDES', 7);
	define('CAMBIAR_TERMINOS', 8);

	require_once('../../classes/DatabasePDOInstance.function.php');

	$db = DatabasePDOInstance();

	$op = isset($_REQUEST["op"]) ? $_REQUEST["op"] : false;

	if($op) {
		switch($op) {
			case IVA: 
				$exist = $db->getOne("SELECT id FROM configuraciones");
				if($exist) {
					$db->query("UPDATE configuraciones SET iva='$_REQUEST[iva]' WHERE id=1");
				}
				else {
					$db->query("INSERT INTO configuraciones (iva) VALUES ('$_REQUEST[iva]');");
				}
				echo json_encode(array("msg" => "OK"));
				break;
			case PLANES:
				$db->query("UPDATE planes SET precio='$_REQUEST[bronce]' WHERE id=2");
				$db->query("UPDATE planes SET precio='$_REQUEST[plata]' WHERE id=3");
				$db->query("UPDATE planes SET precio='$_REQUEST[oro]' WHERE id=4");
				echo json_encode(array("msg" => "OK"));
				break;
			case SERVICIOS:
				$db->query("UPDATE servicios SET precio='$_REQUEST[serv1]' WHERE id=1");
				$db->query("UPDATE planes SET precio='$_REQUEST[serv2]' WHERE id=2");
				$db->query("UPDATE planes SET precio='$_REQUEST[serv3]' WHERE id=3");
				echo json_encode(array("msg" => "OK"));
				break;
			case CAMBIAR_NOSOTROS:
				$db->query("UPDATE plataforma SET nosotros='$_REQUEST[nosotros]' WHERE id=1");
				echo json_encode(array("msg" => "OK"));
				break;
			case CAMBIAR_POLITICAS:
				$db->query("UPDATE plataforma SET politicas='$_REQUEST[politicas]' WHERE id=1");
				echo json_encode(array("msg" => "OK"));
				break;
			case CAMBIAR_CONTACTO:
				$db->query("UPDATE plataforma SET correo_contacto='$_REQUEST[contacto]' WHERE id=1");
				echo json_encode(array("msg" => "OK"));
				break;
			case CAMBIAR_REDES:
				$db->query("UPDATE plataforma SET facebook='$_REQUEST[facebook]', instagram='$_REQUEST[instagram]', twitter='$_REQUEST[twitter]', youtube='$_REQUEST[youtube]', linkedin='$_REQUEST[linkedin]' WHERE id=1");
				echo json_encode(array("msg" => "OK"));
				break;
			case CAMBIAR_TERMINOS:
				$db->query("UPDATE plataforma SET terminos='$_REQUEST[terminos]' WHERE id=1");
				echo json_encode(array("msg" => "OK"));
				break;
		}
	}
	function getExtension($str) {$i=strrpos($str,".");if(!$i){return"";}$l=strlen($str)-$i;$ext=substr($str,$i+1,$l);return $ext;}
?>