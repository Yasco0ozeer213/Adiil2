<?php
/**
 * LoginController - Contrôleur pour la page de connexion
 * Redirige vers AuthController::login()
 */

class LoginController extends Controller
{
    public function index()
    {
        // Charger AuthController
        require_once APP . '/controllers/AuthController.php';
        
        // Appeler la méthode login de AuthController
        $authController = new AuthController();
        $authController->login();
    }
}
