<?php
// Go to 1.5 cm from bottom
$pdf->SetY(0);
    // Select Arial italic 8
$pdf->SetFont('Arial','I',8);
    // Print centered page number
$pdf->Cell(0,10,''.utf8_decode('Página ').''.$pdf->PageNo(),0,0,'R');
?>