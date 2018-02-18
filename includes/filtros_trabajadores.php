<?php
$base = DatabasePDOInstance();

//Filtro idioma
$datos_idiomas = $base->getAll("SELECT t2.nombre, t1.id_idioma ,count(t1.id_idioma) as cantidad 
								FROM trabajadores_idiomas t1 
								LEFT JOIN idiomas t2 on t1.id_idioma = t2.id 
								GROUP BY t1.id_idioma 
								ORDER BY cantidad DESC");

//Filtro edad
$datos_edad = $base->getAll("SELECT TIMESTAMPDIFF(YEAR,fecha_nacimiento,CURDATE()) 
							 AS edad,COUNT(TIMESTAMPDIFF(YEAR,fecha_nacimiento,CURDATE())) AS cantidad 
							 FROM trabajadores 
							 GROUP BY edad");
//Filtro sexo
$datos_sexo = $base->getAll("SELECT id_sexo, count(id_sexo) as cantidad 
							 FROM trabajadores 
							 GROUP BY id_sexo");
//Filtro localidad
$datos_localidad = $base->getAll("SELECT t2.localidad as nombre, t1.localidad,COUNT(t1.localidad) AS cantidad 
								  FROM trabajadores t1 
								  LEFT JOIN localidades t2 on t1.localidad = t2.id 
								  GROUP BY localidad 
								  ORDER BY cantidad DESC");
//Filtro provincia
$datos_provincia = $base->getAll("SELECT t2.provincia as nombre, t1.provincia,COUNT(t1.provincia) AS cantidad 
								  FROM trabajadores t1 
								  LEFT JOIN provincias t2 on t1.provincia = t2.id 
								  GROUP BY provincia 
								  ORDER BY cantidad DESC");
//Filtro area estudio
$datos_area_estudio = $base->getAll("SELECT t2.nombre, t1.id_area_estudio,count(t1.id_area_estudio) as cantidad 
									 FROM trabajadores_educacion t1 
									 LEFT JOIN areas_estudio t2 ON t1.id_area_estudio= t2.id 
									 GROUP BY t1.id_area_estudio
									 ORDER BY cantidad DESC");
//Filtro area remuneracion
$datos_area_remuneracion = $base->getAll("SELECT remuneracion_pret as nombre 
										  FROM `trabajadores_infextra`  
										  ORDER BY remuneracion_pret ASC");
$experiencia_laboral = $base->getAll("SELECT t2.id_actividad_empresa,t3.nombre FROM trabajadores t1
						LEFT JOIN trabajadores_experiencia_laboral t2 ON t1.id= t2.id_trabajador
						LEFT JOIN actividades_empresa t3 ON t3.id= t2.id_actividad_empresa
						where t3.nombre IS NOT null
						GROUP by t2.id_actividad_empresa
						order by t3.nombre asc");
?>