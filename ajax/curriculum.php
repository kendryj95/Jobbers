<?php
	session_start();
	require_once('../classes/DatabasePDOInstance.function.php');
	require_once('../slug.function.php');
	$db = DatabasePDOInstance();

	$sql="
	UPDATE trabajadores
	SET nombres='".$_POST['nombre']."', 
	apellidos='".$_POST['apellido']."',
	correo_electronico='".$_POST['correo']."',
	fecha_nacimiento='".$_POST['anio']."-".$_POST['mes']."-".$_POST['dia']."',
	id_pais=".$_POST['naciomiento'].",
	id_estado_civil=".$_POST['edo_civil'].",
	id_tipo_documento_identificacion=".$_POST['dni'].",
	numero_documento_identificacion='".$_POST['numberdni']."',
	cuil='".$_POST['cuil']."',
	provincia='".$_POST['provincia']."',
	localidad='".$_POST['localidad']."',
	calle='".$_POST['calle']."',
	telefono='".$_POST['telefono']."',
	id_sexo=".$_POST['sexo'].",
	telefono_alternativo='".$_POST['telefono_2']."'
	WHERE id=".$_SESSION['ctc']['id']."";

 	try {
 		$db->query($sql);
 		//Actualizar nombre y apellido en la variable de session.
 		$_SESSION["ctc"]["name"] = explode(" ",$_REQUEST["nombre"])[0];
 		$_SESSION["ctc"]["lastName"] = explode(" ",$_REQUEST["apellido"])[0];
 		echo "1";
 	} catch (Exception $e) {
 		echo 0;
 	}
?>