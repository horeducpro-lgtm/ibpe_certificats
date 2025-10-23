<?php
require 'config.php';

$code = $_GET['code'] ?? '';

if (empty($code)) {
  echo "<h2>Veuillez entrer un numéro de certificat.</h2>";
  exit;
}

$sql = "SELECT * FROM certificats WHERE numero = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $code);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  echo "<h2>✅ Certificat valide</h2>";
  echo "<p><strong>Nom :</strong> " . htmlspecialchars($row['nom']) . "</p>";
  echo "<p><strong>Programme :</strong> " . htmlspecialchars($row['programme']) . "</p>";
  echo "<p><strong>Date d'obtention :</strong> " . htmlspecialchars($row['date_obtention']) . "</p>";
} else {
  echo "<h2>❌ Aucun certificat trouvé pour ce numéro.</h2>";
}

$conn->close();
?>
