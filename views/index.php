<?php 
$data = isset($data) && count($data)?$data[0]:null;
// var_dump($data);die;

use App\Core\Session;
use App\Core\Validator;

// $data = isset($data) && count($data)?$data[0]:null;
// $data = $_POST; // Assurez-vous que vos données proviennent correctement du formulaire
// $error = Validator::validate($data, $rules); // $rules doit être défini selon vos besoins

// // Stockage des données saisies en session pour les champs non validés
// foreach ($data as $key => $value) {
//     Session::set($key, $value);
// }

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boutique - Gestion des Clients et Dettes</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-100 font-sans">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="bg-gray-700 text-white w-64 flex-shrink-0 overflow-y-auto">
            <div class="p-4">
                <h2 class="text-2xl font-bold mb-6">Menu</h2>
                <nav>
                    <ul class="space-y-2">
                        <li><a href="#" class="block py-2 px-4 hover:bg-gray-700 rounded">Accueil</a></li>
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
            <header class="bg-blue-900 text-white shadow-md">
                <div class="container mx-auto px-4 py-3 flex justify-between items-center">
                    <h1 class="text-2xl font-bold">Shop</h1>
                    <div class="flex items-center space-x-4">
                        <button class="bg-blue-700 hover:bg-blue-600 px-4 py-2 rounded">Notifications</button>
                        <div class="relative">
                            <img class="h-10 w-10 rounded-full" src="https://via.placeholder.com/40" alt="User avatar">
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100">
                <div class="container mx-auto px-6 py-8">
                    <div class="flex flex-col md:flex-row space-y-6 md:space-y-0 md:space-x-6">
                        <!-- Nouveau Client Form -->
                        <div class="bg-white shadow-md rounded-lg p-6 w-full md:w-1/2">
                            <h2 class="text-2xl font-semibold mb-6">Nouveau Client</h2>
                            <form class="space-y-4" action="/add-client" method="post" enctype="multipart/form-data">
                                <div class="mb-4">
                                    <label for="nom" class="block text-gray-700">Nom</label>
                                    <div class="flex items-center border rounded-md bg-white">
                                        <input type="text" id="nom" name="nom" class="w-full p-2 rounded-md focus:outline-none" placeholder="Nom" value="<?=Session::isset("nom")?Session::get("nom"):""?>">
                                    </div>
                                    <div class="text-red-400 min-h-8"><?=isset($error["nom"])?$error["nom"]:""?></div>
                                </div>
                                <div class="mb-4">
                                    <label for="prenom" class="block text-gray-700">Prénom</label>
                                    <div class="flex items-center border rounded-md bg-white">
                                        <input name="prenom" type="text" id="prenom" class="w-full p-2 rounded-md focus:outline-none" placeholder="Prénom" value="<?=Session::isset("prenom")?Session::get("prenom"):""?>">
                                    </div>
                                    <div class="text-red-400 min-h-8"><?=isset($error["prenom"])?$error["prenom"]:""?></div>
                                </div>
                                <div class="mb-4">
                                    <label for="email" class="block text-gray-700">Email</label>
                                    <div class="flex items-center border rounded-md bg-white">
                                       
                                        <input name="email" type="text" id="email" class="w-full p-2 rounded-md focus:outline-none" placeholder="Email" value="<?=Session::isset("email")?Session::get("email"):""?>">
                                    </div>
                                    <div class="text-red-400 min-h-8"><?=isset($error["email"])?$error["email"]:""?></div>
                                </div>
                                <div class="mb-4">
                                    <label for="tel" class="block text-gray-700">Tel</label>
                                    <div class="flex items-center border rounded-md bg-white">
                                       
                                        </span>
                                        <input name="telephone" type="tel" id="tel" class="w-full p-2 rounded-md focus:outline-none" placeholder="Tel" value="<?=Session::isset("telephone")?Session::get("telephone"):""?>">
                                    </div>
                                    <div class="text-red-400 min-h-8"><?=isset($error["telephone"])?$error["telephone"]:""?></div>
                                </div>
                                <div>
                                    <label for="photo" class="block text-sm font-medium text-gray-700 mb-1">Photo</label>
                                    <input type="file" id="photo" name="photo" class="w-full p-2 border rounded-md focus:ring focus:ring-blue-300">
                                </div>
                                <div class="flex justify-end">
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                        Enregistrer
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Suivie dette -->
                        <div class="bg-white shadow-md rounded-lg p-6 w-full md:w-1/2">
                            <h2 class="text-2xl font-semibold mb-6">Suivie dette</h2>
                            <form method="post" action="/" class="flex items-center">
                                <input type="tel" value="<?=$data?$data->telephone:""?>" name="telephone" class="border rounded-md p-2 focus:outline-none" placeholder="Tel">
                                <button name="search" type="submit" class="bg-blue-500 text-white ml-2 px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none">Ok</button>
                            </form>
                            <div class="bg-gray-100 p-4 rounded-lg shadow-lg mt-5">
                            <div class="flex mb-4">
                                <button class="bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded">Client</button>
                                <div class="ml-auto">
                                <button class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none">Nouvelle +</button>
                                <a href="<?= $data?"/listedette":""?>" class="bg-green-500 text-white ml-2 px-4 py-2 rounded-md hover:bg-red-600 focus:outline-none">Dette</a>
                                </div>
                            </div>
                                <div class="bg-gray-100 p-4 rounded-lg mb-6">
                                <div class="flex mb-4">
                                    <div class="w-24 h-24 bg-gray-300 mr-4 rounded"> <img src="./assets/img/<?=$data?$data->photo:""?>" alt="" class="h-full w-full object-cover"></div>
                                    <div>
                                        <p class="mb-1"> <div class="text-gray-700"><strong>Nom :</strong> <?=$data?$data->nom:""?></div> </p>
                                        <p class="mb-1"> <div class="text-gray-700"><strong>Prénom :</strong> <?=$data?$data->prenom:""?></div></p>
                                        <p><strong><div class="text-gray-700">Email : <span class="text-blue-400 underline"><?=$data?$data->email:""?></span></div></strong> </p>
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <p><strong><div class="text-gray-700">Total Dette : <?=$data?$data->montant:""?></div></strong> </p>
                                    <p><strong><div class="text-gray-700 mt-2">Montant versé : <?=$data?$data->montantVerser:""?></div></strong> </p>
                                    <p><strong><div class="text-gray-700 mt-2">Montant rester : <?=$data?$data->montantRestant:""?></div></strong> </p>
                                </div>
                            </div>

                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
     <!-- Script JavaScript pour afficher le popup -->
     <script>
    document.addEventListener('DOMContentLoaded', function() {
        var successMessage = "<?= Session::get('success_message') ?>";
        if (successMessage) {
            Swal.fire({
                title: 'Succès!',
                text: successMessage,
                icon: 'success',
                confirmButtonText: 'OK'
            });
            <?php Session::unset('success_message'); ?>
        }
    });
</script>
</body>
</html>
