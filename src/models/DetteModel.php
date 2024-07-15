<?php

namespace App\Model;

use App\Core\Model;

class DetteModel extends Model
{

    // function detteById(int $id)
    // {
    //     $sql = "SELECT u.nom, u.prenom, u.telephone, d.date, COALESCE(SUM(d.montant), 0) AS montant, 
    //             COALESCE(SUM(d.montant) - SUM(p.montant), COALESCE(SUM(d.montant), 0)) AS montantRestant
    //             FROM Utilisateurs u
    //             LEFT JOIN Dettes d ON u.id = d.client_id
    //             LEFT JOIN Paiements p ON u.id = p.client_id
    //             WHERE d.id = :id
    //             GROUP BY u.nom, u.prenom, u.telephone;";
    //     $entityName = "App\\Entity\\DetteClientEntity";
        
    //     return $this->prepare($sql, ["id" => $id], $entityName, true);
    // }

    function detteClient(string $telephone)
    {
        $sql = "SELECT d.id, u.prenom,u.nom,u.telephone,d.date,d.montant, d.solder, (d.montant - IFNULL(SUM(p.montant), 0)) AS montantRestant
                FROM Dettes d
                LEFT JOIN PaiementsDettes pd ON d.id = pd.dette_id
                LEFT JOIN Paiements p ON pd.paiement_id = p.id
                INNER JOIN Utilisateurs u ON d.client_id = u.id
                WHERE u.telephone = :telephone
                GROUP BY d.id, d.montant, u.prenom, u.nom, u.telephone
                ORDER BY d.date DESC";

        $entityName = "App\\Entity\\DetteClientEntity";
        return $this->prepare($sql, ["telephone" => $telephone], $entityName);
    }

    
// Dans votre contrôleur ou modèle


    public function getDettesPaginees($page = 1, $itemsPerPage = 10)
    {
        $offset = ($page - 1) * $itemsPerPage;
        
        $sql = "SELECT d.date, d.montant, u.nom, u.prenom 
                FROM Dettes d 
                JOIN Utilisateurs u ON d.client_id = u.id 
                ORDER BY d.date DESC
                LIMIT :limit OFFSET :offset";
        
        $params = [
            ':limit' => $itemsPerPage,
            ':offset' => $offset
        ];
        
        // $dettes = $this->query($sql, $params);
        
        // Obtenir le nombre total de dettes
        $sqlCount = "SELECT COUNT(*) as total FROM Dettes";
        $totalDettes = $this->query($sqlCount)[0]->total;
        
        $totalPages = ceil($totalDettes / $itemsPerPage);
        
        return [
            // 'dettes' => $dettes,
            'currentPage' => $page,
            'totalPages' => $totalPages
        ];
    }


// Dans votre contrôleur

}
