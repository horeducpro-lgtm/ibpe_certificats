<?php
require('fpdf/fpdf.php');
require('fpdi/src/autoload.php');
use setasign\Fpdi\Fpdi;

$numero = "IBPE-2025-081";
$qrPath = "qr/$numero.png";

$pdf = new FPDI();
$pdf->AddPage();
$pdf->setSourceFile('modele_diplome_ibpe.pdf');
$tpl = $pdf->importPage(1);
$pdf->useTemplate($tpl);

$pdf->Image($qrPath, 160, 230, 30, 30);
$pdf->SetFont('Arial','B',12);
$pdf->SetXY(20, 250);
$pdf->Cell(0, 10, "Numéro de série : $numero", 0, 1);

$pdf->Output('F', "pdf/diplome_$numero.pdf");
echo "✅ Diplôme généré avec QR pour $numero";
?>
