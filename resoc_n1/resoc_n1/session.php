
    <header>
            <img src="resoc.jpg" alt="Logo de notre réseau social"/>
            <nav id="menu">
                <a href="login.php">Connexion</a>
                <a href="news.php">Actualités</a>
                <a href="wall.php?user_id=<?php echo intval($_SESSION['connected_id'])?>">Mur</a>
                <a href="feed.php?user_id=<?php echo intval($_SESSION['connected_id'])?>">Flux</a>
                <a href="tags.php?tag_id=<?php echo intval($_SESSION['connected_id'])?>">Mots-clés</a>
            </nav>
            <nav id="user">
                <a href="#">Profil</a>
                <ul>
                    <li><a href="settings.php?user_id=<?php echo intval($_SESSION['connected_id'])?>">Paramètres</a><li>
                    <li><a href="followers.php?user_id=<?php echo intval($_SESSION['connected_id'])?>">Mes suiveurs</a><li>
                    <li><a href="subscriptions.php?user_id=<?php echo intval($_SESSION['connected_id'])?>">Mes abonnements</a></li>
                    <li><a href="logout.php">Déconnexion</a></li>
                </ul>

            </nav>
        </header>


