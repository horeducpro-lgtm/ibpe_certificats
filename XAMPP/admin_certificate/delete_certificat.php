<?php
require('config.php');
$id = $_POST['id'] ?? null;

if ($id) {
  $stmt = $conn->prepare("DELETE FROM certificats WHERE id = ?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $stmt->close();
}

header("Location: admin_dashboard.php");
exit;
?>
