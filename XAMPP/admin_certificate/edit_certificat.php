<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header('Location: login.php');
  exit;
}

require('config.php');
$id = $_GET['id'] ?? null;

if (!$id) {
  echo "Certificat introuvable.";
  exit;
}

// Récupérer les données
$stmt = $conn->prepare("SELECT nom, date, type FROM certificats WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($nom, $date, $type);
$stmt->fetch();
$stmt->close();
?>

<h2>✏️ Modifier le certificat IBPE</h2>
<form method="POST" action="update_certificat.php">
  <input type="hidden" name="id" value="<?= $id ?>">

  <label>Nom :</label><br>
  <input type="text" name="nom" value="<?= htmlspecialchars($nom) ?>" required><br><br>

  <label>Date :</label><br>
  <input type="date" name="date" value="<?= $date ?>" required><br><br>

  <label>Type :</label><br>
  <select name="type">
    <option value="diplome" <?= $type === 'diplome' ? 'selected' : '' ?>>Diplôme</option>
    <option value="attestation" <?= $type === 'attestation' ? 'selected' : '' ?>>Attestation</option>
    <option value="certificat" <?= $type === 'certificat' ? 'selected' : '' ?>>Certificat</option>
  </select><br><br>

  <input type="submit" value="✅ Enregistrer les modifications">
</form>
