<?php
$page = "Page Administrateur";
$sessioncheck = "true";

include("../templates/header.php");
require_once("../system/config.php");

if ($_SESSION["role"] != "administrateur") {
    session_destroy();
    header("Location: login.php");
}

// $db : vient de la classe "private" dans la config

/////////////////////////////////////SELECT////////////////////////////////////

$queryReviews = $db->query("SELECT * FROM reviews ORDER BY id DESC LIMIT 10");
$reviews = $queryReviews->fetchAll();

$queryPhotos = $db->query("SELECT * FROM photos_cars ORDER BY id DESC LIMIT 10");
$photos = $queryPhotos->fetchAll();

$queryServices = $db->query("SELECT type_services.type AS 'type', GROUP_CONCAT(services.id, ' - ', services.name ORDER BY services.id SEPARATOR '<br>') AS 'listes' FROM type_services INNER JOIN services ON type_services.id = services.service_type GROUP BY type_services.type ORDER BY type_services.id ASC");
$services = $queryServices->fetchAll(PDO::FETCH_ASSOC);

////////////////////////////////TABLEAU D'ERREUR////////////////////////////////////

$errors = [];
$errorsReviews = [];

///////////////////////////////////INSERT INTO/////////////////////////////////////

if (!empty($_POST["submitService"])) {

    $nameService = trim(strip_tags($_POST["nameService"]));
    $columnService = trim(strip_tags($_POST["columnService"]));

    if (empty($nameService)) {
        $errorsServices["nameService"] = " Le service doit être complété ";
    }

    if (empty($columnService)) {
        $errorsServices["columnService"] = "Le type de service est obligatoire";
    }

    if (empty($errorsServices)) {

        $addService = $db->prepare("INSERT INTO services (name, service_type) VALUES (:nameService, :columnService)");
        $addService->bindParam(":nameService", $nameService);
        $addService->bindParam(":columnService", $columnService, PDO::PARAM_INT);

        if ($addService->execute()) {
            header("Location: home_admin.php#administration");
        }
    }
}

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

if (!empty($_POST['submitPhotosCars'])) {

    $photoOld = trim(strip_tags($_FILES["imgBefore"]["name"]));
    $txtBefore = trim(strip_tags($_POST["txtBefore"]));
    $photoOld2 = trim(strip_tags($_FILES["imgAfter"]["name"]));
    $txtAfter = trim(strip_tags($_POST["txtAfter"]));

    $tmpName = $_FILES["imgBefore"]["tmp_name"];
    $name = $_FILES["imgBefore"]["name"];
    $size = $_FILES["imgBefore"]["size"];

    $tmpName2 = $_FILES["imgAfter"]["tmp_name"];
    $name2 = $_FILES["imgAfter"]["name"];
    $size2 = $_FILES["imgAfter"]["size"];

    $uploadPath = "assets/img/photos/travaux/" . $name;
    $uploadPath2 = "assets/img/photos/travaux/" . $name2;

    $errorsWorks = [];
    $errorsFiles = $_FILES["imgAfter"]["error"];

    $tabExtension = explode(".", $name);
    $extension = strtolower(end($tabExtension));

    $tabExtension2 = explode(".", $name2);
    $extension2 = strtolower(end($tabExtension2));

    $allowedTypes = ["jpg", "png", "jpeg", "bmp"];
    $maxSize = 5000000;

    if (in_array($extension, $allowedTypes) && in_array($extension2, $allowedTypes) && $size <= $maxSize && $size2 <= $maxSize) {

        $uniqueName = md5(time() . $name);
        $uniqueName2 = md5(time() . $name2);

        $imgBefore = $uniqueName . ".webp";
        $imgAfter = $uniqueName2 . ".webp";

        move_uploaded_file($tmpName, $uploadPath);
        move_uploaded_file($tmpName2, $uploadPath2);

        rename("assets/img/photos/travaux/$photoOld", "assets/img/photos/travaux/$imgBefore");
        rename("assets/img/photos/travaux/$photoOld2", "assets/img/photos/travaux/$imgAfter");

        if ($extension === "jpg" || $extension === "jpeg") {

            $img = imagecreatefromjpeg("assets/img/photos/travaux/$imgBefore");
            imagepalettetotruecolor($img);
            imagewebp($img, "assets/img/photos/travaux/$imgBefore", 80);

        } else if ($extension === "png") {

            $img = imagecreatefrompng("assets/img/photos/travaux/$imgBefore");
            imagepalettetotruecolor($img);
            imagealphablending($img, true);
            imagesavealpha($img, true);
            imagewebp($img, "assets/img/photos/travaux/$imgBefore", 80);

        } else if ($extension === "bmp") {

            $img = imagecreatefrombmp("assets/img/photos/travaux/$imgBefore");
            imagepalettetotruecolor($img);
            imagewebp($img, "assets/img/photos/travaux/$imgBefore", 80);
        }

        if ($extension2 === "jpg" || $extension2 === "jpeg") {

            $img2 = imagecreatefromjpeg("assets/img/photos/travaux/$imgAfter");
            imagepalettetotruecolor($img2);
            imagewebp($img2, "assets/img/photos/travaux/$imgAfter", 80);

        } else if ($extension2 === "png") {

            $img2 = imagecreatefrompng("assets/img/photos/travaux/$imgAfter");
            imagepalettetotruecolor($img2);
            imagealphablending($img2, true);
            imagesavealpha($img2, true);
            imagewebp($img2, "assets/img/photos/travaux/$imgAfter", 80);

        } else if ($extension2 === "bmp") {

            $img2 = imagecreatefrombmp("assets/img/photos/travaux/$imgAfter");
            imagepalettetotruecolor($img2);
            imagewebp($img2, "assets/img/photos/travaux/$imgAfter", 80);
        }

        // echo "Image enregistrée";
    } else {
        // echo "Une erreur est survenue";

        if ($maxSize <= $size || $maxSize <= $size2) {

            echo "Fichier trop volumineux";

        } else {

            $errors["imgBefore"] = "Une erreur est survenue";
            $errors["imgAfter"] = "Une erreur est survenue";

        }
    }


    if (empty($errors) && empty($errorsFiles)) {

        $addWork = $db->prepare("INSERT INTO photos_cars (txt_before, img_before, txt_after, img_after) VALUES (:txtBefore, :imgBefore, :txtAfter, :imgAfter)");
        $addWork->bindParam(":txtBefore", $txtBefore);
        $addWork->bindParam(":imgBefore", $imgBefore);
        $addWork->bindParam(":txtAfter", $txtAfter);
        $addWork->bindParam(":imgAfter", $imgAfter);

        if ($addWork->execute()) {

            //////////////////* Se positionne sur l'ID */
            header("Location: home_admin.php#photosView");
        } else {

            $errors["message"] = "Erreur de bdd";
        }
    }
}

