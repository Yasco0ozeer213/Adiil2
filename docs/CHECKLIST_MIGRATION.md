# 📋 CHECKLIST MIGRATION MVC - ADIIL

## ✅ **DÉJÀ MIGRÉS**

- [x] **index.php** → HomeController + app/views/pages/home.php
- [x] **header.php** → app/views/layouts/header.php
- [x] **footer.php** → app/views/layouts/footer.php
- [x] **assets/** → public/assets/
- [x] **styles/** → public/styles/
- [x] **scripts/** → public/scripts/

---

## 🎯 **À MIGRER - PAR PRIORITÉ**

### 🟢 **PRIORITÉ 1 : Pages principales (publiques)**

| Fichier | Controller | Vue | Complexité | Assigné à |
|---------|------------|-----|------------|-----------|
| ❌ **events.php** | EventsController | pages/events.php | ⭐⭐⭐ Moyenne | _________ |
| ❌ **news.php** | NewsController | pages/news.php | ⭐⭐ Facile | _________ |
| ❌ **shop.php** | ShopController | pages/shop.php | ⭐⭐ Facile | _________ |
| ❌ **about.php** | HomeController::about() | pages/about.php | ⭐ Très facile | _________ |
| ❌ **grade.php** | GradeController | pages/grade.php | ⭐⭐ Facile | _________ |

### 🟡 **PRIORITÉ 2 : Pages de détails**

| Fichier | Controller | Vue | Complexité | Assigné à |
|---------|------------|-----|------------|-----------|
| ❌ **event_details.php** | EventsController::details() | pages/event_details.php | ⭐⭐ Facile | _________ |
| ❌ **news_details.php** | NewsController::details() | pages/news_details.php | ⭐⭐ Facile | _________ |

### 🟠 **PRIORITÉ 3 : Pages utilisateur (connexion requise)**

| Fichier | Controller | Vue | Complexité | Assigné à |
|---------|------------|-----|------------|-----------|
| ❌ **login.php** | AuthController::login() | pages/login.php | ⭐⭐ Facile | _________ |
| ❌ **signin.php** | AuthController::register() | pages/signin.php | ⭐⭐⭐ Moyenne | _________ |
| ❌ **account.php** | AccountController | pages/account.php | ⭐⭐⭐ Moyenne | _________ |
| ❌ **agenda.php** | AgendaController | pages/agenda.php | ⭐⭐ Facile | _________ |
| ❌ **my_gallery.php** | GalleryController | pages/my_gallery.php | ⭐⭐⭐ Moyenne | _________ |

### 🔴 **PRIORITÉ 4 : Pages e-commerce**

| Fichier | Controller | Vue | Complexité | Assigné à |
|---------|------------|-----|------------|-----------|
| ❌ **cart.php** | CartController::index() | pages/cart.php | ⭐⭐⭐ Moyenne | _________ |
| ❌ **order.php** | CartController::order() | pages/order.php | ⭐⭐⭐ Moyenne | _________ |

### ⚫ **PRIORITÉ 5 : Actions utilisateur (pas de vue)**

| Fichier | Controller | Action | Complexité | Assigné à |
|---------|------------|--------|------------|-----------|
| ❌ **event_subscription.php** | EventsController::subscribe() | Redirect | ⭐⭐ Facile | _________ |
| ❌ **grade_subscription.php** | GradeController::subscribe() | Redirect | ⭐⭐ Facile | _________ |
| ❌ **cart_add.php** | CartController::add() | Redirect/JSON | ⭐⭐ Facile | _________ |
| ❌ **delete_account.php** | AccountController::delete() | Redirect | ⭐⭐ Facile | _________ |
| ❌ **add_media.php** | GalleryController::add() | Redirect | ⭐⭐⭐ Moyenne | _________ |
| ❌ **delete_media.php** | GalleryController::delete() | Redirect | ⭐⭐ Facile | _________ |
| ❌ **files_save.php** | FileController::save() | Redirect | ⭐⭐ Facile | _________ |

### ⚪ **À IGNORER / Analyser plus tard**

| Fichier | Raison | Action |
|---------|--------|--------|
| ❓ **info.php** | À vérifier (page de debug ?) | Voir si utile |
| ✅ **database.php** | Déjà remplacé par core/Database.php | À archiver |
| ✅ **cart_class.php** | Classe existante | Peut rester ou devenir Model |

---

## 🎯 **PLAN DE TRAVAIL RECOMMANDÉ**

### **SEMAINE 1 : Pages principales**
1. **events.php** (le plus complexe, mais exemple complet)
2. **news.php** (similaire à events)
3. **shop.php** (e-commerce)
4. **about.php** (très simple, boost de moral !)

### **SEMAINE 2 : Pages utilisateur**
5. **login.php** + **signin.php** (authentification)
6. **account.php** (profil utilisateur)
7. **event_details.php** + **news_details.php**

### **SEMAINE 3 : Actions et finitions**
8. **cart.php** + **order.php** + **cart_add.php**
9. **event_subscription.php** + **grade_subscription.php**
10. **my_gallery.php** + **add_media.php** + **delete_media.php**

---

## 📝 **PROCÉDURE POUR CHAQUE PAGE**

### **ÉTAPE 1 : Analyse (5 min)**
```bash
# Ouvre le fichier et identifie :
# 🔵 CONTROLLER : require, $db->select(), calculs, conditions
# 🟡 VIEW : HTML, <div>, echo pour affichage
```

### **ÉTAPE 2 : Créer la Vue (10 min)**
```bash
# Copie le HTML dans app/views/pages/[nom].php
# Remplace les require par les nouveaux chemins
# Garde les <?php echo ?> pour l'affichage
```

### **ÉTAPE 3 : Compléter le Controller (15 min)**
```php
// Dans app/controllers/[Nom]Controller.php
public function index() {
    // 1. Charger le Model si besoin
    $model = $this->model('Event');
    
    // 2. Récupérer les données
    $data = $model->getAll();
    
    // 3. Traiter les données
    foreach ($data as &$item) { ... }
    
    // 4. Préparer pour la vue
    $viewData = ['items' => $data];
    
    // 5. Afficher
    $this->view('pages/events', $viewData);
}
```

### **ÉTAPE 4 : Tester (5 min)**
```bash
# Accède à http://localhost:8888/[route]
# Vérifie que tout s'affiche correctement
```

### **ÉTAPE 5 : Commit Git (2 min)**
```bash
git add .
git commit -m "✅ Migration de [nom].php vers MVC"
git push
```

---

## 🎓 **RÉPARTITION DANS L'ÉQUIPE (4 personnes)**

### **Personne 1 : Pages principales**
- events.php
- news.php
- shop.php

### **Personne 2 : Authentification + Compte**
- login.php
- signin.php
- account.php
- delete_account.php

### **Personne 3 : E-commerce + Galerie**
- cart.php
- cart_add.php
- order.php
- my_gallery.php
- add_media.php
- delete_media.php

### **Personne 4 : Pages simples + Actions**
- about.php
- grade.php
- grade_subscription.php
- event_details.php
- news_details.php
- event_subscription.php
- agenda.php

---

## ✅ **CHECKLIST AVANT DE PUSH**

Avant de commit, vérifie :

- [ ] Le Controller charge les bonnes données ?
- [ ] La Vue affiche correctement ?
- [ ] Les liens sont en format MVC (`/events` pas `/events.php`) ?
- [ ] Les chemins assets sont corrects (`/assets/` pas `../assets/`) ?
- [ ] La page fonctionne sur http://localhost:8888/[route] ?
- [ ] Pas d'erreurs PHP dans les logs ?
- [ ] Le code est commenté et propre ?

---

## 📊 **PROGRESSION**

**Total : 25 fichiers**

- ✅ Migrés : **6** (24%)
- ❌ Restants : **19** (76%)

**Mise à jour régulière de ce fichier au fur et à mesure !**

---

## 🚀 **TU ES PRÊT !**

Choisis un fichier dans **PRIORITÉ 1**, fais la migration, et je te corrige ! 💪

**Commence par lequel ?** 
- `about.php` (le plus simple, 10 min)
- `events.php` (le plus complet, bon apprentissage)
- `news.php` (intermédiaire)

À toi de jouer ! 🎯
