<?php

namespace App\Core;

use \PDO;
use \PDOException;
use \InvalidArgumentException;

/**
 * Classe MysqlDatabase
 * @package App\Core
 *
 * Une classe pour gérer les interactions avec une base de données MySQL.
 */
final class MysqlDatabase
{

    /**
     * @var string Adresse du serveur de base de données.
     */
    private string $host;

    /**
     * @var string Nom de la base de données.
     */
    private string $db_name;

    /**
     * @var string Nom d'utilisateur pour la base de données.
     */
    private string $username;

    /**
     * @var string Mot de passe pour l'accès à la base de données.
     */
    private string $password;

    /**
     * @var PDO|null Instance de l'objet PDO pour la connexion à la base de données.
     */
    private ?PDO $pdo = null;

    /**
     * @var string|null Message d'erreur en cas d'échec de la connexion ou de requête.
     */
    private ?string $error = null;

    /**
     * Constructeur de la classe Database.
     *
     * @param string $host     Adresse du serveur de base de données.
     * @param string $db_name  Nom de la base de données.
     * @param string $username Nom d'utilisateur pour la base de données.
     * @param string $password Mot de passe pour l'accès à la base de données.
     * @param string $dbType   Type de base de données à utiliser (ex: "pgsql", "mysql", "sqlite").
     */
    public function __construct(string $host, string $db_name, string $username, string $password, string $dbType)
    {
        $this->host = $host;
        $this->db_name = $db_name;
        $this->username = $username;
        $this->password = $password;
        $this->getInstance($dbType); // Initialisation de la connexion dans le constructeur
    }
    

    /**
     * Initialise la connexion PDO à la base de données spécifiée.
     *
     * @param string $dbType Type de base de données à utiliser (ex: "pgsql", "mysql", "sqlite").
     *
     * @return void
     */
    private function getInstance(string $dbType): void {
        if ($this->pdo === null) {
            try {
                // Construction du DSN en fonction du type de base de données
                switch ($dbType) {
                    case 'postgresql':
                        $dsn = "pgsql:host={$this->host};port=5432;dbname={$this->db_name}";
                        break;
                    case 'mysql':
                        $dsn = "mysql:host={$this->host};dbname={$this->db_name};charset=utf8mb4";
                        break;
                    case 'sqlite':
                        $dsn = "sqlite:{$this->db_name}";
                        break;
                    default:
                        throw new InvalidArgumentException("Unsupported database type: {$dbType}");
                }

                // Connexion à la base de données avec PDO
                $this->pdo = new PDO($dsn, $this->username, $this->password);
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Activation des exceptions PDO
            } catch (PDOException $e) {
                $this->error = $e->getMessage(); // Enregistrement de l'erreur
                echo 'Connection failed: ' . $this->error; // Gestion d'erreur basique
                // Vous pouvez améliorer cette gestion d'erreur en utilisant des logs ou en lançant une exception personnalisée
            } catch (InvalidArgumentException $e) {
                $this->error = $e->getMessage(); // Enregistrement de l'erreur d'argument invalide
                echo 'Connection failed: ' . $this->error; // Gestion d'erreur pour type de base de données non supporté
            }
        }
    }

    
    /**
     * Retourne l'objet PDO pour la connexion à la base de données.
     *
     * @return PDO|null Instance de l'objet PDO ou null si la connexion a échoué.
     */
    public function getConnection(): ?PDO {
        return $this->pdo; // Retourne l'objet PDO ou null si la connexion a échoué
    }


    /**
     * Exécute une requête SQL et retourne les résultats sous forme d'objets d'une classe spécifiée.
     *
     * @param string $sql       Requête SQL à exécuter.
     * @param string $className Nom de la classe des objets à retourner.
     * @param bool   $single    Indique si l'on souhaite récupérer un seul résultat ou plusieurs (par défaut).
     *
     * @return array|mixed Tableau d'objets ou un objet unique selon le paramètre $single.
     */
    public function query(string $sql, string $className = null, bool $single = false) {
        try {
            $stmt = $this->pdo->query($sql); // Exécution de la requête SQL
            if($className)
                $stmt->setFetchMode(PDO::FETCH_CLASS, $className); // Définition du mode de récupération des résultats
            if ($single) {
                return $stmt->fetch(); // Renvoie un seul résultat si demandé
            }
            return $stmt->fetchAll(); // Renvoie tous les résultats par défaut
        } catch (PDOException $e) {
            $this->error = $e->getMessage(); // Enregistrement de l'erreur en cas d'échec de la requête
            // Gestion d'erreur : vous pouvez choisir de logger l'erreur ou de lancer une exception ici
            echo 'Query failed: ' . $this->error;
            return []; // Retourne un tableau vide en cas d'échec de la requête
        }
    }

    /**
     * Prépare et exécute une requête SQL avec des données liées et retourne les résultats sous forme d'objets d'une classe spécifiée.
     *
     * @param string $sql       Requête SQL préparée à exécuter.
     * @param array  $data      Données à lier à la requête préparée.
     * @param string $className Nom de la classe des objets à retourner.
     * @param bool   $single    Indique si l'on souhaite récupérer un seul résultat ou plusieurs (par défaut).
     *
     * @return array|mixed Tableau d'objets ou un objet unique selon le paramètre $single.
     */
    public function prepare(string $sql, array $data, string $className=null, bool $single = false) {
        try {
            $stmt = $this->pdo->prepare($sql); // Préparation de la requête SQL
            $stmt->execute($data); // Exécution de la requête avec les données fournies
            
            if($className)
                $stmt->setFetchMode(PDO::FETCH_CLASS, $className); // Définition du mode de récupération des résultats
            if ($single) {
                return $stmt->fetch(); // Renvoie un seul résultat si demandé
            }
            return $stmt->fetchAll(); // Renvoie tous les résultats par défaut
        } catch (PDOException $e) {
            $this->error = $e->getMessage(); // Enregistrement de l'erreur en cas d'échec de la requête préparée
            // Gestion d'erreur : vous pouvez choisir de logger l'erreur ou de lancer une exception ici
            echo 'Prepare failed: ' . $this->error;
            return []; // Retourne un tableau vide en cas d'échec de la requête préparée
        }
    }
}
