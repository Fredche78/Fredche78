<?php
session_start();
$page = "Contact";
include("../templates/header.php");
require_once '../system/config.php';

//Initialisation d'un tableau d'erreur
$errors = [];
$confirme = "";

/* Récupération des informations de l'utilisateur connecté pour les afficher dans les placeholders */

if (isset($_SESSION['email'])) {
    $emailLog = trim(strip_tags($_SESSION['email']));

    // $db = new PDO("mysql:host=localhost;dbname=sbpolish", "root", "");

    $queryLog = $db->prepare("SELECT * FROM users WHERE email =  :email");
    $queryLog->BindParam(":email", $emailLog);
    $queryLog->execute();
    $userLog = $queryLog->fetch(PDO::FETCH_ASSOC);
}

if (!empty($_POST)) {
    // Le formulaire a été soumis
    $firstname = trim(strip_tags($_POST["firstname"])); // Ici firstname = au name dans le formulaire
    $lastname = trim(strip_tags($_POST["lastname"]));
    $email = trim(strip_tags($_POST["email"]));
    $phone = trim(strip_tags($_POST["phone"]));
    $vehicule = trim(strip_tags($_POST["vehicule"]));
    $city = trim(strip_tags($_POST["city"]));
    $question = trim(strip_tags($_POST["question"]));
    $message = trim(strip_tags($_POST["message"]));

    for ($i = 1; $i < 4; $i++) {

        /////////////////////////// Vérifier si ce if fonctionne/////////////////
        if (!empty($_FILES["photo" . $i]["name"])) {

            $photoOld[$i] = trim(strip_tags($_FILES["photo" . $i]["name"]));
            $tmpName[$i] = $_FILES["photo" . $i]["tmp_name"];
            $name[$i] = $_FILES["photo" . $i]["name"];
            $size[$i] = $_FILES["photo" . $i]["size"];
            $uploadPath[$i] = "assets/img/photos/devis/" . $name[$i];
            $errorsFiles = $_FILES["photo" . $i]["error"];
            $tabExtension[$i] = explode(".", $name[$i]);
            $extension[$i] = strtolower(end($tabExtension[$i]));
            $allowedTypes = ["jpg", "png", "jpeg", "bmp"];
            $maxSize = 2000000;

            if (in_array($extension[$i], $allowedTypes) && $size[$i] < $maxSize && $errorsFiles == 0) {

                $uniqueName[$i] = md5(time() . $name[$i]);
                $photo[$i] = $uniqueName[$i] . "." . $extension[$i];

                move_uploaded_file($tmpName[$i], $uploadPath[$i]);
                rename("assets/img/photos/devis/$photoOld[$i]", "assets/img/photos/devis/$photo[$i]");

                ////////////////////////////////La gestion des erreurs d'images/////////////////////////////
            } else {

                if ($maxSize <= $size[$i]) {
                    $errors["weight"][$i] = "Maximum 2Mo";
                } else {
                    $errors["files"][$i] = "Une erreur est survenue";
                }
            }
        }
    }

    ////////////////////////////La gestion des erreurs textes///////////////////////////////

    // Validation de l'email

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "L'email n'est pas valide";
    }

    // Validation du prénom

    if (empty($firstname)) {
        $errors["firstname"] = "Prénom requis";
    }

    // Validation du Nom

    if (empty($lastname)) {
        $errors["lastname"] = "Nom requis";
    }

    // Validation du numéro de téléphone

    if (empty($phone)) {
        $errors["phone"] = "Numéro de téléphone requis";
    }

    /////////////////////////////////////INSERT INTO/////////////////////////////////////////////

    // Si pas d'erreur -> insertion de l'utilisateur en BDD
    if (empty($errors) && empty($errorsFiles)) {
        // $db = new PDO("mysql:host=localhost;dbname=sbpolish", "root", "");

        $query = $db->prepare("INSERT INTO contacts (firstname, lastname, email, phone, vehicule, city, question, photo, photo2, photo3, message) VALUES (:firstname, :lastname, :email, :phone, :vehicule, :city, :question, :photo1, :photo2, :photo3, :message)");

        $query->bindParam(":firstname", $firstname);
        $query->bindParam(":lastname", $lastname);
        $query->bindParam(":email", $email);
        $query->bindParam(":phone", $phone);
        $query->bindParam(":vehicule", $vehicule);
        $query->bindParam(":city", $city);
        $query->bindParam(":question", $question);
        $query->bindParam(":photo1", $photo[1]);
        $query->bindParam(":photo2", $photo[2]);
        $query->bindParam(":photo3", $photo[3]);
        $query->bindParam(":message", $message);

        if ($query->execute()) {

            $confirme = "Votre demande a bien été enregistrée";
        } else {
            $errors["db"] = "Une erreur est survenue. Veuillez réessayer.";
        }
    }
}
?>

