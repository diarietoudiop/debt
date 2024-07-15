<?php

namespace App\Core;

use \Exception;
use ReflectionMethod;


// class Route
// {

//     private static array $routes = [];


//     public static function post(string $path, array $action)
//     {
//         self::$routes["POST"][$path] = $action;
//     }


//     public static function get(string $path, array $action)
//     {
//         self::$routes["GET"][$path] = $action;
//     } 


//     public static function run($url)
//     {
//         if (array_key_exists($url, self::$routes[$_SERVER["REQUEST_METHOD"]])) {
//             $action = self::$routes[$_SERVER["REQUEST_METHOD"]][$url];
//             $controller = $action[0];
//             $method = isset($action[1])?$action[1]:"index";
            
//             if(!class_exists($controller)){
//                 echo "Le controller n'existe pas";
//                 return;
//             }
            

//             $controllerInstance = new $controller();

//             if(is_callable($method)){
//                 call_user_func($method);
//             }else{

//                 if(method_exists($controller, $method)){
//                     $controllerInstance->$method();
//                 }else{
//                     return "La méthode $method n'exist pas dans la classe $controller";
//                 }
//             }
//         }else{

//             echo  "Erreur 404";
//         }
//     }
// }


// class Route
// {
//     private static $routes = [];
//     private static $instance = null;

//     private function __construct() {}

//     public static function getInstance()
//     {
//         if (self::$instance === null) {
//             self::$instance = new self();
//         }
//         return self::$instance;
//     }
//     public static function get($path, $controller, $action)
//     {
//         self::addRoute('GET', $path, $controller, $action);
//     }

//     public static function post($path, $controller, $action)
//     {
//         self::addRoute('POST', $path, $controller, $action);
//     }

//     private static function addRoute($method, $path, $controller, $action)
//     {
//         self::$routes[] = [
//             'method' => $method,
//             'path' => $path,
//             'controller' => $controller,
//             'action' => $action
//         ];
//     }

//     public function handleRequest($method, $uri)
//     {
//         foreach (self::$routes as $route) {
//             if ($this->matchRoute($route, $method, $uri)) {
//                 return $this->callAction($route['controller'], $route['action']);
//             }
//         }
        
//         // Si aucune route ne correspond
//         http_response_code(404);
//         echo "404 Not Found";
//     }

//     private function matchRoute($route, $method, $uri)
//     {
//         if ($route['method'] !== $method) {
//             return false;
//         }

//         $pattern = $this->convertPathToRegex($route['path']);
//         return preg_match($pattern, $uri);
//     }

//     private function convertPathToRegex($path)
//     {
//         $pattern = preg_replace('/\/{([^\/]+)}/', '/(?P<$1>[^/]+)', $path);
//         return '#^' . $pattern . '$#';
//     }

//     private function callAction($controller, $action)
//     {
//         if (!class_exists($controller)) {
//             throw new Exception("Controller class $controller not found");
//         }

//         $controllerInstance = new $controller();

//         if (!method_exists($controllerInstance, $action)) {
//             throw new Exception("Action $action not found in controller $controller");
//         }

//         $reflection = new ReflectionMethod($controller, $action);
//         $params = $this->getActionParameters($reflection);

//         return $reflection->invokeArgs($controllerInstance, $params);
//     }

//     private function getActionParameters(ReflectionMethod $reflection)
//     {
//         $params = [];
//         foreach ($reflection->getParameters() as $param) {
//             if (isset($_GET[$param->getName()])) {
//                 $params[] = $_GET[$param->getName()];
//             } elseif (isset($_POST[$param->getName()])) {
//                 $params[] = $_POST[$param->getName()];
//             } elseif ($param->isDefaultValueAvailable()) {
//                 $params[] = $param->getDefaultValue();
//             } else {
//                 throw new Exception("Parameter {$param->getName()} is required but not provided");
//             }
//         }
//         return $params;
//     }
// }


use ReflectionClass;
use ReflectionException;


class Route
{
    private static array $routes = [];

    public static function add(string $method, string $path, array $action)
    {
        self::$routes[strtoupper($method)][$path] = $action;
    }

    public static function get(string $path, array $action)
    {
        self::add('GET', $path, $action);
    }

    public static function post(string $path, array $action)
    {
        self::add('POST', $path, $action);
    }

    public static function run($url)
    {
        $method = $_SERVER["REQUEST_METHOD"];
        $route = self::match($method, $url);
        if ($route) {
            [$controller, $action] = $route;
            self::invokeAction($controller, $action, self::extractParameters($route, $url));
        } else {
            self::sendResponse(['error' => "Route not found"], 404);
        }
    }

    private static function match($method, $url)
    {
        if (isset(self::$routes[$method])) {
            foreach (self::$routes[$method] as $path => $action) {
                if (preg_match(self::convertToRegex($path), $url, $matches)) {
                    return [$action[0], $action[1], array_slice($matches, 1)];
                }
            }
        }
        return false;
    }

    private static function convertToRegex($path)
    {
        $path = preg_replace('/\{[a-zA-Z0-9_]+\}/', '([a-zA-Z0-9_]+)', $path);
        return "#^$path$#";
    }

    private static function invokeAction($controller, $action, $params)
    {
        try {
            $reflectionClass = new ReflectionClass($controller);
            $controllerInstance = $reflectionClass->newInstance();
            $reflectionMethod = $reflectionClass->getMethod($action);
            $response = $reflectionMethod->invokeArgs($controllerInstance, $params);
            self::sendResponse($response);
        } catch (ReflectionException $e) {
            self::sendResponse(['error' => $e->getMessage()], 404);
        }
    }

    private static function extractParameters($route, $url)
    {
        [$controller, $action, $params] = $route;
        return $params;
    }

    private static function sendResponse($response, $statusCode = 200)
    {
        // http_response_code($statusCode);
        // header('Content-Type: application/json');
        // echo json_encode($response);
    }
}

