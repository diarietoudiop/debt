<?php
namespace App\Core;

use ReflectionClass;

/**
 * Classe App
 * @package App\Core
 *
 * Une classe principale pour gérer l'application.
 */
class App {
    private static $database;
    private static $instance;

    /**
     * Récupère l'instance de la base de données.
     *
     * @return mixed L'instance de la base de données.
     */
    public static function getDatabase(): MysqlDatabase {
        if (self::$database === null) {
            self::$database = self::createInstance(MysqlDatabase::class, [DB_HOST, DB_NAME, DB_USERNAME, DB_PASSWORD, DB_TYPE]);
        }
        return self::$database;
    }

    /**
     * Récupère l'instance de l'application.
     *
     * @return App L'instance de l'application.
     */
    public static function getInstance(): App {
        if (self::$instance === null) {
            self::$instance = self::createInstance(static::class);
        }
        return self::$instance;
    }

    /**
     * Récupère un modèle.
     *
     * @param string $model Le nom du modèle à récupérer.
     * @return Model|null Le modèle correspondant.
     */
    public function getModel(string $model) {
        $modelClass = "App\\Model\\{$model}Model";
        if (class_exists($modelClass)) {
            return self::createInstance($modelClass);
        }
        return null;
    }

    /**
     * Crée une instance d'une classe en utilisant la réflexion.
     *
     * @param string $className Le nom complet de la classe à instancier.
     * @param array $parameters Les paramètres à passer au constructeur.
     * @return object L'instance créée.
     */
    private static function createInstance(string $className, array $parameters = []): object {
        $reflectionClass = new ReflectionClass($className);
        return $reflectionClass->newInstanceArgs($parameters);
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