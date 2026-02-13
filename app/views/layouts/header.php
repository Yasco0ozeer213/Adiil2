<link rel="shortcut icon" href="/admin/ressources/favicon.png" type="image/x-icon">

<?php
    // Session déjà démarrée dans index.php
    $isUserLoggedIn = isset($_SESSION['userid']);
    $isAdmin = isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] ;
?>


<!-- HEADER -->
<header>
    <a id="accueil" href="/">
        <img src="/assets/logo.png" alt="Logo de l'ADIIL">
    </a>
    <nav>
        <ul>
            <li>
                <a href="/events">Événements</a>
            </li>
            <li>
                <a href="/news">Actualités</a>
            </li>
            <li>
                <a href="/shop">Boutique</a>
            </li>
            <li>
                <a href="/grade">Grades</a>
            </li>
            
            <?php if ($isUserLoggedIn): ?>
                <li>
                    <a href="/agenda">Agenda</a>
                </li>
            <?php endif; ?>

            <li>
                <a href="/about">À propos</a>
            </li>

            <?php if ($isUserLoggedIn): ?>
                <li>
                    <a href="/account">Mon compte</a>
                </li>

                <?php if ($isAdmin): ?>
                  <li>
                      <a id="header_admin" href="/admin/admin.php">Panel Admin</a>
                  </li>
                <?php endif; ?>

            <?php else: ?>
                <li>
                    <a href="/login">Se connecter</a>
                </li>
            <?php endif; ?>

      
        </ul>
    </nav>
</header>
