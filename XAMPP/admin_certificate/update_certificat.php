<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header('Location: login.php');
  exit;
}

require('config.php');
require('fpdf/fpdf.php');
require('fpdi/src/autoload.php');
require('phpqrcode/qrlib.php');
use setasign\Fpdi\Fpdi;

// 1. Récupérer les données
$id = $_POST['id'];
$nom = $_POST['nom'];
$date = $_POST['date'];
$type = $_POST['type'];

// 2. Recalculer le numéro (optionnel : ici on garde l'ancien)
$stmt = $conn->prepare("SELECT numero FROM certificats WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($numero);
$stmt->fetch();
$stmt->close();

// 3. Régénérer le QR
$url = "https://ibpe-validation.com/verifier.php?code=$numero";
$qrPath = "qr/$numero.png";
QRcode::png($url, $qrPath);

// 4. Choisir le modèle PDF
$model = ($type == 'diplome') ? 'modele_diplome_ibpe.pdf' :
         (($type == 'attestation') ? 'modele_attestation.pdf' : 'modele_certificat.pdf');

// 5. Recréer le PDF
$pdf = new FPDI();
$pdf->AddPage();
$pdf->setSourceFile($model);
$tpl = $pdf->importPage(1);
$pdf->useTemplate($tpl);
$pdf->Image($qrPath, 160, 230, 30, 30);
$pdf->SetFont('Arial','B',12);
$pdf->SetXY(20, 250);
$pdf->Cell(0, 10, "Nom : $nom | Date : $date | Numéro : $numero", 0, 1);

$pdfPath = "pdf/$type-$numero.pdf";
$pdf->Output('F', $pdfPath);

// 6. Mettre à jour la base
$stmt = $conn->prepare("UPDATE certificats SET nom = ?, date = ?, type = ?, qr_path = ?, pdf_path = ? WHERE id = ?");
$stmt->bind_param("sssssi", $nom, $date, $type, $qrPath, $pdfPath, $id);
$stmt->execute();
$stmt->close();

header("Location: admin_dashboard.php");
exit;
