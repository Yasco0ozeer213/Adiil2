# 📂 Anciens fichiers PHP à migrer

Ce dossier contient **tous les anciens fichiers PHP** qui doivent être migrés vers l'architecture MVC.

## ⚠️ IMPORTANT

**NE PAS MODIFIER CES FICHIERS DIRECTEMENT !**

Ces fichiers servent de **référence** pour la migration. Une fois qu'un fichier est migré vers MVC :
1. ✅ Le code est dans `app/controllers/` et `app/views/`
2. 📦 L'ancien fichier reste ici comme backup
3. 🗑️ Il pourra être supprimé plus tard

---

## 📋 Fichiers présents

### 🟢 **Pages principales (5)**
- [ ] `about.php`
- [ ] `events.php`
- [ ] `grade.php`
- [ ] `news.php`
- [ ] `shop.php`

### 🟡 **Pages de détails (2)**
- [ ] `event_details.php`
- [ ] `news_details.php`

### 🟠 **Compte utilisateur (5)**
- [ ] `account.php`
- [ ] `agenda.php`
- [ ] `login.php`
- [ ] `my_gallery.php`
- [ ] `signin.php`

### 🔴 **E-commerce (2)**
- [ ] `cart.php`
- [ ] `order.php`

### ⚫ **Actions (7)**
- [ ] `add_media.php`
- [ ] `cart_add.php`
- [ ] `delete_account.php`
- [ ] `delete_media.php`
- [ ] `event_subscription.php`
- [ ] `files_save.php`
- [ ] `grade_subscription.php`

### ⚪ **Autres (1)**
- [ ] `info.php`

---

## 🎯 Comment migrer un fichier ?

### **Étape 1 : Ouvrir le fichier ici**
```bash
# Ouvre le fichier à migrer
old_files/events.php
```

### **Étape 2 : Identifier les parties**
- 🔵 **CONTROLLER** : `require`, `$db->select()`, calculs
- 🟡 **VIEW** : HTML, `<div>`, `echo`
- 🔴 **MODEL** : Requêtes SQL répétées

### **Étape 3 : Créer les nouveaux fichiers**
```bash
# Controller
app/controllers/EventsController.php

# View
app/views/pages/events.php

# Model (si besoin)
app/models/Event.php
```

### **Étape 4 : Tester**
```bash
# Accède à la route MVC
http://localhost:8888/events
```

### **Étape 5 : Cocher dans la checklist**
```bash
# Marque le fichier comme migré dans
docs/CHECKLIST_MIGRATION.md
```

---

## 📚 Documentation

Pour plus de détails, consulte :
- **docs/GUIDE_SEPARATION_MVC.md** - Comment séparer le code
- **docs/CHECKLIST_MIGRATION.md** - Liste complète et priorités
- **docs/MIGRATION_GUIDE.md** - Procédure détaillée

---

## 🗑️ Suppression

**Ces fichiers pourront être supprimés** une fois :
1. ✅ La migration complète et testée
2. ✅ Le site en production fonctionne
3. ✅ Un backup Git est fait
4. ✅ Toute l'équipe valide

**Ne supprime rien avant ça !** 🛑

---

**Liste mise à jour le : 13 février 2026**
