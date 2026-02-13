# 🔴 MODEL : Quand et comment l'utiliser ?

## ❓ C'est quoi un Model ?

Le **Model** est une classe qui :
- Gère les **requêtes SQL** pour une table spécifique
- Contient la **logique métier** liée aux données
- Permet de **réutiliser** les mêmes requêtes partout

---

## 🤔 Model : Obligatoire ou optionnel ?

### ⚠️ **OPTIONNEL au début !**

Tu peux **toujours** mettre les requêtes SQL directement dans le Controller :

```php
// ✅ C'est OK pour commencer
class EventsController extends Controller {
    public function index() {
        $db = new Database();
        $events = $db->select("SELECT * FROM EVENEMENT");
        $this->view('pages/events', ['events' => $events]);
    }
}
```

### ✅ **RECOMMANDÉ quand tu vois des RÉPÉTITIONS**

Si la **même requête** apparaît dans **plusieurs controllers**, utilise un Model :

---

## 🎯 Exemple concret : `Event.php`

### **Avant (SANS Model)** - Répétition de code

**Dans `HomeController.php` :**
```php
$db = new Database();
$events = $db->select(
    "SELECT id_evenement, nom_evenement, lieu_evenement, date_evenement 
     FROM EVENEMENT 
     WHERE date_evenement >= ? 
     ORDER BY date_evenement ASC 
     LIMIT 2",
    "s",
    [$sql_date]
);

$isPlaceDisponible = $db->select(
    "SELECT (places_evenement - (SELECT COUNT(*) FROM INSCRIPTION WHERE id_evenement = ?)) > 0 
     FROM EVENEMENT 
     WHERE id_evenement = ?",
    "i",
    [$event_id]
);
```

**Dans `EventsController.php` :**
```php
// 🔴 EXACTEMENT LA MÊME REQUÊTE !
$db = new Database();
$events = $db->select(
    "SELECT id_evenement, nom_evenement, lieu_evenement, date_evenement 
     FROM EVENEMENT 
     WHERE date_evenement >= ? 
     ORDER BY date_evenement ASC 
     LIMIT 2",
    "s",
    [$sql_date]
);

// 🔴 ET ENCORE LA MÊME !
$isPlaceDisponible = $db->select(...);
```

**Problème :** Si tu dois changer la requête, tu dois la modifier **partout** ! 😱

---

### **Après (AVEC Model)** - Code réutilisable

**Créer `app/models/Event.php` :**
```php
<?php
class Event {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // 🟢 Méthode réutilisable
    public function getUpcomingEventsWithLimit($sql_date, $limit = 2) {
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

    // 🟢 Méthode réutilisable
    public function hasAvailablePlaces($event_id) {
        $result = $this->db->select(
            "SELECT (places_evenement - (SELECT COUNT(*) FROM INSCRIPTION WHERE id_evenement = EVENEMENT.id_evenement)) > 0 AS isPlaceDisponible 
             FROM EVENEMENT 
             WHERE id_evenement = ?",
            "i",
            [$event_id]
        );
        return (bool)$result[0]['isPlaceDisponible'];
    }
}
```

**Utiliser dans `HomeController.php` :**
```php
class HomeController extends Controller {
    public function index() {
        // 🟢 Charger le Model
        $eventModel = $this->model('Event');
        
        // 🟢 Utiliser les méthodes
        $events = $eventModel->getUpcomingEventsWithLimit($sql_date, 2);
        
        foreach ($events as &$event) {
            $event['hasPlaces'] = $eventModel->hasAvailablePlaces($event['id_evenement']);
        }
        
        $this->view('pages/home', ['events' => $events]);
    }
}
```

**Utiliser dans `EventsController.php` :**
```php
class EventsController extends Controller {
    public function index() {
        // 🟢 Même méthode, même code !
        $eventModel = $this->model('Event');
        $events = $eventModel->getUpcomingEventsWithLimit($sql_date, 10);
        
        foreach ($events as &$event) {
            $event['hasPlaces'] = $eventModel->hasAvailablePlaces($event['id_evenement']);
        }
        
        $this->view('pages/events', ['events' => $events]);
    }
}
```

**Avantage :** Une seule modification dans le Model = tout est mis à jour ! 🎉

