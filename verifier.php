<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'] ?? '';
    $numero = $_POST['numero'] ?? '';
    $programme = $_POST['programme'] ?? '';
    $date = $_POST['date'] ?? '';

    if ($nom && $numero && $programme && $date) {
        $sql = "INSERT INTO certificats (nom, numero, programme, date_obtention) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $nom, $numero, $programme, $date);

        if ($stmt->execute()) {
            echo "<h3>✅ Certificat ajouté avec succès.</h3>";
        } else {
            echo "<h3>❌ Erreur : " . $stmt->error . "</h3>";
        }

        $stmt->close();
    } else {
        echo "<h3>⚠️ Tous les champs sont obligatoires.</h3>";
    }
}

$conn->close();
?>

<form method="POST">
    <label>Nom :</label><br>
    <input type="text" name="nom" required><br><br>

    <label>Numéro de certificat :</label><br>
    <input type="text" name="numero" required><br><br>

    <label>Programme :</label><br>
    <input type="text" name="programme" required><br><br>

    <label>Date d'obtention :</label><br>
    <input type="date" name="date" required><br><br>

    <button type="submit">Ajouter le certificat</button>
</form>
