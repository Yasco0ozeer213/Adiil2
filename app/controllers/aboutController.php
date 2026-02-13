<?php
/**
 * AboutController - Contrôleur de la page À propos
 */

class AboutController extends Controller
{
    public function index()
    {
        // Page à propos - pas de logique, juste afficher la vue
        $data = [
            'title' => 'À propos - ADIIL'
        ];
        
        $this->view('pages/about', $data);
    }
}
