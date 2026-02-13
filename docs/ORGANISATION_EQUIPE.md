# 👥 Organisation de l'équipe - Migration MVC

## 🎯 Objectif

Migrer progressivement le projet ADIIL vers une architecture MVC sans casser le code existant.

## 📅 Plan de migration

### Phase 1 : Préparation (✅ TERMINÉ)
- ✅ Création de la structure MVC
- ✅ Configuration .env
- ✅ Fichiers core (Database, Controller, Router)
- ✅ Contrôleurs de base
- ✅ Modèles de base
- ✅ Documentation

### Phase 2 : Migration des layouts (À faire en priorité)
**Temps estimé : 1h**
**Responsable suggéré : Personne 1**

- [ ] Migrer `header.php` → `app/views/layouts/header.php`
  - Mettre à jour les chemins des assets
  - Tester l'affichage
  
- [ ] Migrer `footer.php` → `app/views/layouts/footer.php`
  - Mettre à jour les chemins des assets
  - Tester l'affichage

### Phase 3 : Migration des pages principales (À répartir)
**Temps estimé : 4-6h au total**

#### Groupe A - Pages publiques (Personne 1)
- [ ] Page d'accueil : `index.php` → `HomeController` + `home.php`
- [ ] À propos : `about.php` → `AboutController` + `about.php`
- [ ] Agenda : `agenda.php` → `AgendaController` + `agenda.php`
- [ ] Info : `info.php` → `InfoController` + `info.php`

#### Groupe B - Événements (Personne 2)
- [ ] Liste : `events.php` → `EventsController::index()` + `events.php`
- [ ] Détails : `event_details.php` → `EventsController::details()` + `event_details.php`
- [ ] Inscription : `event_subscription.php` → `EventsController::subscribe()` + `event_subscription.php`

#### Groupe C - Actualités (Personne 3)
- [ ] Liste : `news.php` → `NewsController::index()` + `news.php`
- [ ] Détails : `news_details.php` → `NewsController::details()` + `news_details.php`

#### Groupe D - Boutique & Compte (Personne 4)
- [ ] Boutique : `shop.php` → `ShopController::index()` + `shop.php`
- [ ] Panier : `cart.php` → `ShopController::cart()` + `cart.php`
- [ ] Commande : `order.php` → `ShopController::order()` + `order.php`
- [ ] Compte : `account.php` → `AccountController::index()` + `account.php`
- [ ] Galerie : `my_gallery.php` → `AccountController::gallery()` + `my_gallery.php`

### Phase 4 : Authentification (Personne 1 ou 2)
- [ ] Login : `login.php` → `AuthController::login()` + `login.php`
- [ ] Inscription : `signin.php` → `AuthController::signin()` + `signin.php`
- [ ] Déconnexion : logique dans `AuthController::logout()`
- [ ] Suppression compte : `delete_account.php` → `AccountController::delete()`

### Phase 5 : Grades (Personne 3)
- [ ] Liste : `grade.php` → `GradeController::index()` + `grade.php`
- [ ] Inscription : `grade_subscription.php` → `GradeController::subscribe()` + `grade_subscription.php`

### Phase 6 : Administration (Personne 4 ou Personne 1)
- [ ] Dashboard : `admin/admin.php` → `AdminController::index()` + `admin/dashboard.php`
- [ ] Migrer les panels HTML vers PHP
- [ ] Déplacer les ressources admin vers `public/admin/`

### Phase 7 : Finalisation (Tous ensemble)
- [ ] Tester toutes les pages
- [ ] Vérifier les liens entre pages
- [ ] Corriger les bugs
- [ ] Nettoyer les anciens fichiers
- [ ] Déploiement

## 🔧 Processus de travail

### 1. Avant de commencer une tâche

```bash
# 1. Récupérer les dernières modifications
git pull origin main

# 2. Créer une branche pour votre tâche (optionnel mais recommandé)
git checkout -b migration/page-events
```

### 2. Pendant le développement

- Tester régulièrement localement
- Faire des commits fréquents et petits
- Commenter le code si nécessaire
- Respecter la structure MVC

