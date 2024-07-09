<?php

namespace App\Entity;

use App\Core\Entity;

/**
 * Classe représentant une entité de dette.
 */
class DetteEntity extends Entity
{
    /**
     * @var int
     */
    private $client_id;

    /**
     * @var int
     */
    private $vendeur_id;

    /**
     * @var float
     */
    private $montant;

    /**
     * @var bool
     */
    private $solder;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * Get the value of client_id
     *
     * @return int
     */
    public function getClientId(): int
    {
        return $this->client_id;
    }

    /**
     * Set the value of client_id
     *
     * @param int $client_id
     * @return self
     */
    public function setClientId(int $client_id): self
    {
        $this->client_id = $client_id;

        return $this;
    }

    /**
     * Get the value of vendeur_id
     *
     * @return int
     */
    public function getVendeurId(): int
    {
        return $this->vendeur_id;
    }

    /**
     * Set the value of vendeur_id
     *
     * @param int $vendeur_id
     * @return self
     */
    public function setVendeurId(int $vendeur_id): self
    {
        $this->vendeur_id = $vendeur_id;

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
     * Get the value of solder
     *
     * @return bool
     */
    public function getSolder(): bool
    {
        return $this->solder;
    }

    /**
     * Set the value of solder
     *
     * @param bool $solder
     * @return self
     */
    public function setSolder(bool $solder): self
    {
        $this->solder = $solder;

        return $this;
    }

    /**
     * Get the value of date
     *
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }

    /**
     * Set the value of date
     *
     * @param \DateTime $date
     * @return self
     */
    public function setDate(\DateTime $date): self
    {
        $this->date = $date;

        return $this;
    }
}
