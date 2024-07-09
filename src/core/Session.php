<?php

namespace App\Core;

/**
 * Classe Session
 * @package App\Core
 *
 * Une classe utilitaire pour gérer les opérations de session.
 */
final class Session{

    private function __construct(){}

    /**
     * Démarre une nouvelle session ou reprend une session existante.
     *
     * @return void
     */
    public static function start() {
        
        // On vérifie si une session n'est pas active
        if(session_status() === PHP_SESSION_DISABLED){
            session_start();
        }
    }

    /**
     * Ferme la session actuelle et écrit les données de session.
     *
     * @return void
     */
    public static function close() {

        // On véfifie si une session est active
        if(session_status() === PHP_SESSION_ACTIVE){
            session_destroy();
        }
    }

    /**
     * Récupère une valeur de la session.
     *
     * @param string $key La clé de la valeur de session à récupérer.
     * @return mixed La valeur associée à la clé, ou null si non trouvée.
     */
    public static function get(string $key) {
        self::start();
        return isset($_SESSION[$key])?$_SESSION[$key]:null; 
    }

    /**
     * Définit une valeur dans la session.
     *
     * @param string $key La clé à associer à la valeur.
     * @param mixed $value La valeur à stocker dans la session.
     * @return void
     */
    public static function set(string $key, mixed $value) {
        self::start();
        $_SESSION[$key] = $value;
    }

    /**
     * Vérifie si une clé est définie dans la session.
     *
     * @param string $key La clé à vérifier dans la session.
     * @return bool True si la clé est définie, false sinon.
     */
    public static function isset(string $key): bool {
        self::start();
        return isset($_SESSION[$key]);
    }

    /**
     * Supprime une valeur de la session.
     *
     * @param string $key La clé de la valeur à supprimer de la session.
     * @return void
     */
    public static function unset(string $key) {
        if(self::isset($key)){
            unset($_SESSION[$key]);
        }
    }
}
