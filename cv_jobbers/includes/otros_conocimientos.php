<?php
//Experiencia laboral
if(count($datos_otros_conocimentos)>0)
{

	$pdf->SetFont('Arial','',10);
	$pdf->SetTextColor(0,0,0);  // Establece el color del texto (en este caso es blanco)
	$pdf->SetFillColor(232, 232, 232);
	$pdf->Cell(190,5,''.utf8_decode("OTROS CONOCIMIENTOS").'',0,1,'C','true');


	if(count($datos_otros_conocimentos)>0)
	{
		for ($i=0; $i < count($datos_otros_conocimentos) ; $i++)
			{
				$pdf->SetFont('Arial','B',10);
				$pdf->SetTextColor(46, 49, 146);
				$pdf->Cell(190,5,''.utf8_decode("".$datos_otros_conocimentos[$i]['nombre']."").'',0,1,'0');
				$pdf->SetFont('Arial','',9);
				$pdf->SetTextColor(0,0,0);
				$contenido_datos=$datos_otros_conocimentos[$i]['descripcion'];
				//$pdf->Cell(190,5,''.utf8_decode("".$datos_otros_conocimentos[$i]['descripcion']."").'',0,1,'0');

				$datos_imprimir="";
				$variable_bandera=0;
				if(strlen($contenido_datos)<110)
				{
					//$pdf->Cell(190,5,''.utf8_decode("".$datos_otros_conocimentos[$i]['descripcion']."").'',0,1,'0');
					$pdf->Cell(190,5,''.utf8_decode("".$datos_otros_conocimentos[$i]['descripcion']."").'',0,1,'0');
				}
				else
				{
					$partes=explode(" ",$contenido_datos);
					foreach ($partes as $key ) {
						if(strlen($datos_imprimir)>100)
						{
							$pdf->Cell(190,5,''.utf8_decode("".$datos_imprimir."").'',0,1,'0');
							$variable_bandera=1;
							$datos_imprimir="";
						}
						else
						{
							$datos_imprimir=$datos_imprimir." ".$key;
							$variable_bandera=0;
						}
					}
				}
			}
	}
	else
	{
		$pdf->Cell(190,5,''.utf8_decode("Sin información").'',0,1,'0');
	}
}
?>
