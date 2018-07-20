<?php
$pdf->ln();$pdf->ln();$pdf->ln();
$pdf->SetFont('Arial','',10); 
$pdf->SetTextColor(0,0,0);  // Establece el color del texto (en este caso es blanco) 
$pdf->SetFillColor(232, 232, 232);  
$pdf->Cell(190,5,''.utf8_decode("INFORMACIÓN GENERAL").'',0,1,'C','true');

$pdf->SetFont('Arial','B',8); 
$pdf->SetFillColor(255, 255, 255);  
$pdf->Cell(85,4,''.utf8_decode("DNI:").'',0,1,'L','true');
$pdf->Cell(85,4,''.utf8_decode("Nº CUIL:").'',0,1,'L','true');
$pdf->Cell(85,4,''.utf8_decode("LUGAR DE NACIMIENTO:").'',0,1,'L','true');
$pdf->Cell(85,4,''.utf8_decode("DIRECCIÓN DE DOMICILIO:").'',0,1,'L','true');
$pdf->Cell(85,4,''.utf8_decode("FECHA DE NACIMIENTO:").'',0,1,'L','true');
$pdf->Cell(85,4,''.utf8_decode("EDAD:").'',0,1,'L','true');
$linea=4;
$pdf->SetFont('Arial','',8); 
$pdf->Text(18,56,"".$datos_trabajadores[0]['numero_documento_identificacion'].""); 
$pdf->Text(23,56+$linea,"".$datos_trabajadores[0]['cuil'].""); 
$linea=$linea+4;
$pdf->Text(46,56+$linea,"".utf8_decode( mb_strtoupper($datos_direccion[0]['localidad'] . ' / ' . $datos_direccion[0]['provincia'] . ' / ' . $datos_direccion[0]['pais'])).""); 
$linea=$linea+4;
$pdf->Text(49,56+$linea,"".utf8_decode( mb_strtoupper($datos_direccion[0]['calle'])).""); 
$linea=$linea+4;
$pdf->Text(46,56+$linea,"".$datos_trabajadores[0]['fecha_n'].""); 
$linea=$linea+4;
$pdf->Text(20,56+$linea," ".utf8_decode(''.$datos_trabajadores[0]['edad'].' años')." ");  

$pdf->Text(43,288,"".utf8_decode('Cree en tí, como creemos nosotros. Jobbers el mejor portal para encontrar lo que buscas.').""); 
?>