<?php
/**
 * GradeController - Contrôleur pour la gestion des grades
 */

class GradeController extends Controller
{
    public function index()
    {
        // ÉTAPE 1 : Se connecter à la base de données
        $db = new Database();
        
        // ÉTAPE 2 : Récupérer tous les grades actifs (non supprimés), triés par prix
        $grades = $db->select(
            "SELECT * FROM GRADE ORDER BY prix_grade"
        );
        
        // ÉTAPE 3 : Savoir si l'utilisateur est connecté
        $userId = isset($_SESSION['userid']) ? $_SESSION['userid'] : null;
        
        // ÉTAPE 4 : Pour chaque grade, vérifier si l'utilisateur le possède déjà
        if (!empty($grades)) {
            foreach ($grades as &$grade) {
                // Par défaut, l'utilisateur ne possède pas ce grade
                $grade['user_has_it'] = false;
                
                // Si l'utilisateur est connecté, vérifier dans la base
                if ($userId) {
                    $check = $db->select(
                        "SELECT * FROM ADHESION WHERE id_grade = ? AND id_membre = ?",
                        "ii",
                        [$grade['id_grade'], $userId]
                    );
                    
                    // Si la requête retourne quelque chose, l'utilisateur possède ce grade
                    if (!empty($check)) {
                        $grade['user_has_it'] = true;
                    }
                }
            }
        }
        
        // ÉTAPE 5 : Préparer les données pour la Vue
        $data = [
            'title' => 'Grades - ADIIL',
            'isLoggedIn' => isset($_SESSION["userid"]),
            'grades' => $grades,  // La liste des grades avec user_has_it
            'userId' => $userId,  // L'ID de l'utilisateur (ou null)
            'message' => isset($_SESSION['message']) ? $_SESSION['message'] : null,
            'message_type' => isset($_SESSION['message_type']) ? $_SESSION['message_type'] : null
        ];
        
        // Supprimer les messages de session après les avoir récupérés
        unset($_SESSION['message']);
        unset($_SESSION['message_type']);
        
        // ÉTAPE 6 : Envoyer tout ça à la Vue
        $this->view('pages/grade', $data);
    }
    
    public function subscribe()
    {
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION["userid"])) {
            $this->redirect('/login');
            return;
        }
        
        // Vérifier que l'ID du grade est fourni
        if (!isset($_GET['id']) || empty($_GET['id'])) {
            $this->redirect('/grade');
            return;
        }
        
        $db = new Database();
        $userid = $_SESSION["userid"];
        $id_grade = intval($_GET['id']);
        
        // Récupérer les informations du grade
        $grade = $db->select(
            "SELECT * FROM GRADE WHERE id_grade = ?",
            "i",
            [$id_grade]
        );
        
        // Vérifier que le grade existe
        if (empty($grade)) {
            $_SESSION['message'] = "Le grade sélectionné n'existe pas.";
            $_SESSION['message_type'] = "error";
            $this->redirect('/grade');
            return;
        }
        
        // Vérifier si l'utilisateur possède déjà un grade
        $currentGrade = $db->select(
            "SELECT * FROM ADHESION WHERE id_membre = ?",
            "i",
            [$userid]
        );
        
        // Gestion de l'achat d'un grade
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mode_paiement']) && !empty($_POST['mode_paiement'])) {
            $mode_paiement = $_POST['mode_paiement'];
            
            // Supprimer l'ancien grade si existant
            if (!empty($currentGrade)) {
                $db->query(
                    "DELETE FROM ADHESION WHERE id_membre = ?",
                    "i",
                    [$userid]
                );
            }
            
            // Insérer le nouveau grade
            $db->query(
                "INSERT INTO ADHESION (id_membre, id_grade, prix_adhesion, paiement_adhesion, date_adhesion) VALUES (?, ?, ?, ?, NOW())",
                "iiss",
                [$userid, $id_grade, $grade[0]['prix_grade'], $mode_paiement]
            );
            
            $_SESSION['message'] = "Adhésion au grade réussie !";
            $_SESSION['message_type'] = "success";
            $this->redirect('/grade');
            return;
        }
        
        // Afficher le formulaire de paiement
        $data = [
            'title' => 'Mon Adhésion - ADIIL',
            'grade' => $grade[0],
            'id_grade' => $id_grade,
            'isLoggedIn' => true
        ];
        
        $this->view('pages/grade_subscription', $data);
    }
}
