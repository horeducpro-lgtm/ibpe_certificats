<?php
require('config.php');

$where = [];
$params = [];
$types = '';

if (!empty($_GET['admin'])) {
  $where[] = "admin_user LIKE ?";
  $params[] = "%" . $_GET['admin'] . "%";
  $types .= 's';
}
if (!empty($_GET['action'])) {
  $where[] = "action = ?";
  $params[] = $_GET['action'];
  $types .= 's';
}
if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
  $where[] = "DATE(timestamp) BETWEEN ? AND ?";
  $params[] = $_GET['date_start'];
  $params[] = $_GET['date_end'];
  $types .= 'ss';
}

$sql = "SELECT * FROM audit_log";
if ($where) {
  $sql .= " WHERE " . implode(" AND ", $where);
}
$sql .= " ORDER BY timestamp DESC";

$stmt = $conn->prepare($sql);
if ($params) {
  $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="audit_log.csv"');

$output = fopen('php://output', 'w');
fputcsv($output, ['ID', 'Certificat', 'Action', 'Détails', 'Admin', 'Date']);

while ($row = $result->fetch_assoc()) {
  fputcsv($output, [
    $row['id'],
    $row['certificat_id'],
    $row['action'],
    $row['details'],
    $row['admin_user'],
    $row['timestamp']
  ]);
}
fclose($output);
exit;
composer require dompdf/dompdf
