<?php

namespace App\Entity;

use App\Core\Entity;
use App\Core\App;

/**
 * Classe représentant une entité de paiement.
 */
class PaiementEntity extends Entity
{
    /**
     * @var int $client_id L'ID du client.
     */
    private int $client_id;

    /**
     * @var float $montant Le montant du paiement.
     */
    private float $montant;

    /**
     * @var string $date La date du paiement.
     */
    private string $date;

    /**
     * Retourne l'ID du client.
     *
     * @return int
     */
    public function getClient()
    {
        return App::getDatabase()->prepare("SELECT * FROM Utilisateurs WHERE id = :id", ["id"=>$this->client_id], "App\\Entity\\UtilisateurEntity", true);
    }


    /**
     * Retourne le montant du paiement.
     *
     * @return float
     */
    public function getMontant(): float
    {
        return $this->montant;
    }

    /**
     * Définit le montant du paiement.
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
     * Retourne la date du paiement.
     *
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * Définit la date du paiement.
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
