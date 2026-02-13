<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link rel="stylesheet" href="/styles/login_style.css">
    <link rel="stylesheet" href="/styles/general_style.css">
    <link rel="stylesheet" href="/styles/header_style.css">

</head>
<body>
    
<?php require_once ROOT . '/app/views/layouts/header.php'; ?>

    <?php if (isset($error) && $error): ?>
        <p style="color: red; text-align: center; margin: 20px 0;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form method="POST" action="/signin" class="login-form">
        <h1>S'inscrire</h1>

        <label for="mail">Prénom :</label>
        <input type="text" name="fname">

        <label for="mail">Nom :</label>
        <input type="text" name="lname">
    
        <label for="mail">Adresse Mail :*</label>
        <input type="email" name="mail" required>

        <label for="password">Mot de passe :*</label>
        <input type="password" name="password" required>

        <label for="password">Confirmez le Mot de passe :*</label>
        <input type="password" name="password_verif" required>

        <button type="submit">Confirmer</button>
    </form>

<?php require_once ROOT . '/app/views/layouts/footer.php'; ?>
</body>
