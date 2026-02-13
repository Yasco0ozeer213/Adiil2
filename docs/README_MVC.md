# ADIIL - Structure MVC

## 📁 Nouvelle Structure du Projet

```
Adiil2/
├── .env                        # Configuration locale (NE PAS COMMITER)
├── .env.example                # Exemple de configuration
├── .gitignore                  # Fichiers à ignorer
├── README_MVC.md               # Ce fichier
│
├── app/                        # Application principale
│   ├── controllers/            # Contrôleurs (logique métier)
│   │   ├── HomeController.php
│   │   ├── EventsController.php
│   │   ├── NewsController.php
│   │   ├── ShopController.php
│   │   ├── AccountController.php
│   │   └── AdminController.php
│   │
│   ├── models/                 # Modèles (accès aux données)
│   │   ├── User.php
│   │   ├── Event.php
│   │   ├── News.php
│   │   ├── Product.php
│   │   └── Grade.php
│   │
│   └── views/                  # Vues (interface utilisateur)
│       ├── layouts/            # Templates de base
│       │   ├── header.php
│       │   └── footer.php
│       │
│       ├── pages/              # Pages principales
│       │   ├── home.php
│       │   ├── events.php
│       │   ├── news.php
│       │   ├── shop.php
│       │   └── account.php
│       │
│       └── admin/              # Pages admin
│           └── dashboard.php
│
├── config/                     # Configuration
│   └── config.php              # Chargement des variables .env
│
├── core/                       # Noyau MVC
│   ├── Controller.php          # Classe Controller de base
│   ├── Database.php            # Gestion BDD
│   └── Router.php              # Système de routage
│
├── public/                     # Point d'entrée public
│   ├── index.php               # Point d'entrée principal
│   ├── .htaccess               # Configuration Apache
│   ├── assets/                 # Images, fonts, etc.
│   ├── styles/                 # CSS
│   ├── scripts/                # JavaScript
│   └── uploads/                # Fichiers uploadés
│
└── api/                        # API (existant, à migrer progressivement)
```

## 🚀 Installation

### 1. Configuration de l'environnement

1. Copier `.env.example` vers `.env` :
   ```bash
   cp .env.example .env
   ```

2. Modifier `.env` avec vos paramètres locaux :
   ```env
   DB_HOST=localhost
   DB_PORT=3306
   DB_NAME=votre_base
   DB_USER=votre_utilisateur
   DB_PASSWORD=votre_mot_de_passe
   ```

### 2. Configuration MAMP

1. Définir le document root vers le dossier `public/` :
   - Préférences MAMP → Web Server → Document Root
   - Pointer vers : `/Applications/MAMP/htdocs/sae4/Adiil2/public`

2. Ou utiliser un Virtual Host (recommandé) :
   ```apache
   <VirtualHost *:80>
       ServerName adiil.local
       DocumentRoot "/Applications/MAMP/htdocs/sae4/Adiil2/public"
       <Directory "/Applications/MAMP/htdocs/sae4/Adiil2/public">
           AllowOverride All
           Require all granted
       </Directory>
   </VirtualHost>
   ```

3. Ajouter dans `/etc/hosts` :
   ```
   127.0.0.1 adiil.local
   ```

## 📝 Guide de Migration

### Organisation des fichiers actuels

Les fichiers PHP actuels doivent être réorganisés :

**Ancien** → **Nouveau**

**Contrôleurs** (logique métier) :
- `index.php` → `app/controllers/HomeController.php` + `app/views/pages/home.php`
- `events.php` → `app/controllers/EventsController.php` + `app/views/pages/events.php`
- `news.php` → `app/controllers/NewsController.php` + `app/views/pages/news.php`
- `shop.php` → `app/controllers/ShopController.php` + `app/views/pages/shop.php`
- `account.php` → `app/controllers/AccountController.php` + `app/views/pages/account.php`
- `login.php` → `app/controllers/AuthController.php` + `app/views/pages/login.php`

**Modèles** (accès BDD) :
- `database.php` → Déjà migré vers `core/Database.php`
- `cart_class.php` → `app/models/Cart.php`
- Créer des modèles pour Event, News, Product, User, Grade

**Vues** (templates) :
- `header.php` → `app/views/layouts/header.php`
- `footer.php` → `app/views/layouts/footer.php`

**Assets** :
- `assets/*` → `public/assets/*`
- `styles/*` → `public/styles/*`
- `scripts/*` → `public/scripts/*`

### Exemple de migration d'une page

**Avant (index.php)** :
```php
<?php
require_once 'header.php';
require_once 'database.php';
$db = new DB();
// ... logique ...
// ... HTML ...
require_once 'footer.php';
?>
```

**Après** :

**Contrôleur** (`app/controllers/HomeController.php`) :
```php
<?php
class HomeController extends Controller {
    public function index() {
        $db = new DB();
        // ... logique ...
        $data = ['titre' => 'Accueil', 'isLoggedIn' => isset($_SESSION["userid"])];
        $this->view('pages/home', $data);
    }
}
```

**Vue** (`app/views/pages/home.php`) :
```php
<?php require_once VIEWS . '/layouts/header.php'; ?>
<!-- HTML de la page -->
<?php require_once VIEWS . '/layouts/footer.php'; ?>
```

## 🔗 URLs et Routage

### Format des URLs

Le système MVC utilise des URLs propres :

- `http://adiil.local/` → HomeController::index()
- `http://adiil.local/events` → EventsController::index()
- `http://adiil.local/events/details/5` → EventsController::details(5)
- `http://adiil.local/shop` → ShopController::index()
- `http://adiil.local/admin` → AdminController::index()

### Structure d'un Contrôleur

```php
<?php
class EventsController extends Controller {
    
    public function index() {
        // Liste des événements
        $eventModel = $this->model('Event');
        $events = $eventModel->getAll();
        $this->view('pages/events', ['events' => $events]);
    }
    
    public function details($id) {
        // Détails d'un événement
        $eventModel = $this->model('Event');
        $event = $eventModel->getById($id);
        $this->view('pages/event_details', ['event' => $event]);
    }
}
```

## 🔄 Workflow Git

### Avant de commencer à travailler

```bash
git pull origin main
```

### Après vos modifications

```bash
# Voir les fichiers modifiés
git status

# Ajouter les fichiers
git add .

# Commiter avec un message clair
git commit -m "feat: ajout du contrôleur Events"

# Pousser vers le dépôt
git push origin main
```

### Convention de commits

- `feat:` - Nouvelle fonctionnalité
- `fix:` - Correction de bug
- `refactor:` - Refactorisation sans changement fonctionnel
- `style:` - Modifications CSS/mise en forme
- `docs:` - Documentation

## ⚠️ Important

1. **NE JAMAIS commiter le fichier `.env`** - Il contient vos identifiants locaux
2. **Toujours utiliser `.env.example`** pour partager la structure de configuration
3. **Faire des commits réguliers** avec des messages clairs
4. **Tester localement** avant de pousser
5. **Communiquer avec l'équipe** sur les modifications importantes

## 🛠️ Prochaines étapes

1. ✅ Structure MVC créée
2. ✅ Fichiers de configuration (.env, .gitignore)
3. ⏳ Migration des fichiers existants vers la structure MVC
4. ⏳ Création des contrôleurs
5. ⏳ Création des modèles
6. ⏳ Organisation des vues
7. ⏳ Tests et validation

## 📚 Ressources

- [MVC Pattern](https://en.wikipedia.org/wiki/Model%E2%80%93view%E2%80%93controller)
- [Git Workflow](https://www.atlassian.com/git/tutorials/comparing-workflows)
