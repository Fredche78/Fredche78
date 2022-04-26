<?php


if (!empty($_POST)) {
    // Le formulaire a été soumis
    $firstname = trim(strip_tags($_POST["firstname"])); // Ici firstname = au name dans le formulaire
    $lastname = trim(strip_tags($_POST["lastname"]));
    $email = trim(strip_tags($_POST["email"]));
    $phone = trim(strip_tags($_POST["phone"]));
    $vehicule = trim(strip_tags($_POST["vehicule"]));
    $city = trim(strip_tags($_POST["city"]));
    $question = trim(strip_tags($_POST["question"]));
    $photoOld = trim(strip_tags($_FILES["photo"]["name"]));
    $photoOld2 = trim(strip_tags($_FILES["photo2"]["name"]));
    $photoOld3 = trim(strip_tags($_FILES["photo3"]["name"]));
    // $photo = trim(strip_tags($_FILES["photo"]["name"]));
    // $photo2 = trim(strip_tags($_POST["photo2"]));
    // $photo3 = trim(strip_tags($_POST["photo3"]));
    $message = trim(strip_tags($_POST["message"]));

    // var_dump($photoOld);
    // var_dump($photoOld2);
    // var_dump($photoOld3);

    // var_dump($email);


    $tmpName = $_FILES["photo"]["tmp_name"];
    $name = $_FILES["photo"]["name"];
    $size = $_FILES["photo"]["size"];

    $tmpName2 = $_FILES["photo2"]["tmp_name"];
    $name2 = $_FILES["photo2"]["name"];
    $size2 = $_FILES["photo2"]["size"];

    $tmpName3 = $_FILES["photo3"]["tmp_name"];
    $name3 = $_FILES["photo3"]["name"];
    $size3 = $_FILES["photo3"]["size"];

    $uploadPath = "assets/img/photos/" . $name; // . $photo fonctionne aussi
    $uploadPath2 = "assets/img/photos/" . $name2; // . $photo fonctionne aussi
    $uploadPath3 = "assets/img/photos/" . $name3; // . $photo fonctionne aussi


    //Initialisation d'un tableau d'erreur
    $errors = [];
    $errorsFiles = $_FILES["photo"]["error"];
    // var_dump($errors);

    $tabExtension = explode(".", $name);
    $extension = strtolower(end($tabExtension));
    $allowedTypes = ["jpg", "png", "jpeg", "bmp"];
    // $allowedTypes = array("image/jpeg", "image/png", "image/jpg", "image/bmp");
    $maxSize = 900000;

    // Validation de l'email

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "L'email n'est pas valide";
    }

    // if ($maxSize<=$size) {
    //     $_FILES["photo"]["error"] = "Fichier trop volumineux";
    //     var_dump($errors["photo"]);
    // }

    /////////////////////////////////////////////////////////////////////////////////
    if (in_array($extension, $allowedTypes) && $size <= $maxSize && $errorsFiles == 0) {
        $uniqueName = uniqid("", true);
        $uniqueName2 = uniqid("", true);
        $uniqueName3 = uniqid("", true);

        $photo = $uniqueName . "." . $extension;
        $photo2 = $uniqueName2 . "." . $extension;
        $photo3 = $uniqueName3 . "." . $extension;

        move_uploaded_file($tmpName, $uploadPath);
        move_uploaded_file($tmpName2, $uploadPath2);
        move_uploaded_file($tmpName3, $uploadPath3);
        // $photoOld = trim(strip_tags($_FILES["photo"]["name"]));
        rename("assets/img/photos/$photoOld", "assets/img/photos/$photo");
        rename("assets/img/photos/$photoOld2", "assets/img/photos/$photo2");
        rename("assets/img/photos/$photoOld3", "assets/img/photos/$photo3");

        echo "Image enregistrée";
    } else {
        echo "Une erreur est survenue";

        if ($maxSize <= $size) {
            echo "Fichier trop volumineux";
        }
    }
    /////////////////////////////////////////////////////////////////////////////////

    // Validation de l'email
    // if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    //     $errors["email"] = "L'email n'est pas valide";
    // }

    //////////////////////////////////////////////////////////////////////////////////

    // Si pas d'erreur -> insertion de l'utilisateur en BDD
    if (empty($errors) && empty($errorsFiles)) {
        $db = new PDO("mysql:host=localhost;dbname=sbpolish", "root", "");

        $query = $db->prepare("INSERT INTO contacts (firstname, lastname, email, phone, vehicule, city, question, photo, photo2, photo3, message) VALUES (:firstname, :lastname, :email, :phone, :vehicule, :city, :question, :photo, :photo2, :photo3, :message)");

        $query->bindParam(":firstname", $firstname);
        $query->bindParam(":lastname", $lastname);
        $query->bindParam(":email", $email);
        $query->bindParam(":phone", $phone);
        $query->bindParam(":vehicule", $vehicule);
        $query->bindParam(":city", $city);
        $query->bindParam(":question", $question);
        $query->bindParam(":photo", $photo);
        $query->bindParam(":photo2", $photo2);
        $query->bindParam(":photo3", $photo3);
        $query->bindParam(":message", $message);

        if ($query->execute()) {
            // header("Location: contact.php");
            // echo "message envoyé";
            // sleep(5);
        } else {
            $message = "Erreur de bdd";
        }
    }
}
include("../templates/header.php")
?>

