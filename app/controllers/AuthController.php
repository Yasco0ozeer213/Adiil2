<?php
/**
 * AuthController - Contrôleur pour l'authentification
 */

class AuthController extends Controller
{
    public function login()
    {
        // DEBUG
        error_log("=== AuthController::login() appelé ===");
        error_log("Method: " . $_SERVER['REQUEST_METHOD']);
        error_log("POST data: " . json_encode($_POST));
        error_log("Session avant: " . json_encode($_SESSION));
        
        // Si déjà connecté, rediriger
        if (isset($_SESSION["userid"])) {
            error_log("REDIRECT: Déjà connecté → /");
            $this->redirect('/');
            return;
        }
        
        // Initialiser les variables
        $login_error = null;
        
        // Traitement du formulaire de connexion
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mail']) && isset($_POST['password'])) {
            error_log("POST détecté avec mail et password");
            $db = new Database();
            
            $mail = htmlspecialchars(trim($_POST['mail']));
            $password = htmlspecialchars(trim($_POST['password']));
            
            error_log("Mail: " . $mail);
            
            // Récupérer l'utilisateur depuis la base de données
            $selection_db = $db->select(
                "SELECT id_membre, email_membre, password_membre FROM MEMBRE WHERE email_membre = ?",
                "s",
                [$mail]
            );
            
            error_log("Résultat DB: " . json_encode($selection_db));
            
            if (!empty($selection_db)) {
                $db_mail = $selection_db[0]["email_membre"];
                $db_password = $selection_db[0]["password_membre"];
                
                $mail_ok = ($db_mail == $mail);
                
                // Vérifier le mot de passe
                if ($db_password == NULL && $password == "") {
                    $password_ok = true;
                } else {
                    $password_ok = password_verify($password, $db_password);
                }
                
                error_log("Mail OK: " . ($mail_ok ? "OUI" : "NON"));
                error_log("Password OK: " . ($password_ok ? "OUI" : "NON"));
                
                if ($mail_ok && $password_ok) {
                    // Connexion réussie
                    $_SESSION['userid'] = $selection_db[0]["id_membre"];
                    error_log("CONNEXION RÉUSSIE ! UserID: " . $_SESSION['userid']);
                    
                    // Vérifier si l'utilisateur a des rôles (admin)
                    $nb_roles = $db->select(
                        "SELECT COUNT(*) as nb_roles FROM ASSIGNATION WHERE id_membre = ?",
                        "i",
                        [$selection_db[0]["id_membre"]]
                    )[0]["nb_roles"];
                    
                    if ($nb_roles > 0) {
                        $_SESSION["isAdmin"] = true;
                    }
                    
                    // Rediriger vers la page d'accueil
                    $this->redirect('/');
                    return;
                } else {
                    $login_error = "Erreur dans les informations de connexion.";
                }
            } else {
                $login_error = "Erreur dans les informations de connexion.";
            }
        }
        
        // Préparer les données pour la vue
        $data = [
            'title' => 'Connexion - ADIIL',
            'isLoggedIn' => false,
            'login_error' => $login_error
        ];
        
        $this->view('pages/login', $data);
    }
    
    public function signin()
    {
        // Si déjà connecté, rediriger
        if (isset($_SESSION["userid"])) {
            $this->redirect('/');
            return;
        }
        
        // Initialiser les variables
        $error = null;
        
        // Traitement du formulaire d'inscription
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mail']) && isset($_POST['password'])) {
            $db = new Database();
            
            $mail = htmlspecialchars(trim($_POST['mail']));
            $password = htmlspecialchars(trim($_POST['password']));
            $password_verif = htmlspecialchars(trim($_POST['password_verif']));
            
            // Vérifier si l'utilisateur existe déjà
            $selection_db = $db->select(
                "SELECT id_membre FROM MEMBRE WHERE email_membre = ?",
                "s",
                [$mail]
            );
            
            if (empty($selection_db)) {
                // Vérifier que les mots de passe correspondent
                if ($password == $password_verif) {
                    $fname = "N/A";
                    $lname = "N/A";
                    
                    if (isset($_POST['fname']) && !empty($_POST['fname'])) {
                        $fname = htmlspecialchars(trim($_POST['fname']));
                    }
                    if (isset($_POST['lname']) && !empty($_POST['lname'])) {
                        $lname = htmlspecialchars(trim($_POST['lname']));
                    }
                    
                    // Créer le compte
                    $db->query(
                        "CALL creationCompte (?, ?, ?, ?, ?);",
                        "sssss",
                        [$lname, $fname, $mail, password_hash($password, PASSWORD_DEFAULT), 'defaultPP.png']
                    );
                    
                    // Rediriger vers la page de connexion
                    $this->redirect('/login');
                    return;
                } else {
                    $error = "Les mots de passe ne correspondent pas.";
                }
            } else {
                $error = "Un compte existe déjà avec cet email.";
            }
        }
        
        $data = [
            'title' => 'Inscription - ADIIL',
            'isLoggedIn' => false,
            'error' => $error
        ];
        
        $this->view('pages/signin', $data);
    }
    
    public function logout()
    {
        session_destroy();
        $this->redirect('/');
    }
}
