<?php
/**
 * Modèle Product - Gestion des produits de la boutique
 */

class Product
{
    private $db;
    
    public function __construct()
    {
        $this->db = new Database();
    }
    
    /**
     * Récupérer tous les produits
     */
    public function getAll()
    {
        $sql = "SELECT * FROM products ORDER BY nom ASC";
        return $this->db->select($sql);
    }
    
    /**
     * Récupérer les produits disponibles
     */
    public function getAvailable()
    {
        $sql = "SELECT * FROM products WHERE stock > 0 ORDER BY nom ASC";
        return $this->db->select($sql);
    }
    
    /**
     * Récupérer un produit par son ID
     */
    public function getById($id)
    {
        $sql = "SELECT * FROM products WHERE id = ?";
        $result = $this->db->select($sql, "i", [$id]);
        return !empty($result) ? $result[0] : null;
    }
    
    /**
     * Créer un nouveau produit
     */
    public function create($data)
    {
        $sql = "INSERT INTO products (nom, description, prix, stock, image, created_at) VALUES (?, ?, ?, ?, ?, NOW())";
        return $this->db->query($sql, "ssdis", [
            $data['nom'],
            $data['description'],
            $data['prix'],
            $data['stock'],
            $data['image']
        ]);
    }
    
    /**
     * Mettre à jour un produit
     */
    public function update($id, $data)
    {
        $sql = "UPDATE products SET nom = ?, description = ?, prix = ?, stock = ?, image = ? WHERE id = ?";
        return $this->db->query($sql, "ssdisi", [
            $data['nom'],
            $data['description'],
            $data['prix'],
            $data['stock'],
            $data['image'],
            $id
        ]);
    }
    
    /**
     * Mettre à jour le stock
     */
    public function updateStock($id, $quantity)
    {
        $sql = "UPDATE products SET stock = stock - ? WHERE id = ?";
        return $this->db->query($sql, "ii", [$quantity, $id]);
    }
    
    /**
     * Supprimer un produit
     */
    public function delete($id)
    {
        $sql = "DELETE FROM products WHERE id = ?";
        return $this->db->query($sql, "i", [$id]);
    }
}
