<!-- views/liste_dettes.php -->

<?php

use App\Core\Session;
use App\Model\DetteModel;

$detteModel = new DetteModel();
// $data = $detteModel->detteClient(Session::get("client"));
// $data = isset($data) && is_array($data) ? $data : [];
$totalPages = 3;
$currentPage = 2;
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
                            <a href="http://www.diary.shop:8005//details/{id}" class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Details</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            <a href="" class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Details</a>
                        </div>
                    </li>

                </ol>
            </nav>
            <!-- Main content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 ">
                <div class="container mx-auto px-6 py-8 shadow-md bg-white mt-4 w-full rounded-lg">
                    <div class="container w-4/5 mx-auto overflow-hidden p-5">
                        <h1 class="text-center text-2xl font-bold text-gray-800 mb-6">Liste des Dettes d'un client</h1>

                        <form class="mb-5 flex items-center" method="GET" action="http://www.diary.shop:8005/listedette">
                            <label class="mr-2">Téléphone:</label>
                            <input type="text" name="telephone" class="p-2 mr-2 border border-gray-300 rounded-md w-44" value="<?= $_GET['telephone'] ?? '' ?>">
                            <label class="mr-2">Filtrer par:</label>
                            <select name="status" class="p-2 mr-4 border border-gray-300 rounded-md w-44">
                                <option value="">Tous</option>
                                <option value="solde" <?= ($_GET['status'] ?? '') === 'solde' ? 'selected' : '' ?>>Soldé</option>
                                <option value="non-solde" <?= ($_GET['status'] ?? '') === 'non-solde' ? 'selected' : '' ?>>Non Soldé</option>
                            </select>
                            <button type="submit" class="px-3 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Filtrer</button>
                        </form>
                        <div class="flex justify-center">
                            <?php if (!empty($data)) : ?>
                                <div class="text-center">
                                    <strong>Nom</strong> : <span class="border-b p-3"><?= $data[0]->nom ?></span>
                                    <strong>Prénom</strong> : <span class="border-b p-3"><?= $data[0]->prenom ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                        <table class="w-full border-collapse mt-5 shadow-md">
                            <thead class="bg-gray-200">
                                <tr>
                                    <th class="p-3 text-center">Date</th>
                                    <th class="p-3 text-center">Montant</th>
                                    <th class="p-3 text-center">Restant</th>
                                    <?php if ($_SESSION["user_role"] == "Vendeur") : ?>
                                        <th class="p-3 text-center">Paiement</th>
                                    <?php endif; ?>
                                    <th class="p-3 text-center">Liste Paiement</th>
                                    <th class="p-3 text-center">Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($data)) : ?>
                                    <?php foreach ($data as $dette) : ?>

                                        <tr class="hover:bg-gray-100">
                                            <td class="border-b p-3 text-center"><?= $dette->date ?></td>
                                            <td class="border-b p-3 text-center"><?= $dette->montant ?></td>
                                            <td class="border-b p-3 text-center"><?= $dette->montantRestant ?></td>
                                            <?php if ($_SESSION["user_role"] == "Vendeur") : ?>

                                                <td class="border-b p-3 text-center">
                                                    <a <?= Session::isset("client") ? "href='http://www.diary.shop:8005/payer/{$dette->id}'" : "" ?> class="bg-teal-600 text-white ml-2 px-4 py-2 cursor-pointer rounded-md hover:bg-teal-700 focus:outline-none">Payer</a>
                                                </td>
                                            <?php endif; ?>

                                            <td class="border-b p-3 text-center">
                                                <a <?= Session::isset("client") ? "href='http://www.diary.shop:8005/listepaiement/{$dette->id}'" : "" ?> class="bg-orange-500 text-white ml-2 px-4 py-2 cursor-pointer rounded-md hover:bg-orange-600 focus:outline-none">Lister</a>
                                            </td>
                                            <td class="border-b p-3 text-center">

                                                <!-- <a  <?= Session::isset("client") ? "href='http://www.diary.shop:8005/details/{$dette->id}'" : "" ?> class="px-3 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 details-btn" >Détails</a> -->
                                                <a href="/details/<?= $dette->id ?>" class="px-3 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 details-btn">Détails</a>

                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="5" class="border-b p-3 text-center">Aucune dette pour ce client.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        <div class="mt-4 flex justify-center">
                            <?php if ($totalPages > 1) : ?>
                                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                                    <?php if ($currentPage > 1) : ?>
                                        <a href="?page=<?= $currentPage - 1 ?>&telephone=<?= $telephone ?>&date=<?= $date ?>&status=<?= $status ?>" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                            Précédent
                                        </a>
                                    <?php endif; ?>

                                    <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                                        <a href="?page=<?= $i ?>&telephone=<?= $telephone ?>&date=<?= $date ?>&status=<?= $status ?>" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium <?= $i === $currentPage ? 'text-indigo-600 bg-indigo-50' : 'text-gray-700 hover:bg-gray-50' ?>">
                                            <?= $i ?>
                                        </a>
                                    <?php endfor; ?>

                                    <?php if ($currentPage < $totalPages) : ?>
                                        <a href="?page=<?= $currentPage + 1 ?>&telephone=<?= $telephone ?>&date=<?= $date ?>&status=<?= $status ?>" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                            Suivant
                                        </a>
                                    <?php endif; ?>
                                </nav>
                            <?php endif; ?>
                        </div>

                    </div>


                </div>
            </main>
        </div>
    </div>
</body>

</html>