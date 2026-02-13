# 🗺️ Guide Visuel Rapide - Structure MVC

## 📂 Où mettre quoi ?

```
┌─────────────────────────────────────────────────────┐
│  Vous créez...                │  Où le mettre ?      │
├─────────────────────────────────────────────────────┤
│  📊 Accès BDD / Requêtes SQL │  app/models/         │
│  🎮 Logique métier           │  app/controllers/    │
│  👁️ HTML / Affichage         │  app/views/pages/    │
│  🎨 Header / Footer          │  app/views/layouts/  │
│  🖼️ Images                    │  public/assets/      │
│  💅 CSS                       │  public/styles/      │
│  ⚡ JavaScript                │  public/scripts/     │
└─────────────────────────────────────────────────────┘
```

---

## 🔄 Flux de données (comment ça marche ?)

```
1️⃣ UTILISATEUR tape l'URL
   👤 http://adiil.local/events
         ↓

2️⃣ APACHE redirige vers public/index.php
   🌐 .htaccess → index.php
         ↓

3️⃣ ROUTER analyse l'URL
   🧭 /events → EventsController::index()
         ↓

4️⃣ CONTRÔLEUR charge le modèle
   🎮 $eventModel = $this->model('Event');
         ↓

5️⃣ MODÈLE interroge la BDD
   📊 $events = $eventModel->getAll();
         ↓

6️⃣ CONTRÔLEUR passe les données à la vue
   🎮 $this->view('pages/events', ['events' => $events]);
         ↓

7️⃣ VUE affiche le HTML
   👁️ foreach($events as $event) { ... }
         ↓

8️⃣ RÉSULTAT envoyé au navigateur
   📄 Page HTML complète
```

---

## 📝 Exemple concret : Migration de events.php

### ❌ AVANT (Ancien code - events.php)

```php
<?php
require_once 'header.php';
require_once 'database.php';

$db = new DB();
$events = $db->select("SELECT * FROM events ORDER BY date DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="/styles/events_style.css">
</head>
<body>
    <h1>Événements</h1>
    <?php foreach ($events as $event): ?>
        <div class="event">
            <h2><?= $event['titre'] ?></h2>
            <p><?= $event['description'] ?></p>
        </div>
    <?php endforeach; ?>
</body>
</html>

<?php require_once 'footer.php'; ?>
```

### ✅ APRÈS (Architecture MVC)

#### 1️⃣ MODÈLE (app/models/Event.php)
```php
<?php
class Event
{
    private $db;
    
    public function __construct()
    {
        $this->db = new Database();
    }
    
    public function getAll()
    {
        $sql = "SELECT * FROM events ORDER BY date DESC";
        return $this->db->select($sql);
    }
}
```

#### 2️⃣ CONTRÔLEUR (app/controllers/EventsController.php)
```php
<?php
class EventsController extends Controller
{
    public function index()
    {
        // Charger le modèle
        $eventModel = $this->model('Event');
        
        // Récupérer les données
        $events = $eventModel->getAll();
        
        // Passer à la vue
        $data = [
            'title' => 'Événements - ADIIL',
            'events' => $events
        ];
        
        $this->view('pages/events', $data);
    }
}
```

#### 3️⃣ VUE (app/views/pages/events.php)
```php
<?php require_once VIEWS . '/layouts/header.php'; ?>

<h1>Événements</h1>

<?php foreach ($events as $event): ?>
    <div class="event">
        <h2><?= $event['titre'] ?></h2>
        <p><?= $event['description'] ?></p>
    </div>
<?php endforeach; ?>

<?php require_once VIEWS . '/layouts/footer.php'; ?>
```

---

## 🎯 Étapes de migration (pour chaque page)

