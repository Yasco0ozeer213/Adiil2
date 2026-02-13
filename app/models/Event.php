<?php
/**
 * Modèle Event - Gestion des événements
 */

class Event
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     * Récupérer tous les événements (non supprimés)
     */
    public function getAll()
    {
        return $this->db->select("SELECT * FROM EVENEMENT WHERE deleted = false ORDER BY date_evenement DESC");
    }

    /**
     * Récupérer les événements à venir (futures + aujourd'hui)
     * @param string $sql_date - Date au format Y-m-d
     * @return array
     */
    public function getUpcomingEvents($sql_date)
    {
        return $this->db->select(
            "SELECT id_evenement, nom_evenement, lieu_evenement, date_evenement 
             FROM EVENEMENT 
             WHERE date_evenement >= ? AND deleted = false 
             ORDER BY date_evenement ASC",
            "s",
            [$sql_date]
        );
    }

    /**
     * Récupérer les événements à venir avec limite
     * @param string $sql_date - Date au format Y-m-d
     * @param int $limit - Nombre d'événements max
     * @return array
     */
    public function getUpcomingEventsWithLimit($sql_date, $limit = 2)
    {
        return $this->db->select(
            "SELECT id_evenement, nom_evenement, lieu_evenement, date_evenement 
             FROM EVENEMENT 
             WHERE date_evenement >= ? AND deleted = false 
             ORDER BY date_evenement ASC 
             LIMIT ?",
            "si",
            [$sql_date, $limit]
        );
    }

    /**
     * Récupérer les événements passés avec limite
     * @param string $sql_date - Date au format Y-m-d
     * @param int $limit - Nombre d'événements max
     * @return array
     */
    public function getPassedEvents($sql_date, $limit = 5)
    {
        return $this->db->select(
            "SELECT id_evenement, nom_evenement, lieu_evenement, date_evenement 
             FROM EVENEMENT 
             WHERE date_evenement < ? AND deleted = false 
             ORDER BY date_evenement ASC 
             LIMIT ?",
            "si",
            [$sql_date, $limit]
        );
    }

    /**
     * Vérifier s'il reste des places disponibles pour un événement
     * @param int $event_id - ID de l'événement
     * @return bool
     */
    public function hasAvailablePlaces($event_id)
    {
        $result = $this->db->select(
            "SELECT (EVENEMENT.places_evenement - (SELECT COUNT(*) FROM INSCRIPTION WHERE INSCRIPTION.id_evenement = EVENEMENT.id_evenement)) > 0 AS isPlaceDisponible 
             FROM EVENEMENT 
             WHERE EVENEMENT.id_evenement = ?",
            "i",
            [$event_id]
        );
        return $result ? (bool)$result[0]['isPlaceDisponible'] : false;
    }

    /**
     * Vérifier si un membre est inscrit à un événement
     * @param int $member_id - ID du membre
     * @param int $event_id - ID de l'événement
     * @return bool
     */
    public function isUserSubscribed($member_id, $event_id)
    {
        $result = $this->db->select(
            "SELECT MEMBRE.id_membre 
             FROM MEMBRE 
             JOIN INSCRIPTION ON MEMBRE.id_membre = INSCRIPTION.id_membre 
             WHERE MEMBRE.id_membre = ? AND INSCRIPTION.id_evenement = ?",
            "ii",
            [$member_id, $event_id]
        );
        return !empty($result);
    }

    /**
     * Récupérer un événement par ID
     */
    public function getById($id)
    {
        $result = $this->db->select(
            "SELECT * FROM EVENEMENT WHERE id_evenement = ?",
            "i",
            [$id]
        );
        return $result ? $result[0] : null;
    }

    /**
     * Créer un nouvel événement
     */
    public function create($data)
    {
        // À implémenter selon vos besoins
        return true;
    }

    /**
     * Mettre à jour un événement
     */
    public function update($id, $data)
    {
        // À implémenter selon vos besoins
        return true;
    }

    /**
     * Supprimer un événement (soft delete)
     */
    public function delete($id)
    {
        // À implémenter selon vos besoins
        return true;
    }
}
