<?php
/**
 * Classe Controller de base
 * Tous les contrôleurs héritent de cette classe
 */

class Controller
{
    /**
     * Charger un modèle
     */
    protected function model($model)
    {
        $modelPath = APP . '/models/' . $model . '.php';
        if (file_exists($modelPath)) {
            require_once $modelPath;
            return new $model();
        }
        return null;
    }

    /**
     * Charger une vue
     */
    protected function view($view, $data = [])
    {
        $viewPath = VIEWS . '/' . $view . '.php';
        if (file_exists($viewPath)) {
            extract($data);
            require_once $viewPath;
        } else {
            die("Vue introuvable : $view");
        }
    }

    /**
     * Redirection
     */
    protected function redirect($path)
    {
        // Forcer l'écriture de la session avant la redirection
        session_write_close();
        header("Location: " . APP_URL . $path);
        exit();
    }
}
