<?php

if (!empty($_POST)) {
    // Le formulaire a été soumis
    $firstname = trim(strip_tags($_POST["firstname"])); // Ici firstname = au name dans le formulaire
    $lastname = trim(strip_tags($_POST["lastname"]));
    $email = trim(strip_tags($_POST["email"]));
    $emailConfirm = trim(strip_tags($_POST["emailConfirm"]));
    $password = trim(strip_tags($_POST["password"]));
    $retypePassword = trim(strip_tags($_POST["retypePassword"]));
    $address = trim(strip_tags($_POST["address"]));
    $city = trim(strip_tags($_POST["city"]));
    $postcode = trim(strip_tags($_POST["postcode"]));
    $state = trim(strip_tags($_POST["state"]));
    $phone = trim(strip_tags($_POST["phone"]));
    $vehicule = trim(strip_tags($_POST["vehicule"]));


    //Initialisation d'un tableau d'erreur
    $errors = [];

    // Validation de l'email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "L'email n'est pas valide";
    }

    // $db = new PDO("mysql:host=localhost;dbname=sbpolish", "root", "");
    // $query = $db->prepare("SELECT email FROM users WHERE email=:email");
    // $query->execute();
    // $test = $query->fetch();

    // if ($email === $test) {
    //     
?><p>L'utilisateur existe déjà</p><?php
                                    // }

// Validation du mot de passe

if ($password != $retypePassword) {
    $errors["retypePassword"] = "Les mots de passe ne sont pas identiques";
}

/**
* 
*  1/ Validation de la taille du mot de passe
*  2/ Validation de la présence d'au moins une majuscule, une minuscule et un chiffre
*  Pour ce faire nous allons utiliser des expressions régulières
*  En PHP l'utilisation des expressions régulières se fait avec la fonction preg_match
*  Par exemple :
*  - Rechercher une lettre majuscule n'importe où dans la chaine : [A-Z]
*  - Correspond à la chaine toto : toto
*  - Commence par toto : ^toto
*  - Termine par toto : toto$
*  - Contient toto : ^toto$
*  - Contient trois lettres majuscules : [A-Z]{3}
*  - Commence par http ou https : ^(http|https)
*  - Contient un caractère spécial : [^A-Za-z-9] // ^ ici veut dire différent de
*/

$uppercase = preg_match("/[A-Z]/", $password); // début et fin d'expression régulère fait par /
$lowercase = preg_match("/[a-z]/", $password);
$number = preg_match("/[0-9]/", $password);
$haveSpace = preg_match("/ /", $password);

if (strlen($password) < 6 || !$uppercase || !$lowercase || !$number || $haveSpace) {
    $errors["password"] = "Le mot de passe doit contenir 6 caractères minimum, une majuscule, une minuscule et un chiffre";
}

// Si pas d'erreur -> insertion de l'utilisateur en BDD
if (empty($errors)) {
    $db = new PDO("mysql:host=localhost;dbname=sbpolish", "root", "");

// Cryptage du mot de passe -> BCRYPT par défaut mais possibilité d'utiliser du ARGON2 (pas d'insertion du mot de passe sans cryptage)
$password = password_hash($password, PASSWORD_DEFAULT);

$query = $db->prepare("INSERT INTO users (firstname, lastname, email, password, address, city, postcode, state, phone, vehicule) VALUES (:firstname, :lastname, :email, :password, :address, :city, :postcode, :state, :phone, :vehicule)");

$query->bindParam(":firstname", $firstname);
$query->bindParam(":lastname", $lastname);
$query->bindParam(":email", $email);
$query->bindParam(":password", $password);
$query->bindParam(":address", $address);
$query->bindParam(":city", $city);
$query->bindParam(":postcode", $postcode);
$query->bindParam(":state", $state);
$query->bindParam(":phone", $phone);
$query->bindParam(":vehicule", $vehicule);

    if ($query->execute()) {

        header("Location: login.php");

        } else {

            $message = "Erreur de bdd";
        }
    }
}

include("../templates/header.php")
?>

<div class="contact">

    <h1>Inscription</h1>

    <div class="form">
        <form action="" method="post">
            <div class="container">
                <div class="form-group">
                    <div class="form-item-group">
                        <label for="inputFirstname">Prénom *</label>
                        <input type="text" id="inputFirstname" name="firstname" value="<?= isset($firstname) ? $firstname : "" ?>">
                    </div>
                    <div class="form-item-group">
                        <label for="inputLastname">Nom *</label>
                        <input type="text" id="inputLastname" name="lastname" value="<?= isset($lastname) ? $lastname : "" ?>">
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-item-group">
                        <label for="inputEmail">E-mail *</label>
                        <input type="email" id="inputEmail" name="email" value="<?= isset($email) ? $email : "" ?>">
                        <?php
                        if (isset($errors["email"])) {
                        ?>
                            <p><?= $errors["email"] ?></p>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="form-item-group">
                        <label for="inputEmailConfirm">Confirmer E-mail *</label>
                        <input type="email" name="emailConfirm" id="inputEmailConfirm" value="<?= isset($emailConfirm) ? $emailConfirm : "" ?>" required />
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-item-group">
                        <label for="inputPassword">Mot de passe *</label>
                        <input type="password" name="password" id="inputPassword" value="<?= isset($password) ? $password : "" ?>">
                    </div>

                    <?php
                    if (isset($errors["password"])) {
                    ?>
                        <p><?= $errors["password"] ?></p>
                    <?php
                    }
                    ?>

                    <div class="form-item-group">
                        <label for="inputRetypePassword">Confirmer mot de passe *</label>
                        <input type="password" name="retypePassword" id="inputRetypePassword" value="<?= isset($retryPassword) ? $retryPassword : "" ?>">
                        <?php
                        if (isset($errors["retypePassword"])) {
                        ?>
                            <p><?= $errors["retypePassword"] ?></p>
                        <?php
                        }
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-item-group">
                        <label for="inputAddress">Adresse</label>
                        <input type="text" id="inputAddress" name="address" value="<?= isset($address) ? $address : "" ?>">
                    </div>
                    <div class="form-item-group">
                        <label for="inputCity">Ville</label>
                        <input type="text" id="inputCity" name="city" value="<?= isset($city) ? $city : "" ?>">
                    </div>
                </div>

                <div class="form-group">

                    <div class="form-item-group">
                        <label for="inputpostcode">Code postal</label>
                        <input type="number" id="inputpostcode" name="postcode" value="<?= isset($postcode) ? $postcode : "" ?>">
                    </div>

                    <div class="form-item-group">
                        <label for="selectMessage">Pays</label>
                        <select name="state" id="selectState">
                            <option value="France" <?= (isset($state) && $state === "France") ? "selected" : "" ?>>France</option>
                            <option value="Belgique" <?= (isset($state) && $state === "Belgique") ? "selected" : "" ?>>Belgique</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-item-group">
                        <label for="inputpostcode">Téléphone *</label>
                        <input type="number" id="inputphone" name="phone" value="<?= isset($phone) ? $phone : "" ?>">
                    </div>
                    <div class="form-item-group">
                        <label for="inputVehicule">Véhicule(s)</label>
                        <input type="text" id="inputVehicule" name="vehicule" value="<?= isset($vehicule) ? $vehicule : "" ?>">
                    </div>
                </div>

                <p>* Champs obligatoires</p>

                <input type="submit" value="Créer votre compte">
            </div>
        </form>
    </div>
</div>

<?php
include("../templates/footer.php")
?>