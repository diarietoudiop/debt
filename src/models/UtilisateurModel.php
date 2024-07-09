<?php

namespace App\Model;

use App\Core\Model;

class UtilisateurModel extends Model
{


    public function search(string $telephone, int $dette = 0)
    {
        $entityName = "App\\Entity\\DetteClientPaiementEntity";
        $condition = $dette? " AND d.id = :dette":"";

        $sql = "SELECT u.nom, u.prenom, u.telephone, u.photo,u.email,COALESCE(SUM(d.montant), 0) AS montant, 
                COALESCE(SUM(p.montant), 0) AS montantVerser, COALESCE(SUM(d.montant) - SUM(p.montant), COALESCE(SUM(d.montant), 0)) AS montantRestant
                FROM Utilisateurs u
                LEFT JOIN Dettes d ON u.id = d.client_id
                LEFT JOIN Paiements p ON u.id = p.client_id
                WHERE u.telephone = :telephone $condition
                GROUP BY u.nom, u.prenom, u.telephone;";

        $data = ["telephone" => $telephone];
        if ($dette) $data["dette"] = $dette;

        return $this->prepare($sql, $data, $entityName, true);
    }
}