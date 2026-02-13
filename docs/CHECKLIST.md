# ✅ Checklist de Migration - ADIIL MVC

## 📋 Phase 1 : Configuration initiale

### Configuration de base
- [ ] Copier `.env.example` vers `.env`
- [ ] Configurer les paramètres de base de données dans `.env`
- [ ] Configurer MAMP pour pointer vers `public/`
- [ ] Tester l'accès : `http://localhost` ou `http://adiil.local`
- [ ] Exécuter `public/test.php` pour vérifier la configuration

### Lecture de la documentation
- [ ] Lire `RESUME.md`
- [ ] Lire `DEMARRAGE_RAPIDE.md`
- [ ] Lire `MIGRATION_GUIDE.md`
- [ ] Lire `ORGANISATION_EQUIPE.md`

---

## 📋 Phase 2 : Migration des Layouts (PRIORITÉ HAUTE)

### Header et Footer
- [ ] Copier `header.php` → `app/views/layouts/header.php`
- [ ] Mettre à jour les chemins dans header.php :
  - [ ] `/assets/` → `/public/assets/`
  - [ ] `/styles/` → `/public/styles/`
  - [ ] Liens vers pages : format MVC
- [ ] Copier `footer.php` → `app/views/layouts/footer.php`
- [ ] Mettre à jour les chemins dans footer.php
- [ ] Tester l'affichage du header
- [ ] Tester l'affichage du footer

---

## 📋 Phase 3 : Migration des Assets

### Images et ressources
- [ ] Copier `assets/*` → `public/assets/`
- [ ] Vérifier que toutes les images sont présentes
- [ ] Tester l'affichage des images

### Styles CSS
- [ ] Copier `styles/*` → `public/styles/`
- [ ] Vérifier que tous les CSS sont présents
- [ ] Tester le chargement des styles

### Scripts JavaScript
- [ ] Copier `scripts/*` → `public/scripts/`
- [ ] Vérifier que tous les JS sont présents
- [ ] Tester le fonctionnement des scripts

---

## 📋 Phase 4 : Migration des Pages Principales

### Page d'accueil
- [ ] Créer `app/views/pages/home.php`
- [ ] Copier le HTML de `index.php` vers `home.php`
- [ ] Mettre à jour les chemins
- [ ] Compléter `HomeController::index()`
- [ ] Tester : `http://localhost/`

### Page À propos
- [ ] Créer `AboutController.php`
- [ ] Créer `app/views/pages/about.php`
- [ ] Migrer le contenu de `about.php`
- [ ] Tester : `http://localhost/about`

### Page Info
- [ ] Créer `InfoController.php`
- [ ] Créer `app/views/pages/info.php`
- [ ] Migrer le contenu de `info.php`
- [ ] Tester : `http://localhost/info`

### Page Agenda
- [ ] Créer `AgendaController.php`
- [ ] Créer `app/views/pages/agenda.php`
- [ ] Migrer le contenu de `agenda.php`
- [ ] Tester : `http://localhost/agenda`

---

## 📋 Phase 5 : Migration des Événements

### Liste des événements
- [ ] Créer `app/views/pages/events.php`
- [ ] Migrer le contenu de `events.php`
- [ ] Compléter `EventsController::index()`
- [ ] Intégrer le modèle `Event`
- [ ] Tester : `http://localhost/events`

### Détails d'un événement
- [ ] Créer `app/views/pages/event_details.php`
- [ ] Migrer le contenu de `event_details.php`
- [ ] Compléter `EventsController::details($id)`
- [ ] Mettre à jour les liens vers cette page
- [ ] Tester : `http://localhost/events/details/1`

### Inscription à un événement
- [ ] Créer `app/views/pages/event_subscription.php`
- [ ] Migrer le contenu de `event_subscription.php`
- [ ] Compléter `EventsController::subscribe($id)`
- [ ] Implémenter la logique d'inscription
- [ ] Tester : `http://localhost/events/subscribe/1`

---

## 📋 Phase 6 : Migration des Actualités

### Liste des actualités
- [ ] Créer `app/views/pages/news.php`
- [ ] Migrer le contenu de `news.php`
- [ ] Compléter `NewsController::index()`
- [ ] Intégrer le modèle `News`
- [ ] Tester : `http://localhost/news`

### Détails d'une actualité
- [ ] Créer `app/views/pages/news_details.php`
- [ ] Migrer le contenu de `news_details.php`
- [ ] Compléter `NewsController::details($id)`
- [ ] Mettre à jour les liens
- [ ] Tester : `http://localhost/news/details/1`

---

## 📋 Phase 7 : Migration de la Boutique

