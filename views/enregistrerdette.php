<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop Admin - Enregistrer une livraison</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-teal-600 text-white p-4">
            <h2 id="menu" class="text-2xl font-bold mb-6">Menu</h2>
            <nav>
                <a href="http://www.diary.shop:8005" class="block py-2 px-4 hover:bg-indigo-700 rounded transition duration-200">Accueil</a>
                <a href="#" class="block py-2 px-4 hover:bg-indigo-700 rounded transition duration-200">Clients</a>
                <a href="#" class="block py-2 px-4 hover:bg-indigo-700 rounded transition duration-200">Dettes</a>
                <a href="#" class="block py-2 px-4 hover:bg-indigo-700 rounded transition duration-200">Rapports</a>
                <a href="#" class="block py-2 px-4 hover:bg-indigo-700 rounded transition duration-200">Paramètres</a>
                <li><a href="#" class="block py-2 px-4 hover:bg-teal-700 rounded">Deconnexion</a></li>

            </nav>
        </div>

        <!-- Main content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-indigo-800 text-white shadow-md">
                <div class="container mx-auto px-4 py-3 flex justify-between items-center">
                    <h1 id="shop" class="text-2xl font-bold">Shop</h1>
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <input type="text" placeholder="Rechercher..." class="bg-indigo-700 text-white rounded-full py-1 px-4 pl-8 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <svg class="w-5 h-5 text-indigo-300 absolute left-2 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <button class="hover:bg-indigo-700 rounded-full p-1 transition duration-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                        </button>
                        <img src="https://via.placeholder.com/40" alt="User avatar" class="h-10 w-10 rounded-full">
                    </div>
                </div>
            </header>

            
            <!-- Main content area -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-semibold mb-6">Enregistrer une dette</h2>
                    <?php if ($succes): ?>
                            <div class="py-4 px-6 <?= $succes["status"] ? 'bg-green-100' : 'bg-red-100' ?> border-t border-b border-gray-200">
                                <p class="text-center text-lg <?= $succes["status"] ? 'text-green-700' : 'text-red-700' ?> font-semibold">
                                    <?= $succes['msg'] ?>
                                </p>
                            </div>
                        <?php endif; ?>
                    <form method="post" action="http://www.diary.shop:8005/enregistrerdette">
                        <div class="grid grid-cols-4 gap-4">
                            <div>
                                <label for="ref" class="block text-sm font-medium text-gray-700 mb-1">REF</label>
                                <input type="number" value="<?= $_SESSION["ref"] ?? "" ?>" id="ref" name="ref" class="w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            <div class="flex items-end">
                                <button type="submit" name="rechercher-article" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition duration-200">Rechercher</button>
                            </div>
                        </div>
                        <div id="error-message" class="text-red-500 text-sm mt-2 mb-6 min-h-6">
                            <?= $error["ref"][0] ?? "" ?>
                        </div>
                    </form>

                    <h3 class="text-lg font-semibold mb-2">Articles de la livraison</h3>
                    <form class="bg-white rounded-lg shadow-md p-4 mb-6" method="post" action="http://www.diary.shop:8005/enregistrerdette">
                        <div class="grid grid-cols-5 gap-4 mb-4">
                            <div>
                                <label for="libelle" class="block text-sm font-medium text-gray-700 mb-1">Libellé</label>
                                <input value="<?= $article->libelle ?? "" ?>" disabled type="text" id="libelle" name="libelle" class="w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">

                            </div>
                            <div>
                                <label for="prix" class="block text-sm font-medium text-gray-700 mb-1">Prix</label>
                                <input value="<?= $article->prixUnitaire ?? "" ?>" disabled type="number" id="prix" name="prix" class="w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            <div>
                                <label for="quantite" class="block text-sm font-medium text-gray-700 mb-1">Quantité</label>
                                <input type="number" id="quantite" name="quantite" class="w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            <div>
                                <label for="montant" class="block text-sm font-medium text-gray-700 mb-1">Montant</label>
                                <input value="<?= $article->prixUnitaire ?? "" ?>" disabled type="number" id="montant" name="montant" class="w-full border border-gray-300 rounded-md shadow-sm bg-gray-50" readonly>
                            </div>
                            <div class="flex items-end">
                                <button type="submit" name="ajouter-article" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition duration-200">Ajouter</button>
                            </div>
                        </div>
                        <div id="error-message" class="text-red-500 text-sm mt-2 mb-6 min-h-6">
                            <?= $error["article"] ?? $error["quantite"][0] ?? "" ?>
                        </div>
                    </form>

                    <div class="flex justify-between">
                    <h3 class="text-lg font-semibold mb-2">Articles choisis pour la dette</h3>
                    <form method="post" action="http://www.diary.shop:8005/enregistrerdette">
                        <button type="submit" name="vider"  class="bg-red-500 text-white px-4 py-2 rounded-md  hover:bg-red-600 focus:outline-none focus:ring-2  transition duration-200">vider</button>
                    </form>
                    </div>

                    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
                        <table class="w-full mb-4">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Libellé</th>
                                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Prix</th>
                                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Quantité</th>
                                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Montant</th>
                                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($_SESSION["panierArticles"] ?? [] as $art): ?>
                                    <tr id="article-row-<?= $key ?>">
                                        <td class="px-4 py-2"><?= $art->libelle ?? "" ?></td>
                                        <td class="px-4 py-2"><?= $art->prixUnitaire ?? "" ?></td>
                                        <td class="px-4 py-2"><?= $art->quantite ?? "" ?></td>
                                        <td class="px-4 py-2"><?= $art->prixUnitaire * $art->quantite ?? "" ?></td>
                                        <td class="border px-4 py-2">
                                            <form method="post" action="http://www.diary.shop:8005/enregistrerdette">
                                                <input type="hidden" name="id" value="<?= $art->id ?? "" ?>">
                                                <button  type="submit" name="supprimer-article" class="bg-red-500 text-white px-4 py-2  hover:bg-red-600  rounded-md transition duration-200">Supprimer</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                            </tbody>
                        </table>
                        <div class="flex justify-end items-center space-x-4 mt-10">
                            <span class="font-semibold">Total de la dette :</span>
                            <input  disabled value="<?= $_SESSION["total"] ?? 0 ?> fcfa" class="text-center w-40 border border-gray-300 rounded-md shadow-sm bg-gray-50 font-semibold" readonly>
                        </div>
                    </div>

                    <form class="flex justify-end" method="post" action="http://www.diary.shop:8005/enregistrerdette">
                        <button  name="enregistrer-dette" type="submit" class="bg-indigo-600 w-full text-white px-6 py-2 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition duration-200">Enregistrer</button>
                    </form>
                </div>
            </main>
        </div>
    </div>
</body>

</html>