////////////////////////////////////// DELETES ////////////////////////////////////////

if (!empty($_POST["deleteServices"])) {

    $idService = trim(strip_tags($_POST["idService"]));

    $supService = $db->prepare("DELETE FROM services WHERE services.id = :idService");
    $supService->bindParam(":idService", $idService, PDO::PARAM_INT);

    if ($supService->execute()) {
        header("Location: home_admin.php#administration");
    } else {
        $message = "Erreur de bdd";
    }
}

if (isset($_POST["deleteReview"])) {

    $delete = $_POST["deleteReview"];
    $supReview = $db->prepare("DELETE FROM reviews WHERE id = :id");
    $supReview->bindParam(":id", $delete, PDO::PARAM_INT);

    if ($supReview->execute()) {
        header("Location: home_admin.php#reviewsView");
    } else {
        $message = "Erreur de bdd";
    }
}

if (isset($_POST["deleteWork"])) {

    $delete = $_POST["deleteWork"];
    $supWork = $db->prepare("DELETE FROM photos_cars WHERE id = :id");
    $supWork->bindParam(":id", $delete, PDO::PARAM_INT);

    if ($supWork->execute()) {

        foreach ($photos as $photo) {

            if (!empty($photo["img_before"])) {

                if ($photo["id"] == $delete) {

                    unlink("assets/img/photos/travaux/" . $photo["img_before"]);
                    unlink("assets/img/photos/travaux/" . $photo["img_after"]);
                }
            }
        }

        header("Location: home_admin.php#photosView");
    } else {
        $message = "Erreur de bdd";
    }
}

///////////////////////////////////////UPDATE//////////////////////////////////////////

