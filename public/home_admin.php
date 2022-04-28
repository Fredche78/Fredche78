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
            header("Location: home_admin.php");
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

    // var_dump($photoOld);
    // var_dump($name);
    // var_dump($tmpName);
    // var_dump($size);


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
        $uniqueName = uniqid("", true);
        $uniqueName2 = uniqid("", true);

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
            header("Location: home_admin.php");
        } else {
            $message = "Erreur de bdd";
        }
    }
    // if (empty($errorsWorks)) {

    //     $addWork = $db->prepare("INSERT INTO photos_cars (txt_before, txt_after) VALUES (:txtBefore, :txtAfter)");
    //     $addWork->bindParam(":txtBefore", $txtBefore);
    //     $addWork->bindParam(":txtAfter", $txtAfter);

    //     if ($addWork->execute()) {
    //         header("Location: home_admin.php");
    //     }
    // }
}



// if (isset($_POST["deleteReview"])) {

//     $delete = $_POST["deleteReview"];
//     $query = $db->prepare("DELETE FROM reviews WHERE id= :id");
//     $query->bindParam(":id", $delete);
//     $query->execute();
// }

// if (isset($_GET["id"])) {

//     $delete = $_GET["id"];
//     $query = $db->prepare("DELETE FROM reviews WHERE id= :id");
//     $query->bindParam(":id", $delete);
//     $query->execute();

//     // foreach ($data as $fight) {
//     //     if ($_GET["id"] == $fight["id"]) {
//     //         // Nous avons trouvé l'ID'
//     //         $find = true;
//     //         $fighter = $fight;
//     //     }
//     // }
// }



include("../templates/header.php")
?>

<div class="backoffice">

    <!-- <h2>Administrateur connecté : <?= $_SESSION["user"] . " " . $_SESSION["userName"] ?></h2> -->

    <div class="container">

        <div class="services">

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

        <div class="reviews">

            <h2>Avis clients</h2>

            <?php
            // var_dump( $reviews);
            foreach ($reviews as $data) {
            ?>
                <div class="carousel <?= $data["id"] ?>">
                    <div class="reviewAdmin"><?= $data["client"] . " - " . $data["review"] ?>
                    </div>
                    <div class="btn-delete">
                        <!-- <form action="" method="post"> -->
                        <!-- <input type="submit" class="deleteReview" name="<?= $data['id'] ?>" value="<?= $data['id'] ?>"> -->
                        <button class="deleteReview" name="<?= $data['id'] ?>" value="<?= isset($delete) ? $delete : "" ?>">X</button>
                        <!-- </form> -->
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

            <div class="addReview">

                <form action="" method="post">

                    <div class="form-admin-group">

                        <div class="form-admin-item">

                            <label for="inputNameReview">Nom:</label>
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

                            <label for="inputReview">Avis:</label>
                            <textarea name="clientReview" id="txtReview" cols="120" rows="1" value="<?= isset($clientReview) ? $clientReview : "" ?>"></textarea>

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

    </div>
    <div class="photosVehicules">
        <div class="pictures">
            <?php
            foreach ($photos as $data) {
            ?>
                <div class="picture">
                    <div class="before">
                        <p>Avant</p>
                        <div class="imgBefore">
                            <img src="assets/img/photos/travaux/<?= $data["img_before"] ?>" alt="Avant nettoyage">
                        </div>
                        <div class="txtBefore">
                            <p>
                                <?= $data["txt_before"] ?>
                            </p>
                        </div>
                    </div>
                    <div class="after">
                        <p>Après</p>
                        <div class="imgAfter">
                            <img src="assets/img/photos/travaux/<?= $data["img_after"] ?>" alt="Après nettoyage">
                            <div class="txtAfter">
                                <p>
                                    <?= $data["txt_after"] ?>
                                </p>
                            </div>
                        </div>
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

                <input class="btn-submit" type="submit" name="submitPhotosCars" value="Ajouter le travail" />

            </form>

        </div>
    </div>

</div>

</div>


<?php
include("../templates/footer.php")
?>