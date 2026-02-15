<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fiche de Décharge - {{ $sortie->numero_bon_decharge }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
            padding: 20px;
        }

        .header {
            text-align: center;
            border-bottom: 3px solid #000;
            padding-bottom: 15px;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 24px;
            color: #d9534f;
            margin-bottom: 5px;
        }

        .header .subtitle {
            font-size: 14px;
            color: #666;
        }

        .info-box {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 20px;
            background-color: #f9f9f9;
        }

        .info-box h3 {
            font-size: 14px;
            margin-bottom: 10px;
            color: #d9534f;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .info-label {
            font-weight: bold;
            width: 35%;
        }

        .info-value {
            width: 65%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        table th {
            background-color: #d9534f;
            color: white;
            font-weight: bold;
        }

        .signature-section {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
        }

        .signature-box {
            width: 45%;
            text-align: center;
        }

        .signature-box .title {
            font-weight: bold;
            margin-bottom: 40px;
        }

        .signature-box .line {
            border-top: 1px solid #000;
            margin-top: 50px;
            padding-top: 5px;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>

<body>
    <!-- En-tête -->
    <div class="header">
        <h1>FICHE DE DÉCHARGE</h1>
        <p class="subtitle">Bon N° {{ $sortie->numero_bon_decharge }}</p>
    </div>

    <!-- Informations Générales -->
    <div class="info-box">
        <h3>Informations de la Sortie</h3>
        <div class="info-row">
            <span class="info-label">Code Sortie :</span>
            <span class="info-value">{{ $sortie->code_sortie }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Date :</span>
            <span class="info-value">{{ $sortie->created_at->format('d/m/Y à H:i') }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Nature de Sortie :</span>
            <span class="info-value">{{ $sortie->nature_sortie }}</span>
        </div>
    </div>

    <!-- Article -->
    <div class="info-box">
        <h3>Article</h3>
        <div class="info-row">
            <span class="info-label">Code Article :</span>
            <span class="info-value">{{ $sortie->unite->code_unite }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Désignation :</span>
            <span class="info-value">{{ $sortie->unite->designation }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Catégorie :</span>
            <span class="info-value">{{ $sortie->unite->categorie->libelle }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Magasin :</span>
            <span class="info-value">{{ $sortie->unite->magasin->nom_magasin }}</span>
        </div>
    </div>

    <!-- Quantité -->
    <table>
        <thead>
            <tr>
                <th>Quantité Sortie</th>
                <th>Unité de Mesure</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="font-size: 18px; font-weight: bold; color: #d9534f;">{{ number_format($sortie->quantite, 2) }}</td>
                <td>{{ $sortie->unite->unite_mesure }}</td>
            </tr>
        </tbody>
    </table>

    <!-- Employé -->
    @if($sortie->employe)
    <div class="info-box">
        <h3>Bénéficiaire</h3>
        <div class="info-row">
            <span class="info-label">Nom Complet :</span>
            <span class="info-value">{{ $sortie->employe->nom_complet }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Matricule :</span>
            <span class="info-value">{{ $sortie->employe->matricule }}</span>
        </div>
        @if($sortie->employe->direction)
        <div class="info-row">
            <span class="info-label">Direction :</span>
            <span class="info-value">{{ $sortie->employe->direction->nom_direction }}</span>
        </div>
        @endif
        @if($sortie->employe->poste)
        <div class="info-row">
            <span class="info-label">Poste :</span>
            <span class="info-value">{{ $sortie->employe->poste }}</span>
        </div>
        @endif
    </div>
    @endif

    <!-- Signatures -->
    <div class="signature-section">
        <div class="signature-box">
            <div class="title">Délivré par</div>
            <div class="line">{{ $sortie->user->name }}</div>
        </div>
        <div class="signature-box">
            <div class="title">Reçu par</div>
            <div class="line">{{ $sortie->employe?->nom_complet ?? '........................' }}</div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Document généré le {{ now()->format('d/m/Y à H:i') }}</p>
        <p>Système de Gestion de Stock</p>
    </div>
</body>

</html>