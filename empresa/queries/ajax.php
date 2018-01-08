<?php
// 1 - Corresponde a la calificacion de los usuarios por parte de las empresas.

require('../../classes/DatabasePDOInstance.function.php');
$base = DatabasePDOInstance();
	$opcion=0;
	if(isset($_POST['op']) && $_POST['op']!=0)
	{
		$opcion=$_POST['op'];
	}
	else
	{
		echo 0;
		exit();
	}

	if($opcion==1)
	{
		//Verificamos si ya hay un registro
		$contar=$base->getAll("SELECT count(calificacion) total FROM trabajadores_calificacion WHERE id_trabajador = ".$_POST['usuario']." AND id_empresa = ".$_POST['empresa']."");
		if($contar[0]['total']>0)
		{
			 $base->getAll("UPDATE trabajadores_calificacion SET calificacion = ".$_POST['value']." WHERE id_trabajador = ".$_POST['usuario']." AND id_empresa = ".$_POST['empresa'].""); 
		}
		else
		{
			  $base->getAll("INSERT INTO trabajadores_calificacion  (id_trabajador,calificacion,id_empresa,fecha_calificacion) values(".$_POST['usuario'].",".$_POST['value'].",".$_POST['empresa'].",'".date('Y-m-d')."');"); 
		}		 
	}

	if($opcion==11)
	{ 
		$contar=$base->getAll("SELECT count(calificacion) total,calificacion FROM trabajadores_calificacion WHERE id_trabajador = ".$_POST['usuario']." AND id_empresa = ".$_POST['empresa']."");
		if($contar[0]['total']>0)
		{
			echo $contar[0]['calificacion'];
			
		}
		else
		{
			echo "0";
		}	 
	}

	if($opcion==2)
	{
		//Verificamos si ya hay un registro
		$contar=$base->getAll("SELECT count(marcador) total FROM trabajadores_marcadores WHERE id_trabajador = ".$_POST['usuario']." AND id_empresa = ".$_POST['empresa']."");
		if($contar[0]['total']>0)
		{
			 $base->getAll("UPDATE trabajadores_marcadores SET marcador = ".$_POST['value']." WHERE id_trabajador = ".$_POST['usuario']." AND id_empresa = ".$_POST['empresa'].""); 
		}
		else
		{
			 $base->getAll("INSERT INTO trabajadores_marcadores  VALUES(null,".$_POST['usuario'].",".$_POST['empresa'].",".$_POST['value'].");"); 
		}		 
	}

	if($opcion==22)
	{ 
		$contar=$base->getAll("SELECT count(marcador) total,marcador FROM trabajadores_marcadores WHERE id_trabajador = ".$_POST['usuario']." AND id_empresa = ".$_POST['empresa']."");
		if($contar[0]['total']>0)
		{
			echo $contar[0]['marcador'];
			
		}
		else
		{
			echo "0";
		}	 
	}		
?>