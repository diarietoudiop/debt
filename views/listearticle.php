<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails des Articles de la Dette</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Détails des Articles de la Dette</h1>
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2 px-4 bg-gray-200">Nom de l'article</th>
                        <th class="py-2 px-4 bg-gray-200">Prix</th>
                        <th class="py-2 px-4 bg-gray-200">Quantité</th>
                        <th class="py-2 px-4 bg-gray-200">Montant</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Exemple de lignes d'articles -->
                    <tr>
                        <td class="border px-4 py-2">Article 1</td>
                        <td class="border px-4 py-2">1000 FCFA</td>
                        <td class="border px-4 py-2">2</td>
                        <td class="border px-4 py-2">2000 FCFA</td>
                    </tr>
                    <tr>
                        <td class="border px-4 py-2">Article 2</td>
                        <td class="border px-4 py-2">500 FCFA</td>
                        <td class="border px-4 py-2">3</td>
                        <td class="border px-4 py-2">1500 FCFA</td>
                    </tr>
                    <!-- Ajouter plus de lignes selon les articles -->
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
