<?php
	require('WriteHTML.php');

	$text = $_POST['doc'];
	// Creación del objeto de la clase heredada
	//$pdf = new PDF();
	$pdf = new PDF_HTML();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('Times','',12);
	$pdf->Cell(0,10,"$text",0,1);
	$pdf->Output();
?>