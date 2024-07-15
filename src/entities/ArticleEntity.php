<?php

namespace App\Entity;

use App\Core\Entity;

/**
 * Class ArticleEntity
 * @package App\Entity
 */
class ArticleEntity extends Entity {

    /**
     * @var string
     */
    private $libelle;

    /**
     * @var float
     */
    private $prixUnitaire;

    /**
     * @var int
     */
    private $quantite;

    /**
     * @var string
     */
    private $photo;


    /**
     * Get the value of libelle
     *
     * @return string
     */
    public function getLibelle(): string {
        return $this->libelle;
    }

    /**
     * Set the value of libelle
     *
     * @param string $libelle
     * @return self
     */
    public function setLibelle(string $libelle): self {
        $this->libelle = $libelle;
        return $this;
    }

    /**
     * Get the value of prixUnitaire
     *
     * @return float
     */
    public function getPrixUnitaire(): float {
        return $this->prixUnitaire;
    }

    /**
     * Set the value of prixUnitaire
     *
     * @param float $prixUnitaire
     * @return self
     */
    public function setPrixUnitaire(float $prixUnitaire): self {
        $this->prixUnitaire = $prixUnitaire;
        return $this;
    }

    /**
     * Get the value of quantite
     *
     * @return int
     */
    public function getQuantite(): int {
        return $this->quantite;
    }

    /**
     * Set the value of quantite
     *
     * @param int $quantite
     * @return self
     */
    public function setQuantite(int $quantite): self {
        $this->quantite = $quantite;
        return $this;
    }

    /**
     * Get the value of photo
     *
     * @return string
     */
    public function getPhoto(): string {
        return $this->photo;
    }

    /**
     * Set the value of photo
     *
     * @param string $photo
     * @return self
     */
    public function setPhoto(string $photo): self {
        $this->photo = $photo;
        return $this;
    }
}

