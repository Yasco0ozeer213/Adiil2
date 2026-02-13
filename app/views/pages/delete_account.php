<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="/styles/delete_account_style.css">
    <link rel="stylesheet" href="/styles/general_style.css">

    <title><?= $title ?? 'Supprimer mon compte - ADIIL' ?></title>
</head>
<body>

<?php if (isset($showConfirmation) && $showConfirmation): ?>
    <div id="deleteAccountAlert" class="alert-container">
        <div class="alert-content">
            <p>
                ⚠️ Vous êtes sur le point de supprimer votre compte. Cette action est irréversible.
                Toutes vos données seront perdues. Veuillez cocher la case ci-dessous pour confirmer que vous comprenez les conséquences.
            </p>
            <input type="checkbox" id="confirmCheckbox"> <label for="confirmCheckbox">J'ai compris</label>
            <br><br>
            <ul>
                <li>
                    <form action="/account/delete" method="POST">
                        <button id="confirmDelete" name="delete_account_valid" value="true" disabled>Valider</button>
                    </form>
                </li>
                <li>
                    <button id="cancelDelete" onclick="window.location.href='/account'">Revenir en arrière</button>
                </li>
            </ul>
        </div>
    </div>
<?php endif; ?>

<script src="/scripts/confirm_account_supression.js"></script>
</body>
</html>
