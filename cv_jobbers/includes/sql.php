<?php
	$db = DatabasePDOInstance();

	$id=$_GET['id'];
	$trabajadores="SELECT *,TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE())  as edad,DATE_FORMAT( fecha_nacimiento,  '%d-%m-%Y' ) as fecha_n FROM trabajadores WHERE id=".$id."";
	$datos_trabajadores=$db->getAll($trabajadores);
	
	$direccion="SELECT t1.calle,t2.localidad,t3.provincia FROM trabajadores t1 
	left JOIN localidades t2 ON t1.localidad = t2.id
	left JOIN provincias t3 ON t1.provincia = t3.id
	WHERE t1.id=".$id."";
	$datos_direccion=$db->getAll($direccion);

	$extra = "SELECT t1.*,t2.nombre from trabajadores_infextra t1
		LEFT JOIN disponibilidad t2 ON t2.id = t1.disponibilidad
		WHERE t1.id_trabajador=".$id."";
	$datos_extra=$db->getAll($extra);

	$idioma = "SELECT t1.*,t2.nombre FROM `trabajadores_idiomas`t1
		LEFT JOIN idiomas t2 on t1.id_idioma=t2.id 
		WHERE t1.id_trabajador=".$id."";
	$datos_idioma=$db->getAll($idioma);

	$experiencias = "SELECT t1.trab_actualmt, t1.nombre_empresa,t1.tipo_puesto,t1.nombre_encargado,t1.tlf_encargado,t1.descripcion_tareas,t2.nombre as pais, concat('',t1.mes_ingreso,'-',t1.ano_ingreso,' a ',t1.mes_egreso,'-',t1.ano_egreso,'') as fecha FROM `trabajadores_experiencia_laboral` t1 
left JOIN paises t2 ON t1.id_pais = t2.id 
		WHERE t1.id_trabajador=".$id." order by t1.ano_ingreso DESC , t1.mes_ingreso DESC ";
	$datos_experiencias=$db->getAll($experiencias);

$estudios = "SELECT t1.ano_finalizacion, t1.mes_finalizacion, t1.id_trabajador,t1.nombre_institucion,t1.titulo,t4.nombre as area ,t1.id_estado_estudio,t2.nombre,t3.nombre as estudio FROM trabajadores_educacion t1
	LEFT JOIN paises t2 ON t1.id_pais = t2.id
	LEFT JOIN nivel_estudio t3 ON t1.id_nivel_estudio = t3.id
	LEFT JOIN areas_estudio t4 ON t1.id_area_estudio = t4.id
		WHERE t1.id_trabajador=".$id." order by t1.ano_inicio desc";
	$datos_estudios=$db->getAll($estudios);

$otros_conocimentos = "SELECT * FROM `trabajadores_otros_conocimientos`
		WHERE  id_trabajador=".$id."";
	$datos_otros_conocimentos=$db->getAll($otros_conocimentos);

$consulta_imagen = " SELECT t1.id,concat(t2.nombre,'.',t2.extension) as imagen,t2.extension FROM trabajadores t1
			LEFT JOIN imagenes t2 On t1.id_imagen = t2.id 
			WHERE t1.id=".$id."";
	$informacion_imagen=$db->getAll($consulta_imagen);

?>