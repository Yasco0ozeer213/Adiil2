# 🎓 ADIIL - Association du Département Informatique IUT Laval

[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)
[![PHP](https://img.shields.io/badge/PHP-7.4%2B-purple.svg)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-5.7%2B-orange.svg)](https://www.mysql.com/)

Site web de l'association ADIIL restructuré en architecture MVC.

---

## 🚨 IMPORTANT - Le projet a été restructuré en MVC !

### 🎯 NOUVEAU DANS LE PROJET ?

#### ⚡ Démarrage ultra-rapide (5 min)
👉 **[QUICK_START.md](QUICK_START.md)** 🚀

#### � Démarrage complet (20 min)
�👉 **[COMMENCER_ICI.md](COMMENCER_ICI.md)** ⭐

#### 📚 Vous cherchez quelque chose de spécifique ?
👉 **[INDEX_DOCUMENTATION.md](INDEX_DOCUMENTATION.md)** 🔍

---

## 📋 Documentation principale

| Fichier | Description | Priorité |
|---------|-------------|----------|
| **[QUICK_START.md](QUICK_START.md)** | Démarrage en 5 minutes | ⭐⭐⭐ |
| **[COMMENCER_ICI.md](COMMENCER_ICI.md)** | Guide complet de démarrage | ⭐⭐⭐ |
| **[RECAP_FINAL.md](RECAP_FINAL.md)** | Récapitulatif de tout ce qui a été fait | ⭐⭐⭐ |
| **[DEMARRAGE_RAPIDE.md](DEMARRAGE_RAPIDE.md)** | Configuration détaillée | ⭐⭐⭐ |
| **[MIGRATION_GUIDE.md](MIGRATION_GUIDE.md)** | Guide de migration des fichiers | ⭐⭐⭐ |
| **[GUIDE_VISUEL.md](GUIDE_VISUEL.md)** | Exemples visuels et diagrammes | ⭐⭐⭐ |
| **[ORGANISATION_EQUIPE.md](ORGANISATION_EQUIPE.md)** | Organisation du travail d'équipe | ⭐⭐⭐ |
| **[CHECKLIST.md](CHECKLIST.md)** | Liste complète des tâches | ⭐⭐ |
| **[README_MVC.md](README_MVC.md)** | Documentation technique MVC | ⭐⭐ |
| **[INDEX_STRUCTURE.md](INDEX_STRUCTURE.md)** | Structure détaillée du projet | ⭐ |
| **[INDEX_DOCUMENTATION.md](INDEX_DOCUMENTATION.md)** | Index de toute la documentation | ⭐ |

---

## 📁 Nouvelle structure du projet

```
Adiil2/
├── app/              # Application (MVC)
│   ├── controllers/  # Contrôleurs
│   ├── models/       # Modèles
│   └── views/        # Vues
├── config/           # Configuration
├── core/             # Noyau MVC
├── public/           # Point d'entrée public
│   ├── index.php     # ⭐ Point d'entrée principal
│   ├── assets/       # Images, fonts
│   ├── styles/       # CSS
│   └── scripts/      # JavaScript
└── api/              # API (existant)
```

---

## 🚀 Installation rapide

### 1. Cloner le repository

```bash
git clone https://github.com/Yasco0ozeer213/Adiil2.git
cd Adiil2
```

### 2. Configuration

```bash
# Copier le fichier de configuration
cp .env.example .env

# Éditer avec vos paramètres
nano .env  # ou vim, ou votre éditeur préféré
```

### 3. Base de données

```bash
# Créer la base de données
mysql -u root -p -e "CREATE DATABASE IF NOT EXISTS sae"

# Importer le schéma
mysql -u etu -p sae < script.sql
```

### 4. Configuration MAMP/serveur web

**Pour MAMP :**
- Document Root : `/chemin/vers/Adiil2/public`
- Voir [DEMARRAGE_RAPIDE.md](DEMARRAGE_RAPIDE.md) pour plus de détails

**Pour Apache :**
```apache
<VirtualHost *:80>
    ServerName adiil.local
    DocumentRoot "/chemin/vers/Adiil2/public"
    <Directory "/chemin/vers/Adiil2/public">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

### 5. Test

Accéder à : `http://localhost` ou `http://adiil.local`

Pour tester la structure : `http://localhost/test.php`

---

## 🛠️ Outils de développement

### Script d'aide à la migration

```bash
./migrate.sh
```

Ce script interactif aide à :
- Copier les assets vers `public/`
- Migrer header et footer
- Vérifier la configuration
- Tester la connexion BDD

---

## 👥 Travail en équipe

### Avant de commencer

```bash
git pull origin main
```

### Workflow

```bash
# 1. Créer une branche (optionnel)
git checkout -b migration/ma-page

# 2. Faire vos modifications

# 3. Commiter
git add .
git commit -m "feat: migration page événements"

# 4. Pousser
git push origin main
```

### Convention de commits

- `feat:` Nouvelle fonctionnalité
- `fix:` Correction de bug
- `refactor:` Refactorisation
- `style:` Modifications CSS
- `docs:` Documentation

---

## 📚 Documentation complète

| Fichier | Description |
|---------|-------------|
| [RESUME.md](RESUME.md) | Vue d'ensemble et résumé |
| [DEMARRAGE_RAPIDE.md](DEMARRAGE_RAPIDE.md) | Guide de démarrage rapide |
| [MIGRATION_GUIDE.md](MIGRATION_GUIDE.md) | Guide de migration détaillé |
| [ORGANISATION_EQUIPE.md](ORGANISATION_EQUIPE.md) | Organisation du travail |
| [README_MVC.md](README_MVC.md) | Documentation MVC complète |
| [INDEX_STRUCTURE.md](INDEX_STRUCTURE.md) | Structure du projet |

---

## 🔧 Anciennes commandes (pour référence)

### Setup initial (Linux)

```bash
sudo chown -R "$USER" /var/www/html
cd /var/www/html
rm index.html
git clone https://github.com/SAE-S3-grp1/site.git .
```

### Import DB

```bash
# Avec prompt
mysql -u etu -p -D sae < ./script.sql

# Direct
mysql -u etu -pMonMotDePasse sae < ./script.sql

Si le mot de passe de l'utilisateur "etu" est incorrect, vous pouvez le modifier avec :
```bash
sudo mysql -u root
```
```sql
ALTER USER 'etu'@'%' IDENTIFIED BY 'motdepasse';
ALTER USER 'etu'@'localhost' IDENTIFIED BY 'motdepasse';

FLUSH PRIVILEGES;

exit;
```

## Configuration

Afin de lier la DB au code source, il faut éditer les fichiers :
- `api/DB.php`
- `database.php`

Et modifier les champs comme ci-dessous.
```php
class DB
{
    private $host = 'localhost';
    private $port = '3306';
    private $db = 'sae'; // <- ici
    private $db_user = 'etu'; // <- ici
    private $db_pass = '[VOTRE_MDP]'; // <- ici
```

## Droits finaux
```bash
sudo chown -R www-data /var/www/html
sudo chgrp -R www-data /var/www/html
```

# infos db

## Problèmes connus 
- Erreur lors de la modification d'un article/event dans le panel admin; probablement un problème avec la DB.
- Le script de remplissage des données fait pointer des liens vers des fichiers qui ne sont pas présent dans le répo (documents, images) -> erreurs d'affichage


## Logins des utilisateurs par défaut 

| email | mot_de_passe |
|---|---|
| gemino.ruffault@example.com | password1 |
| axelle.hannier@example.com | password1 |
| julien.dauvergne@example.com | password1 |
| baptiste.delahay@example.com | password1 |
| nathalie.vieillard@example.com | password1 |
| barnabe.havard@example.com | password1 |
| theo.fevrier@example.com | password1 |
| tom.gouin@example.com | password1 |
| evann.congnard@example.com | password1 |
| erwan.lecoz@example.com | password1 |

## Roles

## Attribution 

| id_membre | nom | prenom | role |
|----------:|--------------------|---------|-------------------|
| 1 | RUFFAULT--RAVENEL | Gemino   | Administrateur |
| 2 | HANNIER            | Axelle   | Membre |
| 3 | DAUVERGNE          | Julien   | Bureau |
| 4 | DELAYE             | Baptiste | Modérateur |
| 5 | VIEILLARD          | Nathalie | Responsable com |
| 6 | HAVARD             | Barnabe  | Bureau |
| 7 | FEVRIER            | Theo     | Membre |
| 8 | GOUIN              | Tom      | Membre |
| 9 | CONGNARD           | Evann    | Modérateur |
|10 | LE COZ             | Erwan    | Membre |

## Permissions

| nom_role        | p_log | p_boutique | p_reunion | p_utilisateur | p_grade | p_roles | p_actualite | p_evenements | p_comptabilite | p_achats | p_moderation |
|-----------------|-------|------------|-----------|---------------|---------|---------|-------------|--------------|----------------|----------|--------------|
| Administrateur  | 1     | 1          | 1         | 1             | 1       | 1       | 1           | 1            | 1              | 1        | 1            |
| Bureau          | 1     | 1          | 1         | 0             | 0       | 0       | 1           | 1            | 1              | 1        | 0            |
| Responsable com | 0     | 0          | 0         | 0             | 0       | 0       | 0           | 0            | 1              | 1        | 0            |
| Modérateur      | 0     | 0          | 0         | 1             | 0       | 0       | 1           | 0            | 0              | 0        | 1            |
| Membre          | 0     | 0          | 0         | 0             | 0       | 0       | 0           | 0            | 0              | 0        | 0            |
