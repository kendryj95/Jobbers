<?php
// Go to 1.5 cm from bottom
$pdf->SetY(0);
    // Select Arial italic 8
$pdf->SetFont('Arial','I',8);
    // Print centered page number
$pdf->Cell(0,10,''.utf8_decode('Página ').''.$pdf->PageNo(),0,0,'R');
$pdf->Image('http://www.jobbersargentina.net/img/logo_d.png' , 77 ,272, 50 , 15,'PNG', '');
$pdf->SetFont('Arial','',8); 
$pdf->Text(43,288,"".utf8_decode('Cree en tí, como creemos nosotros. Jobbers el mejor portal para encontrar lo que buscas.').""); 
?>