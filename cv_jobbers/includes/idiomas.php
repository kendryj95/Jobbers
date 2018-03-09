<?php
//Experiencia laboral
$pdf->SetFont('Arial','',10); 
$pdf->SetTextColor(0,0,0);  // Establece el color del texto (en este caso es blanco) 
$pdf->SetFillColor(232, 232, 232);  
$pdf->Cell(190,5,''.utf8_decode("IDIOMAS").'',0,1,'C','true');

if(count($datos_idioma)>0)
{

	$total=count($datos_idioma);
	for ($i=0; $i < $total ; $i++) {  
	$pdf->SetFont('Arial','B',10); 
	$pdf->SetTextColor(46, 49, 146);
	$pdf->Cell(190,5,''.utf8_decode("".$datos_idioma[$i]['nombre']."").'',0,1,'0');
	$pdf->SetFont('Arial','',9); 
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(190,5,''.utf8_decode("Nivel oral: ".nivel($datos_idioma[$i]['nivel_oral'])." | Nivel Escrito: ".nivel($datos_idioma[$i]['nivel_escrito'])."").'',0,1,'0'); 
	}
} 
else
{
	$pdf->Cell(190,5,''.utf8_decode("Sin información").'',0,1,'0'); 
}
//
function nivel($parametro)
{
	if($parametro==1){return "Básico";}
	if($parametro==2){return "Medio";}
	if($parametro==3){return "Avanzado";}
	if($parametro==4){return "Nativo";}
}
 
?>