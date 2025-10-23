<?php
require('config.php');
$result = $conn->query("SELECT * FROM audit_log ORDER BY timestamp DESC");
?>

<table border="1" cellpadding="5" cellspacing="0">
  <tr>
    <th>ID</th>
    <th>Certificat</th>
    <th>Action</th>
    <th>Détails</th>
    <th>Admin</th>
    <th>Date</th>
  </tr>
  <?php while ($row = $result->fetch_assoc()) { ?>
    <tr>
      <td><?= $row['id'] ?></td>
      <td><?= $row['certificat_id'] ?></td>
      <td><?= ucfirst($row['action']) ?></td>
      <td><?= nl2br(htmlspecialchars($row['details'])) ?></td>
      <td><?= htmlspecialchars($row['admin_user']) ?></td>
      <td><?= $row['timestamp'] ?></td>
    </tr>
  <?php } ?>
</table>
