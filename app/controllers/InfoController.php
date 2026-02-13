<?php
/**
 * InfoController - Contrôleur pour afficher les informations PHP
 */

class InfoController extends Controller
{
    public function index()
    {
        phpinfo();
    }
}
