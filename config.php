<?php
$conn = new mysqli("localhost", "root", "", "ibpe_certificats");
if ($conn->connect_error) {
  die("Erreur de connexion : " . $conn->connect_error);
}
?>
