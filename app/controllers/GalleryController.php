<?php
/**
 * GalleryController - Contrôleur pour la gestion de la galerie
 */

class GalleryController extends Controller
{
    public function index()
    {
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION["userid"])) {
            $this->redirect('/login');
            return;
        }
        
        $db = new Database();
        $userid = $_SESSION["userid"];
        
        // Récupérer l'ID de l'événement
        if (!isset($_GET['eventid']) || !ctype_digit($_GET['eventid'])) {
            $this->redirect('/');
            return;
        }
        
        $eventid = (int)$_GET['eventid'];
        
        // Limite d'affichage
        $limit = 10;
        if (isset($_GET["show"]) && ctype_digit($_GET["show"])) {
            $limit = (int)$_GET["show"];
        }
        
        // Récupérer l'événement
        $event = $db->select(
            "SELECT nom_evenement FROM EVENEMENT WHERE id_evenement = ?",
            "i",
            [$eventid]
        );
        
        if (empty($event)) {
            $this->redirect('/events');
            return;
        }
        
        // Récupérer les médias de l'utilisateur pour cet événement
        $medias = $db->select(
            "SELECT id_media, url_media FROM MEDIA WHERE id_membre = ? AND id_evenement = ? ORDER BY date_media ASC LIMIT ?",
            "iii",
            [$userid, $eventid, $limit]
        );
        
        $data = [
            'title' => 'Ma Galerie - ADIIL',
            'event' => $event[0],
            'eventid' => $eventid,
            'userid' => $userid,
            'medias' => $medias ?? []
        ];
        
        $this->view('pages/my_gallery', $data);
    }
    
    public function add()
    {
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION["userid"])) {
            $this->redirect('/login');
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_FILES['file'], $_POST['userid'], $_POST['eventid'])) {
            $this->redirect('/');
            return;
        }
        
        // Charger le helper files_save
        require_once ROOT . '/app/helpers/files_save.php';
        
        $db = new Database();
        $fileName = saveImage();
        
        if ($fileName !== null) {
            $date = new DateTime();
            $sqlDate = $date->format('Y-m-d H:i:s');
            
            // Insérer le média dans la base de données
            $db->query(
                "INSERT INTO MEDIA VALUES (NULL, ?, ?, ?, ?)",
                "ssii",
                [$fileName, $sqlDate, $_POST["userid"], $_POST["eventid"]]
            );
        }
        
        // Rediriger vers la galerie
        $this->redirect('/gallery?eventid=' . $_POST["eventid"]);
    }
    
    public function delete()
    {
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION["userid"])) {
            $this->redirect('/login');
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['mediaid'], $_POST['eventid'])) {
            $this->redirect('/');
            return;
        }
        
        // Charger le helper files_save
        require_once ROOT . '/app/helpers/files_save.php';
        
        $db = new Database();
        
        // Récupérer le nom du fichier
        $result = $db->select(
            "SELECT url_media FROM MEDIA WHERE id_media = ? AND id_evenement = ?",
            "ii",
            [$_POST['mediaid'], $_POST['eventid']]
        );
        
        if (!empty($result)) {
            $fileName = $result[0]['url_media'];
            
            if (deleteFile($fileName)) {
                // Supprimer l'entrée de la base de données
                $db->query(
                    "DELETE FROM MEDIA WHERE id_media = ? AND id_evenement = ?",
                    "ii",
                    [$_POST['mediaid'], $_POST['eventid']]
                );
            }
        }
        
        // Rediriger vers la galerie
        $this->redirect('/gallery?eventid=' . $_POST["eventid"]);
    }
}
