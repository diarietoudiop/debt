<?php

namespace App\Entity;

use App\Core\Entity;

/**
 * Classe représentant une entité de client.
 */
class ArticleEntity extends Entity
{
    private string $libelle;
    private string $photo;
    private int $prixUnitaire;
    private int $quantite;

    public function getlibelle(): string { 
        return $this->libelle;

    }

 
   
}
