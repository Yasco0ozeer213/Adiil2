<?php
/**
 * Modèle Grade - Gestion des grades
 */

class Grade
{
    private $db;
    
    public function __construct()
    {
        $this->db = new Database();
    }
    
    /**
     * Récupérer tous les grades
     */
    public function getAll()
    {
        $sql = "SELECT * FROM grades ORDER BY niveau ASC";
        return $this->db->select($sql);
    }
    
    /**
     * Récupérer un grade par son ID
     */
    public function getById($id)
    {
        $sql = "SELECT * FROM grades WHERE id = ?";
        $result = $this->db->select($sql, "i", [$id]);
        return !empty($result) ? $result[0] : null;
    }
    
    /**
     * Récupérer le grade d'un utilisateur
     */
    public function getUserGrade($userId)
    {
        $sql = "SELECT g.* FROM grades g 
                INNER JOIN user_grades ug ON g.id = ug.grade_id 
                WHERE ug.user_id = ?";
        $result = $this->db->select($sql, "i", [$userId]);
        return !empty($result) ? $result[0] : null;
    }
    
    /**
     * Attribuer un grade à un utilisateur
     */
    public function assignToUser($userId, $gradeId)
    {
        $sql = "INSERT INTO user_grades (user_id, grade_id, created_at) VALUES (?, ?, NOW())";
        return $this->db->query($sql, "ii", [$userId, $gradeId]);
    }
    
    /**
     * Créer un nouveau grade
     */
    public function create($data)
    {
        $sql = "INSERT INTO grades (nom, description, niveau, prix, created_at) VALUES (?, ?, ?, ?, NOW())";
        return $this->db->query($sql, "ssid", [
            $data['nom'],
            $data['description'],
            $data['niveau'],
            $data['prix']
        ]);
    }
    
    /**
     * Supprimer un grade
     */
    public function delete($id)
    {
        $sql = "DELETE FROM grades WHERE id = ?";
        return $this->db->query($sql, "i", [$id]);
    }
}
