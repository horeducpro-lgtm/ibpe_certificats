<?php
require('config/config.php');
require('fpdf/fpdf.php');

$code = $_GET['code'] ?? '';
$result = $conn->query("SELECT * FROM certificats WHERE numero = '$code'");
if (!$row = $result->fetch_assoc()) { die("Certificat introuvable."); }

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Image('assets/logo_ibpe.png',10,10,30);
$pdf->Cell(0, 40, 'Certificat de reconnaissance professionnelle', 0, 1, 'C');
$pdf->SetFont('Arial', '', 12);
$pdf->MultiCell(0, 10, "Ce certificat est décerné à :\n{$row['nom']}\n\nTitre : {$row['titre']}\nProgramme : {$row['programme']}\nDate : {$row['date_obtention']}\nNuméro : {$row['numero']}", 0, 'C');
$pdf->Image('assets/signature_ibpe.png',10,220,50);
$pdf->Output();
