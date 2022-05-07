<?php
include("../templates/header.php");

$db = new PDO("mysql:host=localhost;dbname=sbpolish", "root", "");

/////////////////////////Select////////////////////////////////////

$queryReviews = $db->query("SELECT * FROM reviews ORDER BY id DESC");
$reviews = $queryReviews->fetchAll();

$queryPhotos = $db->query("SELECT * FROM photos_cars ORDER BY id DESC");
$photos = $queryPhotos->fetchAll();

$queryServices = $db->query("SELECT type_services.type AS 'colonnes', 
GROUP_CONCAT(services.name SEPARATOR '<br>') AS 'services' 
FROM type_services
INNER JOIN type_services_link
ON type_services.id = type_services_link.type_services_id
INNER JOIN services
ON type_services_link.services_id = services.id
GROUP BY type_services.type;");
$services = $queryServices->fetchAll();

/////////////////////////Tableaux d'erreur////////////////////////////////

$errors = [];
$errorsReviews = [];

///////////////////////////INSERT INTO////////////////////////////////

if (!empty($_POST["submitReview"])) {

    $nameReview = trim(strip_tags($_POST["nameReview"]));
    $clientReview = trim(strip_tags($_POST["clientReview"]));

    if (empty($nameReview)) {
        $errorsReviews["nameReview"] = "Le nom ou pseudo du client est obligatoire";
    }

    if (empty($clientReview)) {
        $errorsReviews["clientReview"] = "Le message de l'avis est obligatoire";
    }

    if (empty($errorsReviews)) {

        $addReview = $db->prepare("INSERT INTO reviews (client, review) VALUES (:nameReview, :clientReview)");
        $addReview->bindParam(":nameReview", $nameReview);
        $addReview->bindParam(":clientReview", $clientReview);

        if ($addReview->execute()) {
            header("Location: home_admin.php#reviewsView");
        }
    }
}

if (!empty($_POST["submitPhotosCars"])) {

    // $errorsWorks = [];

    $photoOld = trim(strip_tags($_FILES["imgBefore"]["name"]));
    $photoOld2 = trim(strip_tags($_FILES["imgAfter"]["name"]));
    $txtBefore = trim(strip_tags($_POST["txtBefore"]));
    $txtAfter = trim(strip_tags($_POST["txtAfter"]));

    $tmpName = $_FILES["imgBefore"]["tmp_name"];
    $tmpName2 = $_FILES["imgAfter"]["tmp_name"];
    $name = $_FILES["imgBefore"]["name"];
    $name2 = $_FILES["imgAfter"]["name"];
    $size = $_FILES["imgBefore"]["size"];
    $size2 = $_FILES["imgAfter"]["size"];

    $uploadPath = "assets/img/photos/travaux/" . $name; // . $photo fonctionne aussi
    $uploadPath2 = "assets/img/photos/travaux/" . $name2; // . $photo fonctionne aussi

    $errorsWorks = [];
    $errorsFiles[1] = $_FILES["imgBefore"]["error"];
    $errorsFiles[2] = $_FILES["imgAfter"]["error"];

    $tabExtension1 = explode(".", $name);
    $tabExtension2 = explode(".", $name2);
    $extension1 = strtolower(end($tabExtension1));
    $extension2 = strtolower(end($tabExtension2));
    $allowedTypes = ["jpg", "png", "jpeg", "bmp"];
    $maxSize = 2000000;

    // if (empty($imgBefore)) {
    //     $errorsWorks["photoOld"] = " La photo avant travaux est obligatoire ";
    //     // var_dump($errorsReviews);
    // }

    // if (empty($imgAfter)) {
    //     $errorsWorks["imgAfter"] = " La photo après travaux est obligatoire ";
    //     // var_dump($errorsReviews);
    // }

    // $errorsFiles[$i] = $_FILES["imgAfter"]["error"];
    // $errorsFiles[$i] = $_FILES["imgBefore"]["error"];
    $errorsFiles[1] = $_FILES["imgAfter"]["error"];
    $errorsFiles[2] = $_FILES["imgBefore"]["error"];

    $photoOld1 = trim(strip_tags($_FILES["imgBefore"]["name"]));
    $photoOld2 = trim(strip_tags($_FILES["imgAfter"]["name"]));
    $txtBefore = trim(strip_tags($_POST["txtBefore"]));
    $txtAfter = trim(strip_tags($_POST["txtAfter"]));

    $name1 = $_FILES["imgBefore"]["name"];
    $name2 = $_FILES["imgAfter"]["name"];
    $tmpName1 = $_FILES["imgBefore"]["tmp_name"];
    $tmpName2 = $_FILES["imgAfter"]["tmp_name"];
    $size1 = $_FILES["imgBefore"]["size"];
    $size2 = $_FILES["imgAfter"]["size"];

    $uploadPath1 = "assets/img/photos/travaux/" . $name1; // . $photo fonctionne aussi
    $uploadPath2 = "assets/img/photos/travaux/" . $name2; // . $photo fonctionne aussi

    $tabExtension1 = explode(".", $name1);
    $tabExtension2 = explode(".", $name2);
    $extension1 = strtolower(end($tabExtension1));
    $extension2 = strtolower(end($tabExtension2));
    $allowedTypes = ["jpg", "png", "jpeg", "bmp"];
    $maxSize = 2000000;

    if (in_array($extension1, $allowedTypes) && $size1 <= $maxSize && $errorsFiles == 0) {

        $uniqueName1 = md5(time() . $name1);
        $uniqueName2 = md5(time() . $name2);
        // $uniqueName2 = md5($name2);

        $imgBefore = $uniqueName1 . "." . $extension1;
        $imgAfter = $uniqueName2 . "." . $extension2;

        // move_uploaded_file($tmpName[$i], $uploadPath[$i]);
        move_uploaded_file($tmpName1, $uploadPath1);
        move_uploaded_file($tmpName2, $uploadPath2);

        rename("assets/img/photos/travaux/$photoOld1", "assets/img/photos/travaux/$imgBefore");
        rename("assets/img/photos/travaux/$photoOld2", "assets/img/photos/travaux/$imgAfter");

        // var_dump($imgBefore);

        echo "Image enregistrée";
    } else {

        // if ($maxSize <= $size[$i]) {
        //     $errors["weight"][$i] = "Maximum 2Mo";
        // } else {
        //     $errors["files"][$i] = "Une erreur est survenue";
        // }
    }
    // }

    // $photoOld = trim(strip_tags($_FILES["imgBefore"]["name"]));
    // $txtBefore = trim(strip_tags($_POST["txtBefore"]));
    // $photoOld2 = trim(strip_tags($_FILES["imgAfter"]["name"]));
    // $txtAfter = trim(strip_tags($_POST["txtAfter"]));

    // $tmpName = $_FILES["imgBefore"]["tmp_name"];
    // $name = $_FILES["imgBefore"]["name"];
    // $size = $_FILES["imgBefore"]["size"];

    // $tmpName2 = $_FILES["imgAfter"]["tmp_name"];
    // $name2 = $_FILES["imgAfter"]["name"];
    // $size2 = $_FILES["imgAfter"]["size"];

    // $uploadPath = "assets/img/photos/travaux/" . $name; // . $photo fonctionne aussi
    // $uploadPath2 = "assets/img/photos/travaux/" . $name2; // . $photo fonctionne aussi

    // $errorsWorks = [];
    // $errorsFiles = $_FILES["imgAfter"]["error"];

    // $tabExtension = explode(".", $name);
    // $extension = strtolower(end($tabExtension));
    // $allowedTypes = ["jpg", "png", "jpeg", "bmp"];
    // $maxSize = 2000000;

    // if (empty($imgBefore)) {
    //     $errorsWorks["photoOld"] = " La photo avant travaux est obligatoire ";
    //     // var_dump($errorsReviews);
    // }

    // if (empty($imgAfter)) {
    //     $errorsWorks["imgAfter"] = " La photo après travaux est obligatoire ";
    //     // var_dump($errorsReviews);
    // }

    if (empty($errors) && empty($errorsFiles)) {

        $addWork = $db->prepare("INSERT INTO photos_cars (txt_before, img_before, txt_after, img_after) VALUES (:txtBefore, :imgBefore, :txtAfter, :imgAfter)");
        $addWork->bindParam(":txtBefore", $txtBefore);
        $addWork->bindParam(":imgBefore", $imgBefore);
        $addWork->bindParam(":txtAfter", $txtAfter);
        $addWork->bindParam(":imgAfter", $imgAfter);

        if ($addWork->execute()) {
            //////////////////////////////Se positionne sur l'ID//////////////////////////
            header("Location: home_admin.php#photosView");
            // var_dump($imgBefore);
        } else {
            $errors["message"] = "Erreur de bdd";
            // $message = "Erreur de bdd";
        }
    }
}


////////////////////////// DELETES ////////////////////////////////////////////

if (isset($_POST["deleteReview"])) {

    $delete = $_POST["deleteReview"];
    $supReview = $db->prepare("DELETE FROM reviews WHERE id= :id");
    $supReview->bindParam(":id", $delete);

    if ($supReview->execute()) {
        header("Location: home_admin.php#reviewsView");
    } else {
        $message = "Erreur de bdd";
    }
}

if (isset($_POST["deleteWork"])) {

    $delete = $_POST["deleteWork"];
    $supWork = $db->prepare("DELETE FROM photos_cars WHERE id= :id");
    $supWork->bindParam(":id", $delete);

    if ($supWork->execute()) {

        unlink("assets/img/photos/travaux/" . $imgBefore);
        unlink("assets/img/photos/travaux/" . $imgAfter);

        header("Location: home_admin.php#photosView");
    } else {
        $message = "Erreur de bdd";
    }
}

?>

<!-- ////////////////////////////////////////HTML/////////////////////////////////////////////////////////////////////////////////// -->

<div class="backoffice">

    <div class="nav">
        <a href="prices.php">Prix</a>
        <a href="request.php">Demandes</a>
    </div>

    <div class="administration">

        <div class="servicesAdmin">

            <h2>Services</h2>

            <div class="services">

                <!-- <h2>Services</h2> -->

                <?php
                foreach ($services as $service) {
                ?>
                    <div class="servicesView">
                        <h3><?= $service["colonnes"] ?></h3>
                        <hr>
                        <div class="listServices">
                            <?= $service["services"] ?>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>

            <div class="addServices">

                <form action="" method="post">

                    <div class="form-admin-group">

                        <div class="form-admin-item">

                            <label for="selectColonneService">Type de service

                            </label>

                            <select name="columnService" id="selectColonneService">
                                <option value="1" <?= (isset($columnService) && $columnService === "Extérieur") ? "selected" : "" ?>>Intérieur</option>
                                <option value="2" <?= (isset($columnService) && $columnService === "Intérieur") ? "selected" : "" ?>>Extérieur</option>
                                <option value="3" <?= (isset($columnService) && $columnService === "Options") ? "selected" : "" ?>>Options et services annexes</option>
                            </select>

<!-- //////////////////////////////////////////Code à vérifier///////////////////////////////////////// -->

                            <div class="errors">
                            <?php
                                if (isset($errorsReviews["clientReview"])) {
                            ?>
                                <p>
                                    <span class="info-error"><?= $errorsReviews["clientReview"] ?>
                                    </span>
                                </p>
                            <?php
                                }
                            ?>
                            </div>
<!-- /////////////////////////////////////////////////////////////////////////////////////////////////////// -->
                        </div>

                        <div class="form-admin-item">

                            <label for="inputService">Nom du service *
                            </label>

                            <input type="text" id="inputService" name="nameService" value="<?= isset($nameService) ? $nameService : "" ?>" />

<!-- //////////////////////////////////////////Code à vérifier///////////////////////////////////////// -->

                            <div class="errors">
                            <?php
                                if (isset($errorsServices["nameServices"])) {
                            ?>
                                <p>
                                    <span class="info-error"><?= $errorsServices["nameServices"] ?>
                                    </span>
                                </p>
                            <?php
                                }
                            ?>
                            </div>
<!-- /////////////////////////////////////////////////////////////////////////////////////////////////////// -->
                        </div>

                        <input class="btn-submit" type="submit" name="submitService" value="Ajouter le service" />
                    </div>
                </form>
            </div>
        </div>

        <div class="reviewsAdmin" id="reviewsView">

            <h2>Avis clients</h2>

            <div class="slideReviews">

                <div class="splide" id="splideReviewsAdmin" role="group" aria-label="Splide Basic HTML Example">

                    <div class="splide__track">
                        
                        <div class="splide__list">

                            <?php
                            foreach ($reviews as $review) {
                            ?>
                                <div class="splide__slide">

                                    <?= $review["client"] . " - " . $review["review"] ?>

                                    <div class="deleteReview">

                                        <form action="" method="post">
                                            <button class="btn-delete" name="deleteReview" type="submit" value="<?= $review['id'] ?>">X</button>
                                        </form>
                                        
                                    </div>

                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="addReviews">

                <form action="" method="post">

                    <div class="form-admin-group">

                        <div class="form-admin-item">

                            <label for="inputNameReview">Nom *</label>
                            <input type="text" id="inputNameReview" name="nameReview" value="<?= isset($nameReview) ? $nameReview : "" ?>">

                            <div class="errors">
                                <?php
                                if (isset($errorsReviews["nameReview"])) {
                                ?>
                                    <p class="errorsTxt"><?= $errorsReviews["nameReview"] ?></p>
                                <?php
                                }
                                ?>
                            </div>

                        </div>
                        <div class="form-admin-item">

                            <label for="inputReview">Avis *</label>
                            <textarea name="clientReview" id="txtReview" rows="1" value="<?= isset($clientReview) ? $clientReview : "" ?>"></textarea>

                            <div class="errors">
                                <?php
                                if (isset($errorsReviews["clientReview"])) {
                                ?>
                                    <p class="errorsTxt"><?= $errorsReviews["clientReview"] ?></p>
                                <?php
                                }
                                ?>
                            </div>

                        </div>

                        <input class="btn-submit" type="submit" name="submitReview" value="Ajouter l'avis" />
                    </div>
                </form>
            </div>
        </div>

        <div class="photosVehicules" id="photosView">

            <div class="pictures">

                <?php
                    foreach ($photos as $photo) {
                ?>
                    <div class="picturesView">

                        <div class="before">

                            <h2>Avant</h2>

                            <div class="imgBefore">

                                <img src="assets/img/photos/travaux/<?= $photo["img_before"] ?>" alt="Avant nettoyage">

                                <?php
                                    if (!empty($photo["txt_before"])) {
                                ?>
                                    <div class="txtBefore">

                                        <p>
                                            <?= $photo["txt_before"] ?>
                                        </p>

                                    </div>
                                <?php
                                    }
                                ?>

                            </div>

                        </div>
                        <div class="after">

                            <h2>Après</h2>

                            <div class="imgAfter">

                                <img src="assets/img/photos/travaux/<?= $data["img_after"] ?>" alt="Après nettoyage">

                                <?php
                                    if (!empty($data["txt_after"])) {
                                ?>
                                    <div class="txtAfter">

                                        <p>
                                            <?= $data["txt_after"] ?>
                                        </p>

                                    </div>
                                <?php
                                    }
                                ?>

                            </div>
                        </div>
                        <div class="deleteWork">
                            <form action="" method="post">
                                <button class="btn-delete" name="deleteWork" type="submit" value="<?= $data['id'] ?>">X
                                </button>
                            </form>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
            <div class="addWorks">

                <form action="" method="post" enctype="multipart/form-data">

                    <div class="form-group">

                        <div class="form-admin-group">

                            <div class="form-admin-item">
                                <label for="inputTxtBefore">Texte 1ère image
                                </label>
                                <input type="text" id="inputTxtBefore" name="txtBefore" value="<?= isset($txtBefore) ? $txtBefore : "" ?>" />
                            </div>

                            <div class="form-admin-item">
                                <label for="inputImgBefore">Photo avant</label>
                                <input type="file" id="inputImgBefore" name="imgBefore" accept=".png, .jpeg, .jpg, .bmp" value="<?= isset($imgBefore) ? $imgBefore : "" ?>">
                            </div>

                        </div>

                        <div class="form-admin-group">

                            <div class="form-admin-item">
                                <label for="inputTxtAfter">Texte 2ème image</label>
                                <input type="text" id="inputTxtAfter" name="txtAfter" value="<?= isset($txtAfter) ? $txtAfter : "" ?>">
                            </div>

                            <div class="form-admin-item">
                                <label for="inputImgAfter">Photo après</label>
                                <input type="file" id="inputImgAfter" name="imgAfter" accept=".png, .jpeg, .jpg, .bmp" value="<?= isset($imgAfter) ? $imgAfter : "" ?>">
                            </div>

                        </div>
                    </div>

                    <input class="btn-submit" type="submit" name="submitPhotosCars" value="Ajouter les photos" />

                </form>
            </div>
        </div>
    </div>
</div>

<!-- if (!empty($_POST["submitPhotosCars"])) {

// $errorsWorks = [];

for ($i = 1; $i < 3; $i++) {

    // $errorsFiles[$i] = $_FILES["imgAfter"]["error"];
    // $errorsFiles[$i] = $_FILES["imgBefore"]["error"];
    $errorsFiles[$i] = $_FILES["imgAfter"]["error"];
    $errorsFiles[$i] = $_FILES["imgBefore"]["error"];

    $photoOldBefore = trim(strip_tags($_FILES["imgBefore"]["name"]));
    $photoOldAfter = trim(strip_tags($_FILES["imgAfter"]["name"]));
    $txtBefore = trim(strip_tags($_POST["txtBefore"]));
    $txtAfter = trim(strip_tags($_POST["txtAfter"]));

    $name[$i] = $_FILES["imgBefore"]["name"];
    $tmpName[$i] = $_FILES["imgBefore"]["tmp_name"];
    $size[$i] = $_FILES["imgBefore"]["size"];

    $uploadPath[$i] = "assets/img/photos/travaux/" . $name[$i]; // . $photo fonctionne aussi

    $tabExtension[$i] = explode(".", $name[$i]);
    $extension[$i] = strtolower(end($tabExtension[$i]));
    $allowedTypes = ["jpg", "png", "jpeg", "bmp"];
    $maxSize = 2000000;

    if (in_array($extension[$i], $allowedTypes) && $size[$i] <= $maxSize && $errorsFiles == 0) {

        $uniqueName[$i] = md5(time() . $name[$i]);
        // $uniqueName2 = md5($name2);

        $imgBefore = $uniqueName[$i] . "." . $extension[$i];
        $imgAfter = $uniqueName[$i] . "." . $extension[$i];

        move_uploaded_file($tmpName[$i], $uploadPath[$i]);
        // move_uploaded_file($tmpName2, $uploadPath2);

        rename("assets/img/photos/travaux/$photoOldBefore", "assets/img/photos/travaux/$imgBefore");
        rename("assets/img/photos/travaux/$photoOldAfter", "assets/img/photos/travaux/$imgAfter");

        // var_dump($imgBefore);

        echo "Image enregistrée";
    } else {

        if ($maxSize <= $size[$i]) {
            $errors["weight"][$i] = "Maximum 2Mo";
        } else {
            $errors["files"][$i] = "Une erreur est survenue"; -->

<?php
include("../templates/footer.php")
?>

