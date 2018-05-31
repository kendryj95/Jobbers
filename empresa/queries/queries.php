<?php
	$base = DatabasePDOInstance();
	// publicaciones.php

	// -- Trabajadores postulados a este empleo --  
	
	//Obtener idiomas
	$datos_idiomas = $base->getAll("SELECT * FROM idiomas");

	//Obtener areas_estudio
	$areas_estudio = $base->getAll("SELECT t1.id,t3.id as id_cliente,t4.id_area_estudio ,t5.nombre as nombre,t5.id as id_area
									FROM publicaciones t1 
									LEFT JOIN postulaciones t2 ON t1.id = t2.id_publicacion 
									LEFT JOIN trabajadores t3 ON t3.id = t2.id_trabajador
									LEFT JOIN trabajadores_educacion t4 ON t4.id_trabajador = t2.id_trabajador
									LEFT JOIN areas_estudio t5 ON t5.id = t4.id_area_estudio
									WHERE t1.id_empresa=".$_SESSION['ctc']['empresa']['id']."
									GROUP BY t4.id_area_estudio
									ORDER BY t5.nombre  ASC
									");

	//Datos para el select provincias	
	$datos_provincias = $base->getAll("SELECT t4.id,t4.provincia 
									FROM publicaciones t1 
									LEFT JOIN postulaciones t2 ON t1.id = t2.id_publicacion 
									LEFT JOIN trabajadores t3 ON t3.id = t2.id_trabajador 
									LEFT JOIN provincias t4 ON t4.id = t3.provincia
									WHERE t1.id_empresa=".$_SESSION['ctc']['empresa']['id']."
									GROUP BY provincia");

	$provincias = $base->getAll("SELECT * FROM provincias WHERE estatus=1");
	
	//Datos para el select actividad empresa	
	$actividad_empresa = $base->getAll("SELECT t4.id_actividad_empresa,t5.nombre 
										FROM publicaciones t1 
										LEFT JOIN postulaciones t2 ON t1.id = t2.id_publicacion 
										LEFT JOIN trabajadores t3 ON t3.id = t2.id_trabajador 
										LEFT JOIN trabajadores_experiencia_laboral t4 ON t4.id_trabajador = t2.id_trabajador
										LEFT JOIN actividades_empresa t5 ON t5.id = t4.id_actividad_empresa 
										WHERE t1.id_empresa=".$_SESSION['ctc']['empresa']['id']."
										GROUP BY id_actividad_empresa
										order by nombre asc");

?>