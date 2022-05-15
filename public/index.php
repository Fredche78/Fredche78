<?php
session_start();
$page="Bienvenue sur le site SB Polish";
include("../templates/header.php");
require_once '../system/config.php';
//Connexion à la base d'avis

// $dsn = "mysql:host=localhost;dbname=sbpolish;
// charset=utf8mb4";
// $db = new PDO($dsn, "root", "");

$queryReviews = $db->query("SELECT * FROM reviews ORDER BY id DESC");
$reviews = $queryReviews->fetchAll();

$queryPhotos = $db->query("SELECT * FROM photos_cars ORDER BY id DESC");
$photos = $queryPhotos->fetchAll();

// $queryServices = $db->query("SELECT 
// type_services.type AS 'colonnes', 
// GROUP_CONCAT(services.name SEPARATOR '<br>') AS 'services' 
// FROM type_services
// INNER JOIN type_services_link
// ON type_services.id = type_services_link.type_services_id
// INNER JOIN services
// ON type_services_link.services_id = services.id
// GROUP BY type_services.type;");
// $services = $queryServices->fetchAll();

$queryServices = $db->query("SELECT type_services.type AS 'type', GROUP_CONCAT(services.name ORDER BY services.id SEPARATOR '<BR>') AS 'listes' FROM type_services INNER JOIN services ON type_services.id = services.service_type GROUP BY type_services.type ORDER BY type_services.id ASC");
$services = $queryServices->fetchAll(PDO::FETCH_ASSOC);

// var_dump($services);

// $serviceList = 0;
// var_dump($services);
// $i=0;
// foreach ($services as $service) {
//     $i++;
//     $servicesList = $servicesList ."". $i;
//     $servicesList = explode(",", $services["services"]);
// }

// $servicesList1 = $services[0];
// $servicesList2 = $services[1];
// $servicesList3 = $services[2];
// var_dump($services[0]);
// $servicesList1 = $services[0];
// $servicesList1 = explode(",", $servicesList1);
// $servicesList2 = explode(",", $services[1]);
// $servicesList3 = explode(",", $services[2]);
// foreach ($services as $services) {
//     // foreach ($services as $service) {
//     //     $servicesList = explode(",", $service);
//     // }

//     // $i++;
//     $servicesList[$i] = explode(",", $services["services"]);
// }
// var_dump($servicesList);
// var_dump($servicesList1);

// var_dump($servicesList[1]);
// var_dump($servicesList[2]);
// var_dump($servicesList[3]);
// var_dump($servicesList);
// var_dump($services);
// $servicesList2 = explode(",", $services["services"][0]);
// var_dump($servicesList2);
// var_dump($services[0]);

?>

<div class="view">

    <div class="txtView">

        <h2 class="txtHome">Nettoyage professionnel de votre véhicule</h2>

        <h2 class="txtHome">Particuliers et Professionnels</h2>

        <h2 class="txtHome">Prestation à domicile ou dans nos locaux</h2>

    </div>

</div>

<div class="ceo">

    <div class="txtCeo">

        <p>Professionnel du nettoyage et passionné par l'automobile, contactez-moi et nous établirons ensemble un devis gratuit pour votre véhicule.</p>

    </div>

    <div class="pictCeo">

    </div>

</div>

<a href="contact.php" Class="contacts">
    <div class="contact">
        <p>
            Votre tarif sur mesure : <span>Cliquez ici</span>
        </p>
    </div>
</a>

<!-- Affichage des avis -->

<div class="reviews">

    <h2>Les avis de nos clients</h2>

    <div class="slideReviews">
        <div class="splide" id="splideReviews" role="group" aria-label="Splide Basic HTML Example">
            <div class="splide__track">
                <div class="splide__list">
                    <?php
                    foreach ($reviews as $review) {
                    ?>
                        <div class="splide__slide">
                            <?= $review["client"] . " - " . $review["review"] ?>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="services">

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

<a href="prices.php" Class="prices">
    <div class="price">
        <p>Détails de nos tarifs et de nos prestations</p>
    </div>
</a>

<div class="pictures">

    <div class="slidePictures">
        <div class="splide" id="splidePictures" role="group" aria-label="Splide Basic HTML Example">
            <div class="splide__track">
                <h2>Nos interventions</h2>
                <div class="splide__list">

                    <?php
                    foreach ($photos as $photo) {
                    ?>
                        <div class="splide__slide">

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
                        </div>
                    <?php
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="infosSociety">

    <div class="society">

        <p id="nameSociety">S.B Polish</p>
        <p id="addressSociety">91 Rue Henry Durre<br />59174 La Sentinelle</p>
        <p id="phoneSociety">Tel: 06.62.49.20.49</p>
        <p id="emailSociety">sbpolish@outlook.fr</p>
        <p id="openingSociety">Horaires: lundi au vendredi de 9h - 18h<br />Samedi 9h - 12h sur demande</p>
        <p id="openingQuestion"><a href="contact.php">Une question ? Cliquez-ici</a></p>

    </div>

    <div class="map">
        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d10184.254916045364!2d3.4853949946899414!3d50.34671671927941!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c2ec4549a81cdd%3A0x37c41f301b0a3967!2s91%20Rue%20Henri%20Durre%2C%2059174%20La%20Sentinelle!5e0!3m2!1sfr!2sfr!4v1650474732181!5m2!1sfr!2sfr" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    </div>

</div>

<?php
include("../templates/footer.php")
?>