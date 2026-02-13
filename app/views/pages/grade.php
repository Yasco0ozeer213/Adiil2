<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grades</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link rel="stylesheet" href="/styles/grade_style.css">

    <link rel="stylesheet" href="/styles/general_style.css">

    <link rel="stylesheet" href="/styles/header_style.css">
    <link rel="stylesheet" href="/styles/footer_style.css">

</head>



<body class="body_margin">

<?php require_once ROOT . '/app/views/layouts/header.php'; ?>

<body class="body_margin">

<H1>Les grades</H1>

<!-- Affichage du message de succès ou d'erreur -->
<!-- Le Controller nous envoie $message et $message_type -->
<div>
    <?php if ($message): ?>
        <?php $messageStyle = ($message_type === "error") ? "error-message" : "success-message"; ?>
        <div id="<?= $messageStyle ?>"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>
</div>

<!-- Le Controller nous envoie $grades (pas $products !) -->
<?php if (!empty($grades)) : ?>
    <div id="product-list">
        <!-- On boucle sur $grades -->
        <?php foreach ($grades as $grade) : ?>
                <div id="one-product">
                    <div>
                        <!-- Afficher l'image du grade -->
                        <?php if($grade['image_grade'] == null):?>
                            <img src="/admin/ressources/default_images/grade.webp" alt="Image du grade" />
                        <?php else:?>
                            <img src="/api/files/<?php echo $grade['image_grade']; ?>" alt="Image du grade" />
                        <?php endif?>

                        <!-- Nom du grade -->
                        <h3 title="<?= htmlspecialchars($grade['nom_grade']) ?>">
                            <?= htmlspecialchars($grade['nom_grade']) ?>
                        </h3>
                        
                        <!-- Description du grade -->
                        <?php if (!empty($grade['description_grade'])) { ?>
                            <p><?= htmlspecialchars($grade['description_grade'])?></p>
                        <?php } ?>
                        
                        <!-- Prix du grade -->
                        <p>-- Prix : <?= number_format(htmlspecialchars($grade['prix_grade']), 2, ',', ' ') ?> € --</p>
                    </div>
                    <div>
                        <p id="adhesion-status">
                            <!-- Le Controller a déjà vérifié si l'utilisateur possède ce grade -->
                            <!-- Il nous a envoyé $grade['user_has_it'] = true ou false -->
                            <?php if ($grade['user_has_it']): ?>
                                <button id="detention">Vous détenez ce grade</button>
                            <?php else: ?>
                                <a id="buy-button" href="/grade/subscribe?id=<?= htmlspecialchars($grade['id_grade']) ?>">
                                    Acheter
                                </a>
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
        <?php endforeach; ?>
    </div>
<?php else : ?>
    <p>Aucun grade trouvé.</p>
<?php endif; ?>

<?php require_once ROOT . '/app/views/layouts/footer.php'; ?>

</body>
</html>
