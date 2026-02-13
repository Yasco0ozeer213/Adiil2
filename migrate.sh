#!/bin/bash

# Script d'aide à la migration MVC
# Ce script aide à copier les fichiers existants vers la nouvelle structure

echo "🚀 Script d'aide à la migration MVC - ADIIL"
echo "=============================================="
echo ""

# Fonction pour afficher un menu
show_menu() {
    echo "Que voulez-vous faire ?"
    echo ""
    echo "1. Copier les assets vers public/"
    echo "2. Copier header.php vers app/views/layouts/"
    echo "3. Copier footer.php vers app/views/layouts/"
    echo "4. Créer le dossier old_files et y déplacer les anciens fichiers"
    echo "5. Vérifier la configuration MAMP"
    echo "6. Tester la connexion à la base de données"
    echo "7. Afficher l'état de la migration"
    echo "8. Quitter"
    echo ""
    read -p "Votre choix (1-8) : " choice
    echo ""
}

# Fonction 1 : Copier les assets
copy_assets() {
    echo "📁 Copie des assets vers public/..."
    
    if [ -d "assets" ]; then
        cp -r assets/* public/assets/
        echo "✅ Assets copiés"
    else
        echo "❌ Dossier assets/ introuvable"
    fi
    
    if [ -d "styles" ]; then
        cp -r styles/* public/styles/
        echo "✅ Styles copiés"
    else
        echo "❌ Dossier styles/ introuvable"
    fi
    
    if [ -d "scripts" ]; then
        cp -r scripts/* public/scripts/
        echo "✅ Scripts copiés"
    else
        echo "❌ Dossier scripts/ introuvable"
    fi
    
    echo ""
}

# Fonction 2 : Copier header
copy_header() {
    echo "📄 Copie de header.php..."
    
    if [ -f "header.php" ]; then
        cp header.php app/views/layouts/header.php
        echo "✅ header.php copié vers app/views/layouts/"
        echo "⚠️  N'oubliez pas de mettre à jour les chemins des assets !"
    else
        echo "❌ Fichier header.php introuvable"
    fi
    
    echo ""
}

# Fonction 3 : Copier footer
copy_footer() {
    echo "📄 Copie de footer.php..."
    
    if [ -f "footer.php" ]; then
        cp footer.php app/views/layouts/footer.php
        echo "✅ footer.php copié vers app/views/layouts/"
        echo "⚠️  N'oubliez pas de mettre à jour les chemins des assets !"
    else
        echo "❌ Fichier footer.php introuvable"
    fi
    
    echo ""
}

# Fonction 4 : Créer old_files
create_old_files() {
    echo "📦 Création du dossier old_files/..."
    
    if [ ! -d "old_files" ]; then
        mkdir old_files
        echo "✅ Dossier old_files/ créé"
    else
        echo "ℹ️  Le dossier old_files/ existe déjà"
    fi
    
    read -p "Voulez-vous déplacer les fichiers PHP dans old_files/ ? (o/n) : " move
    
    if [ "$move" = "o" ] || [ "$move" = "O" ]; then
        echo "⚠️  ATTENTION : Cette action va déplacer tous les fichiers .php de la racine"
        echo "   vers old_files/. Assurez-vous d'avoir migré vos vues avant !"
        read -p "Êtes-vous sûr ? (o/n) : " confirm
        
        if [ "$confirm" = "o" ] || [ "$confirm" = "O" ]; then
            mv *.php old_files/ 2>/dev/null
            echo "✅ Fichiers PHP déplacés dans old_files/"
        else
            echo "❌ Opération annulée"
        fi
    fi
    
    echo ""
}

# Fonction 5 : Vérifier MAMP
check_mamp() {
    echo "⚙️  Vérification de la configuration MAMP..."
    echo ""
    echo "Le Document Root de MAMP doit pointer vers :"
    echo "  📁 $(pwd)/public"
    echo ""
    echo "Pour configurer MAMP :"
    echo "  1. Ouvrir MAMP"
    echo "  2. Préférences → Web Server"
    echo "  3. Document Root : sélectionner le dossier 'public'"
    echo "  4. Redémarrer les serveurs"
    echo ""
    echo "Ou créer un Virtual Host (voir DEMARRAGE_RAPIDE.md)"
    echo ""
}

# Fonction 6 : Tester la BDD
test_database() {
    echo "🗄️  Test de la connexion à la base de données..."
    echo ""
    
    if [ ! -f ".env" ]; then
        echo "❌ Fichier .env introuvable"
        echo "   Veuillez copier .env.example vers .env et le configurer"
        echo ""
        return
    fi
    
    # Lire les variables du .env
    DB_HOST=$(grep DB_HOST .env | cut -d '=' -f2)
    DB_NAME=$(grep DB_NAME .env | cut -d '=' -f2)
    DB_USER=$(grep DB_USER .env | cut -d '=' -f2)
    DB_PASSWORD=$(grep DB_PASSWORD .env | cut -d '=' -f2)
    
    echo "Configuration trouvée :"
    echo "  Host: $DB_HOST"
    echo "  Database: $DB_NAME"
    echo "  User: $DB_USER"
    echo ""
    
    # Tester la connexion (nécessite mysql command line)
    if command -v mysql &> /dev/null; then
        mysql -h"$DB_HOST" -u"$DB_USER" -p"$DB_PASSWORD" -e "USE $DB_NAME; SELECT 'Connexion réussie ✅' as Status;" 2>/dev/null
        if [ $? -eq 0 ]; then
            echo "✅ Connexion à la base de données réussie"
        else
            echo "❌ Échec de la connexion à la base de données"
            echo "   Vérifiez vos paramètres dans .env"
        fi
    else
        echo "⚠️  Commande mysql non trouvée, impossible de tester"
        echo "   Vous pouvez tester manuellement via phpMyAdmin"
    fi
    
    echo ""
}

# Fonction 7 : État de la migration
migration_status() {
    echo "📊 État de la migration"
    echo "======================="
    echo ""
    
    # Vérifier les fichiers core
    echo "🔧 Core MVC :"
    [ -f "core/Database.php" ] && echo "  ✅ Database.php" || echo "  ❌ Database.php"
    [ -f "core/Controller.php" ] && echo "  ✅ Controller.php" || echo "  ❌ Controller.php"
    [ -f "core/Router.php" ] && echo "  ✅ Router.php" || echo "  ❌ Router.php"
    echo ""
    
    # Vérifier les contrôleurs
    echo "🎮 Contrôleurs :"
    controller_count=$(ls -1 app/controllers/*.php 2>/dev/null | wc -l)
    echo "  📁 $controller_count contrôleurs créés"
    echo ""
    
    # Vérifier les modèles
    echo "📊 Modèles :"
    model_count=$(ls -1 app/models/*.php 2>/dev/null | wc -l)
    echo "  📁 $model_count modèles créés"
    echo ""
    
    # Vérifier les vues
    echo "👁️  Vues :"
    [ -f "app/views/layouts/header.php" ] && echo "  ✅ header.php" || echo "  ❌ header.php (à migrer)"
    [ -f "app/views/layouts/footer.php" ] && echo "  ✅ footer.php" || echo "  ❌ footer.php (à migrer)"
    view_count=$(ls -1 app/views/pages/*.php 2>/dev/null | wc -l)
    echo "  📁 $view_count pages créées"
    echo ""
    
    # Vérifier les assets
    echo "🎨 Assets :"
    assets_count=$(ls -1 public/assets/* 2>/dev/null | wc -l)
    styles_count=$(ls -1 public/styles/*.css 2>/dev/null | wc -l)
    scripts_count=$(ls -1 public/scripts/*.js 2>/dev/null | wc -l)
    echo "  📁 $assets_count fichiers dans assets/"
    echo "  📁 $styles_count fichiers CSS"
    echo "  📁 $scripts_count fichiers JS"
    echo ""
    
    # Vérifier la config
    echo "⚙️  Configuration :"
    [ -f ".env" ] && echo "  ✅ .env" || echo "  ❌ .env (à créer depuis .env.example)"
    [ -f "config/config.php" ] && echo "  ✅ config.php" || echo "  ❌ config.php"
    echo ""
}

# Boucle principale
while true; do
    show_menu
    
    case $choice in
        1) copy_assets ;;
        2) copy_header ;;
        3) copy_footer ;;
        4) create_old_files ;;
        5) check_mamp ;;
        6) test_database ;;
        7) migration_status ;;
        8)
            echo "👋 Au revoir !"
            exit 0
            ;;
        *)
            echo "❌ Choix invalide"
            echo ""
            ;;
    esac
    
    read -p "Appuyez sur Entrée pour continuer..."
    clear
done
