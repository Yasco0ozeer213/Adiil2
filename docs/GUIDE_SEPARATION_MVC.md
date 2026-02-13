# 🎯 Guide : Comment séparer une page PHP en MVC

## 📋 Les 3 parties à identifier

Quand tu regardes un fichier PHP classique comme `index.php`, tu dois identifier **3 zones** :

### 🟢 **1. LOGIQUE (Controller)** - Tout ce qui est entre `<?php ?>` SANS affichage HTML

**Comment reconnaître ?**
- ✅ Connexion à la base de données : `$db = new DB();`
- ✅ Requêtes SQL : `$db->select("SELECT ...")`
- ✅ Calculs et vérifications : `$isLoggedIn = isset($_SESSION["userid"])`
- ✅ Traitement de données : boucles pour transformer les données
- ❌ PAS de `<html>`, `<div>`, `echo` de HTML

**Exemple dans `index.php` :**
```php
<?php
// 🔵 PARTIE CONTROLLER - À mettre dans HomeController.php
require_once 'database.php';
$db = new DB();
$isLoggedIn = isset($_SESSION["userid"]);

// Requête SQL pour le podium
$podium = $db->select(
    "SELECT prenom_membre, xp_membre, pp_membre FROM MEMBRE ORDER BY xp_membre DESC LIMIT 3;"
);

// Requête SQL pour les événements
$date = getdate();
$sql_date = $date["year"]."-".$date["mon"]."-".$date["mday"];
$events_to_display = $db->select(
    "SELECT id_evenement, nom_evenement, lieu_evenement, date_evenement 
     FROM EVENEMENT 
     WHERE date_evenement >= ? 
     ORDER BY date_evenement ASC LIMIT 2;",
    "s",
    [$sql_date]
);

// Traitement des données d'événements
foreach ($events_to_display as &$event) {
    $eventid = $event["id_evenement"];
    
    // Vérifier places disponibles
    $isPlaceDisponible = $db->select("...");
    $event['isPlaceDisponible'] = $isPlaceDisponible;
    
    // Vérifier inscription
    if($isLoggedIn) {
        $isSubscribed = !empty($db->select("..."));
        $event['isSubscribed'] = $isSubscribed;
    }
}
?>
```

---

### 🟡 **2. AFFICHAGE (View)** - Tout le HTML avec les variables

**Comment reconnaître ?**
- ✅ Balises HTML : `<html>`, `<body>`, `<div>`, `<section>`, etc.
- ✅ Affichage de variables : `<?php echo $variable; ?>`
- ✅ Boucles d'affichage : `<?php foreach($items as $item): ?>` suivies de HTML
- ✅ Conditions d'affichage : `<?php if($condition): ?>` suivies de HTML
- ❌ PAS de requêtes SQL directes
- ❌ PAS de calculs complexes

**Exemple dans `index.php` :**
```html
<!-- 🟡 PARTIE VIEW - À mettre dans app/views/pages/home.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="stylesheet" href="/styles/index_style.css">
</head>
<body>
    <!-- Affichage du podium avec les données reçues -->
    <div id="podium">
        <?php foreach ([2,1,3] as $member_number): 
            $pod = $podium[$member_number-1]; // $podium vient du controller
        ?>
            <div class="podium_unit">
                <h3>#0<?php echo $member_number?></h3>
                <h4><?php echo $pod['prenom_membre'];?></h4>
                <div>
                    <?php if($pod['pp_membre'] == null):?>
                        <img src="/admin/ressources/default_images/user.jpg">
                    <?php else:?>
                        <img src="/api/files/<?php echo $pod['pp_membre'];?>">
                    <?php endif?>
                    <?php echo $pod['xp_membre'];?> xp
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
```

---

### 🔴 **3. MODÈLE (Model)** - Requêtes SQL réutilisables (OPTIONNEL)

**Comment reconnaître ?**
- ✅ Requêtes SQL qui se répètent dans plusieurs pages
- ✅ Opérations CRUD : Create, Read, Update, Delete
- ✅ Logique métier spécifique à une table

**Exemple :**
Si tu vois cette requête dans **plusieurs fichiers** :
```php
$events = $db->select("SELECT * FROM EVENEMENT WHERE date_evenement >= ?");
```

Tu peux créer une méthode dans `Event.php` (Model) :
```php
// 🔴 PARTIE MODEL - app/models/Event.php
class Event {
    public function getUpcomingEvents($date) {
        $db = new Database();
        return $db->select(
            "SELECT * FROM EVENEMENT WHERE date_evenement >= ? ORDER BY date_evenement",
            "s",
            [$date]
        );
    }
}
```

**⚠️ IMPORTANT** : Le Model n'est PAS obligatoire au début ! Tu peux faire toutes les requêtes dans le Controller.

---

## 🎬 Processus étape par étape

### **Étape 1 : Ouvre le fichier PHP original**
Exemple : `events.php`

### **Étape 2 : Surligne les zones avec des couleurs mentales**

