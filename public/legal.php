<?php

$page = ($_GET["page"]);

include("../templates/header.php")
?>

<div class="legalRules">

    <?php
    if ($page === "mentions") {
    ?>

        <div class="mentions">

            <p>Entreprise: SB POLISH</p>
            <p>Responsable légal: Sébastien BROUILLARD</p>
            <p>Statuts : Auto-Entreprise</p>
            <p>Siret: 80260641800035</p>
            <p>Adresse: 91 Rue Henri Durre</p>
            <p>59174 La sentinelle</p>

            <div class="develop">
            Ce site a été réalisé par <a href="https://www.linkedin.com/in/frederic-chenneviere/" target="_blank">Frédéric Chennevière</a>
        </div>

        </div>

    <?php
    }

    if ($page === "cookies") {
    ?>

        <div class="cookies">
            <p>
                Le site SB Polish recueille uniquement des cookies nécessaires au bon fonctionnement du site
            </p>
        </div>

    <?php
    }

    if ($page === "protect") {
    ?>

        <div class="protect">
            <p>
                Toutes les informations que vous nous communiquez restent confidentielles et ne sont en aucun cas transmises à des sites ou entreprises tierces.
            </p>
        </div>

    <?php
    }
    ?>

</div>

<?php
include("../templates/footer.php")
?>