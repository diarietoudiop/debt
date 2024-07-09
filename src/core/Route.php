<?php

namespace App\Core;

/**
 * Classe Route
 * @package App\Core
 *
 * Une classe pour gérer les routes de l'application.
 */
class Route
{

    private static array $routes = [];

    /**
     * Définit une route pour une requête POST.
     *
     * @param string $path Le chemin de la route.
     * @param array $action L'action à exécuter lorsque la route est atteinte.
     * @return void
     */
    public static function post(string $path, array $action)
    {
        // Implémentation ici
        self::$routes["POST"][$path] = $action;
    }

    /**
     * Définit une route pour une requête GET.
     *
     * @param string $path Le chemin de la route.
     * @param array $action L'action à exécuter lorsque la route est atteinte.
     * @return void
     */
    public static function get(string $path, array $action)
    {
        // Implémentation ici
        self::$routes["GET"][$path] = $action;
    }


    public static function run($url)
    {
        if (array_key_exists($url, self::$routes[$_SERVER["REQUEST_METHOD"]])) {
            $action = self::$routes[$_SERVER["REQUEST_METHOD"]][$url];
            $controller = $action[0];
            $method = isset($action[1])?$action[1]:"index";
            
            if(!class_exists($controller)){
                echo "Le controller n'existe pas";
                return;
            }
            

            $controllerInstance = new $controller();

            if(is_callable($method)){
                call_user_func($method);
            }else{

                if(method_exists($controller, $method)){
                    $controllerInstance->$method();
                }else{
                    return "La méthode $method n'exist pas dans la classe $controller";
                }
            }
        }else{

            echo  "Erreur 404";
            // App::getInstance()->notFound();
        }
    }
}




// $routes = [
//     "GET" => [
//         "/" => ["ClientController","index]
//     ],
//     "POSt" => []
// ];
