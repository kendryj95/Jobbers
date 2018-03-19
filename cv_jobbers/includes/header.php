<?php
$pdf->SetFont('Arial','',12); 
$pdf->Cell(190,10,''.utf8_decode( mb_strtoupper($datos_trabajadores[0]['nombres'].' '.$datos_trabajadores[0]['apellidos'])).'',0,1,'C');
$pdf->SetFont('Arial','',8); 
$pdf->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco) 
$pdf->SetFillColor(46, 49, 146);  
$pdf->Cell(190,8,''.utf8_decode( mb_strtoupper($datos_direccion[0]['provincia'].' / '.$datos_direccion[0]['localidad'].' / '.$datos_direccion[0]['calle'])).'',0,1,'C','true');
$pdf->SetFont('Arial','',8); 
$pdf->SetTextColor(0,0,0);  // Establece el color del texto (en este caso es blanco) 
$pdf->SetFillColor(255, 255, 255); 
$pdf->Cell(190,5,''.utf8_decode(" ".$datos_trabajadores[0]['telefono']." - ".$datos_trabajadores[0]['correo_electronico']." - ".$datos_trabajadores[0]['edad']." años.").'',0,1,'C','true');


 
if($informacion_imagen[0]["imagen"]!=null)
{
	$pdf->Image('../img/profile/'.$informacion_imagen[0]["imagen"].'' , 15 ,8, 25 , 35,$informacion_imagen[0]["extension"], '');
}
else
{
	$pdf->Image('http://neu.bodenbelaege-koch.de/wp-content/uploads/2017/02/mustermann-e1487862745115.jpeg' , 15 ,8, 25 , 35,'jpg', '');
} 
?>