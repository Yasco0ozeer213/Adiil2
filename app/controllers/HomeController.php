<?php
// Page d'accueil

class HomeController extends Controller
{
    public function index()
    {
        $eventModel = $this->model('Event');
        $db = new Database();
        $isLoggedIn = isset($_SESSION["userid"]);
        
        // Top 3 membres avec le plus d'XP
        $podium = $db->select(
            "SELECT prenom_membre, xp_membre, pp_membre FROM MEMBRE ORDER BY xp_membre DESC LIMIT 3;"
        );
        
        // Les 2 prochains événements
        $date = getdate();
        $sql_date = $date["year"]."-".$date["mon"]."-".$date["mday"];
        $events_to_display = $eventModel->getUpcomingEventsWithLimit($sql_date, 2);
        
        // Pour chaque événement, vérifier places et inscription
        foreach ($events_to_display as &$event) {
            $eventid = $event["id_evenement"];
            $event['isPlaceDisponible'] = $eventModel->hasAvailablePlaces($eventid);
            $event['isSubscribed'] = false;
            if($isLoggedIn){
                $event['isSubscribed'] = $eventModel->isUserSubscribed($_SESSION['userid'], $eventid);
            }
        }
        
        $data = [
            'title' => 'Accueil - ADIIL',
            'isLoggedIn' => $isLoggedIn,
            'podium' => $podium,
            'events_to_display' => $events_to_display
        ];
        
        // Charger la vue
        $this->view('pages/home', $data);
    }
}
