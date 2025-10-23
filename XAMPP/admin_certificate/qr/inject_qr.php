<?php
require('../fpdf/fpdf.php');
require('../fpdi/src/autoload.php');
require('../phpqrcode/qrlib.php');

use setasign\Fpdi\Fpdi;

// Données
$numero = "IBPE-2025-081";
$url = "https://ibpe-validation.com/verifier.php?code=$numero";

// Générer le QR code
$path = 'temp/';
if (!file_exists($path)) { mkdir($path); }
$file = $path.$numero.".png";
QRcode::png($url, $file);

// Charger le modèle PDF
$pdf = new FPDI();
$pdf->AddPage();
$pdf->setSourceFile('../modele_diplome_ibpe.pdf');
$tpl = $pdf->importPage(1);
$pdf->useTemplate($tpl);

// Ajouter le QR code
$pdf->Image($file, 160, 230, 30, 30); // Ajuste la position selon ton modèle

// Ajouter le numéro de série
$pdf->SetFont('Arial','B',12);
$pdf->SetXY(20, 250); // Ajuste la position
$pdf->Cell(0, 10, "Numéro de série : $numero", 0, 1);

// Exporter le PDF final
$pdf->Output('I', "diplome_$numero.pdf");
