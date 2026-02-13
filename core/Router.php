<?php
/**
 * Classe Router - Gestion du routage de l'application
 */

class Router
{
    private $controller = 'HomeController';
    private $method = 'index';
    private $params = [];

    public function __construct()
    {
        $url = $this->parseUrl();

        // Vérifier si un contrôleur existe
        if (isset($url[0])) {
            $controllerName = ucfirst($url[0]) . 'Controller';
            $controllerPath = APP . '/controllers/' . $controllerName . '.php';
            
            if (file_exists($controllerPath)) {
                $this->controller = $controllerName;
                unset($url[0]);
            }
        }

        // Inclure le contrôleur
        require_once APP . '/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        // Vérifier si une méthode existe
        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        // Récupérer les paramètres
        $this->params = $url ? array_values($url) : [];

        // Appeler la méthode du contrôleur avec les paramètres
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    private function parseUrl()
    {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
        return [];
    }
}
