<?php
require('fpdf/fpdf.php');
require('phpqrcode/qrlib.php');

// Données du certificat (à automatiser plus tard)
$nom = "Adnane";
$programme = "Master Professionnel en Management Industriel";
$date = "2025-10-20";
$numero = "IBPE-2025-001";

// Générer le QR code
$qrText = "http://localhost/ibpe-site/verifier.php?code=" . urlencode($numero);
QRcode::png($qrText, "assets/qr.png");

// Créer le PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(0,10,"Certificat de Reconnaissance Professionnelle",0,1,'C');
$pdf->Ln(10);
$pdf->SetFont('Arial','',12);
$pdf->Cell(0,10,"Nom du candidat : $nom",0,1);
$pdf->Cell(0,10,"Programme : $programme",0,1);
$pdf->Cell(0,10,"Date d'obtention : $date",0,1);
$pdf->Cell(0,10,"Numéro de certificat : $numero",0,1);
$pdf->Ln(20);
$pdf->Image("assets/seaux.png", 10, 150, 60); // Sceau institutionnel
$pdf->Image("assets/qr.png", 150, 150, 40);   // QR code
$pdf->Output();
?>
