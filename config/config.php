<?php
/**
 * Fichier de configuration - Chargement des variables d'environnement
 */

// Charger les variables du fichier .env
function loadEnv($path) {
    if (!file_exists($path)) {
        die('.env file not found');
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        // Ignorer les commentaires
        if (strpos(trim($line), '#') === 0) {
            continue;
        }

        // Parser la ligne
        list($name, $value) = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value);

        // Définir la variable d'environnement
        if (!array_key_exists($name, $_ENV)) {
            putenv(sprintf('%s=%s', $name, $value));
            $_ENV[$name] = $value;
            $_SERVER[$name] = $value;
        }
    }
}

// Charger le fichier .env
loadEnv(__DIR__ . '/../.env');

// Configuration de la base de données
define('DB_HOST', getenv('DB_HOST'));
define('DB_PORT', getenv('DB_PORT'));
define('DB_NAME', getenv('DB_NAME'));
define('DB_USER', getenv('DB_USER'));
define('DB_PASSWORD', getenv('DB_PASSWORD'));

// Configuration de l'application
define('APP_ENV', getenv('APP_ENV'));
define('APP_DEBUG', getenv('APP_DEBUG') === 'true');
define('APP_URL', getenv('APP_URL'));

// Chemins
define('ROOT', dirname(__DIR__));
define('APP', ROOT . '/app');
define('CORE', ROOT . '/core');
define('PUBLIC_PATH', ROOT . '/public');
define('VIEWS', APP . '/views');
define('UPLOAD_PATH', PUBLIC_PATH . getenv('UPLOAD_PATH'));
define('ASSETS_PATH', PUBLIC_PATH . getenv('ASSETS_PATH'));

// Session
define('SESSION_LIFETIME', getenv('SESSION_LIFETIME'));

// Affichage des erreurs en mode debug
if (APP_DEBUG) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}
