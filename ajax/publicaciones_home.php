<?php
require_once('../classes/DatabasePDOInstance.function.php'); 
	$base = DatabasePDOInstance();
 
$condicion="";

if($_POST["area"]!=""){$condicion=$condicion." WHERE id_sector= ".$_POST['area']." ";}
if($_POST["disponibilidad"]!="")
{
	if($condicion=="")
	{
			$condicion=$condicion." WHERE disponibilidad= ".$_POST['disponibilidad']." ";
	}
	else
	{
		$condicion=$condicion." and disponibilidad= ".$_POST['disponibilidad']." ";
	}
}

if($_POST["provincia"]!=0)
{
	if($condicion=="")
	{
			$condicion=$condicion." WHERE t1.provincia= ".$_POST['provincia']." ";
	}
	else
	{
		$condicion=$condicion." and t1.provincia = ".$_POST['provincia']." ";
	}
}

if($_POST["localidad"]!=0)
{
	if($condicion=="")
	{
			$condicion=$condicion." WHERE t1.localidad = ".$_POST['localidad']." ";
	}
	else
	{
		$condicion=$condicion." and t1.localidad = ".$_POST['localidad']." ";
	}
}

if($_POST["fecha"]!="")
{
	if($condicion=="")
	{
			if($_POST['fecha']==24){$condicion=$condicion." WHERE timestampdiff(day,t1.fecha_actualizacion,curdate()) < 2 ";}
			if($_POST['fecha']==3){$condicion=$condicion." WHERE timestampdiff(day,t1.fecha_actualizacion,curdate()) < 4 ";}
			if($_POST['fecha']==1){$condicion=$condicion." WHERE timestampdiff(day,t1.fecha_actualizacion,curdate()) < 8 ";}
			if($_POST['fecha']==2){$condicion=$condicion." WHERE timestampdiff(day,t1.fecha_actualizacion,curdate()) < 15 ";}
			if($_POST['fecha']==4){$condicion=$condicion." WHERE timestampdiff(day,t1.fecha_actualizacion,curdate()) < 31 ";}
			 
	}
	else
	{
			if($_POST['fecha']==24){$condicion=$condicion." and timestampdiff(day,t1.fecha_actualizacion,curdate()) < 2 ";}
			if($_POST['fecha']==3){$condicion=$condicion." and timestampdiff(day,t1.fecha_actualizacion,curdate()) < 4 ";}
			if($_POST['fecha']==1){$condicion=$condicion." and timestampdiff(day,t1.fecha_actualizacion,curdate()) < 8 ";}
			if($_POST['fecha']==2){$condicion=$condicion." and timestampdiff(day,t1.fecha_actualizacion,curdate()) < 15 ";}
			if($_POST['fecha']==4){$condicion=$condicion." and timestampdiff(day,t1.fecha_actualizacion,curdate()) < 31 ";}
	}
}


if($_POST["busqueda"]!="")
{
	if($condicion=="")
	{
			$condicion=$condicion." WHERE t1.titulo like '%".$_POST['busqueda']."%'  ";
	}
	else
	{
		$condicion=$condicion." and t1.titulo like '%".$_POST['busqueda']."%' ";
	}
}
if($condicion=="")
{
	$condicion=$condicion." WHERE t2.suspendido <> 1 AND t1.estatus=1";
}
else
{
	$condicion=$condicion." AND t2.suspendido <> 1 AND t1.estatus=1";
}



//if($_POST["disponibilidad"]!=""){}

$sql="
SELECT t1.id as id_publicacion,
t2.verificado as verificado,  
t2.nombre as nombre_empresa,
concat('empresa/img/',t7.directorio,'/',t2.id_imagen,'.',t7.extension) as imagen_empresa,
t1.descripcion as descripcion_publicacion,
t1.titulo as titulo_publicacion, 
t3.id_plan as plan,
timestampdiff(month,t1.fecha_actualizacion,curdate()) as meses,
timestampdiff(day,t1.fecha_actualizacion,curdate()) as dias,
timestampdiff(year,t1.fecha_actualizacion,curdate()) as anos,
t2.facebook,
t2.instagram,
t2.twitter,
t2.linkedin,
t8.provincia,
t9.localidad,
t1.fecha_actualizacion,
t5.amigable as sector,
t6.amigable as area,
t1.amigable as publicacion,
t4.id_sector,
t2.id  as id_empresa
from publicaciones t1 
LEFT JOIN empresas t2 ON t1.id_empresa = t2.id
LEFT JOIN empresas_planes t3 ON t1.id_empresa = t3.id_empresa

LEFT JOIN provincias t8 ON t8.id = t1.provincia
LEFT JOIN localidades t9 ON t9.id = t1.localidad

LEFT JOIN publicaciones_sectores t4 ON t1.id=t4.id_publicacion
LEFT JOIN areas_sectores t5 ON t4.id_sector=t5.id 
LEFT JOIN areas t6 ON t5.id_area=t6.id 
LEFT JOIN imagenes t7 ON t2.id_imagen=t7.id
".$condicion." 

GROUP BY t1.id ORDER BY t3.id_plan DESC,t1.fecha_actualizacion DESC  limit ".$_POST['pag'].",10"

;

$datos_publicaciones = $base->getAll($sql);

//echo $sql;
echo json_encode($datos_publicaciones);
?>