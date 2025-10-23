<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header('Location: login.php');
  exit;
}

require('config.php');

// 🔍 Construction dynamique de la requête SQL
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
} elseif (!empty($_GET['date_start'])) {
  $where[] = "DATE(timestamp) >= ?";
  $params[] = $_GET['date_start'];
  $types .= 's';
} elseif (!empty($_GET['date_end'])) {
  $where[] = "DATE(timestamp) <= ?";
  $params[] = $_GET['date_end'];
  $types .= 's';
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

// 📊 Préparer les données pour les graphiques
$stats = [];
$adminStats = [];
$actionStats = [];

foreach ($result as $row) {
  $date = substr($row['timestamp'], 0, 10);
  $stats[$date] = ($stats[$date] ?? 0) + 1;

  $admin = $row['admin_user'];
  $adminStats[$admin] = ($adminStats[$admin] ?? 0) + 1;

  $action = $row['action'];
  $actionStats[$action] = ($actionStats[$action] ?? 0) + 1;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Historique des modifications IBPE</title>
  <script src="https://code.highcharts.com/highcharts.js"></script>
  <script src="https://code.highcharts.com/modules/exporting.js"></script>
  <script src="https://code.highcharts.com/modules/export-data.js"></script>
  <script src="https://code.highcharts.com/modules/accessibility.js"></script>
  <style>
    body { font-family: Arial, sans-serif; margin: 40px; }
    table { border-collapse: collapse; width: 100%; }
    th, td { border: 1px solid #ccc; padding: 8px; text-align: left; vertical-align: top; }
    th { background-color: #f2f2f2; }
    a { color: #0066cc; text-decoration: none; }
    a:hover { text-decoration: underline; }
    .filter-form, .export-form { margin-bottom: 20px; }
  </style>
</head>
<body>

<h1>📜 Historique des modifications IBPE</h1>

<!-- ✅ Formulaire de filtre -->
<form method="GET" class="filter-form">
  <label>Admin :</label>
  <input type="text" name="admin" value="<?= htmlspecialchars($_GET['admin'] ?? '') ?>">

  <label>Action :</label>
  <select name="action">
    <option value="">-- Tous --</option>
    <option value="modification" <?= ($_GET['action'] ?? '') === 'modification' ? 'selected' : '' ?>>Modification</option>
    <option value="suppression" <?= ($_GET['action'] ?? '') === 'suppression' ? 'selected' : '' ?>>Suppression</option>
  </select>

  <label>Du :</label>
  <input type="date" name="date_start" value="<?= htmlspecialchars($_GET['date_start'] ?? '') ?>">

  <label>Au :</label>
  <input type="date" name="date_end" value="<?= htmlspecialchars($_GET['date_end'] ?? '') ?>">

  <input type="submit" value="Filtrer">
</form>

<!-- 📤 Export CSV avec filtres -->
<form method="GET" action="export_audit_csv.php" class="export-form">
  <input type="hidden" name="admin" value="<?= htmlspecialchars($_GET['admin'] ?? '') ?>">
  <input type="hidden" name="action" value="<?= htmlspecialchars($_GET['action'] ?? '') ?>">
  <input type="hidden" name="date_start" value="<?= htmlspecialchars($_GET['date_start'] ?? '') ?>">
  <input type="hidden" name="date_end" value="<?= htmlspecialchars($_GET['date_end'] ?? '') ?>">
  <input type="submit" value="📤 Exporter en CSV">
</form>

<!-- 🧾 Export PDF (préparé) -->
<form method="GET" action="export_audit_pdf.php" class="export-form">
  <input type="submit" value="🧾 Exporter en PDF">
</form>

<!-- 📊 Graphique par date -->
<div id="chart-container" style="height: 400px; margin-bottom: 40px;"></div>
<script>
Highcharts.chart('chart-container', {
  chart: { type: 'column' },
  title: { text: '📊 Activité des modifications IBPE' },
  xAxis: {
    categories: <?= json_encode(array_keys($stats)) ?>,
    title: { text: 'Date' }
  },
  yAxis: {
    title: { text: 'Nombre de modifications' }
  },
  series: [{
    name: 'Modifications',
    data: <?= json_encode(array_values($stats)) ?>
  }],
  exporting: { enabled: true }
});
</script>

<!-- 👤 Graphique par utilisateur -->
<div id="chart-admin" style="height: 400px; margin-bottom: 40px;"></div>
<script>
Highcharts.chart('chart-admin', {
  chart: { type: 'bar' },
  title: { text: '👤 Activité par administrateur' },
  xAxis: {
    categories: <?= json_encode(array_keys($adminStats)) ?>,
    title: { text: 'Administrateur' }
  },
  yAxis: {
    title: { text: 'Nombre d’actions' }
  },
  series: [{
    name: 'Actions',
    data: <?= json_encode(array_values($adminStats)) ?>
  }],
  exporting: { enabled: true }
});
</script>

<!-- 🛠️ Graphique par type d’action -->
<div id="chart-action" style="height: 400px; margin-bottom: 40px;"></div>
<script>
Highcharts.chart('chart-action', {
  chart: { type: 'pie' },
  title: { text: '🛠️ Répartition des types d’action' },
  series: [{
    name: 'Actions',
    colorByPoint: true,
    data: <?= json_encode(array_map(function($k, $v) {
      return ['name' => ucfirst($k), 'y' => $v];
    }, array_keys($actionStats), array_values($actionStats))) ?>
  }],
  exporting: { enabled: true }
});
</script>

<!-- 📋 Tableau des logs -->
<table>
  <tr>
    <th>ID</th>
    <th>Certificat</th>
    <th>Action</th>
    <th>Détails</th>
    <th>Admin</th>
    <th>Date</th>
  </tr>

  <?php foreach ($result as $row) { ?>
    <tr>
      <td><?= $row['id'] ?></td>
      <td>
        <a href="verifier.php?code=<?= htmlspecialchars($row['certificat_id']) ?>" target="_blank">
          Certificat #<?= $row['certificat_id'] ?>
        </a>
      </td>
      <td><?= ucfirst($row['action']) ?></td>
      <td>
        <?php
          $details = htmlspecialchars($row['details']);
          $details = str_replace(",", "<br>", $details);
          echo nl2br($details);
        ?>
      </td>
      <td><?= htmlspecialchars($row['admin_user']) ?></td>
      <td><?= $row['timestamp'] ?></td>
    </tr>
  <?php } ?>
