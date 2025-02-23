<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement PDF</title>
</head>
<body>
    <h1>Informations du Paiement</h1>
    <p>Montant: {{ $paiement->montant }}</p>
    <p>Mode de Paiement: {{ $paiement->mode_paiement }}</p>
    <p>Référence: {{ $paiement->reference }}</p>
    <p>Statut: {{ $paiement->statut }}</p>
    <p>Date de Paiement: {{ $paiement->date_paiement }}</p>
</body>
</html>