<?php extract($data); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <title>Evenements</title>
    <link rel="stylesheet" href="/styles/events_style.css">
    <link rel="stylesheet" href="/styles/general_style.css">
    <link rel="stylesheet" href="/styles/header_style.css">
    <link rel="stylesheet" href="/styles/footer_style.css">
</head>
<body class="body_margin">

<?php require APP . '/views/layouts/header.php'; ?>

<h1>LES EVENEMENTS</h1>
<section>
    <a class="show-more" href="/events?show=<?php echo $show + 10?>">Voir plus loin dans le passé</a>
    <div class="events-display">
        <?php foreach ($events as $event): ?>
            <div class="event-box <?php echo $event['other_classes'] ?? '';?>" 
                 id="<?php echo ($event['isClosest'] ?? false) ? 'closest-event' : '' ?>">
                <div class="timeline-event">
                    <h4><?php echo ucwords($joursFr[$event['date_info']['wday']]." ".$event['date_info']["mday"]." ".$moisFr[$event['date_info']['mon']]);?></h4>
                    <div class="vertical-line"></div>
                    <p><?php echo $event['date_pin_label'];?></p>
                    <div class="timeline-marker <?php echo $event['date_pin_class'] ?>">
                        <div class="time-line"></div>
                    </div>
                </div>
                <div class="event" event-id="<?php echo $event['id_evenement'];?>">
                    <div>
                        <h2><?php echo $event['nom_evenement'];?></h2>
                        <?php echo ucwords($event["lieu_evenement"]);?>
                    </div>
                    <h4 class="<?php echo $event['subscription_class'];?>">
                        <?php echo $event['subscription_label'];?>
                    </h4>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<?php require APP . '/views/layouts/footer.php'; ?>

<script src="/scripts/event_details_redirect.js"></script>
<script src="/scripts/scroll_to_closest_event.js"></script>

</body>
</html>