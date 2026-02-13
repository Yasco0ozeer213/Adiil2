<!DOCTYPE html>
<html lang="fr">
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <title><?= $title ?? 'Ma Galerie - ADIIL' ?></title>
    
    <link rel="stylesheet" href="/styles/my_gallery_style.css">
    <link rel="stylesheet" href="/styles/general_style.css">
    <link rel="stylesheet" href="/styles/header_style.css">
    <link rel="stylesheet" href="/styles/footer_style.css">
</head>
<body>
<?php require_once ROOT . '/app/views/layouts/header.php'; ?>

<section class="user-gallery">

    <a href="/events/details/<?= $eventid ?>" class="back-arrow">
        &#8592;<span>Retour</span>
    </a>
    <h1>MA GALLERIE</h1>
    <h2><?= htmlspecialchars($event['nom_evenement']) ?></h2>

    <div class="my-medias">

            <form id="add-media" action="/gallery/add" method="post" enctype="multipart/form-data">
                <label for="file-picker">
                    <img src="/assets/add_media.png" alt="Ajouter un média">
                </label>
                <input type="hidden" name="eventid" value="<?= $eventid ?>">
                <input type="hidden" name="userid" value="<?= $userid ?>">

                <input type="file" id="file-picker" name="file" accept="image/jpeg, image/png, image/webp" hidden>
                <button type="submit" style="display:none;">Envoyer</button>
            </form>

           <?php foreach($medias as $media): ?>
                <div class="media-container">
                    <img src="/api/files/<?= trim($media['url_media']); ?>" alt="Image Personnelle de l'événement">
                    <div class="delete-icon">

                        <form class="delete-media" action="/gallery/delete" method="post">
                            <label for="del-media">
                                <img src="/assets/delete_icon.png" alt="poubelle">
                            </label>
                            <input type="hidden" name="mediaid" value="<?= $media['id_media'] ?>">
                            <input type="hidden" name="eventid" value="<?= $eventid ?>">

                            <button type="submit" style="display:none;">Envoyer</button>
                        </form>

                    </div>
                </div>
            <?php endforeach; ?>

    </div>

</section>

<?php require_once ROOT . '/app/views/layouts/footer.php'; ?>

<script src="/scripts/open_media.js"></script>
<script src="/scripts/add_media.js"></script>
<script src="/scripts/delete_media.js"></script>

</body>
</html>
