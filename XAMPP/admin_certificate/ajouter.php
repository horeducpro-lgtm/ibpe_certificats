<?php require('config/config.php'); ?>
<form method="POST">
  <input name="nom" placeholder="Nom" required>
  <input name="titre" placeholder="Titre" required>
  <input name="programme" placeholder="Programme" required>
  <input type="date" name="date_obtention" required>
  <input name="numero" placeholder="Numéro unique" required>
  <button type="submit">Ajouter</button>
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $stmt = $conn->prepare("INSERT INTO certificats (nom, titre, programme, date_obtention, numero) VALUES (?, ?, ?, ?, ?)");
  $stmt->bind_param("sssss", $_POST['nom'], $_POST['titre'], $_POST['programme'], $_POST['date_obtention'], $_POST['numero']);
  $stmt->execute();
  echo "✅ Certificat IBPE ajouté.";
}
?>
