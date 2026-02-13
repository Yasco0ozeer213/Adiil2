<?php
/**
 * Point d'entrée principal de l'application
 */

// Démarrer la session
session_start();

// Charger la configuration
require_once __DIR__ . '/../config/config.php';

// Charger les classes du core
require_once CORE . '/Database.php';
require_once CORE . '/Controller.php';
require_once CORE . '/Router.php';

// Créer un alias pour la classe Database (pour compatibilité avec le code existant)
class_alias('Database', 'DB');

// Initialiser le routeur
$router = new Router();
