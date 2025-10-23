document.getElementById('verifyForm')?.addEventListener('submit', function(e) {
  e.preventDefault();
  const certNumber = document.getElementById('certNumber').value.trim();
  const result = document.getElementById('result');

  const validCertificates = {
    "IBPE2025-001": "Master Pro en Management Industriel",
    "IBPE2025-002": "Licence QHSE"
  };

  if (validCertificates[certNumber]) {
    result.innerHTML = `<p style="color:green;">✅ Certificat valide – ${validCertificates[certNumber]}</p>`;
  } else {
    result.innerHTML = `<p style="color:red;">❌ Certificat introuvable.</p>`;
  }
});
