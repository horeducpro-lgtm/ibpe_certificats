$pdf->Cell(0, 10, 'Attestation de validation IBPE', 0, 1, 'C');
$pdf->MultiCell(0, 10, "Nom : {$row['nom']}\nNé le : [DATE]\nPasseport : [ID]\nRésultat : Haute Distinction\nSpécialité : {$row['programme']}", 0, 'L');
