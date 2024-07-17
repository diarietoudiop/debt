<?php

namespace App\Model;

use App\Core\Model;

class PaiementModel extends Model
{
    public function paiementDette(int $id)
    {
        $sql = "SELECT p.* FROM `Paiements` p 
                JOIN `PaiementsDettes` pd ON p.id = pd.paiement_id 
                WHERE pd.dette_id = :id";
        return $this->prepare($sql, ["id" => $id]);
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

    public function save(array $data)
    {
        return $this->transaction(function () use ($data) {
            parent::save(["montant" => $data["montant"], "client_id" => $data["client_id"]]);
            $pdo = $this->database->getConnection();
            $result = $pdo->query("SELECT id FROM Paiements ORDER BY id DESC LIMIT 1");
            $id = $result->fetch()["id"];
            $sql = "INSERT INTO PaiementsDettes (dette_id, vendeur_id, paiement_id) VALUES (:dette, :vendeur, :paiement)";
            $this->prepare($sql, [
                "dette"    => $data["dette_id"],
                "vendeur"  => $data["vendeur_id"],
                "paiement" => $id
            ]);
        });
    }
   

}