```
┌─────────────────────────────────────────────┐
│  ÉTAPE 1 : Identifier les 3 parties        │
├─────────────────────────────────────────────┤
│  📊 Code BDD        → Modèle                │
│  🎮 Code PHP logic  → Contrôleur            │
│  👁️ Code HTML       → Vue                   │
└─────────────────────────────────────────────┘
         ↓
┌─────────────────────────────────────────────┐
│  ÉTAPE 2 : Créer le modèle si nécessaire   │
├─────────────────────────────────────────────┤
│  app/models/NomModele.php                   │
│  - Méthodes getAll(), getById(), etc.       │
└─────────────────────────────────────────────┘
         ↓
┌─────────────────────────────────────────────┐
│  ÉTAPE 3 : Créer/Compléter le contrôleur   │
├─────────────────────────────────────────────┤
│  app/controllers/NomController.php          │
│  - Charger le modèle                        │
│  - Récupérer les données                    │
│  - Passer à la vue                          │
└─────────────────────────────────────────────┘
         ↓
┌─────────────────────────────────────────────┐
│  ÉTAPE 4 : Créer la vue                     │
├─────────────────────────────────────────────┤
│  app/views/pages/nom_page.php               │
│  - Include header                           │
│  - HTML de la page                          │
│  - Include footer                           │
└─────────────────────────────────────────────┘
         ↓
┌─────────────────────────────────────────────┐
│  ÉTAPE 5 : Mettre à jour les liens         │
├─────────────────────────────────────────────┤
│  /page.php      → /controller               │
│  /page.php?id=5 → /controller/method/5      │
└─────────────────────────────────────────────┘
         ↓
┌─────────────────────────────────────────────┐
│  ÉTAPE 6 : Tester !                         │
├─────────────────────────────────────────────┤
│  http://localhost/controller/method         │
└─────────────────────────────────────────────┘
```

---

## 🌐 URLs : Avant vs Après

```
┌──────────────────────────┬──────────────────────────────┐
│  AVANT (ancien)          │  APRÈS (MVC)                 │
├──────────────────────────┼──────────────────────────────┤
│  /index.php              │  /                           │
│  /events.php             │  /events                     │
│  /event_details.php?id=5 │  /events/details/5           │
│  /news.php               │  /news                       │
│  /news_details.php?id=3  │  /news/details/3             │
│  /shop.php               │  /shop                       │
│  /cart.php               │  /shop/cart                  │
│  /login.php              │  /auth/login                 │
│  /signin.php             │  /auth/signin                │
│  /account.php            │  /account                    │
│  /my_gallery.php         │  /account/gallery            │
│  /admin/admin.php        │  /admin                      │
└──────────────────────────┴──────────────────────────────┘
```

---

## 📦 Checklist rapide de migration d'une page

```
Pour migrer "events.php" :

✅ PRÉPARATION
□ Ouvrir events.php
□ Identifier le code BDD
□ Identifier le code PHP logique
□ Identifier le code HTML

✅ MODÈLE (si pas encore créé)
□ Créer app/models/Event.php
□ Ajouter méthode getAll()
□ Tester la méthode

✅ CONTRÔLEUR
□ Ouvrir app/controllers/EventsController.php
□ Compléter la méthode index()
□ Charger le modèle
□ Récupérer les données
□ Passer à la vue

✅ VUE
□ Créer app/views/pages/events.php
□ Include header
□ Copier le HTML de events.php
□ Mettre à jour les chemins assets
□ Include footer

✅ TEST
□ Accéder à /events
□ Vérifier l'affichage
□ Vérifier les liens
□ Vérifier les styles

✅ COMMIT
□ git add .
□ git commit -m "feat: migration page événements"
□ git push
```

---

## 🎨 Chemins des assets

### ❌ Anciens chemins (à remplacer)
```html
<img src="/assets/logo.png">
<link rel="stylesheet" href="/styles/events_style.css">
<script src="/scripts/events.js"></script>
```

### ✅ Nouveaux chemins MVC
```html
<img src="/public/assets/logo.png">
<link rel="stylesheet" href="/public/styles/events_style.css">
<script src="/public/scripts/events.js"></script>
```

