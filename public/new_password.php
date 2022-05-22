<?php
$page="Nouveau mot de passe";
$sessioncheck = "false";

require_once("../system/config.php");

$errors = [];

if (isset($_GET["token"])) {

    $token = trim(strip_tags($_GET["token"]));

    // $db = new PDO("mysql:host=localhost;dbname=sbpolish", "root", "");

    $query = $db->prepare("SELECT email, validity FROM password_reset WHERE token LIKE :token");
    $query->bindParam(":token", $token);
    $query->execute();
    $result = $query->fetch();

    // Validité du lien avec temps de validation

    if (!$result || $result["validity"] < time()) {

        // array_push($errors, "Votre lien de récupération du mot de passe est invalide ou expiré");

        $errors["validity"] = "Votre lien de récupération du mot de passe est invalide ou expiré";
    } else {

        $_SESSION["token"] = $token;
    }

    if (empty($result)) {
        // Tchao bye bye -> Le token n'a pas été trouvé dans la base
        header("Location: ./");
    }

    if (isset($_POST["password"])) {
        // if (!empty($_POST)) {
        // Le formulaire est envoyé et un mot de passe est disponible
        // N'oubliez pas de valider la consistance du mot de passe comme dans create_account.php
        $password = trim(strip_tags($_POST["password"]));
        $retypePassword = trim(strip_tags($_POST["retypePassword"]));

        if ($password !== $retypePassword) {
            $errors["retypePassword"] = "Les mots de passe ne sont pas identiques";
        }

        if ($result["email"] && $result["validity"] > time()) {

            $uppercase = preg_match("/[A-Z]/", $password); // début et fin d'expression régulère fait par /
            $lowercase = preg_match("/[a-z]/", $password);
            $number = preg_match("/[0-9]/", $password);
            $specialChar = preg_match("/[^a-zA-Z0-9]/", $password);
            $haveSpace = preg_match("/ /", $password);

            if (strlen($password) < 12 || !$uppercase || !$lowercase || !$number || !$specialChar || $haveSpace) {
                $errors["password"] = "Le mot de passe doit contenir au minimum 12 caractères, une majuscule, une minuscule, un caractère spécial et un chiffre";
            }

            if (empty($errors)) {

                // Cryptage du mot de passe
            $password = password_hash($password, PASSWORD_DEFAULT);

                // Requète SQL de mise à jour du mot de passe
                $query = $db->prepare("UPDATE users SET password = :password WHERE email LIKE :email");
                $query->bindParam(":password", $password);
                $query->bindParam(":email", $result["email"]);

                if ($query->execute()) {
                    // Possibilité de compléter avec une requête DELETE sur la table password_reset pour pruger la ligne en question.
                    $delete = $db->prepare(
                        "DELETE 
                                        FROM password_reset
                                        WHERE email = :email"
                    );
                    $delete->bindParam(":email", $result["email"]);
                    $delete->execute();

                    header("Location: ./login.php");
                } else {
                    $message = "Erreur de bdd";
                }
            }
        }
    }
} else {
    header("Location: ./");
}

include("../templates/header.php")

?>

<div class="contact">

    <h1>Choississez votre nouveau mot de passe</h1>

    <div class="form">

        <form action="" method="post">

            <div class="container">

                <div class="form-group-account">

                    <div class="form-item-group">

                        <label for="inputPassword">Nouveau mot de passe</label>
                        <input type="password" name="password" id="inputPassword">

                        <?php
                        if (isset($errors["password"])) {
                        ?>
                            <p class="errorsTxt"><?= $errors["password"] ?>
                            </p>
                        <?php
                        }
                        ?>
                        <?php
                        if (isset($errors["validity"])) {
                        ?>
                            <p class="errorsTxt"><?= $errors["validity"] ?>
                            </p>
                        <?php
                        }
                        ?>

                    </div>
                </div>

                <div class="form-group-account">

                    <div class="form-item-group">

                        <label for="inputRetypePassword">Confirmer nouveau mot de passe</label>
                        <input type="password" name="retypePassword" id="inputRetypePassword">

                        <?php
                        if (isset($errors["retypePassword"])) {
                        ?>
                            <p class="errorsTxt"><?= $errors["retypePassword"] ?>
                            </p>
                        <?php
                        }
                        ?>

                    </div>
                </div>

                <input type="submit" value="Envoyer">

            </div>

        </form>

    </div>

</div>

<?php
include("../templates/footer.php")
?>