<?php
namespace App\Entity;

use App\Core\Entity;
use App\Core\SecurityDatabase;

/**
 * Classe représentant une entité de client.
 */
class UtilisateurEntity extends Entity
{

    /**
     * Le prénom du client.
     *
     * @var string
     */
    private $prenom;

    /**
     * Le nom du client.
     *
     * @var string
     */
    private $nom;

    /**
     * L'adresse du client.
     *
     * @var string
     */
    private $adresse;

    /**
     * La photo du client.
     *
     * @var string
     */
    private $photo;

    /**
     * Le numéro de téléphone du client.
     *
     * @var string
     */
    private $telephone;
    private $login;
    private $password;
    private $role_id;
    private $email;

    public function getLogin()
    {
        return $this->login;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setLogin(string $login)
    {
        $this->login = $login;
    }

    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    public function getRole(){
        return $this->role_id == 1? "Vendeur":"Client";
    }

    public function getEmail(){
        return $this->email;
    }

    public function setEmail($value){
        $this->email = $value;
    }




    /**
     * Récupère le prénom du client.
     *
     * @return string Le prénom du client
     */
    public function getPrenom(): string
    {
        return $this->prenom;
    }

    /** 
     * Récupère le nom du client.
     *
     * @return string Le nom du client
     */
    public function getNom(): string
    {
        return $this->nom;
    }

    /**
     * Récupère l'adresse du client.
     *
     * @return string L'adresse du client
     */
    public function getAdresse(): string
    {
        return $this->adresse;
    }

    /**
     * Récupère la photo du client.
     *
     * @return string La photo du client
     */
    public function getPhoto(): string
    {
        return $this->photo;
    }

    /**
     * Récupère le numéro de téléphone du client.
     *
     * @return string Le numéro de téléphone du client
     */
    public function getTelephone(): string
    {
        return $this->telephone;
    }

    /**
     * Définit le prénom du client.
     *
     * @param string $prenom Le prénom du client
     */
    public function setPrenom(string $prenom): void
    {
        $this->prenom = $prenom;
    }

    /**
     * Définit le nom du client.
     *
     * @param string $nom Le nom du client
     */
    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    /**
     * Définit l'adresse du client.
     *
     * @param string $adresse L'adresse du client
     */
    public function setAdresse(string $adresse): void
    {
        $this->adresse = $adresse;
    }

    /**
     * Définit la photo du client.
     *
     * @param string $photo La photo du client
     */
    public function setPhoto(string $photo): void
    {
        $this->photo = $photo;
    }

    /**
     * Définit le numéro de téléphone du client.
     *
     * @param string $telephone Le numéro de téléphone du client
     */
    public function setTelephone(string $telephone): void
    {
        $this->telephone = $telephone;
    }
}
