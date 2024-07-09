<?php

namespace App\Core;

use PDO;
use PDOException;

/**
 * Classe SecurityDatabase
 * @package App\Core
 *
 * Une classe pour gérer la sécurité et l'authentification via la base de données.
 */
final class SecurityDatabase
{
    private $database;
    private static $instance;

    /**
     * Constructeur de la classe SecurityDatabase.
     * Initialise la connexion à la base de données.
     */
    private function __construct()
    {
        $this->database = App::getDatabase();
    }


        /**
     * Récupère l'instance de l'application.
     *
     * @return SecurityDatabase L'instance de l'application.
     */
    public static function getInstance():SecurityDatabase {
        if (self::$instance === null) {
            self::$instance = new SecurityDatabase();
        }
        return self::$instance;
    }

    /**
     * Gère la connexion d'un utilisateur.
     *
     * @param string $username Le nom d'utilisateur.
     * @param string $password Le mot de passe.
     * @return bool True si la connexion est réussie, false sinon.
     */
    public function login($login, $password)
    {

        $loginHash = sha1($login);
        $passwordHash = sha1($password);
        $query = "SELECT * FROM Utilisateurs WHERE login = :login AND password = :password";
        $user = $this->database->prepare($query, ["login"=>$loginHash, "password"=>$passwordHash ], null, true);
        if ($user) {
            // Démarrer la session et stocker les informations de l'utilisateur
            Session::start();
            Session::set("user_id", $user["id"]);
            return true;
        }

        return false;
    }

    /**
     * Vérifie si un utilisateur est connecté.
     *
     * @return bool True si un utilisateur est connecté, false sinon.
     */
    public function isLogged()
    {
        Session::start();
        return Session::isset("user_id");
    }

    /**
     * Récupère les rôles de l'utilisateur connecté.
     *
     * @return array Un tableau des rôles de l'utilisateur.
     */
    public function getRoles($userId)
    {
        $query = "SELECT r.libelle FROM `Utilisateurs` u JOIN `Roles` r ON r.id = u.role_id WHERE u.id = :user_id";
        return $this->database->prepare($query, ["user_id"=>$userId], null, true)["libelle"];
    }

    /**
     * Récupère les informations de l'utilisateur connecté.
     *
     * @return mixed Les informations de l'utilisateur connecté.
     */
    public function getUserLogged()
    {
        Session::start();
        if ( Session::isset("user_id") ) {
            $query = "SELECT * FROM Utilisateurs WHERE id = :user_id";
            return $this->database->prepare($query, ["user_id" => Session::get("user_id")], "App\Entity\UtilisateurEntity", true);
        }
        return null;
    }
}
