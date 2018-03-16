<?php
//Experiencia laboral
$pdf->SetFont('Arial','',10); 
$pdf->SetTextColor(0,0,0);  // Establece el color del texto (en este caso es blanco) 
$pdf->SetFillColor(232, 232, 232);  
$pdf->Cell(190,5,''.utf8_decode("EXPERIENCIA LABORAL").'',0,1,'C','true');
if(count($datos_experiencias)>0)
{ 	$total=count($datos_experiencias);
	for ($i=0; $i < $total ; $i++) 
	{ 
	$pdf->SetFont('Arial','B',10); 
	$pdf->SetTextColor(46, 49, 146);
	$pdf->Cell(190,5,''.utf8_decode("".$datos_experiencias[$i]['nombre_empresa']."").'',0,1,'0');
	$pdf->SetFont('Arial','',9); 
	$pdf->SetTextColor(0,0,0);
	$textotrabajar="";
	if($datos_experiencias[$i]['trab_actualmt']==1)
	{
		$textotrabajar=" Trabajando actualmente";
	}
	$datos_fecha=explode(" ", $datos_experiencias[$i]['fecha']);
	$fecha="";
 	if($datos_fecha[2]=="0-9999")
	{
		$fecha=$datos_fecha[0];
	}
	else
	{ 
		$fecha=$datos_experiencias[$i]['fecha'];
	} 

	$pdf->Cell(190,5,''.utf8_decode("".$datos_experiencias[$i]['pais']." | ".$datos_experiencias[$i]['tipo_puesto']." | Periodo: (".$fecha.$textotrabajar.")").'',0,1,'0');
	$pdf->Cell(190,5,''.utf8_decode("Referencia: ".$datos_experiencias[$i]['nombre_encargado'].". ".$datos_experiencias[$i]['tlf_encargado']."").'',0,1,'0');

 
	$cadena_experiencia=explode(" ", $datos_experiencias[$i]['descripcion_tareas']);
	$datos_experiencia="";
	$bandera_experiencia=0;
	$contador=0;
	foreach ($cadena_experiencia as $key ) 
		{

		 
			if(strlen($datos_experiencia)<100)
			{
				$datos_experiencia=$datos_experiencia." ".$key;
				$bandera_experiencia=0;
			}
			else
			{
				if($contador==0)
				{
					$bandera_experiencia=1;
					$pdf->Cell(190,5,''.utf8_decode("Descripción de tareas:".$datos_experiencia."").'',0,1,'0');
					$datos_experiencia="";
					$contador++;
				}
				else
				{
					$bandera_experiencia=1;
					$pdf->Cell(190,5,''.utf8_decode("".$datos_experiencia."").'',0,1,'0');
					$datos_experiencia="";
				}
					
			 
				}
		
		}
			if($bandera==0)
			{
				if($contador==0)
				{
					$bandera_experiencia=1;
					$pdf->Cell(190,5,''.utf8_decode("Descripción de tareas:".$datos_experiencia."").'',0,1,'0'); 
					$contador++;
				}
				else
				{
					$bandera_experiencia=1;
					$pdf->Cell(190,5,''.utf8_decode("".$datos_experiencia."").'',0,1,'0'); 
				} 
			} 
		}

	} 
else
{
	$pdf->Cell(190,5,''.utf8_decode("Sin experiencia pero con ganas de aprender mucho.").'',0,1,'0'); 
}
 

?>