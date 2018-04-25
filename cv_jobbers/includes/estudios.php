<?php
//Experiencia laboral
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(0,0,0);  // Establece el color del texto (en este caso es blanco)
$pdf->SetFillColor(232, 232, 232);
$pdf->Cell(190,5,''.utf8_decode("ESTUDIOS REALIZADOS").'',0,1,'C','true');


 if(count($datos_estudios)>0)
 {
	$total=count($datos_estudios);
	for ($i=0; $i < $total ; $i++)
	{
	$pdf->SetFont('Arial','B',10);
	$pdf->SetTextColor(46, 49, 146);
	$pdf->Cell(190,5,''.utf8_decode("".$datos_estudios[$i]['nombre_institucion']."").'',0,1,'0');
	$pdf->SetFont('Arial','',9);
	$pdf->SetTextColor(0,0,0);

	$datos_experiencia="";
	$cadena=$datos_estudios[$i]['estudio']." | ".$datos_estudios[$i]['nombre']." | ".$datos_estudios[$i]['titulo']." | ".estado($datos_estudios[$i]['id_estado_estudio'])." | ".$datos_estudios[$i]['area'];
	$cadena_experiencia=explode(" ", $cadena);

	foreach ($cadena_experiencia as $key )
		{
			if(strlen($datos_experiencia)<110)
			{
				$datos_experiencia=$datos_experiencia." ".$key;
				$bandera_experiencia=0;
			}
			else
			{
					$bandera_experiencia=1;
					$pdf->Cell(190,5,''.utf8_decode("".$datos_experiencia."").'',0,1,'0');
					$datos_experiencia="";

			}
		}

			if($bandera==0)
			{
				 $bandera_experiencia=1;
				 $pdf->Cell(190,5,''.utf8_decode("".$datos_experiencia."").'',0,1,'0');
			}
	}
}

 else
{
	$pdf->Cell(190,5,''.utf8_decode("Sin información").'',0,1,'0');
} 
 function estado($parametro)
{
	if($parametro==1){return "En curso";}
	if($parametro==2){return "Graduado";}
	if($parametro==3){return "Abandonado";}
}
?>
