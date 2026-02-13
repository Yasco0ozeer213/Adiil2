<?php
/**
 * NewsController - Contrôleur pour la gestion des actualités
 */

class NewsController extends Controller
{
    public function index()
    {
        // Connexion à la base de données
        $db = new Database();
        
        // Vérifier si l'utilisateur est connecté
        $isLoggedIn = isset($_SESSION["userid"]);
        
        // Récupérer le paramètre 'show' (nombre d'actualités à afficher)
        $show = 5;
        if (isset($_GET['show']) && is_numeric($_GET['show'])) {
            $show = (int) $_GET['show'];
        }
        
        // Dates et traductions
        $date = getdate();
        $sql_date = $date["year"]."-".$date["mon"]."-".$date["mday"];
        $joursFr = [0 => 'Dimanche', 1 => 'Lundi', 2 => 'Mardi', 3 => 'Mercredi', 4 => 'Jeudi', 5 => 'Vendredi', 6 => 'Samedi'];
        $moisFr = [1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril', 5 => 'Mai', 6 => 'Juin', 7 => 'Juillet', 8 => 'Août', 9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre'];
        $current_date = new DateTime(date("Y-m-d"));
        
        // Récupérer les actualités
        $news_to_display = $db->select(
            "SELECT id_actualite, titre_actualite, date_actualite FROM ACTUALITE WHERE date_actualite <= NOW() ORDER BY date_actualite DESC LIMIT ?;",
            "i",
            [$show]
        );
        
        // Traiter les actualités
        $closest_news_id = "";
        foreach ($news_to_display as &$news) {
            $news_id = $news["id_actualite"];
            $news_date = new DateTime(substr($news['date_actualite'], 0, 10));
            $news['date_info'] = getdate(strtotime($news['date_actualite']));
            
            // Marquer l'actualité du jour ou la plus récente
            if ($news_date == $current_date) {
                $news['isClosest'] = true;
                $closest_news_id = "found";
            } else {
                if (empty($closest_news_id)) {
                    $news['isClosest'] = true;
                    $closest_news_id = "found";
                } else {
                    $news['isClosest'] = false;
                }
            }
        }
        
        // Préparer les données pour la vue
        $data = [
            'title' => 'Actualités - ADIIL',
            'isLoggedIn' => $isLoggedIn,
            'news' => $news_to_display,
            'show' => $show,
            'joursFr' => $joursFr,
            'moisFr' => $moisFr
        ];
        
        $this->view('pages/news', $data);
    }
    
    public function details($id = null)
    {
        if (!$id) {
            $this->redirect('/news');
            return;
        }
        
        $db = new Database();
        
        // Récupérer l'actualité
        $news = $db->select(
            "SELECT * FROM ACTUALITE WHERE id_actualite = ?",
            "i",
            [$id]
        );
        
        if (empty($news) || is_null($news)) {
            $this->redirect('/news');
            return;
        }
        
        $news = $news[0];
        
        $data = [
            'title' => $news['titre_actualite'] . ' - ADIIL',
            'news' => $news,
            'isLoggedIn' => isset($_SESSION["userid"])
        ];
        
        $this->view('pages/news_details', $data);
    }
}
