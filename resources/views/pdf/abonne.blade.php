<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Abonné PDF</title>
</head>
<body>
    <h1>Informations de l'Abonné</h1>
    <p>Nom: {{ $abonne->nom }}</p>
    <p>Prénom: {{ $abonne->prenom }}</p>
    <p>Email: {{ $abonne->email }}</p>
    <p>Ville: {{ $abonne->ville }}</p>
</body>
</html>