<?php
require 'config.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Administration IBPE – Ajouter un certificat</title>
    <link rel="stylesheet" href="css/style.css"> <!-- Tu peux styliser ici -->
    <style>
        body { font-family: Arial; background: #f4f4f4; padding: 40px; }
        h2 { color: #2c3e50; }
        form { background: #fff; padding: 20px; border-radius: 8px; max-width: 500px; margin: auto; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        label { font-weight: bold; display: block; margin-top: 15px; }
        input, select { width: 100%; padding: 8px; margin-top: 5px; }
        button { margin-top: 20px; padding: 10px 20px; background: #2980b9; color: white; border: none; border-radius: 4px; cursor: pointer; }
        .message { text-align: center; margin-top: 20px; font-weight: bold; }
    </style>
</head>
<body>

<h2>Ajouter un certificat IBPE</h2>

<form method="POST">
    <label>Nom du candidat :</label>
    <input type="text" name="nom" required>

    <label>Numéro de certificat :</label>
    <input type="text" name="numero" required>

    <label>Programme :</label>
    <input type="text" name="programme" required>

    <label>Date d'obtention :</label>
    <input type="date" name="date" required>

    <button type="submit">Ajouter le certificat</button>
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $numero = $_POST['numero'];
    $programme = $_POST['programme'];
    $date = $_POST['date'];

    $sql = "INSERT INTO certificats (nom, numero, programme, date_obtention) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $nom, $numero, $programme, $date);

    if ($stmt->execute()) {
        echo "<div class='message' style='color:green;'>✅ Certificat ajouté avec succès.</div>";
    } else {
        echo "<div class='message' style='color:red;'>❌ Erreur : " . $stmt->error . "</div>";
    }

    $stmt->close();
}
$conn->close();
?>

</body>
</html>
