<?php
require_once('../classes/DatabasePDOInstance.function.php'); 
$base = DatabasePDOInstance();
$sql="INSERT INTO tbl_alertas VALUES(null,".$_POST['user'].",".$_POST['actividad'].",null);";

try {
	$base->query($sql);
	echo 1;
} catch (Exception $e) {
	echo 0;
}


?>