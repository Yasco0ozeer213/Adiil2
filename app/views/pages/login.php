<?php extract($data); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link rel="stylesheet" href="/styles/login_style.css">
    <link rel="stylesheet" href="/styles/general_style.css">
    <link rel="stylesheet" href="/styles/header_style.css">

</head>
<body>
    <?php require APP . '/views/layouts/header.php'; ?>

    <!-- Affichage de l'erreur de connexion -->
    <?php if ($login_error): ?>
        <h3 class="login-error"><?php echo $login_error; ?></h3>
    <?php endif; ?>

    <!-- Formulaire de connexion -->
    <form method="POST" action="/login" class="login-form">
        <h1>Connexion</h1>
        <label for="mail">Adresse Mail :</label>
        <input type="email" name="mail" required>

        <label for="password">Mot de passe :</label>
        <input type="password" name="password">

        <button type="submit">Se connecter</button>
    </form>

    <form method="GET" action="/signin" id="create-account">
        <h2>Pas encore de compte ?</h2>
        <button type="submit">Créez en un</button>
    </form>

</body>
</html>
