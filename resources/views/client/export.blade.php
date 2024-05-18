<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Devis</title>
    <style>
        /* Style pour la table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        /* Style pour l'en-tête de la table */
        th {
            background-color: #f2f2f2;
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        /* Style pour les cellules de la table */
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        /* Style pour chaque ligne impaire de la table */
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        /* Style pour la ligne du total */
        .total-row td:first-child {
            font-weight: bold;
            text-align: right;
        }

        .total-row td:last-child {
            font-weight: bold;
            text-align: right;
        }

        /* Style pour la section contenant les informations sur le devis */
        .devis-info {
            margin-bottom: 20px;
            display: flex;
            justify-content: center;
            align-content: center;
            align-items: center;
        }

        .devis-info h2 {
            margin: 0;
            color: #333;
        }

        .devis-info ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .devis-info ul li {
            margin-bottom: 5px;
            color: #666;
        }

        .devis-info strong {
            font-weight: bold;
            color: #000;
        }
    </style>
</head>
<body>

<div class="devis-info">
    <div>
        <div>
            <div>
                <h2>{{$total->reference}}</h2>
            </div>
            <ul>
                <li><strong>Type de maison :</strong> {{$total->maison}}</li>
                <li><strong>Type de finition :</strong> {{$total->finition}}</li>
                <li><strong>Date devis :</strong> {{$total->dateinsertion}}</li>
                <li><strong>Date debut :</strong> {{$total->datedebut}}</li>
                <li><strong>Date fin :</strong> {{$total->datefin}}</li>
            </ul>
        </div>
    </div>
</div>

<table>
    <thead>
    <h3>Detail</h3>
    <tr>
        <th>Code</th>
        <th>Designation</th>
        <th>Unite</th>
        <th>Quantite</th>
        <th>Prix</th>
        <th>Total</th>
    </tr>
    </thead>
    <tbody>
    @foreach($devis as $row)
        <tr>
            <td>{{ $row->code }}</td>
            <td>{{ $row->designation }}</td>
            <td>{{ $row->unite }}</td>
            <td>{{ $row->quantite }}</td>
            <td style="text-align: right">{{ number_format($row->prixunitaire, 2, ',', ' ') }} MGA</td>
            <td style="text-align: right">{{ number_format($row->montant, 2, ',', ' ') }} MGA</td>
        </tr>
    @endforeach
    <tr class="total-row">
        <td colspan="3">Total</td>
        <td colspan="3" style="text-align: right">{{ number_format($total->total, 2, ',', ' ') }} MGA</td>
    </tr>
    </tbody>
</table>
<h2>Liste Paiment</h2>
<table>
    <thead>
    <tr>
        <th>idpaiment</th>
        <th>Montant</th>
        <th>Date de paiment</th>
    </tr>
    </thead>
    <tbody>
    @foreach($paiment as $row)
        <tr>
            <td>{{$row->idpaiment}}</td>
            <td>{{ number_format($row->montant, 2, ',', ' ') }} MGA</td>
            <td>{{$row->datepaiment}}</td>
        </tr>
    @endforeach
    <tr class="total-row">
        <td colspan="1">Total</td>
        <td colspan="2" style="text-align: right">{{ number_format($total->payer, 2, ',', ' ') }} MGA</td>
    </tr>
    </tbody>
</table>

</body>
</html>
