<?php


//Connexion à la base d'avis

$dsn = "mysql:host=localhost;dbname=sbpolish;
charset=utf8mb4";
$db = new PDO($dsn, "root", "");

$queryReviews = $db->query("SELECT * FROM reviews");
$reviews = $queryReviews->fetchAll();

$queryPhotos = $db->query("SELECT * FROM photos_cars");
$photos = $queryPhotos->fetchAll();


include("../templates/header.php")
?>

<div class="view">
    <div class="txtView">
        <h2 class="txt one">Nettoyage professionnel de votre véhicule</h2>
        <h2 class="txt two">Particuliers et Professionnels</h2>
        <h2 class="txt three">Prestation à domicile ou dans nos locaux</h2>
    </div>
</div>

<div class="ceo">
    <div class="txtCeo">
        <p>Professionnel du nettoyage et passionné par l'automobile, contactez-moi et nous établirons ensemble un devis gratuit pour votre véhicule.</p>
    </div>
    <div class="pictCeo">
    </div>
</div>

<div class="services">
    <div class="firstServices">
        <h3>Intérieur</h3>
        <hr>
        <ul>
            <li>
                Aspirations textiles et cuirs
            </li>
            <li>
                Aspirations moquettes
            </li>
            <li>
                Traitement des plastiques
            </li>
            <li>
                Pédalier
            </li>
            <li>
                Rails de siège
            </li>
            <li>
                Nettoyage des vitres
            </li>
            <li>
                Rétroviseur intérieur
            </li>
            <li>
                Miroir de courtoisie
            </li>
            <li>
                Affichages et compteurs
            </li>
            <li>
                Désodorisation
            </li>
            <li>
                Ciel de toit
            </li>
            <li>
                Sièges & banquette
            </li>
        </ul>
    </div>
    <div class="secondServices">
        <h3>Extérieur</h3>
        <hr>
        <ul>
            <li>
                Carrosserie
            </li>
            <li>
                Optiques
            </li>
            <li>
                Seuil de coffre
            </li>
            <li>
                Seuils de portes
            </li>
            <li>
                Rétroviseurs
            </li>
            <li>
                Trappe à essence
            </li>
            <li>
                Jantes, étriers
            </li>
            <li>
                Baie de pare brise
            </li>
            <li>
                Soubassement
            </li>
            <li>
                Passage de roues
            </li>
        </ul>
    </div>
    <div class="thirdServices">
        <h3>Options et services annexes</h3>
        <hr>
        <ul>
            <li>
                Soin du cuir
            </li>
            <li>
                Soin plafonnier
            </li>
            <li>
                Cire de protection
            </li>
            <li>
                Traitement céramique
            </li>
            <li>
                Nettoyage moteur
            </li>
            <li>
                Traitement Hydrophobe des vitres
            </li>
        </ul>
    </div>
</div>


<div class="prices">
    <a href="prices.php">
        <p>Détails de nos tarifs et de nos prestations</p>
        <div class="selections">
            <div class="citadine">

            </div>
        </div>
        <p>Votre tarif sur-mesure</p>
    </a>
</div>


<div class="reviews">

    <h2>Les avis de nos clients</h2>

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
        < </div>
            <div id="suivant" onclick="ChangeSlide(1)"> >
            </div>

    </div>
</div>

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



<div class="infosSociety">
    <div class="society">
        <p id="nameSociety">S.B Polish</p>
        <p id="addressSociety">91 Rue Henry Durre<br />59174 La Sentinelle</p>
        <p id="phoneSociety">Tel: 06.62.49.20.49</p>
        <p id="openingSociety">Horaires: lundi au vendredi de 9h - 18h<br />Samedi 9h - 12h sur demande</p>
    </div>
    <div class="map">
        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d10184.254916045364!2d3.4853949946899414!3d50.34671671927941!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c2ec4549a81cdd%3A0x37c41f301b0a3967!2s91%20Rue%20Henri%20Durre%2C%2059174%20La%20Sentinelle!5e0!3m2!1sfr!2sfr!4v1650474732181!5m2!1sfr!2sfr" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
    <!-- <div class="question">
                <p id="questionSociety">Vous avez des questions ? N'hésitez pas à nous contacter.</p>
            </div> -->
</div>

<?php
include("../templates/footer.php")
?>