<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voyageur PDF</title>
</head>
<body>
    <h1>Informations du Voyageur</h1>
    <p>Nom: {{ $voyageur->nom }}</p>
    <p>Prénom: {{ $voyageur->prenom }}</p>
    <p>Post-nom: {{ $voyageur->post_nom }}</p>
    <p>Nationalité: {{ $voyageur->nationalite }}</p>
    <p>Numéro de Passeport: {{ $voyageur->numero_passport }}</p>
    <p>Compagnie Aérienne: {{ $voyageur->compagnie_aerienne }}</p>
    <p>Numéro de Vol: {{ $voyageur->numero_vol }}</p>
    <p>Provenance: {{ $voyageur->provenance }}</p>
    <p>Destination: {{ $voyageur->destination }}</p>
    <p>Téléphone: {{ $voyageur->telephone }}</p>
    <p>Email: {{ $voyageur->adresse_mail }}</p>
    <p>Adresse: {{ $voyageur->adresse_residence }}</p>
</body>
</html>