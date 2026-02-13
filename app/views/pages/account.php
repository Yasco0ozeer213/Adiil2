<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon compte</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="/styles/account_style.css">
    <link rel="stylesheet" href="/styles/general_style.css">
    <link rel="stylesheet" href="/styles/header_style.css">
    <link rel="stylesheet" href="/styles/footer_style.css">

</head>

<body class="body_margin">
<?php require_once ROOT . '/app/views/layouts/header.php'; ?>

<body class="body_margin">

<H2>MON COMPTE</H2>

<!-- Affichage du message de succès ou d'erreur -->
<?php if ($message): ?>
    <?php $messageStyle = ($message_type === "error") ? "error-message" : "success-message"; ?>
    <div id="<?= $messageStyle ?>"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<section>
    <!-- Partie contenant les informations générales sur le compte de l'utilisateur -->
    <div id="account-generalInfo">
        <div>
            <form method="POST" enctype="multipart/form-data" id="pp-form">
                <label id="cadre-pp" for="profilePictureInput">
                    <?php if($infoUser['pp_membre'] == null):?>
                        <img src="/admin/ressources/default_images/user.jpg" alt="Photo de profil de l'utilisateur" />
                    <?php else:?>
                        <img src="/api/files/<?php echo $infoUser['pp_membre']; ?>" alt="Photo de profil de l'utilisateur" />
                    <?php endif?>
                </label>

                <input type="file" id="profilePictureInput" name="file" accept="image/jpeg, image/png, image/webp" style="display: none;" onchange="this.form.submit()">

                <button type="button" id="edit-icon" onclick="document.getElementById('profilePictureInput').click()">
                    <img src="/assets/edit_logo.png" alt="Icone éditer la photo de profil" />
                </button>
            </form>
        </div>
        <div>
            <p><?php echo $infoUser['xp_membre']; ?></p>
            <p>XP</p>
        </div>
        <div id="cadre-grade">
            <?php if (empty($infoUser['nom_grade'])): ?>
                <p>Vous n'avez pas de grade</p>
            <?php else: ?>
                <p><?php echo $infoUser['nom_grade']; ?></p>
                <?php if($infoUser['image_grade'] == null):?>
                    <img src="/admin/ressources/default_images/grade.webp" alt="Image du grade" />
                <?php else:?>
                    <img src="/api/files/<?php echo $infoUser['image_grade']; ?>" alt="Illustration du grade de l'utilisateur" />
                <?php endif?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Formulaire contenant les données personnelles de l'utilisateur -->
    <form method="POST" action="" id="account-personalInfo-form">
        <div>
            <div>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    placeholder="Prénom" 
                    value="<?php echo htmlspecialchars($infoUser['prenom_membre']); ?>" 
                    required>
                <input 
                    type="text" 
                    id="lastName" 
                    name="lastName" 
                    placeholder="Nom de famille" 
                    value="<?php echo htmlspecialchars($infoUser['nom_membre']); ?>" 
                    required>
            </div>
            <div>
                <input 
                    type="email" 
                    id="mail" 
                    name="mail" 
                    placeholder="Adresse mail" 
                    value="<?php echo htmlspecialchars($infoUser['email_membre']); ?>" 
                    required>
                
                <?php if (!empty($infoUser['tp_membre'])): ?>
                <select id="tp" name="tp">
                    <option value="11A" <?php echo $infoUser['tp_membre'] === '11A' ? 'selected' : ''; ?>>TP 11 A</option>
                    <option value="11B" <?php echo $infoUser['tp_membre'] === '11B' ? 'selected' : ''; ?>>TP 11 B</option>
                    <option value="12C" <?php echo $infoUser['tp_membre'] === '12C' ? 'selected' : ''; ?>>TP 12 C</option>
                    <option value="12D" <?php echo $infoUser['tp_membre'] === '12D' ? 'selected' : ''; ?>>TP 12 D</option>
                    <option value="21A" <?php echo $infoUser['tp_membre'] === '21A' ? 'selected' : ''; ?>>TP 21 A</option>
                    <option value="21B" <?php echo $infoUser['tp_membre'] === '21B' ? 'selected' : ''; ?>>TP 21 B</option>
                    <option value="22C" <?php echo $infoUser['tp_membre'] === '22C' ? 'selected' : ''; ?>>TP 22 C</option>
                    <option value="22D" <?php echo $infoUser['tp_membre'] === '22D' ? 'selected' : ''; ?>>TP 22 D</option>
                    <option value="31A" <?php echo $infoUser['tp_membre'] === '31A' ? 'selected' : ''; ?>>TP 31 A</option>
                    <option value="31B" <?php echo $infoUser['tp_membre'] === '31B' ? 'selected' : ''; ?>>TP 31 B</option>
                    <option value="32C" <?php echo $infoUser['tp_membre'] === '32C' ? 'selected' : ''; ?>>TP 32 C</option>
                    <option value="32D" <?php echo $infoUser['tp_membre'] === '32D' ? 'selected' : ''; ?>>TP 32 D</option>
                </select>
                <?php endif; ?>
            </div>
        </div>

        <button type="submit">
            <img src="/assets/save_logo.png" alt="Logo enregistrer les modifications"/>
        </button>
    </form>

    <!-- Formulaire permettant à l'utilisateur de modifier son mot de passe-->
    <form method="POST" action="" id="account-editPass-form">
        <div>
            <div>
                <p>Modifier mon mot de passe :</p>
                <input type="password" id="mdp" name="mdp" placeholder="Mot de passe actuel">
            </div>
            <div>
                <input type="password" id="newMdp" name="newMdp" placeholder="Nouveau mot de passe" required>
                <input type="password" id="newMdpVerif" name="newMdpVerif" placeholder="Confirmation du nouveau mot de passe" required>
            </div>
        </div>

        <button type="submit"><img src="/assets/save_logo.png" alt="Logo editer la photo de profil"/></button>
    </form>
