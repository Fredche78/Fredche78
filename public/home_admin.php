<?php

$dsn = "mysql:host=localhost;dbname=sbpolish;
charset=utf8mb4";
$db = new PDO($dsn, "root", "");

$queryReviews = $db->query("SELECT * FROM reviews");
$reviews = $queryReviews->fetchAll();

$queryPhotos = $db->query("SELECT * FROM photos_cars");
$photos = $queryPhotos->fetchAll();

include("../templates/header.php")
?>

<div class="backoffice">

    <h2>Administrateur connecté : <?= $_SESSION["user"] . " " . $_SESSION["userName"] ?></h2>

    <div class="container">

        <div class="ceo">

        </div>
        <div class="services">

        </div>
        <div class="reviews">

            <h2>Avis clients</h2>

            <?php

            foreach ($reviews as $data) {
            ?>
                <div class="carousel <?= $data["id"] ?>">
                    <p><?= $data["client"] . " - " . $data["review"] ?></p>
                </div>
            <?php
            }
            ?>
            <div id="precedent" onclick="ChangeSlide(-1)">
                <<<<<<< < /div>
                    <div id="suivant" onclick="ChangeSlide(1)"> >>>>>> </div>
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
                                <img src="assets/img/photos/<?= $data["img_before"] ?>" alt="Avant nettoyage">
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
                                <img src="assets/img/photos/<?= $data["img_after"] ?>" alt="Après nettoyage">
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
        </div>

    </div>

</div>


<?php
include("../templates/footer.php")
?>