```php
<!DOCTYPE html>
<html>
<head>...</head>
<body>
    🟡 HTML STATIC (View)

    <?php
    🔵 require_once 'database.php';        ← Controller
    🔵 $db = new DB();                     ← Controller
    🔵 $events = $db->select("SELECT..."); ← Controller
    ?>

    🟡 <div class="events-list">            ← View
        🟡 <?php foreach($events as $event): ?> ← View (affichage)
            🟡 <h2><?php echo $event['nom']; ?></h2> ← View
        🟡 <?php endforeach; ?>            ← View
    🟡 </div>                              ← View
</body>
</html>
```

### **Étape 3 : Copie le HTML dans la Vue**

Crée `app/views/pages/events.php` :
```php
<?php extract($data); // Récupère les variables du controller ?>
<!DOCTYPE html>
<html>
<head>...</head>
<body>
    <div class="events-list">
        <?php foreach($events as $event): ?>
            <h2><?php echo $event['nom']; ?></h2>
        <?php endforeach; ?>
    </div>
</body>
</html>
```

### **Étape 4 : Copie la logique dans le Controller**

Complète `app/controllers/EventsController.php` :
```php
class EventsController extends Controller {
    public function index() {
        // 🔵 Toute la logique ici
        $db = new Database();
        $events = $db->select("SELECT...");
        
        // Préparer les données pour la vue
        $data = [
            'events' => $events
        ];
        
        // Envoyer à la vue
        $this->view('pages/events', $data);
    }
}
```

---

## ✅ Checklist de vérification

Avant de tester, vérifie :

- [ ] **Controller** : Toutes les requêtes SQL sont dans le controller ?
- [ ] **Controller** : Les variables sont dans le tableau `$data` ?
- [ ] **Controller** : La méthode se termine par `$this->view('pages/xxx', $data)` ?
- [ ] **View** : Aucune requête SQL directe (pas de `$db->select()`) ?
- [ ] **View** : Les variables utilisées viennent de `$data` (via `extract()`) ?
- [ ] **View** : Les liens sont en format MVC (`/events` pas `/events.php`) ?
- [ ] **Header** : Les liens du menu sont mis à jour ?

---

## 🎯 Exemple complet : Migration de `shop.php`

### **1. Fichier original `shop.php`**
```php
<!DOCTYPE html>
<html>
<body>
    <?php
    require_once 'header.php';
    require_once 'database.php';
    $db = new DB();
    
    $products = $db->select("SELECT * FROM ARTICLE ORDER BY nom_article");
    ?>
    
    <div class="shop">
        <?php foreach($products as $product): ?>
            <div class="product">
                <h3><?php echo $product['nom_article']; ?></h3>
                <p><?php echo $product['prix_article']; ?>€</p>
            </div>
        <?php endforeach; ?>
    </div>
    
    <?php require_once 'footer.php'; ?>
</body>
</html>
```

### **2. Controller : `app/controllers/ShopController.php`**
```php
<?php
class ShopController extends Controller {
    public function index() {
        // 🔵 LOGIQUE : Récupérer les produits
        $db = new Database();
        $products = $db->select("SELECT * FROM ARTICLE ORDER BY nom_article");
        
        // Préparer les données
        $data = [
            'products' => $products,
            'title' => 'Boutique - ADIIL'
        ];
        
        // Afficher la vue
        $this->view('pages/shop', $data);
    }
}
```

### **3. Vue : `app/views/pages/shop.php`**
```php
<?php extract($data); ?>
<!DOCTYPE html>
<html>
<body>
    <?php require APP . '/views/layouts/header.php'; ?>
    
    <div class="shop">
        <?php foreach($products as $product): ?>
            <div class="product">
                <h3><?php echo $product['nom_article']; ?></h3>
                <p><?php echo $product['prix_article']; ?>€</p>
            </div>
        <?php endforeach; ?>
    </div>
    
    <?php require APP . '/views/layouts/footer.php'; ?>
</body>
</html>
```

---

## 🚀 Exercice pratique

Essaie de migrer `news.php` toi-même en suivant ces étapes :

1. **Identifie** : Surligne mentalement les zones Controller et View
2. **Copie** : Crée `app/views/pages/news.php` avec le HTML
3. **Adapte** : Complète `NewsController::index()` avec la logique
4. **Teste** : Accède à `http://localhost:8888/news`

---

## 💡 Astuces

- **Si tu vois `$db->select()`** → Controller
- **Si tu vois `<html>` ou `<div>`** → View
- **Si tu vois `foreach()` avec du HTML après** → View (mais les données viennent du Controller)
- **Si tu vois `isset($_SESSION)`** → Controller
- **Si tu vois `require_once 'database.php'`** → Controller

---

## ❓ Questions fréquentes

**Q : Et si j'ai du PHP au milieu du HTML ?**
R : Si c'est juste pour afficher (`echo`), c'est de la Vue. Si c'est pour calculer, c'est du Controller.

**Q : Je dois créer un Model pour chaque page ?**
R : Non ! Le Model est optionnel. Au début, mets tout dans le Controller.

**Q : Comment je sais si une requête SQL doit être dans le Model ?**
R : Si elle est utilisée dans **plusieurs controllers**, mets-la dans le Model. Sinon, laisse-la dans le Controller.

**Q : extract($data) c'est obligatoire ?**
R : Non, mais c'est plus simple. Sinon tu dois écrire `$data['products']` au lieu de `$products`.

---

Bonne migration ! 🎉
