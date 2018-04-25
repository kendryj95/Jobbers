<?php
require('fpdf/fpdf.php');
require_once '../classes/DatabasePDOInstance.function.php';
require_once '../slug.function.php';
include('includes/sql.php');

$pdf = new FPDF();
$pdf->AddPage();

include('includes/logo_jobbers.php');
//Pie cabecera
include('includes/header.php');
validar($pdf);
//Información general;
include('includes/inf_general.php');
validar($pdf);
//Información general;
include('includes/experiencia.php');
validar($pdf);
//Información general;
include('includes/idiomas.php');
validar($pdf);

//Información estudos;
include('includes/estudios.php');
validar($pdf);
//Otros conocimeintos
include('includes/otros_conocimientos.php');
validar($pdf);
//Información extra
include('includes/info_extra.php');
//Logo jobbers
//Pie depagina
include('includes/fotter.php');

function validar($pdf)
{
	if($pdf->GetY()>220)
	{
		$pdf->AddPage();
	}
}
$pdf->Output();
?>
