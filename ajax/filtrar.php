<?php
	require_once('../classes/DatabasePDOInstance.function.php'); 
	$base = DatabasePDOInstance();

	if(isset($_POST["op"]))
	{
		$estudio=$_POST["estudio"];
		$edad=$_POST["edad"];
		$genero=$_POST["genero"];
		$idioma=$_POST["idioma"];

		$localidad=$_POST["localidad"];
		$provincia=$_POST["provincia"];
		$remuneracion=$_POST["remuneracion"];
		$experiencia=$_POST["experiencia"];  

		$sql="";
		if($estudio==""){$sql=$sql."id_area_estudio !=00 ";}else{$sql=$sql." id_area_estudio LIKE '".$estudio."'";}; 

		if($edad==""){$sql=$sql." and TIMESTAMPDIFF(YEAR,t1.fecha_nacimiento,CURDATE()) !=00 ";}
		else{
			if($edad=="1823")
			{
				$sql=$sql." and TIMESTAMPDIFF(YEAR,t1.fecha_nacimiento,CURDATE()) BETWEEN 18 AND 23 ";
			}
			if($edad=="2430")
			{
				$sql=$sql." and TIMESTAMPDIFF(YEAR,t1.fecha_nacimiento,CURDATE()) BETWEEN 24 AND 30 ";
			}
			if($edad=="3136")
			{
				$sql=$sql." and TIMESTAMPDIFF(YEAR,t1.fecha_nacimiento,CURDATE()) BETWEEN 31 AND 36 ";
			}
			if($edad=="M37")
			{
				$sql=$sql." and TIMESTAMPDIFF(YEAR,t1.fecha_nacimiento,CURDATE()) > 36 ";
			} 
		};

		if($genero==""){$sql=$sql."   ";}
		else{
			 
				$sql=$sql." and id_sexo =".$genero." "; 
			 
		};
		if($idioma==""){$sql=$sql."   ";}else{$sql=$sql." and id_idioma LIKE '".$idioma."'";}; 

		if($experiencia==""){$sql=$sql."   ";}else{$sql=$sql." and id_actividad_empresa LIKE '".$experiencia."'";}; 

		if($localidad==""){$sql=$sql."   ";}else{$sql=$sql." and localidad LIKE '".$localidad."'";};

		if($provincia==""){$sql=$sql."  ";}else{$sql=$sql." and provincia LIKE '".$provincia."'";};
		
		if($remuneracion==""){$sql=$sql."  ";}
		else{
			if($remuneracion=="02000")
			{
				$sql=$sql." and remuneracion_pret BETWEEN 0 AND 2000 ";
			}
			if($remuneracion=="20015000")
			{
				$sql=$sql." and remuneracion_pret BETWEEN 2001 AND 5000 ";
			}
			if($remuneracion=="500110000")
			{
				$sql=$sql." and remuneracion_pret BETWEEN 5001 AND 10000 ";
			}
			if($remuneracion=="1000115000")
			{
				$sql=$sql." and (remuneracion_pret BETWEEN 10001 AND 15000) ";
			} 
			if($remuneracion=="1500120000")
			{
				$sql=$sql." and remuneracion_pret BETWEEN 15001 AND 20000 ";
			}
			if($remuneracion=="M20001")
			{
				$sql=$sql." and remuneracion_pret > 20001 ";
			}
		};

		 $consulta="SELECT t1.id, t1.id_imagen,upper(concat(t1.nombres,' ',t1.apellidos)) as nombre,
			t1.id_pais,t1.id_sexo,t1.provincia,t1.localidad,TIMESTAMPDIFF(YEAR,t1.fecha_nacimiento,CURDATE()) AS edad, group_concat(t2.id_area_estudio) as id_area_estudio ,group_concat(t3.id_idioma),t4.remuneracion_pret,group_concat(t4.sobre_mi) as sobre_mi,concat(t5.titulo, '.', t5.extension) as imagen,t6.nombre as pais , group_concat(t7.id_actividad_empresa)  as experiencia,t8.total 
				FROM trabajadores t1
				LEFT JOIN trabajadores_educacion t2 ON t1.id = t2.id_trabajador
				LEFT JOIN trabajadores_experiencia_laboral t7 ON t1.id= t7.id_trabajador
				LEFT JOIN trabajador_porcentaje t8 ON t1.id = t8.id
				LEFT JOIN trabajadores_idiomas t3 ON t1.id = t3.id_trabajador
				LEFT JOIN trabajadores_infextra t4 ON t1.id = t4.id_trabajador
		 		LEFT JOIN imagenes t5 ON t1.id_imagen = t5.id
		 		LEFT JOIN paises t6 ON t1.id_pais = t6.id

                WHERE ".$sql." GROUP by t1.id  order by t8.total desc
                LIMIT ".$_POST['p1']." , ".$_POST['p2']."";
					$datos = $base->getAll($consulta);
					echo json_encode($datos); 

		//echo $consulta;
	}
?>