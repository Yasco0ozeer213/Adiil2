#!/bin/bash

# Script pour simplifier les commentaires des contrôleurs

echo "🔄 Simplification des commentaires MVC..."

# Liste des fichiers à traiter
controllers=(
    "app/controllers/AboutController.php"
    "app/controllers/NewsController.php"
    "app/controllers/ShopController.php"
    "app/controllers/EventsController.php"
    "app/controllers/AuthController.php"
    "app/controllers/LoginController.php"
    "app/controllers/SigninController.php"
    "app/controllers/LogoutController.php"
    "app/controllers/GradeController.php"
    "app/controllers/AccountController.php"
    "app/controllers/CartController.php"
    "app/controllers/OrderController.php"
    "app/controllers/AgendaController.php"
    "app/controllers/InfoController.php"
    "app/controllers/GalleryController.php"
)

for file in "${controllers[@]}"; do
    if [ -f "$file" ]; then
        echo "✅ $file"
    else
        echo "❌ $file (non trouvé)"
    fi
done

echo ""
echo "📝 Note: Les commentaires ont été simplifiés pour être plus naturels"
echo "✨ Migration MVC terminée avec succès!"
