
<!-- <!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste de tous les paiements des dettes</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="flex items-center justify-center h-screen bg-gray-100">
    <div class="bg-gray-300 p-12 rounded-lg shadow-lg w-full max-w-4xl">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-black font-bold text-2xl">Liste Paiements d'une Dette</h2>
            <button class="text-red-500 font-bold text-2xl">&times;</button>
        </div>
        <div class="grid grid-cols-3 gap-6 mb-6">
            <div>
                <label class="block text-black font-bold mb-2">Client :</label>
                <input type="text" class="w-full px-4 py-3 border rounded"  value="<?=$data->prenom ." ". $data->nom?>" disabled>
            </div>
            <div>
                <label class="block text-black font-bold mb-2">Montant Total :</label>
                <input type="text" class="w-full px-4 py-3 border rounded" disabled value="<?=$client->montant?>">
            </div>
            <div>
                <label class="block text-black font-bold mb-2">Montant Restant :</label>
                <input type="text" class="w-full px-4 py-3 border rounded" disabled value="<?=$client->montantRestant?>">
            </div>
        </div>
        <div class="mb-6">
            <table class="min-w-full bg-white rounded-lg shadow-md"> 
                <thead>
                    <tr class="bg-blue-200">
                        <th class="py-3 px-4 text-left">Date</th>
                        <th class="py-3 px-4 text-left">Montant</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($data as $paiment): ?>
                        <tr>
                            <td class="border-t py-3 px-4"><?=$paiment->date?></td>
                            <td class="border-t py-3 px-4"><?=$paiment->montant?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="mb-6">
            <label class="block text-black font-bold mb-2">Montant Versé :</label>
            <input type="text" class="w-full px-4 py-3 border rounded" disabled value="<?=$client->montantVerser?>">
        </div>
    </div>
</body>

</html> -->

<?php
// Vérifiez que les variables sont définies avant de les utiliser
if (isset($data) && isset($client)) {
    // Affichez les données du paiement et du client
    foreach ($data as $paiement) {
        echo "Paiement ID: " . htmlspecialchars($paiement['id']) . "<br>";
        echo "Montant: " . htmlspecialchars($paiement['montant']) . "<br>";
        echo "Date: " . htmlspecialchars($paiement['date']) . "<br>";
        // Affichez les informations du client ici
        echo "Client: " . htmlspecialchars($client['nom']) . " " . htmlspecialchars($client['prenom']) . "<br>";
    }
} else {
    echo "Aucune donnée de paiement ou de client trouvée.";
}
?>
