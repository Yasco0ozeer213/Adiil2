<?php
/**
 * OrderController - Contrôleur pour la gestion des commandes
 */

class OrderController extends Controller
{
    public function index()
    {
        // DEBUG
        error_log("=== OrderController::index() appelé ===");
        error_log("Session userid: " . (isset($_SESSION["userid"]) ? $_SESSION["userid"] : "NON CONNECTÉ"));
        error_log("Panier: " . json_encode($_SESSION['cart'] ?? []));
        
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION["userid"])) {
            error_log("REDIRECT: Non connecté → /login");
            $this->redirect('/login');
            return;
        }
        
        // Vérifier si le panier est vide
        if (empty($_SESSION['cart'])) {
            error_log("REDIRECT: Panier vide → /cart");
            $this->redirect('/cart');
            return;
        }
        
        error_log("OrderController: OK, affichage de la page");
        
        $db = new Database();
        $userid = $_SESSION["userid"];
        
        // Traitement de la commande (POST)
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mode_paiement']) && !empty($_POST['mode_paiement'])) {
            $mode_paiement = $_POST['mode_paiement'];
            
            // Récupérer les produits du panier
            $cart = $_SESSION['cart'];
            $product_ids = array_keys($cart);
            $placeholders = implode(",", array_fill(0, count($product_ids), "?"));
            $query = "SELECT * FROM ARTICLE WHERE id_article IN ($placeholders)";
            $types = str_repeat("i", count($product_ids));
            $products = $db->select($query, $types, $product_ids);
            
            // Enregistrer la commande
            foreach ($products as $product) {
                $product_id = $product['id_article'];
                $quantite = $cart[$product_id];
                
                // Vérifier le stock et ajuster si nécessaire
                if ($product['stock_article'] > 0 && $quantite > $product['stock_article']) {
                    $quantite = $product['stock_article'];
                }
                
                // Appeler la procédure achat_article
                $db->query(
                    "CALL achat_article(?, ?, ?, ?)",
                    "iiis",
                    [$userid, $product_id, $quantite, $mode_paiement]
                );
            }
            
            // Vider le panier
            $_SESSION['cart'] = [];
            
            $_SESSION['message'] = "Commande réalisée avec succès !";
            $_SESSION['message_type'] = "success";
            
            $this->redirect('/cart');
            return;
        }
        
        // Récupérer les produits du panier pour affichage
        $cart = $_SESSION['cart'];
        $product_ids = array_keys($cart);
        $placeholders = implode(",", array_fill(0, count($product_ids), "?"));
        $query = "SELECT * FROM ARTICLE WHERE id_article IN ($placeholders)";
        $types = str_repeat("i", count($product_ids));
        $products = $db->select($query, $types, $product_ids);
        
        // Préparer les items du panier avec ajustement du stock
        $cart_items = [];
        $total = 0;
        
        foreach ($products as $product) {
            $product_id = $product['id_article'];
            $quantite = $cart[$product_id];
            
            // Ajuster la quantité si stock insuffisant
            if ($product['stock_article'] > 0 && $quantite > $product['stock_article']) {
                $quantite = $product['stock_article'];
                $_SESSION['cart'][$product_id] = $quantite;
            }
            
            $cart_items[$product_id] = [
                'nom_article' => $product['nom_article'],
                'prix_article' => $product['prix_article'],
                'quantite' => $quantite,
                'reduction_article' => $product['reduction_article'] ?? 0
            ];
            
            $total += $product['prix_article'] * $quantite;
        }
        
        // Calculer les réductions si l'utilisateur a un grade
        $totalWithReduc = null;
        $reductionGrade = 0;
        
        $adherant = $db->select(
            "SELECT * FROM ADHESION 
            INNER JOIN GRADE ON ADHESION.id_grade = GRADE.id_grade 
            WHERE ADHESION.id_membre = ? AND reduction_grade > 0",
            "i",
            [$userid]
        );
        
        if (!empty($adherant)) {
            $reductionGrade = floatval($adherant[0]["reduction_grade"] ?? 0);
            $user_reduction = 1 - ($reductionGrade / 100);
            $totalWithReduc = 0;
            
            foreach ($products as $product) {
                $product_id = $product['id_article'];
                $quantite = $_SESSION['cart'][$product_id];
                
                if (!empty($product['reduction_article'])) {
                    $totalWithReduc += $product['prix_article'] * $quantite * $user_reduction;
                } else {
                    $totalWithReduc += $product['prix_article'] * $quantite;
                }
            }
        }
        
        $data = [
            'title' => 'Ma commande - ADIIL',
            'isLoggedIn' => true,
            'cart_items' => $cart_items,
            'total' => $total,
            'totalWithReduc' => $totalWithReduc,
            'reductionGrade' => $reductionGrade
        ];
        
        $this->view('pages/order', $data);
    }
}
