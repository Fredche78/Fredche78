<?php
session_start();
$page = "Mon compte";
include("../templates/header.php");
require_once '../system/config.php';

// $errors=[];
$confirme = "";

if (!isset($_SESSION["token"])) {
    // Pas de token dans les variables de session
    session_destroy();
    header("Location: ./");
} else {

    $token = trim(strip_tags($_SESSION["token"]));

    $queryToken = $db->prepare("SELECT email, token FROM user_reset WHERE token LIKE :token");
    $queryToken->bindParam(":token", $token);
    $queryToken->execute();
    $result = $queryToken->fetch();

    // On vérifie l'adresse IP de l'utilisateur et le token
    if ($_SESSION["token"] != $result["token"] || !isset($_SESSION["user"]) || $_SESSION["user_ip"] != $_SERVER["REMOTE_ADDR"]) {

        session_destroy();
        header("Location: login.php");
        // echo "token";

    } else {

        if (isset($_SESSION['email'])) {
            $email = trim(strip_tags($_SESSION['email']));

            // $db = new PDO("mysql:host=localhost;dbname=sbpolish", "root", "");

            $query = $db->prepare("SELECT * FROM users WHERE email =  :email");
            $query->BindParam(":email", $email);
            $query->execute();
            $user = $query->fetch();
        }
    }

    if (!empty($_POST["modifyAccount"])) {

        $address = trim(strip_tags($_POST["address"]));
        $postcode = trim(strip_tags($_POST["postcode"]));
        $city = trim(strip_tags($_POST["city"]));
        $state = trim(strip_tags($_POST["state"]));
        $phone = trim(strip_tags($_POST["phone"]));
        $vehicule = trim(strip_tags($_POST["vehicule"]));
        $email = trim(strip_tags($user["email"]));
        // Requète SQL de mise à jour du compte
        $queryUpdate = $db->prepare(
            "UPDATE users
                                SET address = :address,
                                city = :city,
                                postcode = :postcode,
                                vehicule = :vehicule,   
                                phone = :phone,
                                state = :state
                                WHERE email LIKE :email"
        );

        $queryUpdate->bindParam(":address", $address);
        $queryUpdate->bindParam(":city", $city);
        $queryUpdate->bindParam(":postcode", $postcode);
        $queryUpdate->bindParam(":state", $state);
        $queryUpdate->bindParam(":phone", $phone);
        $queryUpdate->bindParam(":vehicule", $vehicule);
        $queryUpdate->bindParam(":email", $user["email"]);

        if ($queryUpdate->execute()) {
            // Possibilité de compléter avec une requête DELETE sur la table password_reset pour pruger la ligne en question.
            header("Location: ./my_account.php");
        } else {
            $message = "Erreur de bdd";
        }
    }

    //////////////////Delete////////////////////////

    if (isset($_POST["deleteAccount"])) {

        $delete = $_POST["deleteAccount"];
        $supAccount = $db->prepare("DELETE FROM users WHERE id= :id");
        $supAccount->bindParam(":id", $delete);

        if ($supAccount->execute()) {

            session_destroy();
            $confirme = "Votre compte a été supprimé";

        } else {
            $message = "Erreur de bdd";
        }
    }
}


if (empty($confirme)) {
?>

    <div class="myAccount">

        <div class="account">

            <h1>Compte de <?= $user["firstname"] . " " . $user["lastname"] ?></h1>
            <h2><?= $user["email"] ?></h2>

            <div class="viewAccount">

                <div class="items-account">
                    <h2>Votre compte</h2>

                    <div class="item-view">
                        <h3>Adresse</h3>
                        <p><?= $user["address"] . "<br>" . $user["postcode"] . " " . $user["city"] . ", " . $user["state"] ?></p>
                    </div>

                    <div class="item-view">
                        <h3>Numéro de téléphone</h3>
                        <?= $user["phone"] ?>
                    </div>

                    <div class="item-view">
                        <h3>Véhicule(s)</h3>
                        <?= $user["vehicule"] ?>
                    </div>

                    <div class="deleteAccount">

                        <form action="" method="post">
                            <button class="btn-account" name="deleteAccount" type="submit" value="<?= $user['id'] ?>">Supprimer le compte</button>
                        </form>
                    </div>

                </div>

                <div class="items-account-address">

                    <form action="" method="post">

                        <h2>Modifier votre compte</h2>


                        <div class="address-account">

                            <div class="address">

                                <div class="addressView">
                                    <p>
                                        <label for="inputAddress">Adresse:</label>
                                        <input type="text" id="inputAddress" name="address" value="<?= $user['address'] ?>">
                                    </p>
                                    <p>
                                        <label for="inputPostcode">Code postal:</label>
                                        <input type="text" id="inputPostcode" name="postcode" value="<?= $user['postcode'] ?>">
                                    </p>
                                    <p>
                                        <label for="inputCity">Ville:</label>
                                        <input type="text" id="inputCity" name="city" value="<?= $user['city'] ?>">
                                    </p>
                                    <p>
                                        <label for="selectMessage">Pays:</label>
                                        <select name="state" id="selectState">
                                            <option value="France" <?= (isset($state) && $state === "France") ? "selected" : "" ?>>France</option>
                                            <option value="Belgique" <?= (isset($state) && $state === "Belgique") ? "selected" : "" ?>>Belgique</option>
                                        </select>
                                    </p>
                                    <p>
                                        <label for="inputPhone">Téléphone:</label>
                                        <input type="text" id="inputPhone" name="phone" value="<?= $user['phone'] ?>">
                                    </p>
                                    <p>
                                        <label for="inputVehicule">Véhicule(s):</label>
                                        <input type="text" id="inputVehicule" name="vehicule" value="<?= $user['vehicule'] ?>">
                                    </p>
                                </div>

                            </div>

                            <input type="submit" name="modifyAccount" value="Modifier">

                        </div>

                    </form>

                </div>

            </div>

        </div>
    </div>

<?php
} else {
?>

    <div class="confirmeDeleteAccount">

        <div class="deleteAccount">

            <h1>Suppression de compte</h1>

            <h2><?= $confirme ?></h2>

            <div class="btn">

                <a href="./">Retour à l'accueil
                </a>

            </div>

        </div>

    </div>

<?php
}
include("../templates/footer.php")
?>