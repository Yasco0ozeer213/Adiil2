<?php
/**
 * Modèle User - Gestion des utilisateurs
 */

class User
{
    private $db;
    
    public function __construct()
    {
        $this->db = new Database();
    }
    
    /**
     * Récupérer tous les utilisateurs
     */
    public function getAll()
    {
        $sql = "SELECT * FROM users ORDER BY id DESC";
        return $this->db->select($sql);
    }
    
    /**
     * Récupérer un utilisateur par son ID
     */
    public function getById($id)
    {
        $sql = "SELECT * FROM users WHERE id = ?";
        $result = $this->db->select($sql, "i", [$id]);
        return !empty($result) ? $result[0] : null;
    }
    
    /**
     * Récupérer un utilisateur par email
     */
    public function getByEmail($email)
    {
        $sql = "SELECT * FROM users WHERE email = ?";
        $result = $this->db->select($sql, "s", [$email]);
        return !empty($result) ? $result[0] : null;
    }
    
    /**
     * Créer un nouvel utilisateur
     */
    public function create($data)
    {
        $sql = "INSERT INTO users (nom, prenom, email, password, created_at) VALUES (?, ?, ?, ?, NOW())";
        return $this->db->query($sql, "ssss", [
            $data['nom'],
            $data['prenom'],
            $data['email'],
            $data['password']
        ]);
    }
    
    /**
     * Mettre à jour un utilisateur
     */
    public function update($id, $data)
    {
        $sql = "UPDATE users SET nom = ?, prenom = ?, email = ? WHERE id = ?";
        return $this->db->query($sql, "sssi", [
            $data['nom'],
            $data['prenom'],
            $data['email'],
            $id
        ]);
    }
    
    /**
     * Supprimer un utilisateur
     */
    public function delete($id)
    {
        $sql = "DELETE FROM users WHERE id = ?";
        return $this->db->query($sql, "i", [$id]);
    }
}
