# 🚀 Démarrage rapide - Structure MVC

## ✅ Ce qui a été fait

J'ai restructuré votre projet en architecture MVC sans modifier votre code existant. Voici ce qui a été créé :

### Structure créée :
```
✅ app/
   ✅ controllers/    (8 contrôleurs créés)
   ✅ models/         (5 modèles créés)
   ✅ views/
      ✅ layouts/     (pour header/footer)
      ✅ pages/       (pour les pages)
      ✅ admin/       (pour l'admin)

✅ config/
   ✅ config.php      (chargement .env)

✅ core/
   ✅ Database.php    (gestion BDD)
   ✅ Controller.php  (classe de base)
   ✅ Router.php      (routage)

✅ public/
   ✅ index.php       (point d'entrée)
   ✅ .htaccess       (redirection)
   ✅ assets/         (images)
   ✅ styles/         (CSS)
   ✅ scripts/        (JS)
   ✅ uploads/        (fichiers uploadés)

✅ .env & .env.example
✅ .gitignore (mis à jour)
```

## 📋 Prochaines étapes

### 1. Configuration (5 minutes)

**a) Copier le fichier .env.example vers .env**
```bash
cp .env.example .env
```

**b) Éditer .env avec vos paramètres** :
```bash
open .env
```
Modifier les valeurs de DB_NAME, DB_USER, DB_PASSWORD selon votre configuration.

### 2. Configuration MAMP (2 minutes)

**Option A - Virtual Host (recommandé)**
1. Éditer `/Applications/MAMP/conf/apache/httpd.conf`
2. Décommenter : `# Include /Applications/MAMP/conf/apache/extra/httpd-vhosts.conf`
3. Éditer `/Applications/MAMP/conf/apache/extra/httpd-vhosts.conf`
4. Ajouter :
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
5. Éditer `/etc/hosts` :
```bash
sudo nano /etc/hosts
```
Ajouter : `127.0.0.1 adiil.local`

6. Redémarrer MAMP

**Option B - Document Root simple**
1. MAMP → Préférences → Web Server
2. Document Root : `/Applications/MAMP/htdocs/sae4/Adiil2/public`
3. Redémarrer

### 3. Test de la structure (1 minute)

Accéder à :
- http://adiil.local/ (ou http://localhost/)

Si vous voyez une page blanche ou erreur, c'est normal ! Il faut maintenant migrer vos vues.

### 4. Migration des fichiers (progressif)

**Commencer par la page d'accueil :**

1. **Copier le HTML de index.php** vers une nouvelle vue :

```bash
# Créer la vue home
touch app/views/pages/home.php
```

2. **Ouvrir index.php** et copier tout le HTML (de `<!DOCTYPE html>` à `</html>`)

3. **Dans app/views/pages/home.php**, coller :
```php
<?php require_once VIEWS . '/layouts/header.php'; ?>

<!-- Coller le contenu HTML de index.php ici (sans le require header/footer) -->

<?php require_once VIEWS . '/layouts/footer.php'; ?>
```

4. **Tester** : http://adiil.local/

### 5. Continuer avec les autres pages

Suivre le même processus pour chaque page (voir MIGRATION_GUIDE.md pour la liste complète).

## 🤝 Travail en équipe

### Avant de commencer à coder :
```bash
git pull origin main
```

### Après vos modifications :
```bash
git status                           # Voir ce qui a changé
git add .                            # Ajouter tous les fichiers
git commit -m "feat: migration page accueil vers MVC"
git push origin main
```

### Convention de commits :
- `feat:` Nouvelle fonctionnalité
- `fix:` Correction de bug
- `refactor:` Refactorisation
- `style:` Modifications CSS
- `docs:` Documentation

## ⚠️ Important

1. **NE PAS commiter le fichier .env** (déjà dans .gitignore)
2. **Tester localement** avant de pousser
3. **Communiquer** avec l'équipe sur Slack/Discord
4. **Garder les anciens fichiers** tant que la migration n'est pas terminée
5. **Faire des commits réguliers** (petits et fréquents)

## 📚 Documentation

- **README_MVC.md** : Documentation complète de la structure
- **MIGRATION_GUIDE.md** : Guide détaillé de migration
- **Ce fichier** : Démarrage rapide

## 🆘 Besoin d'aide ?

### Erreur "Class not found"
→ Vérifier que tous les fichiers du dossier `core/` existent

### Erreur de connexion BDD
→ Vérifier les paramètres dans `.env`

### Page blanche
→ Activer le mode debug dans `.env` : `APP_DEBUG=true`
→ Vérifier les logs Apache : `/Applications/MAMP/logs/apache_error.log`

### Les assets ne chargent pas
→ Vérifier que MAMP pointe bien vers le dossier `public/`
→ Vérifier les chemins dans les vues

## 📞 Contact

En cas de problème, contacter l'équipe ou créer une issue sur GitHub.

---

**Bonne migration ! 🎉**