if (isset($_POST["updateServices"])) {

    $updateService = trim(strip_tags($_POST["updateService"]));
    $updateType = trim(strip_tags($_POST["updateType"]));
    $idUpdateService = trim(strip_tags($_POST["idUpdateService"]));

    $queryUpdate = $db->prepare("UPDATE services
                                SET name = :updateService,
                                service_type = :updateType
                                WHERE id LIKE :idUpdateService");

    $queryUpdate->bindParam(":updateService", $updateService);
    $queryUpdate->bindParam(":updateType", $updateType, PDO::PARAM_INT);
    $queryUpdate->bindParam(":idUpdateService", $idUpdateService, PDO::PARAM_INT);

    if ($queryUpdate->execute()) {

        header("Location: home_admin.php#administration");
    } else {

        $message = "Erreur de bdd";
    }
}

?>

<!-- ////////////////////////////////////////HTML/////////////////////////////////////////////////////////////////////////////////// -->

<div class="backoffice">

    <div class="navAdmin">
        <a href="prices.php">Prix</a>
        <a href="request.php">Demandes</a>
    </div>

    <div class="administration" id="administration">

        <div class="servicesAdmin">

            <h2>Services</h2>

            <div class="services">

                <!-- <h2>Services</h2> -->

                <?php
                foreach ($services as $service) {
                ?>
                    <div class="servicesView">
                        <h3><?= $service["type"] ?></h3>
                        <hr>
                        <div class="listServices">
                            <?= $service["listes"] ?>
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
                        </div>

                        <div class="form-admin-item">

                            <label for="inputService">Nom du service *
                            </label>

                            <input type="text" id="inputService" name="nameService" value="<?= isset($nameService) ? $nameService : "" ?>" />

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
                        </div>

                        <input class="btn-submit" type="submit" name="submitService" value="Ajouter le service" />
                    </div>
                </form>
            </div>
            <div class="modifyServices">
                <form action="" method="post">
                    <div class="form-admin-group">
                        <div class="form-admin-item">
                            <label for="idUpdateService">ID du service à modifier</label>
                            <input type="number" id="idUpdateService" name="idUpdateService" value="<?= isset($idUpdateService) ? $idUpdateService : "" ?>">
                        </div>
                        <div class="form-admin-item">
                            <label for="updateService">Texte du service</label>
                            <input type="text" id="updateService" name="updateService" value="<?= isset($updateService) ? $updateService : "" ?>">
                        </div>
                        <div class="form-admin-item">
                            <label for="updateType">Changer le type</label>
                            <select name="updateType" id="updateType">
                                <option value="1" <?= (isset($updateType) && $updateType === "Intérieur") ? "selected" : "" ?>>Intérieur</option>
                                <option value="2" <?= (isset($updateType) && $updateType === "Extérieur") ? "selected" : "" ?>>Extérieur</option>
                                <option value="3" <?= (isset($updateType) && $updateType === "Options") ? "selected" : "" ?>>Options</option>
                            </select>
                        </div>
                        <input class="btn-submit" name="updateServices" type="submit" value="Mettre à jour le service" />
                    </div>
                </form>
            </div>
            <div class="deleteServices">
                <form action="" method="post">
                    <div class="form-admin-group">

                        <div class="form-admin-item">
                            <label for="idService">Renseignez l'ID à supprimer</label>
                            <input type="text" id="idService" name="idService" value="<?= isset($idService) ? $idService : "" ?>">
                        </div>

                        <input type="submit" class="btn-submit" name="deleteServices" value="Supprimer le service" />

                    </div>
                </form>
            </div>
        </div>


        <div class="reviewsAdmin" id="reviewsView">

            <h2>Avis clients</h2>

            <div class="reviewsContainer">
                <div class="reviewsGrid">
                    <?php
                    foreach ($reviews as $review) {
                    ?>
                        <div class="reviewSelect">

                            <div class="deleteReview">

                                <form action="" method="post">
                                    <button class="btn-delete" name="deleteReview" type="submit" value="<?= $review['id'] ?>">X</button>
                                </form>

                            </div>

                            <div class="reviewClient">
                                <?= $review["id"] . " - " . $review["client"] . " - " . $review["review"] ?>
                            </div>

                        </div>

                    <?php
                    }
                    ?>

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
                        <div class="deleteWork">
                            <form action="" method="post">
                                <button class="btn-delete" name="deleteWork" type="submit" value="<?= $photo['id'] ?>">X
                                </button>
                            </form>
                        </div>
                        <div class="after">

                            <h2>Après</h2>

                            <div class="imgAfter">

                                <img src="assets/img/photos/travaux/<?= $photo["img_after"] ?>" alt="Après nettoyage">

                                <?php
                                if (!empty($photo["txt_after"])) {
                                ?>
                                    <div class="txtAfter">

                                        <p>
                                            <?= $photo["txt_after"] ?>
                                        </p>

                                    </div>
                                <?php
                                }
                                ?>

                            </div>
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
                                <label for="inputImgBefore">Photo avant
                                </label>
                                <input type="file" id="inputImgBefore" name="imgBefore" accept=".png, .jpeg, .jpg, .bmp" />
                            </div>

                        </div>

                        <div class="form-admin-group">

                            <div class="form-admin-item">
                                <label for="inputTxtAfter">Texte 2ème image
                                </label>
                                <input type="text" id="inputTxtAfter" name="txtAfter" value="<?= isset($txtAfter) ? $txtAfter : "" ?>" />
                            </div>

                            <div class="form-admin-item">
                                <label for="inputImgAfter">Photo après
                                </label>
                                <input type="file" id="inputImgAfter" name="imgAfter" accept=".png, .jpeg, .jpg, .bmp" />
                            </div>

                        </div>
                    </div>

                    <input class="btn-submit" type="submit" name="submitPhotosCars" value="Ajouter les photos" />

                </form>
            </div>
        </div>
    </div>
</div>

<?php
include("../templates/footer.php")
?>