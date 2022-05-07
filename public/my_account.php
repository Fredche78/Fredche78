<?php
include("../templates/header.php")
?>

<?php

// On teste que l'utilisateur est bien connecté
if (!isset($_SESSION["user"]) || $_SESSION["user_ip"] != $_SERVER["REMOTE_ADDR"]) {
    // Interdit ! -> rediriger vers la page de login
    header("Location: login.php");
} else {

    if (isset($_SESSION['email'])) {
        $email = trim(strip_tags($_SESSION['email']));

        $db = new PDO("mysql:host=localhost;dbname=sbpolish", "root", "");

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
                                "UPDATE users SET
                                address = :address,
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
        header("Location: ./");
    } else {
        $message = "Erreur de bdd";
    }
}
?>

<div class="myAccount">

    <div class="account">

        <h1>Compte de <?= $user["firstname"] . " " . $user["lastname"] ?></h1>
        <h2><?= $user["email"] ?></h2>

        <div class="viewAccount">

            <div class="items-account">

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

                    <h3>Modifier votre compte</h3>


                    <div class="address-account">

                        <div class="address">

                            <div>
                                <p> <label for="inputAddress">Adresse:
                                    </label>
                                </p>

                                <p>
                                    <label for="inputPostcode">Code postal:
                                    </label>
                                </p>

                                <p>
                                    <label for="inputCity">Ville:
                                    </label>
                                </p>
                                <p>
                                    <label for="selectMessage">Pays:
                                    </label>
                                </p>
                                <p>
                                    <label for="inputPhone">Téléphone:
                                    </label>
                                </p>
                                <p>
                                    <label for="inputVehicule">Véhicule(s):
                                    </label>
                                </p>
                            </div>

                            <div>
                                <p>
                                    <input type="text" id="inputAddress" name="address" value="<?= $user['address'] ?>">
                                </p>
                                <p>

                                    <input type="text" id="inputPostcode" name="postcode" value="<?= $user['postcode'] ?>">
                                </p>
                                <p>
                                    <input type="text" id="inputCity" name="city" value="<?= $user['city'] ?>">
                                </p>
                                <p>
                                    <select name="state" id="selectState">
                                        <option value="France" <?= (isset($state) && $state === "France") ? "selected" : "" ?>>France</option>
                                        <option value="Belgique" <?= (isset($state) && $state === "Belgique") ? "selected" : "" ?>>Belgique</option>
                                    </select>
                                </p>
                                <p>
                                    <input type="text" id="inputPhone" name="phone" value="<?= $user['phone'] ?>">
                                </p>
                                <p>
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
include("../templates/footer.php")
?>