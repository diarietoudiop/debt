<div class="shadow-lg rounded-lg overflow-hidden mx-4 md:mx-10 mt-5">
    <h1 class="text-center text-3xl mb-4 uppercase">La liste des clients</h1>
    <table class="w-full table-fixed">
        <thead>
            <tr class="bg-gray-100">
                <th class="w-1/4 py-4 px-6 text-left text-gray-600 font-bold uppercase">Id</th>
                <th class="w-1/4 py-4 px-6 text-left text-gray-600 font-bold uppercase">Prenom</th>
                <th class="w-1/4 py-4 px-6 text-left text-gray-600 font-bold uppercase">Nom</th>
                <th class="w-1/4 py-4 px-6 text-left text-gray-600 font-bold uppercase">Téléphone</th>
                <th class="w-1/4 py-4 px-6 text-left text-gray-600 font-bold uppercase">Adresse</th>
                <th class="w-1/4 py-4 px-6 text-left text-gray-600 font-bold uppercase">Role</th>
            </tr>
        </thead>
        <tbody class="bg-white">
            <?php foreach ($data as $client): ?>
                <tr>
                    <td class="py-4 px-6 border-b border-gray-200"><?= $client->id ?></td>
                    <td class="py-4 px-6 border-b border-gray-200"><?= $client->prenom ?></td>
                    <td class="py-4 px-6 border-b border-gray-200 truncate"><?= $client->nom ?></td>
                    <td class="py-4 px-6 border-b border-gray-200"><?= $client->telephone ?></td>
                    <td class="py-4 px-6 border-b border-gray-200"><?= $client->adresse ?></td>
                    <td class="py-4 px-6 border-b border-gray-200"><?= $client->role ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>