<!-- //////////////////////////////////HTML////////////////////////////////////// -->

<div class="contact">

    <?php
    if (empty($confirme)) {
    ?>

        <h1>Formulaire de contact</h1>

        <?php
        if (isset($errors["db"])) {
        ?>
            <h2><?= $errors["db"] ?>
            </h2>
        <?php
        }
        ?>

        <div class="form">
            <form action="" method="post" enctype="multipart/form-data">
                <!-- Lorsque l’on souhaite soumettre un formulaire avec un type file il faut rajouter l’attribut  enctype= »multipart/form-data » dans la balise form. -->
                <div class="container">
                    <div class="form-group">
                        <div class="form-item-group">
                            <label for="inputFirstname">Prénom *</label>

                            <?php
                            if (isset($_SESSION["email"])) {
                            ?>
                                <input type="text" id="inputFirstname" name="firstname" value="<?= isset($userLog["firstname"]) ? $userLog["firstname"] : "" ?>">
                            <?php
                            } else {
                            ?>
                                <input type="text" id="inputFirstname" name="firstname" value="<?= isset($firstname) ? $firstname : "" ?>">
                            <?php
                            }
                            if (isset($errors["firstname"])) {
                            ?>
                                <p class="errorsTxt"><?= $errors["firstname"] ?>
                                </p>
                            <?php
                            }
                            ?>
                        </div>
                        <div class="form-item-group">
                            <label for="inputLastname">Nom *</label>

                            <?php
                            if (isset($_SESSION["email"])) {
                            ?>
                                <input type="text" id="inputLastname" name="lastname" value="<?= isset($userLog["lastname"]) ? $userLog["lastname"] : "" ?>">
                            <?php
                            } else {
                            ?>
                                <input type="text" id="inputLastname" name="lastname" value="<?= isset($lastname) ? $lastname : "" ?>">
                            <?php
                            }
                            if (isset($errors["lastname"])) {
                            ?>
                                <p class="errorsTxt"><?= $errors["lastname"] ?>
                                </p>
                            <?php
                            }
                            ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-item-group">
                            <label for="inputMail">E-mail *</label>

                            <?php
                            if (isset($_SESSION["email"])) {
                            ?>
                                <input type="email" id="inputMail" name="email" value="<?= isset($userLog["email"]) ? $userLog["email"] : "" ?>">
                            <?php
                            } else {
                            ?>
                                <input type="email" id="inputMail" name="email" value="<?= isset($email) ? $email : "" ?>">
                            <?php
                            }
                            if (isset($errors["email"])) {
                            ?>
                                <p class="errorsTxt"><?= $errors["email"] ?>
                                </p>
                            <?php
                            }
                            ?>
                        </div>
                        <div class="form-item-group">
                            <label for="inputPhone">Téléphone *</label>

                            <?php
                            if (isset($_SESSION["email"])) {
                            ?>
                                <input type="tel" id="inputPhone" name="phone" value="<?= isset($userLog["phone"]) ? $userLog["phone"] : "" ?>">
                            <?php
                            } else {
                            ?>
                                <input type="tel" id="inputPhone" name="phone" value="<?= isset($phone) ? $phone : "" ?>">
                            <?php
                            }
                            if (isset($errors["phone"])) {
                            ?>
                                <p class="errorsTxt"><?= $errors["phone"] ?>
                                </p>
                            <?php
                            }
                            ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-item-group">
                            <label for="inputVehicule">Véhicule(s)</label>

                            <?php
                            if (isset($_SESSION["email"])) {
                            ?>
                                <input type="text" id="inputVehicule" name="vehicule" value="<?= isset($userLog["vehicule"]) ? $userLog["vehicule"] : "" ?>" required>
                            <?php
                            } else {
                            ?>
                                <input type="text" id="inputVehicule" name="vehicule" <?= isset($vehicule) ? $vehicule : "" ?>">
                            <?php
                            }
                            ?>
                        </div>
                        <div class="form-item-group">
                            <label for="inputCity">Ville</label>

                            <?php
                            if (isset($_SESSION["email"])) {
                            ?>
                                <input type="text" id="inputCity" name="city" value="<?= isset($userLog["city"]) ? $userLog["city"] : "" ?>" required>
                            <?php
                            } else {
                            ?>
                                <input type="text" id="inputCity" name="city" value="<?= isset($city) ? $city : "" ?>">
                            <?php
                            }
                            ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-item-group">
                            <label for="selectQuestion">Votre demande</label>
                            <select name="question" id="selectQuestion">
                                <option value="Devis" <?= (isset($question) && $question === "Devis") ? "selected" : "" ?>>Demander un devis</option>
                                <option value="Question" <?= (isset($question) && $question === "Question") ? "selected" : "" ?>>Poser une question</option>
                            </select>
                        </div>
                        <div class="form-item-group">
                            <label>Photo(s)</label>
                            <div class="form-photo">
                                <label for="inputPhoto">Photo 1</label>
                                <input type="file" id="inputPhoto" name="photo1" accept=".png, .jepg, .jpg, .bmp" style="display: none;">
                                <label for="inputPhoto2">Photo 2</label>
                                <input type="file" id="inputPhoto2" name="photo2" accept=".png, .jepg, .jpg, .bmp" style="display: none;">
                                <label for="inputPhoto3">Photo 3</label>
                                <input type="file" id="inputPhoto3" name="photo3" accept=".png, .jepg, .jpg, .bmp" style="display: none;">
                            </div>

                            <div class="warningFiles">

                                <?php
                                for ($i = 1; $i < 4; $i++) {
                                ?>
                                    <div class="warning">

                                        <?php
                                        if (isset($errors["files"][$i])) {
                                        ?>
                                            <p class="errorsTxt"><?= $errors["files"][$i] ?>
                                            </p>
                                        <?php
                                        }
                                        ?>

                                    </div>
                                    <div class="warning">

                                        <?php
                                        if (isset($errors["weight"][$i])) {
                                        ?>
                                            <p class="errorsTxt"><?= $errors["weight"][$i] ?>
                                            </p>
                                        <?php
                                        }
                                        ?>

                                    </div>
                                <?php
                                }
                                ?>

                            </div>


                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-item-area">
                            <label for="txtMsg">Message</label>
                            <textarea name="message" id="txtMsg" rows="15" value="<?= isset($message) ? $message : "" ?>"></textarea>
                        </div>
                    </div>

                    <p>* Champs obligatoires</p>

                    <input class="btn-submit" type="submit" value="Envoyer votre demande" />
                </div>
            </form>
        </div>
    <?php
    } else {
    ?>
        <h1><?= $confirme ?></h1>

        <h2>Nous vous répondrons dans les meilleurs délais</h2>

        <div class="btn">
            <a href="./">Retour à l'accueil
            </a>
        </div>
    <?php
    }
    ?>
</div>

<?php
include("../templates/footer.php")
?>