<?php

namespace App\Model;

use App\Core\Model;

class DetteModel extends Model
{

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
        $sqlCount = "SELECT COUNT(*) as total FROM Dettes";
        $totalDettes = $this->query($sqlCount)[0]->total;
        
        $totalPages = ceil($totalDettes / $itemsPerPage);
        
        return [
            'currentPage' => $page,
            'totalPages' => $totalPages
        ];
    }

    public function recupererArticle(int $id){
        $sql = "SELECT a.libelle,dd.quantite,a.prixUnitaire,(dd.quantite * a.prixUnitaire) AS montant,d.date AS date
                FROM DetailsDettes dd
                INNER JOIN Articles a ON dd.article_id = a.id
                INNER JOIN Dettes d ON dd.dette_id = d.id
                WHERE dd.dette_id = :id";
        $entityName = "App\Entity\ArticleDetteEntity";
        return $this->prepare($sql, ["id"=>$id], $entityName);
    }


    public function recupererDette(int $id)
    {
        $sql = "SELECT d.id, u.id as idClient, u.prenom,u.nom,u.telephone,d.montant, COALESCE(SUM(p.montant), 0) AS montantVerser, (d.montant - IFNULL(SUM(p.montant), 0)) AS montantRestant
                FROM Dettes d
                LEFT JOIN PaiementsDettes pd ON d.id = pd.dette_id
                LEFT JOIN Paiements p ON pd.paiement_id = p.id
                INNER JOIN Utilisateurs u ON d.client_id = u.id
                WHERE d.id = :id
                GROUP BY d.id, d.montant, u.prenom, u.nom, u.telephone
                ORDER BY d.date DESC";
        $entityName = "App\Entity\DetteClientPaiementEntity";
        return $this->prepare($sql, ["id" => $id], $entityName, true);
    }

}

