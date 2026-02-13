<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de l'événement</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="/styles/event_details_style.css">

    <link rel="stylesheet" href="/styles/general_style.css">
    <link rel="stylesheet" href="/styles/header_style.css">
    <link rel="stylesheet" href="/styles/footer_style.css">
</head>
<body class="body_margin">
<?php require_once ROOT . '/app/views/layouts/header.php'; ?>

    <section class="event-details">
        <!-- Image par défaut car la colonne image_evenement n'existe pas dans la BDD -->
        <img src="/admin/ressources/default_images/event.jpg" alt="Image de l'événement">

        <h1><?php echo strtoupper($event['nom_evenement']); ?></h1>

        <div>
            <h2><?php echo date('d/m/Y', strtotime($event['date_evenement'])); ?></h2>
            
            <?php if($isPassed):?>
                <button class="subscription" id="passed_subscription">Passé</button>
            <?php else: ?>
                <?php if($isSubscribed): ?>
                    <button class="subscription" id="passed_subscription">Inscrit</button>
                <?php else: ?>
                    <form class="subscription" action="/event_subscription" method="post">
                        <input type="text" name="eventid" value="<?php echo $eventId ?>" hidden>
                        <button type="submit">Inscription</button>
                    </form>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <ul>
            <li>
                <div>📍<h3><?php echo $event['lieu_evenement']; ?></h3></div>
            </li>
            <li>
                <div>💸<h3><?php echo $event['prix_evenement']; ?>€ par personne</h3></div>
            </li>
            <?php if(boolval($event['reductions_evenement'])): ?>
                <li><div>💎<h3>-10% pour les membres Diamants</h3></div></li>
            <?php endif; ?>
        </ul>

        <!-- Description commentée car la colonne description_evenement n'existe pas dans la BDD -->
        <!-- <p><?php echo nl2br(htmlspecialchars($event['description_evenement'] ?? '')); ?></p> -->
    </section>

    <section class="gallery">
        <h2>GALLERIE</h2>
        
        <?php if($isLoggedIn): ?>
            <h3>Mes photos</h3>
            <div class="my-medias">
                <?php foreach($myMedias as $media): ?>
                    <img src="/api/files/<?php echo trim($media['url_media']); ?>" alt="Image Personelle de l'événement">
                <?php endforeach; ?>

                <form id="add-media" action="/add_media" method="post" enctype="multipart/form-data">
                    <label for="file-picker">
                        <img src="/assets/add_media.png" alt="Ajouter un média">
                    </label>
                    <input type="hidden" name="eventid" value="<?php echo $eventId ?>">
                    <input type="hidden" name="userid" value="<?php echo $_SESSION['userid'] ?>">
                    <input type="file" id="file-picker" name="file" accept="image/jpeg, image/png, image/webp" hidden>
                    <button type="submit" style="display:none;">Envoyer</button>
                </form>

                <form id="open-gallery" action="/gallery" method="get">
                    <label for="open-gallery-button">
                        <img src="/assets/explore_gallery.png" alt="Voir ma galerie entière">
                    </label>
                    <input type="hidden" name="eventid" value="<?php echo $eventId ?>">
                    <button id="open-gallery-button" type="submit" style="display:none;">Envoyer</button>
                </form>
            </div>
        <?php endif; ?>

        <h3>Collection Generale</h3>
        <div class="general-medias">
            <?php foreach($generalMedias as $media): ?>
                <img src="/api/files/<?php echo trim($media['url_media']); ?>" alt="Image de l'événement">
            <?php endforeach; ?>
        </div>

        <div class="show-more">
            <form action="" method="GET" style="display: inline;">
                <input type="hidden" name="show" value="<?php echo $show + 8 ?>">
                <button type="submit">Voir plus</button>
            </form>

            <form action="" method="GET" style="display: inline;">
                <?php if($show >= 20): ?>
                    <input type="hidden" name="show" value="<?php echo $show - 10 ?>">
                <?php endif; ?>
                <button type="submit">Voir Moins</button>
            </form>
        </div>
    </section>

    <?php require_once ROOT . '/app/views/layouts/footer.php'; ?>
    
    <script src="/scripts/open_media.js"></script>
    <script src="/scripts/add_media.js"></script>
    <script src="/scripts/open_gallery.js"></script>
</body>
</html>
