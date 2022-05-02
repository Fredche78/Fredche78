<?php

$db = new PDO("mysql:host=localhost;dbname=sbpolish", "root", "");

$queryReviews = $db->query("SELECT * FROM reviews
                            ORDER BY id DESC");
$reviews = $queryReviews->fetchAll();

$queryPhotos = $db->query("SELECT * FROM photos_cars
                            ORDER BY id DESC");
$photos = $queryPhotos->fetchAll();

$queryServices = $db->query("SELECT 
type_services.type AS 'colonnes', 
GROUP_CONCAT(services.name SEPARATOR '<br>') AS 'services' 
FROM type_services
INNER JOIN type_services_link
ON type_services.id = type_services_link.type_services_id
INNER JOIN services
ON type_services_link.services_id = services.id
GROUP BY type_services.type;");
$services = $queryServices->fetchAll();

if (!empty($_POST['submitService'])) {

    $nameService = trim(strip_tags($_POST["nameService"]));
    $columnService = trim(strip_tags($_POST["columnService"]));

    // $errorsServices = [];

    // if (empty($addNameService)) {
    //     $errorsServices["addNameService"] = " Le service doit être complété ";
    // }

    // if (empty($clientReview)) {
    //     $errorsReviews["clientReview"] = " Le message de l'avis est obligatoire ";
    // }

    // if (empty($errorsServices)) {

    // $queryServices = $db->query("SELECT type_services.type AS 'colonnes', 
    // GROUP_CONCAT(services.name SEPARATOR '<br>') AS 'services' 
    // FROM type_services
    // INNER JOIN type_services_link
    // ON type_services.id = type_services_link.type_services_id
    // INNER JOIN services
    // ON type_services_link.services_id = services.id
    // GROUP BY type_services.type;");
    // $services = $queryServices->fetchAll();

    // $addService = $db->prepare("INSERT INTO services (name)
    // SELECT type_services.id FROM type_services
    // INNER JOIN type_services_link ON services.id = type_services.id
    // ");

    $addService = $db->prepare("INSERT INTO services (name)
                                        VALUES (:nameService)

                                        -- SELECT type_services.id 
                                        -- FROM type_services
                                        -- INNER JOIN type_services_link
                                        -- ON services.id = type_services.id
                                        -- SELECT id FROM type_services WHERE id=:columnService



                                    -- INSERT INTO type_services_link (services_id, type_services_id)
                                    -- VALUES (mysql_insert_id(services.id), :columnService)



                                    
                                    -- (SELECT id fROM services WHERE services.id=services_id)),
                                    -- (:columnService, (SELECT id FROM type_services WHERE type_services.id = type_services_id))
                                    
                                    -- WHERE type_services_link.services_id = services.id AND type_services_link.type_services_id = type_services.id
                                    ");
    $addService->bindParam("nameService", $nameService);
    $addService->bindParam(":columnService", $columnService);



    if ($addService->execute()) {
        header("Location: home_admin.php");
        // var_dump($nameService);
        // var_dump($columnService);
    }
    // }
}

if (!empty($_POST['submitReview'])) {

    $nameReview = trim(strip_tags($_POST["nameReview"]));
    $clientReview = trim(strip_tags($_POST["clientReview"]));

    $errorsReviews = [];

    if (empty($nameReview)) {
        $errorsReviews["nameReview"] = " Le nom ou pseudo du client est obligatoire ";
        // var_dump($errorsReviews);
    }

    if (empty($clientReview)) {
        $errorsReviews["clientReview"] = " Le message de l'avis est obligatoire ";
    }

    if (empty($errorsReviews)) {

        $addReview = $db->prepare("INSERT INTO reviews (client, review) VALUES (:nameReview, :clientReview)");
        $addReview->bindParam(":nameReview", $nameReview);
        $addReview->bindParam(":clientReview", $clientReview);

        if ($addReview->execute()) {
            header("Location: home_admin.php#reviewsView");
            // var_dump($imgBefore);
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

    $uploadPath = "assets/img/photos/travaux/" . $name; // . $photo fonctionne aussi
    $uploadPath2 = "assets/img/photos/travaux/" . $name2; // . $photo fonctionne aussi

    $errorsWorks = [];
    $errorsFiles = $_FILES["imgAfter"]["error"];

    $tabExtension = explode(".", $name);
    $extension = strtolower(end($tabExtension));
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

    if (in_array($extension, $allowedTypes) && $size <= $maxSize && $errorsFiles == 0) {
        // $uniqueName = uniqid("", true);
        // $uniqueName2 = uniqid("", true);
        $uniqueName = md5($name);
        $uniqueName2 = md5($name2);

        $imgBefore = $uniqueName . "." . $extension;
        $imgAfter = $uniqueName2 . "." . $extension;

        move_uploaded_file($tmpName, $uploadPath);
        move_uploaded_file($tmpName2, $uploadPath2);

        rename("assets/img/photos/travaux/$photoOld", "assets/img/photos/travaux/$imgBefore");
        rename("assets/img/photos/travaux/$photoOld2", "assets/img/photos/travaux/$imgAfter");

        // var_dump($imgBefore);

        echo "Image enregistrée";
    } else {
        echo "Une erreur est survenue";

        if ($maxSize <= $size) {
            echo "Fichier trop volumineux";
        }
    }

    if (empty($errorsWorks) && empty($errorsFiles)) {

        $addWork = $db->prepare("INSERT INTO photos_cars (txt_before, img_before, txt_after, img_after) VALUES (:txtBefore, :imgBefore, :txtAfter, :imgAfter)");
        $addWork->bindParam(":txtBefore", $txtBefore);
        $addWork->bindParam(":imgBefore", $imgBefore);
        $addWork->bindParam(":txtAfter", $txtAfter);
        $addWork->bindParam(":imgAfter", $imgAfter);

        if ($addWork->execute()) {
            header("Location: home_admin.php#photosView");
            // var_dump($imgBefore);
        } else {
            $message = "Erreur de bdd";
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
    // unlink("assets/img/photos/travaux/" . $imgBefore);
    // unlink("assets/img/photos/travaux/" . $imgAfter);
    // unlink($imgBefore);
    // unlink($imgAfter);

    if ($supWork->execute()) {
        header("Location: home_admin.php#photosView");
    } else {
        $message = "Erreur de bdd";
    }
}

include("../templates/header.php")
?>

<div class="backoffice">

    <!-- <h2>Administrateur connecté : <?= $_SESSION["user"] . " " . $_SESSION["userName"] ?></h2> -->

    <div class="nav">
        <a href="prices.php">Prix</a>
        <a href="request.php">Demandes</a>
    </div>

    <div class="container">

        <div class="servicesAdmin">

            <h2>Services</h2>

            <div class="services">

                <!-- <h2>Services</h2> -->

                <?php
                foreach ($services as $service) {
                ?>
                    <div class="service">
                        <h3><?= $service["colonnes"] ?></h3>
                        <hr>
                        <div class="listServices">
                            <?= $service["services"] ?>
                            <!-- <?= $serviceList ?> -->
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

                            <!-- <div class="errors">
                            <?php
                            if (isset($errorsReviews["clientReview"])) {
                            ?>
                            <p><span class="info-error"><?= $errorsReviews["clientReview"] ?></span></p>
                            <?php
                            }
                            ?>
                            </div> -->
                        </div>

                        <div class="form-admin-item">

                            <label for="inputService">Nom du service *</label>
                            <input type="text" id="inputService" name="nameService" value="<?= isset($nameService) ? $nameService : "" ?>">

                            <!-- <div class="errors">
                            <?php
                            if (isset($errorsServices["nameServices"])) {
                            ?>
                            <p><span class="info-error"><?= $errorsServices["nameServices"] ?></span></p>
                            <?php
                            }
                            ?>
                            </div> -->
                        </div>

                        <input class="btn-submit" type="submit" name="submitService" value="Ajouter le service" />
                    </div>
                </form>
            </div>
        </div>



        <div class="reviewsAdmin" id="reviewsView">

            <h2>Avis clients</h2>

            <div class="viewReviews">

                <?php
                foreach ($reviews as $data) {
                ?>
                    <div class="carousel">
                        <div class="reviewAdmin"><?= $data["client"] . " - " . $data["review"] ?>
                        </div>
                        <div class="deleteReview">

                            <form action="" method="post">
                                <button class="btn-delete" name="deleteReview" type="submit" value="<?= $data['id'] ?>">X</button>
                            </form>
                        </div>
                    </div>
                    <!-- <div class="precedent" onclick="ChangeSlide(-1)">
                    <span>
                        <<<<<< </span>
                </div>
                <div class="suivant" onclick="ChangeSlide(1)">
                    <span>
                        >>>>>>
                        <span>
                </div> -->
                <?php
                }
                ?>
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
                                    <p><span class="info-error"><?= $errorsReviews["nameReview"] ?></span></p>
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
                                    <p><span class="info-error"><?= $errorsReviews["clientReview"] ?></span></p>
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
                foreach ($photos as $data) {
                ?>
                    <div class="picture">

                        <div class="before">

                            <p>Avant</p>

                            <div class="imgBefore">

                                <img src="assets/img/photos/travaux/<?= $data["img_before"] ?>" alt="Avant nettoyage">

                                <?php
                                if (!empty($data["txt_before"])) {
                                ?>
                                    <div class="txtBefore">

                                        <p>
                                            <?= $data["txt_before"] ?>
                                        </p>

                                    </div>
                                <?php
                                }
                                ?>

                            </div>

                        </div>
                        <div class="after">

                            <p>Après</p>

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
                                <button class="btn-delete" name="deleteWork" type="submit" value="<?= $data['id'] ?>">X</button>
                            </form>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
            <div class="addWorks">

                <form action="" method="post" enctype="multipart/form-data">

                    <div class="form-admin-group">

                        <div class="form-admin-item">
                            <label for="inputTxtBefore">Texte 1ère image</label>
                            <input type="text" id="inputTxtBefore" name="txtBefore" value="<?= isset($txtBefore) ? $txtBefore : "" ?>">
                        </div>

                        <div class="form-admin-item">
                            <label for="inputImgBefore">Photo avant</label>
                            <input type="file" id="inputImgBefore" name="imgBefore" accept=".png, .jepg, .jpg, .bmp" value="<?= isset($imgBefore) ? $imgBefore : "" ?>">
                        </div>

                    </div>

                    <div class="form-admin-group">

                        <div class="form-admin-item">
                            <label for="inputTxtAfter">Texte 2ème image</label>
                            <input type="text" id="inputTxtAfter" name="txtAfter" value="<?= isset($txtAfter) ? $txtAfter : "" ?>">
                        </div>

                        <div class="form-admin-item">
                            <label for="inputImgAfter">Photo après</label>
                            <input type="file" id="inputImgAfter" name="imgAfter" accept=".png, .jepg, .jpg, .bmp" value="<?= isset($imgAfter) ? $imgAfter : "" ?>">
                        </div>

                    </div>

                    <input class="btn-submit" type="submit" name="submitPhotosCars" value="Ajouter le Avant / Après" />

                </form>
            </div>
        </div>
    </div>
</div>


<?php
include("../templates/footer.php")
?>