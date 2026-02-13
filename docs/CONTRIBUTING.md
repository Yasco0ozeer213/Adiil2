# 🤝 CONTRIBUTING - Guide de Contribution

## Bienvenue !

Merci de contribuer au projet ADIIL ! Ce guide vous aidera à contribuer efficacement.

---

## 📋 Avant de contribuer

### Prérequis
- [ ] Avoir lu [COMMENCER_ICI.md](COMMENCER_ICI.md)
- [ ] Avoir configuré son environnement local
- [ ] Avoir compris l'architecture MVC ([GUIDE_VISUEL.md](GUIDE_VISUEL.md))
- [ ] Avoir choisi une tâche dans [CHECKLIST.md](CHECKLIST.md)

---

## 🔄 Workflow Git

### 1. Récupérer les dernières modifications

```bash
git pull origin main
```

### 2. Créer une branche (optionnel mais recommandé)

```bash
# Format : type/description-courte
git checkout -b feat/page-evenements
git checkout -b fix/bug-connexion
git checkout -b refactor/modele-user
```

### 3. Faire vos modifications

Travaillez sur votre tâche...

### 4. Tester localement

```bash
# Vérifier que tout fonctionne
# Tester dans le navigateur
# Vérifier la console pour les erreurs
```

### 5. Commiter

```bash
git add .
git commit -m "feat: migration page événements vers MVC"
```

### 6. Pousser

```bash
# Si branche main
git push origin main

# Si branche feature
git push origin feat/page-evenements
```

### 7. Pull Request (si utilisation de branches)

Sur GitHub, créer une Pull Request de votre branche vers `main`.

---

## ✍️ Convention de commits

### Format

```
type: description courte

[corps optionnel]

[footer optionnel]
```

### Types

- `feat:` Nouvelle fonctionnalité
- `fix:` Correction de bug
- `refactor:` Refactorisation (sans changement fonctionnel)
- `style:` Modifications CSS ou formatage code
- `docs:` Documentation
- `test:` Ajout ou modification de tests
- `chore:` Tâches de maintenance

### Exemples

```bash
git commit -m "feat: ajout du contrôleur Events"
git commit -m "fix: correction erreur 404 sur page événements"
git commit -m "refactor: amélioration du modèle User"
git commit -m "style: mise en forme page d'accueil"
git commit -m "docs: ajout guide de migration"
```

### Messages détaillés

```bash
git commit -m "feat: migration page événements

- Création EventsController
- Création vue events.php
- Intégration modèle Event
- Mise à jour des liens
- Tests fonctionnels OK"
```

---

## 📝 Standards de code

### PHP

#### Indentation
- 4 espaces (pas de tabs)

#### Nommage
```php
// Classes : PascalCase
class EventsController extends Controller {}
class Event {}

// Méthodes et variables : camelCase
public function getEvents() {}
$eventList = [];

// Constantes : UPPER_SNAKE_CASE
define('MAX_EVENTS', 100);
```

#### Structure d'un contrôleur
```php
<?php
/**
 * NomController - Description
 */

class NomController extends Controller
{
    public function index()
    {
        // Logique
        $data = [];
        $this->view('pages/nom', $data);
    }
}
```

#### Structure d'un modèle
```php
<?php
/**
 * Nom - Description
 */

class Nom
{
    private $db;
    
    public function __construct()
    {
        $this->db = new Database();
    }
    
    public function getAll()
    {
        // Requête SQL
    }
}
```

### HTML/PHP dans les vues

```php
<?php require_once VIEWS . '/layouts/header.php'; ?>

<!-- HTML propre et indenté -->
<div class="container">
    <?php if (isset($data)): ?>
        <h1><?= htmlspecialchars($data['title']) ?></h1>
    <?php endif; ?>
    
    <?php foreach ($items as $item): ?>
        <div><?= htmlspecialchars($item['name']) ?></div>
    <?php endforeach; ?>
</div>

<?php require_once VIEWS . '/layouts/footer.php'; ?>
```

### CSS

```css
/* Commentaires descriptifs */
.container {
    /* Propriétés ordonnées */
    display: flex;
    flex-direction: column;
    padding: 20px;
    margin: 0 auto;
}

/* Nommage en kebab-case */
.event-card {}
.news-list {}
```

### JavaScript

```javascript
// camelCase pour les variables et fonctions
const eventList = [];

function getEventDetails(id) {
    // Code...
}

// PascalCase pour les classes
class EventManager {
    constructor() {}
}
```

---

## 🧪 Tests

### Avant de commiter

- [ ] La page s'affiche correctement
- [ ] Tous les liens fonctionnent
- [ ] Les styles s'appliquent
- [ ] Les scripts JS fonctionnent
- [ ] Pas d'erreur dans la console
- [ ] Pas d'erreur PHP (vérifier les logs)

### Tests manuels

```
1. Navigation
   - Tous les liens du menu
   - Retour en arrière
   - Liens internes à la page

2. Fonctionnalités
   - Formulaires
   - Authentification
   - Panier
   - Upload de fichiers

3. Affichage
   - Desktop
   - Mobile (si responsive)
   - Différents navigateurs
```

---

## 📁 Structure des fichiers

### Où mettre quoi ?

