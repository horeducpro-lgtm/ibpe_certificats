<?php
require('config.php'); // Connexion MySQL
require('fpdf/fpdf.php');
require('fpdi/src/autoload.php');
require('phpqrcode/qrlib.php');
use setasign\Fpdi\Fpdi;

// 1. Récupérer les données du formulaire
$nom = $_POST['nom'];
$date = $_POST['date'];
$type = $_POST['type'];

// 2. Générer le numéro de série
$prefix = strtoupper(substr($type, 0, 3)); // DIP, ATT, CER
$numero = "IBPE-" . date('Y') . "-" . rand(100,999) . "-" . $prefix;

// 3. Générer le QR code
$url = "https://ibpe-validation.com/verifier.php?code=$numero";
$qrPath = "qr/$numero.png";
QRcode::png($url, $qrPath);

// 4. Choisir le modèle PDF
$model = ($type == 'diplome') ? 'modele_diplome_ibpe.pdf' :
         (($type == 'attestation') ? 'modele_attestation.pdf' : 'modele_certificat.pdf');

// 5. Créer le PDF
$pdf = new FPDI();
$pdf->AddPage();
$pdf->setSourceFile($model);
$tpl = $pdf->importPage(1);
$pdf->useTemplate($tpl);
$pdf->Image($qrPath, 160, 230, 30, 30);
$pdf->SetFont('Arial','B',12);
$pdf->SetXY(20, 250);
$pdf->Cell(0, 10, "Nom : $nom | Date : $date | Numéro : $numero", 0, 1);

// 6. Sauvegarder le PDF
$pdfPath = "pdf/$type-$numero.pdf";
$pdf->Output('F', $pdfPath);

// ✅ 7. ENREGISTRER DANS LA BASE DE DONNÉES (ici !)
$stmt = $conn->prepare("INSERT INTO certificats (nom, date, type, numero, qr_path, pdf_path) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $nom, $date, $type, $numero, $qrPath, $pdfPath);
$stmt->execute();
$stmt->close();

// 8. Afficher le lien de téléchargement
echo "✅ Document IBPE généré : <a href='$pdfPath' target='_blank'>Télécharger</a>";
?>