</section>

<section>
    <div id="buttons-section">
        <!--Discord-->
        <button type="button">
            <a href="https://discord.com/login" target="_blank">
                <img src="/assets/logo_discord.png" alt="Logo de Discord">
                Associer mon compte à Discord
            </a>
        </button>

        <!--Deconnexion-->
        <form action="" method="post">
            <input type="hidden" name="deconnexion" value="true">
            <button type="submit">
                    <img src="/assets/logOut_icon.png" alt="icone de deconnexion">
                    Déconnexion
            </button>
        </form>

        <!--Supprimer son compte-->
        <form action="/account/delete" method="post">
            <input type="hidden" name="delete_account" value="true">
            <button type="submit">
                <img src="/assets/delete_icon.png" alt="icone de suppression">
                Supprimer mon compte
            </button>
        </form>
    </div>
</section>

<!-- PARTIE MES ACHATS -->
<section id="section-mesAchats">
    <h2>MES ACHATS</h2>

    <div id=historique-achats>
        <!-- Bouton pour afficher tout ou afficher moins -->
        <form method="GET" action="#section-mesAchats" id="viewAll-form">
            <?php if ($viewAll): ?>
                <button type="submit" name="viewAll" value="0">Afficher moins</button>
            <?php else: ?>
                <button type="submit" name="viewAll" value="1">Afficher tout</button>
            <?php endif; ?>
         </form>

        <?php if (!empty($historiqueAchats)): ?>
            <table id="tab-historique-achats">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Produit</th>
                    <th>Quantité</th>
                    <th>Prix</th>
                    <th>Mode de paiement</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($historiqueAchats as $achat): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($achat['date_transaction']); ?></td>
                        <td><?php echo htmlspecialchars($achat['type_transaction']); ?></td>
                        <td><?php echo htmlspecialchars($achat['element']); ?></td>
                        <td><?php echo htmlspecialchars($achat['quantite']); ?></td>
                        <td><?php echo htmlspecialchars(number_format($achat['montant'], 2, ',', ' ')) . " €"; ?></td>
                        <td><?php echo htmlspecialchars($achat['mode_paiement']); ?></td>
                        <td><?php echo htmlspecialchars($achat['statut']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            </table>
        <?php else: ?>
            <p>Vous n'avez effectué aucun achat pour le moment.</p>
        <?php endif; ?>
    </div>
</section>

<?php require_once ROOT . '/app/views/layouts/footer.php'; ?>
</body>
</html>