<div class="contact">

    <h1>Formulaire de contact</h1>

    <div class="form">
        <form action="" method="post" enctype="multipart/form-data">
            <!-- Lorsque l’on souhaite soumettre un formulaire avec un type file il faut rajouter l’attribut  enctype= »multipart/form-data » dans la balise form. -->
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
                        <label for="inputMail">E-mail *</label>
                        <input type="email" id="inputMail" name="email" value="<?= isset($email) ? $email : "" ?>" required>
                    </div>
                    <div class="form-item-group">
                        <label for="inputPhone">Téléphone *</label>
                        <input type="tel" id="inputPhone" name="phone" value="<?= isset($phone) ? $phone : "" ?>">
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-item-group">
                        <label for="inputVehicule">Véhicule(s)</label>
                        <input type="text" id="inputVehicule" name="vehicule" <?= isset($vehicule) ? $vehicule : "" ?>">
                    </div>
                    <div class="form-item-group">
                        <label for="inputCity">Ville</label>
                        <input type="text" id="inputCity" name="city" value="<?= isset($city) ? $city : "" ?>">
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-item-group">
                        <label for="selectQuestion">Votre demande *</label>
                        <select name="question" id="selectQuestion">
                            <option value="Devis" <?= (isset($question) && $question === "Devis") ? "selected" : "" ?>>Demander un devis</option>
                            <option value="Question" <?= (isset($question) && $question === "Question") ? "selected" : "" ?>>Poser une question</option>
                        </select>
                    </div>
                    <div class="form-item-group">
                        <label>Photo(s)</label>
                        <div class="form-photo">
                            <label for="inputPhoto">Photo 1</label>
                            <input type="file" id="inputPhoto" name="photo" accept=".png, .jepg, .jpg, .bmp" value="<?= isset($photo) ? $photo : "" ?>" style="display: none;">
                            <!--  multiple="multiple" -->
                            <label for="inputPhoto2">Photo 2</label>
                            <input type="file" id="inputPhoto2" name="photo2" accept=".png, .jepg, .jpg, .bmp" value="<?= isset($photo2) ? $photo2 : "" ?>" style="display: none;">
                            <label for="inputPhoto3">Photo 3</label>
                            <input type="file" id="inputPhoto3" name="photo3" accept=".png, .jepg, .jpg, .bmp" value="<?= isset($photo3) ? $photo3 : "" ?>" style="display: none;">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-item-group">
                        <label for="txtMsg">Message</label>
                        <textarea name="message" id="txtMsg" cols="167" rows="15" value="<?= isset($message) ? $message : "" ?>"></textarea>
                    </div>
                </div>

                <p>* Champs obligatoires</p>

                <input class="btn-submit" type="submit" value="Envoyer votre demande" />
            </div>
        </form>
    </div>

</div>


<?php
include("../templates/footer.php")
?>