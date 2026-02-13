<?php
/**
 * AdminController - Contrôleur pour l'administration
 */

class AdminController extends Controller
{
    public function index()
    {
        // Vérifier si admin
        if (!isset($_SESSION['isAdmin']) || !$_SESSION['isAdmin']) {
            $this->redirect('/');
            return;
        }
        
        $data = [
            'title' => 'Administration - ADIIL',
            'isLoggedIn' => true,
            'isAdmin' => true
        ];
        
        $this->view('admin/dashboard', $data);
    }
}