### 🎯 Encore mieux (avec constante PHP)
```php
<img src="<?= ASSETS_PATH ?>/logo.png">
<link rel="stylesheet" href="<?= PUBLIC_PATH ?>/styles/events_style.css">
<script src="<?= PUBLIC_PATH ?>/scripts/events.js"></script>
```

---

## 🔗 Liens entre pages

### ❌ Ancien
```html
<a href="/events.php">Événements</a>
<a href="/event_details.php?id=<?= $event['id'] ?>">Détails</a>
```

### ✅ Nouveau (MVC)
```html
<a href="/events">Événements</a>
<a href="/events/details/<?= $event['id'] ?>">Détails</a>
```

---

## 🎭 Layouts (Header / Footer)

### Structure de base d'une vue

```php
<?php
// 1. Include le header
require_once VIEWS . '/layouts/header.php';
?>

<!-- 2. Votre contenu HTML ici -->
<div class="container">
    <h1><?= $title ?></h1>
    <!-- ... -->
</div>

<?php
// 3. Include le footer
require_once VIEWS . '/layouts/footer.php';
?>
```

---

## 💡 Astuces rapides

### 🔍 Déboguer
```php
// Dans un contrôleur ou une vue
echo "<pre>";
print_r($data);
echo "</pre>";
die();
```

### 🧪 Tester la BDD
```php
// Dans un contrôleur
$db = new Database();
$conn = $db->connect();
echo $conn ? "✅ Connecté" : "❌ Erreur";
```

### 📝 Vérifier les variables
```php
// Dans une vue
<?php if (isset($variable)): ?>
    <p><?= $variable ?></p>
<?php endif; ?>
```

---

## 🆘 Problèmes courants

| Problème | Solution |
|----------|----------|
| Page blanche | Vérifier les logs Apache, activer APP_DEBUG=true dans .env |
| 404 Not Found | Vérifier .htaccess, vérifier le nom du contrôleur |
| Assets ne chargent pas | Vérifier le Document Root de MAMP → doit pointer vers public/ |
| Erreur BDD | Vérifier les paramètres dans .env |
| Classe non trouvée | Vérifier le require_once, vérifier le nom de fichier |

---

## 📊 Progression suggérée

```
JOUR 1
✅ Configuration (.env, MAMP)
✅ Migration header/footer
✅ Copie des assets

JOUR 2-3
✅ Pages principales (home, about)
✅ Test et validation

JOUR 4-5
✅ Événements (liste, détails)
✅ Actualités (liste, détails)

JOUR 6-7
✅ Boutique (liste, panier, commande)
✅ Grades

JOUR 8-9
✅ Authentification
✅ Compte utilisateur

JOUR 10-11
✅ Administration
✅ Tests complets

JOUR 12
✅ Nettoyage
✅ Documentation finale
✅ 🎉 C'EST TERMINÉ !
```

---

## 🏆 Récapitulatif : Les 3 fichiers à créer pour chaque fonctionnalité

```
Pour la fonctionnalité "Événements" :

1️⃣ MODÈLE
   📄 app/models/Event.php
   → Méthodes : getAll(), getById($id), create($data)...

2️⃣ CONTRÔLEUR
   📄 app/controllers/EventsController.php
   → Méthodes : index(), details($id), subscribe($id)...

3️⃣ VUES
   📄 app/views/pages/events.php (liste)
   📄 app/views/pages/event_details.php (détails)
   📄 app/views/pages/event_subscription.php (inscription)
```

---

**Pour plus de détails, voir :**
- [MIGRATION_GUIDE.md](MIGRATION_GUIDE.md) - Guide complet
- [DEMARRAGE_RAPIDE.md](DEMARRAGE_RAPIDE.md) - Configuration
- [CHECKLIST.md](CHECKLIST.md) - Liste complète des tâches

**Bon courage ! 💪**