---

## 📊 Quand utiliser un Model ?

### ✅ **OUI, utilise un Model si :**

1. **La requête est RÉPÉTÉE** dans plusieurs controllers
   - Exemple : `getUpcomingEvents()` utilisé dans Home + Events + Admin

2. **La logique est COMPLEXE**
   - Exemple : Calculer des statistiques, vérifier des règles métier

3. **Tu veux ORGANISER** ton code
   - Exemple : Toutes les requêtes liées aux événements dans `Event.php`

### ❌ **NON, pas besoin de Model si :**

1. **La requête n'est utilisée QU'UNE SEULE FOIS**
   - Exemple : Une requête spécifique pour une page admin

2. **C'est une requête SIMPLE** pour un test
   - Exemple : `SELECT * FROM ...` basique

3. **Tu débutes** et veux aller vite
   - Commence avec les requêtes dans le Controller, refactore plus tard

---

## 🛠️ Structure d'un bon Model

```php
<?php
class Event {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // 🟢 GET : Récupérer des données
    public function getAll() { ... }
    public function getById($id) { ... }
    public function getUpcoming() { ... }
    
    // 🟢 CREATE : Créer une entrée
    public function create($data) { ... }
    
    // 🟢 UPDATE : Modifier une entrée
    public function update($id, $data) { ... }
    
    // 🟢 DELETE : Supprimer une entrée
    public function delete($id) { ... }
    
    // 🟢 LOGIQUE MÉTIER : Vérifications
    public function hasAvailablePlaces($id) { ... }
    public function isUserSubscribed($user_id, $event_id) { ... }
}
```

---

## 🎯 Exemple complet : Migration avec Model

### **1. Identifier les requêtes répétées**

Cherche dans ton projet :
```bash
# Dans le terminal
grep -r "SELECT.*FROM EVENEMENT" *.php
```

Si tu vois la même requête **2 fois ou plus** → Model !

### **2. Créer le Model**

`app/models/Event.php` avec les méthodes réutilisables.

### **3. Utiliser dans les Controllers**

**Avant :**
```php
$db = new Database();
$events = $db->select("SELECT...");
```

**Après :**
```php
$eventModel = $this->model('Event');
$events = $eventModel->getUpcoming();
```

---

## 💡 Résumé

| Situation | Solution |
|-----------|----------|
| Requête utilisée **1 fois** | Controller (pas de Model) |
| Requête utilisée **2+ fois** | Model |
| Logique métier complexe | Model |
| Tu débutes / prototypes | Controller (refactore plus tard) |
| Organisation professionnelle | Model pour chaque table |

---

## ✅ Pour ton projet ADIIL

Voici les Models recommandés :

1. **`Event.php`** ✅ (déjà créé)
   - `getUpcomingEvents()`
   - `hasAvailablePlaces()`
   - `isUserSubscribed()`

2. **`User.php`** (à créer)
   - `getById()`
   - `login()`
   - `register()`
   - `updateProfile()`

3. **`Product.php`** (à créer)
   - `getAll()`
   - `getById()`
   - `getByCategory()`

4. **`News.php`** (à créer)
   - `getRecent()`
   - `getById()`

5. **`Grade.php`** (optionnel)
   - Si les grades sont souvent utilisés

---

## 🚀 En pratique

**Pour ta migration :**

1. **Commence SANS Model** (requêtes dans les Controllers)
2. **Identifie les répétitions** après avoir migré 2-3 pages
3. **Crée les Models** pour les requêtes répétées
4. **Refactore les Controllers** pour utiliser les Models

**Ne crée pas tous les Models d'un coup !** Fais-le au fur et à mesure. 💪

---

## ❓ Questions ?

**Q : Je dois créer un Model pour chaque table ?**
R : Non ! Seulement pour les tables souvent utilisées (Event, User, Product, News).

**Q : Puis-je mixer requêtes directes + Model ?**
R : Oui ! Utilise le Model pour les requêtes répétées, direct pour les requêtes uniques.

**Q : Le Model peut appeler un autre Model ?**
R : Oui ! Exemple : `Event` peut appeler `User->getById()`.

---

Bonne migration ! 🎉
