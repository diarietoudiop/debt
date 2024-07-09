<?php

namespace App\Core;

/**
 * Classe abstraite Controller
 * @package App\Core
 *
 * Une classe de base pour les contrôleurs de l'application.
 */
abstract class Controller{
    protected $model;

    public function __construct() {
        Session::start();

        $modelName = str_replace("App\\Controller\\", "", static::class);
        $modelName = str_replace("Controller", "", $modelName);
        $this->model = App::getInstance()->getModel($modelName);
    }

    /**
     * Redirige vers une autre URL.
     *
     * @param string $url L'URL vers laquelle rediriger.
     * @return void
     */
    public function redirect(string $url) {
        header("Location: {$url}");
        exit;
    }


    /**
     * Affiche une vue.
     *
     * @param string $view Le nom de la vue à afficher.
     * @param array $data Les données à passer à la vue.
     * @param array $layout Le layout.
     * @return void
     */
    public function renderView(string $view, array $data = [], string $layout=null) {
        $viewPath = VIEW.$view;

        if (file_exists($viewPath)) {
            extract($data);
            ob_start();
            require_once $viewPath;
            $content = ob_get_clean();

            if($layout != null){
                require_once $layout;
            }else{
                echo $content;
            }
        } 
    }


}
