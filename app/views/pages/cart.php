<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon panier</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="/styles/cart_style.css">

    <link rel="stylesheet" href="/styles/general_style.css">
    <link rel="stylesheet" href="/styles/header_style.css">
    <link rel="stylesheet" href="/styles/footer_style.css">

    <script>
        //Fonction pour valider la soumission du formulaire (form-quantity) par la touche "Entrée"
        function pressEnter (event) {
            var code=event.which || event.keyCode;
            if (code==13) { //Code de la touche "Entrée"
                document.getElementById("form-quantity").submit();
            }
        }
    </script>

</head>
<?php require_once ROOT . '/app/views/layouts/header.php'; ?>

<body class="body_margin">

<script>
    //Fonction pour valider la soumission du formulaire (form-quantity) par la touche "Entrée"
    function pressEnter (event) {
        var code=event.which || event.keyCode;
        if (code==13) { //Code de la touche "Entrée"
            document.getElementById("form-quantity").submit();
        }
    }
</script>

<div>
<H1>MON PANIER</H1>

    <!-- Affichage du message de succès ou d'erreur -->
    <?php if ($message): ?>
        <?php $messageStyle = ($message_type === "error") ? "error-message" : "success-message"; ?>
        <div id="<?= $messageStyle ?>"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <div>
        <button id="shop-button" >
            <a href="/shop">
                <img src="/assets/fleche_retour.png" alt="Fleche de retour">
                Retourner à la boutique
            </a>
        </button>
    </div>
</div>

<?php if (!empty($_SESSION['cart'])) : ?>
<div id='cart-container'>
    <form method="POST" action="/cart" id= "form-quantity">
    <table>
            <thead>
                <tr>
                    <th>Article</th>
                    <th>Prix unitaire</th>
                    <th>Quantité</th>
                    <th>Sous-total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product) :?>
                <tr>
                    <td id='article-cell'>
                        <img src="/api/files/<?php echo $product['image_article']; ?>" alt="Image de l'article" />
                        <p><?= htmlspecialchars($product['nom_article']) ?></p>
                    </td>
                    <td><?= number_format(htmlspecialchars($product['prix_article']), 2, ',', ' ') ?> €</td>                
                    <td><input type='text' name="cart[quantity][<?=$product['id_article']?>]" value="<?=$_SESSION['cart'][$product['id_article']]?>" onkeydown="pressEnter(event)"></td>
                    <td><?= number_format(htmlspecialchars($product['prix_article'] * $_SESSION['cart'][$product['id_article']]), 2, ',', ' ') ?> €</td>  
                    <td>
                        <a href="/cart?del=<?= $product['id_article'] ?>">Supprimer</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>Nombre d'articles &nbsp : </th>
                    <td><?=$cart->count()?></td>
                </tr>
                <tr>
                    <th>Total &nbsp : </th>
                    <td><?= number_format($cart->total(), 2, ',', ' ') ?> €</td>
                </tr>
                
                <?php if ($totalWithReduc !== null): ?>
                    <tr>
                        <th style="min-width: 400px">Total après réductions (<?= $reductionGrade ?>%) &nbsp : </th>
                        <td style="min-width: 50px"><?= number_format($totalWithReduc, 2, ',', ' ') ?> €</td>
                    </tr>
                <?php endif; ?>
            <tfoot>
        </table>
    </form>
</div>
<div>
    <form class="subscription" action="/order" method="post">
        <?php if (isset($_SESSION['cart'])): ?>
            <input type="hidden" name="cart" value="<?= htmlspecialchars(json_encode($_SESSION['cart'], JSON_UNESCAPED_UNICODE)) ?>">
        <?php endif; ?>
        <button type="submit" id='order-button'>
            Commander
        </button>
    </form>
</div>

<?php else : ?>
    <p id="empty-cart">Votre panier est vide</p>
<?php endif; ?>

<?php require_once ROOT . '/app/views/layouts/footer.php'; ?>

</body>
</html>
