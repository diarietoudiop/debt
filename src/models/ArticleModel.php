<?php

namespace App\Model;

use App\Core\Model;

class ArticleModel extends Model
{
    public function getArticles($detteId)
    {
        $sql = "SELECT a.id, a.libelle, a.prixUnitaire, dd.quantite, (a.prixUnitaire * dd.quantite) as sous_total
                FROM Articles a
                JOIN DetailsDettes dd ON a.id = dd.article_id
                WHERE dd.dette_id = :dette_id";
        
        return $this->prepare($sql, ['dette_id' => $detteId]);
    }




}
