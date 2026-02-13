<?php
/**
 * AgendaController - Contrôleur pour l'agenda/planning
 */

class AgendaController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Agenda - ADIIL',
            'isLoggedIn' => isset($_SESSION["userid"])
        ];
        
        $this->view('pages/agenda', $data);
    }
}
