<!-- views/liste_dettes.php -->

<?php

use App\Core\Session;
use App\Model\DetteModel;

$detteModel = new DetteModel();
$data = $detteModel->detteClient(Session::get("client"));
$data = isset($data) && is_array($data) ? $data : [];

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Dettes</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans bg-gray-100 m-0 p-0">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="bg-teal-600 text-white w-64 flex-shrink-0 overflow-y-auto">
            <div class="p-4">
                <h2 class="text-2xl font-bold mb-6">Menu</h2>
                <nav>
                    <ul class="space-y-2">
                        <li><a href="http://www.diary.shop:8005" class="block py-2 px-4 hover:bg-gray-700 rounded">Accueil</a></li>
                        <li><a href="#" class="block py-2 px-4 hover:bg-gray-700 rounded">Clients</a></li>
                        <li><a href="#" class="block py-2 px-4 hover:bg-gray-700 rounded">Dettes</a></li>
                        <li><a href="#" class="block py-2 px-4 hover:bg-gray-700 rounded">Rapports</a></li>
                        <li><a href="#" class="block py-2 px-4 hover:bg-gray-700 rounded">Paramètres</a></li>
                    </ul>
                </nav>
            </div>
        </aside>

        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-indigo-800 text-white shadow-md">
                <div class="container mx-auto px-4 py-3 flex justify-between items-center">
                    <h1 class="text-2xl font-bold">Shop</h1>
                    <div class="flex items-center space-x-4">
                        <!-- Search Bar -->
                        <div class="relative">
                            <input type="text" class="bg-gray-100 text-gray-800 rounded-full py-2 pl-10 pr-4 focus:outline-none focus:bg-white" placeholder="Rechercher...">
                            <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <button class="bg-indigo-600 hover:bg-indigo-500 px-4 py-2 rounded">Notifications</button>
                        <div class="relative">
                            <img class="h-10 w-10 rounded-full" src="https://via.placeholder.com/40" alt="User avatar">
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100">
                <div class="container mx-auto px-6 py-8">
                    <div class="container w-4/5 mx-auto overflow-hidden p-5">
                        <h1 class="text-center text-2xl font-bold text-gray-800 mb-6">Liste des Dettes</h1>
                        
                        <form class="mb-5 flex items-center">
                            <label class="mr-2">Date:</label>
                            <input type="date" class="p-2 mr-2 border border-gray-300 rounded-md w-44">
                            <label class="mr-2">Recherche:</label>
                            <input type="text" class="p-2 mr-2 border border-gray-300 rounded-md w-44">
                            <button class="px-3 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Filtrer</button>
                            
                        </form>
                        <div>
                        <?php if (!empty($data)): ?>
                          <strong>Nom</strong> :  <span class="border-b p-3 text-center"><?= $data[0]->nom ?></span>
                          <strong>Prenom</strong> :  <span class="border-b p-3 text-center"><?= $data[0]->prenom ?></span>
                        <?php endif; ?>

                        
                        <table class="w-full border-collapse mt-5 shadow-md">
                            <thead class="bg-gray-200">
                                <tr>
                                    <th class="p-3 text-center">Date</th>
                                    <th class="p-3 text-center">Montant</th>
                                    <th class="p-3 text-center">Restant</th>
                                    <th class="p-3 text-center">Paiement</th>
                                    <th class="p-3 text-center">Liste Paiement</th>
                                    <th class="p-3 text-center">Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($data)): ?>
                                    <?php foreach ($data as $dette): ?>
                                        
                                    <tr class="hover:bg-gray-100">
                                        <td class="border-b p-3 text-center"><?= $dette->date ?></td>  
                                        <td class="border-b p-3 text-center"><?= $dette->montant ?></td>
                                        <td class="border-b p-3 text-center"><?= $dette->montantRestant ?></td>
                                        <td class="border-b p-3 text-center">
                                            <a <?= Session::isset("client") ? "href='http://www.diary.shop:8005/payer/{$dette->id}'" : "" ?> class="bg-green-500 text-white ml-2 px-4 py-2 cursor-pointer rounded-md hover:bg-red-600 focus:outline-none">Payer</a>
                                        </td>
                                        <td class="border-b p-3 text-center">
                                            <a <?= Session::isset("client") ? "href='http://www.diary.shop:8005/listepaiement/{$dette->id}'" : "" ?> class="bg-green-500 text-white ml-2 px-4 py-2 cursor-pointer rounded-md hover:bg-red-600 focus:outline-none">Lister</a>
                                        </td>
                                        <td class="border-b p-3 text-center">
                                           
                                            <!-- <a  <?= Session::isset("client") ? "href='http://www.diary.shop:8005/details/{$dette->id}'" : "" ?> class="px-3 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 details-btn" >Détails</a> -->
                                            <a href="/details/<?= $dette->id ?>" class="px-3 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 details-btn">Détails</a>
                                            
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="border-b p-3 text-center">Aucune dette pour ce client.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        
                    </div>

                    <div id="popup" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
                        <div class="bg-white p-5 rounded-lg shadow-lg w-4/5 max-w-3xl relative">
                            <span id="closePopup" class="absolute top-2 right-2 text-2xl cursor-pointer">&times;</span>
                            <h2 class="text-xl font-bold mb-3">Détails de la dette</h2>
                            <div id="detteDetails"></div>
                            <h3 class="text-lg font-bold mt-4 mb-2">Articles de la dette</h3>
                            <ul id="articlesList"></ul>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
