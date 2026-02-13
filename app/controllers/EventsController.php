<?php
/**
 * EventsController - Contrôleur pour la gestion des événements
 */

class EventsController extends Controller
{
    public function index()
    {
        // === ÉTAPE 1 : Connexion et initialisation ===
        $db = new Database();
        $eventModel = $this->model('Event');
        $isLoggedIn = isset($_SESSION["userid"]);
        
        // === ÉTAPE 2 : Gérer le paramètre 'show' ===
        $show = 5; // Par défaut
        if (isset($_GET['show']) && is_numeric($_GET['show'])) {
            $show = (int) $_GET['show'];
        }
        
        // === ÉTAPE 3 : Préparer les dates et traductions ===
        $date = getdate();
        $sql_date = $date["year"]."-".$date["mon"]."-".$date["mday"];
        $joursFr = [0 => 'Dimanche', 1 => 'Lundi', 2 => 'Mardi', 3 => 'Mercredi', 4 => 'Jeudi', 5 => 'Vendredi', 6 => 'Samedi'];
        $moisFr = [1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril', 5 => 'Mai', 6 => 'Juin', 7 => 'Juillet', 8 => 'Août', 9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre'];
        $current_date = new DateTime(date("Y-m-d"));
        
        // === ÉTAPE 4 : Récupérer les événements via le Model ===
        $events_to_display = $eventModel->getUpcomingEvents($sql_date);
        $passed_events = $eventModel->getPassedEvents($sql_date, $show);
        $events = array_merge($passed_events, $events_to_display);
        
        // === ÉTAPE 5 : Traiter chaque événement ===
        $closest_event_id = "";
        foreach ($events as &$event) {
            $eventid = $event["id_evenement"];
            $event_date = new DateTime(substr($event['date_evenement'], 0, 10));
            $event['date_info'] = getdate(strtotime($event['date_evenement']));
            
            // Calculer si passé/aujourd'hui/futur
            if ($event_date < $current_date) {
                $event['date_pin_class'] = "passed";
                $event['date_pin_label'] = "Passé";
                $event['other_classes'] = 'passed';
                $event['isPassed'] = true;
            } elseif ($event_date == $current_date) {
                $event['date_pin_class'] = "today";
                $event['date_pin_label'] = "Aujourd'hui";
                $event['isClosest'] = true;
                $closest_event_id = "found";
            } else {
                $event['date_pin_class'] = "upcoming";
                $event['date_pin_label'] = "A venir";
                if (empty($closest_event_id)) {
                    $event['isClosest'] = true;
                    $closest_event_id = "found";
                }
            }
            
            // Vérifier places disponibles via Model
            $event['isPlaceDisponible'] = $eventModel->hasAvailablePlaces($eventid);
            
            // Vérifier inscription utilisateur
            $event['isSubscribed'] = false;
            if ($isLoggedIn) {
                $event['isSubscribed'] = $eventModel->isUserSubscribed($_SESSION['userid'], $eventid);
            }
            
            // Calculer le label et la classe CSS du bouton
            if ($event['isPassed'] ?? false) {
                $event['subscription_class'] = "event-full";
                $event['subscription_label'] = "Passé";
            } elseif ($event['isPlaceDisponible']) {
                $event['subscription_class'] = "event-not-subscribed hover_effect";
                $event['subscription_label'] = "S'inscrire";
            } else {
                $event['subscription_class'] = "event-full";
                $event['subscription_label'] = "Complet";
            }
            
            if ($isLoggedIn && $event['isSubscribed']) {
                $event['subscription_class'] = "event-subscribed";
                $event['subscription_label'] = "Inscrit";
            }
        }
        
        // === ÉTAPE 6 : Envoyer à la vue ===
        $data = [
            'title' => 'Événements - ADIIL',
            'isLoggedIn' => $isLoggedIn,
            'events' => $events,
            'show' => $show,
            'joursFr' => $joursFr,
            'moisFr' => $moisFr
        ];
        
        $this->view('pages/events', $data);
    }
    
