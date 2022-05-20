<?php
// session_start();
require_once("../system/config.php");

$error = "";

if (!empty($_POST)) {
    $email = trim(strip_tags($_POST["email"]));
    $password = trim(strip_tags($_POST["password"]));

    // $db : Vient de config.php
    $query = $db->prepare("SELECT * FROM users WHERE email LIKE :email");
    $query->bindParam(":email", $email);
    $query->execute();
    //Si vous ne voulez pas avoir les résultats en doublon il faut ajouter PDO::FETCH_ASSOC
    $result = $query->fetch(PDO::FETCH_ASSOC);

    // if ($password == $result["password"]) pas possible de le tester comme ça car nous avons d'un côté une donnée non cryptée et une donnée cryptée
    // if ($password_hash($password) == $result["password"]) pas possible non plus car le hash généré par password_hash change à chaque appel

    // password_verify va nous permettre de vérifier la correspondance entre le mot de passe saisi et le hash saisi et le hash stocké en BDD.
    if (!empty($result) && password_verify($password, $result["password"])) {

        ///////////////////////////////////////////////////////
        session_start();
        //////////////////////////////////////////////////////

    
        //On stocke le prénom, le nom et l'email dans des variables de session
        $_SESSION["user"] = $result["firstname"];
        $_SESSION["userName"] = $result["lastname"];
        $_SESSION["email"] = $result["email"];
        
        // On stocke l'adresse IP de l'utilisateur pour palier à une possible attaque "session hijacking"
        $_SESSION["user_ip"] = $_SERVER["REMOTE_ADDR"];
        // REMOTE_ADDR donne l'adresse ip de l'appelant
        // Redirection vers la page d'accueil
        
        $token = bin2hex(random_bytes(50));
        $validity = time() + 7200;

        $query = $db->prepare("INSERT INTO user_reset (email, token, validity) VALUES (:email, :token, :validity)");
        $query->bindParam(":email", $email);
        $query->bindParam(":token", $token);
        //On lie la durée de validity
        $query->bindParam(":validity", $validity, PDO::PARAM_INT);

        if ($query->execute()) {
            $_SESSION["token"] = $token;
        }

        header("Location: index.php");

    } else {
        $error = "Identifiant et/ou mot de passe incorrect(s)";
    }
}

$page="Connexion";
include("../templates/header.php")
?>

<div class="contact">

    <h1>Connexion</h1>

    <p id="errorLogin">
        <?= $error ?>
    </p> 

    <div class="form">

        <form action="" method="post">
            <div class="container">
                <div class="form-group-account">
                    <div class="form-item-group">
                        <label for="inputEmail">Email :</label>
                        <input type="email" name="email" id="inputEmail">

                        <label for="inputPassword">Mot de passe :</label>
                        <input type="password" name="password" id="inputPassword">
                        <p id="resetPwd">
                            <a href="reset_password.php">J'ai oublié mon mot de passe
                            </a>
                        </p>           
                    </div>
                </div>
                <input type="submit" value="Se connecter">
            </div>
        </form>

    </div>

</div>

<?php
include("../templates/footer.php")
?>