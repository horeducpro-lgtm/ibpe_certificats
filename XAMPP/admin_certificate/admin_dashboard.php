<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header('Location: login.php');
  exit;
}

require('config.php');

// 🔍 Recherche
$search = $_GET['search'] ?? '';
if ($search) {
  $stmt = $conn->prepare("SELECT * FROM certificats WHERE nom LIKE ? OR numero LIKE ? ORDER BY id DESC");
  $like = "%$search%";
  $stmt->bind_param("ss", $like, $like);
  $stmt->execute();
  $result = $stmt->get_result();
} else {
  $result = $conn->query("SELECT * FROM certificats ORDER BY id DESC");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Tableau de bord IBPE</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 40px; }
    table { border-collapse: collapse; width: 100%; }
    th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
    th { background-color: #f2f2f2; }
    form.inline { display: inline; }
    .top-bar { margin-bottom: 20px; }
  </style>
</head>
<body>

<h1>📋 Tableau de bord IBPE</h1>

<div class="top-bar">
  <!-- 📤 Export CSV -->
  <form method="POST" action="export_csv.php" class="inline">
    <input type="submit" value="📤 Exporter en CSV">
  </form>

  <!-- 🔍 Recherche -->
  <form method="GET" class="inline" style="margin-left: 20px;">
    <input type="text" name="search" placeholder="🔍 Rechercher par nom ou numéro" value="<?= htmlspecialchars($search) ?>">
    <input type="submit" value="Rechercher">
  </form>

  <!-- 🚪 Déconnexion -->
  <form method="POST" action="logout.php" class="inline" style="margin-left: 20px;">
    <input type="submit" value="🚪 Déconnexion">
  </form>
</div>

<table>
  <tr>
    <th>ID</th>
    <th>Nom</th>
    <th>Date</th>
    <th>Type</th>
    <th>Numéro</th>
    <th>QR</th>
    <th>PDF</th>
    <th>Vérifier</th>
    <th>🗑️ Supprimer</th>
  </tr>

  <?php while ($row = $result->fetch_assoc()) { ?>
    <tr>
      <td><?= $row['id'] ?></td>
      <td><?= htmlspecialchars($row['nom']) ?></td>
      <td><?= $row['date'] ?></td>
      <td><?= strtoupper($row['type']) ?></td>
      <td><?= $row['numero'] ?></td>
      <td><img src="<?= $row['qr_path'] ?>" width="50"></td>
      <td><a href="<?= $row['pdf_path'] ?>" target="_blank">📄 Télécharger</a></td>
      <td><a href="verifier.php?code=<?= $row['numero'] ?>" target="_blank">🔍 Vérifier</a></td>
      <td>
        <form method="POST" action="delete_certificat.php" onsubmit="return confirm('Supprimer ce certificat ?');">
          <input type="hidden" name="id" value="<?= $row['id'] ?>">
          <input type="submit" value="🗑️">
        </form>
      </td>
    </tr>
  <?php } ?>
</table>

</body>
</html>
