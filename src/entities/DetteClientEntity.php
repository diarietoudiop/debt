<?php

namespace App\Entity;

use App\Core\Entity;

/**
 * Classe représentant une entité de dette.
 */
class DetteClientEntity extends Entity
{
    /**
     * @var string
     */
    private $prenom;

    /**
     * @var string
     */
    private $nom;

    /**
     * @var string
     */
    private $telephone;

    /**
     * @var float
     */
    private $montant;
    /**
     * @var string
     */
    private $date;
    /**
     * @var bool
     */
    private $solder;


    /**
     * @var float
     */
    private $montantRestant;

    /**
     * Get the value of prenom
     *
     * @return string
     */
    public function getPrenom(): string
    {
        return $this->prenom;
    }

    /**
     * Set the value of prenom
     *
     * @param string $prenom
     * @return self
     */
    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get the value of nom
     *
     * @return string
     */
    public function getNom(): string
    {
        return $this->nom;
    }

    /**
     * Set the value of nom
     *
     * @param string $nom
     * @return self
     */
    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get the value of nom
     *
     * @return string
     */
    public function getSolder(): string
    {
        return $this->solder;
    }

    /**
     * Set the value of nom
     *
     * @param string $nom
     * @return self
     */
    public function setSolder(string $solder): self
    {
        $this->solder = $solder;

        return $this;
    }

    /**
     * Get the value of nom
     *
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * Set the value of nom
     *
     * @param string $nom
     * @return self
     */
    public function setDate(string $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get the value of telephone
     *
     * @return string
     */
    public function getTelephone(): string
    {
        return $this->telephone;
    }

    /**
     * Set the value of telephone
     *
     * @param string $telephone
     * @return self
     */
    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

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
     * Get the value of montantRestant
     *
     * @return float
     */
    public function getMontantRestant(): float
    {
        return $this->montantRestant;
    }

    /**
     * Set the value of montantRestant
     *
     * @param float $montantRestant
     * @return self
     */
    public function setMontantRestant(float $montantRestant): self
    {
        $this->montantRestant = $montantRestant;

        return $this;
    }
}
