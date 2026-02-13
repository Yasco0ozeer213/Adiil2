<?php require_once ROOT . '/app/views/layouts/header.php'; ?>

<body>
    <section class="event-details">
        <?php if($news['image_actualite'] == null):?>
            <img src="/admin/ressources/default_images/event.jpg" alt="Image de l'actualite">
        <?php else:?>
            <img src="/api/files/<?php echo $news['image_actualite']; ?>" alt="Image de l'actualite">
        <?php endif?>
        
        <h1><?php echo strtoupper($news['titre_actualite']); ?></h1>

        <div>
            <h2><?php echo date('d/m/Y', strtotime($news['date_actualite'])); ?></h2>
        </div>
        
        <ul></ul>
        
        <p><?php echo nl2br(htmlspecialchars($news['contenu_actualite'])); ?></p>
    </section>

    <?php require_once ROOT . '/app/views/layouts/footer.php'; ?>
</body>
</html>
