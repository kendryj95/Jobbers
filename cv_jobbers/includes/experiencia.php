<?php
//Experiencia laboral
$pdf->SetFont('Arial','',10); 
$pdf->SetTextColor(0,0,0);  // Establece el color del texto (en este caso es blanco) 
$pdf->SetFillColor(232, 232, 232);  
$pdf->Cell(190,5,''.utf8_decode("EXPERIENCIA LABORAL").'',0,1,'C','true');
if(count($datos_experiencias)>0)
{ 	$total=count($datos_experiencias);
	for ($i=0; $i < $total ; $i++) { 
	$pdf->SetFont('Arial','B',10); 
	$pdf->SetTextColor(46, 49, 146);
	$pdf->Cell(190,5,''.utf8_decode("".$datos_experiencias[$i]['nombre_empresa']."").'',0,1,'0');
	$pdf->SetFont('Arial','',9); 
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(190,5,''.utf8_decode("".$datos_experiencias[$i]['nombre_empresa']." | ".$datos_experiencias[$i]['pais']." | ".$datos_experiencias[$i]['tipo_puesto']." | ".$datos_experiencias[$i]['fecha'].")").'',0,1,'0');
	$pdf->Cell(190,5,''.utf8_decode("Referencia: ".$datos_experiencias[$i]['nombre_encargado'].". ".$datos_experiencias[$i]['tlf_encargado']."").'',0,1,'0');
	$pdf->Cell(190,5,''.utf8_decode("Detalle: ".$datos_experiencias[$i]['descripcion_tareas']."").'',0,1,'0'); 
	}
}
else
{
	$pdf->Cell(190,5,''.utf8_decode("Sin información").'',0,1,'0'); 
}


  


?>