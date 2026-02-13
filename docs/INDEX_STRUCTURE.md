# 📦 Structure MVC - ADIIL

## ✅ RESTRUCTURATION TERMINÉE !

Votre projet a été restructuré en architecture MVC. **Aucun code n'a été modifié**, seule la structure des dossiers a été créée.

## 📁 Nouvelle arborescence

```
Adiil2/
│
├── 📄 .env                          # Configuration locale (NE PAS COMMITER !)
├── 📄 .env.example                  # Template de configuration
├── 📄 .gitignore                    # Fichiers à ignorer par Git
├── 📄 README.md                     # README original
├── 📄 README_MVC.md                 # 📖 Documentation MVC complète
├── 📄 DEMARRAGE_RAPIDE.md           # 🚀 Guide de démarrage rapide
├── 📄 MIGRATION_GUIDE.md            # 📋 Guide de migration détaillé
├── 📄 ORGANISATION_EQUIPE.md        # 👥 Organisation du travail d'équipe
├── 📄 INDEX_STRUCTURE.md            # 📦 Ce fichier
│
├── 📂 app/                          # APPLICATION PRINCIPALE
│   ├── 📂 controllers/              # 🎮 CONTRÔLEURS (logique métier)
│   │   ├── HomeController.php       # Page d'accueil
│   │   ├── EventsController.php     # Événements
│   │   ├── NewsController.php       # Actualités
│   │   ├── ShopController.php       # Boutique et panier
│   │   ├── AccountController.php    # Compte utilisateur
│   │   ├── AuthController.php       # Authentification
│   │   ├── AdminController.php      # Administration
│   │   └── GradeController.php      # Grades
│   │
│   ├── 📂 models/                   # 📊 MODÈLES (accès aux données)
│   │   ├── User.php                 # Modèle Utilisateur
│   │   ├── Event.php                # Modèle Événement
│   │   ├── News.php                 # Modèle Actualité
│   │   ├── Product.php              # Modèle Produit
│   │   └── Grade.php                # Modèle Grade
│   │
│   └── 📂 views/                    # 👁️ VUES (templates HTML)
│       ├── 📂 layouts/              # Templates de base
│       │   ├── header.php           # En-tête (à migrer)
│       │   └── footer.php           # Pied de page (à migrer)
│       │
│       ├── 📂 pages/                # Pages du site
│       │   ├── home.php             # Accueil (à créer)
│       │   ├── events.php           # Liste événements (à créer)
│       │   ├── event_details.php    # Détails événement (à créer)
│       │   ├── news.php             # Actualités (à créer)
│       │   ├── shop.php             # Boutique (à créer)
│       │   ├── account.php          # Compte (à créer)
│       │   └── ...                  # Autres pages
│       │
│       └── 📂 admin/                # Pages d'administration
│           └── dashboard.php        # Tableau de bord admin (à créer)
│
├── 📂 config/                       # ⚙️ CONFIGURATION
│   └── config.php                   # Chargement des variables .env
│
├── 📂 core/                         # 🔧 NOYAU MVC
│   ├── Database.php                 # Gestion de la base de données
│   ├── Controller.php               # Classe Controller de base
│   └── Router.php                   # Système de routage
│
├── 📂 public/                       # 🌐 DOSSIER PUBLIC (point d'entrée)
│   ├── index.php                    # ⭐ POINT D'ENTRÉE PRINCIPAL
│   ├── .htaccess                    # Redirection Apache
│   │
│   ├── 📂 assets/                   # Images, fonts, etc.
│   │   └── (à copier depuis /assets/)
│   │
│   ├── 📂 styles/                   # Fichiers CSS
│   │   └── (à copier depuis /styles/)
│   │
│   ├── 📂 scripts/                  # Fichiers JavaScript
│   │   └── (à copier depuis /scripts/)
│   │
│   └── 📂 uploads/                  # Fichiers uploadés par les utilisateurs
│       └── .gitkeep
│
├── 📂 api/                          # 🔌 API (garder pour l'instant)
│   └── ...                          # Fichiers API existants
│
├── 📂 admin/                        # 🔐 Administration (ancienne structure)
│   └── ...                          # À migrer progressivement
│
└── 📂 old_files/                    # 📦 Anciens fichiers (à créer lors migration)
    └── (fichiers PHP originaux)
```

## 🎯 Les 3 fichiers à lire ABSOLUMENT

1. **DEMARRAGE_RAPIDE.md** 🚀
   - Configuration en 10 minutes
   - Premiers pas avec la structure MVC
   - Test de la configuration

2. **MIGRATION_GUIDE.md** 📋
   - Liste complète des fichiers à migrer
   - Étapes détaillées
   - Exemples de migration

3. **ORGANISATION_EQUIPE.md** 👥
   - Répartition des tâches
   - Workflow Git
   - Bonnes pratiques

## 🔑 Concepts clés du MVC

### Model (Modèle) 📊
**Où ?** `app/models/`
**Quoi ?** Accès aux données de la base de données
**Exemple :** `User.php`, `Event.php`, `Product.php`

