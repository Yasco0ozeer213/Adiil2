<?php
/**
 * LogoutController - Contrôleur pour la déconnexion
 * Redirige vers AuthController::logout()
 */

class LogoutController extends Controller
{
    public function index()
    {
        // Charger AuthController
        require_once APP . '/controllers/AuthController.php';
        
        // Appeler la méthode logout de AuthController
        $authController = new AuthController();
        $authController->logout();
    }
}
