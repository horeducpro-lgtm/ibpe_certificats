<?php
require('config.php');
$code = $_GET['code'] ?? '';

$stmt = $conn->prepare("SELECT nom, date, type FROM certificats WHERE numero = ?");
$stmt->bind_param("s", $code);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
  $stmt->bind_result($nom, $date, $type);
  $stmt->fetch();
  echo "<h1>✅ Certificat IBPE valide</h1>";
  echo "<p>Nom : $nom<br>Date : $date<br>Type : $type<br>Numéro : $code</p>";
} else {
  echo "<h1>❌ Certificat introuvable</h1>";
  echo "<p>Numéro : $code</p>";
}
$stmt->close();
?>
