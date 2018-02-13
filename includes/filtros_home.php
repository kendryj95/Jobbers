<?php
$base = DatabasePDOInstance();

//Filtro idioma 
//Filtro localidad
/*$datos_localidad = $base->getAll("SELECT t2.localidad as nombre, t1.localidad,COUNT(t1.localidad) AS cantidad 
								  FROM trabajadores t1 
								  LEFT JOIN localidades t2 on t1.localidad = t2.id 
								  GROUP BY localidad 
								  ORDER BY cantidad DESC");*/
//Filtro provincia
$datos_disponibilidad = $base->getAll("
SELECT t2.id,t2.nombre 
FROM publicaciones t1 
LEFT JOIN disponibilidad t2 ON t1.disponibilidad = t2.id 
GROUP by t1.disponibilidad ORDER by t2.nombre ASC");  

//Filtro area estudio
$datos_area = $base->getAll("
	SELECT t1.id_sector,t2.nombre FROM `publicaciones_sectores` t1 LEFT JOIN  areas_sectores t2 ON t1.id_sector= t2.id  GROUP by t1.id_sector order by nombre asc");

$datos_provincias=$base->getAll("SELECT t1.* FROM provincias t1 RIGHT JOIN publicaciones t2 ON t2.provincia = t1.id GROUP BY id");
 
?>