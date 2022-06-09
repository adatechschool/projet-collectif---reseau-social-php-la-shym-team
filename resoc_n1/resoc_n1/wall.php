<?php
session_start();
?>

<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>ReSoC - Mur</title> 
        <meta name="author" content="Julien Falconnet">
        <link rel="stylesheet" href="style.css"/>
    </head>
    <body>
 <!-- <header-->
   <?php 
      include 'session.php';
       ?>

<main>
        <!-- <header>
            <img src="resoc.jpg" alt="Logo de notre réseau social"/>
            <nav id="menu">
                <a href="news.php">Actualités</a>
                <a href="wall.php?user_id=">Mur</a>
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
            <?php
            /**
             * Etape 1: Le mur concerne un utilisateur en particulier
             * La première étape est donc de trouver quel est l'id de l'utilisateur
             * Celui ci est indiqué en parametre GET de la page sous la forme user_id=...
             * Documentation : https://www.php.net/manual/fr/reserved.variables.get.php
             * ... mais en résumé c'est une manière de passer des informations à la page en ajoutant des choses dans l'url
             */
            //print_r($_SESSION);
            $userId =intval($_GET['user_id']); 
            // replace $userId = intval($_SESSION['connected_id']);<
            ?>
            <?php
            /**
             * Etape 2: se connecter à la base de donnée'
             */
            include 'server_connect.php';
           // $mysqli = new mysqli("localhost", "root", "root", "socialnetwork");
            ?>

            <aside>
                <?php
                /**
                 * Etape 3: récupérer le nom de l'utilisateur
                 */                
                $laQuestionEnSql = "SELECT * FROM users WHERE id= '$userId' ";
                include 'userinfo.php';
                //$lesInformations = $mysqli->query($laQuestionEnSql);
                $user = $lesInformations->fetch_assoc();
                //@todo: afficher le résultat de la ligne ci dessous, remplacer XXX par l'alias et effacer la ligne ci-dessous
                //echo "<pre>" . print_r($user, 1) . "</pre>";
                ?>
                <img src="wedjene_felicie.jpg" alt="Portrait de l'utilisatrice"/>
                <section>
                    <h3>Présentation</h3>
                    <p>Sur cette page vous trouverez tous les message de l'utilisatrice : <?php echo $user['alias']?>;
                        (n° <?php echo $userId ?>)
                    </p>
                </section>
            </aside>
            <main>
        <!--Post form-->
        



            <form action="wall.php?user_id=<?php echo $userId ?>" method="post">
                <input type='hidden'name='user_id' value=<?php echo $userId?>>
                <dl>
                    <dt><label for='message'>Post a message</label></dt>
                    <textarea  name='message' rows="5" cols="33" > </textarea>
                   
                </dl>
                <input class='login' type='submit'>
            </form>
<!--input log out -->
            <!-- <form action="logout.php" method="post">
                <input type='submit' value='Déconnexion'/>
            </form> -->

            <br>
             
                <?php
                $messageRecu = isset($_POST['message']);
                if ($messageRecu)
                { 
                    $messageSenderID = $_SESSION['connected_id'];
                    //echo $messageSenderID;
                    $messageAVerifier = $_POST['message'];
                    //echo $messageAVerifier;
                  

                    //echo "<pre>" . print_r($_POST, 1) . "</pre>";

                    // pour éviter les injection sql : https://www.w3schools.com/sql/sql_injection.asp

                    // $messageSenderID = intval($mysqli->real_escape_string($messageSenderID));
                    // $messageAVerifier = $mysqli->real_escape_string($messageAVerifier);
                    $retrieveMessage = "INSERT INTO posts " 
                    . "(id, user_id, content, created, parent_id, author_id)"
                    . "VALUES (NULL, "
                    . "'" . $userId . "', "
                    . "'" . $messageAVerifier . "', "
                    . "NOW(), "
                    . "NULL," 
                    . $messageSenderID
                    . ");";
                    //echo $retrieveMessage;
                    $ok = $mysqli->query($retrieveMessage);
                        if ( ! $ok)
                        {
                            echo "Impossible d'ajouter le message: " . $mysqli->error;
                        } else
                        {
                            //echo "Message posté en tant que : " . $messageSenderID;
                        }
                    
                    //echo $retrieveMessage ;
                    }   
                /**
                 * Etape 3: récupérer tous les messages de l'utilisatrice
                 */
                $laQuestionEnSql = "
                    SELECT posts.content, 
                    posts.created, 
                    users.alias as owner_name, 
                    posts.author_id as writer_id,
                    users.id as author_id,
                    zizi.alias AS zizi2,
                    COUNT(likes.id) as like_number, GROUP_CONCAT(DISTINCT tags.label) AS taglist 
                    FROM posts
                    JOIN users ON  users.id=posts.user_id
                    LEFT JOIN posts_tags ON posts.id = posts_tags.post_id  
                    LEFT JOIN tags       ON posts_tags.tag_id  = tags.id 
                    LEFT JOIN likes      ON likes.post_id  = posts.id 
                    LEFT JOIN users AS zizi ON zizi.id = posts.author_id

                    WHERE posts.user_id='$userId' 
                    GROUP BY posts.id
                    ORDER BY posts.created DESC  
                    ";
                    include 'userinfo.php';
                //$lesInformations = $mysqli->query($laQuestionEnSql);
                if ( ! $lesInformations)
                {
                    echo("Échec de la requete : " . $mysqli->error);
                }
             
                /**
                 * Etape 4: @todo Parcourir les messsages et remplir correctement le HTML avec les bonnes valeurs php
                 */
                while ($post = $lesInformations->fetch_assoc())
                {

                   // echo "<pre>" . print_r($post, 1) . "</pre>";
                    ?>                
                    <article>
                        <h3>
                            <time datetime='2020-02-01 11:12:13' ><?php echo $post['created']?></time>
                        </h3>
                        <address><?php 
                     $userName=$post['owner_name'];
                     $authorId =$post['author_id'];
                     $writerID = $post['writer_id'];
                     $superzizi = $post['zizi2'];
                     echo 
                    "<a href=\"wall.php?user_id=$authorId\"> message à $userName</a>";
                //     echo 
                //    "<a href=\"wall.php?user_id=$authorId\"> par $writerID </a>";
                   echo 
                   "<a href=\"wall.php?user_id=$authorId\"> de la part $superzizi </a>";
                    ?></address>
                   
                        <div>
                            <p><?php echo $post['content']?></p>
                            <!-- <p>Ceci est un autre paragraphe</p>
                            <p>... de toutes manières il faut supprimer cet 
                                article et le remplacer par des informations en 
                                provenance de la base de donnée</p> -->
                        </div>                                            
                        <footer>
                            <small><a href="">♥ <?php echo $post['like_number']?></small></a>
                            <a href=""><?php echo $post['taglist']?></a>
                            <!-- <a href="">#piscitur</a>, -->
                        </footer>
                    </article>
                <?php } ?>
            </main>
        </div>
    </body>
</html>