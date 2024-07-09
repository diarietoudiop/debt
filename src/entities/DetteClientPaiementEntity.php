<?php

namespace App\Entity;

use App\Core\Entity;

/**
 * Classe représentant une entité de client.
 */
class DetteClientPaiementEntity extends Entity
{

    private string $prenom;
    private string $photo;
    private string $nom;
    private string $email;
    private string $telephone;
    private int $montant;
    private int $montantVerser;
    private int $montantRestant;

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
     * Get the value of photo
     *
     * @return string
     */
    public function getPhoto(): string
    {
        return $this->photo;
    }

    /**
     * Set the value of photo
     *
     * @param string $photo
     * @return self
     */
    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;
        return $this;
    }

    /**
     * Get the value of nom
     *
     * @return string
     */
    public function getTelephone(): string
    {
        return $this->telephone;
    }

    /**
     * Get the value of nom
     *
     * @return string
     */
    public function setTelephone(string $telephone)
    {
        $this->telephone = $telephone;
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
     * Get the value of email
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @param string $email
     * @return self
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Get the value of montant
     *
     * @return int
     */
    public function getMontant(): int
    {
        return $this->montant;
    }

    /**
     * Set the value of montant
     *
     * @param int $montant
     * @return self
     */
    public function setMontant(int $montant): self
    {
        $this->montant = $montant;
        return $this;
    }

    /**
     * Get the value of montantVerser
     *
     * @return int
     */
    public function getMontantVerser(): int
    {
        return $this->montantVerser;
    }

    /**
     * Set the value of montantVerser
     *
     * @param int $montantVerser
     * @return self
     */
    public function setMontantVerser(int $montantVerser): self
    {
        $this->montantVerser = $montantVerser;
        return $this;
    }

    /**
     * Get the value of montantRestant
     *
     * @return int
     */
    public function getMontantRestant(): int
    {
        return $this->montantRestant;
    }

    /**
     * Set the value of montantRestant
     *
     * @param int $montantRestant
     * @return self
     */
    public function setMontantRestant(int $montantRestant): self
    {
        $this->montantRestant = $montantRestant;
        return $this;
    }
}