### 3. Après avoir terminé une tâche

```bash
# 1. Vérifier ce qui a changé
git status
git diff

# 2. Ajouter les fichiers
git add app/views/pages/events.php
git add app/controllers/EventsController.php

# 3. Commiter avec un message clair
git commit -m "feat: migration page événements vers MVC"

# 4. Pousser vers le dépôt
git push origin main
# Ou si vous avez créé une branche :
git push origin migration/page-events
```

### 4. En cas de conflit

```bash
# 1. Récupérer les dernières modifications
git pull origin main

# 2. Résoudre les conflits dans VS Code
# (les zones en conflit seront marquées)

# 3. Après résolution, ajouter et commiter
git add .
git commit -m "fix: résolution conflits merge"
git push origin main
```

## 📝 Checklist pour chaque page migrée

### Avant de commiter, vérifier :

- [ ] Le contrôleur est créé et hérite de `Controller`
- [ ] La vue est créée dans `app/views/pages/`
- [ ] Les chemins des assets sont corrects (`/public/assets/`, `/public/styles/`, etc.)
- [ ] Les liens vers d'autres pages utilisent le nouveau format (`/controller/methode`)
- [ ] Le header et footer sont inclus avec `require_once VIEWS . '/layouts/...'`
- [ ] La page s'affiche correctement dans le navigateur
- [ ] Les fonctionnalités (formulaires, liens, etc.) fonctionnent
- [ ] Le code est propre et commenté si nécessaire

## 📞 Communication

### Daily Standup (5-10 min par jour)
Chacun répond à :
1. Qu'est-ce que j'ai fait hier ?
2. Qu'est-ce que je fais aujourd'hui ?
3. Est-ce que j'ai des blocages ?

### Slack/Discord
- Canal #dev-migration : Questions et problèmes
- Canal #general : Communication générale
- Utiliser @all pour les messages importants

### Réunion hebdomadaire (30 min)
- Point sur l'avancement
- Résolution des problèmes
- Planification de la semaine suivante

## 🎯 Priorités

1. **URGENT** : Layouts (header/footer) - Sans ça rien ne fonctionne
2. **HAUTE** : Pages principales (index, events, news, shop)
3. **MOYENNE** : Authentification, compte utilisateur
4. **BASSE** : Administration, pages secondaires

## 🏆 Bonnes pratiques

### Code
- ✅ Commenter le code complexe
- ✅ Respecter l'indentation (4 espaces ou 1 tab)
- ✅ Nommer les variables clairement
- ✅ Éviter la duplication de code
- ✅ Tester avant de commiter

### Git
- ✅ Messages de commit clairs et en français
- ✅ Commits fréquents et petits
- ✅ Ne jamais commiter de fichiers sensibles (.env, mots de passe)
- ✅ Toujours pull avant de commencer à travailler
- ✅ Résoudre les conflits rapidement

### Équipe
- ✅ Communiquer régulièrement
- ✅ Demander de l'aide en cas de blocage
- ✅ Partager ses découvertes
- ✅ Être patient et bienveillant
- ✅ Respecter le travail des autres

## 📊 Suivi de l'avancement

Créer un tableau (Trello, Notion, ou simple Google Sheet) avec :
- Nom de la tâche
- Responsable
- Statut (À faire, En cours, Terminé)
- Date de début
- Date de fin
- Commentaires

## 🆘 En cas de problème

### Problème technique
1. Vérifier la documentation (README_MVC.md, MIGRATION_GUIDE.md)
2. Chercher sur Google/Stack Overflow
3. Demander à l'équipe sur Discord/Slack
4. En dernier recours, créer une issue sur GitHub

### Conflit d'équipe
1. Communiquer calmement
2. Expliquer son point de vue
3. Écouter l'autre
4. Trouver un compromis
5. Si nécessaire, vote d'équipe

### Retard sur le planning
1. Identifier la cause du retard
2. Communiquer avec l'équipe
3. Réajuster les priorités
4. Demander de l'aide si nécessaire
5. Replanifier

---

**Bon travail d'équipe ! 💪**
