<?php
if (isset($_GET["token"])) {
    $token = trim(strip_tags($_GET["token"]));

    $db = new PDO("mysql:host=localhost;dbname=sbpolish", "root", "");

    $query = $db->prepare("SELECT email FROM password_reset WHERE token LIKE :token");
    $query->bindParam(":token", $token);
    $query->execute();
    $result = $query->fetch();

    if (empty($result)) {
        // Tchao bye bye -> Le token n'a pas été trouvé dans la base
        header("Location: ./");
    }

    if (isset($_POST["password"])) {
        // Le formulaire est envoyé et un mot de passe est disponible
        // N'oubliez pas de valider la consistance du mot de passe comme dans create_account.php
        $password = trim(strip_tags($_POST["password"]));
        // Cryptage du mot de passe
        $password = password_hash($password, PASSWORD_DEFAULT);

        // Requète SQL de mise à jour du mot de passe
        $query = $db->prepare("UPDATE users SET password = :password WHERE email LIKE :email");
        $query->bindParam(":password", $password);
        $query->bindParam(":email", $result["email"]);

        if ($query->execute()) {
            // Possibilité de compléter avec une requête DELETE sur la table password_reset pour pruger la ligne en question.

            header("Location: ./login.php");
        }
    }
    // var_dump($result);
} else {
    header("Location: ./");
}

include("../templates/header.php")

?>

<div class="contact">

    <h1>Choississez votre nouveau mot de passe</h1>

    <form action="" method="post">
        <div class="form-group">
            <label for="inputPassword">Nouveau mot de passe</label>
            <input type="password" name="password" id="inputPassword">
        </div>

        <input type="submit" value="Envoyer">
    </form>
</div>

<?php
include("../templates/footer.php")
?>