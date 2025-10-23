<?php
require('config.php');
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="certificats_ibpe.csv"');

$output = fopen('php://output', 'w');
fputcsv($output, ['ID', 'Nom', 'Date', 'Type', 'Numéro', 'QR', 'PDF']);

$result = $conn->query("SELECT * FROM certificats ORDER BY id DESC");
while ($row = $result->fetch_assoc()) {
  fputcsv($output, [
    $row['id'],
    $row['nom'],
    $row['date'],
    $row['type'],
    $row['numero'],
    $row['qr_path'],
    $row['pdf_path']
  ]);
}
fclose($output);
exit;
?>
