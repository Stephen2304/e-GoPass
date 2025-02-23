<!-- resources/views/pdf/paiements.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Liste des Paiements</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Liste des Paiements</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Montant</th>
                <th>Mode de Paiement</th>
                <th>Statut</th>
                <th>Date de Création</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($paiements as $paiement)
                <tr>
                    <td>{{ $paiement->id }}</td>
                    <td>{{ $paiement->montant }}</td>
                    <td>{{ $paiement->mode_paiement }}</td>
                    <td>{{ $paiement->statut }}</td>
                    <td>{{ $paiement->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>