<?php
session_start();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $user = $_POST['username'];
  $pass = $_POST['password'];

  // Identifiants IBPE (à personnaliser)
  if ($user === 'admin' && $pass === 'ibpe2025') {
    $_SESSION['admin'] = true;
    header('Location: admin_dashboard.php');
    exit;
  } else {
    $error = "Identifiants incorrects.";
  }
}
?>

<h2>🔐 Connexion IBPE</h2>
<form method="POST">
  <label>Nom d'utilisateur :</label><br>
  <input type="text" name="username" required><br><br>

  <label>Mot de passe :</label><br>
  <input type="password" name="password" required><br><br>

  <input type="submit" value="Se connecter">
</form>

<p style="color:red"><?= $error ?></p>