### Page boutique
- [ ] Créer `app/views/pages/shop.php`
- [ ] Migrer le contenu de `shop.php`
- [ ] Compléter `ShopController::index()`
- [ ] Intégrer le modèle `Product`
- [ ] Tester : `http://localhost/shop`

### Panier
- [ ] Migrer `cart_class.php` → `app/models/Cart.php`
- [ ] Créer `app/views/pages/cart.php`
- [ ] Migrer le contenu de `cart.php`
- [ ] Compléter `ShopController::cart()`
- [ ] Implémenter la logique d'ajout au panier
- [ ] Tester : `http://localhost/shop/cart`

### Commande
- [ ] Créer `app/views/pages/order.php`
- [ ] Migrer le contenu de `order.php`
- [ ] Compléter `ShopController::order()`
- [ ] Implémenter la logique de commande
- [ ] Tester : `http://localhost/shop/order`

---

## 📋 Phase 8 : Migration des Grades

### Liste des grades
- [ ] Créer `app/views/pages/grade.php`
- [ ] Migrer le contenu de `grade.php`
- [ ] Compléter `GradeController::index()`
- [ ] Intégrer le modèle `Grade`
- [ ] Tester : `http://localhost/grade`

### Inscription à un grade
- [ ] Créer `app/views/pages/grade_subscription.php`
- [ ] Migrer le contenu de `grade_subscription.php`
- [ ] Compléter `GradeController::subscribe($id)`
- [ ] Implémenter la logique d'inscription
- [ ] Tester : `http://localhost/grade/subscribe/1`

---

## 📋 Phase 9 : Migration de l'Authentification

### Page de connexion
- [ ] Créer `app/views/pages/login.php`
- [ ] Migrer le contenu de `login.php`
- [ ] Compléter `AuthController::login()`
- [ ] Implémenter la logique de connexion
- [ ] Tester : `http://localhost/auth/login`

### Page d'inscription
- [ ] Créer `app/views/pages/signin.php`
- [ ] Migrer le contenu de `signin.php`
- [ ] Compléter `AuthController::signin()`
- [ ] Implémenter la logique d'inscription
- [ ] Tester : `http://localhost/auth/signin`

### Déconnexion
- [ ] Compléter `AuthController::logout()`
- [ ] Tester la déconnexion
- [ ] Vérifier la destruction de session

---

## 📋 Phase 10 : Migration du Compte Utilisateur

### Page compte
- [ ] Créer `app/views/pages/account.php`
- [ ] Migrer le contenu de `account.php`
- [ ] Compléter `AccountController::index()`
- [ ] Intégrer le modèle `User`
- [ ] Tester : `http://localhost/account`

### Galerie
- [ ] Créer `app/views/pages/my_gallery.php`
- [ ] Migrer le contenu de `my_gallery.php`
- [ ] Compléter `AccountController::gallery()`
- [ ] Implémenter la gestion des médias
- [ ] Tester : `http://localhost/account/gallery`

### Ajout de média
- [ ] Intégrer la logique de `add_media.php` dans `AccountController::addMedia()`
- [ ] Créer la vue si nécessaire
- [ ] Tester l'upload de média

### Suppression de média
- [ ] Intégrer la logique de `delete_media.php` dans `AccountController::deleteMedia()`
- [ ] Tester la suppression de média

### Suppression de compte
- [ ] Créer `app/views/pages/delete_account.php`
- [ ] Migrer le contenu de `delete_account.php`
- [ ] Compléter `AccountController::delete()`
- [ ] Implémenter la logique de suppression
- [ ] Tester : `http://localhost/account/delete`

---

## 📋 Phase 11 : Migration de l'Administration

### Dashboard admin
- [ ] Créer `app/views/admin/dashboard.php`
- [ ] Migrer le contenu de `admin/admin.php`
- [ ] Compléter `AdminController::index()`
- [ ] Vérifier les permissions admin
- [ ] Tester : `http://localhost/admin`

### Panels admin
- [ ] Migrer `admin/panels/*.html` → `app/views/admin/panels/*.php`
- [ ] Convertir HTML en PHP si nécessaire
- [ ] Créer les contrôleurs admin nécessaires
- [ ] Tester chaque panel

### Ressources admin
- [ ] Copier `admin/ressources/*` → `public/admin/ressources/`
- [ ] Mettre à jour les chemins
- [ ] Vérifier l'affichage

### Scripts admin
- [ ] Copier `admin/scripts/*` → `public/admin/scripts/`
- [ ] Mettre à jour les chemins
- [ ] Tester les fonctionnalités

