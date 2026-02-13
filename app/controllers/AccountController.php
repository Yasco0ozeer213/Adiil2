<?php
/**
 * AccountController - Contrôleur pour la gestion des comptes utilisateur
 */

class AccountController extends Controller
{
    public function index()
    {
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION["userid"])) {
            $this->redirect('/login');
            return;
        }
        
        $db = new Database();
        $message = null;
        $message_type = null;
        
        // TRAITEMENT 1 : Déconnexion
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deconnexion']) && $_POST['deconnexion'] === 'true') {
            session_destroy();
            $this->redirect('/');
            return;
        }
        
        // TRAITEMENT 2 : Modification de la photo de profil
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
            require_once ROOT . '/old_files/files_save.php';
            $fileName = saveImage();
            
            if ($fileName !== null) {
                // Récupérer l'ancienne photo
                $oldPp = $db->select(
                    "SELECT pp_membre FROM MEMBRE WHERE id_membre = ?",
                    "i",
                    [$_SESSION['userid']]
                );
                
                // Supprimer l'ancienne image si elle existe
                if (!empty($oldPp[0]['pp_membre'])) {
                    deleteFile($oldPp[0]['pp_membre']);
                }
                
                // Mettre à jour la base de données
                $db->query(
                    "UPDATE MEMBRE SET pp_membre = ? WHERE id_membre = ?",
                    "si",
                    [$fileName, $_SESSION['userid']]
                );
                
                $_SESSION['message'] = "Mise à jour de la photo de profil réussie !";
                $_SESSION['message_type'] = "success";
            } else {
                $_SESSION['message'] = "Erreur : veuillez vérifier le fichier envoyé.";
                $_SESSION['message_type'] = "error";
            }
            
            $this->redirect('/account');
            return;
        }
        
        // TRAITEMENT 3 : Modification des informations personnelles
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'], $_POST['lastName'], $_POST['mail'])) {
            // Charger les informations actuelles
            $currentUserData = $db->select(
                "SELECT prenom_membre, nom_membre, email_membre, tp_membre FROM MEMBRE WHERE id_membre = ?",
                "i",
                [$_SESSION['userid']]
            );
            
            if (!empty($currentUserData)) {
                $currentName = $currentUserData[0]['prenom_membre'];
                $currentLastName = $currentUserData[0]['nom_membre'];
                $currentMail = $currentUserData[0]['email_membre'];
                $currentTp = $currentUserData[0]['tp_membre'];
                
                // Récupérer les nouvelles valeurs ou conserver les anciennes
                $name = empty($_POST['name']) ? $currentName : htmlspecialchars($_POST['name']);
                $lastName = empty($_POST['lastName']) ? $currentLastName : htmlspecialchars($_POST['lastName']);
                $mail = empty($_POST['mail']) ? $currentMail : htmlspecialchars($_POST['mail']);
                $tp = isset($_POST['tp']) && !empty($_POST['tp']) ? htmlspecialchars($_POST['tp']) : $currentTp;
                
                // Vérifier si l'email existe déjà
                $existingEmail = $db->select(
                    "SELECT id_membre FROM MEMBRE WHERE email_membre = ? AND id_membre != ?",
                    "si",
                    [$mail, $_SESSION['userid']]
                );
                
                if (!empty($existingEmail)) {
                    $_SESSION['message'] = "Les modifications n'ont pas pu être effectuées car l'adresse e-mail est déjà utilisée par un autre compte.";
                    $_SESSION['message_type'] = "error";
                } else {
                    // Mettre à jour les informations
                    $db->query(
                        "UPDATE MEMBRE SET prenom_membre = ?, nom_membre = ?, email_membre = ?, tp_membre = ? WHERE id_membre = ?",
                        "ssssi",
                        [$name, $lastName, $mail, $tp, $_SESSION['userid']]
                    );
                    
                    $_SESSION['message'] = "Vos informations ont été mises à jour avec succès !";
                    $_SESSION['message_type'] = "success";
                }
            } else {
                $_SESSION['message'] = "Erreur : utilisateur introuvable dans la base de données.";
                $_SESSION['message_type'] = "error";
            }
            
            $this->redirect('/account');
            return;
        }
        
        // TRAITEMENT 4 : Modification du mot de passe
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mdp'], $_POST['newMdp'], $_POST['newMdpVerif'])) {
            $currentPassword = htmlspecialchars(trim($_POST['mdp']));
            $newPassword = htmlspecialchars(trim($_POST['newMdp']));
            $newPasswordVerif = htmlspecialchars(trim($_POST['newMdpVerif']));
            
            // Récupérer le mot de passe actuel
            $user = $db->select(
                "SELECT password_membre FROM MEMBRE WHERE id_membre = ?",
                "i",
                [$_SESSION['userid']]
            );
            
            if ($user[0]['password_membre'] == NULL && $currentPassword == "") {
                $password_ok = true;
            } else {
                $password_ok = password_verify($currentPassword, $user[0]['password_membre']);
            }
            
            if (!empty($user)) {
                if ($password_ok && $newPassword == $newPasswordVerif) {
                    // Mettre à jour le mot de passe
                    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                    $db->query(
                        "UPDATE MEMBRE SET password_membre = ? WHERE id_membre = ?",
                        "si",
                        [$hashedPassword, $_SESSION['userid']]
                    );
                    
                    $_SESSION['message'] = "Mot de passe mis à jour avec succès !";
                    $_SESSION['message_type'] = "success";
                } else {
                    $_SESSION['message'] = "Les nouveaux mots de passe ne correspondent pas.";
                    $_SESSION['message_type'] = "error";
                }
            } else {
                $_SESSION['message'] = "Mot de passe actuel incorrect.";
                $_SESSION['message_type'] = "error";
            }
            
            $this->redirect('/account');
            return;
        }
        
        // RÉCUPÉRATION DES DONNÉES : Informations de l'utilisateur
        $infoUser = $db->select(
            "SELECT pp_membre, xp_membre, prenom_membre, nom_membre, email_membre, tp_membre, discord_token_membre, nom_grade, image_grade 
             FROM MEMBRE 
             LEFT JOIN ADHESION ON MEMBRE.id_membre = ADHESION.id_membre 
             LEFT JOIN GRADE ON ADHESION.id_grade = GRADE.id_grade 
             WHERE MEMBRE.id_membre = ?",
            "i",
            [$_SESSION['userid']]
        );
        
        // RÉCUPÉRATION DES DONNÉES : Historique des achats
        $viewAll = isset($_GET['viewAll']) && $_GET['viewAll'] === '1';
        
        $sql = "SELECT type_transaction, element, quantite, montant, mode_paiement, date_transaction, 
                CASE WHEN recupere = 1 THEN 'Récupéré' ELSE 'Non récupéré' END AS statut 
                FROM HISTORIQUE_COMPLET WHERE id_membre=? ORDER BY date_transaction DESC";
        
        if (!$viewAll) {
            $sql .= " LIMIT 6";
        }
        
        $historiqueAchats = $db->select($sql, "i", [$_SESSION['userid']]);
        
        // Récupérer les messages de session
        if (isset($_SESSION['message'])) {
            $message = $_SESSION['message'];
            $message_type = $_SESSION['message_type'];
            unset($_SESSION['message']);
            unset($_SESSION['message_type']);
        }
        
        // Envoyer tout à la Vue
        $data = [
            'title' => 'Mon compte - ADIIL',
            'isLoggedIn' => true,
            'infoUser' => $infoUser[0],
            'historiqueAchats' => $historiqueAchats,
            'viewAll' => $viewAll,
            'message' => $message,
            'message_type' => $message_type
        ];
        
        $this->view('pages/account', $data);
    }
    
    public function gallery()
    {
        if (!isset($_SESSION["userid"])) {
            $this->redirect('/login');
            return;
        }
        
        // TODO: Récupérer la galerie de l'utilisateur
        
        $data = [
            'title' => 'Ma galerie - ADIIL',
            'isLoggedIn' => true
        ];
        
        $this->view('pages/my_gallery', $data);
    }
    
    public function delete()
    {
        if (!isset($_SESSION["userid"])) {
            $this->redirect('/login');
            return;
        }
        
        $db = new Database();
        
        // Traitement de la suppression
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // Première étape : afficher la confirmation
            if (isset($_POST['delete_account']) && $_POST['delete_account'] === 'true') {
                $data = [
                    'title' => 'Supprimer mon compte - ADIIL',
                    'isLoggedIn' => true,
                    'showConfirmation' => true
                ];
                
                $this->view('pages/delete_account', $data);
                return;
            }
            
            // Deuxième étape : supprimer le compte
            if (isset($_POST['delete_account_valid']) && $_POST['delete_account_valid'] === 'true') {
                $db->query(
                    "CALL suppressionCompte(?)",
                    "i",
                    [$_SESSION["userid"]]
                );
                
                session_destroy();
                $this->redirect('/');
                return;
            }
        }
        
        // Affichage initial
        $data = [
            'title' => 'Supprimer mon compte - ADIIL',
            'isLoggedIn' => true,
            'showConfirmation' => false
        ];
        
        $this->view('pages/delete_account', $data);
    }
}
