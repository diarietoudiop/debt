<?php

namespace App\Model;
use App\Core\App;
use App\Core\Model;

class DetteModel extends Model
{

    function detteClient(string $telephone)
    {
        $sql = "SELECT d.id, u.prenom,u.nom,u.telephone,d.date,d.montant,  (d.montant - IFNULL(SUM(p.montant), 0)) AS montantRestant
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


    public function rechercherArticle($id){
        $sql = "SELECT * FROM Articles WHERE id = :ref";
        $entityName = "App\Entity\ArticleEntity";
        return $this->prepare($sql, ["ref" => $id], $entityName, true);
    }


    public function save(array $dette){
        $resulat = $this->transaction(fn()=>$this->saveDette($dette));
        return $resulat == "succès"? true:  false;
    }

    private function saveDette($dette){
        // On enregistre sur la table dettes
        parent::save([
            "client_id"=>$dette["client"],
            "vendeur_id"=>$dette["vendeur"],
            "montant"=>$dette["montant"]
        ]);

        $idDette = $this->lastId(); // On récupérer l'id du dette qu'on vient d'inserer
        $app = App::getInstance();
        $articleModel = $app->getModel("Article"); // On récupérer le model article
        $detailDetteModel = $app->getModel("DetailsDette"); // On récupérer le model detaildette

        // On parcourt la liste des articles qui sont dans ce nouveau dette
        foreach($dette["articles"] as $article){

            // On enregistre sur la table detaildette
            $detailDetteModel->save([
                "dette_id"=>$idDette,
                "article_id"=>$article->id,
                "quantite"=>$article->quantite
            ]);

            // On récupére la quantité de l'article en stock
            $quantite = $articleModel->find($article->id)->quantite;

         
            // ON met à jour la quantité en stock de l'article
            $articleModel->save([
                "id"=>$article->id,
                "quantite"=> $quantite - $article->quantite
            ]);
        }
    }


}


