<?php
/**
 * Modèle News - Gestion des actualités
 */

class News
{
    private $db;
    
    public function __construct()
    {
        $this->db = new Database();
    }
    
    /**
     * Récupérer toutes les actualités
     */
    public function getAll()
    {
        $sql = "SELECT * FROM news ORDER BY created_at DESC";
        return $this->db->select($sql);
    }
    
    /**
     * Récupérer une actualité par son ID
     */
    public function getById($id)
    {
        $sql = "SELECT * FROM news WHERE id = ?";
        $result = $this->db->select($sql, "i", [$id]);
        return !empty($result) ? $result[0] : null;
    }
    
    /**
     * Récupérer les dernières actualités
     */
    public function getRecent($limit = 5)
    {
        $sql = "SELECT * FROM news ORDER BY created_at DESC LIMIT ?";
        return $this->db->select($sql, "i", [$limit]);
    }
    
    /**
     * Créer une nouvelle actualité
     */
    public function create($data)
    {
        $sql = "INSERT INTO news (titre, contenu, image, created_at) VALUES (?, ?, ?, NOW())";
        return $this->db->query($sql, "sss", [
            $data['titre'],
            $data['contenu'],
            $data['image']
        ]);
    }
    
    /**
     * Mettre à jour une actualité
     */
    public function update($id, $data)
    {
        $sql = "UPDATE news SET titre = ?, contenu = ?, image = ? WHERE id = ?";
        return $this->db->query($sql, "sssi", [
            $data['titre'],
            $data['contenu'],
            $data['image'],
            $id
        ]);
    }
    
    /**
     * Supprimer une actualité
     */
    public function delete($id)
    {
        $sql = "DELETE FROM news WHERE id = ?";
        return $this->db->query($sql, "i", [$id]);
    }
}
