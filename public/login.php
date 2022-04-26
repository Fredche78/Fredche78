<?php

$error = "";
if (!empty($_POST)) {
    $email = trim(strip_tags($_POST["email"]));
    $password = trim(strip_tags($_POST["password"]));

    $db = new PDO("mysql:host=localhost;dbname=sbpolish", "root", "");
    $query = $db->prepare("SELECT * FROM users WHERE email LIKE :email");
    $query->bindParam(":email", $email);
    $query->execute();
    //Si vous ne voulez pas avoir les résultats en doublon il faut ajouter PDO::FETCH_ASSOC
    $result = $query->fetch(PDO::FETCH_ASSOC);

    // if ($password == $result["password"]) pas possible de le tester comme ça car nous avons d'un côté une donnée non cryptée et une donnée ccryptée
    // if ($password_hash($password) == $result["password"]) pas possible non plus car le hash généré par password_hash change à chaque appel

    // password_verify va nous permettre de vérifier la correspondance entre le mot de passe saisi et le hash saisi et le hash stocké en BDD.
    if (!empty($result) && password_verify($password, $result["password"])) {
        // Les informations de connexion sont correctes
        // Démarrage du système de session
        session_start();
        //On stocke le prénom dans un variable de session
        $_SESSION["user"] = $result["firstname"];
        $_SESSION["userName"] = $result["lastname"];
        // On stocke l'adresse IP de l'utilisateur pour palier à une possible attaque "session hijacking"
        $_SESSION["user_ip"] = $_SERVER["REMOTE_ADDR"]; // REMOTE_ADDR donne l'adresse ip de l'appelant
        // Redirection vers la page d'accueil
        header("Location: index.php");
    } else {
        $error = "Erreur de connexion: veuillez vérifier vos informations de connexion";
    }
}

include("../templates/header.php")
?>

<div class="contact">

    <h1>Connexion</h1>

    <?= $error ?>

    <div class="form">

        <form action="" method="post">
            <div class="container">
                <div class="form-group">
                    <div class="form-item-group">
                        <label for="inputEmail">Email :</label>
                        <input type="email" name="email" id="inputEmail">
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-item-group">
                        <label for="inputPassword">Mot de passe :</label>
                        <input type="password" name="password" id="inputPassword">
                    </div>
                </div>
                <input type="submit" value="Se connecter">
            </div>
        </form>
    </div>

    <div class="resetPwd">
        <p>
            <a href="reset_password.php">Mot de passe oublié
            </a>
        </p>
    </div>

</div>

<?php
include("../templates/footer.php")
?>