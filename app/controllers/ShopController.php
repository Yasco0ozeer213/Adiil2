<?php
/**
 * ShopController - Contrôleur pour la boutique
 */

// Charger la classe cart
require_once ROOT . '/cart_class.php';

class ShopController extends Controller
{
    public function index()
    {
        // Connexion à la base de données
        $db = new Database();
        
        // Initialiser le panier
        $cart = new cart($db);
        
        // Gestion de la recherche, des filtres et tris
        $filters = [];
        $orderBy = "name_asc";
        $searchTerm = "";
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['reset'])) {
                $filters = [];
                $orderBy = "name_asc";
                $searchTerm = "";
            } else {
                if (isset($_POST['category'])) {
                    $filters = $_POST['category'];
                }
                if (isset($_POST['sort'])) {
                    $orderBy = $_POST['sort'];
                }
                if (!empty($_POST['search'])) {
                    $searchTerm = $_POST['search'];
                }
            }
        }
        
        // Construction de la requête SQL
        $query = "SELECT * FROM ARTICLE";
        $whereClauses = ["deleted = false"];
        $params = [];
        
        // Ajout de la recherche par nom
        if (!empty($searchTerm)) {
            $whereClauses[] = "nom_article LIKE ?";
            $params[] = '%' . $searchTerm . '%';
        }
        
        // Ajout des filtres par catégorie
        if (!empty($filters)) {
            $placeholders = implode(", ", array_fill(0, count($filters), "?"));
            $whereClauses[] = "categorie_article IN ($placeholders)";
            $params = array_merge($params, $filters);
        }
        
        // Ajout des clauses WHERE
        if (!empty($whereClauses)) {
            $query .= " WHERE " . implode(" AND ", $whereClauses);
        }
        
        // Ajout du tri
        if ($orderBy === "price_asc") {
            $query .= " ORDER BY prix_article ASC";
        } elseif ($orderBy === "price_desc") {
            $query .= " ORDER BY prix_article DESC";
        } elseif ($orderBy === "name_asc") {
            $query .= " ORDER BY nom_article ASC";
        } elseif ($orderBy === "name_desc") {
            $query .= " ORDER BY nom_article DESC";
        }
        
        // Exécution de la requête
        $products = $db->select($query, str_repeat("s", count($params)), $params);
        
        // Préparer les données pour la vue
        $data = [
            'title' => 'Boutique - ADIIL',
            'isLoggedIn' => isset($_SESSION["userid"]),
            'products' => $products,
            'filters' => $filters,
            'orderBy' => $orderBy,
            'searchTerm' => $searchTerm,
            'cart' => $cart
        ];
        
        $this->view('pages/shop', $data);
    }
    
    public function cart()
    {
        if (!isset($_SESSION["userid"])) {
            $this->redirect('/login');
            return;
        }
        
        // TODO: Récupérer le panier
        
        $data = [
            'title' => 'Panier - ADIIL',
            'isLoggedIn' => true
        ];
        
        $this->view('pages/cart', $data);
    }
    
    public function order()
    {
        if (!isset($_SESSION["userid"])) {
            $this->redirect('/login');
            return;
        }
        
        // TODO: Logique de commande
        
        $data = [
            'title' => 'Commande - ADIIL',
            'isLoggedIn' => true
        ];
        
        $this->view('pages/order', $data);
    }
}
