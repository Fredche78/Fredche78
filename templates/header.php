<?php

if ($sessioncheck === "true") {

    session_start();

    if (isset($_SESSION["email"])) {

        
        require_once("../system/config.php");

        $token = trim(strip_tags($_SESSION["token"]));

        $queryToken = $db->prepare("SELECT * FROM user_reset WHERE token LIKE :token");
        $queryToken->bindParam(":token", $token);
        $queryToken->execute();
        $result = $queryToken->fetch();

        if ($_SESSION["token"] != $result["token"] || !isset($_SESSION["user"]) || $_SESSION["user_ip"] != $_SERVER["REMOTE_ADDR"] || $_SESSION["validity"] != $result["validity"] || $result["validity"] < time()) {

            header("Location: logout.php");
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Bienvenue sur le site de S.B POLISH spécialiste depuis 2014 du nettoyage automobile. Vous rentrez de vacances, célébrez un mariage, vendez ou achetez un véhicule ? Pensez à S.B POLISH !">
    <link rel="stylesheet" href="assets/stylesheets/css/main.css">
    <!-- Link to the file hosted on your server, -->
    <link rel="stylesheet" href="../node_modules/@splidejs/splide/dist/css/splide.min.css">
    <link rel="icon" href="assets/icons/favicon.ico">
    <title><?= $page ?></title>
</head>

<body>
    <header>

        <div class="headerView">

            <div class="company">
                <div class="logo">
                    <a href="./">
                        <img src="assets/img/logo.png" alt="logo">
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
                                <p>Bienvenue: <?= ($_SESSION["user"] . " " . $_SESSION["userName"]) ?>
                                </p>

                                <li>
                                    <a href="my_account.php">Mon compte
                                    </a>
                                </li>
                                <li>
                                    -
                                </li>
                                <li>
                                    <a href="logout.php">Déconnexion

                                    </a>
                                </li>
                            <?php
                            } else {
                            ?>
                                <li>
                                    <a href="create_account.php">Création du compte
                                    </a>
                                </li>
                                -
                                <li>
                                    <a href="login.php">Connexion
                                    </a>
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
                            <img src="assets/icons/envelope.svg" alt="email" width="40px" height="40px">
                        </div>
                    </a>
                    <a href="tel:+33662492049">
                        <div class="phone">
                            <img src="assets/icons/phone.svg" alt="téléphone" width="35px" height="35px">
                        </div>
                    </a>
                    <a href="https://www.facebook.com/SbPolish/" target="_blank">
                        <div class="facebook">
                            <img src="assets/icons/facebook.svg" alt="facebook" width="35px" height="35px">
                        </div>
                    </a>
                </div>

            </div>
        </div>

        <div class="hrDiv">
            <hr>
        </div>

    </header>

    <main>