### Styles admin
- [ ] Copier `admin/styles/*` → `public/admin/styles/`
- [ ] Mettre à jour les chemins
- [ ] Vérifier le rendu

---

## 📋 Phase 12 : Tests et Validation

### Tests de navigation
- [ ] Tester tous les liens du menu
- [ ] Vérifier les redirections
- [ ] Tester les pages nécessitant une authentification
- [ ] Tester les pages admin

### Tests de fonctionnalités
- [ ] Connexion / Déconnexion
- [ ] Inscription
- [ ] Ajout au panier
- [ ] Commande
- [ ] Inscription événement
- [ ] Inscription grade
- [ ] Upload de média
- [ ] Suppression de média
- [ ] Suppression de compte

### Tests de sécurité
- [ ] Vérifier les protections CSRF si nécessaire
- [ ] Tester l'accès aux pages admin sans être admin
- [ ] Tester l'accès aux pages authentifiées sans être connecté
- [ ] Vérifier les échappements SQL (prepared statements)

### Tests d'affichage
- [ ] Vérifier tous les assets s'affichent
- [ ] Vérifier tous les styles s'appliquent
- [ ] Vérifier tous les scripts fonctionnent
- [ ] Tester sur différents navigateurs

---

## 📋 Phase 13 : Nettoyage

### Archivage des anciens fichiers
- [ ] Créer le dossier `old_files/`
- [ ] Déplacer tous les anciens `.php` de la racine
- [ ] Déplacer les anciens dossiers `assets/`, `styles/`, `scripts/`
- [ ] Conserver `admin/` temporairement si nécessaire

### Vérification finale
- [ ] Supprimer `public/test.php`
- [ ] Vérifier qu'aucun fichier sensible n'est commité
- [ ] Vérifier le `.gitignore`
- [ ] Nettoyer les commentaires de debug

---

## 📋 Phase 14 : Documentation

### Documentation du code
- [ ] Commenter les contrôleurs complexes
- [ ] Commenter les modèles complexes
- [ ] Documenter les fonctions importantes

### README final
- [ ] Mettre à jour le README.md principal
- [ ] Ajouter des screenshots si nécessaire
- [ ] Documenter les dépendances

---

## 📋 Phase 15 : Git et Déploiement

### Commits finaux
- [ ] Faire un commit de la structure finale
- [ ] Créer un tag de version (v2.0-mvc par exemple)
- [ ] Pousser sur le repository

### Préparation au déploiement
- [ ] Vérifier la configuration de production dans `.env.example`
- [ ] Documenter les étapes de déploiement
- [ ] Créer un guide de mise en production

---

## 🎉 Migration terminée !

- [ ] Célébrer avec l'équipe ! 🎊
- [ ] Faire une démo
- [ ] Recueillir les feedbacks
- [ ] Planifier les améliorations futures

---

## 📊 Statistiques de progression

**Phase 1 - Configuration :** ⬜⬜⬜⬜⬜ 0/5  
**Phase 2 - Layouts :** ⬜⬜⬜⬜⬜⬜⬜ 0/7  
**Phase 3 - Assets :** ⬜⬜⬜⬜⬜⬜ 0/6  
**Phase 4 - Pages principales :** ⬜⬜⬜⬜⬜⬜⬜⬜⬜ 0/9  
**Phase 5 - Événements :** ⬜⬜⬜⬜⬜⬜⬜⬜ 0/8  
**Phase 6 - Actualités :** ⬜⬜⬜⬜⬜⬜ 0/6  
**Phase 7 - Boutique :** ⬜⬜⬜⬜⬜⬜⬜⬜⬜ 0/9  
**Phase 8 - Grades :** ⬜⬜⬜⬜⬜⬜ 0/6  
**Phase 9 - Auth :** ⬜⬜⬜⬜⬜⬜ 0/6  
**Phase 10 - Compte :** ⬜⬜⬜⬜⬜⬜⬜⬜⬜ 0/9  
**Phase 11 - Admin :** ⬜⬜⬜⬜⬜⬜⬜⬜ 0/8  
**Phase 12 - Tests :** ⬜⬜⬜⬜⬜⬜⬜⬜⬜⬜ 0/10  
**Phase 13 - Nettoyage :** ⬜⬜⬜⬜ 0/4  
**Phase 14 - Documentation :** ⬜⬜⬜ 0/3  
**Phase 15 - Déploiement :** ⬜⬜⬜ 0/3  

**TOTAL :** 0/100 tâches complétées

---

*Mettez à jour cette checklist au fur et à mesure de votre avancement !*  
*Partagez vos progrès avec l'équipe régulièrement.*

**Bon courage ! 💪**