    public function details($id = null)
    {
        // Vérifier si l'ID est fourni
        if (!$id) {
            $this->redirect('/events');
            return;
        }
        
        $db = new Database();
        $isLoggedIn = isset($_SESSION["userid"]);
        
        // Récupérer l'événement
        $event = $db->select(
            "SELECT nom_evenement, xp_evenement, places_evenement, prix_evenement, reductions_evenement, lieu_evenement, date_evenement
             FROM EVENEMENT WHERE id_evenement = ?",
            "i",
            [$id]
        );
        
        if (empty($event) || is_null($event)) {
            $this->redirect('/events');
            return;
        }
        
        $event = $event[0];
        
        // Gérer le paramètre 'show' pour la galerie
        $show = 8;
        if (isset($_GET['show']) && is_numeric($_GET['show']) && $_GET['show']) {
            $show = (int) $_GET['show'];
        }
        
        // Vérifier si l'événement est passé
        $current_date = new DateTime(date("Y-m-d"));
        $event_date = new DateTime(substr($event['date_evenement'], 0, 10));
        $isPassed = ($event_date < $current_date);
        
        // Vérifier si l'utilisateur est inscrit
        $isSubscribed = false;
        if ($isLoggedIn) {
            $subscription = $db->select(
                "SELECT * FROM INSCRIPTION WHERE id_evenement = ? AND id_membre = ?",
                "ii",
                [$id, $_SESSION['userid']]
            );
            $isSubscribed = !empty($subscription);
        }
        
        // Récupérer les médias personnels (si connecté)
        $myMedias = [];
        if ($isLoggedIn) {
            $myMedias = $db->select(
                "SELECT url_media FROM MEDIA WHERE id_membre = ? AND id_evenement = ? ORDER BY date_media ASC LIMIT 4",
                "ii",
                [$_SESSION['userid'], $id]
            );
        }
        
        // Récupérer les médias généraux
        $generalMedias = $db->select(
            "SELECT url_media FROM MEDIA WHERE id_evenement = ? ORDER BY date_media ASC LIMIT ?",
            "ii",
            [$id, $show]
        );
        
        $data = [
            'title' => $event['nom_evenement'] . ' - ADIIL',
            'event' => $event,
            'eventId' => $id,
            'isLoggedIn' => $isLoggedIn,
            'isPassed' => $isPassed,
            'isSubscribed' => $isSubscribed,
            'myMedias' => $myMedias,
            'generalMedias' => $generalMedias,
            'show' => $show
        ];
        
        $this->view('pages/event_details', $data);
    }
    
    public function subscribe()
    {
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION["userid"])) {
            $this->redirect('/login');
            return;
        }
        
        $db = new Database();
        $userid = $_SESSION["userid"];
        
        // Vérifier que la requête est POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/events');
            return;
        }
        
        // Si on a le prix, on enregistre l'inscription
        if (isset($_POST["price"], $_POST["eventid"])) {
            $eventid = $_POST["eventid"];
            $price = $_POST["price"];
            
            $db->query(
                "INSERT INTO INSCRIPTION (id_membre, id_evenement, date_inscription, paiement_inscription, prix_inscription)
                VALUES (?, ?, NOW(), 'WEB', ?)",
                "iid",
                [$userid, $eventid, $price]
            );
            
            // Ajouter l'XP à l'utilisateur
            $xp = $db->select("SELECT xp_evenement FROM EVENEMENT WHERE id_evenement = ?", "i", [$eventid])[0]['xp_evenement'];
            $db->query(
                "UPDATE MEMBRE SET xp_membre = xp_membre + ? WHERE id_membre = ?",
                "ii",
                [$xp, $userid]
            );
            
            $this->redirect('/events');
            return;
        }
        
        // Sinon, on affiche le formulaire de paiement
        if (isset($_POST["eventid"])) {
            $eventid = $_POST["eventid"];
            
            $event = $db->select(
                "SELECT nom_evenement, xp_evenement, prix_evenement, reductions_evenement FROM EVENEMENT WHERE id_evenement = ?",
                "i",
                [$eventid]
            );
            
            if (empty($event)) {
                $this->redirect('/events');
                return;
            }
            
            $event = $event[0];
            $title = $event["nom_evenement"];
            $xp = $event["xp_evenement"];
            $price = $event["prix_evenement"];
            $isDiscounted = boolval($event["reductions_evenement"]);
            $user_reduction = 1;
            
            // Calculer la réduction si applicable
            if ($isDiscounted) {
                $reduction = $db->select(
                    "SELECT reduction_grade FROM ADHESION 
                    JOIN GRADE ON ADHESION.id_grade = GRADE.id_grade
                    WHERE id_membre = ? AND reduction_grade > 0 ORDER BY ADHESION.date_adhesion DESC LIMIT 1",
                    "i",
                    [$userid]
                );
                
                if (!empty($reduction)) {
                    $user_reduction = 1 - ($reduction[0]["reduction_grade"] / 100);
                }
            }
            
            $data = [
                'title' => 'Inscription - ' . $title,
                'isLoggedIn' => true,
                'eventid' => $eventid,
                'eventTitle' => $title,
                'xp' => $xp,
                'price' => $price,
                'priceWithReduction' => $price * $user_reduction,
                'hasReduction' => ($user_reduction < 1)
            ];
            
            $this->view('pages/event_subscription', $data);
            return;
        }
        
        $this->redirect('/events');
    }
}
