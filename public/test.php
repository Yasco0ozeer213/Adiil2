<?php
/**
 * Fichier de test pour vérifier que la structure MVC fonctionne
 * Accéder à ce fichier via : http://localhost/test.php ou http://adiil.local/test.php
 * 
 * ⚠️ Supprimer ce fichier une fois la migration terminée !
 */

// Démarrer la session
session_start();

// Chemins absolus
$rootPath = '/Applications/MAMP/htdocs/sae4/Adiil2';

// Charger la configuration
require_once $rootPath . '/config/config.php';

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Structure MVC - ADIIL</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        h1 {
            color: #333;
            border-bottom: 3px solid #4CAF50;
            padding-bottom: 10px;
        }
        .test-section {
            background: white;
            padding: 20px;
            margin: 20px 0;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .success {
            color: #4CAF50;
            font-weight: bold;
        }
        .error {
            color: #f44336;
            font-weight: bold;
        }
        .warning {
            color: #ff9800;
            font-weight: bold;
        }
        .info {
            color: #2196F3;
        }
        pre {
            background: #f5f5f5;
            padding: 10px;
            border-radius: 3px;
            overflow-x: auto;
        }
        .status-icon {
            font-size: 20px;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <h1>🧪 Test de la Structure MVC - ADIIL</h1>
    
    <div class="test-section">
        <h2>1. Configuration PHP</h2>
        <?php
        echo "<p><span class='status-icon'>✅</span><span class='success'>PHP Version: " . phpversion() . "</span></p>";
        echo "<p><span class='info'>Date du serveur: " . date('d/m/Y H:i:s') . "</span></p>";
        ?>
    </div>

    <div class="test-section">
        <h2>2. Variables d'environnement (.env)</h2>
        <?php
        if (file_exists(__DIR__ . '/.env')) {
            echo "<p><span class='status-icon'>✅</span><span class='success'>Fichier .env trouvé</span></p>";
            
            echo "<p><strong>Configuration :</strong></p>";
            echo "<pre>";
            echo "DB_HOST: " . (defined('DB_HOST') ? DB_HOST : '❌ Non défini') . "\n";
            echo "DB_NAME: " . (defined('DB_NAME') ? DB_NAME : '❌ Non défini') . "\n";
            echo "DB_USER: " . (defined('DB_USER') ? DB_USER : '❌ Non défini') . "\n";
            echo "DB_PASSWORD: " . (defined('DB_PASSWORD') ? (DB_PASSWORD ? '***' : 'Vide') : '❌ Non défini') . "\n";
            echo "APP_ENV: " . (defined('APP_ENV') ? APP_ENV : '❌ Non défini') . "\n";
            echo "APP_DEBUG: " . (defined('APP_DEBUG') ? (APP_DEBUG ? 'true' : 'false') : '❌ Non défini') . "\n";
            echo "</pre>";
        } else {
            echo "<p><span class='status-icon'>❌</span><span class='error'>Fichier .env non trouvé !</span></p>";
            echo "<p class='warning'>→ Copier .env.example vers .env et le configurer</p>";
        }
        ?>
    </div>

    <div class="test-section">
        <h2>3. Constantes de chemins</h2>
        <?php
        echo "<pre>";
        echo "ROOT: " . (defined('ROOT') ? ROOT : '❌ Non défini') . "\n";
        echo "APP: " . (defined('APP') ? APP : '❌ Non défini') . "\n";
        echo "CORE: " . (defined('CORE') ? CORE : '❌ Non défini') . "\n";
        echo "PUBLIC_PATH: " . (defined('PUBLIC_PATH') ? PUBLIC_PATH : '❌ Non défini') . "\n";
        echo "VIEWS: " . (defined('VIEWS') ? VIEWS : '❌ Non défini') . "\n";
        echo "</pre>";
        ?>
    </div>

    <div class="test-section">
        <h2>4. Fichiers Core</h2>
        <?php
        $coreFiles = [
            'Database' => CORE . '/Database.php',
            'Controller' => CORE . '/Controller.php',
            'Router' => CORE . '/Router.php'
        ];
        
        foreach ($coreFiles as $name => $path) {
            if (file_exists($path)) {
                echo "<p><span class='status-icon'>✅</span><span class='success'>$name.php trouvé</span></p>";
            } else {
                echo "<p><span class='status-icon'>❌</span><span class='error'>$name.php non trouvé à: $path</span></p>";
            }
        }
        ?>
    </div>

    <div class="test-section">
        <h2>5. Structure des dossiers</h2>
        <?php
        $requiredDirs = [
            'app/controllers',
            'app/models',
            'app/views/layouts',
            'app/views/pages',
            'app/views/admin',
            'config',
            'core',
            'public/assets',
            'public/styles',
            'public/scripts',
            'public/uploads'
        ];
        
        $allExist = true;
        foreach ($requiredDirs as $dir) {
            $fullPath = ROOT . '/' . $dir;
            if (is_dir($fullPath)) {
                echo "<p><span class='status-icon'>✅</span><span class='success'>$dir/</span></p>";
            } else {
                echo "<p><span class='status-icon'>❌</span><span class='error'>$dir/ non trouvé</span></p>";
                $allExist = false;
            }
        }
        
        if ($allExist) {
            echo "<p><strong><span class='success'>Tous les dossiers requis existent !</span></strong></p>";
        }
        ?>
    </div>

    <div class="test-section">
        <h2>6. Connexion à la base de données</h2>
        <?php
        try {
            require_once CORE . '/Database.php';
            $db = new Database();
            $conn = $db->connect();
            
            if ($conn) {
                echo "<p><span class='status-icon'>✅</span><span class='success'>Connexion à la base de données réussie !</span></p>";
                echo "<p class='info'>Base de données: " . DB_NAME . "</p>";
                
                // Tester une requête simple
                $result = $conn->query("SELECT VERSION() as version");
                if ($result) {
                    $row = $result->fetch_assoc();
                    echo "<p class='info'>Version MySQL: " . $row['version'] . "</p>";
                }
                
                $conn->close();
            } else {
                echo "<p><span class='status-icon'>❌</span><span class='error'>Échec de la connexion à la base de données</span></p>";
            }
        } catch (Exception $e) {
            echo "<p><span class='status-icon'>❌</span><span class='error'>Erreur: " . $e->getMessage() . "</span></p>";
            echo "<p class='warning'>→ Vérifier les paramètres dans .env</p>";
        }
        ?>
    </div>

    <div class="test-section">
        <h2>7. Contrôleurs</h2>
        <?php
        $controllers = glob(APP . '/controllers/*.php');
        if (!empty($controllers)) {
            echo "<p><span class='status-icon'>✅</span><span class='success'>" . count($controllers) . " contrôleur(s) trouvé(s) :</span></p>";
            echo "<ul>";
            foreach ($controllers as $controller) {
                echo "<li>" . basename($controller) . "</li>";
            }
            echo "</ul>";
        } else {
            echo "<p><span class='status-icon'>⚠️</span><span class='warning'>Aucun contrôleur trouvé</span></p>";
        }
        ?>
    </div>

    <div class="test-section">
        <h2>8. Modèles</h2>
        <?php
        $models = glob(APP . '/models/*.php');
        if (!empty($models)) {
            echo "<p><span class='status-icon'>✅</span><span class='success'>" . count($models) . " modèle(s) trouvé(s) :</span></p>";
            echo "<ul>";
            foreach ($models as $model) {
                echo "<li>" . basename($model) . "</li>";
            }
            echo "</ul>";
        } else {
            echo "<p><span class='status-icon'>⚠️</span><span class='warning'>Aucun modèle trouvé</span></p>";
        }
        ?>
    </div>

    <div class="test-section">
        <h2>9. Vues (Layouts)</h2>
        <?php
        $layoutFiles = [
            'header.php' => VIEWS . '/layouts/header.php',
            'footer.php' => VIEWS . '/layouts/footer.php'
        ];
        
        foreach ($layoutFiles as $name => $path) {
            if (file_exists($path)) {
                echo "<p><span class='status-icon'>✅</span><span class='success'>$name trouvé</span></p>";
            } else {
                echo "<p><span class='status-icon'>⚠️</span><span class='warning'>$name non trouvé (à migrer)</span></p>";
            }
        }
        ?>
    </div>

    <div class="test-section">
        <h2>10. Assets</h2>
        <?php
        $assetsCount = count(glob(PUBLIC_PATH . '/assets/*'));
        $stylesCount = count(glob(PUBLIC_PATH . '/styles/*.css'));
        $scriptsCount = count(glob(PUBLIC_PATH . '/scripts/*.js'));
        
        echo "<p><span class='info'>Assets: $assetsCount fichier(s)</span></p>";
        echo "<p><span class='info'>Styles CSS: $stylesCount fichier(s)</span></p>";
        echo "<p><span class='info'>Scripts JS: $scriptsCount fichier(s)</span></p>";
        
        if ($assetsCount === 0 && $stylesCount === 0 && $scriptsCount === 0) {
            echo "<p><span class='status-icon'>⚠️</span><span class='warning'>Aucun asset trouvé (à migrer depuis les dossiers racine)</span></p>";
        }
        ?>
    </div>

    <div class="test-section">
        <h2>✅ Résumé</h2>
        <?php
        $issues = [];
        
        if (!file_exists(__DIR__ . '/.env')) {
            $issues[] = "Créer et configurer le fichier .env";
        }
        
        if (!file_exists(VIEWS . '/layouts/header.php')) {
            $issues[] = "Migrer header.php vers app/views/layouts/";
        }
        
        if (!file_exists(VIEWS . '/layouts/footer.php')) {
            $issues[] = "Migrer footer.php vers app/views/layouts/";
        }
        
        if ($assetsCount === 0) {
            $issues[] = "Copier les assets vers public/assets/";
        }
        
        if ($stylesCount === 0) {
            $issues[] = "Copier les styles vers public/styles/";
        }
        
        if ($scriptsCount === 0) {
            $issues[] = "Copier les scripts vers public/scripts/";
        }
        
        if (empty($issues)) {
            echo "<p><span class='status-icon'>🎉</span><strong class='success'>Tout est prêt ! La structure MVC est opérationnelle !</strong></p>";
            echo "<p class='info'>Vous pouvez maintenant commencer à migrer vos pages.</p>";
            echo "<p class='warning'>⚠️ N'oubliez pas de supprimer ce fichier (public/test.php) une fois la migration terminée !</p>";
        } else {
            echo "<p><span class='status-icon'>⚠️</span><strong class='warning'>Actions restantes :</strong></p>";
            echo "<ul>";
            foreach ($issues as $issue) {
                echo "<li>$issue</li>";
            }
            echo "</ul>";
            echo "<p class='info'>Voir DEMARRAGE_RAPIDE.md et MIGRATION_GUIDE.md pour les instructions.</p>";
        }
        ?>
    </div>

    <div class="test-section">
        <h2>📚 Documentation</h2>
        <ul>
            <li><strong>RESUME.md</strong> - Vue d'ensemble de ce qui a été fait</li>
            <li><strong>DEMARRAGE_RAPIDE.md</strong> - Configuration et premiers pas</li>
            <li><strong>MIGRATION_GUIDE.md</strong> - Guide détaillé de migration</li>
            <li><strong>ORGANISATION_EQUIPE.md</strong> - Travail en équipe</li>
            <li><strong>README_MVC.md</strong> - Documentation complète MVC</li>
        </ul>
    </div>

    <p style="text-align: center; color: #666; margin-top: 50px;">
        <small>ADIIL - Structure MVC - Test effectué le <?php echo date('d/m/Y à H:i:s'); ?></small>
    </p>
</body>
</html>
