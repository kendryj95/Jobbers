<?php
//Experiencia laboral
$pdf->SetFont('Arial','',10); 
$pdf->SetTextColor(0,0,0);  // Establece el color del texto (en este caso es blanco) 
$pdf->SetFillColor(232, 232, 232);  
$pdf->Cell(190,5,''.utf8_decode("INFORMACIÓN ADICIONAL").'',0,1,'C','true');
if(count($datos_extra)>0)
{

$pdf->SetFont('Arial','B',10); 
$pdf->SetTextColor(46, 49, 146);
$pdf->Cell(190,5,''.utf8_decode("Remuneración pretendida:").'',0,1,'0');
$pdf->SetFont('Arial','',9); 
$pdf->SetTextColor(0,0,0);
$pdf->Cell(190,5,''.utf8_decode("$ ".$datos_extra[0]['remuneracion_pret']."").'',0,1,'0'); 
 

$pdf->SetFont('Arial','B',10); 
$pdf->SetTextColor(46, 49, 146);
$pdf->Cell(190,5,''.utf8_decode("Disponibilidad").'',0,1,'0');
$pdf->SetFont('Arial','',9); 
$pdf->SetTextColor(0,0,0);
$pdf->Cell(190,5,''.utf8_decode("".$datos_extra[0]['nombre']."").'',0,1,'0');   


$pdf->SetFont('Arial','B',10); 
$pdf->SetTextColor(46, 49, 146);
$pdf->Cell(190,5,''.utf8_decode("Sobre mi").'',0,1,'0');
$pdf->SetFont('Arial','',9); 
$pdf->SetTextColor(0,0,0);

$cadena=explode(" ", $datos_extra[0]['sobre_mi']);
$datos="";
$bandera=0;
foreach ($cadena as $key ) {
	
	if(strlen($datos)<120)
	{
		$datos=$datos." ".$key;
		$bandera=0;
	}
	else
	{
		$bandera=1;
		$pdf->Cell(190,5,''.utf8_decode("".$datos."").'',0,1,'0');
		$datos="";	
	}
	
}
	if($bandera==0)
	{
		$pdf->Cell(190,5,''.utf8_decode("".$datos."").'',0,1,'0');
	} 
}

else
{
	$pdf->Cell(190,5,''.utf8_decode("Sin información").'',0,1,'0');
}
?>