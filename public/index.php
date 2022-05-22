<?php
// session_start();
$page = "Bienvenue sur le site SB Polish";
$sessioncheck = "true";

include("../templates/header.php");
require_once("../system/config.php");
//Connexion à la base d'avis

$queryReviews = $db->query("SELECT * FROM reviews ORDER BY id DESC");
$reviews = $queryReviews->fetchAll();

$queryPhotos = $db->query("SELECT * FROM photos_cars ORDER BY id DESC");
$photos = $queryPhotos->fetchAll();

$queryServices = $db->query("SELECT type_services.type AS 'type', GROUP_CONCAT(services.name ORDER BY services.id SEPARATOR '<BR>') AS 'listes' FROM type_services INNER JOIN services ON type_services.id = services.service_type GROUP BY type_services.type ORDER BY type_services.id ASC");
$services = $queryServices->fetchAll(PDO::FETCH_ASSOC);

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

        <p>Professionnel du nettoyage et passionné par l'automobile, j'ai créé S.B Polish en 2014. Contactez-moi et nous établirons ensemble un devis gratuit pour votre véhicule.</p>

    </div>

    <div class="pictCeo">

    </div>

</div>

<!-- JavaScript pour le lien -->
<div class="contacts" id="contactsLink">
    <p>
        Votre tarif sur mesure : <br> <span>Cliquez ici</span>
    </p>
</div>

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
    <div class="controlReviews">
        <a href="legal.php?page=reviews">En savoir plus</a>
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

<!-- JavaScript pour le lien -->
<div class="price" id="pricesLink">
    <p>Détails de nos tarifs et de nos prestations</p>
</div>

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
        <iframe title="Google Map" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2545.990311753979!2d3.485738815694014!3d50.34808607946137!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c2ec4549a81cdd%3A0x37c41f301b0a3967!2s91%20Rue%20Henri%20Durre%2C%2059174%20La%20Sentinelle!5e0!3m2!1sfr!2sfr!4v1653122774063!5m2!1sfr!2sfr" style="border:3;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>

</div>
<script src="../node_modules/@splidejs/splide/dist/js/splide.min.js"></script>
<script src="js/carousel.js"></script>
<script src="js/link.js"></script>
<?php
include("../templates/footer.php")
?>