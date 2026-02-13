<?php
/**
 * CartController - Contrôleur pour la gestion du panier
 */

class CartController extends Controller
{
    public function index()
    {
        $db = new Database();
        
        // Charger la classe cart
        require_once ROOT . '/cart_class.php';
        $cart = new cart($db);
        
        // Supprimer un article du panier
        if (isset($_GET['del'])) {
            $productId = (int)$_GET['del'];
            unset($_SESSION['cart'][$productId]);
            $this->redirect('/cart');
            return;
        }
        
        // Mettre à jour les quantités
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cart']['quantity'])) {
            foreach ($_POST['cart']['quantity'] as $productId => $quantity) {
                $quantity = (int)$quantity;
                if ($quantity > 0) {
                    $_SESSION['cart'][$productId] = $quantity;
                } else {
                    unset($_SESSION['cart'][$productId]);
                }
            }
            $this->redirect('/cart');
            return;
        }
        
        // Récupérer les produits du panier
        $ids = array_keys($_SESSION['cart'] ?? []);
        $products = [];
        
        if (!empty($ids)) {
            $placeholders = implode(",", array_fill(0, count($ids), "?"));
            $query = "SELECT * FROM ARTICLE WHERE id_article IN ($placeholders)";
            $types = str_repeat("i", count($ids));
            
            $products = $db->select($query, $types, $ids);
        }
        
        // Calculer les réductions si l'utilisateur est connecté
        $totalWithReduc = null;
        $reductionGrade = 0;
        
        if (!empty($_SESSION['userid'])) {
            $adherant = $db->select(
                "SELECT * FROM ADHESION 
                INNER JOIN GRADE ON ADHESION.id_grade = GRADE.id_grade 
                WHERE ADHESION.id_membre = ? AND reduction_grade > 0",
                "i",
                [$_SESSION['userid']]
            );
            
            if (!empty($adherant)) {
                $reductionGrade = floatval($adherant[0]["reduction_grade"] ?? 0);
                $user_reduction = 1 - ($reductionGrade / 100);
                $totalWithReduc = 0;
                
                foreach ($products as $product) {
                    if (!empty($product['reduction_article'])) {
                        $totalWithReduc += $product['prix_article'] * $_SESSION['cart'][$product['id_article']] * $user_reduction;
                    } else {
                        $totalWithReduc += $product['prix_article'] * $_SESSION['cart'][$product['id_article']];
                    }
                }
            }
        }
        
        // Messages de session
        $message = null;
        $message_type = null;
        if (isset($_SESSION['message'])) {
            $message = $_SESSION['message'];
            $message_type = $_SESSION['message_type'];
            unset($_SESSION['message']);
            unset($_SESSION['message_type']);
        }
        
        $data = [
            'title' => 'Mon panier - ADIIL',
            'isLoggedIn' => isset($_SESSION["userid"]),
            'products' => $products,
            'cart' => $cart,
            'totalWithReduc' => $totalWithReduc,
            'reductionGrade' => $reductionGrade,
            'message' => $message,
            'message_type' => $message_type
        ];
        
        $this->view('pages/cart', $data);
    }
    
    public function add()
    {
        $db = new Database();
        
        // Charger la classe cart
        require_once ROOT . '/cart_class.php';
        $cart = new cart($db);
        
        $json = array('error' => true);
        
        if (isset($_GET['id'])) {
            $product = $db->select(
                "SELECT id_article FROM ARTICLE WHERE id_article = ?",
                "i",
                [$_GET['id']]
            );
            
            if (empty($product)) {
                $json['message'] = "Ce produit n'existe pas";
            } else {
                $cart->add($product[0]['id_article']);
                $json['error'] = false;
                $json['total'] = $cart->total();
                $json['count'] = $cart->count();
                $json['message'] = "Le produit a bien été ajouté à votre panier";
            }
        } else {
            $json['message'] = "Vous n'avez pas ajouté de produit à ajouter au panier";
        }
        
        // Retourner du JSON
        header('Content-Type: application/json');
        echo json_encode($json);
        exit;
    }
}
