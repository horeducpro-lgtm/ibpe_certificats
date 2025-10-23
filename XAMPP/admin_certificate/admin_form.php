<form action="generate_certificate.php" method="POST">
  <label>Nom complet :</label><br>
  <input type="text" name="nom" required><br><br>

  <label>Date de délivrance :</label><br>
  <input type="date" name="date" required><br><br>

  <label>Type de document :</label><br>
  <select name="type">
    <option value="diplome">Diplôme</option>
    <option value="attestation">Attestation</option>
    <option value="certificat">Certificat</option>
  </select><br><br>

  <input type="submit" value="📄 Générer le document IBPE">
</form>
