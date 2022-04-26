<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/stylesheets/css/main.css">
    <link rel="icon" href="assets/icons/favicon.ico">
    <title>SB Polish</title>
</head>

<body>
    <header>
        <div class="company">
            <div class="logo">
                <a href="./">
                    <img src="assets/img/logo.jpg" alt="logo">
                </a>
            </div>
            <!-- <p>Depuis 2014</p> -->
        </div>
        <div class="rightMenu">
            <div class="authentification">
                <nav>
                    <ul>
                        <?php
                        // On teste en complément l'adresse ip de l'utilisateur pour valider que la session appartient bien à l'utilisateur 
                        if (isset($_SESSION["user"]) && ($_SESSION["user_ip"] === $_SERVER["REMOTE_ADDR"])) {
                        ?>
                            <p>Bienvenue: <?= ($_SESSION["user"] ." ". $_SESSION["userName"])?></p>
                            
                            <li>
                                <a href="my_account.php">Mon compte</a>
                            </li>
                            -
                            <li>
                                <a href="logout.php">Déconnexion</a>
                            </li>
                        <?php
                        } else {
                        ?>
                            <li>
                                <a href="create_account.php">Création du compte</a>
                            </li>
                            <li>
                                <a href="login.php">Connexion</a>
                            </li>
                        <?php
                        }
                        ?>
                    </ul>
                </nav>
            </div>
            <div class="links">
                <a href="mailto:sbpolish@outlook.fr">
                    <div class="mail">
                        <!-- <img src="assets/icons/envelope.svg" alt="E-mail" width="45px" height="45px"> -->
                        <!-- <i class="fa-solid fa-envelope"></i> -->
                    </div>
                </a>
                <a href="tel:+33662492049">
                    <div class="phone">
                    </div>
                </a>
                <a href="https://www.facebook.com/SbPolish/" target="_blank">
                    <div class="facebook">
                    </div>
                </a>
            </div>

        </div>
    </header>

    <main>