
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
                        <li><a href="#" class="block py-2 px-4 hover:bg-teal-700 rounded">Deconnexion</a></li>

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
             <!-- Breadcrumb -->
             <nav class="justify-between px-4 py-3 text-white-700 border border-white sm:flex sm:px-5 bg-gray-50 dark:bg-teal-600 dark:border-gray-700" aria-label="Breadcrumb">
                <ol class="inline-flex items-center mb-3 space-x-1 md:space-x-2 rtl:space-x-reverse sm:mb-0">
                    <li>
                        <div class="flex items-center">
                            <a href="http://www.diary.shop:8005" class="ms-1 text-sm font-medium text-white-700 hover:text-blue-600 md:ms-2 dark:text-white dark:hover:text-dark">Acceuil</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            <a href="http://www.diary.shop:8005/listedette" class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">liste dette</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            <a href="" class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Liste paiement</a>
                        </div>
                    </li>

                </ol>
            </nav>
           
             <!-- Main content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100">
                <div class="container mx-auto px-6 py-8">
                    <h1 class="text-2xl font-bold mb-4">Liste des paiements d'une dette</h1>
                    <div class="bg-white shadow-md rounded-lg overflow-hidden">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr>
                                    <th class="py-2 px-4 bg-gray-200">Date</th>
                                    <th class="py-2 px-4 bg-gray-200">Montant</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($paiements as $paiement): ?>
                                <tr>
                                    <td class="border text-center px-4 py-2"><?= $paiement->getDate() ?> FCFA</td>
                                    <td class="border text-center px-4 py-2"><?= $paiement->getMontant() ?> FCFA</td>
                                </tr>
                            <?php endforeach; ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
