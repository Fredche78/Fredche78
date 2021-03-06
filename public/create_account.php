<?php
$page="Création de compte";
$sessioncheck = "false";

if (!empty($_POST)) {
    // Le formulaire a été soumis
    $firstname = trim(strip_tags($_POST["firstname"]));
    $email = trim(strip_tags($_POST["email"]));
    $retypeEmail = trim(strip_tags($_POST["retypeEmail"]));
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
;
    $queryUsersMail = $db->query("SELECT email FROM users");
    $usersMail = $queryUsersMail->fetchAll();

    foreach ($usersMail as $userMail) {
        if ($userMail["email"] === $email) {
            $errors["emailBdd"] = "Un compte avec cet E-mail existe déjà";
        }
    }

    // Validation de l'email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "L'email n'est pas valide";
    }

    // Comparer les emails
    if ($email != $retypeEmail) {
        $errors["retypeEmail"] = "Les emails ne sont pas identiques";
    }

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

    $uppercase = preg_match("/[A-Z]/", $password);                     // début et fin d'expression régulère fait par /
    $lowercase = preg_match("/[a-z]/", $password);
    $number = preg_match("/[0-9]/", $password);
    $specialChar = preg_match("/[^a-zA-Z0-9]/", $password);
    $haveSpace = preg_match("/ /", $password);
    

    if (strlen($password) < 12 || !$uppercase || !$lowercase || !$number || !$specialChar || $haveSpace) {
        $errors["password"] = "Le mot de passe doit contenir au minimum 12 caractères, une majuscule, une minuscule, un caractère spécial et un chiffre";
    }

    // Si pas d'erreur -> insertion de l'utilisateur en BDD
    if (empty($errors)) {

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
                        <input type="text" id="inputFirstname" name="firstname" value="<?= isset($firstname) ? $firstname : "" ?>" required>
                    </div>
                    <div class="form-item-group">
                        <label for="inputLastname">Nom *</label>
                        <input type="text" id="inputLastname" name="lastname" value="<?= isset($lastname) ? $lastname : "" ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-item-group">
                        <label for="inputEmail">E-mail *</label>
                        <input type="email" id="inputEmail" name="email" value="<?= isset($email) ? $email : "" ?>" required>

                        <?php
                        if (isset($errors["email"])) {
                        ?>
                            <p class="errorsTxt"><?= $errors["email"] ?>
                            </p>
                        <?php
                        }
                        ?>
                        
                        <?php
                        if (isset($errors["emailBdd"])) {
                        ?>
                            <p class="errorsTxt"><?= $errors["emailBdd"] ?>
                            </p>
                        <?php
                        }
                        ?>

                    </div>

                    <div class="form-item-group">
                        <label for="inputRetypeEmail">Confirmer E-mail *</label>
                        <input type="email" name="retypeEmail" id="inputRetypeEmail" value="<?= isset($retypeEmail) ? $retypeEmail : "" ?>" required />

                        <?php
                        if (isset($errors["retypeEmail"])) {
                        ?>
                            <p class="errorsTxt"><?= $errors["retypeEmail"] ?>
                            </p>
                        <?php
                        }
                        ?>

                    </div>

                </div>

                <div class="form-group">
                    <div class="form-item-group">
                        <label for="inputPassword">Mot de passe *</label>
                        <input type="password" name="password" id="inputPassword" value="<?= isset($password) ? $password : "" ?>">

                        <?php
                        if (isset($errors["password"])) {
                        ?>
                            <p class="errorsTxt"><?= $errors["password"] ?>
                            </p>
                        <?php
                        }
                        ?>

                    </div>

                    <div class="form-item-group">
                        <label for="inputRetypePassword">Confirmer mot de passe *</label>
                        <input type="password" name="retypePassword" id="inputRetypePassword" value="<?= isset($retypePassword) ? $retypePassword : "" ?>">
                        <?php
                        if (isset($errors["retypePassword"])) {
                        ?>
                            <p class="errorsTxt"><?= $errors["retypePassword"] ?></p>
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
                        <input type="tel" id="inputphone" name="phone" value="<?= isset($phone) ? $phone : "" ?>" required>
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