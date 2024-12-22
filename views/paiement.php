<?php
use App\Core\Session;
?>
<!DOCTYPE html>

<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boutique - Gestion des Clients et Dettes</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<style>
    .min-h-8 {
        min-height: 2rem;
    }
</style>

<body class="bg-gray-200 font-sans">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="bg-teal-600 text-white w-64 flex-shrink-0 overflow-y-auto">
            <div class="p-4">
                <h2 class="text-2xl font-bold mb-6">Menu</h2>
                <nav>
                    <ul class="space-y-2">
                        <li><a href="http://www.diary.shop:8005" class="block py-2 px-4 hover:bg-teal-700 rounded">Accueil</a></li>
                        <li><a href="#" class="block py-2 px-4 hover:bg-teal-700 rounded">Clients</a></li>
                        <li><a href="#" class="block py-2 px-4 hover:bg-teal-700 rounded">Dettes</a></li>
                        <li><a href="#" class="block py-2 px-4 hover:bg-teal-700 rounded">Rapports</a></li>
                        <li><a href="#" class="block py-2 px-4 hover:bg-teal-700 rounded">Paramètres</a></li>
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
                            <a href="<?= Session::isset("client") ? "href='http://www.diary.shop:8005/payer/{$dette->id}'" : "" ?>" class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">paiement</a>
                        </div>
                    </li>

                </ol>
            </nav>

            <!-- Main content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200">
                <div class="container mx-auto px-6 py-8">
                    <div class="max-w-3xl mx-auto mt-8 mb-10 bg-white shadow-lg rounded-lg overflow-hidden">
                        <div class="bg-gray-100 py-4 px-6 border-b border-gray-200">
                            <h2 class="text-2xl font-bold text-gray-800 text-center">Détails du client</h2>
                        </div>
                        <div class="flex flex-col md:flex-row justify-between items-center py-4 px-6">
                            <div class="text-gray-700 text-xl mb-2 md:mb-0">
                                <span class="font-semibold">Client :</span> <?= $dette->prenom . ' ' . $dette->nom ?>
                            </div>
                            <div class="text-gray-700 text-xl">
                                <span class="font-semibold">Tél :</span> <?= $dette->telephone ?>
                            </div>
                        </div>

                        <?php if (count($succes)): ?>
                            <div class="py-4 px-6 <?= $succes["status"] ? 'bg-green-100' : 'bg-red-100' ?> border-t border-b border-gray-200">
                                <p class="text-center text-lg <?= $succes["status"] ? 'text-green-700' : 'text-red-700' ?> font-semibold">
                                    <?= $succes['msg'] ?>
                                </p>
                            </div>
                        <?php endif; ?>

                        <form class="py-6 px-8" method="post" action="/payer/<?=$id?>">
                            <input type="hidden" name="telephone_client" value="<?=$dette->telephone?>">
                            <input type="hidden" name="dette_id" value="<?=$dette->id?>">

                            <h3 class="text-2xl font-bold text-gray-800 mb-6 text-center">Effectuer un paiement</h3>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Montant Total</label>
                                    <input value="<?=$dette->montant?>" type="text" disabled class="w-full p-2 bg-gray-100 border border-gray-300 rounded-md text-center">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Montant Versé</label>
                                    <input value="<?=$dette->montantVerser?>" type="text" disabled class="w-full p-2 bg-gray-100 border border-gray-300 rounded-md text-center">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Montant Restant</label>
                                    <input value="<?=$dette->montantRestant?>" type="text" disabled class="w-full p-2 bg-gray-100 border border-gray-300 rounded-md text-center">
                                </div>
                            </div>

                            <div class="mb-6">
                                <label for="paiement" class="block text-sm font-medium text-gray-700 mb-2">Montant à Payer</label>
                                <input type="text" id="paiement" name="paiement" class="w-full p-2 border border-gray-300 rounded-md text-center" placeholder="Entrez le montant">
                                <?php if (isset($error["paiement"])): ?>
                                    <p class="mt-2 text-sm text-red-600"><?= $error["paiement"][0] ?></p>
                                <?php endif; ?>
                            </div>

                            <div>
                                <button type="submit" name="payer" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-md transition duration-300">
                                    Effectuer le paiement
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>

</html>
