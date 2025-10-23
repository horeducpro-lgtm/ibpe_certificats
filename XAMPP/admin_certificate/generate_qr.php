<?php
require('phpqrcode/qrlib.php');

$numero = "IBPE-2025-081";
$url = "https://ibpe-validation.com/verifier.php?code=$numero";
$path = 'qr/';
if (!file_exists($path)) { mkdir($path); }
QRcode::png($url, $path.$numero.".png");
echo "✅ QR généré pour $numero";
?>
