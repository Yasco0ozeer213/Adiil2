# Guide de migration des fichiers

## Ce fichier explique comment déplacer les fichiers existants vers la nouvelle structure MVC

### IMPORTANT : Ne supprimez pas les anciens fichiers avant d'avoir terminé la migration !

## Étape 1 : Créer un dossier de sauvegarde
```bash
mkdir old_files
```

## Étape 2 : Déplacer les vues (layouts)

### Header et Footer
```bash
# Copier (ne pas déplacer encore)
cp header.php app/views/layouts/header.php
cp footer.php app/views/layouts/footer.php
```

**Modifications à faire dans app/views/layouts/header.php :**
- Remplacer les chemins des assets : `/assets/` → `<?php echo ASSETS_PATH; ?>/`
- Remplacer les chemins des styles : `/styles/` → `<?php echo PUBLIC_PATH; ?>/styles/`

## Étape 3 : Déplacer les assets

```bash
# Vérifier que les dossiers existent
mkdir -p public/assets
mkdir -p public/styles
mkdir -p public/scripts

# Copier les fichiers
cp -r assets/* public/assets/
cp -r styles/* public/styles/
cp -r scripts/* public/scripts/
```

## Étape 4 : Créer les vues des pages

Pour chaque fichier PHP principal, vous devez :
1. Extraire la partie HTML
2. La placer dans `app/views/pages/`
3. Créer/compléter le contrôleur correspondant

### Exemple avec index.php :

**Ancienne structure (index.php) :**
```php
<?php
require_once 'header.php';
require_once 'database.php';
$db = new DB();
// ... code PHP ...
?>
<!-- HTML de la page -->
<?php require_once 'footer.php'; ?>
```

**Nouvelle structure :**

1. **Contrôleur (app/controllers/HomeController.php)** - DÉJÀ CRÉÉ
2. **Vue (app/views/pages/home.php)** - À CRÉER :
```php
<?php require_once VIEWS . '/layouts/header.php'; ?>
<!-- Copier le HTML de index.php ici -->
<?php require_once VIEWS . '/layouts/footer.php'; ?>
```

## Étape 5 : Liste des fichiers à migrer

### Pages principales (créer les vues correspondantes) :

- [ ] `index.php` → `app/views/pages/home.php`
- [ ] `about.php` → `app/views/pages/about.php` (créer AboutController.php)
- [ ] `events.php` → `app/views/pages/events.php`
- [ ] `event_details.php` → `app/views/pages/event_details.php`
- [ ] `event_subscription.php` → `app/views/pages/event_subscription.php`
- [ ] `news.php` → `app/views/pages/news.php`
- [ ] `news_details.php` → `app/views/pages/news_details.php`
- [ ] `shop.php` → `app/views/pages/shop.php`
- [ ] `cart.php` → `app/views/pages/cart.php`
- [ ] `order.php` → `app/views/pages/order.php`
- [ ] `grade.php` → `app/views/pages/grade.php`
- [ ] `grade_subscription.php` → `app/views/pages/grade_subscription.php`
- [ ] `account.php` → `app/views/pages/account.php`
- [ ] `my_gallery.php` → `app/views/pages/my_gallery.php`
- [ ] `login.php` → `app/views/pages/login.php`
- [ ] `signin.php` → `app/views/pages/signin.php`
- [ ] `delete_account.php` → `app/views/pages/delete_account.php`
- [ ] `info.php` → `app/views/pages/info.php`
- [ ] `agenda.php` → `app/views/pages/agenda.php` (créer AgendaController.php)

### Fichiers de traitement (logique à intégrer dans les contrôleurs) :

- [ ] `cart_add.php` → Logique dans `ShopController::addToCart()`
- [ ] `add_media.php` → Logique dans `AccountController::addMedia()`
- [ ] `delete_media.php` → Logique dans `AccountController::deleteMedia()`
- [ ] `files_save.php` → Logique dans contrôleur approprié

### Fichiers de classe (déplacer vers models) :

- [ ] `cart_class.php` → `app/models/Cart.php`

### Administration :

- [ ] `admin/admin.php` → Contrôleur déjà créé
- [ ] `admin/panels/*.html` → `app/views/admin/panels/*.php`
- [ ] `admin/ressources/*` → `public/admin/ressources/*`
- [ ] `admin/scripts/*` → `public/admin/scripts/*`
- [ ] `admin/styles/*` → `public/admin/styles/*`

### API (garder pour l'instant) :
L'API peut rester dans son dossier actuel pour ne pas casser l'existant.
On pourra la migrer plus tard si nécessaire.

## Étape 6 : Après la migration complète

Une fois que tout fonctionne avec la nouvelle structure :

```bash
# Déplacer les anciens fichiers
mv *.php old_files/
mv assets old_files/
mv styles old_files/
mv scripts old_files/
mv admin old_files/ # sauf si vous voulez le garder temporairement
```

## Étape 7 : Mettre à jour les chemins

Dans tous les fichiers HTML/PHP migré, remplacer :
- `/assets/` → `/public/assets/`
- `/styles/` → `/public/styles/`
- `/scripts/` → `/public/scripts/`
- Les liens vers les pages : `/page.php` → `/controller/methode`

Exemples :
- `/events.php` → `/events`
- `/event_details.php?id=5` → `/events/details/5`
- `/shop.php` → `/shop`
- `/login.php` → `/auth/login`

## Configuration MAMP

**Très important :** Configurer MAMP pour pointer vers le dossier `public/`

1. Ouvrir MAMP
2. Préférences → Web Server
3. Document Root : `/Applications/MAMP/htdocs/sae4/Adiil2/public`
4. Redémarrer les serveurs

Ou créer un Virtual Host (recommandé) - voir README_MVC.md