```
app/
├── controllers/
│   └── NomController.php        # Nouveau contrôleur
│
├── models/
│   └── Nom.php                  # Nouveau modèle
│
└── views/
    ├── layouts/
    │   ├── header.php           # Header commun
    │   └── footer.php           # Footer commun
    │
    ├── pages/
    │   └── nom_page.php         # Nouvelle page
    │
    └── admin/
        └── nom_admin.php        # Page admin

public/
├── assets/                      # Images
├── styles/                      # CSS
└── scripts/                     # JavaScript
```

---

## 🚫 Ce qu'il ne faut PAS faire

### ❌ Git
- Commiter le fichier `.env`
- Commiter des fichiers temporaires (`.DS_Store`, `Thumbs.db`)
- Faire des commits géants (+ de 10 fichiers)
- Pousser sans avoir testé

### ❌ Code
- Laisser du code commenté
- Laisser des `console.log()` ou `var_dump()` de debug
- Mettre des mots de passe en dur
- Dupliquer du code (utiliser des fonctions)
- Ignorer les erreurs PHP

### ❌ Documentation
- Ne pas documenter les fonctions complexes
- Ne pas mettre à jour la documentation si changements

---

## ✅ Bonnes pratiques

### ✅ Git
- Faire des commits réguliers et petits
- Écrire des messages clairs
- Pull avant de commencer
- Tester avant de pousser

### ✅ Code
- Commenter le code complexe
- Utiliser des noms de variables explicites
- Respecter l'indentation
- Séparer logique métier / affichage (MVC)
- Valider les données utilisateur
- Échapper les sorties (XSS)
- Utiliser des requêtes préparées (SQL injection)

### ✅ Documentation
- Documenter les nouvelles fonctionnalités
- Mettre à jour la CHECKLIST.md
- Ajouter des commentaires explicatifs

---

## 📞 Communication

### Avant de commencer une grosse tâche
- Informer l'équipe (Discord/Slack)
- Vérifier que personne ne travaille dessus
- S'assigner la tâche dans CHECKLIST.md

### En cas de problème
- Chercher dans la documentation
- Demander à l'équipe
- Créer une issue sur GitHub

### Daily Standup
Chaque jour, partager :
1. Ce que j'ai fait hier
2. Ce que je fais aujourd'hui
3. Mes blocages éventuels

---

## 🔄 Processus de revue

### Si utilisation de branches

1. Créer une Pull Request
2. Décrire les changements
3. Attendre la revue d'un pair
4. Apporter les corrections si nécessaire
5. Merge après validation

### Points de vérification
- [ ] Code propre et commenté
- [ ] Tests passés
- [ ] Documentation à jour
- [ ] Pas de conflit
- [ ] Respect des conventions

---

## 🏷️ Labels et Issues

### Créer une issue

```markdown
Titre : Description courte

**Description**
Explication détaillée du problème ou de la fonctionnalité

**Étapes pour reproduire** (si bug)
1. Aller sur...
2. Cliquer sur...
3. Observer...

**Comportement attendu**
Ce qui devrait se passer

**Comportement actuel**
Ce qui se passe réellement

**Environnement**
- OS: macOS / Windows / Linux
- Navigateur: Chrome / Firefox / Safari
- Version PHP: 7.4 / 8.0
```

### Labels suggérés
- `bug` - Correction de bug
- `feature` - Nouvelle fonctionnalité
- `documentation` - Documentation
- `help wanted` - Aide demandée
- `good first issue` - Bon pour débutants
- `priority: high` - Priorité haute
- `priority: medium` - Priorité moyenne
- `priority: low` - Priorité basse

---

## 📊 Progression

### Mettre à jour la CHECKLIST.md

Cocher les tâches terminées :
```markdown
- [x] Tâche terminée
- [ ] Tâche en cours
```

### Informer l'équipe

Sur Discord/Slack :
```
✅ Page événements migrée !
- EventsController créé
- Vue events.php créée
- Liens mis à jour
- Tests OK

Prochaine tâche : Page détails événement
```

---

## 🎯 Checklist du contributeur

Avant chaque commit :

- [ ] Mon code respecte les conventions
- [ ] J'ai testé mes modifications
- [ ] J'ai commenté le code complexe
- [ ] J'ai mis à jour la documentation si nécessaire
- [ ] J'ai fait un `git pull` avant
- [ ] Mon message de commit est clair
- [ ] Pas de fichiers sensibles (.env, etc.)

---

## 📚 Ressources

### Documentation interne
- [GUIDE_VISUEL.md](GUIDE_VISUEL.md) - Exemples de code
- [MIGRATION_GUIDE.md](MIGRATION_GUIDE.md) - Comment migrer
- [README_MVC.md](README_MVC.md) - Architecture MVC

### Ressources externes
- [Git Cheat Sheet](https://education.github.com/git-cheat-sheet-education.pdf)
- [PHP PSR Standards](https://www.php-fig.org/psr/)
- [Conventional Commits](https://www.conventionalcommits.org/)

---

## 🎉 Merci !

Merci de contribuer au projet ADIIL ! Votre travail est apprécié. 💪

**Questions ?** Contactez l'équipe sur Discord/Slack ou créez une issue.

---

*Pour plus d'informations sur le projet, voir [README.md](README.md)*
