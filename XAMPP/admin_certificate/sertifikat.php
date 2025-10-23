<?php 
require 'cert_config.php';
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ibpe_certificats";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}
?>