```php
// app/models/Event.php
class Event {
    public function getAll() {
        // Récupère tous les événements
    }
}
```

### View (Vue) 👁️
**Où ?** `app/views/`
**Quoi ?** Templates HTML à afficher
**Exemple :** `pages/home.php`, `layouts/header.php`

```php
// app/views/pages/home.php
<?php require_once VIEWS . '/layouts/header.php'; ?>
<h1>Bienvenue sur ADIIL</h1>
<?php require_once VIEWS . '/layouts/footer.php'; ?>
```

### Controller (Contrôleur) 🎮
**Où ?** `app/controllers/`
**Quoi ?** Logique métier, coordination entre Model et View
**Exemple :** `HomeController.php`, `EventsController.php`

```php
// app/controllers/EventsController.php
class EventsController extends Controller {
    public function index() {
        $eventModel = $this->model('Event');
        $events = $eventModel->getAll();
        $this->view('pages/events', ['events' => $events]);
    }
}
```

## 🔄 Flux de données

```
1. Utilisateur visite : http://adiil.local/events
                          ↓
2. Router analyse l'URL → EventsController::index()
                          ↓
3. Contrôleur récupère les données → Event::getAll()
                          ↓
4. Contrôleur passe les données à la vue → events.php
                          ↓
5. Vue affiche le HTML avec les données
```

## 🛠️ Fichiers de configuration

### .env (LOCAL - NE PAS COMMITER)
```env
DB_HOST=localhost
DB_NAME=sae
DB_USER=etu
DB_PASSWORD=motdepasse
```

### .env.example (À COMMITER)
Template pour que les autres membres de l'équipe sachent quoi configurer.

## 📝 Convention de nommage

### Contrôleurs
- Nom : `NomController.php`
- Classe : `class NomController extends Controller`
- Méthode : `public function index()`, `public function details($id)`

### Modèles
- Nom : `Nom.php` (singulier)
- Classe : `class Nom`
- Méthodes : `getAll()`, `getById($id)`, `create($data)`

### Vues
- Nom : `nom_page.php` (snake_case)
- Emplacement : `app/views/pages/` ou `app/views/admin/`

## 🌐 Routage

### Ancien système
```
/events.php
/event_details.php?id=5
/shop.php
```

### Nouveau système MVC
```
/events              → EventsController::index()
/events/details/5    → EventsController::details(5)
/shop                → ShopController::index()
/shop/cart           → ShopController::cart()
/auth/login          → AuthController::login()
```

## ⚙️ Configuration MAMP

**Très important !** MAMP doit pointer vers le dossier `public/` :

```
Document Root : /Applications/MAMP/htdocs/sae4/Adiil2/public
```

Ou créer un Virtual Host (voir DEMARRAGE_RAPIDE.md).

## 🚦 État de la migration

### ✅ Terminé
- Structure MVC créée
- Fichiers core (Database, Controller, Router)
- Configuration (.env, config.php)
- Contrôleurs de base (8)
- Modèles de base (5)
- Documentation complète

### 🔄 En cours / À faire
- Migration des layouts (header, footer)
- Migration des vues (toutes les pages)
- Migration des assets (images, CSS, JS)
- Tests et validation
- Nettoyage des anciens fichiers

## 📚 Documentation

| Fichier | Description | Priorité |
|---------|-------------|----------|
| **DEMARRAGE_RAPIDE.md** | Guide de démarrage | ⭐⭐⭐ |
| **MIGRATION_GUIDE.md** | Comment migrer les fichiers | ⭐⭐⭐ |
| **ORGANISATION_EQUIPE.md** | Travail d'équipe | ⭐⭐⭐ |
| **README_MVC.md** | Documentation MVC complète | ⭐⭐ |
| **INDEX_STRUCTURE.md** | Vue d'ensemble (ce fichier) | ⭐ |

## 🎓 Ressources

- [Tutoriel MVC PHP](https://www.leaseweb.com/labs/2015/10/creating-a-simple-rest-api-in-php/)
- [Pattern MVC](https://fr.wikipedia.org/wiki/Mod%C3%A8le-vue-contr%C3%B4leur)
- [Git Workflow](https://www.atlassian.com/git/tutorials/comparing-workflows)

## ⚠️ Points d'attention

1. ❌ **NE JAMAIS commiter .env**
2. ✅ **TOUJOURS tester avant de pousser**
3. ✅ **Faire des commits réguliers**
4. ✅ **Communiquer avec l'équipe**
5. ✅ **Garder les anciens fichiers** jusqu'à la fin de la migration

## 🆘 Besoin d'aide ?

1. 📖 Lire la documentation (README_MVC.md, MIGRATION_GUIDE.md)
2. 💬 Demander à l'équipe
3. 🔍 Google / Stack Overflow
4. 📧 Créer une issue sur GitHub

---

**Bonne migration ! 🚀**

*Structure créée le : février 2026*
*Pour le projet : ADIIL - Association du Département Informatique IUT Laval*
