<?php
/**
 * SigninController - Contrôleur pour la page d'inscription
 * Redirige vers AuthController::signin()
 */

class SigninController extends Controller
{
    public function index()
    {
        // Charger AuthController
        require_once APP . '/controllers/AuthController.php';
        
        // Appeler la méthode signin de AuthController
        $authController = new AuthController();
        $authController->signin();
    }
}
