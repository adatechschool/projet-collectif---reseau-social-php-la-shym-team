<?php
session_start();
?>
<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>ReSoC - Mes abonnés </title> 
        <meta name="author" content="Julien Falconnet">
        <link rel="stylesheet" href="style.css"/>
    </head>
    <body>
    <?php 
       include 'session.php';
       ?>
        <!-- <header>
            <img src="resoc.jpg" alt="Logo de notre réseau social"/> 
            <nav id="menu">
                <a href="news.php">Actualités</a>
                <a href="wall.php?user_id=5">Mur</a>
                <a href="feed.php?user_id=5">Flux</a>
                <a href="tags.php?tag_id=1">Mots-clés</a>
            </nav>
            <nav id="user">
                <a href="#">Profil</a>
                <ul>
                    <li><a href="settings.php?user_id=5">Paramètres</a></li>
                    <li><a href="followers.php?user_id=5">Mes suiveurs</a></li>
                    <li><a href="subscriptions.php?user_id=5">Mes abonnements</a></li>
                </ul>

            </nav>
        </header> -->
        <div id="wrapper">          
            <aside>
                <img src = "user.jpg" alt = "Portrait de l'utilisatrice"/>
                <section>
                    <h3>Présentation</h3>
                    <p>Sur cette page vous trouverez la liste des personnes qui
                        suivent les messages de l'utilisatrice
                        n° <?php echo intval($_SESSION['connected_id'])//echo include "commun_code.php" ;  ?></p>

                </section>
            </aside>
            <main class='contacts'>
                <?php
                // Etape 1: récupérer l'id de l'utilisateur
                //include 'userID.php';
                $userId = intval($_SESSION['connected_id']);
                //echo $userId;
               // $userId = intval($_GET['user_id']);
                // Etape 2: se connecter à la base de donnée
               include 'server_connect.php';
              //  $mysqli = new mysqli("localhost", "root", "root", "socialnetwork");
                // Etape 3: récupérer le nom de l'utilisateur
                $laQuestionEnSql = "
                    SELECT users.*,
                    users.alias as author_name,
                    users.id as author_id
                    FROM followers
                    LEFT JOIN users ON users.id=followers.following_user_id
                    WHERE followers.followed_user_id='$userId'
                    GROUP BY users.id
                    ";
                    include 'userinfo.php';
                    if ( ! $lesInformations)
                    {
                        echo("Échec de la requete : " . $mysqli->error);
                    }
    
                    while ($user = $lesInformations->fetch_assoc())
                    {
    
                //$lesInformations = $mysqli->query($laQuestionEnSql);
                // Etape 4: à vous de jouer
                
                //@todo: faire la boucle while de parcours des abonnés et mettre les bonnes valeurs ci dessous 
                //echo "<pre>" . print_r($user, 1) . "</pre>"
                ?>
                <article>
                    <img src="user.jpg" alt="blason"/>
                    <h3><?php 
                     $userName=$user['author_name'];
                     $authorId =$user['author_id'];
                     echo 
                    "<a href=\"wall.php?user_id=$authorId\">$userName</a>"
                    ?></h3>
                    <p><?php echo $user['id']?></p>
                </article>
                <?php
                }
                ?>
            </main>
        </div>
    </body>
</html>
