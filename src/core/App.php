<?php

namespace App\Core;

/**
 * Classe App
 * @package App\Core
 *
 * Une classe principale pour gérer l'application.
 */
class App{

    private static $database;
    private static $instance;

    /**
     * Récupère l'instance de la base de données.
     *
     * @return mixed L'instance de la base de données.
     */
    public static function getDatabase():MysqlDatabase {
        if (self::$database === null) {
            self::$database = new MysqlDatabase(DB_HOST, DB_NAME, DB_USERNAME, DB_PASSWORD, DB_TYPE);
        }
        return self::$database;
    }

    /**
     * Récupère l'instance de l'application.
     *
     * @return App L'instance de l'application.
     */
    public static function getInstance():App {
        if (self::$instance === null) {
            self::$instance = new App();
        }
        return self::$instance;
    }

    /**
     * Récupère un modèle.
     *
     * @param string $model Le nom du modèle à récupérer.
     * @return Model Le modèle correspondant.
     */
    public function getModel(string $model) {
        
        $model = "App\\Model\\{$model}Model";

        if(class_exists($model)){
            $model = new $model();
            return $model;
        }
        return null;
    }

    /**
     * Gère les cas où une ressource n'est pas trouvée.
     *
     * @return void
     */
    public function notFound() {
        header("HTTP/1.0 404 Not Found");
        exit;
    }

    /**
     * Gère les cas où l'accès est interdit.
     *
     * @return void
     */
    public function forbidden() {
        header("HTTP/1.0 403 Forbidden");
        exit;
    }
}
