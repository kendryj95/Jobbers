<?php
//Experiencia laboral
$pdf->SetFont('Arial','',10); 
$pdf->SetTextColor(0,0,0);  // Establece el color del texto (en este caso es blanco) 
$pdf->SetFillColor(232, 232, 232);  
$pdf->Cell(190,5,''.utf8_decode("OTROS CONOCIMIENTOS").'',0,1,'C','true');


if(count($datos_otros_conocimentos)>0)
{
	for ($i=0; $i < $total ; $i++) 
		{
			$pdf->SetFont('Arial','B',10); 
			$pdf->SetTextColor(46, 49, 146);
			$pdf->Cell(190,5,''.utf8_decode("".$datos_otros_conocimentos[$i]['nombre']."").'',0,1,'0');
			$pdf->SetFont('Arial','',9); 
			$pdf->SetTextColor(0,0,0);
			$pdf->Cell(190,5,''.utf8_decode("".$datos_otros_conocimentos[$i]['descripcion']."").'',0,1,'0'); 
		}
	  
}
else
{

	$pdf->Cell(190,5,''.utf8_decode("Sin información").'',0,1,'0'); 
} 
 
?>