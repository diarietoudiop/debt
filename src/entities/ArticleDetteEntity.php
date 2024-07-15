<?php

namespace App\Entity;
use App\Entity\ArticleEntity;

/**
 * Class ArticleEntity
 * @package App\Entity
 */
class ArticleDetteEntity extends ArticleEntity
{

    private $montant;
    private $date;

    /**
     * Get the value of montant
     *
     * @return float
     */
    public function getMontant(): float
    {
        return $this->montant;
    }

    /**
     * Set the value of montant
     *
     * @param float $montant
     * @return self
     */
    public function setMontant(float $montant): self
    {
        $this->montant = $montant;
        return $this;
    }

    /**
     * Get the value of date
     *
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * Set the value of date
     *
     * @param string $date
     * @return self
     */
    public function setDate(string $date): self
    {
        $this->date = $date;
        return $this;
    }
}
