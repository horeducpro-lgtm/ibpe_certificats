<?php require('config/config.php'); ?>
<table>
<tr><th>Nom</th><th>Titre</th><th>Programme</th><th>Date</th><th>Numéro</th></tr>
<?php
$result = $conn->query("SELECT * FROM certificats");
while ($row = $result->fetch_assoc()) {
  echo "<tr><td>{$row['nom']}</td><td>{$row['titre']}</td><td>{$row['programme']}</td><td>{$row['date_obtention']}</td><td>{$row['numero']}</td></tr>";
}
?>
</table>
